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
 * Define la clase modelo del mÛdulo encargado de crear cursos.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel auth
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MNewCourse extends base_Model
{
    /**
     * This is the constructor.
     *
     */
  function miguel_MNewCourse() 
  {	
    $this->base_Model();
  }

  /*
  function testNav($institution_id, $faculty_id, $department_id, $area_id)
  {
    $ret_val = $this-> SelectCount('area', "institution_id = $institution_id AND faculty_id = $faculty_id AND department_id = $department_id AND area_id = $area_id");
    if ($this->hasError()) {
      $ret_val = 0;
    }
    return $ret_val;
  }
  */
	
  function createNewCourse($courseData, $user_id)
  {
    $courseID = $this->insertNewCourse($courseData);
    $course = $this->insertDataCourse($courseData, $courseID);
    $rel = $this->insertUserCourse($user_id, $courseID );                
  }

  function insertNewCourse( $courseData )
  {
    $ret_val = $this->Insert('course',
                             'course_name, course_description, course_language, course_access, course_active',
                             $courseData['c_name'] . ' , ' . $courseData['c_description'] . ' , ' . $courseData['c_language'] . ' , ' . $courseData['c_access'] . ' , ' . $courseData['active'] );
    if ($this->hasError()) {
      $ret_val = null;
    }
        
    return $ret_val;
  }

  function insertDataCourse( $courseData, $course_id )
  {
    $ret_val = $this->Insert('courseData',
                             'COURSE_ID, description, version, keyWords, userProfile, knowledge, metodology',
                             $course_id . ' , ' . $courseData['cd_descripcion'] . ' , ' . $courseData['cd_version'] . ' , ' . $courseData['cd_claves'] . ' , ' . $courseData['cd_destinatarios'] . ' , ' . $courseData['cd_conocimientos'] . ' , ' . $courseData['cd_metodologia'] );
    if ($this->hasError()) {
      $ret_val = null;
    }
        
    return $ret_val;
  }
    
  function insertUserCourse( $user_id, $course_id )
  {
    $ret_val = $this->Insert('user_course',
                             'course_id, user_id, ud_date',
                             $course_id . ' , ' . $user_id . ' , ' . date("Y-m-d H:i:s"));
    if ($this->hasError()) {
      $ret_val = null;
    }
    return $ret_val;
  }    
    
  function getCourseId( $course )
  {
    $ret_val = $this->Select('course', 'course_id', 'course_name = ' . $course);
    if ($this->hasError()) {
      $ret_val = null;
    }
    if (is_array($ret_val)) {
      $course_id = $ret_val[0]['course.course_id'];
    }
    return $course_id;
  }
    
}    
