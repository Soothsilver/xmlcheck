<?php

namespace asm\core;
use asm\core\lang\Language;
use asm\core\lang\StringID;
use asm\utils\Filesystem, asm\utils\Validator;

/**
 * Handler of core requests from UI.
 *
 * Request handlers are used by calling their run() method and their main handling
 * logic should be contained in their implementation of body() method. In case of
 * error, body() should set error using one of stop methods and return false.
 *
 * Calling request handler should be the final action of request handling script,
 * as the handler manages output as well.
 *
 * Methods tagged as [stopping] call appropriate stop method in case of error,
 * therefore no additional stop() calls should be made in case they fail (return false).
 */
abstract class UiScript
{
    private $errors = array();    ///< (array) script errors
    private $failed = false;    ///< (bool) true if script failed to finish successfully
    private $params = array();    ///< (array) script arguments (associative)

    /**
     * Runs the request handler with supplied arguments.
     *
     * Handler is initialized first using init() override and in case of no errors,
     * body() override is run. After it finishes (whether successfully or not), errors are
     * logged and output is sent using output() override.
     * @param array $params associative array of script arguments
     * @param array $files associative array with info about files uploaded with request
     * @see init()
     * @see body()
     * @see output()
     */
    public final function run(array $params = array(), array $files = array())
    {
        $this->init($params, $files);

        if (!$this->isFailed())
        {
            $this->body();
        }

        $this->logErrors();
        $this->output();
    }

    /**
     * Convenience method for adding error and stopping script execution at the same time.
     *
     * Typical use in script body:
     * @code
     * if (($error = foo()) !== false)
     *        return $this->stop($error);
     * @endcode
     * @param mixed  $cause code of error cause (int) or cause message (string) if it doesn't have own code
     * @param string $effect error effect
     * @param string $details additional error info
     * @return bool false
     * @see addError()
     * @see stopDb()
     * @see stopRm()
     */
    protected final function stop($cause = null, $effect = null, $details = null)
    {
        $this->addError(Error::levelError, $cause, $effect, $details);
        return false;
    }

    protected final function death($stringID)
    {
        $this->addError(Error::levelError, Language::get($stringID));
        return false;
    }

    /**
     * Extension of stop() for errors caused by failed request to database.
     *
     * Typical use in script body:
     * @code
     * if (empty($result = Core::sendDbRequest('foo')))
     *        return $this->stopDb($result);
     * @endcode
     * @param mixed  $result database request result (array or bool)
     * @param string $effect error effect
     * @param string $details additional error info
     * @return bool false
     * @see stop()
     */
    protected final function stopDb($result = false, $effect = null, $details = null)
    {
        if (!is_array($result) && !is_bool($result))
        {
            return $this->stop($result, $effect, $details);
        }

        list($cause, $dbDetails) = $this->getDbStopInfo($result);
        $details = $this->joinDetails($dbDetails, $details);

        return $this->stop($cause, $effect, $details);
    }

    /**
     * Turns database request result into array containing error cause and details.
     * @param mixed $result database request result (array or bool)
     * @return array error info {cause, details}
     * @see stopDb()
     */
    protected final function getDbStopInfo($result = false)
    {
        $cause = null;
        $details = null;
        if ($result === false)
        {
            $cause = ErrorCode::dbRequest;
            $details = Core::sendDbRequest(null);
        }
        elseif (is_array($result) && empty($result))
        {
            $cause = ErrorCode::dbEmptyResult;
        }
        return array($cause, $details);
    }

    /**
     * Extension of stop() for errors caused by failure of one of RemovalManager removal methods.
     * @param mixed  $removalManagerError either simple error cause (code or message)
     *        or array with database request result and error message {result, message}
     * @param string $effect error effect
     * @param string $details additional error info
     * @return bool false
     * @see stop()
     */
    protected final function stopRm($removalManagerError, $effect = null, $details = null)
    {
        if (!is_array($removalManagerError))
        {
            return $this->stop($removalManagerError, $effect, $details);
        }

        list($result, $rmDetails) = $removalManagerError;
        $details = $this->joinDetails($rmDetails, $details);

        return $this->stopDb($result, $effect, $details);
    }

    /**
     * Joins two error details strings together with a newline in between.
     * @param string $details1 error details
     * @param string $details2 error details
     * @return string joined error details
     */
    protected final function joinDetails($details1, $details2)
    {
        $details = array();
        if ($details1)
        {
            array_push($details, $details1);
        }
        if ($details2)
        {
            array_push($details, $details2);
        }
        return implode("\n", $details);
    }

