<?php

namespace asm\core;


/**
 * @ingroup requests
 * Gets all tests managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesManageAll,
 *		User::lecturesManageOwn
 * @n @b Arguments: none
 */
final class GetTests extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::lecturesManageAll, User::lecturesManageOwn))
			return false;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll);

		/*
		 * TODO complete this change (will be more complex, I think):
		$tests = ($displayAll ? Repositories::getRepository(Repositories::Xtest)->findAll() :
				Reposito)
			*/

		/*'id',
		'description',
		'template',
		'count',
		'generated',
		'lectureId',
		'lecture',
		'lectureDescription'*/

		$tests = Core::sendDbRequest('getGenTestsVisibleByUserId', $user->getId(), $displayAll);
		if ($tests === false)
			return $this->stopDb($tests, ErrorEffect::dbGetAll('tests'));

		$this->setOutputTable($tests);
	}
}

