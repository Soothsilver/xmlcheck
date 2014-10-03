<?php

namespace asm\core;

use asm\db\Database;
use asm\db\DbLayout;
use asm\utils\Security;
use asm\utils\StringUtils;

final class ResetPassword extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputSet(array('resetLink', 'pass', 'repass')))
			return;

		$resetLink = $this->getParams('resetLink');
        if (strlen($resetLink) < 1)
        {
            return $this->stop("You must provide a reset link.");
        }
        $encryptionType = Security::HASHTYPE_PHPASS;
        $newPassword = $this->getParams('pass');
        $newPasswordHash = Security::hash($newPassword, $encryptionType);

		$result = Core::sendDbRequest('changePasswordByResetLink', $resetLink, $newPasswordHash, $encryptionType);
        if (!$result)
            return $this->stopDb();
        if (Database::getAffectedRows() == 0)
			return $this->stop('This reset link is not in the database. This may be because 24 hours elapsed since the link was created or because a new reset link for your account was created since.');
	}
}

