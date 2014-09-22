<?php

namespace asm\core;

/**
 * @ingroup requests
 * Gets supplied number of entries from system log.
 * @n @b Requirements: User::systemLogExplore
 * @n @b Arguments:
 * @li @c maxEntries @optional maximum number of newest log entries to get
 */
class GetSystemLog extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::systemLogExplore))
			return;

		$maxEntries = $this->getParams('maxEntries');

		$log = Core::readLog($maxEntries);
		$logTable = array();
		foreach ($log as $entry)
		{
			$header = $entry['header'];
			foreach ($entry['lines'] as $line)
			{
				$logTable[] = array($line['level'], $entry['datetime'], $line['cause'],
						$line['effect'], $line['details'], $header['username'],
						$header['remoteAddr'], $header['remoteHost'], $header['request']);
			}
		}

		$this->setOutput($logTable);
	}
}

?>