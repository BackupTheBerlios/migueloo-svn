<?php
$config_base = '<?php
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


/*******************************************************************************
*****
*****					MIGUEL FRAMEWORK CONFIGURATION
*****
*******************************************************************************/

define(\'MIGUELBASE_VERSION\', \'1.3.0\'); /* Version information */

define(\'MIGUELBASE_MAINDIR\', MIGUEL_MODULES_DIR);
define(\'MIGUELBASE_DIR\', MIGUEL_MODULES_DIR.\''.$this->frameworkName.'\');
define(\'MIGUELBASE_URL\', MIGUEL_URLDIR);
define(\'MIGUELBASE_MODULES_URL\', MIGUEL_MODULES_URLDIR);
define(\'MIGUELBASE_MODULES_BASE\', MIGUEL_MODULESPATH);

define(\'MIGUELBASE_PHPHTMLLIB\', \''.$this->phphtmllib_path.'\');
define(\'MIGUELBASE_ADODB\', \''.$this->adodb_path.'\');';

$config_cache = '
define(\'MIGUELBASE_CACHEABLE\', '.$this->cacheable.');';
if($this->cacheable == '1') {
$config_cache .= '
define(\'MIGUELBASE_CACHE_TIME\', '.$this->cachetime.');';
$config_cache .= '
define(\'MIGUELBASE_CACHE_DIR\', \''.$this->cachepath.'\');';
}

$config_log = '
define(\'MIGUELBASE_LOG_ACTIVE\', '.$this->log.');';
if($this->log == '1') {
$config_log .= '
define(\'MIGUELBASE_LOG_TYPE\', \''.$this->logtype.'\');';
if($this->logtype == 'file'){
$config_log .= '
define(\'MIGUELBASE_LOG_FILE\', \''.$this->logpath.'\');';
}
if($this->logtype == 'adodb'){
$config_log .= '
define(\'MIGUELBASE_LOG_TABLE\', \''.$this->logtable.'\');';
}
$config_log .= '
define(\'MIGUELBASE_LOG_LEVEL\', \''.$this->loglevel.'\');';
}

$config_session = '
define(\'MIGUELBASE_SESSION_DIR\', \''.$this->sessionpath.'\');
define(\'MIGUELBASE_SESSION_TIME\', '.$this->sessiontime.');';

$config_defines = '
define(\'MIGUELBASE_ERRORLOG_FILE\', \''.$this->errorpath.'\');

define(\'MIGUELBASE_THEME_DIR\', MIGUELTHEME_DIR);
define(\'MIGUELBASE_THEME_URLDIR\', MIGUELTHEME_URLDIR);

include_once(MIGUELBASE_DIR.\'defines.inc.php\');
include_once(MIGUELBASE_DIR.\'util.class.php\');

include_once(MIGUELBASE_DIR.\'include/classes/file.class.php\');
include_once(MIGUELBASE_DIR.\'control/classes/registry.class.php\');
include_once(MIGUELBASE_DIR.\'control/classes/menubar.class.php\');
include_once(MIGUELBASE_DIR.\'control/classes/session.class.php\');
include_once(MIGUELBASE_DIR.\'control/classes/base_controller.class.php\');
include_once(MIGUELBASE_DIR.\'model/classes/base_model.class.php\');

?>';
?>
