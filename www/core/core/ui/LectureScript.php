<?php

namespace asm\core;
use asm\db\DbLayout;

abstract class LectureScript extends DataScript
{
	protected function checkTestGenerationPrivileges ($lectureId)
	{
		if (!($lectures = Core::sendDbRequest('getLectureById', $lectureId)))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll)
				&& (!$user->hasPrivileges(User::lecturesManageOwn)
					|| ($lectures[0][DbLayout::fieldUserId] != $user->getId())))
			return $this->stop(ErrorCode::lowPrivileges);
		else
			return true;
	}
}

