<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, miguel Development Team                          |
      +----------------------------------------------------------------------+
      |   This program is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU General Public License        |
      |   as published by the Free Software Foundation; either version 2     |
      |   of the License, or (at your option) any later version.             |
      |                                                                      |
      |   This program is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
      |   GNU General Public License for more details.                       |
      |                                                                      |
      |   You should have received a copy of the GNU General Public License  |
      |   along with this program; if not, write to the Free Software        |
      |   Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA          |
      |   02111-1307, USA. The GNU GPL license is also available through     |
      |   the world-wide-web at http://www.gnu.org/copyleft/gpl.html         |
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Log system.
 * @package include
 * @subpackage log
 */
 /**
 *
 */
//* ADOdb DB package */
include_once(LOG_ADODB.'/adodb.inc.php');

/**
 * The Log_adodb class is a concrete implementation of the Log::
 * abstract class which sends messages to an SQL server using ADOdb interface.  
 * Each entry occupies a separate row in the database.
 *
 * This implementation uses ADOdb database abstraction layer.
 *
 * CREATE TABLE log_table (
 *  id          INT NOT NULL auto_increment,
 *  logtime     TIMESTAMP NOT NULL,
 *  ident       CHAR(30) NOT NULL,
 *  priority    INT NOT NULL,
 *  message     VARCHAR(200),
 *  PRIMARY KEY (id)
 * );
 *
 * This class is derived from sql.php file in PEAR Log package
 * @author  Jon Parise <jon@php.net>
 *
 * @author  Jesús Martínez <jamarcer@inicia.es>
 * @since   Miguel 1.0
 * @package Log
 */
class Log_adodb extends Log {

    /** 
     * Array containing the dsn information. 
     * @var string
     * @access private
     */
    var $_dsn = '';

    /** 
     * Object holding the database handle. 
     * @var object
     * @access private
     */
    var $_db = null;

    /**
     * Flag indicating that we're using an existing database connection.
     * @var boolean
     * @access private
     */
    var $_existingConnection = false;

    /** 
     * String holding the database table to use. 
     * @var string
     * @access private
     */
    var $_table = 'log_table';


    /**
     * Constructs a new sql logging object.
     *
     * @param string $name         The target SQL table.
     * @param string $ident        The identification field.
     * @param array $conf          The connection configuration array.
     * @param int $level           Log messages up to and including this level.
     * @access public     
     */
    function Log_adodb($name, $ident = '', $conf = array(),
                     $level = PEAR_LOG_DEBUG)
    {
        $this->_id = md5(microtime());
        $this->_table = $name;
        $this->_ident = $ident;
        $this->_mask = Log::UPTO($level);

        /* If an existing database connection was provided, use it. */
        if (isset($conf['db'])) {
            $this->_db = &$conf['db'];
            $this->_existingConnection = true;
            $this->_opened = true;
        } else {
            $this->_dsn = $conf['dsn'];
        }
    }

    /**
     * Opens a connection to the database, if it has not already
     * been opened. This is implicitly called by log(), if necessary.
     *
     * @return boolean   True on success, false on failure.
     * @access public     
     */
    function open()
    {
        if (!$this->_opened) {
        	$this->_db = &ADONewConnection($this->_dsn['ddbbSgbd']);
     	
			$this->_db->PConnect($this->_dsn['ddbbServer'],
					    $this->_dsn['ddbbUser'],
					    $this->_dsn['ddbbPassword'],
					    $this->_dsn['ddbbMainDb']);

			if($this->_db->ErrorMsg() != '' ) {
			    return false;
			}
			
            $this->_opened = true;
        }

        return $this->_opened;
    }

    /**
     * Closes the connection to the database if it is still open and we were
     * the ones that opened it.  It is the caller's responsible to close an
     * existing connection that was passed to us via $conf['db'].
     *
     * @return boolean   True on success, false on failure.
     * @access public     
     */
    function close()
    {
        if ($this->_opened && !$this->_existingConnection) {
            $this->_opened = false;
            return $this->_db->Close();
        }

        return ($this->_opened === false);
    }

    /**
     * Inserts $message to the currently open database.  Calls open(),
     * if necessary.  Also passes the message along to any Log_observer
     * instances that are observing this Log.
     *
     * @param mixed  $message  String or object containing the message to log.
     * @param string $priority The priority of the message.  Valid
     *                  values are: PEAR_LOG_EMERG, PEAR_LOG_ALERT,
     *                  PEAR_LOG_CRIT, PEAR_LOG_ERR, PEAR_LOG_WARNING,
     *                  PEAR_LOG_NOTICE, PEAR_LOG_INFO, and PEAR_LOG_DEBUG.
     * @return boolean  True on success or false on failure.
     * @access public     
     */
    function log($message, $priority = null)
    {
        /* If a priority hasn't been specified, use the default value. */
        if ($priority === null) {
            $priority = $this->_priority;
        }

        /* Abort early if the priority is above the maximum logging level. */
        if (!$this->_isMasked($priority)) {
            return false;
        }

        /* If the connection isn't open and can't be opened, return failure. */
        if (!$this->_opened && !$this->open()) {
            return false;
        }

        /* Extract the string representation of the message. */
        $message = $this->_extractMessage($message);

        /* Build the SQL query for this log entry insertion. */
        $q = sprintf('insert into %s (logtime, ident, priority, message)' .
                     'values(%s, %s, %d, %s)',
                     $this->_table, $this->_db->DBTimeStamp(time()),$this->_db->Quote($this->_ident),
                     $priority, $this->_db->Quote($message));
                     

        $result = $this->_db->Execute($q);
        if ($this->_db->ErrorMsg() != '') {
            return false;
        }

        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }
}

?>
