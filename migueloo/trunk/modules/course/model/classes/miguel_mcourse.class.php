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

class miguel_MCourse extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MCourse() 
    {	
        $this->base_Model();
    }
	
	function getCourseItems( $course_id )
    {
        $ret_val = array();
        $course = $this->SelectMultiTable('course_visual, course_visual_item',
                                           'course_visual.visible, course_visual.admin, course_visual_item.label, course_visual_item.link, course_visual_item.param, course_visual_item.image',
                                           'course_visual.course_id = ' . $course_id . ' AND course_visual_item.item_id = course_visual.item_id');
		//Debug::oneVar($course, __FILE__, __LINE__);

        if ( $this->hasError() ) {
            $ret_val = null;
        } else {
            $countCourse = count($course);
    		for ($i=0; $i < $countCourse; $i++) {
                $ret_val[] = array ( 'label' => $course[$i]['course_visual_item.label'],
                               'link' => $course[$i]['course_visual_item.link'],
                               'param' => $course[$i]['course_visual_item.param'],
                               'image' => $course[$i]['course_visual_item.image'] ,
							   'admin' => $course[$i]['course_visual.admin'] ,
                               'visible' => $course[$i]['course_visual.visible']);
            }
        }
        //Debug::oneVar($ret_val, __FILE__, __LINE__);
        return ( $ret_val );   
    }
	
	function setBottonVisibility( $course_id, $item_id, $visible )
    {
        $course = $this->Update('course_visual','visible', "$visible", 'course_id = '.$course_id.' AND item_id = '. $item_id);
		//Debug::oneVar($course, __FILE__, __LINE__);

        if ( $this->hasError() ) {
            $ret_val = false;
        } else {
			$ret_val = true;
        }
        //Debug::oneVar($ret_val, __FILE__, __LINE__);
        return ( $ret_val );   
    }
}    