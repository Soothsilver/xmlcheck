<?php

namespace asm\core;


/**
 * @ingroup requests
 * Gets user's rating sums for subscribed groups.
 * @n @b Requirements: User::submissionsCorrect
 * @n @b Arguments: none
 */
final class GetTeacherRatingSums extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::submissionsCorrect))
			return;

		$user = User::instance();
		$ratings = Core::sendDbRequest('getUserRatingSumsByOwnerId', $user->getId());
		if ($ratings === false)
			return $this->stopDb($ratings, ErrorEffect::dbGetAll('submission rating sums'));

		$this->setOutputTable($ratings);
	}
}

