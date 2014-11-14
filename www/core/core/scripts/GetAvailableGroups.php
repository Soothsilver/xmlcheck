<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets groups user can subscribe to.
 * @n @b Requirements: must be logged in
 * @n @b Arguments: none
 */
final class GetAvailableGroups extends DataScript
{
	protected function body ()
    {
        if (!$this->userHasPrivs())
        {
            return;
        }

        $user = User::instance();
        $displayPublic = $user->hasPrivileges(User::groupsJoinPublic);
        $displayPrivate = $user->hasPrivileges(User::groupsJoinPrivate, User::groupsRequest);

        /**
         * @var $groups \Group[]
         * @var $subscriptions \Subscription[]
         */
        $subscriptions = Repositories::getRepository(Repositories::Subscription)->findBy(array('user' => $user->getId()));
        $subscriptionIds = array_map(function ($subscription) { return $subscription->getId(); }, $subscriptions);
        $conditions = array('deleted' => false);
        if (!$displayPrivate)
        {
            $conditions['type'] = 'public';
        }
        $groups = Repositories::getRepository(Repositories::Group)->findBy($conditions);
        foreach ($groups as $group)
        {
            if (in_array($group->getId(), $subscriptionIds))
            {
                continue;
            }
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

