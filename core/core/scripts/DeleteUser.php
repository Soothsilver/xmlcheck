<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes user.
 * @n @b Requirements: User::usersRemove privilege
 * @n @b Arguments:
 * @li @c id user ID
 */
class DeleteUser extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::usersRemove))
			return;

		if (!$this->isInputSet('id'))
			return;

		$id = $this->getParams('id');
		if ($id == DbLayout::rootUserId)
			return $this->stop('cannot delete root user');

		if (!Core::sendDbRequest('deleteUserById', $id))
			return $this->stopDb();
	}
}

?>