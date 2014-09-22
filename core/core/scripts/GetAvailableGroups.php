<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets groups user can subscribe to.
 * @n @b Requirements: must be logged in
 * @n @b Arguments: none
 */
final class GetAvailableGroups extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs())
			return;

		$user = User::instance();
		$displayPublic = $user->hasPrivileges(User::groupsJoinPublic);
		$displayPrivate = $user->hasPrivileges(User::groupsJoinPrivate, User::groupsRequest);

		$groups = Core::sendDbRequest('getAvailableGroups', $displayPrivate);
		if ($groups === false)
			return $this->stopDb($groups, ErrorEffect::dbGetAll('groups'));

		$subscriptions = Core::sendDbRequest('getSubscriptionsRawByUserId', $user->getId());
		if ($subscriptions === false)
			return $this->stopDb($subscriptions, ErrorEffect::dbGetAll('subscriptions'));

		$subscribedGroupIds = array();
		foreach ($subscriptions as $subscription)
		{
			$subscribedGroupIds[] = $subscription[DbLayout::fieldGroupId];
		}

		foreach ($groups as $key => $group) {
			if (in_array($group[DbLayout::fieldGroupId], $subscribedGroupIds))
			{
				unset($groups[$key]);
			}
		}

		$this->setOutputTable($groups);
	}
}

?>