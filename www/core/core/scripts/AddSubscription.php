<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Add subscription for current user.
 * @n @b Requirements: one of following privileges: User::groupsJoinPrivate,
 *		User::groupsJoinPublic, or User::groupsRequest
 * @n @b Arguments:
 * @li @c id group ID
 */
class AddSubscription extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsJoinPrivate, User::groupsJoinPublic,
				User::groupsRequest))
			return;

		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$groupId = $this->getParams('id');
		$groups = Core::sendDbRequest('getGroupById', $groupId);
		if (!$groups)
			return $this->stopDb($groups, ErrorEffect::dbGet('group'));

		$group = $groups[0];
		$user = User::instance();
		$isPrivate = ($group[DbLayout::fieldGroupType] == 'private');
		$canJoinPrivate = $user->hasPrivileges(User::groupsJoinPrivate);
		$hasPrivs = (($isPrivate && ($canJoinPrivate || $user->hasPrivileges(User::groupsRequest)))
				|| (!$isPrivate && $user->hasPrivileges(User::groupsJoinPublic)));
		if (!$hasPrivs)
			$this->stop(ErrorCode::lowPrivileges);

		$status = (!$isPrivate || $canJoinPrivate) ? 'subscribed' : 'requested';
		if (!Core::sendDbRequest('addSubscription', $groupId, $user->getId(), $status))
			return $this->stopDb(false, ErrorEffect::dbAdd('subscription'));
	}
}

