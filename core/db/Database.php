<?php

namespace asm\db;
use asm\core\Config;

/**
 * Main point of access to database @module.
 *
 * Database implementation used is completely hidden from the rest of the application.
 */
class Database
{
	const dbImpl = 'asm\db\MysqlDb';	///< class name of used database implementation

	protected static $dbImplInst = null;	///< database implementation class instance

	/**
	 * (Creates and) gets database implementation class instance.
	 *
	 * Data for class instance creation (server, credentials, db name) are taken
	 * from application configuration.
	 * @return IDbImpl database implementation class instance
	 * @see Config
	 */
	protected static function getDbImplInst ()
	{
		if (!self::$dbImplInst)
		{
			$dbImpl = self::dbImpl;
			$config = Config::get('database');
			self::$dbImplInst = new $dbImpl($config['host'], $config['user'],
					$config['pass'], $config['db']);
		}
		return self::$dbImplInst;
	}

	/**
	 * Handles database request from core.
	 * @param string $requestId request ID
	 * @param array $arguments request-specific arguments
	 * @return mixed multi-dimensional array 'table' with fields indexed with
	 *		@ref DbLayout "DbLayout::field*" constants for successful 'select'
	 *		requests, or boolean indicating success/failure
	 */
	public static function request ($requestId, $arguments)
	{
		$query = QueryManager::getQuery($requestId, $arguments);
		$result = self::getDbImplInst()->query($query);
		return QueryManager::translateResult($requestId, $result);
	}

	/**
	 * Gets error from last failed database request.
	 * @return string error message
	 */
	public static function getLastError ()
	{
		return self::getDbImplInst()->getLastError();
	}

    public static function sqlQuery ($queryString)
    {
        $result = self::getDbImplInst()->sqlQuery($queryString);
        return $result;
    }
    public static function getAffectedRows ()
    {
        $result = self::getDbImplInst()->getAffectedRows();
        return $result;
    }
}

