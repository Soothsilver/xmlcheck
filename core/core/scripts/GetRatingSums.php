<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets user's rating sums for subscribed groups.
 * @n @b Requirements: User::assignmentsSubmit
 * @n @b Arguments: none
 */
final class GetRatingSums extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::assignmentsSubmit))
			return;

		$user = User::instance();
		$ratings = Core::sendDbRequest('getUserRatingSumsByUserId', $user->getId());
		if ($ratings === false)
			return $this->stopDb($ratings, ErrorEffect::dbGetAll('submission rating sums'));

		$this->setOutputTable($ratings);
	}
}

?>