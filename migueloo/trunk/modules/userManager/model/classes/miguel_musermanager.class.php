<?php
/*
      +----------------------------------------------------------------------+
      |userManager/model                                                     |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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
class miguel_MUserManager extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MUserManager()
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
    
    function newInscription($nif, $name, $surname1, $surname2, $calle, $localidad, $provincia, $pais, $cp, $telefono, $telefono2, $fax, $email, $email2, $email3, $web, $notes, $imagen, $cv_doc, $profile)
    {
        $person = $this->_insertPerson($nif,$name, $surname1, $surname2);
        if ($person!=null)
        {
        	$person_data = $this->_insertPersonData($person, $calle, $localidad, $provincia, $email, $email2, $email3, $pais, $cp, $telefono, $telefono2, $fax, $web, $notes, $imagen, $cv_doc);
			
			$nick = strtolower(substr($name,0,1).$surname1.substr($surname2,0,1));
			if(strlen($nick) > 10){
				$nick = substr($nick, 0, 10);
			}

			$user = $this->_insertUser($person, $nick, $profile);
        }
        return $person;
    }
    
    //function _insertPerson($name, $surname, $treatment)
    function _insertPerson($dni, $name, $surname1, $surname2)
    {
		$ret_val = $this->Insert('person',
							'person_dni, person_name, person_surname, person_surname2',
							"$dni, $name, $surname1, $surname2");
		
		if ($this->hasError()) {
			$ret_val = null;
		}
		
		return $ret_val;
    }
    
    function _insertPersonData($person, $calle, $localidad, $provincia, $email, $email2, $email3, $pais, $cp, $telefono, $telefono2, $fax, $web, $notes, $imagen, $cv_doc)
    {	
        $ret_val = $this->Insert('person_data',
                                 'person_id, street, city, council, country, postalcode, phone, phone2, fax, email, email2, email3, web, notes, image, cv',
                                 array($person, $calle, $localidad, $provincia, $pais, $cp, $telefono, $telefono2, $fax, $email, $email2, $email3, $web, $notes, $imagen, $cv_doc));

    	if ($this->hasError()) {
	    	$ret_val = null;
  	  	}

    	return $ret_val;
    }
	
	function _insertUser($person, $user, $profile)
    {
        $active = '1';
        $hash = '';
		$theme = 'ups';
		$lang = 'es_ES';
		$passwd = Util::newPasswd(10);
		$treatment = 1;
		$email = '';
		
        $ret_val = $this->Insert('user',
                                 'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                                 "$user, $theme, $lang, $passwd, $active, $hash, 0, 0, 0, $person, $profile, $treatment, $email");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }

	function getUserList($_profile = 4, $_search_type = 0, $_search_value = '')
    {
		$ret_val = array();
		
		switch($_search_type){
			case 1:
				$where_cond = 'and person.person_name LIKE %'.$_search_value.'%'; //LIKE '%value%';
				break;
			case 2:
				$where_cond = 'and ( person.person_surname LIKE %'.$_search_value.'%';
				$where_cond .= ' or person.person_surname2 LIKE %'.$_search_value.'% )';
				break;
			case 3:
				$where_cond = 'and person.person_dni LIKE %'.$_search_value.'%';
				break;
			case 4:
				//$where_cond = 'course.course_id = '.$_search_value;
				break;
			case 5:
				$where_cond = 'and user.user_alias LIKE %'.$_search_value.'%';
				break;
			default:
				$where_cond = '';
				break;
		}
		
		/*
		$sql_ret = $this->SelectMultiTable('person, person_data, user', 
											'person.person_dni, person.person_name, person.person_surname, person.person_surname2, 
											person_data.street, person_data.city, person_data.council, person_data.country, 
											person_data.postalcode, person_data.phone, person_data.phone2, person_data.fax,
											person_data.email, person_data.email2, person_data.email3, person_data.web,
											person_data.notes, person_data.image, person_data.cv,
											user.user_alias, user.user_password',
											"person.person_id = person_data.person_id and person.person_id = user.person_id $where_cond");
        */

		$sql_ret = $this->SelectMultiTable('person, person_data, user', 
											'person.person_dni, person.person_name, person.person_surname, person.person_surname2, person_data.phone, person_data.email, user.user_alias',
											"person.person_id = person_data.person_id and person.person_id = user.person_id and user.id_profile = $_profile $where_cond");

		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
			for($i=0; $i<count($sql_ret); $i++){
				if($sql_ret[$i] != null){
					foreach($sql_ret[$i] as $key => $value){
						list($table, $campo) = explode('.', $key);
						$ret_val[$i][$campo] = $value; 
					}
				}
				$ret_val[$i]['is_logged'] = $this->isLogged($sql_ret[$i]['user.user_alias']);
			}
		}
	
    	return $ret_val;
    }
	
	function getUserInfo($_user_id)
    {
		$ret_val = array();
				
		$sql_ret = $this->SelectMultiTable('person, person_data, user', 
											'person.person_id, person.person_dni, person.person_name, person.person_surname, person.person_surname2, 
											person_data.street, person_data.city, person_data.council, person_data.country, 
											person_data.postalcode, person_data.phone, person_data.phone2, person_data.fax,
											person_data.email, person_data.email2, person_data.email3, person_data.web,
											person_data.notes, person_data.image, person_data.cv,
											user.user_alias, user.user_password',
											"person.person_id = person_data.person_id and person.person_id = user.person_id and user.user_alias = $_user_id");

		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
			if($sql_ret[0] != null){
				foreach($sql_ret[0] as $key => $value){
					list($table, $campo) = explode('.', $key);
					$ret_val[$campo] = $value; 
				}
			}
		}
            	
    	return $ret_val;
    }
	
	function modifyUserInfo($user_id, $calle, $localidad, $provincia, $pais, $cp, $telefono, $telefono2, $fax, $email, $email2, $email3, $web, $notes, $passwd)
    {
		$person = $this->_updateUser($user_id, $passwd);
		
		$upd_ok = false;	
		if(!empty($person)){			
			$upd_ok = $this->_updatePersonData($person, $calle, $localidad, $provincia, $email, $email2, $email3, $pais, $cp, $telefono, $telefono2, $fax, $web, $notes);
        }
		
        return $uu_ok;
    }
    
    function _updatePersonData($person, $calle, $localidad, $provincia, $email, $email2, $email3, $pais, $cp, $telefono, $telefono2, $fax, $web, $notes)
    {	
        $ret_val = $this->Update('person_data',
                                 'street, city, council, country, postalcode, phone, phone2, fax, email, email2, email3, web, notes',
                                 array($calle, $localidad, $provincia, $pais, $cp, $telefono, $telefono2, $fax, $email, $email2, $email3, $web, $notes),
								 "person_id = $person");

    	if ($this->hasError()) {
	    	$ret_val = false;
  	  	} else {
			$ret_val = true;
		}

    	return $ret_val;
    }
	
	function _updateUser($user, $passwd)
    {
        $ret_val = $this->Update('user', 'user_password', "$passwd", "user_alias = $user");

    	if ($this->hasError()) {
    		$ret_val = null;
  	  	} else {
			$sql_val = $this->Select('user', 'person_id', "user_alias = $user");
			$ret_val = $sql_val[0]['user.person_id'];
		}

    	return $ret_val;
    }
	
	function isLogged($_nick)
    {
		$log_sql = $this->SelectMultiTable('user, user_logged', 'user_logged.is_logged', 'user.user_id = user_logged.user_id AND user.user_alias = '.$_nick);

		if ($this->hasError()) {
			$ret_val = false;
		} else {
			if($log_sql[0]['user_logged.is_logged'] == null){
				$ret_val = false;
			} else {
				$ret_val = true;
			}	
		}
		
		return $ret_val;
    }
	
	function getCandidateInfo($_person_id)
    {
		$ret_val = array();
				
		$sql_ret = $this->SelectMultiTable('candidate, candidate_data', 
											'candidate.person_id, candidate.person_dni, candidate.person_name, candidate.person_surname, candidate.person_surname2, 
											candidate_data.street, candidate_data.city, candidate_data.council, candidate_data.country, 
											candidate_data.postalcode, candidate_data.phone, candidate_data.phone2, candidate_data.fax,
											candidate_data.email, candidate_data.email2, candidate_data.email3, candidate_data.web',
											"candidate.person_id = candidate_data.person_id and candidate.person_id = $_person_id");

		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
			if($sql_ret[0] != null){
				foreach($sql_ret[0] as $key => $value){
					list($table, $campo) = explode('.', $key);
					$ret_val[$campo] = $value; 
				}
			}
		}
            	
    	return $ret_val;
    }
	
	function deleteCandidateData($id_cand)
	{
		$ret_val = $this->Delete('candidate', "person_id = $id_cand");
		
		$ret_val = $this->Delete('candidate_data', "person_id = $id_cand");
		
		if ($this->hasError()) {
   			$ret_val = false;
   		} else {
			$ret_val = true;
		}
		
		return $ret_val;
	}
}
?>