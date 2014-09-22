<?php

namespace asm\core;
use \asm\db\DbLayout, \asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets
 */
final class GetTeacherRatings extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsManageAll, User::groupsManageOwn))
			return;

		$user = User::instance();
		$submissions = Core::sendDbRequest('getUserSubmissionRatingsByOwnerId',
				$user->getId(), $user->hasPrivileges(User::groupsManageAll));
		if ($submissions === null)
			return $this->stopDb ($submissions, ErrorEffect::dbGetAll('student submission ratings'));

		$result = array();
		foreach ($submissions as $s)
		{
			if (!isset($result[$s[DbLayout::fieldGroupId]]))
			{
				$result[$s[DbLayout::fieldGroupId]] = array(
					'name' => $s[DbLayout::fieldGroupName],
					'lecture' => $s[DbLayout::fieldLectureName],
					'owned' => ($s[DbLayout::fieldSpecialSecondaryId] == $user->getId()),
					'assignments' => array(),
					'students' => array(),
				);
			}

			$assignments =& $result[$s[DbLayout::fieldGroupId]]['assignments'];
			if (!isset($assignments[$s[DbLayout::fieldAssignmentId]]))
			{
				$assignments[$s[DbLayout::fieldAssignmentId]] = array(
					'problem' => $s[DbLayout::fieldProblemName],
					'reward' => $s[DbLayout::fieldAssignmentReward],
				);
			}

			$students =& $result[$s[DbLayout::fieldGroupId]]['students'];
			if (!isset($students[$s[DbLayout::fieldUserId]]))
			{
				$students[$s[DbLayout::fieldUserId]] = array(
					'name' => $s[DbLayout::fieldUserRealName],
					'ratings' => array(),
					'sum' => 0,
				);
			}

			$student =& $students[$s[DbLayout::fieldUserId]];
			$ratings =& $student['ratings'];
			$ratings[$s[DbLayout::fieldAssignmentId]] = array(
				'id' => $s[DbLayout::fieldSubmissionId],
				'rating' => $s[DbLayout::fieldSubmissionRating],
			);

			if (is_numeric($s[DbLayout::fieldSubmissionRating]))
			{
				$student['sum'] += $s[DbLayout::fieldSubmissionRating];
			}
		}

		$this->setOutput($result);
	}
}

?>