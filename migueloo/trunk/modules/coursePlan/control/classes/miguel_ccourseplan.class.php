<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */
/**
 *
 */

class miguel_CCoursePlan extends miguel_Controller
{
        function miguel_CCoursePlan()
        {
                $this->miguel_Controller();
                $this->setModuleName('coursePlan');
                $this->setModelClass('miguel_MCoursePlan');
            $this->setViewClass('miguel_VMCoursePlan');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {
                //Se controla que el usuario no tenga acceso. Por defecto, se tiene acceso.
                //$institution_id = -1;


                //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
                $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
                if ( isset($user_id) && $user_id != '' ) {
                        $course_id = $this->getSessionElement( 'courseinfo', 'course_id' );
                        if(empty($course_id)) $course_id = 7;
                        //$this->setViewVariable('user_id', $user_id );
                        switch ($this->getViewVariable('option')) {
                                case show:
                                        $ext_course = $this->getViewVariable('course');
                                        $arr_courseplan = $this->obj_data->listCoursePlan($ext_course);
                                        $this->setViewClass('miguel_VMain');
                                        break;
                                case detail:
                                        //$module_id = $this->getViewVariable('module_id');
                                        //$detail_courseplan = $this->obj_data->getCoursePlan($ourse_id, $module_id);
                                        //$this->setViewVariable('detail_courseplan', $detail_courseplan);
                                        //$this->setViewClass('miguel_VDetail');
                                        break;
                                default:
                                        $arr_courseplan = $this->obj_data->listCoursePlan($course_id);
                                        $this->setViewClass('miguel_VMain');
                                        break;
                        }
                        $this->setViewVariable('arr_courseplan', $arr_courseplan );
                        $this->setViewVariable('courseid', $course_id );
                        $this->clearNavBarr();  
                        //$this->addNavElement(Util::format_URLPath('coursePlan/index.php'), agt('Mapa del curso') );
                        $this->setCacheFile("miguel_VMain_CoursePlan_" . $this->getSessionElement("userinfo", "user_id"));
                        $this->setMessage('');
                        $this->setPageTitle( 'Plan del curso' );

                        $this->setCacheFlag(true);
                        $this->setHelp("EducContent");
                } else {
                        header('Location:' . Util::format_URLPath('main/index.php') );
                }
        }
}

?>