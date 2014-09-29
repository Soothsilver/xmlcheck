<?php

namespace asm\core;
use asm\db\Database,
	asm\plugin\PluginResponse,
	asm\utils\ShellUtils,
	asm\utils\StringUtils,
	asm\utils\Logger,
	Exception;

/**
 * Core functions (communications between components, error logging) @module.
 */
class Core
{
	protected static $mailer;	///< mailer instance
	protected static $logger;	///< logger instance
	protected static $request = null;	///< name of UI request being handled

	/**
	 * Sends request to database or returns last error.
	 * @param string $requestId request
	 * @param mixed [...] request arguments
	 * @return mixed associative array with data or false in case of get request, boolean
	 * in case of other requests, string with last error in case supplied \$requestId
	 * is null
	 */
	public static function sendDbRequest ($requestId)
	{
		if ($requestId === null)
		{
			return Database::getLastError();
		}

		$arguments = func_get_args();
		array_shift($arguments);
		return Database::request($requestId, $arguments);
	}

	/**
	 * [Initializes mailer and] sends e-mail.
	 * @param string $to recipient e-mail address
	 * @param string $subject subject
	 * @param string $body text
     * @return bool was the email successfully sent?
	 */
	public static function sendEmail ($to, $subject, $body)
	{
        $config = Config::get('mail');
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $port = isset($config['port']) ? $config['port'] : 25;
        $security = isset($config['security']) ? $config['security'] : null;
        $from_name = isset($config['from_name']) ? $config['from_name'] : "XMLCHECK";
        $from_addr = isset($config['from_address']) ? $config['from_address'] : "XMLCHECK@XMLCHECK.CZ";

        $transport = \Swift_SmtpTransport::newInstance($host, $port, $security);
        if ($security)
        {
           $transport->setUsername($config["user"])->setPassword($config["password"]);
        }
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($subject)
            ->setFrom($from_addr, $from_name)
            ->setTo(array($to))
            ->setBody($body);

        return ($mailer->send($message) === 1);
	}

	/**
	 * Launches plugin and updates database with results.
	 * @param string $pluginType one of 'php', 'java', or 'exe'
	 * @param string $pluginFile plugin file path
	 * @param string $inputFile input file path
	 * @param string $dbRequest database update request
	 * @param int $rowId ID of row to be updated
	 * @param array $arguments plugin arguments
	 * @return bool true if no error occured
	 */
	public static function launchPlugin ($pluginType, $pluginFile, $inputFile,
			$dbRequest, $rowId, $arguments = array())
	{
        try
        {
            if (!is_file($pluginFile) || !is_file($inputFile))
            {
                $error = "plugin file and/or input file don't exist";
            }
            else
            {
                array_unshift($arguments, $inputFile);

                $cwd = getcwd();
                chdir(dirname($pluginFile));
                switch ($pluginType)
                {
                    case 'php':
                        $launcher = new PhpLauncher();
                        ob_start();
                        $error = $launcher->launch($pluginFile, $arguments, $response);
                        ob_end_clean();
                        break;
                    case 'java':
                        $launcher = new JavaLauncher();
                        $error = $launcher->launch($pluginFile, $arguments, $responseString);
                        break;
                    case 'exe':
                        $launcher = new ExeLauncher();
                        $error = $launcher->launch($pluginFile, $arguments, $responseString);
                        break;
                    default:
                        $error = "unsupported plugin type '$pluginType'";
                }
                chdir($cwd);
            }

            if (!$error)
            {
                if (isset($responseString))
                {
                    try {
                        $response = PluginResponse::fromXml(simplexml_load_string($responseString));
                    }
                    catch (Exception $ex)
                    {
                        $response =PluginResponse::createError('Internal error. Plugin did not supply valid response XML and this error occured: ' . $ex->getMessage());
                    }
                }
            }
            else
            {
                $response = PluginResponse::createError('Plugin cannot be launched (' . $error . ').');
            }

            $outputFile = $response->getOutput();
            if ($outputFile)
            {
                $outputFolder = Config::get('paths', 'output');

                $newFile = $outputFolder . date('Y-m-d_H-i-s_') . StringUtils::randomString(10) . '.zip';
                if (rename($outputFile, $newFile))
                {
                    $outputFile = $newFile;
                }
                else
                {
                    $outputFile = 'tmp-file-rename-failed';
                }
            }

            if (!Core::sendDbRequest($dbRequest, $rowId, $response->getFulfillment(),
                    $response->getDetails(), $outputFile))
            {
                Core::logError(Error::create(Error::levelError, Core::sendDbRequest(null),
                        'Submission/test state cannot be updated'));
            }

            return !$error;
        }
        catch (Exception $exception)
        {
            Core::sendDbRequest($dbRequest, $rowId, 0, "Internal error. Plugin launcher or plugin failed with an internal error. Exception information: " . $exception->getMessage() . " in " . $exception->getFile() . " at " . $exception->getLine(), null);
        }
	}

