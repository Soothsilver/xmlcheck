<?php

namespace asm\core;
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
class ConfirmSubmission extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		$submissions = Core::sendDbRequest('getSubmissionById', $id);
		if (!$submissions)
			return $this->stopDb($submissions, ErrorEffect::dbGet('submission'));

		$submission = $submissions[0];
		$userId = User::instance()->getId();

		if ($submission[DbLayout::fieldUserId] != $userId)
			return $this->stop(ErrorCause::notOwned('submission'));

		$assignments = Core::sendDbRequest('getAssignmentsByUserId', $userId);
		if ($assignments === null)
			return $this->stopDb($assignments, ErrorEffect::dbGetAll('assignments'));

		foreach ($assignments as $assignment)
		{
			if (($assignment[DbLayout::fieldAssignmentId] == $submission[DbLayout::fieldAssignmentId]) &&
					($assignment[DbLayout::fieldSpecialCount] > 0))
			{
				return $this->stop('another submission has already been confirmed for this assignment',
						'cannot confirm submission');
			}
		}

		$status = $submission[DbLayout::fieldSubmissionStatus];
		if ($status == 'new')
			return $this->stop('submission hasn\'t been corrected yet', 'cannot confirm submission');
		if ($status != 'corrected')
			return $this->stop('submission has already been confirmed', 'cannot confirm submission');

        // Now confirm.
        if (!Core::sendDbRequest('confirmSubmissionById', $id))
            return $this->stopDb(false, ErrorEffect::dbEdit('submission'));

        // Now send email to tutor
        $query = "select email from usersprivileges where (usersprivileges.send_email_on_new_submission = 1 OR  usersprivileges.send_email_on_new_submission IS NULL ) AND usersprivileges.id = ( select ownerId from groups where  groups.id = " .
            "(  select groupId from assignments where  assignments.id =  (  select assignmentId from submissions where " .
            "id = " . $submission[DbLayout::fieldSubmissionId]  .
            " ) ) )";

        $whereTo = Database::sqlQuery($query);
        if ($whereTo)
        {
            $email = file_get_contents(Config::get("paths", "newSubmissionEmail"));
            $email = str_replace( "%{RealName}", User::instance()->getRealName(), $email);
            $email = str_replace( "%{Email}", User::instance()->getEmail(), $email); // TODO which assignment?
            $email = str_replace( "%{Date}", date("Y-m-d H:i:s"), $email); // TODO localisation?
            $lines = explode("\n", $email);
            $subject = $lines[0];
            $text = preg_replace('/^.*\n/', '', $email); // TODO beautify
            if (!Core::sendEmail($whereTo[0]["email"], trim($subject), $text))
            {
                $this->stop("E-mail could not be sent for some reason",
                    "cannot send e-mail to student", "the submission was still rated");
                // TODO improve the error message and move this beyond sendDbRequest
            }
        }



	}
}

?>