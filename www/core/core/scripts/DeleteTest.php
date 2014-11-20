<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes a saved test template.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this test belongs to
 * @n @b Arguments:
 * @li @c id test ID
 */
final class DeleteTest extends GenTestScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($tests = Core::sendDbRequest('getGenTestById', $id)))
			return $this->stopDb($tests, ErrorEffect::dbGet('test'));

		if (!$this->checkTestGenerationPrivileges($tests[0][DbLayout::fieldLectureId]))
			return;

		if (!Core::sendDbRequest('deleteGenTestById', $id))
			return $this->stopDb(false, ErrorEffect::dbRemove('test'));
	}
}

