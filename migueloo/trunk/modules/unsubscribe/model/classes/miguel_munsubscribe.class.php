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

class miguel_MUnsubscribe extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MUnsubscribe() 
    {	
        $this->base_Model();
    }

    function unsubscribeUserCourse($user_id, $course_id)
    {
        
        $ret_val = $this->Delete('user_course',
                                 "course_id = $course_id AND user_id = $user_id");
        if ($this->hasError()) {
            $ret_val = null;
        }
        return $ret_val;
    }

    
    function getCourseName( $course_id )
    {
        $ret_val = $this->Select('course', 'course_name', 'course_id = ' . $course_id);
        if ($this->hasError()) {
            $ret_val = null;
        }
        
        if (is_array($ret_val)) {
            $course_name = $ret_val[0]['course.course_name'];
        }

    	
    	return $course_name;
    }
    
}    
