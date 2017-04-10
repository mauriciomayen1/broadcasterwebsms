<?php

class Ns_Db_Table_Abstract extends Zend_Db_Table_Abstract 
{
	public  function __construct($tableName)
	{        
		$db = Zend_Registry::get('db');
		self::$_defaultDb = self::_setupAdapter($db);
		
		if( $db instanceof Zend_Db_Adapter_Pdo_Mysql){
			$this->_name    = strtolower($tableName);
			$this->_primary = strtolower($tableName).'_id';
		}

		if( $db instanceof Zend_Db_Adapter_Pdo_Pgsql){
			$this->_name    = strtolower($tableName);
			$this->_primary = strtolower($tableName).'_id';
		}

		if( $db instanceof Zend_Db_Adapter_Pdo_Oci){
			$this->_name    = strtoupper($tableName);
			$this->_primary = strtoupper($tableName).'_ID';
		}

		if( $db instanceof Zend_Db_Adapter_Pdo_Mssql){
			$this->_name    = strtolower($tableName);
			$this->_primary = strtolower($tableName).'_id';
		}

        parent::__construct();
	}


    /**
     * Inserts a new row.
     *
     * @param  array  $data  Column-value pairs.
     * @return mixed         The primary key of the row inserted.
     */
    public function insert(array $data)
    {
        $this->_setupPrimaryKey();

        /**
         * Zend_Db_Table assumes that if you have a compound primary key
         * and one of the columns in the key uses a sequence,
         * it's the _first_ column in the compound key.
         */
        $primary = (array) $this->_primary;
        $pkIdentity = $primary[(int)$this->_identity];
        /**
         * If this table uses a database sequence object and the data does not
         * specify a value, then get the next ID from the sequence and add it
         * to the row.  We assume that only the first column in a compound
         * primary key takes a value from a sequence.
         */
        if (is_string($this->_sequence) && !isset($data[$pkIdentity])) {
            $data[$pkIdentity] = $this->_db->nextSequenceId($this->_sequence);
        }

        /**
         * If the primary key can be generated automatically, and no value was
         * specified in the user-supplied data, then omit it from the tuple.
         */
        if (array_key_exists($pkIdentity, $data) && $data[$pkIdentity] === null) {
            unset($data[$pkIdentity]);
        }


        /**
         * INSERT the new row.
         */
        $tableSpec = ($this->_schema ? $this->_schema . '.' : '') . $this->_name;
        /**
         * INICIO NUESTROSITE 
         */

		$this->_setupMetadata();
		
		foreach($data as $key => $value) {
			if (!array_key_exists($key, $this->_metadata)) {
				unset($data[$key]);
			}
		}

		$data[$pkIdentity] = rand(0,9) . uniqid() . rand(0,9);

        /**
         * FIN NUESTROSITE 
         */
		
        $this->_db->insert($tableSpec, $data);

        /**
         * Fetch the most recent ID generated by an auto-increment
         * or IDENTITY column, unless the user has specified a value,
         * overriding the auto-increment mechanism.
         */
        if ($this->_sequence === true && !isset($data[$pkIdentity])) {
            $data[$pkIdentity] = $this->_db->lastInsertId();
        }

        /**
         * Return the primary key value if the PK is a single column,
         * else return an associative array of the PK column/value pairs.
         */
        $pkData = array_intersect_key($data, array_flip($primary));
        if (count($primary) == 1) {
            reset($pkData);
            return current($pkData);
        }

        return $pkData;
    }
	
    /**
     * Updates existing rows.
     *
     * @param  array        $data  Column-value pairs.
     * @param  array|string $where An SQL WHERE clause, or an array of SQL WHERE clauses.
     * @return int          The number of rows updated.
     */
    public function update(array $data, $where)
    {
        $tableSpec = ($this->_schema ? $this->_schema . '.' : '') . $this->_name;
        /**
         * INICIO NUESTROSITE 
         */

		$this->_setupMetadata();
		
		foreach($data as $key => $value) {
			if (!array_key_exists($key, $this->_metadata)) {
				unset($data[$key]);
			}
		}

        /**
         * FIN NUESTROSITE 
         */
		
        return $this->_db->update($tableSpec, $data, $where);
    }
	


}

?>