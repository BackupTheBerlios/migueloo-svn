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

class miguel_mCoursePlan extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_mCoursePlan() 
    {	
		$this->base_Model();
    }
 
    function listCoursePlan($course_id)
    {
		$sql_res = $this->SelectMultiTable('course_module, module',
                                           'module.module_id, module.module_name, module.module_description',
                                           'course_module.course_id = '.$course_id.' AND module.module_id = course_module.module_id');
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$count = count($sql_res);
			for ($i=0; $i < $count; $i++) {
				$ret_val[$i]= array ("id" => $sql_res[$i]['module.module_id'],
									 "name" => $sql_res[$i]['module.module_name'],
									 "description" => $sql_res[$i]['module.module_description']);
			}
		}
    	
    	return $ret_val;
    }
}
?>
