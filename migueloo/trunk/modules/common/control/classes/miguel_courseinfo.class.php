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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase obtiene información relativa a un curso.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */
class miguel_CourseInfo
{
	/**
	 * Informa si el curso es de acceso público.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $course_id Identificador del curso.
	 * @return boolean Devuelve TRUE si el usuario es público, y FALSE si no lo es.
	 */
    function getAccess(&$obj_model, $course_id)
    {
        $ret_sql = $obj_model->Select('course', 'course_access', 'course_id = ' . $course_id);
        if ($obj_model->hasError()) {
           $ret_val = null;
    	} else {
    	   if($ret_sql[0]['course.course_access']) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }
    
	/**
	 * Informa si el curso está disponible o activado.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $course_id Identificador del curso.
	 * @return boolean Devuelve TRUE si el curso está activo, y FALSE si no.
	 */    
    function getActive(&$obj_model, $course_id)
    {
        $ret_sql = $obj_model->Select('course', 'course_active', 'course_id = ' . $course_id);
        if ($obj_model->hasError()) {
           $ret_val = null;
    	} else {
    	   if($ret_sql[0]['course.course_active']) {
    	       $ret_val = true;
    	   } else {
    	       $ret_val = false;
    	   }
    	}    	

    	return ($ret_val);
    }    
	
    /**
	 * Informa si el usuario/clave tiene acceso permitido al curso.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @param string $str_password Clave del usuario.
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function hasAccess(&$obj_model, $course_id, $user_id)
    {
        $ret_sql_course = $obj_model->Select('course', 'course_active, course_access', 'course_id = ' . $course_id);
     
        if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   $active = $ret_sql_course[0]['course.course_active'];
    	   $access = $ret_sql_course[0]['course.course_access'];    	   
    	}    	
        
        $ret_val = false;
        if ( $active ) { //Si el curso está activado
          if ( $access ) { //Es necesario estar matriculado
              $ret_sql_user = $obj_model->Select('user_course', 'user_id', 'course_id = ' . $course_id . ' AND user_id = ' . $user_id);
              if ($obj_model->hasError()) {
    		        $ret_val = false;
    	        } else {
    	           if ($ret_sql_user[0]['user_course.user_id'] ) { //El usuario está matriculado
                     $ret_val = true;
                 }
    	        }
    	    } else {
    	        $ret_val = true;
    	    }
        }
        
    	return ($ret_val);
    }
	
	/**
	 * Informa si el usuario/clave tiene acceso permitido al curso.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_user Identificador de usuario (nickname).
	 * @param string $str_password Clave del usuario.
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
    function isCourseAdmin(&$obj_model, $course_id, $user_id)
    {
        $ret_sql_course = $obj_model->Select('course', 'user_id', 'course_id = ' . $course_id);
     
        if ($obj_model->hasError()) {
    		$ret_val = null;
    	} else {
    	   $user = $ret_sql_course[0]['course.user_id'];
    	}    	
        
        $ret_val = false;
        if ( $user == $user_id ) {
			$ret_val = true;
        }
        
    	return ($ret_val);
    }

    /**
	 * Obtiene la localización del curso dentro de la institución
	 * @param base_model $obj_model Instancia de un modelo	 
	 * @param string $course_id Identificador del curso.
	 * @return array Toda la informaciÛn: institucion, facultad, departamento y area
	 */
    function _getPath( &$obj_model, $course_id ) {
        $ret_sql = $obj_model->Select('area_course',
                                 'institution_id, faculty_id, department_id, area_id',
                                 'course_id = ' . $course_id);
    	  if ($obj_model->hasError()) {
    	    $ret_val = null;
    	  } else {
    	      $institution_id = $ret_sql[0]['area_course.institution_id'];
       	    $faculty_id = $ret_sql[0]['area_course.faculty_id'];
       	    $department_id = $ret_sql[0]['area_course.department_id'];
       	    $area_id = $ret_sql[0]['area_course.area_id'];
    	  }
    	  $ret_sql = $obj_model->Select('institution', 'institution_description', 'institution_id = ' . $institution_id);
    	  if ( $obj_model->hasError() ) {
    	    $institution_description = '';
    	  } else {
    	    $institution_description = $ret_sql[0]['institution.institution_description'];
        }

    	  $ret_sql = $obj_model->Select('faculty', 'faculty_description', 'faculty_id = ' . $faculty_id);
    	  if ( $obj_model->hasError() ) {
    	    $faculty_description = '';
    	  } else {
    	    $faculty_description = $ret_sql[0]['faculty.faculty_description'];
        }
        
    	  $ret_sql = $obj_model->Select('department', 'department_description', 'department_id = ' . $department_id);
    	  if ( $obj_model->hasError() ) {
    	    $department_description = '';
    	  } else {
    	    $department_description = $ret_sql[0]['department.department_description'];
        }
        
    	  $ret_sql = $obj_model->Select('area', 'area_description', 'area_id = ' . $area_id);
    	  if ( $obj_model->hasError() ) {
    	    $area_description = '';
    	  } else {
    	    $area_description = $ret_sql[0]['area.area_description'];
        }
        
        $ret_val = array ( 'institution'          => $institution_description,
                           'faculty'       => $faculty_description,
                           'department'    => $department_description,
                           'area'      => $area_description);
    	  return ($ret_val);                                       
    }
    
    /**
	 * Obtiene toda la informaciÛn de un curso
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $course_id Identificador de curso.
	 * @return array Toda la informaciÛn: nombre, email, idioma,...
	 */
    function getInfo(&$obj_model, $course_id)
    {
        //Obtiene información del curso
        $ret_sql = $obj_model->SelectMultiTable('course, user, person', 
                                      'course.course_name, course.course_description, course.course_language, person.person_name, person.person_surname, user.email',
                                      'course_id = ' . $course_id . ' AND course.user_id = user.user_id AND user.person_id = person.person_id');

    	if ($obj_model->hasError()) {
    	    $ret_val = null;
    	} else {
    		    $arr_path = miguel_CourseInfo::_getPath($obj_model, $course_id);
            $ret_val = array ( 'course_id'          => $course_id,
                               'name'               => $ret_sql[0]['course.course_name'],
                               'description'        => $ret_sql[0]['course.course_description'],
                               'user_responsable'   => $ret_sql[0]['person.person_name'] . ' ' . $ret_sql[0]['person.person_surname'],
                               'email'              => $ret_sql[0]['user.email'],
                               'language'           => $ret_sql[0]['course.course_language'],
                               'path'               => $arr_path );
    	}
    	return ($ret_val);
    }

    /**
	 * Inserta en la tabla de accesos un nuevo registro
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $user Identificador de usuario (nickname).
	 * @return boolean Devuelve TRUE si el usuario es administrador, y FALSE si no lo es.
	 */
	 /*
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
		}
    	return ($ret_val);
    }
	*/
}
?>
