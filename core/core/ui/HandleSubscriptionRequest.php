<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * Implements common logic for handling of PermitSubscription and ProhibitSubscription requests.
 */
abstract class HandleSubscriptionRequest extends DataScript
{
	/**
	 * Sends appropriate database request updating the subscription.
	 * @param int $subscriptionId subscription ID
	 */
	abstract protected function handleRequest ($subscriptionId);

	protected function body ()
	{
		if (!$this->isInputSet('id'))
			return;

		$id = $this->getParams('id');

		$subscriptions = Core::sendDbRequest('getSubscriptionOwnerById', $id);
		if (!$subscriptions)
			return $this->stopDb($subscriptions, ErrorEffect::dbGet('subscription'));

		if ($subscriptions[0][DbLayout::fieldUserId] != User::instance()->getId())
			return $this->stop(ErrorCause::notOwned('subscription request'));

		$this->handleRequest($id);
	}
}

?>