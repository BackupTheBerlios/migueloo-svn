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
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class miguel_MMain extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MMain() 
    {	
		$this->base_Model();
    }
	
    function _getInstitution()
    {
		$ret_val = $this->Select('institution', "institution_id, institution_name");
                
    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
        
    function _getInstitutionCoursNum($institution_id)
    {
    	$ret_val = $this->SelectCount('area_course', "institution_id = $institution_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return $ret_val;
    }
    
    function getInstitutionResume()
    {
        $categoryelem = array();
    	$institution = $this->_getInstitution();
    	if (is_array($institution)) {
                $countInstitution = count($institution);
    		for ($i=0; $i < $countInstitution; $i++) {
    			$num = $this->_getInstitutionCoursNum($institution[$i]['institution.institution_id']);

    			if ($num != 0) {
                                $categoryelem[]=array ("id" => $institution[$i]['institution.institution_id'], 
                                                        "name" => $institution[$i]['institution.institution_name'], 
                                                        "num" => $num);
                        }
    		}

    	}
    	
    	return $categoryelem;
    }

    function getUserCourse( $user_id )
    {
        $ret_val = array();
        $course = $this->SelectMultiTable('user_course, course, user, person',
                                           'course.course_id, course.course_name, course.course_description, user.email, person.person_name, person.person_surname',
                                           'user_course.user_id = ' . $user_id . ' AND user_course.course_id = course.course_id AND user.user_id = course.user_id AND person.person_id = user.person_id');


        if ( $this->hasError() ) {
            $ret_val = null;
        } else {
            $countCourse = count($course);
    		for ($i=0; $i < $countCourse; $i++) {
                $ret_val[] = array ( 'course_id' => $course[$i]['course.course_id'],
                               'course_name' => $course[$i]['course.course_name'],
                               'course_description' => $course[$i]['course.course_description'],
                               'course_responsable' => $course[$i]['person.person_name'] . ' ' . $course[$i]['person.person_surname'],
                               'course_email' => $course[$i]['user.email']);
            }
        }
        
        return ( $ret_val );   
    }
}
?>
