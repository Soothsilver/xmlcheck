<?php

namespace asm\utils;
use Exception, ErrorException;

/**
 * Takes over handling of PHP errors and uncaught exceptions @module.
 *
 * To use this class for error handling, register() must be called to register
 * error and exception handlers. While the module is registered, all PHP errors
 * behave like thrown exceptions, which can be caught inside application code in
 * usual fashion. Uncaught exceptions are passed to all handlers bound to this
 * module by bind().
 *
 * Uncaught exceptions do not cause script execution to be stopped while the
 * module is registered.
 *
 * Class is implemented as singleton-module.
 */
class ErrorHandler
{
	protected static $instance;	///< singleton instance

	/**
	 * (Creates and) gets singleton instance.
	 * @return ErrorHandler instance
	 */
	protected static function instance ()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Makes directly inaccessible singleton instance accessible as module.
	 *
	 * Provides static access to register(), unregister(), bind() and unbind() methods.
	 */
	public static function __callStatic ($name, $arguments)
	{
		if (in_array($name, array('register', 'unregister', 'bind', 'unbind')))
		{
			call_user_func_array(array(self::instance(), $name), $arguments);
		}
	}


	private $callbacks = array();	///< uncaught exception handlers
	private $registered = false;	///< true if class has taken over error handling

	/**
	 * Register this handler to take over all PHP error handling.
	 * @see unregister()
	 * @see bind()
	 */
	protected final function register ()
	{
      	if (!$this->registered)
		{
			set_error_handler(array($this, 'handleError'));
			set_exception_handler(array($this, 'handleException'));
			$this->registered;
		}
	}

	/**
	 * Unregister this handler (pass PHP error handling back to previous handler).
	 * @see register()
	 */
	protected final function unregister ()
	{
		if ($this->registered)
		{
			restore_exception_handler();
			restore_error_handler();
			$this->registered = false;
		}
	}

	/**
	 * Bind supplied callback to this handler to be called for every uncaught exception.
	 * @param callback $callback will be called with uncaught Exception as first argument
	 * @return bool true if callback was bound successfully, false if it was
	 *		already bound
	 * @see unbind()
	 * @see register()
	 */
	protected final function bind ($callback)
	{
		if (!in_array($callback, $this->callbacks, true))
		{
			$this->callbacks[] = $callback;
			return true;
		}

		return false;
	}

	/**
	 * Unbind supplied callback (or all callbacks if none is supplied) from this handler.
	 * @param mixed $callback callback to be unbound or null to unbind all
	 * @return bool false if supplied callback was not bound, true otherwise
	 */
	protected final function unbind ($callback = null)
	{
		if ($callback === null)
		{
			$this->callbacks = array();
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
	 * @param int $errno one of predefined @c E_* constants
	 * @param string $errstr error message
	 * @param string $errfile file in which error occured
	 * @param int $errline line on which error occured
	 * @throws ErrorException always
	 */
	public function handleError ($errno, $errstr, $errfile, $errline)
	{
		if (ini_get('error_reporting') == 0)
		{
			return;	// error-control operator was used
		}

		switch ($errno)
		{
			case \E_STRICT:
			case \E_NOTICE:
				break;
			default:
				$errstr = preg_replace('| \[<a href=[^<]*</a>]|', '', $errstr);
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		}
	}

	/**
	 * Handles uncaught exception (calls bound callbacks).
	 * @param Exception $e
	 */
	public function handleException (Exception $e)
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

?>