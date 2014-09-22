<?php

namespace asm\db;

/**
 * Database implementation interface.
 */
interface IDbImpl
{
	/**
	 * Sends supplied query to database.
	 * @param AbstractQuery $query abstract query (implementation-independent)
	 * @return mixed query result
	 */
	public function query (AbstractQuery $query);

    public function sqlQuery($stringQuery);

    public function getAffectedRows();

	/**
	 * Gets error for last failed database request.
	 * @return string error message
	 */
	public function getLastError ();
}

?>