<?php
/*
      +----------------------------------------------------------------------+
      | Miguel common                                                        |
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
      | Authors: Guillermo Halys Ortuño    <yursoft@yursoft.com>             |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase de login a traves de una BBDD con password encriptado con MD5
 *
 * @author Guillermo Halys Ortuño <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */ 
 
 // ESTE INCLUDE ELIMINARLO YA QUE ES DE PRUEBAS
//include_once ('../../../common/miguel_base.inc.php');
include_once(Util::app_Path('common/control/classes/base_loginbase.php'));
 
class base_loginMD5 extends base_loginBase
{
  function base_loginMD5()
  {
    $this->base_loginBase();
  }
  
  function _encrypt($str_userpswd)
  {        
    return md5($str_userpswd);    
  }  
  
  function login($obj_model, $str_username, $str_userpswd)
  {
    $ret_sql = $obj_model->Select('user', 'password', "username = $str_username");

  	if ($obj_model->hasError()) {
  		$ret_val = false;
  	} else {
  	   //dbg_var($ret_sql[0], __FILE__, __LINE__);
      
  	   if($ret_sql[0]['password'] == $this->_encrypt($str_userpswd)) {
  	       $ret_val = true;
  	   } else {
  	       $ret_val = false;
  	   }
  	}    	

  	return ($ret_val);  
  }
}

?>
