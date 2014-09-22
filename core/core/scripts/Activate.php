<?php

namespace asm\core;

/**
 * @ingroup requests
 * Activates user account with supplied activation code.
 * @n @b Requirements: none
 * @n @b Arguments:
 * @li @c code user account activation code
 */
final class Activate extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputSet(array('code')))
			return;

		$code = $this->getParams('code');

		if (!Core::sendDbRequest('getUsersByActivationCode', $code))
			return $this->stop('invalid activation code');

		if (!Core::sendDbRequest('activateUsersByCode', $this->getParams('code')))
			return $this->stopDb();
	}
}

?>