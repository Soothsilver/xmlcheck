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
		if (!$this->userHasPrivs(User::lecturesAdd, User::lecturesManageAll,
				User::lecturesManageOwn, User::groupsAdd))
			return;

		$lite = $this->getParams('lite');

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll) || $lite;
		$lectures = Core::sendDbRequest('getLecturesVisibleByUserId', $user->getId(), $displayAll);
		if ($lectures === null)
			return $this->stopDb($lectures, ErrorEffect::dbGetAll('lectures'));

		if ($lite)
		{
			$lectures = ArrayUtils::map(array('\asm\utils\ArrayUtils', 'filterByKeys'),
					$lectures, array(DbLayout::fieldLectureDescription), false);
		}

		$this->setOutputTable($lectures);
	}
}

?>