<?php

namespace asm\utils;
use Exception, ErrorException;

/**
 * Takes over handling of PHP errors and uncaught exceptions.
 *
 * To use this class for error handling, register() must be called to register
 * error and exception handlers. While the module is registered, all PHP errors
 * behave like thrown exceptions, which can be caught inside application code in
 * usual fashion. Uncaught exceptions are passed to all handlers bound to this
 * module by bind().
 *
 * Note: Class is implemented as singleton-module.
 */
class ErrorHandler
{
	private static $instance;	///< singleton instance

	/**
	 * (Creates and) gets singleton instance.
	 * @return ErrorHandler instance
	 */
    private static function instance ()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	private $callbacks = [];	///< bound exception handlers
	private $registered = false;	///< true if class has taken over error handling

	/**
	 * Register this handler to take over all PHP error and exception handling.
     *
	 * @see unregister()
	 * @see bind()
	 */
    public static function register()
    {
        self::instance()->_register();
    }
	private function _register ()
	{
      	if (!$this->registered)
		{
			set_error_handler([$this, 'handleError']);
			set_exception_handler([$this, 'handleException']);
			$this->registered;
		}
	}
	/**
	 * Unregister this handler (pass PHP error and exception handling back to previous handler).
	 * @see register()
	 */
    public static function unregister()
    {
        self::instance()->_unregister();
    }
    private function _unregister ()
	{
		if ($this->registered)
		{
			restore_exception_handler();
			restore_error_handler();
			$this->registered = false;
		}
	}

	/**
	 * Bind the callback to this handler. Whenever an error or unhandled exception occurs, this callback will be called,
     * along with any other callbacks registered using this function.
     * Callback is: function(Exception). Errors are turned into ErrorException.
     *
	 * @param callback $callback will be called with uncaught Exception as first argument
	 * @return bool true if callback was bound successfully, false if it was already bound
	 * @see unbind()
	 * @see register()
	 */
    public static function bind(callable $callback)
    {
        self::instance()->_bind($callback);
    }
    /**
     * @param callable $callback
     * @return bool
     */
    private function _bind (callable $callback)
	{
		if (!in_array($callback, $this->callbacks, true))
		{
			$this->callbacks[] = $callback;
			return true;
		}

		return false;
	}

	/**
	 * Unbind the callback from this handler.
	 * @param mixed $callback callback to be unbound or null to unbind all
	 * @return bool false if supplied callback was not bound, true otherwise
	 */
    public static function unbind(callable $callback = null)
    {
        self::instance()->_unbind($callback);
    }
    /**
     * @param callable $callback
     * @return bool
     */
	private function _unbind (callable $callback = null)
	{
		if ($callback === null)
		{
			$this->callbacks = [];
			return true;
		}

		if (in_array($callback, $this->callbacks, true))
		{
			$keys = array_keys($this->callbacks, $callback, true);
			array_splice($this->callbacks, $keys[0], 1);
			return true;
		}

		return false;
	}

	/**
	 * Turns triggered PHP error to exception with appropriate data.
     *
	 * @param int $errno one of predefined @c E_* constants
	 * @param string $errstr error message
	 * @param string $errfile file in which error occurred
	 * @param int $errline line on which error occurred
	 * @throws ErrorException always, unless we are inside an error-controlled (@@) function.
	 */
	private function handleError ($errno, $errstr, $errfile, $errline)
	{
		if (ini_get('error_reporting') == 0)
		{
            // Error-control operator (@) was used
            // http://php.net/manual/en/function.set-error-handler.php
			return;
		}

		switch ($errno)
		{

        // Uncomment for less strict error handling.
        //	case \E_STRICT:
        //	case \E_NOTICE:
        //		break;
			default:
				$errstr = preg_replace('| \[<a href=[^<]*</a>]|', '', $errstr);
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		}
	}

	/**
	 * Handles uncaught exception (calls bound callbacks).
	 * @param Exception $e
	 */
    private function handleException (Exception $e)
	{
		foreach ($this->callbacks as $callback)
		{
			try
			{
				call_user_func($callback, $e);
			}
			catch (Exception $ex)
			{
			}
		}
	}
}