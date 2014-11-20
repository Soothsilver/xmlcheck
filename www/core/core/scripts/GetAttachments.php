<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets all questions managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesManageAll,
 *		User::lecturesManageOwn
 * @n @b Arguments: none
 */
final class GetAttachments extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::lecturesManageAll, User::lecturesManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll);
		$attachments = Core::sendDbRequest('getAttachmentsVisibleByUserId', $user->getId(), $displayAll);
		if ($attachments === false)
			return $this->stopDb($attachments, ErrorEffect::dbGetAll('attachments'));

		$this->setOutputTable($attachments);
	}
}

