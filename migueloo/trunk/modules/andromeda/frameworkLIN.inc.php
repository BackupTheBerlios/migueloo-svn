<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       |
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/


/*******************************************************************************
*****
*****					MIGUEL FRAMEWORK CONFIGURATION
*****
*******************************************************************************/

define('MIGUELBASE_VERSION', '1.3.0'); /* Version information */

define('MIGUELBASE_MAINDIR', MIGUEL_MODULES_DIR);
define('MIGUELBASE_DIR', MIGUEL_MODULES_DIR.'andromeda/');
define('MIGUELBASE_URL', MIGUEL_URLDIR);
define('MIGUELBASE_MODULES_URL', MIGUEL_MODULES_URLDIR);
define('MIGUELBASE_MODULES_BASE', MIGUEL_MODULESPATH);

define('MIGUELBASE_PHPHTMLLIB', '/var/www/html/phphtmllib');
define('MIGUELBASE_ADODB', '/var/www/html/adodb_4.0.4');
define('MIGUELBASE_CACHEABLE', 0);
define('MIGUELBASE_LOG_ACTIVE', 1);
define('MIGUELBASE_LOG_TYPE', 'file');
define('MIGUELBASE_LOG_FILE', '/var/www/html/andromeda/var/temp/log/miguel.log');
define('MIGUELBASE_LOG_LEVEL', 'ERROR');
define('MIGUELBASE_SESSION_DIR', '/var/www/html/andromeda/var/temp/session');
define('MIGUELBASE_SESSION_TIME', 180);
define('MIGUELBASE_ERRORLOG_FILE', '/var/www/html/andromeda/var/temp/log/error.log');

define('MIGUELBASE_THEME_DIR', MIGUELTHEME_DIR);
define('MIGUELBASE_THEME_URLDIR', MIGUELTHEME_URLDIR);

include_once(MIGUELBASE_DIR.'defines.inc.php');
include_once(MIGUELBASE_DIR.'constants.inc.php');
include_once(MIGUELBASE_DIR.'util.class.php');

include_once(MIGUELBASE_DIR.'include/classes/file.class.php');
include_once(MIGUELBASE_DIR.'control/classes/registry.class.php');
include_once(MIGUELBASE_DIR.'control/classes/session.class.php');
include_once(MIGUELBASE_DIR.'control/classes/base_controller.class.php');
include_once(MIGUELBASE_DIR.'model/classes/base_model.class.php');
//Sólo para uso en desarrollo, valor a 1. Por defecto siempre 0.
//Se eliminará de las versiones estables. Si nos acordamos ;)).
define('MIGUELBASE_DEBUG', 1); /* Set Debug to 1 for more verbose output, 0 otherwise */
include_once(MIGUELBASE_DIR.'include/classes/debug.class.php');

?>
