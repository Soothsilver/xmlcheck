<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates a test template.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this test belongs to
 * @n @b Arguments:
 * @li @c description test description
 * @li @c count number of questions the test is to have
 * @li @c questions question IDs in a single string consisting of two parts separated
 *		by semicolon. First part are mandatory questions, second part are the optional
 *		questions. IDs are separated by commas.
 */
final class AddTest extends GenTestScript
{
	protected function body ()
	{
		$questions = $this->getParams('questions');
		if ($questions === null || $questions === '')
		{
			return $this->death(StringID::ChooseAtLeastOneQuestion);
			// Put this in front to have a more specific, comprehensible error message
		}

		$inputs = array(
			'description' => 'isNotEmpty',
			'count' => 'isNonNegativeInt',
			'questions' => 'isNotEmpty',
		);
		if (!$this->isInputValid($inputs))
			return;
		$description = $this->getParams('description');
		$count = $this->getParams('count');
		$questions = $this->getParams('questions');
		$questionsArray = explode(',', $questions);


		$user = User::instance();
		$visibleQuestions = CommonQueries::GetQuestionsVisibleToActiveUser();

		$lecture = null;


		foreach ($visibleQuestions as $vq)
		{
			$qId = $vq->getId();
			$index = array_search($qId, $questionsArray);
			if ($index !== false)
			{
				array_splice($questionsArray, $index, 1);
				if ($lecture === null)
				{
					$lecture = $vq->getLecture();
				}
				elseif ($lecture->getId() !== $vq->getLecture()->getId())
				{
					return $this->death(StringID::TestCannotContainQuestionsOfDifferentLectures);
				}
			}
		}
		if (count($questionsArray))
		{
			return $this->stop(ErrorCause::invalidInput('Following question IDs are invalid or inaccessible: ' .
				implode(', ', $questionsArray) . '.', 'questions'));
		}
		if ($lecture === null)
		{
			return $this->death(StringID::ChooseAtLeastOneQuestion);
		}

		if (!$this->checkTestGenerationPrivileges($lecture->getId()))
			return $this->death(StringID::InsufficientPrivileges);

		$randomized = $this->generateTest($questions, $count);

		$xtest = new \Xtest();
		$xtest->setDescription($description);
		$xtest->setCount($count);
		$xtest->setLecture($lecture);
		$xtest->setTemplate($questions);
		$xtest->setGenerated(implode(',', $randomized));
		Repositories::persistAndFlush($xtest);
		/*

		extract($this->getParams(array_keys($inputs)));

		list($selected, $filtered) = $this->parseQuestions($questions);

		if (!$count)
			return $this->stop(ErrorCause::invalidInput('Number of questions must be positive.', 'count'));
		elseif ($count < count($selected))
			return $this->stop(ErrorCause::invalidInput('Number of questions must be greater than the number of selected questions.', 'count'));
		elseif ($count > (count($selected) + count($filtered)))
			return $this->stop(ErrorCause::invalidInput('Number of questions must not be more than total number of questions.', 'count'));

		$user = User::instance();
		$visibleQuestions = Core::sendDbRequest('getQuestionsVisibleByUserId', $user->getId());
		if ($visibleQuestions === false)
			return $this->stopDb(false, ErrorEffect::dbGetAll('questions'));

		$qTmp = array_merge($selected, $filtered);
		$lectureId = null;
		foreach ($visibleQuestions as $vq)
		{
			$qId = $vq[DbLayout::fieldQuestionId];
			$index = array_search($qId, $qTmp);
			if ($index !== false)
			{
				array_splice($qTmp, $index, 1);
				if ($lectureId === null)
				{
					$lectureId = $vq[DbLayout::fieldLectureId];
				}
				elseif ($lectureId !== $vq[DbLayout::fieldLectureId])
				{
					return $this->stop(ErrorCause::invalidInput('A test cannot contain questions from multiple lectures.', 'questions'));
				}
			}
		}
		if (count($qTmp))
		{
			return $this->stop(ErrorCause::invalidInput('Following question IDs are invalid or inaccessible: ' .
					implode(', ', $qTmp) . '.', 'questions'));
		}

		if (!$this->checkGenTestPrivs($lectureId))
			return;

		$randomized = $this->generateTest($questions, $count);

		if (!Core::sendDbRequest('addGenTest', $lectureId, $description, $questions,
				$count, implode(',', $randomized)))
			return $this->stopDb(false, ErrorEffect::dbAdd('test'));
		*/
	}
}

