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
          |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/

class miguel_CCourseActivities extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CCourseActivities()
        {
                $this->miguel_Controller();
                $this->setModuleName('courseActivities');
                $this->setModelClass('miguel_MCourseActivities');
                $this->setViewClass('miguel_VCourseActivities');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {
                if ($this->issetViewVariable('course')){
                        $course = $this->getViewVariable('course');
                } else {
                        $course = 7;
                }

				$status = $this->getViewVariable('status');
				switch($status)
				{
					case 'showForm':	
									break;
					case 'update':
									$activity_id = $this->getViewVariable('idi');
									$body = $this->getViewVariable('body');
									$title = $this->getViewVariable('title');
									$this->obj_data->updateCourseActivity($activity_id, $title, $body);
									break;
					case 'new':
									$body = $this->getViewVariable('body');
									$title = $this->getViewVariable('title');
									$this->obj_data->insertCourseActivity($course, $title, $body);
									break;
					case 'delete':
									$activity_id = $this->getViewVariable('idi');
									$this->obj_data->deleteCourseActivity($activity_id);
									break;
					default:
								break;
				}

				$arrCourseActivities = $this->obj_data->getCourseActivities($course);
				$this->setViewVariable('arrCourseActivities', $arrCourseActivities);

	            $this->clearNavBarr();
                $this->setPageTitle("miguel Course Activities");
                $this->setMessage('');

                $this->setHelp("");
        }

}
?>