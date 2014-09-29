<?php

namespace asm\core;
use asm\db\DbLayout;

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

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');

       	$name = strtolower($name);
		$users = Core::sendDbRequest('getUserByName', $name);
		$userExists = (bool)$users;

        // Verify password
        if ($pass !== $repass)
        {
            return $this->stop(ErrorCause::invalidInput("passwords do not match", "repass"));
        }
        if ($userExists)
        {
            // A new user must have full password
            if ((strlen($pass) < Constants::PasswordMinLength || strlen($pass) > Constants::PasswordMaxLength) && $pass !== "")
            {
                return $this->stop(ErrorCause::invalidInput("password must have between 6 and 20 characters, or be empty", "pass"));
            }
        }
        else
        {
            // A new user must have full password
            if (strlen($pass) < Constants::PasswordMinLength || strlen($pass) > Constants::PasswordMaxLength)
            {
                return $this->stop(ErrorCause::invalidInput("password must have between 6 and 20 characters", "pass"));
            }
        }



        $isIdSet = (($id !== null) && ($id !== ''));
		$type = $this->getParams('type');
		$isTypeSet = ($type !== null);
		$code = '';
        $unhashedPass = $pass;
		$pass = \asm\utils\Security::hash($pass, \asm\utils\Security::$hashtypePhpass);
		$canAddUsers = User::instance()->hasPrivileges(User::usersAdd);
		$canEditUsers = User::instance()->hasPrivileges(User::usersManage);
		$isEditingSelf = ($id === User::instance()->getId());

		if (!$userExists) // create/register new user
		{
			if (!$canAddUsers)
			{
				if ($type != 0) // TODO this zero means student (0=student, 1=admin unchangeable user types)
					return $this->stop(ErrorCode::lowPrivileges, 'cannot add new user of specified type to database');

				$code = md5(uniqid(mt_rand(), true));
				$text = $this->getRegistrationEmail($realname, $code);
				$returnCode = Core::sendEmail($email, '[XMLCheck] Your activation code', $text); // TODO move somewhere (when localizing) (won't always be [XMLCheck]

				if (!$returnCode)
					return $this->stop(ErrorCode::mail, 'user registration failed', 'email could not be sent');
			}

            // TODO add user options here and make them a transaction
			if (!Core::sendDbRequest('addUser', $type, $name, $pass, $realname, $email, $code, \asm\utils\Security::$hashtypePhpass))
				return $this->stopDb(false, ErrorEffect::dbAdd('user'));
		}
		elseif ($isIdSet) // edit existing user
		{
			$user = $users[0];
			if ($id != $user[DbLayout::fieldUserId])
				return $this->stop(ErrorCause::dataMismatch('user'));
			
			if (!$canEditUsers && ($isTypeSet || (!$isEditingSelf)))
				return $this->stop(ErrorCode::lowPrivileges, 'cannot edit data of users other than yourself');

			$type = $isTypeSet ? $type : $user[DbLayout::fieldUsertypeId];
			if ($isTypeSet && ($id == DbLayout::rootUserId) && ($type != DbLayout::rootUsertypeId))
			{
				$type = DbLayout::rootUsertypeId;
				$this->addError(Error::levelWarning, 'cannot change user type of root user',
						'user type hasn\'t been modified');
			}

            if ($unhashedPass)
            {
                if (!Core::sendDbRequest('editUserById', $id, $name, $type, $pass, $realname, $email, \asm\utils\Security::$hashtypePhpass))
                    return $this->stopDb(false, ErrorEffect::dbEdit('user'));
            }
            else
            {
                if (!Core::sendDbRequest('editUserByIdButKeepPassword', $id, $name, $type, $realname, $email))
                    return $this->stopDb(false, ErrorEffect::dbEdit('user'));
            }
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('user', $name));
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

