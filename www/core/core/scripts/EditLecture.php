<?php

namespace asm\core;
use asm\core\lang\StringID;


/**
 * @ingroup requests
 * Creates or edits lecture.
 * @n @b Requirements: User::lecturesAdd privilege for add; either User::lecturesManageAll
 *		privilege or User::lecturesManageOwn privilege and be the lecture's owner (creator)
 * @n @b Arguments:
 * @li @c id @optional lecture ID (required for edit)
 * @li @c name lecture name (not editable, must match lecture ID for edit)
 * @li @c description lecture description
 */
final class EditLecture extends DataScript
{
	protected function body ()
	{
		$inputs = array(
			'name' => array(
				'isName',
				'isNotEmpty'
			),
			'description' => 'isNotEmpty',
		);
		if (!$this->isInputValid($inputs))
			return false;

		$name = $this->getParams('name');
		$description = $this->getParams('description');
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));

		/** @var \Lecture $lectureWithThisName */
		$lectureWithThisName = Repositories::getRepository(Repositories::Lecture)->findOneBy(['name' => $name]);

		$user = User::instance();
		$userId = $user->getId();

		if ($lectureWithThisName === null)
		{
			if (!$this->userHasPrivileges(User::lecturesAdd))
				return false;

			$lecture = new \Lecture();
			$lecture->setName($name);
			$lecture->setDescription($description);
			$lecture->setOwner(User::instance()->getEntity());
			Repositories::persistAndFlush($lecture);
		}
		else if ($isIdSet)
		{
			if ($id != $lectureWithThisName->getId())
				return $this->stop(ErrorCause::dataMismatch('lecture'));

			if (!$user->hasPrivileges(User::lecturesManageAll)
					&& (!$user->hasPrivileges(User::lecturesManageOwn)
						|| ($lectureWithThisName->getOwner()->getId() != $userId)))
				return $this->death(StringID::InsufficientPrivileges);

			$lectureWithThisName->setDescription($description);
			Repositories::persistAndFlush($lectureWithThisName);
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('lecture', $name));
		}
		return true;
	}
}

