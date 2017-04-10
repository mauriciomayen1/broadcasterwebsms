<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the MDB_QueryTool_EasyJoin class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Database
 * @package    MDB_QueryTool
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @copyright  2003-2006 Lorenzo Alberton
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version    CVS: $Id: EasyJoin.php,v 1.12 2006/03/28 16:43:32 lsmith Exp $
 * @link       http://pear.php.net/package/MDB_QueryTool
 */

/**
 * require the MDB_QueryTool_Query class
 */
require_once 'MDB/QueryTool/Query.php';

/**
 * MDB_QueryTool_EasyJoin class
 *
 * @category   Database
 * @package    MDB_QueryTool
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @copyright  2003-2006 Lorenzo Alberton
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link       http://pear.php.net/package/MDB_QueryTool
 */
class MDB_QueryTool_EasyJoin extends MDB_QueryTool_Query
{
    // {{{ class vars

    /**
     * this is the regular expression that shall be used to find a table's
     * shortName in a column name, the string found by using this regular
     * expression will be removed from the column name and it will be checked
     * if it is a table name i.e. the default '/_id$/' would find the table name
     * 'user' from the column name 'user_id'
     */
    var $_tableNamePreg = '/_id$/';

    /**
     * this is to find the column name that is refered by it, so the default
     * find from 'user_id' the column 'id' which will be used to refer to the
     * 'user' table
     */
    var $_columnNamePreg = '/^.*_/';

    // }}}
    // {{{ __construct()

    /**
     * call parent constructor
     * @param mixed $dsn DSN string, DSN array or MDB object
     * @param array $options
     * @param integer $version
     */
    function __construct($dsn=false, $options=array(), $version = 1)
    {
        parent::MDB_QueryTool_Query($dsn, $options, $version);
    }

    // }}}
    // {{{ autoJoin()

    /**
     * join the tables given, using the column names, to find out how to join
     * the tables this is, if table1 has a column names table2_id this method
     * will join WHERE table1.table2_id=table2.id
     * all joins made here are only concatenated via AND
     */
    function autoJoin($tables)
    {
// FIXXME if $tables is empty, autoJoin all available tables that have a relation
// to $this->table, starting to search in $this->table
        settype($tables, 'array');
        // add this->table to the tables array, so we go thru the current table first
        $tables = array_merge(array($this->table), $tables);

        $shortNameIndexed = $this->getTableSpec(true,  $tables);
        $nameIndexed      = $this->getTableSpec(false, $tables);

//print_r($shortNameIndexed);
//print_r($tables);        print '<br /> <br />';
        if (sizeof($shortNameIndexed) != sizeof($tables)) {
            $this->_errorLog('autoJoin-ERROR: not all the tables are in the tableSpec!<br />');
        }
        $joinTables     = array();
        $joinConditions = array();
        foreach ($tables as $aTable) {
            // go through $this->table and all the given tables
            if ($metadata = $this->metadata($aTable)) {
                foreach ($metadata as $aCol => $x) {
                    // go through each row to check which might be related to $aTable
                    $possibleTableShortName = preg_replace($this->_tableNamePreg,  '', $aCol);
                    $possibleColumnName     = preg_replace($this->_columnNamePreg, '', $aCol);
//print "$aTable.$aCol .... possibleTableShortName=$possibleTableShortName .... possibleColumnName=$possibleColumnName<br />";
                    if (!empty($shortNameIndexed[$possibleTableShortName])) {
                        // are the tables given in the tableSpec?
                        if (!$shortNameIndexed[$possibleTableShortName]['name'] ||
                           !$nameIndexed[$aTable]['name'])
                        {
                            // its an error of the developer, so log the error, dont show it to the end user
                            $this->_errorLog("autoJoin-ERROR: '$aTable' is not given in the tableSpec!<br />");
                        } else {
                            // do only join different table.col combination,
                            // we should not join stuff like 'question.question=question.question' this would be quite stupid, but it used to be :-(
                            if ($shortNameIndexed[$possibleTableShortName]['name'] != $aTable ||
                                $possibleColumnName != $aCol
                            ) {
                                $where = $shortNameIndexed[$possibleTableShortName]['name'].".$possibleColumnName=$aTable.$aCol";
                                $this->addJoin($nameIndexed[$aTable]['name'],                      $where);
                                $this->addJoin($shortNameIndexed[$possibleTableShortName]['name'], $where);
                            }
                        }
                    }
                }
            }
        }
    }

    // }}}
}
?>