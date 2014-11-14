<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets all questions managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesManageAll,
 *		User::lecturesManageOwn
 * @n @b Arguments: none
 */
final class GetQuestions extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::lecturesManageAll, User::lecturesManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll);
		$questions = Core::sendDbRequest('getQuestionsVisibleByUserId', $user->getId(), $displayAll);
		if ($questions === false)
			return $this->stopDb($questions, ErrorEffect::dbGetAll('questions'));

		$this->setOutputTable($questions);
	}
}

