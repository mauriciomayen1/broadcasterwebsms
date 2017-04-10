<?php
class Ns_QueryTool extends MDB_QueryTool 
{
	public 	$table			= '';
	public 	$primaryCol		= '';
	public 	$tableSpec		= '';
	public 	$sequenceName	= '';


	function __construct($dsn = array(), $table = '' ) 
	{
		parent::__construct($dsn, array(), 2);

		$this->db->loadModule('Reverse');
		$info = $this->db->reverse->tableInfo($table);

		$this->table 		= $table;
		$this->primaryCol	= $table . '_id';
		$this->sequenceName	= $table;
		$i = 0;
		$this->tableSpec = array();
		
		foreach($info as $k ) {
			$this->tableSpec[$i]['name']		= $k['name'];
			$this->tableSpec[$i]['shortName']	= ereg_replace($table.'_','',$k['name']);
			$i++;
		} // foreach($info as $k ) {
		
	} //function __construct($myDb_dsn, $table_name, $table_id)
	
    // {{{ add()

    /**
     * add a new member in the DB
     *
     * @param   array   contains the new data that shall be saved in the DB
     * @return  mixed   the inserted id on success, or false otherwise
     * @access  public
     */
    function add($newData)
    {
        // if no primary col is given, get next sequence value
        if (empty($newData[$this->primaryCol])) {
            if ($this->primaryCol) {
                // do only use the sequence if a primary column is given
                // otherwise the data are written as given
                $id = rand(0,9) . uniqid() . rand(0,9);
                $newData[$this->primaryCol] = $id;
            } else {
                // if no primary col is given return true on success
                $id = true;
            }
        } else {
            $id = $newData[$this->primaryCol];
        }

        //unset($newData[$this->primaryCol]);

        $newData = $this->_checkColumns($newData, 'add');
        $newData = $this->_quoteArray($newData);

        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($newData)),
            implode(', ', $newData)
        );
        return $this->execute($query, 'query') ? $id : false;
    }

    // }}}
    // {{{ addMultiple()

    /**
     * adds multiple new members in the DB
     *
     * @param   array   contains an array of new data that shall be saved in the DB
     *                  the key-value pairs have to be the same for all the data!!!
     * @return  mixed   the inserted ids on success, or false otherwise
     * @access  public
     */
    function addMultiple($data)
    {
        if (!sizeof($data)) {
            return false;
        }
        // the inserted ids which will be returned or if no primaryCol is given
        // we return true by default
        $retIds = $this->primaryCol ? array() : true;
        $allData = array();                     // each row that will be inserted
        foreach ($data as $key => $aData) {
            $aData = $this->_checkColumns($aData,'add');
            $aData = $this->_quoteArray($aData);

            if (empty($aData[$this->primaryCol])) {
                if ($this->primaryCol) {
                    // do only use the sequence if a primary column is given
                    // otherwise the data are written as given
                    $retIds[] = $id = rand(0,9) . uniqid() . rand(0,9);
                    $aData[$this->primaryCol] = $id;
                }
            } else {
                $retIds[] = $aData[$this->primaryCol];
            }
            $allData[] = '('.implode(', ', $aData).')';
        }

        $query = sprintf( 'INSERT INTO %s (%s) VALUES %s',
                          $this->table ,
                          implode(', ', array_keys($aData)) ,
                          implode(', ', $allData)
                        );
        return $this->execute($query, 'query') ? $retIds : false;
    }

    // }}}


} // class Ns_QueryTool extends NS_DB_QueryTool 


?>