<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
//include_once("../base/timecontrol.class.php");
//$timeck = new timeControl();
//include_once ($_SERVER['DOCUMENT_ROOT']."/andromeda/common/miguel_base.inc.php");
include_once ("../common/miguel_base.inc.php");
//$timeck->getInterval();
include_once (Util::app_Path("faculty/control/classes/miguel_cfaculty.class.php"));
//$timeck->getInterval();

$miguel = new miguel_CFaculty();
//$timeck->getInterval();
$miguel->Exec();
//$timeck->getInterval();

//dbg_var($timeck->seeResults());
//dbg_sessionVars();
//dbg_allVars();
//dbg_allClasses();

?>
