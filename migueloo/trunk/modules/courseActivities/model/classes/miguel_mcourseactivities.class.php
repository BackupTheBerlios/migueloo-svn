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
      | Authors: Miguel Majuelos Mudarra <www.polar.es>                      |
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



class miguel_MCourseActivities extends base_Model
{
        /**
         * This is the constructor.
         *
         */
    function miguel_MCourseActivities()
    {
        //Llama al constructor de la superclase del Modelo
        $this->base_Model();
    }

	function getCourseActivities($course_id)
	{
	    $arrTmp = $this->Select('course_activity', 'course_activity_id, title, body',"course_id = $course_id");

	    if (!$this->hasError() && $arrTmp[0]['course_activity.title']!=null)	{
			for ($i=0; $i<count($arrTmp); $i++) {
				$arrRet[$i]['id'] = $arrTmp[$i]['course_activity.course_activity_id'];
				$arrRet[$i]['title'] = $arrTmp[$i]['course_activity.title'];
				$arrRet[$i]['body'] = $arrTmp[$i]['course_activity.body'];
			}
		}
		return $arrRet;
	}

	function updateCourseActivity($activity_id, $title, $body)
	{
	    $ret = $this->Update('course_activity', 
													'title, body',
													array($title, $body),
													"course_activity_id = $activity_id");

	    if ($this->hasError()) {
			$ret = null;
		}
		return $ret;
	}

	function insertCourseActivity($course_id, $title, $body)
	{
	    $ret = $this->Insert('course_activity', 
													'course_id, title, body',
													array($course_id, $title, $body));
	    if ($this->hasError()) {
			$ret = null;
		}
		return $ret;
	}

	function deleteCourseActivity($activity_id)
	{
	    $ret = $this->Delete('course_activity', 
										"course_activity_id = $activity_id");
	    if ($this->hasError()) {
			$ret = null;
		}
		return $ret;
	}

}