<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets assignments available to be solved by this user.
 * @n @b Requirements: must be logged in
 * @n @b Arguments: none
 */
final class GetStudentAssignments extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs())
			return;

		$assignments = Core::sendDbRequest('getAssignmentsByUserId', User::instance()->getId());
		if ($assignments === null)
			return $this->stopDb($assignments, ErrorEffect::dbGetAll('assignments'));

		$this->setOutputTable($assignments);
	}
}

?>