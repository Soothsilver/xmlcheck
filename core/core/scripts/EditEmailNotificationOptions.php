<?php

namespace asm\core;
use asm\db\DbLayout;

final class EditEmailNotificationOptions extends DataScript
{
	protected function body ()
	{
        if (!$this->userHasPrivs())
             return;

        $onSubmissionRated = $this->getParams(User::sendEmailOnSubmissionRatedStudent);
        $onSubmissionConfirmed =  $this->getParams(User::sendEmailOnSubmissionConfirmedTutor);
        $onAssignmentAvailable = $this->getParams(User::sendEmailOnAssignmentAvailableStudent);
        $userEntity = User::instance()->getEntity();

        $params = $this->getParams(null);

        User::instance()->setData(User::sendEmailOnSubmissionRatedStudent, $this->getParams(User::sendEmailOnSubmissionRatedStudent)  ? 1 : 0);
        User::instance()->setData(User::sendEmailOnSubmissionConfirmedTutor, $this->getParams(User::sendEmailOnSubmissionConfirmedTutor) ? 1 : 0);
        User::instance()->setData(User::sendEmailOnAssignmentAvailableStudent, $this->getParams(User::sendEmailOnAssignmentAvailableStudent) ? 1 : 0);

        // Update
        $userEntity->setSendEmailOnNewAssignment(!!$onAssignmentAvailable);
        $userEntity->setSendEmailOnNewSubmission(!!$onSubmissionConfirmed);
        $userEntity->setSendEmailOnSubmissionRated(!!$onSubmissionRated);
        Repositories::getEntityManager()->persist($userEntity);
        Repositories::getEntityManager()->flush($userEntity);
	}
}

?>