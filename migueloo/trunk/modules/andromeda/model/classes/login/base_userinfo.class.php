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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */
 
include_once(Util::app_Path("common/control/classes/base_login.php"));
 
class miguel_UserInfo
{
	/**
	 * Informa si el usuario es administrador a no.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function isAdmin(&$obj_model, $str_user)
    {
		$ret_sql = $obj_model->Select('admin', 'idUser', "idUser = $str_user");
		
    	if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   //dbg_var($ret_sql[0], __FILE__, __LINE__);
    	   if($ret_sql[0]["idUser"] == 1) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }
    
    /**
	 * Informa si el usuario/clave tiene acceso permitido.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @param string $str_password Clave del usuario.
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function hasAccess(&$obj_model, $str_user, $str_password)
    {
      $ret_sql = $obj_model->Select('user', 'password', "username = $str_user");

    	if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   //dbg_var($ret_sql[0], __FILE__, __LINE__);
    	   if($ret_sql[0]["password"] == $str_password) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }

    /**
	 * Obtiene toda la información de un usuario
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @return array Toda la información: user_id, nombre, email, nick, trato, idioma,...
	 */
    function getInfo(&$obj_model, $str_user)
    {
    	if($str_user == '') {
    	   $ret_val = array ( "user_id"           => '',
                            "name"          => '',
                            "surname"       => '',
                            "username"      => 'guest',
                            "password"      => '',
                            "email"         => '',
                            "statut"        => '',
                            "treatment"     => '',
                            "language"      => '',
                            "theme"         => '',
                            "profile"       => 'guest',
                            "isadmin"       => false);
    	} else {
            $ret_sql = $obj_model->Select('user',
                                          'user_id, nom, prenom, username, password, email, statut, idtreatment, language, theme, profile',
                                       "username = $str_user");
    	
    	   if ($obj_model->hasError()) {
    		  $ret_val = null;
    	   } else {
        	  //No incluimos información de la "tabla" o modelo de datos
                  $ret_val = array ( "user_id"       => $ret_sql[0]["user_id"],
        	                     "name"          => $ret_sql[0]["nom"],
        	                     "surname"       => $ret_sql[0]["prenom"],
        	                     "username"      => $ret_sql[0]["username"],
        	                     "password"      => $ret_sql[0]["password"],
        	                     "email"         => $ret_sql[0]["email"],
        	                     "statut"        => $ret_sql[0]["statut"],
        	                     "treatment"     => $ret_sql[0]["idtreatment"],
        	                     "language"      => $ret_sql[0]["language"],
                               "theme"         => $ret_sql[0]["theme"],
                               "profile"       => $ret_sql[0]["profile"]);
    	   }
 	  }

    return ($ret_val);
  }
  
  function processUser(&$obj_model, $str_username, $str_userpswd)
  {
    $ret_val = false;
    $obj_login = base_login::crearLogin();
    if($obj_login->login($obj_model, $str_username, $str_userpswd)) 
    {
      $arr_userinfo = $this->getInfo($obj_model, $str_username);
      $arr_userinfo["isadmin"] = $this->isAdmin($obj_model, $str_username);
      base_Controller::setSessionArray("userinfo", $arr_userinfo);
      $ret_val = true;
    }    
    return $ret_val;
  }
}
?>
