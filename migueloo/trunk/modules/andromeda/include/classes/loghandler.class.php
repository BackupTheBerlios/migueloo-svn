<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
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
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage include
 */
/**
 *
 */
require_once (MIGUELBASE_DIR.'include/Log-PEAR/Log.php');  
/**
 * Define la clase para trabajar con el sistema de Log.
 * Se plantea un manejador del sistema de logs, basado en la clase Log de PEAR.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */
 
class LogHandler
{
	/**
     * Inserta en el Log el mensaje.
     * @param string $message Mensaje a guardar en el Log
     * @param string $ident   Identificador de 'usuario'.
     * @param string $priority Nivel de log
     */
	function log($message, $ident, $priority = PEAR_LOG_WARNING)
	{
		if(MIGUELBASE_LOG_ACTIVE) {
			switch (MIGUELBASE_LOG_TYPE) {
        	    case 'file':
                	$conf = array('mode' => 0600, 'timeFormat' => '%Y/%m/%d %H:%M:%S');
					$logger = &Log::singleton('file', MIGUELBASE_LOG_FILE, 'miguelOO_'.$ident, $conf);
              		break;
      	      	case 'adodb':
           	 		$db_conf = array('ddbbSgbd' =>Session::getContextValue('ddbbSgbd'),
        	    					 'ddbbServer' => Session::getContextValue('ddbbServer'),
						    		 'ddbbUser' => Session::getContextValue('ddbbUser'),
						    		 'ddbbPassword' => Session::getContextValue('ddbbPassword'),
						    		 'ddbbMainDb' => Session::getContextValue('ddbbMainDb'));
        	    	$conf = array('dsn' => $db_conf);
					$logger = &Log::singleton('adodb', MIGUELBASE_LOG_TABLE, 'miguelOO_'.$ident, $conf);
        	    	break;
        	    default:
        	        $logger = &Log::singleton('error_log', 0, 'miguelOO_'.$ident);
        	}
        	
        	switch (MIGUELBASE_LOG_LEVEL) {
        		case 'ALL':
        			$mask = Log::UPTO(PEAR_LOG_DEBUG);
        			break;
        	    case 'EMERG':
        	        $mask = Log::UPTO(PEAR_LOG_EMERG);
        	        break;
        	    case 'ALERT':
        	        $mask = Log::UPTO(PEAR_LOG_ALERT);
        	        break;
        	    case 'CRITIC':
        	        $mask = Log::UPTO(PEAR_LOG_CRIT);
        	        break;
        	    case 'ERROR':
        	        $mask = Log::UPTO(PEAR_LOG_ERR);
        	        break;
        	    case 'WARNING':
        	        $mask = Log::UPTO(PEAR_LOG_WARNING);
        	        break;
        	    case 'NOTICE':
        	        $mask = Log::UPTO(PEAR_LOG_NOTICE);
        	        break;
        	    case 'INFO':
        	        $mask = Log::UPTO(PEAR_LOG_INFO);
        	        break;
        	    case 'DEBUG':
        	        $mask = Log::UPTO(PEAR_LOG_DEBUG);
        	        break;                        
        	    default:
        	        $mask = PEAR_LOG_NONE;
        	}
       
   			$logger->setMask($mask);
   			//Debug::oneVar($logger,__FILE__,__LINE__);
			$logger->log($message, $priority);
		}
	}
}
