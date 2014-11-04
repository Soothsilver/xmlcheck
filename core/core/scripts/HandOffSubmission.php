<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\Database;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Marks submission as confirmed.
 * @n @b Requirements: user has be the uploader of the submission
 * @n @b Arguments: 
 * @li @c id submission ID
 *
 * Submission will be open for correction & rating by assignment owner and no
 * more submissions for same assignment by current user will be accepted.
 */
class HandOffSubmission extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;
		$id = $this->getParams('id');
        /**
         * @var $submission \Submission
         */
        $submission = Repositories::findEntity(Repositories::Submission, $id);
		$userId = User::instance()->getId();
        if ($submission->getUser()->getId() != $userId) { return $this->death(StringID::HackerError); }
        $submission->setStatus(\Submission::STATUS_REQUESTING_GRADING);

        // First, if you handed something off previously, it is no longer handed off
        $yourSubmissions = Repositories::getRepository(Repositories::Submission)->findBy(['user'=>$userId,'assignment'=>$submission->getAssignment()->getId(),'status'=>\Submission::STATUS_REQUESTING_GRADING]);
        foreach($yourSubmissions as $previouslyHandedOffSubmission)
        {
            $previouslyHandedOffSubmission->setStatus(\Submission::STATUS_NORMAL);
            Repositories::persistAndFlush($previouslyHandedOffSubmission);
        }
        Repositories::persistAndFlush($submission);

        // TODO send email
	}
}

