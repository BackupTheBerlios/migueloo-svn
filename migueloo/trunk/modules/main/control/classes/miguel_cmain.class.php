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

class miguel_CMain extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CMain()
	{	
		$this->miguel_Controller();
		$this->setModuleName('main');
		$this->setModelClass('miguel_MMain');
		$this->setViewClass('miguel_VIntro');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
		$this->setMessage(agt('miguel_Welcome'));
		//Se controla que el usuario no tenga acceso.
		$bol_hasaccess = false;


        //Peticion de salida
        if ( $this->issetViewVariable('id') && $this->getViewVariable('id') == 'logoff') {
        	$this->Close($this->obj_data);
			$this->setViewClass('miguel_VIntro');
			//$this->alertView('Ha salido correctamente de la aplicaci�n',
			//                 'Para continuar trabajando en este Campus Virtual debe regresar a la p�gina de inicio y acceder de nuevo');
		}
		
		//Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
		$user_id = $this->getSessionElement( 'userinfo', 'user_id' );

		if ( isset($user_id) && $user_id != '' ) {
			$bol_hasaccess = true;
			$user = $this->getSessionElement( 'userinfo', 'user_alias' );
		} else {
			if ( $this->issetViewVariable('id') && $this->getViewVariable('id') == 'logon'){
				$user = $this->getViewVariable("nombre_de_usuario");
				if ($user == '' || $user == 'guest' ) {
					$user = ''; //'guest';
					$password = ''; //'guest';
				} else {
					$user = $this->getViewVariable("nombre_de_usuario");
					$password = $this->getViewVariable("clave_de_acceso");
				}
				
				$bol_hasaccess = $this->processUser($this->obj_data, $user,  $password );
	
				if ( !$bol_hasaccess) {
					//Intento Fallido de autenticaciÛn. øDeberÌa enviar a una p·gina de mensaje de error, link a dar de alta y notificaciÛn vÌa mail?
					$this->setMessage(agt('miguel_wrongPassword'));
					$this->setViewVariable("clave_de_acceso", '');
				}
			}
		}

		$this->clearNavBarr();
        if($bol_hasaccess) {
        	if ( $user == 'guest' ) { 
        		//Navega por la jerarquía
        		$this->setViewClass("miguel_VMain");                    
        		$this->setPageTitle("miguel_institutionList");
        		$this->addNavElement(Util::format_URLPath('main/index.php','id=institution'), agt("miguel_Center") );
        		
        		//$this->setViewVariable('arr_categories', $this->obj_data->getInstitutionResume() );
        		//Debug::oneVar($this, __FILE__, __LINE__);
        		$this->setCacheFile("miguel_VMain_Institution_" . $this->getSessionElement("userinfo", "user_id"));
        		$this->setMessage( agt('miguel_institutionList') );
        	} else {
				switch ($this->getSessionElement( 'userinfo', 'profile_id' )) {
					case 2:
					case 3:
						$this->giveControl('teacherPage', 'miguel_CTeacherPage');
						break;
					case 4:
						$this->giveControl('alumnPage', 'miguel_CAlumnPage');
						break;
					case 5:
						$this->giveControl('secretariatPage', 'miguel_CSecretariatPage');
						break;
					default:
						//Muestra los cursos de un usuario
						$this->setViewClass("miguel_VUserCourses");
						$this->addNavElement(Util::format_URLPath('main/index.php','id=institution'), agt('miguel_Courses') );
						$this->setViewVariable('arr_courses', $this->obj_data->getUserCourse( $this->getSessionElement('userinfo', 'user_id') ) );
						
						$this->setCacheFile("miguel_VMain_Courses_" . $this->getSessionElement("userinfo", "user_id"));
						$this->setMessage(agt("miguel_userCourses"));
						$this->setPageTitle("miguel_userCourses");
				}
				
        		
        	}
        } else { 
        	//Bienvenida
        	$this->setPageTitle("miguel_Welcome");
        	$this->setCacheFile("miguel_VMain_Welcome");
        }
        
        $this->setCacheFlag(true);
        $this->setHelp("EducContent");                
    }
}
?>