	/**
	 * Launches plugin in detached process (asynchronous).
	 * @param string $pluginType one of 'php', 'java', or 'exe'
	 * @param string $pluginFile plugin file path
	 * @param string $inputFile input file path
	 * @param string $dbRequest database update request
	 * @param int $rowId ID of row to be updated
	 * @param array $arguments plugin arguments
	 */
	public static function launchPluginDetached (
        $pluginType, $pluginFile, $inputFile,
			$dbRequest, $rowId, $arguments = array())
	{
		$launchPluginArguments = ShellUtils::quotePhpArguments(func_get_args());

        // Get config file and autoloader file
        $paths = Config::get('paths');
		$configFile = $paths['configFile'];
        $internalConfigFile = $paths['internalConfigFile'];
		$vendorAutoload = $paths['composerAutoload'];

        // This code will be passed, shell-escaped to the PHP CLI
		$launchCode = <<<LAUNCH_CODE
require_once '$vendorAutoload';
\asm\core\Config::init('$configFile', '$internalConfigFile');
\asm\utils\ErrorHandler::register();
\asm\core\Core::launchPlugin($launchPluginArguments);
LAUNCH_CODE;

		ShellUtils::phpExecInBackground(Config::get('bin', 'phpCli'), $launchCode);
	}

	/**
	 * Prints formatted response to UI request.
	 * @param UiResponse $response response data
	 */
	public static function sendUiResponse (UiResponse $response)
	{
		echo $response->toJson();
	}

	/**
	 * Launches UI script (handler for request from UI).
	 * @param array $data associative array with request arguments
	 * @param array $files uploaded files
	 */
	public static function handleUiRequest (array $data, array $files = array())
	{

        if (empty($data))
		{
			throw new CoreException("No request data received");
		}

		$request = UiRequest::fromArray($data);

		self::$request = $request->getRequestName();

		$handler = $request->getHandler();
		$handler->run($request->getParams(), $files);
	}

	/**
	 * Creates and initializes logger instance if it doesn't exist yet.
	 */
	protected static function initLogger ()
	{
		if (!self::$logger)
		{
			$user = User::instance();
			$username = $user->isLogged() ? $user->getName() : '[not logged in]';
			$remoteAddr = ($_SERVER['REMOTE_ADDR'] != '::1')
					? $_SERVER['REMOTE_ADDR'] : '[localhost]';
			$remoteHost = isset($_SERVER['REMOTE_HOST'])
					? $_SERVER['REMOTE_ADDR'] : '[no lookup]';
			self::$logger = Logger::create(Config::get('paths', 'log'))
				->setMaxFileSize(2097152)	// 2 * 1024 * 1024
				->setMaxFileCount(5)
				->setEntrySeparator("\n-\n")
				->setLineSeparator("\n\n")
				->setItemSeparator("\t")
				->setDatetimeFormat('Y-m-d H:i:s')
				->setHeaderItems($username, $remoteAddr, $remoteHost, self::$request);
		}
	}

	/**
	 * Gets system log entries.
	 * @param int $maxEntries maximum number of entries to get (no limit if set to zero)
	 * @return array log entries
	 */
	public static function readLog ($maxEntries = null)
	{
		self::initLogger();

		return self::$logger->read(array(
			'header' => array('username', 'remoteAddr', 'remoteHost', 'request'),
			'item' => array('level', 'code', 'cause', 'effect', 'details'),
		), $maxEntries);
	}

	/**
	 * Logs supplied error.
	 * @param Error $error
	 * @see logException()
	 */
	public static function logError (Error $error)
	{
		self::initLogger();

		call_user_func_array(array(self::$logger, 'log'), $error->toArray());
	}

	/**
	 * Logs supplied exception.
	 * @param Exception $e
	 * @see logError()
	 */
	public static function logException (Exception $e)
	{
		self::logError(Error::create(Error::levelFatal, self::getCustomMessage($e),
				'Runtime error', self::getCustomTrace($e)));
	}

	/**
	 * Creates message with custom formatting from supplied exception.
	 * @param Exception $e
	 * @return string error message with format: \<message\> (\<file\>:\<line\>)
	 */
	protected static function getCustomMessage (Exception $e)
	{
		return StringUtils::stripFunctionLinks($e->getMessage()) . ' (' .
				basename($e->getFile()) . ':' . $e->getLine() . ')';
	}

	/**
	 * Creates stack trace with custom formatting from supplied exception.
	 * @param Exception $e
	 * @return string stack trace
	 */
	protected static function getCustomTrace (Exception $e)
	{
		$trace = array();
		$index = 0;
		$defaults = array(
			'file' => null,
			'line' => null,
			'class' => null,
			'function' => null,
			'type' => '::',
			'args' => array(),
		);

		foreach ($e->getTrace() as $props)
		{
			$props = array_merge($defaults, $props);
			$file = basename($props['file']);
			$location = $props['file']
					? (($props['file'] != 'Command line code')
						? basename($props['file']) . ':' . $props['line']
						: '[command line]')
					: '[unknown location]';
			if (($props['function'] == 'trigger_error') && ($props['class'] === null))
			{
				$trace[] = "User error triggered ($location): {$props['args'][0]}";
			}
			elseif ((($props['class'] == 'Utils') && ($props['function'] == 'turnErrorToException'))
					|| (($props['class'] == 'ErrorHandler') && ($props['function'] == 'handleException'))
					|| (($props['class'] == 'ErrorHandler') && ($props['function'] == 'handleError')))
			{
				continue;
			}
			else
			{
				$arguments = ShellUtils::quotePhpArguments($props['args']);
				$function = $props['function'] ? "{$props['function']}($arguments)" : '';
				$caller = ($function && $props['class']) ? $props['class'] : '';
				$call = $caller ? $props['type'] : '';
				$trace[] = "#$index $location {$caller}{$call}{$function}";
				++$index;
			}
		}

		return implode("\n", $trace);
	}
}

