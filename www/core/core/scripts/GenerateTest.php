<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Generates a test from saved template.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this test belongs to
 * @n @b Arguments:
 * @li @c id test ID
 */
final class GenerateTest extends GenTestScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($genTests = Core::sendDbRequest('getGenTestById', $id)))
			return $this->stopDb($genTests, ErrorEffect::dbGet('test'));

		$test = $genTests[0];

		if (!$this->checkTestGenerationPrivileges($test[DbLayout::fieldLectureId]))
			return;

		$randomized = $this->generateTest($test[DbLayout::fieldGenTestTemplate],
				$test[DbLayout::fieldGenTestCount]);

		if (!Core::sendDbRequest('editGenTestById', $id, implode(',', $randomized)))
			return $this->stopDb(false, ErrorEffect::dbEdit('test'));
	}
}

