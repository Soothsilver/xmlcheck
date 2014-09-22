<?php

namespace asm\plugin;

/**
 * Used by @ref Test "tests" to count occurences of certain elements in input.
 */
class CountedRequirements
{
	protected $descriptions = array();	///< descriptions of required elements
	protected $requirements = array();	///< quantities of element occurences required
	protected $counts = array();			///< element occurences counted so far
	protected $extras = array();			///< additional data used for occurence checking

	/**
	 * Initializes instance with descriptions and required quantities of elements.
	 * Requirement specifications must be supplied in array with special format:
	 * @code
	 * array(
	 *		'data' => array(
	 *			<REQUIREMENT_1_ID> => array(<REQUIREMENT_1_DESCRIPTION>, [<R1_ADDITIONAL_DATA_1>, ...]),
	 *			...
	 *		),
	 *		// following elements are optional (required minima default to 1)
	 *		'counts' => array(
	 *			<REQUIREMENT_1_ID> => <R1_REQUIRED_MINIMUM>,
	 *			...
	 *		),
	 *		'extras' => array(<ADDITIONAL_DATA_1_ID>, ...),
	 * )
	 * @endcode
	 * Only as many additional data of each requirement will be accessible as many
	 * elements there are in @c extras. Additional data elements will be indexed
	 * with IDs from @c extras and accessible using getExtra() method. If @c extras
	 * contain more than one element and some requirements don't come with as many
	 * additional data supplied, last additional data element value is returned for
	 * all IDs with missing values.
	 * Sample use:
	 * @code
	 * $reqs = new CountedRequirements(array(
	 *		'data' => array(
	 *			13 => array('uppercase letters used', '/[A-Z]/', 'this string will not be accessible'),
	 *			'foo' => array('PHP-like variable names used', '/$[a-zA-Z0-9]+/'),
	 *		),
	 *		'counts' => array(
	 *			13 => 5,
	 *		),
	 *		'extras' => array('regexp'),
	 * ));
	 * $text = "This is some input text $to $be $checked.";
	 * foreach ($reqs->getNames() as $name)
	 * {
	 *		preg_match($reqs->getExtra('regexp', $name), $text, $matches);
	 *		$reqs->addOccurences($name, count($matches[0]));
	 * }
	 * @endcode
	 * Above code could be used to count numbers of uppercase letters and PHP-like
	 * variable names used in input text. Use resolve() method to ascertain whether
	 * all requirements were met.
	 * @param array $config see method description for required format
	 */
	public function __construct ($config)
	{
		$this->ids = array_keys($config['data']);
		foreach ($config['data'] as $id => $data)
		{
			if (!is_array($data))
			{
				$data = array($data);
			}
			
			$this->descriptions[$id] = $data[0];
			$this->requirements[$id] = isset($config['counts'][$id]) ? $config['counts'][$id] : 1;
			$this->counts[$id] = 0;
			if (isset($config['extras']))
			{
				foreach ($config['extras'] as $i => $extraName)
				{
					if (!isset($this->extras[$extraName])) $this->extras[$extraName] = array();
					$this->extras[$extraName][$id] = isset($data[1 + $i]) ? $data[1 + $i] : $data[count($data) - 1];
				}
			}
		}
	}

	/**
	 * Raises number of occurences for selected requirement by 1.
	 * @param mixed $id requirement ID
	 * @see addOccurences()
	 */
	public function addOccurence ($id)
	{
		$this->addOccurences($id, 1);
	}

	/**
	 * Raises number of occurences for selected requirement by supplied number.
	 * @param mixed $id requirement ID
	 * @param int $count number of new occurences found
	 * @see addOccurence()
	 * @see tryRaiseCount()
	 */
	public function addOccurences ($id, $count)
	{
		$this->counts[$id] += $count;
	}

	/**
	 * Raises number of occurences for selected requirement if supplied number
	 * of occurences is bigger than the one currently set.
	 * Can be used for example in case there are more input files and at least
	 * one of them should contain at least required number of element occurences.
	 * @param mixed $id requirement ID
	 * @param int $count number of occurences counted this time
	 * @see addOccurences()
	 */
	public function tryRaiseCount ($id, $count)
	{
		if ($count > $this->counts[$id])
		{
			$this->counts[$id] = $count;
		}
	}

	/**
	 * Gets requirement IDs.
	 * @return array IDs of contained requirements
	 */
	public function getNames ()
	{
		return array_keys($this->counts);
	}

	/**
	 * Gets additional data with supplied key for selected requirement.
	 * @param string $extraName additional data key
	 * @param int $id requirement ID
	 * @return mixed additional data of selected requirement with @c $extraName ID
	 */
	public function getExtra ($extraName, $id)
	{
		return (isset($this->extras[$extraName][$id])
			? $this->extras[$extraName][$id]
			: null);
	}

	/**
	 * Checks whether all requirements have been met and returns appropriate info if not.
	 * Output arguments are set only if some requirements haven't been met and
	 * contain info about first of them.
	 * @param[out] string $description description of elements that haven't been found enough times
	 * @param[out] int $occured number of element occurences found
	 * @param[out] int $required minimum number required
	 * @return bool true if all requirements have been met, false otherwise
	 */
	public function resolve (&$description, &$occured, &$required)
	{
		foreach ($this->descriptions as $id => $text)
		{
			if ($this->counts[$id] < $this->requirements[$id])
			{
				$description = $text;
				$occured = $this->counts[$id];
				$required = $this->requirements[$id];
				return false;
			}
		}
		return true;
	}
}

?>