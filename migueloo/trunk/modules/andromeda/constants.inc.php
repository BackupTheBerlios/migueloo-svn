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
 * Errores para errorHandler
 */
define ('FATAL', E_USER_ERROR);
define ('ERROR', E_USER_WARNING);
define ('WARNING', E_USER_NOTICE);

/**
 * Clase de Error
 */
define("USER_ERROR", 1);
define("BASE_ERROR", 2);
define("APP_ERROR", 3);

/**
 * Severidad del Error
 */
define('LOG_EMERG',    0);     /** System is unusable */
define('LOG_ALERT',    1);     /** Immediate action required */
define('LOG_CRIT',     2);     /** Critical conditions */
define('LOG_ERR',      3);     /** Error conditions */
define('LOG_WARNING',  4);     /** Warning conditions */
define('LOG_NOTICE',   5);     /** Normal but significant */
define('LOG_INFO',     6);     /** Informational */
define('LOG_DEBUG',    7);     /** Debug-level messages */

/**
 * Tipo de Error
 */
define("UNKNOWN", 0);
define("COULD_NOT_OPEN_FILE", 1);
define("COULD_NOT_CREATE_FILE", 2);
define("FILE_DOES_NOT_EXIST", 3);
//define("", "");
//define("", "");


//define("", "");



?>
