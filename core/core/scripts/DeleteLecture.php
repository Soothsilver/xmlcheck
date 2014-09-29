<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes lecture (with groups, subscriptions, problem, assignments, submissions).
 * @n @b Requirements: either User::lecturesManageAll, or User::lecturesManageOwn and
 *		be the lecture's owner
 * @n @b Arguments:
 * @li @c id lecture ID
 */
final class DeleteLecture extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
        {
            return;
        }
        /**
         * @var $lecture \Lecture
         */
        $lecture = Repositories::findEntity(Repositories::Lecture, $this->getParams('id'));
		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll) &&
            (!$user->hasPrivileges(User::lecturesManageOwn) || ($user->getId() != $lecture->getId())))
        {
			return $this->death(StringID::InsufficientPrivileges);
        }
        RemovalManager::hideLectureItsProblemsAndGroups($lecture);
	}
}

