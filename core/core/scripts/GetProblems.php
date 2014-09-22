<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets all problems managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesManageAll,
 *		User::lecturesManageOwn, User::groupsManageAll, User::groupsManageOwn
 * @n @b Arguments:
 * @li @c lite to get problems usable by user (just IDs & names)
 */
final class GetProblems extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::lecturesManageAll, User::lecturesManageOwn,
				User::groupsManageAll, User::groupsManageOwn))
			return;

		$lite = $this->getParams('lite');

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll) || $lite;
		$problems = Core::sendDbRequest('getProblemsVisibleByUserId', $user->getId(), $displayAll);
		if ($problems === false)
			return $this->stopDb($problems, ErrorEffect::dbGetAll('problems'));

		if ($lite)
		{
			$problems = ArrayUtils::map(array('\asm\utils\ArrayUtils', 'filterByKeys'),
					$problems, array(DbLayout::fieldProblemId, DbLayout::fieldProblemName,
					DbLayout::fieldLectureId));
		}

		$this->setOutputTable($problems);
	}
}

?>