    /**
     * Sets request handler arguments to be accessible by getParams().
     * @param array $params associative array of script arguments
     * @see getParams()
     */
    protected function setParams($params)
    {
        $this->params = $params;
    }

    protected function paramExists($paramName){
        return array_key_exists($paramName, $this->params);
    }

	/**
	 * Gets script argument with supplied key or all arguments.
	 * @param mixed $key argument key (string), array with argument keys, or null
	 *		to get all arguments
	 * @return mixed argument value if single key is supplied, otherwise associative
	 *		array with arguments (either all or with selected keys only)
	 * @see setParams()
	 */
	protected final function getParams ($key = null)
	{
		if ($key === null)
		{
			return $this->params;
		}
		elseif (!is_array($key))
		{
			return (isset($this->params[$key]) ? $this->params[$key] : null);
		}
		else
		{
			$ret = array();
			foreach ($key as $k)
			{
				$ret[$k] = $this->getParams($k);
			}
			return $ret;
		}
	}

	/**
	 *	[stopping]
	 * @param string $id file ID
	 * @return mixed file info (array) or false in case of error
	 */
	private function getUploadedFileInfo ($id)
	{
		$fileInfo = UploadManager::instance()->retrieve($id);

		if ($fileInfo === UploadManager::fileNotFound)
			return $this->stop('file has been lost', 'cannot retrieve uploaded file');

		if ($fileInfo === UploadManager::idNotSet)
		{
			if (!isset($_FILES[$id]) || ($_FILES[$id]['error'] != UPLOAD_ERR_OK)
					|| (!is_uploaded_file($_FILES[$id]['tmp_name'])))
			{
				return $this->stop(ErrorCode::upload, 'cannot retrieve uploaded file');
			}

			$file = $_FILES[$id];
			return array(
				'name' => $file['name'],
				'type' => $file['type'],
				'path' => $file['tmp_name'],
			);
		}
		return $fileInfo;
	}

	/**
	 * Gets path to pre-uploaded file with supplied ID [stopping].
	 * @param string $id file ID
	 * @return mixed file path (string) or false in case of error
	 * @see saveUploadedFile()
	 * @see UploadManager
	 */
	protected final function getUploadedFile ($id)
	{
		if (!($fileInfo = $this->getUploadedFileInfo($id)))
			return false;

		return $fileInfo['path'];
	}

	protected final function getUploadedFileName ($id)
	{
		if (!($fileInfo = $this->getUploadedFileInfo($id)))
			return false;

		return $fileInfo['name'];
	}

	/**
	 * Save pre-uploaded file to permanent storage [stopping].
	 * @param string $id file ID
	 * @param string $destination destination to which the file is to be moved
	 * @return bool success
	 * @see getUploadedFile()
	 * @see UploadManager
	 */
	protected final function saveUploadedFile ($id, $destination)
	{
		$src = $this->getUploadedFile($id);
		if (!$src)
			return false;

		if (!rename($src, Filesystem::realPath($destination)))
			return $this->stop(Language::get(StringID::UploadUnsuccessful));

		return true;
	}

	/**
	 * Stores error (warning, notice) to be appended to script output.
	 *
	 * Sets @ref $failed flag to true if error is level is Error::levelError or higher.
	 * @param int $level error severity (@ref Error "Error::level*" constant)
	 * @param mixed $cause error cause code (int) or message (string)
	 * @param string $effect error effect
	 * @param string $details additional error info
	 * @see getErrors()
	 * @see clearErrors()
	 */
	protected final function addError ($level, $cause, $effect = null, $details = null)
	{
		$this->errors[] = Error::create($level, $cause, $effect, $details);
		if ($level >= Error::levelError)
		{
			$this->failed = true;
		}
	}

	/**
	 * Gets stored errors.
	 * @return array errors (Error instances)
	 * @see addError()
	 * @see clearErrors()
	 * @see isFailed()
	 */
	protected final function getErrors ()
	{
		return $this->errors;
	}

	/**
	 * Checks whether this handler is flagged as failed.
	 * @return bool true if handler is failed
	 */
	protected final function isFailed ()
	{
		return $this->failed;
	}

	/**
	 * Clears all stored errors and unsets @ref $failed flag.
	 * @return bool true if the handler was flagged as failed
	 * @see addError()
	 * @see getErrors()
	 * @see isFailed()
	 */
	protected final function clearErrors ()
	{
		$failed = $this->isFailed();
		$this->errors = array();
		$this->failed = false;
		return $failed;
	}

