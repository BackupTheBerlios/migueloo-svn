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
 * @author Antonio Gutiérrez Mayoral <agutierr@gsyc.escet.urjc.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */
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
        $ret_sql = $obj_model->Select('user', 'id_profile', 'user_alias = ' . $str_user);
        if ($obj_model->hasError()) {
           $ret_val = null;
    	} else {
    	   if($ret_sql[0]['user.id_profile'] == 1) {
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
		$ret_sql = $obj_model->Select('user', 'user_password', 'user_alias = ' . $str_user);

        if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   if($ret_sql[0]['user.user_password'] == $str_password) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }

    /**
	 * Obtiene toda la informaciÃ›n de un usuario
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @return array Toda la informaciÃ›n: nombre, email, nick, trato, idioma,...
	 */
    function getInfo(&$obj_model, $str_user)
    {

        if($str_user == '') {
    	   $ret_val = array ( 'name'          => '',
                              'surname'       => '',
                              'user_alias'    => 'guest',
                              'email'         => '',
                              'profile_id'    => 6,
                              'treatment'     => '',
                              'language'      => '',
                              'theme'         => '',
                              'profile'       => 'guest',
                              'isadmin'       => false);
    	} else {
            $ret_sql = $obj_model->SelectMultiTable('user, person, treatment, profile', 
                                                    'user.user_id, user.user_alias, user.email, user.user_notify_email, user.theme, user.language, user.id_profile, treatment.treatment_description, person.person_name, person.person_surname, profile.profile_description',
                                                    'user.user_alias = ' . $str_user . ' AND user.person_id = person.person_id AND user.treatment_id = treatment.treatment_id AND user.id_profile = profile.id_profile');

    	   if ($obj_model->hasError()) {
    		  $ret_val = null;
    	   } else {
        	  //No incluimos informaciÃ›n de la "tabla" o modelo de datos
        	  $ret_val = array ( 'user_id'       => $ret_sql[0]['user.user_id'],
                               'name'          => $ret_sql[0]['person.person_name'],
        	                     'surname'       => $ret_sql[0]['person.person_surname'],
        	                     'user_alias'    => $ret_sql[0]['user.user_alias'],
        	                     'email'         => $ret_sql[0]['user.email'],
        	                     'profile_id'    => $ret_sql[0]['user.id_profile'],
                               'profile'       => $ret_sql[0]['profile.profile_description'],
        	                     'treatment'     => $ret_sql[0]['treatment.treatment_description'],
        	                     'language'      => $ret_sql[0]['user.language'],
                               'theme'         => $ret_sql[0]['user.theme'],
                               'notify_email'  => $ret_sql[0]['user.user_notify_email']);
    	   }
 	}
		miguel_UserInfo::prepareTheme($ret_val['theme']);
    	return ($ret_val);
    }

    /**
	 * Inserta en la tabla de accesos un nuevo registro
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $user Identificador de usuario (nickname).
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function setLogin(&$obj_model, $user, $type = 1)
    {
		$ret_select = $obj_model->Select('user', 'user_id', "user_alias = $user");

    	if ($obj_model->hasError()) {
    		$ret_val = false;
    	} else {
    		$userId = $ret_select[0]['user.user_id'];
			$now = date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];
			if($type == 1) {
				$log = 'LOGIN';
			} else {
				$log = 'LOGOUT';
			}
		
			$ret_sql = $obj_model->Insert('loginout', 'id_user, ip, log_when, log_action', "$userId, $ip, $now, $log");
            
    		if ($obj_model->hasError()) {
    			$ret_val = false;
    		} else {
    		   $ret_val = true;
    		}
			
			//Modificado para la demo/maqueta
			if($type == 1) {
				$ret_sql = $obj_model->Select('user_logged', 'user_id', "user_id = $userId");
				
				if ($obj_model->hasError()) {
					$ret_val = false;
				} else {
					if($ret_sql[0]['user_logged.user_id'] == null) {
						$ret_sql = $obj_model->Insert('user_logged', 'user_id, is_logged', "$userId, 1");
					}
				}
				
			} else {
				$ret_sql = $obj_model->Delete('user_logged', "user_id = $userId");
			}
            
    		if ($obj_model->hasError()) {
    			$ret_val = false;
    		} else {
    		   $ret_val = true;
    		}    	
		}
    	return ($ret_val);
    }

	/**
	 * Devuelve el rol asociado al usuario que inició la sesión.
	 * @param base_model $obj_model Instancia de un modelo.
	 * @param int $user_id Identificador de usuario.
	 * @return int Devuelve el role o profile asociado a un usuario.
	 *
	 **/
   
	function getRole(&$obj_model, $user_id)

	{
		$ret_sql = $obj_model->Select('user','id_profile', 'user_id = ' . $user_id);

		if ($obj_model->hasError()) {
			$ret_val = null;
		} else {
			$ret_val = $ret_sql[0]['user.id_profile'];
		}

		return ($ret_val);
	}
	
	function isLogged(&$obj_model, $str_user)
	{
		//Bloqueado para la demo/maqueta
		/*
		$log_sql = $obj_model->SelectMultiTable('user, user_logged', 'user_logged.is_logged', 'user.user_id = user_logged.user_id AND user.user_alias = '.$str_user);
		
		if ($obj_model->hasError()) {
			$ret_val = null;
		} else {
			//Debug::oneVar($log_sql, __FILE__, __LINE__);
			if($log_sql[0]['user_logged.is_logged'] == null){
				$ret_val = true;
			} else {
				$ret_val = false;
			}	
		}
		*/
		//Eliminar siguiente
		$ret_val = true;
		
		return $ret_val;
	}

	function prepareTheme($theme)
	{
		include_once(Util::base_Path('include/classes/theme.class.php'));
		//Comprobamos si el tema existe
		if(!Theme::existTheme($theme)){
			$theme = Session::getContextValue('theme');
		}
		//Configuración theme
		$file = MIGUELBASE_THEME_DIR.$theme.'/theme.xml';

        if(file_exists($file)) {
		  miguel_UserInfo::_processXMLInitData($file);
		} else {
			$this->_setError("miguel_UserInfo:: el tema visual no está configurado");
		}
	}

	/*
	 * Procesa el fichero de configuración
	 * El fichero de configuración está en formato XML.
	 * @param string $str_fileName Nombre del fichero de configuración
	 * @internal
	 *
	 */
  	function _processXMLInitData($str_fileName)
	{
		//Include XMLMini
		require_once (MIGUELBASE_MINIXML.'/minixml.inc.php');
		
		//Abrimos el fichero
		$xml_obj = new MiniXMLDoc();

		//Procesamos el contenido
		$xml_obj->fromFile($str_fileName);

		//Cargamos la variable
		$xml_root 		=& $xml_obj->getElementByPath('config');
		$xml_elements 	=& $xml_root->getAllChildren();

		for ($i=0; $i < $xml_root->numChildren(); $i++) {
			$_SESSION["CONTEXT"]["MIGUEL_".strtoupper($xml_elements[$i]->name())] = $xml_elements[$i]->getValue();
		}

		//Cerramos el fichero
		unset($xml_obj);
	}

}
?>
