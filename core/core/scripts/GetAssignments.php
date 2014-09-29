<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets assignments managable by user.
 * @n @b Requirements: one of following privileges: User::groupsManageAll, User::groupsManageOwn
 * @n @b Arguments: none
 */
final class GetAssignments extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsManageAll, User::groupsManageOwn))
			return;

		$user = User::instance();
        $conditions = array('deleted' => false);
        if (!$user->hasPrivileges(User::groupsManageAll)) { $conditions['owner'] = $user->getId(); }
        /**
         * @var $assignments \Assignment[]
         */
        $assignments = Repositories::getRepository(Repositories::Assignment)->findBy($conditions);
        foreach($assignments as $assignment)
        {
            $row = array(
                $assignment->getId(),
                $assignment->getProblem()->getId(),
                $assignment->getProblem()->getName(),
                $assignment->getDeadline()->format('Y-m-d H:i:s'),
                $assignment->getReward(),
                $assignment->getGroup()->getId(),
                $assignment->getGroup()->getName(),
                $assignment->getGroup()->getOwner()->getId()
            );
            $this->addRowToOutput($row);
        }
	}
}

