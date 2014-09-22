<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes subscription.
 * @n @b Requirements: must be owner of the subscription
 * @n @b Arguments:
 * @li @c id subscription ID
 */
final class DeleteSubscription extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($subscriptions = Core::sendDbRequest('getSubscriptionById', $id)))
			return $this->stopDb($subscriptions, ErrorEffect::dbGet('subscription'));

		if ($subscriptions[0][DbLayout::fieldUserId] != User::instance()->getId())
			return $this->stop(ErrorCause::notOwned('subscription'));

		if (!Core::sendDbRequest('deleteSubscriptionById', $id))
			return $this->stopDb(false, ErrorEffect::dbRemove('subscription'));
	}
}

?>