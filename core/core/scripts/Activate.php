<?php

namespace asm\core;
use asm\core\lang\StringID;

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
			return $this->death(StringID::InvalidActivationCode);

		if (!Core::sendDbRequest('activateUsersByCode', $this->getParams('code')))
			return $this->stopDb();
	}
}

