<?php

namespace asm\core;

/**
 * Contains information about a single error.
 */
class Error
{
	/// @name Severity constants
	//@{
	const levelNotice		=	10;	///< notice (doesn't have to be error-related at all)
	const levelWarning	=	25;	///< warning (nothing failed but something's wrong)
	const levelError		=	50;	///< regular error
	const levelFatal		=	100;	///< fatal error (unexpected & fatal)
	//@}

	public static $counter = 0;	///< (int) error counter

	protected $level;	///< (int) error severity (one of @ref levelNotice, @ref levelWarning, @ref levelError, @ref levelFatal)
	protected $code;	///< (int) error code (unique for every known cause, otherwise ErrorCode::special)
	protected $cause;	///< (string) error cause (what happened)
	protected $effect;	///< (string) error effect (which action could not be completed)
	protected $details;	///< (string) any other pertinent information

	/**
	 * Creates instance and increases error counter.
	 * 
	 * Instances must be created using factory method create().
	 * @param int $level error severity
	 * @param mixed $cause either error code (int) or cause (string) for unknown errors
	 * @param string $effect error effect
	 * @param string $details error details
	 */
	protected function __construct ($level, $cause, $effect, $details)
	{
		if (is_int($cause))
		{
			$this->code = $cause;
			$this->cause = ErrorCause::getCauseString($this->code);
		}
		else
		{
			$this->code = ErrorCode::special;
			$this->cause = $cause;
		}
		$this->level = $level;
		$this->effect = $effect;
		$this->details = $details;
		
		++Error::$counter;
	}

	/**
	 * Creates Error instance [factory method].
	 * @param int $level error severity
	 * @param mixed $cause either error code (int) or cause (string) for unknown errors
	 * @param string $effect error effect
	 * @param string $details error details
	 * @return Error new Error instance
	 */
	public static function create ($level = Error::levelError, $cause = ErrorCode::unknown,
			$effect = null, $details = null)
	{
		return new self($level, $cause, $effect, $details);
	}

	/**
	 * Gets error severity.
	 * @return int error severity
	 */
	public function getLevel ()
	{
		return $this->level;
	}

	/**
	 * Creates array with error data.
	 * @return array associative array with error data {'level'=>severity,'code','cause','effect','details}
	 */
	public function toArray ()
	{
		return array(
			'level' => $this->level,
			'code' => $this->code,
			'cause' => $this->cause,
			'effect' => $this->effect,
			'details' => $this->details,
		);
	}
}

?>