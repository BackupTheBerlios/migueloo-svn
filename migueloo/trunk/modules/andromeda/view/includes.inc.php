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
 * Include the phphtmllib libraries
 */
//This variable is necessary. Don`t delete next line. 
$phphtmllib = MIGUELBASE_PHPHTMLLIB; 
include_once($phphtmllib."/includes.inc");
include_once($phphtmllib."/form/includes.inc");

/**
 * Include the control libraries
 */
$viewlib = MIGUELBASE_DIR."view/classes/";
$includelib = MIGUELBASE_DIR."include/classes/";

//include($viewlib."base_element.class.php");
//include($viewlib."base_header.class.php");
//include($viewlib."base_footer.class.php");
//include($viewlib."base_layoutpage.class.php");
include($viewlib."base_formcontent.class.php");
include($viewlib."base_submitbutton.class.php");
include($viewlib."base_FETime.class.php");
include($viewlib."base_FEImgRadioGroup.class.php");
include($viewlib."base_FERadioGroup.class.php");

include_once($includelib."theme.class.php");

//Para tener la versión de phpHtmlLib usar la función
//   phphtmllib_get_version()  debe devolver un string
// del tipo '2.3.0'
?>
