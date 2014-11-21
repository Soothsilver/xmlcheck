<?php

namespace asm\core;


use asm\db\DbLayout;
use asm\utils\StringUtils;

final class RequestResetLink extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputSet(array('email')))
			return;

		$email = $this->getParams('email');

		$users = Core::sendDbRequest('getUsersByEmail', $email);
        if (!$users)
			return $this->stop('There is no user with this e-mail address in the database.');

        foreach($users as $user)
        {
            // Generate reset link.
            $resetLink = StringUtils::randomString(60);
            $now = new \DateTime();
            $expiryDate = $now->add(new \DateInterval('P1D'))->format("Y-m-d H:i:s");

            // Add in in the database (replacing any older reset links in the process)
            if (!Core::sendDbRequest('setResetLinkById', $user[DbLayout::fieldUserId], $resetLink, $expiryDate))
            {
                return $this->stopDb();
            }

            // Send the e-mail
            $body = "A Password Reset Link was requested for your e-mail address on XMLCheck.\n\nYour name: " . $user[DbLayout::fieldUserRealName] . "\nYour login: " . $user[DbLayout::fieldUserName]
                . "\n\nClick this link to reset your password: \n\n" . Config::get('roots', 'http') . "#resetPassword#" . $resetLink . "\n\nThe link will be valid for the next 24 hours, until " . $expiryDate . ".";
            if (!Core::sendEmail($user[DbLayout::fieldUserEmail], "[XMLCheck] Password Reset Link for '" . $user[DbLayout::fieldUserRealName] . "'", $body))
            {
                return $this->stop("Password reset link could not be sent to your e-mail.");
            }

        }
        $this->addOutput('count', count($users));
	}
}

