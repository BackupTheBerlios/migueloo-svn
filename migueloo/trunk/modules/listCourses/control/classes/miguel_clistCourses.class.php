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
/**
 *
 */

class miguel_CListcourses extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CListCourses()
	{	
		$this->miguel_Controller();
		$this->setModuleName('listCourses');
		$this->setModelClass('miguel_MListCourses');
		$this->setViewClass('miguel_VMain');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
           //Se controla que el usuario no tenga acceso. Por defecto, se tiene acceso.
           $institution_id = -1;
           //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
            $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
            if ( isset($user_id) && $user_id != '' ) { 
                if ( $this->issetViewVariable('institution_id')  ) {
                    $institution_id = $this->getViewVariable('institution_id');
                } else {
                    $institution_id = -1;
                }
                if ( $this->issetViewVariable('faculty_id')  ) {
                    $faculty_id = $this->getViewVariable('faculty_id');
                } else {
                    $institution_id = -1;
                }
                if ( $this->issetViewVariable('department_id')  ) {
                    $department_id = $this->getViewVariable('department_id');
                } else {
                    $institution_id = -1;
                }
                if ( $this->issetViewVariable('area_id')  ) {
                    $area_id = $this->getViewVariable('area_id');
                } else {
                    $institution_id = -1;
                }
            } else {
                header('Location:' . Util::format_URLPath('main/index.php') );
            }              

            if ( $institution_id >= 0 ) { 
                $this->setViewVariable('arr_courses', $this->obj_data->getCourse( $user_id, $institution_id, $faculty_id, $department_id, $area_id ) );
                
                //Perfil superior al alumno, debería de ser una comprobación ACL
                $profile_id = $this->getSessionElement( 'userinfo', 'profile_id' );
                if ( $profile_id < 4 ) {
                	$navinfo = array( "institution_id" => $institution_id,
                	                  "faculty_id" => $faculty_id,
                	                  "department_id" => $department_id,
                	                  "area_id" => $area_id);
                	$this->setSessionArray('navinfo', $navinfo);
                }

                $this->addNavElement(Util::format_URLPath('listCourses/index.php','institution_id=' . $institution_id . '&faculty_id=' . $faculty_id . '&department_id=' . $department_id . '&area_id=' . $area_id), agt('miguel_CourseList') );
                $this->setCacheFile("miguel_VMain_ListaCursos_" . $this->getSessionElement("userinfo", "user_id"));
                $this->setMessage( agt('miguel_CourseList') );
                $this->setPageTitle( 'miguel_CourseList' );
                
                $this->setCacheFlag(true);
                $this->setHelp("EducContent");
            } else { //category_id
                header('Location:' . Util::format_URLPath('main/index.php') );
            }
	}
}
?>
