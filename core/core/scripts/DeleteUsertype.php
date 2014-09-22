<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes user type.
 * @n @b Requirements: User::usersPrivPresets privilege
 * @n @b Arguments:
 * @li @c id usertype ID
 */
class DeleteUsertype extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::usersPrivPresets))
			return;

		if (!$this->isInputSet('id'))
			return;

		$id = $this->getParams('id');
		if ($id == DbLayout::rootUsertypeId)
			return $this->stop('cannot delete root user type');

		if (!Core::sendDbRequest('demoteUsersByType', $id))
			return $this->stopDb(false, 'cannot change type of affected users');

		if (!Core::sendDbRequest('deleteUsertypeById', $id))
			return $this->stopDb();
	}
}

?>