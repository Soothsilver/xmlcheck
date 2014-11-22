<?php

namespace asm\core;


abstract class LectureScript extends DataScript
{
	protected function checkTestGenerationPrivileges ($lectureId)
	{
		/**
		 * @var $lecture \Lecture
		 */
		$lecture = Repositories::findEntity(Repositories::Lecture, $lectureId);
		return $this->authorizedToManageLecture($lecture);
	}
}

