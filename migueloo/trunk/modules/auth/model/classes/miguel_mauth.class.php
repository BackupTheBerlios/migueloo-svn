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
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel auth
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_mAuth extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_mMain()
    {	
		$this->base_Model();
    }
    
    function getProfileList()
    {
    	//Get code cours
    	$profile = $this->Select('profile', 'id_profile, profile_description');
        //Debug::oneVar($this, __FILE__, __LINE__);
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	//Debug::oneVar($profile, __FILE__, __LINE__);
    	for ($i=0; $i < count($profile); $i++) {
			//$profiles = array("Alumno"=>5, "Profesor"=>1);	
    		$arr_profile[$profile[$i]['profile.profile_description']] = $profile[$i]['profile.id_profile'];
    	}
    	
    	return ($arr_profile);
    }
    
    function getTreatmentList()
    {
    	//Get code cours
    	$treatment = $this->Select('treatment', 'treatment_id, treatment_description');
        //Debug::oneVar($this, __FILE__, __LINE__);
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	//Debug::oneVar($treatment, __FILE__, __LINE__);
    	for ($i=0; $i < count($treatment); $i++) {
    	   if($treatment[$i]['treatment.treatment_description'] == ''){
    	       $treatment[$i]['treatment.treatment_description'] = 'none';
    	   }
    		$arr_treatment[$treatment[$i]['treatment.treatment_description']] = $treatment[$i]['treatment.treatment_id'];
    	}
    	
    	return ($arr_treatment);
    }
    
    function newUser($name, $surname, $treatment, $user, $theme, $lang, $passwd, $profile, $email)
    {
        $person = $this->_insertPerson($name, $surname, $treatment);
        $user = $this->_insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email);
    }
    
    function _insertPerson($name, $surname, $treatment)
    {
        $jabber = 'none';
        $cargo = 'none';

        $ret_val = $this->Insert('person',
                                 'person_jabber, person_name, person_surname, treatment_id, cargo',
                                 "$jabber, $name, $surname, $treatment, $cargo");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function _insertUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email)
    {
        $active = '1';
        $hash = '';
        $ret_val = $this->Insert('user',
                                 'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                                 "$user, $theme, $lang, $passwd, $active, $hash, 0, 0, 0, $person, $profile, $treatment, $email");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    /*
    function _userExists($sr_username)
    {
	$sel_val = $this->data->Select('user', "username", "username = $sr_username");

    	if ($this->data->hasError()) {
    		$sel_val = null;
    	}
	
	if(count($sel_val) > 0) {
		$ret_val = true;
	} else {
		$ret_val = false;
	}

    	return ($ret_val);    
    }
    
    
    function _getUserInfo($sr_user)
    {
	$ret_val = $this->data->Select('user', "user_id, nom, prenom", "user_id = $sr_user");

    	if ($this->data->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);    
    }
    
    
    
    function _getFacultes()
    {
    	$ret_val = $this->data->Select('faculte', "code, name");

    	if ($this->data->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function _getFaculteCoursNum($code)
    {
    	$ret_val = $this->data->SelectCount('cours_faculte', "faculte = $code");

    	if ($this->data->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val[0]["count(*)"]);
    }
    
    function getFaculteName($code)
    {
    	$ret_val = $this->data->Select('faculte', "name", "code = $code");
    	
    	if ($this->data->hasError()) {
    		$ret_val = null;
    	}
    	
    	$categoryelem[] = array ("code" => $code, "name" => $ret_val[0]["name"]);

    	return ($categoryelem);
    }
    
    function getFacultesResume()
    {
    	$faculte = $this->_getFacultes();
    	
    	if (is_array($faculte)) {
    		for ($i=0; $i < count($faculte); $i++) {
    			$num = $this->_getFaculteCoursNum($faculte[$i]["code"]);
    			if ($num != 0) {
					$categoryelem[]=array ("url" => app_URLPath("index.php"), 
										   "id" => $faculte[$i]["code"], 
										   "name" => $faculte[$i]["name"], 
										   "num" => $num);
				}
    		}
    		//echo "<pre>"; print_r($categoryelem); echo "</pre>";
    	}
    	
    	return $categoryelem;
    }
    */
}
