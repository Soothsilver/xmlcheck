<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\DbLayout;
use asm\utils\Security;

/**
 * @ingroup requests
 * Creates or edits user.
 * @n @b Requirements: none to create inactive account of default type, User::usersAdd
 *		privilege to create active account of custom type, User::usersManage privilege
 *		to edit user account
 * @n @b Arguments:
 * @li @c id @optional user ID (required for edit)
 * @li @c type @optional (required for creation of active user account)
 * @li @c name username (must match user ID for edit)
 * @li @c realname user's real name
 * @li @c email
 * @li @c pass account password
 * @li @c repass must match ^
 *
 * Notes on user creation:
 * If user session is currently open, this handler tries to create full-fledged
 * active user, otherwise it tries to register new user of base type and send
 * them e-mail with activation code. They must activate their user account before
 * they can use it.
 */
final class EditUser extends DataScript
{
	protected function body ()
	{
		$inputs = array(
			'name' => array(
				'isAlphaNumeric',
				'hasLength' => array(
					'min_length' => Constants::UsernameMinLength,
					'max_length' => Constants::UsernameMaxLength,
				),
			),
			'realname' => array(
				'isNotEmpty',
				'isName',
			),
			'email' => 'isEmail',
			'pass' => array(),
			'repass' => array(),
		);
		if (!$this->isInputValid($inputs))
			return;

        // Extract input data
        $username = strtolower( $this->getParams('name') );
        $realname = $this->getParams('realname');
        $email = $this->getParams('email');
        $pass = $this->getParams('pass');
        $repass = $this->getParams('repass');
        $id = $this->getParams('id');
        $type = $this->getParams('type');
        $user = null;
        $isIdSet = ($id !== null && $id !== '');
        $isTypeSet = ($type !== null && $type !== '');

        // Extract database data
        if ($id)
        {
            $user = Repositories::findEntity($user, $id);
        }
        $userExists = ($user != null);
        $sameNameUserExists = count(Repositories::getRepository(Repositories::User)->findBy(['name' => $username])) > 0;

        // Custom verification of input data
        if ($pass !== $repass)
        {
            return $this->death(StringID::InvalidInput);
        }
        if ($userExists)
        {
            if ((strlen($pass) < Constants::PasswordMinLength || strlen($pass) > Constants::PasswordMaxLength) && $pass !== "")
            {
                return $this->death(StringID::InvalidInput);
            }
        }
        else
        {
            // A new user must have full password
            if (strlen($pass) < Constants::PasswordMinLength || strlen($pass) > Constants::PasswordMaxLength)
            {
                return $this->death(StringID::InvalidInput);
            }
        }

        $code = '';
        $unhashedPass = $pass;
        $pass = \asm\utils\Security::hash($pass, \asm\utils\Security::HASHTYPE_PHPASS);
        $canAddUsers = User::instance()->hasPrivileges(User::usersAdd);
        $canEditUsers = User::instance()->hasPrivileges(User::usersManage);
        $isEditingSelf = ($id === User::instance()->getId());
        /**
         * @var $user \User
         */

        if (!$userExists) // create/register new user
        {
            if (!$canAddUsers)
            {
                if ($type != Repositories::StudentUserType)
                    return $this->death(StringID::InsufficientPrivileges);

                $code = md5(uniqid(mt_rand(), true));
                $text = $this->getRegistrationEmail($realname, $code);
                $returnCode = Core::sendEmail($email, '[XMLCheck] Your activation code', $text); // TODO move somewhere (when localizing) (won't always be [XMLCheck]

                if (!$returnCode)
                    return $this->stop(ErrorCode::mail, 'user registration failed', 'email could not be sent');
            }
            $user = new \User();
            $typeEntity = Repositories::findEntity(Repositories::UserType, $type);
            $user->setType($typeEntity);
            $user->setPass($pass);
            $user->setName($username);
            $user->setEmail($email);
            $user->setActivationcode($code);
            $user->setEncryptiontype(Security::HASHTYPE_PHPASS);
            $user->setRealname($realname);
            Repositories::persistAndFlush($user);
        }
        elseif ($isIdSet && !$sameNameUserExists) // edit existing user
        {
            if (!$canEditUsers && ($isTypeSet || (!$isEditingSelf)))
                return $this->stop(ErrorCode::lowPrivileges, 'cannot edit data of users other than yourself');

            $type = $isTypeSet ? $type : $user->getType()->getId();
            $typeEntity = Repositories::findEntity(Repositories::UserType, $type);

            if ($unhashedPass)
            {
                $user->setPass($pass);
                $user->setEncryptiontype(Security::HASHTYPE_PHPASS);
            }
            $user->setType($typeEntity);
            $user->setEmail($email);
            $user->setActivationcode('');
            $user->setRealname($realname);
            Repositories::persistAndFlush($user);
        }
        else
        {
            return $this->death(StringID::UserNameExists);
        }
	}

	protected function getRegistrationEmail($name, $code)
	{
		return <<<EMAIL
Hello $name.

To complete registration of your account, please use following activation code:

$code

This e-mail is automated, do not reply.
EMAIL;
	}
}

