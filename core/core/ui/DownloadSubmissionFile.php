<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * Contains convenience method for getting submission by ID if it's accessible to user.
 *
 * @see UiScript for explanation of [stopping] tag.
 */
abstract class DownloadSubmissionFile extends DownloadScript
{
	/**
	 * Gets submission with supplied ID if it's accessible to user [stopping].
	 * @param int $id submission ID
	 * @return mixed submission data (array) or false in case of failure
	 */
	protected final function findAccessibleSubmissionById ($id)
	{
		$submissionsWithAuthor = Core::sendDbRequest('getSubmissionById', $id);
		$submissionsWithOwner = Core::sendDbRequest('getSubmissionOwnerById', $id);
		if (!$submissionsWithAuthor || !$submissionsWithOwner)
		{
			$badResult = ($submissionsWithAuthor ? $submissionsWithOwner : $submissionsWithAuthor);
			return $this->stopDb($badResult, ErrorEffect::dbGetAll('submissions'));
		}

		$userId = User::instance()->getId();
		$authorId = $submissionsWithAuthor[0][DbLayout::fieldUserId];
		$ownerId = $submissionsWithOwner[0][DbLayout::fieldUserId];

		if (($authorId != $userId) && ($ownerId != $userId))
			return $this->stop(ErrorCause::notOwned('submissions'));

		return $submissionsWithAuthor[0];
	}
}

?>