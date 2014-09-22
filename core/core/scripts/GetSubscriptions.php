<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets user's subscriptions.
 * @n @b Requirements: one of following privileges: User::groupsJoinPublic,
 *		User::groupsJoinPrivate, User::groupsRequest
 * @n @b Arguments: none
 */
final class GetSubscriptions extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsJoinPublic, User::groupsJoinPrivate, User::groupsRequest))
			return;

		$subscriptions = Core::sendDbRequest('getSubscriptionsByUserId', User::instance()->getId());
		if ($subscriptions === false)
			return $this->stopDb($subscriptions, ErrorEffect::dbGetAll('subscriptions'));

		$fields = array(
			DbLayout::fieldSubscriptionId,
			DbLayout::fieldGroupName,
			DbLayout::fieldGroupDescription,
			DbLayout::fieldLectureName,
			DbLayout::fieldLectureDescription,
			DbLayout::fieldSubscriptionStatus,
		);
		$subscriptions = ArrayUtils::map(array('asm\utils\ArrayUtils', 'filterByKeys'), $subscriptions, $fields);
		$subscriptions = ArrayUtils::map(array('asm\utils\ArrayUtils', 'sortByKeys'), $subscriptions, $fields);

		$this->setOutputTable($subscriptions);
	}
}

?>