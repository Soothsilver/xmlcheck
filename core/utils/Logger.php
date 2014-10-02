<?php

namespace asm\utils;
use DateTime;

/**
 * Manages error log.
 *
 * Log consists of entries, each of which should contain error information about
 * a single request that went wrong. Each entry has a single header and any number
 * of 'lines' (error descriptions). Header contains timestamp and possibly other
 * customizable items. Lines are fully customizable. Header and line item sets
 * should be consistent throughout the whole log.
 *
 * Usual use of Logger is to create single instance for the whole script execution
 * and use it to log errors. At the end of script execution all errors are
 * automatically packed into single log entry and added to log file.
 *
 * Log data is saved in log files. Maximum size of individual files and their
 * number can be customized. Log is 'rotating' - when the file is full, it
 * continues writing into next one (when the last one is full, it continues with
 * the first one, etc.).
 *
 * The Logger flushes (writes to disk) when it is destroyed.
 */
class Logger
{
	const minFileSize = 1024;	///< minimum for maximum file size (see setMaxFileSize())
	const minFileCount = 2;		///< minimum for maximum file count (see setMaxFileCount())

	/**
	 * Creates new Logger instance.
	 * @param string $folder folder in which the log files are (to be) located
	 * @return Logger new instance
	 */
	public static function create ($folder)
	{
		return new self($folder);
	}

    private $folder;	///< folder to store log files in

	private $lines = array();		///< log entry 'lines' (error descriptions)
	private $header = array();		///< customized entry header items
	private $prefix = 'logfile';	///< logfile name prefix
	private $suffix = '.log';		///< logfile name suffix
	private $maxFileSize = 1048576;	///< maximum size of individual log files in bytes (default is 1MB)
	private $maxFileCount = 5;		///< maximum number of log files
	private $entrySeparator = "\n#ENTRY\n";	///< entry separator
	private $lineSeparator = "\n#LINE\n";		///< 'line' separator
	private $itemSeparator = "\n#ITEM\n";		///< item separator
	private $datetimeFormat = DateTime::ISO8601;	///< entry timestamp format

	/**
	 * (Creates and) sets folder for log files to be saved in.
	 * @param string $folder logfile folder
	 */
	private function __construct ($folder)
	{
		Filesystem::createDir($folder, 0700);
		$this->folder = realpath($folder);
	}

	/**
	 * Writes log entry to log file if it's not empty.
	 */
	function  __destruct ()
	{
		@$this->flush();
	}

	/**
	 * Sets prefix of log file names (logfiles are named \<PREFIX\>\<INDEX\>\<SUFFIX\>).
	 * @param string $prefix
	 * @return Logger self
	 */
	public final function setPrefix ($prefix)
	{
		$this->prefix = basename($prefix);
		return $this;
	}

	/**
	 * Sets suffix of log file names (logfiles are named \<PREFIX\>\<INDEX\>\<SUFFIX\>).
	 * @param string $suffix
	 * @return Logger self
	 */
	public final function setSuffix ($suffix)
	{
		$this->suffix = basename($suffix);
		return $this;
	}

	/**
	 * Sets maximum size of log files.
	 * @param int $size maximum file size in bytes
	 * @return Logger self
	 */
	public final function setMaxFileSize ($size)
	{
		$this->maxFileSize = max((int)$size, self::minFileSize);
		return $this;
	}

	/**
	 * Sets maximum number of log files (log rotation starts when this number is reached).
	 * @param int $count
	 * @return Logger self
	 */
	public final function setMaxFileCount ($count)
	{
		$this->maxFileCount = max((int)$count, self::minFileCount);
		return $this;
	}

	/**
	 * Sets entry separator (will be stripped from all log entry data and used to separate log entries).
	 * @param string $separator
	 * @return Logger self
	 */
	public final function setEntrySeparator ($separator)
	{
		$this->entrySeparator = (string)$separator;
		return $this;
	}

	/**
	 * Sets line separator (will be stripped from all log entry data and used to separate log 'lines').
	 * @param string $separator
	 * @return Logger self
	 */
	public final function setLineSeparator ($separator)
	{
		$this->lineSeparator = (string)$separator;
		return $this;
	}

	/**
	 * Sets item separator (will be stripped from all log entry data and used to separate log data chunks).
	 * @param string $separator
	 * @return Logger self
	 */
	public final function setItemSeparator ($separator)
	{
		$this->itemSeparator = (string)$separator;
		return $this;
	}

	/**
	 * Sets timestamp format.
	 * @param string $format Look up PHP @c date function for formatting options.
	 *		Separators will be stripped from value.
	 * @return Logger self
	 */
	public final function setDatetimeFormat ($format)
	{
		$this->datetimeFormat = $this->stripSeparators($format);
		return $this;
	}

	/**
	 * Sets items to be saved in log entry header apart from timestamp.
	 * @param mixed [...] items to be included in entry header
	 * @return Logger self
	 */
	public final function setHeaderItems ()
	{
		$items = array();
		foreach (func_get_args() as $item)
		{
			$items[] = $this->stripSeparators($item);
		}
		$this->header = $items;

		return $this;
	}

