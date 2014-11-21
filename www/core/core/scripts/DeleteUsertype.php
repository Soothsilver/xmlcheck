<?php

namespace asm\core;
use asm\core\lang\StringID;


/**
 * @ingroup requests
 * Deletes user type.
 * @n @b Requirements: User::usersPrivPresets privilege
 * @n @b Arguments:
 * @li @c id usertype ID
 */
class DeleteUsertype extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::usersPrivPresets))
			return;

		if (!$this->isInputSet('id'))
			return;

		$id = $this->getParams('id');
        if ($id == Repositories::StudentUserType)
        {
            return $this->death(StringID::CannotRemoveBasicStudentType);
        }
        /**
         * @var $deletedType \UserType
         */
        $deletedType = Repositories::findEntity(Repositories::UserType, $id);
        $users = Repositories::getRepository(Repositories::User)->findBy(['type' => $id]);
        $studentType = Repositories::findEntity(Repositories::UserType, Repositories::StudentUserType);
        foreach($users as $user)
        {
            /** @var $user \User */
            $user->setType($studentType);
            Repositories::persist($user);
        }
        Repositories::remove($deletedType);
        Repositories::flushAll();
	}
}

