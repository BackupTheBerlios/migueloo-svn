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
      | Authors: Guillermo Halys Ortuño    <yursoft@yursoft.com>             |
	  |          Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage model
 */
/**
 *
 */ 

/**
 * Define la clase de login a traves de una BBDD con password encriptado con MCRYPT
 *
 * @author Guillermo Halys Ortuño <yursoft@yursoft.com>
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */ 
 
 // IMPORTANTISIMO HAY QUE TENER ACTIVADA LA EXTENSION MCRYPT.DLL PARA TRABAJAR
 // CON ESTE MODULO
include_once(Util::app_Path('common/control/classes/base_loginbase.php'));
 
class base_loginMCRYPT extends base_loginBase
{
  var $str_typeencrypt = '';
  
  function base_loginMCRYPT($str_tencrypt)
  {
    $this->base_loginBase();
    $this->str_typeencrypt = strtolower($str_tencrypt);
  }
  
  function _encrypt($str_username, $str_userpswd)
  {   
    $iv_tam = mcrypt_get_iv_size($this->str_typeencrypt, MCRYPT_MODE_ECB); //MCRYPT_RIJNDAEL_256
    $iv = mcrypt_create_iv($iv_tam, MCRYPT_RAND);
    $llave = md5($str_username);
    $texto = $str_userpswd;

    $ret_valor = mcrypt_encrypt($this->str_typeencrypt, $llave, $texto, MCRYPT_MODE_ECB, $iv);
    $ret_valor = base64_encode($ret_valor);

    return $ret_valor;
  }    
  
  function login($obj_model, $str_username, $str_userpswd)
  {
    $ret_sql = $obj_model->Select('user', 'password', "username = $str_username");

  	if ($obj_model->hasError()) {
  		$ret_val = false;
  	} else {
  	   //dbg_var($ret_sql[0], __FILE__, __LINE__);
  	   if($ret_sql[0]['password'] == $this->_encrypt($str_username, $str_userpswd)) {
  	       $ret_val = true;
  	   } else {
  	       $ret_val = false;
  	   }
  	}    	

  	return ($ret_val);  
  }
}

?>