	/**
	 * Strips entry, line, and item separators from supplied item.
	 * @param mixed $str value will be turned to string by @c print_r function
	 *		and stripped of separators
	 * @return string value ready to be added to log
	 */
	protected final function stripSeparators ($str)
	{
		$str = print_r($str, true);
		$str = str_replace($this->entrySeparator, '', $str);
		$str = str_replace($this->lineSeparator, '', $str);
		return str_replace($this->itemSeparator, '', $str);
	}

	/**
	 * Log error (or anything really).
	 * @param mixed [...] items to be saved as single log 'line' (will be
	 *		stripped of separators)
	 * @return Logger self
	 */
	public function log ()
	{
		$items = array();
		foreach (func_get_args() as $item)
		{
			$items[] = $this->stripSeparators($item);
		}
		$this->lines[] = $items;
		
		return $this;
	}

	/**
	 * Creates full path to log file with supplied index.
	 * @param int $index
	 * @return string log file path
	 */
	private function getLogFilename ($index)
	{
		return $this->folder . DIRECTORY_SEPARATOR . $this->prefix . $index . $this->suffix;
	}

	/**
	 * Create index of currently existing log files with info about current log file index.
	 * @return array combined array with logfile names as simple entries and an
	 *		additional entry 'lastIndex' indicating index of most recent logfile
	 */
	private function getLogFiles ()
	{
		$lastIndex = null;
		$lastFoundIndex = 0;
		$reachedBreak = false;
		$beforeBreak = array();
		$afterBreak = array();
		for ($i = 0; $i <= $this->maxFileCount; ++$i)
		{
			$filename = $this->getLogFilename($i);
			if (!is_file($filename))
			{
				$reachedBreak = true;
				continue;
			}

			if ($reachedBreak)
			{
				$afterBreak[] = $filename;
				$lastFoundIndex = $i;
			}
			else
			{
				$beforeBreak[] = $filename;
				$lastIndex = $i;
			}
		}

		$logFiles = array_merge($afterBreak, $beforeBreak);

		if (($lastIndex === null) && count($logFiles))
		{
			$lastIndex = $lastFoundIndex;
		}
		
		$logFiles['lastIndex'] = $lastIndex;

		return $logFiles;
	}

	/**
	 * Gets logfile index coming after supplied index (indexes are rotated).
	 * @param int $index
	 * @return int next index
	 */
	private function getNextIndex ($index)
	{
		return ($index + 1) % ($this->maxFileCount + 1);
	}

	/**
	 * Turns log entry data stored in this Logger instance to string to be written
	 * to logfile.
	 * @return string escaped and separated log entry data
	 */
	private function entryToString ()
	{
		$headerLine = implode($this->itemSeparator, array_merge(
				array(date($this->datetimeFormat)), $this->header));

		$lines = array($headerLine);
		foreach ($this->lines as $entry)
		{
			$lines[] = implode($this->itemSeparator, $entry);
		}

		$entry = $this->entrySeparator . implode($this->lineSeparator, $lines);

		if (strlen($entry) > $this->maxFileSize)
		{
			$entry = substr($entry, 0, $this->maxFileSize);
		}

		return $entry;
	}

	/**
	 * Manages writing of stored data to logfile (and possibly rotating log).
	 *
	 * Entry is written only if not empty. If most recent logfile is full, oldest
	 * logfile is deleted and new file is created to contain the entry. Locking
	 * is used to prevent logfile access clashes.
	 * @return Logger self
	 */
    private function write ()
	{
		if (!count($this->lines))
		{
			return $this;
		}

		$entryString = $this->entryToString();

		$logFiles = $this->getLogFiles();
		$lastIndex = $logFiles['lastIndex'];
		unset($logFiles['lastIndex']);
		$noFile = ($lastIndex === null);

		$currentFileSize = $noFile	? 0 : filesize($this->getLogFilename($lastIndex));
		$currentIndex = $noFile	? 0 : $lastIndex;

		$deleteOldest = (($currentFileSize + strlen($entryString)) > $this->maxFileSize);
		if ($deleteOldest)
		{
			$currentIndex = $this->getNextIndex($currentIndex);
		}

		$currentFile = fopen($this->getLogFilename($currentIndex), 'a');
		$lock = flock($currentFile, LOCK_EX);

		if ($deleteOldest)
		{
			if ((count($logFiles) >= $this->maxFileCount) && file_exists($logFiles[0]))
			{
				chmod($logFiles[0], 0777);
				unlink($logFiles[0]);
			}
		}

		fwrite($currentFile, $entryString);
		flock($currentFile, LOCK_UN);
		fclose($currentFile);

		clearstatcache();
		
		return $this;
	}

	/**
	 * Clears all events logged so far during this script execution.
	 * @return Logger self
	 */
    private function clear ()
	{
		$this->lines = array();
		return $this;
	}

	/**
	 * Writes logged events to logfile and remove them from this instance (to avoid
	 * saving them more than once).
	 * @return Logger self
	 */
	public final function flush ()
	{
		return $this->write()->clear();
	}
}

