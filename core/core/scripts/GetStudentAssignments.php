<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets assignments available to be solved by this user.
 * @n @b Requirements: must be logged in
 * @n @b Arguments: none
 */
final class GetStudentAssignments extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs())
			return;

        $query = "SELECT a, p, l, z, g FROM Assignment a JOIN a.problem p JOIN p.plugin z JOIN p.lecture l JOIN a.group g WITH g.id IN (SELECT IDENTITY(k.group) FROM \Subscription k WHERE k.user = :id)";
        /**
         * @var $assignments \Assignment[]
         */
        $userId = User::instance()->getId();
        $assignments = Repositories::getEntityManager()->createQuery($query)
            ->setParameter('id', $userId)
            ->getResult();

        foreach($assignments as $assignment)
        {
            $submissionGraded = count(Repositories::getRepository(Repositories::Submission)->findBy (['assignment'=>$assignment->getId(), 'user' => $userId, 'status' => \Submission::STATUS_GRADED])) > 0;
            $submissionExists = count(Repositories::getRepository(Repositories::Submission)->findBy (['assignment'=>$assignment->getId(), 'user' => $userId])) > 0;
            $row = [
                $assignment->getId(),
                $assignment->getProblem()->getName(),
                $assignment->getProblem()->getDescription(),
                $assignment->getProblem()->getPlugin()->getDescription(),
                $assignment->getDeadline()->format("Y-m-d H:i:s"),
                $assignment->getReward(),
                $assignment->getProblem()->getLecture()->getName(),
                $assignment->getProblem()->getLecture()->getDescription(),
                $assignment->getGroup()->getName(),
                $assignment->getGroup()->getDescription(),
                $submissionExists,
                $submissionGraded
            ];
            $this->addRowToOutput($row);
        }


        /*
         * TODO remove
		$assignments = Core::sendDbRequest('getAssignmentsByUserId', User::instance()->getId());
		if ($assignments === null)
			return $this->stopDb($assignments, ErrorEffect::dbGetAll('assignments'));

		$this->setOutputTable($assignments);
        */
	}
}

?>