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

class miguel_CCourseCard extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CCourseCard()
        {
                $this->miguel_Controller();
                $this->setModuleName('courseCard');
                $this->setModelClass('miguel_MCourseCard');
                $this->setViewClass('miguel_VCourseCard');
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
						//Guardar cambios
						case 'update':	
											$objectives = $this->getViewVariable('objectives');
											$description = $this->getViewVariable('description');
											$contents = $this->getViewVariable('contents');
											$this->obj_data->updateCourseCard($course, $objectives, $description, $contents);
											break;
						//Mostrar formulario 
						case 'showForm': 
						//Mostrar contenido
						case 'show':
						default:
											break;
				}

				//Información de la ficha
				$arrCourseCard = $this->obj_data->getCourseCard($course);
				$this->setViewVariable('arrCourseCard', $arrCourseCard);
		
                $this->clearNavBarr();

                $this->setPageTitle("miguel Course Card");
                $this->setMessage('');

                $this->setHelp("");
        }
}
?>