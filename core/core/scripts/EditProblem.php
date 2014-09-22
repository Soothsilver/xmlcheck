<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates or edits problem.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this problem belongs to
 * @n @b Arguments:
 * @li @c id @optional problem ID (required for edit)
 * @li @c lecture @optional lecture ID (required for add, not editable)
 * @li @c name problem name (must match problem ID for edit)
 * @li @c description problem description
 * @li @c plugin plugin ID (zero for no plugin)
 */
final class EditProblem extends DataScript
{
	protected function body ()
	{
		$inputs = array(
			'lecture' => 'isIndex',
			'name' => array(
				'isName',
				'hasLength' => array(
					'min_length' => 5,
					'max_length' => 50,
				),
			),
			'description' => 'isNotEmpty',
			'pluginId' => 'isIndex',
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));
		$pluginArguments = $this->getParams('pluginArguments');
		$pluginArguments = ($pluginArguments !== null) ? $pluginArguments : '';

		if (!($lectures = Core::sendDbRequest('getLectureById', $lecture)))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll)
				&& (!$user->hasPrivileges(User::lecturesManageOwn)
					|| ($lectures[0][DbLayout::fieldUserId] != $user->getId())))
			return $this->stop(ErrorCode::lowPrivileges);

		if ($pluginId && !($plugins = Core::sendDbRequest('getPluginById', $pluginId)))
			return $this->stopDb($plugins, ErrorEffect::dbGet('plugin'));

		$problems = Core::sendDbRequest('getProblemByName', $name);
		if ($problems === false)
			return $this->stopDb($problems, ErrorEffect::dbGet('problem', 'name'));

		if (!$problems)
		{
			if (!Core::sendDbRequest('addProblem', $lecture, $pluginId, $name, $description, $pluginArguments))
				return $this->stopDb(false, ErrorEffect::dbAdd('problem'));
		}
		else if ($isIdSet)
		{
			$problem = $problems[0];
			if ($id != $problem[DbLayout::fieldProblemId])
				return $this->stop(ErrorCause::dataMismatch('problem'));

			if (!Core::sendDbRequest('editProblemById', $id, $pluginId, $name, $description, $pluginArguments))
				return $this->stopDb(false, ErrorEffect::dbEdit('problem'));
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('problem', $name));
		}
	}
}

?>