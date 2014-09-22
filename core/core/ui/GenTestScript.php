<?php

namespace asm\core;
use asm\db\DbLayout;

abstract class GenTestScript extends LectureScript
{
	protected function parseQuestions ($questionString)
	{
		$q = explode(';', $questionString);
		return array(
			$q[0] ? explode(',', $q[0]) : array(),
			$q[1] ? explode(',', $q[1]) : array(),
		);
	}

	protected function generateTest ($template, $count)
	{
		list($selected, $filtered) = $this->parseQuestions($template);

		for ($i = $count - count($selected); $i; --$i)
		{
			$items = array_splice($filtered, rand(0, count($filtered) - 1), 1);
			array_push($selected, $items[0]);
		}

		$randomized = array();
		for ($j = count($selected); $j; --$j)
		{
			$items = array_splice($selected, rand(0, count($selected) - 1), 1);
			array_push($randomized, $items[0]);
		}

		return $randomized;
	}
}

?>