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

        /**
         * @var $problems \Problem[]
         */
        $problems = Repositories::getEntityManager()->createQuery(
            "SELECT p, l FROM \Problem p JOIN p.lecture l WHERE p.deleted = false AND (:displayAll = true OR l.owner = :userid)")
            ->setParameter('displayAll', $displayAll)
            ->setParameter('userid', $user->getId())->getResult();

        foreach ($problems as $problem) {
            $row = array($problem->getId(), $problem->getName());
            if (!$lite) { $row[] = $problem->getDescription(); if ($problem->getPlugin()) { $row[] = $problem->getPlugin()->getId(); } else { $row[] = ""; } $row[] = $problem->getConfig();};
            $row[] = $problem->getLectureid();
            if (!$lite) { $row[] = $problem->getLecture()->getName(); $row[] = $problem->getLecture()->getDescription(); }
            $this->addRowToOutput($row);
        }

        /*
         *
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
        */
	}
}

?>