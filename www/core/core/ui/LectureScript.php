<?php

namespace asm\core;


abstract class LectureScript extends DataScript
{
	protected function authorizedToManageLecture(\Lecture $lecture)
	{
		$user = User::instance();
		if ($user->hasPrivileges(User::lecturesManageAll)) { return true; }
		if ($user->hasPrivileges(User::lecturesManageOwn && $lecture->getOwner()->getId() === User::instance()->getId())) { return true; }
		return false;
	}

	protected function checkTestGenerationPrivileges ($lectureId)
	{
		/**
		 * @var $lecture \Lecture
		 */
		$lecture = Repositories::findEntity(Repositories::Lecture, $lectureId);
		return $this->authorizedToManageLecture($lecture);
	}
}

