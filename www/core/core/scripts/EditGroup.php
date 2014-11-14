<?php

namespace asm\core;
use asm\core\lang\StringID;
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
                    'min_length' => 1
                ),
            ),
            'description' => array()
        );
        if (!$this->isInputValid($inputs))
        {
            return;
        }
        $lectureIndex = $this->getParams('lecture');
        $groupName = $this->getParams('name');
        $groupDescription = $this->getParams('description');
        $public = $this->paramExists('public') ? 'public' : 'private';
        $groupId = $this->getParams('id');
        $editing = $groupId !== null && $groupId !== '';
        $user = User::instance();
        $userId = $user->getId();
        $lecture = Repositories::findEntity(Repositories::Lecture, $lectureIndex);

        if ($editing)
        {
            /**
             * @var $group \Group
             */
            $group = Repositories::findEntity(Repositories::Group, $groupId);
            $sameNameGroup = Repositories::getRepository(Repositories::Group)->findBy(['name' => $groupName]);
            if (count($sameNameGroup) == 1 && $sameNameGroup[0]->getId() !== (int)$groupId)
            {
                return $this->death(StringID::GroupNameExists);
            }
            $group->setName($groupName);
            $group->setDescription($groupDescription);
            $group->setType($public);
            Repositories::persistAndFlush($group);
        }
        else
        {
            if (!$this->userHasPrivs(User::groupsAdd)) { return $this->death(StringID::InsufficientPrivileges); }
            $sameNameGroup = Repositories::getRepository(Repositories::Group)->findBy(['name' => $groupName]);
            if (count($sameNameGroup) > 0)
            {
                return $this->death(StringID::GroupNameExists);
            }
            $group = new \Group();
            $group->setDeleted(false);
            $group->setDescription($groupDescription);
            $group->setLecture($lecture);
            $group->setName($groupName);
            $group->setOwner($user->getEntity());
            $group->setType($public);
            Repositories::persistAndFlush($group);
        }


        /*
		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));
		$type = $this->paramExists('public') ? 'public' : 'private';
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
        */
	}
}