	/**
	 * Logs all errors added during handler execution to system log.
	 * @return UiScript self
	 * @see Core::logError()
	 */
	private function logErrors ()
	{
		foreach ($this->errors as $error)
		{
			Core::logError($error);
		}
		return $this;
	}

	/**
	 * Outputs supplied data along with stored errors to UI.
	 * @param array $data data to output
	 */
	protected final function outputData ($data = array())
	{
		Core::sendUiResponse(UiResponse::create($data, $this->getErrors()));
	}

	/**
	 * Checks whether required handler arguments are set [stopping].
	 * @param mixed $args array with argument keys or single argument key string
	 * @param string [...] argument keys can be specified as method arguments
	 * @return bool true if arguments for all supplied keys are set
	 * @see isInputValid()
	 */
	protected final function isInputSet ($args)
	{
		if (is_string($args)) {
			$args = (func_num_args() > 1) ? func_get_args() : array($args);
		}

		$missingArgs = array();
		foreach ($args as $arg)
		{
			if (!isset($this->params[$arg]))
			{
				$missingArgs[] = $arg;
			}
		}

		if (!empty($missingArgs))
		{
			return $this->stop(ErrorCode::inputIncomplete, null,
					'Missing input fields: ' . implode(', ', $missingArgs) . '.');
		}
		return true;
	}

	/**
	 * Checks whether required handler arguments are set and fit supplied constraints [stopping].
	 * @param array $fields associative array of fields and their validation filters
	 *	@code
	 *	array(
	 *		'<argument name>' => array(\<FILTER\>, ...),
	 *		[...]
	 *	)
	 *	@endcode
	 *	where \<FILTER\> is either filter name string (must be accepted by Validator::validate()
	 * as second argument) or array key-value pair with filter name as key and
	 * filter options array as value, e.g.:
	 *	@code
	 *	array(
	 *		'id' => array('isId'),
	 *		'name' => array(
	 * 		'isAlphaNumeric',
	 * 		'hasLength' => array(
	 * 			'min_length' => 5,
	 * 			'max_length' => 15,
	 * 		),
	 *		),
	 *	)
	 *	@endcode
	 * @return bool true if arguments for all supplied keys are set and valid to supplied constraints
	 * @see isInputSet()
	 * @see Validator
	 */
	protected final function isInputValid ($fields)
	{
		if (!$this->isInputSet(array_keys($fields)))
			return false;

		foreach ($fields as $name => $filters)
		{
			if ($filters === null)
			{
				continue;
			}
			if (!is_array($filters))
			{
				$filters = array($filters => array());
			}
			foreach ($filters as $filter => $options)
			{
				if (is_int($filter))
				{
					$filter = $options;
					$options = array();
				}
				$details = Validator::validate($this->getParams($name), $filter, $options);
				if ($details)
				{
					if ($details === true)
					{
						return $this->stop(ErrorCode::inputInvalid, null, "key: '$name'");
					}
					else
					{
						return $this->stop(ErrorCause::invalidInput($details, $name));
					}
				}
			}
		}
		return true;
	}

	/**
	 * Checks whether user has at least one the given sets of privileges [stopping].
	 * @param int $privileges sets of privileges to check against
	 * @return bool true if he has
	 * @see User::hasPrivileges()
	 */
	protected final function userHasPrivileges (...$privileges)
	{
        if (!User::instance()->isSessionValid($reason))
        {
            return $this->stop(Language::get(StringID::SessionInvalidated));
        }
		if (!User::instance()->hasPrivileges(...$privileges))
		// TODO remove this: if (!call_user_func_array(array(User::instance(), 'hasPrivileges'), func_get_args()))
		{
            return $this->stop(Language::get(StringID::InsufficientPrivileges));
		}
		return true;
	}

	/**
	 * Initializes handler with supplied arguments.
	 *
	 * Should be overridden and finalized in abstract descendants, not in final handlers.
	 * Script body() is executed only if this method doesn't stop().
	 * @param array $params associative array of script arguments supplied to run() on handler execution
	 * @param array $files associative array with info about files uploaded with request supplied to run() on handler execution
	 */
	protected abstract function init (array $params = array(), array $files = array());

	/**
	 * Contains main handling logic specific to each handler.
	 *
	 * Should be overridden in final handler classes.
	 */
	protected abstract function body ();

	/**
	 * Outputs appropriately formatted response to UI.
	 *
	 * Should be overridden and finalized in abstract descendants, not in final handlers.
	 */
	protected abstract function output ();
}

