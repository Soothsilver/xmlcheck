<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets lectures managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesAdd, User::lecturesManageAll,
 *		User::lecturesManageOwn, User::groupsAdd
 * @n @b Arguments:
 * @li @c lite to get lectures usable by user (just IDs & names)
 */
final class GetLectures extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::lecturesAdd, User::lecturesManageAll,
				User::lecturesManageOwn, User::groupsAdd))
			return;

		$lite = $this->getParams('lite');

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll) || $lite;

        /**
         * @var $lectures \Lecture[]
         */
        $lectures = ($displayAll ? Repositories::getRepository('Lecture')->findBy(array('deleted'=>false)) : Repositories::getRepository('Lecture')->findBy(array('owner' => $user->getId(), 'deleted' => false)));
        foreach($lectures as $lecture)
        {
            $radek = array( $lecture->getId(), $lecture->getName() );
            if (!$lite) { $radek[] = $lecture->getDescription(); }
            $this->addRowToOutput($radek);
        }
	}
}

