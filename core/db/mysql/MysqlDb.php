<?php

namespace asm\db;

/**
 * Database implementation for MySQL databases.
 */
// TODO recently upgraded to mysqli Warning
final class MysqlDb implements IDbImpl
{
	protected $connection;	///< open connection to MySQL server

	/**
	 * Opens connection to MySQL server, select database, and forces UTF-8 for
	 * all future communication.
	 */
	public function __construct ($host, $user, $pass, $db)
	{
		$this->connection = mysqli_connect($host, $user, $pass, $db);
		mysqli_query($this->connection, "SET NAMES 'utf8'");
	}

    public function getAffectedRows()
    {
        return mysqli_affected_rows($this->connection);
    }

    public function sqlQuery($stringQuery)
    {
        $result = mysqli_query($this->connection, $stringQuery);
        return $this->parseResult($result);
    }

	public function query (AbstractQuery $query)
	{
		$queryString = (string)(new MysqlQuery($query));
		$result = mysqli_query($this->connection, $queryString);
		return $this->parseResult($result);
	}

	public function getLastError ()
	{
		return mysqli_error($this->connection);
	}

	/**
	 * Turns MySQL result resource to multi-dimensional array.
	 * @param mixed $result mysql result resource or boolean
	 * @return mixed translated @c $result (array) if it's a mysql result resource,
	 *		unchanged otherwise (translated array is simple array of associative
	 *		'table line' arrays)
	 */
	protected function parseResult ($result)
	{
		if (is_bool($result)) return $result;

		$ret = array();
		for ($i = mysqli_num_rows($result); $i; --$i)
		{
			$row = mysqli_fetch_assoc($result);
			$ret[] = array();
			foreach ($row as $key => $val)
			{
				$ret[count($ret) - 1][$key] = $val;
			}
		}
		return $ret;
	}
}

?>