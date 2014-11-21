<?php

namespace asm\core;


/**
 * @ingroup requests
 * Gets subscription requests to user's groups.
 * @n @b Requirements: User::groupsAdd privilege
 * @n @b Arguments: none
 */
final class GetSubscriptionRequests extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::groupsAdd))
			return;

		$requests = Core::sendDbRequest('getSubscriptionRequestsByUserId', User::instance()->getId());
		if ($requests === false)
			return $this->stopDb($requests, ErrorEffect::dbGetAll('subscription requests'));

		$this->setOutputTable($requests);
	}
}

