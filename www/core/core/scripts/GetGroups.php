<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets groups managable by user.
 * @n @b Requirements: one of following privileges: User::groupsAdd, User::groupsManageAll,
 *		User::groupsManageOwn
 * @n @b Arguments: none
 */
final class GetGroups extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsAdd, User::groupsManageAll, User::groupsManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::groupsManageAll);

        $groups = ( $displayAll ? Repositories::getRepository(Repositories::Group)->findBy(array('deleted' => false))
            : Repositories::getRepository(Repositories::Group)->findBy(array('deleted' => false, 'owner' => $user->getId())) );

        /**
         * @var $group \Group
         */
        foreach($groups as $group)
        {
            $row = array(
                $group->getId(),
                $group->getName(),
                $group->getDescription(),
                $group->getType(),
                $group->getLecture()->getId(),
                $group->getLecture()->getName(),
                $group->getLecture()->getDescription()
            );
            $this->addRowToOutput($row);
        }
	}
}