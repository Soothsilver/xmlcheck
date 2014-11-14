<?php

namespace asm\core;

/**
 * @ingroup requests
 * Checks whether supplied name is taken for supplied subject type.
 * @n @b Requirements: none
 * @n @b Arguments:
 * @li @c table subject type (possible values: @c groups, @c lectures, @c plugins
 *		@c problems, @c users, @c usertypes)
 */
final class IsNameTaken extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputSet(array('name', 'table')))
			return;

		$table = $this->getParams('table');
		$name = strtolower($this->getParams('name'));
		switch ($table)
		{
			case 'groups':
				$subject = 'group';
				$requestId = 'getGroupByName';
				break;
			case 'lectures':
				$subject = 'lecture';
				$requestId = 'getLectureByName';
				break;
			case 'plugins':
				$subject = 'plugin';
				$requestId = 'getPluginByName';
				break;
			case 'problems':
				$subject = 'problem';
				$requestId = 'getProblemByName';
				break;
			case 'users':
				$subject = 'user';
				$requestId = 'getUserByName';
				break;
			case 'usertypes':
				$subject = 'user type';
				$requestId = 'getUsertypeByName';
				break;
			default:
				return $this->stop('name duplicity check cannot be performed on table' . $table);
		}

		$data = Core::sendDbRequest($requestId, $name);
		if ($data === false)
			return $this->stopDb($data, ErrorEffect::dbGet($subject, 'name'));

		$this->addOutput('nameTaken', (boolean)$data);
	}
}

