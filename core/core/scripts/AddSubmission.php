<?php

namespace asm\core;
use asm\core\lang\Language;
use asm\core\lang\StringID;
use asm\utils\StringUtils, asm\utils\Filesystem, asm\db\DbLayout;

/**
 * @ingroup requests
 * Stores uploaded submission file, adds new submission to database, and launches
 * corrective plugin if any is used for this assignment.
 * @n @b Requirements: User::assignmentsSubmit privilege
 * @n @b Arguments:
 * @li @c assignmentId assignment ID
 * @li @c submission ZIP archive with problem solution files
 */
final class AddSubmission extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::assignmentsSubmit))
			return;

		if (!$this->isInputValid(array('assignmentId' => 'isIndex')))
			return;

		$userId = User::instance()->getId();
		$assignmentId = $this->getParams('assignmentId');
        /**
         * @var $assignment \Assignment
         */
        $assignment = Repositories::getEntityManager()->find('Assignment', $assignmentId);
        $query = "SELECT s, a FROM Subscription s, Assignment a WHERE s.group = a.group AND s.user = " . $userId . " AND a.id = " . $assignmentId;
        if ( count(Repositories::getEntityManager()->createQuery($query)->getResult()) === 0)
        {
            $this->stop(Language::get(StringID::HackerError));
            return;
        }


		$submissionsFolder = Config::get('paths', 'submissions');
		$file = date('Y-m-d_H-i-s_') . $userId . '_' . StringUtils::randomString(10) . '.zip';
		if (!$this->saveUploadedFile('submission', $submissionsFolder . $file))
			return;

        // Create submission
        $newSubmission = new \Submission();
        $newSubmission->setAssignment($assignment);
        $newSubmission->setStatus('new');
        $newSubmission->setSubmissionfile($file);
        $newSubmission->setUser(User::instance()->getEntity());
        $newSubmission->setDate(new \DateTime());

        // Fill in empty values
        $newSubmission->setSuccess(0); $newSubmission->setExplanation(""); $newSubmission->setInfo("");
        $newSubmission->setOutputfile(''); $newSubmission->setRating(0);

        // Put into database
        Repositories::getEntityManager()->persist($newSubmission);
        Repositories::getEntityManager()->flush($newSubmission);
        Core::launchPlugin(
            $assignment->getProblem()->getPlugin()->getType(),
            Config::get('paths', 'plugins') . $assignment->getProblem()->getPlugin()->getMainfile(),
            $submissionsFolder . $file,
            'correctSubmissionById',
            $newSubmission->getId(),
            explode(';', $assignment->getProblem()->getConfig())
        );

            /*
		if (!Core::sendDbRequest('addSubmission', $assignmentId, $userId, $file))
		{
			$this->stopDb(false, ErrorEffect::dbAdd('submission'));
			goto removeSubmissionFile;
		}

		$submissions = Core::sendDbRequest('getSubmissionByFilename', $file);
		if (!$submissions)
		{
			$this->stopDb($submissions, 'cannot retrieve id of added submission from database');
			goto removeSubmissionFile;
		}

		$submission = $submissions[0];
		$id = $submission[DbLayout::fieldSubmissionId];
		$correctRequestId = 'correctSubmissionById';
		if ($submission[DbLayout::fieldPluginType] != null)
		{

            // launch the corrective plugin synchronously
            Core::launchPlugin(
              $submission[DbLayout::fieldPluginType],
                Config::get('paths', 'plugins') . $submission[DbLayout::fieldPluginMainFile],
                $submissionsFolder . $submission[DbLayout::fieldSubmissionFile],
                $correctRequestId,
                $id,
                explode(';', $submission[DbLayout::fieldProblemPluginArguments])
            );
		}
		else
		{
			if (!Core::sendDbRequest($correctRequestId, $id, 100, '- no plugin used -', ''))
			{
				$this->addError(Error::levelWarning, Core::sendDbRequest(null),
						ErrorEffect::dbEdit('submission'));
			}
		}

		return;

removeSubmissionFile:
		Filesystem::removeFile($submissionsFolder . $file);
            */
	}
}

?>