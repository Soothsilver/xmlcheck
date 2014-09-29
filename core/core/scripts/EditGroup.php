<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates or edits group.
 * @n @b Requirements: User::groupsAdd privilege for add and either User::groupsManageAll
 *		privilege or User::groupsManageOwn privilege and be the group's owner for edit
 * @n @b Arguments:
 * @li @c id @optional group ID (required for edit)
 * @li @c lecture @optional lecture ID (required for add, not editable)
 * @li @c name group name (not editable, must match group ID for edit)
 * @li @c description group description
 */
final class EditGroup extends DataScript
{
	protected function body ()
	{
		$inputs = array(
			'lecture' => 'isIndex',
			'name' => array(
				'isName',
				'hasLength' => array(
					'min_length' => 5,
					'max_length' => 20,
				),
			),
			'description' => 'isNotEmpty',
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));
		$type = $this->getParams('public') ? 'public' : 'private';

		if (!($lectures = Core::sendDbRequest('getLectureById', $lecture)))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$groups = Core::sendDbRequest('getGroupByName', $name);

		$user = User::instance();
		$userId = $user->getId();

		if (!$groups)
		{
			if (!$this->userHasPrivs(User::groupsAdd))
				return;

			if (!Core::sendDbRequest('addGroup', $lecture, $userId, $name, $description, $type))
				return $this->stop(false, ErrorEffect::dbAdd('group'));
		}
		else if ($isIdSet)
		{
			$group = $groups[0];
			if ($id != $group[DbLayout::fieldGroupId])
				return $this->stop(ErrorCause::dataMismatch('group'));

			if (!$user->hasPrivileges(User::groupsManageAll)
					&& (!$user->hasPrivileges(User::groupsManageOwn)
						|| ($group[DbLayout::fieldUserId] != $userId)))
				return $this->stop(ErrorCode::lowPrivileges);

			if (!Core::sendDbRequest('editGroupById', $id, $name, $description, $type))
				return $this->stopDb(false, ErrorEffect::dbEdit('group'));
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('group', $name));
		}
	}
}

