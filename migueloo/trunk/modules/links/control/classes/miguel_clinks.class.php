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
      | Authors: Eukene Elorza Bernaola <eelorza@ikusnet.com>                |
      |          Mikel Ruiz Diez <mruiz@ikusnet.com>                         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Eukene Elorza Bernaola <eelorza@ikusnet.com>
 * @author Mikel Ruiz Diez <mruiz@ikusnet.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 *
 */

class miguel_CLinks extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CLinks()
	{	
		$this->miguel_Controller();
		$this->setModuleName('links');
		$this->setModelClass('miguel_MLinks');
		$this->setViewClass('miguel_VMain');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
            //Se controla que el usuario no tenga acceso. Por defecto, se tiene acceso.
            $course_id = -1;

            //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
            $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
            $course_id = $this->getSessionElement( 'courseinfo', 'course_id' );
		   if ( isset($user_id) && $user_id != '' ) {            
                if ( !isset($course_id)  ) {
                     $course_id = -1;
                }
            } else {
              header('Location:' . Util::format_URLPath('main/index.php') );
            }
 //validar formulario
            if ( $course_id >= 0 ) { 
			if ($this->issetViewVariable('submit') && $this->getViewVariable('submit')!= '') {
				if ($this->checkInput()){
           
                   $this->obj_data->insertLinks($course_id,$this->getViewVariable('nomlink'), $this->getViewVariable('descrlink'),
                                            $this->getViewVariable('urllink'));
                   $this->setViewVariable('newlink', 'ok');
			  //     $this->addNavElement(Util::format_URLPath('links/index.php'), "InscripciÛn (Paso 2)");
			       $insert_ok = true;
				}
				else {      
				$message = 'Error: Todos los campos son obligatorios.';
				$this->setViewClass('miguel_VInsert'); 
				$this->setViewVariable('msgError',$message );
}	}			
						
			if ($this->issetViewVariable('action') && $this->getViewVariable('action') == 'insert') {
			$this->setViewClass('miguel_VInsert');
			} 
			if ($this->issetViewVariable('action') && $this->getViewVariable('action') == 'delete') {
			$this->obj_data->deleteLinks($this->getViewVariable('link_id'));
			} 
			if ($this->issetViewVariable('action') && $this->getViewVariable('action') == 'invalid') {
			$this->obj_data->invalidLink($this->getViewVariable('link_id'));
			}

    
			
                $this->setViewVariable('course_id', $course_id );
                $arr_links = $this->obj_data->getLinks($course_id);
				
				$this->setViewVariable('arr_links', $arr_links );
                $this->addNavElement(Util::format_URLPath('links/index.php','course_id=' . $course_id), agt('miguel_Links') );
                $this->setCacheFile("miguel_VMain_Links_" . $this->getSessionElement("userinfo", "user_id"));
                $this->setMessage(agt('miguel_Links') );
                $this->setPageTitle( 'miguel_Links' );
                
                $this->setCacheFlag(true);
                $this->setHelp("EducContent");
           } else {
                header('Location:' . Util::format_URLPath('main/index.php') );
	        }
	}
	
	function checkInput()
	{
				    if ($this->issetViewVariable('nomlink') && $this->getViewVariable('nomlink') != '') {
                $this->setViewVariable('nomlink', $this->getViewVariable('nomlink'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('descrlink') && $this->getViewVariable('descrlink') != '') {
                $this->setViewVariable('descrlink', $this->getViewVariable('descrlink'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('urllink') && $this->getViewVariable('urllink') != '') {
                $this->setViewVariable('urllink', $this->getViewVariable('urllink'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
			return $all_Ok;
	}
	
}
?>
