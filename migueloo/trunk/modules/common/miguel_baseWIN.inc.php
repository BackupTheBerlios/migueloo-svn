<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 by miguel Development Team                   |
      |   This file was generate by script setup.php                         |
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

/***************************************************************************************************
*****
*****					MIGUEL BASE CONFIGURATION
*****
***************************************************************************************************/
define('MIGUEL_LOCALPATH', 'andromeda');

define('MIGUEL_APPDIR', 'e:/unidadej/www'.'/'.MIGUEL_LOCALPATH.'/');
define('MIGUEL_MODULESPATH', MIGUEL_LOCALPATH.'/modules/');
define('MIGUEL_MODULES_DIR',MIGUEL_APPDIR.'modules/');
define('MIGUEL_URLDIR', 'http://'.$_SERVER['SERVER_NAME'].'/'.MIGUEL_LOCALPATH.'/');
define('MIGUEL_MODULES_URLDIR',MIGUEL_URLDIR.'modules/');

define('MIGUELGETTEXT_DIR', MIGUEL_MODULES_DIR.'/gettext/');
define('MIGUELTHEME_DIR', MIGUEL_APPDIR.'var/themes/');
define('MIGUELTHEME_URLDIR', MIGUEL_URLDIR.'var/themes/');

define('CONFIG_FILE',MIGUEL_MODULES_DIR.'common/include/config.xml');
/* Include the framework libraries */
include_once(MIGUEL_MODULES_DIR.'andromeda/framework.inc.php');
include_once(MIGUEL_MODULES_DIR.'common/control/classes/miguel_controller.class.php');
?>
