<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets all users.
 * @n @b Requirements: User::usersExplore privilege
 * @n @b Arguments: none
 */
class GetUsers extends DataScript
{
	protected function body ()
	{

		if (!$this->userHasPrivs(User::usersExplore))
			return;

        /**
         * @var $users \User[]
         */
        $users = Repositories::getRepository(Repositories::User)->findAll();

        foreach ($users as $user)
        {
            if ($user->getDeleted() == true) { continue; }

            $this->addRowToOutput([
                $user->getId(),
                $user->getName(),
                $user->getType()->getId(),
                $user->getType()->getName(),
                $user->getRealname(),
                $user->getEmail(),
                $user->getLastaccess()->format("Y-m-d H:i:s")
            ]);
        }
	}
}

