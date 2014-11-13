<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Updates submission with supplied rating.
 * @n @b Requirements: user has to own (transitively) the assignment submission belongs to
 * @n @b Arguments:
 * @li @c id submission id
 * @li @c rating submission rating
 */
final class RateSubmission extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::submissionsCorrect))
			return;

		$inputs = array(
			'id' => 'isIndex',
			'rating' => 'isNonNegativeInt',
            'explanation' => null
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));

		$submissions = Core::sendDbRequest('getSubmissionOwnerById', $id);
		if (!$submissions)
			return $this->stopDb($submissions, ErrorEffect::dbGet('submission'));

		$submission = $submissions[0];
		$user = User::instance();

		if ($submission[DbLayout::fieldUserId] != $user->getId())
			return $this->stop(ErrorCause::notOwned('submission'));

		$status = $submission[DbLayout::fieldSubmissionStatus];
		if (($status == 'new') && ($status == 'corrected'))
			return $this->stop('submission is not confirmed yet', 'cannot rate submission');
		if (($status == 'rated') && !$user->hasPrivileges(User::submissionsModifyRated))
			return $this->stop("you don't have permission to change rating of already rated submission",
					'cannot rate submission');

		$maxReward = $submission[DbLayout::fieldAssignmentReward];
		if ($rating > $maxReward)
			return $this->stop('rating exceeds assignment\'s maximum reward', 'cannot rate submission');


		if (!Core::sendDbRequest('rateSubmissionById', $id, $rating, $explanation))
			return $this->stopDb(false, ErrorEffect::dbEdit('submission'));

        // Now send email.
        // Load email.
        $userDetailsTable = Core::sendDbRequest('getUserById', $submission[DbLayout::fieldSpecialSecondaryId]); // special secondary id is userId column of submissions table in this case
        if (!$userDetailsTable)
            return $this->stopDb($userDetailsTable, "Submission was rated, but it was not possible to send an e-mail to the user.");
        $userDetails = $userDetailsTable[0];

        if ($userDetails[DbLayout::fieldUserOptionSendEmailOnSubmissionRated])
        {
            $email = file_get_contents(Config::get("paths", $rating == $maxReward ? "successEmail" : "failureEmail"));
            $email = str_replace( "%{Points}", $rating, $email);
            $email = str_replace( "%{Maximum}", $maxReward, $email);
            $email = str_replace( "%{Explanation}", $explanation, $email);
            $email = str_replace( "%{Assignment}", $submission[DbLayout::fieldProblemName], $email);
            $email = str_replace( "%{Link}", Config::getHttpRoot() . "#submissions", $email);
            $email = str_replace( "%{Date}", date("Y-m-d H:i:s"), $email);
            $lines = explode("\n", $email);
            $subject = $lines[0];
            $text = preg_replace('/^.*\n/', '', $email);
            if (!Core::sendEmail($userDetails[DbLayout::fieldUserEmail], trim($subject), $text))
            {
                $this->death(StringID::MailError);
            }
        }

	}
}

