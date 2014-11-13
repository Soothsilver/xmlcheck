<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\utils\Filesystem, asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes unconfirmed submission.
 * @n @b Requirements: must be the owner (creator) of the submission
 * @n @b Arguments:
 * @li @c id submission ID
 */
class DeleteSubmission extends DataScript
{
	protected function body ()
	{
        if (!$this->isInputSet(array('id')))
			return;
        $id = $this->getParams('id');
        /**
         * @var $submission \Submission
         */
        $submission = Repositories::findEntity(Repositories::Submission, $id);
        if ($submission->getUser()->getId() !== User::instance()->getId())
        {
            return $this->death(StringID::InsufficientPrivileges);
        }
        if ($submission->getStatus() === \Submission::STATUS_GRADED)
        {
            return $this->death(StringID::CannotDeleteGradedSubmissions);
        }
        $status = $submission->getStatus();
        $submission->setStatus(\Submission::STATUS_DELETED);
        Repositories::persist($submission);

        // Make something else latest
        if ($status === \Submission::STATUS_LATEST)
        {
            $latestSubmission = null;
            /**
             * @var $submissions \Submission[]
             * @var $latestSubmission \Submission
             */
            $submissions = Repositories::getRepository(Repositories::Submission)->findBy(['status' => \Submission::STATUS_NORMAL, 'assignment' => $submission->getAssignment()->getId(), 'user' => User::instance()->getId()]);
            foreach ($submissions as $olderSolution)
            {
                if ($latestSubmission === null || $olderSolution->getDate() > $latestSubmission->getDate())
                {
                    $latestSubmission = $olderSolution;
                }
            }
            if ($latestSubmission !== null)
            {
                $latestSubmission->setStatus(\Submission::STATUS_LATEST);
                Repositories::persist($latestSubmission);
            }
        }
        Repositories::flushAll();

	}
}

