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
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */


class miguel_CAuth extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CAuth()
	{	
		$this->miguel_Controller();
		$this->setModuleName('auth');
		$this->setModelClass('miguel_MAuth');
		$this->setViewClass('miguel_VAuth');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
        $message = '';
        $insert_ok = false;
        
        if ($this->issetViewVariable("submit") ){
            $all_Ok = false;
            //Control sobre variables de vista definidas
            if ($this->issetViewVariable('profile') && $this->getViewVariable('profile') != '') {
                //$this->setViewVariable('profile', $this->getViewVariable('profile'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('theme') && $this->getViewVariable('theme') != '') {
                //$this->setViewVariable('theme', $this->getViewVariable('theme'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('treatment') && $this->getViewVariable('treatment') != '') {
                //$this->setViewVariable('treatment', $this->getViewVariable('treatment'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('nom_form') && $this->getViewVariable('nom_form') != '') {
                $this->setViewVariable('nom_form', $this->getViewVariable('nom_form'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('prenom_form') && $this->getViewVariable('prenom_form') != '') {
                $this->setViewVariable('prenom_form', $this->getViewVariable('prenom_form'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            if ($this->issetViewVariable('uname') && $this->getViewVariable('uname') != '') {
                $this->setViewVariable('uname', $this->getViewVariable('uname'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
            
            if ($this->issetViewVariable('email') && $this->getViewVariable('email') != '') {
                $this->setViewVariable('email', $this->getViewVariable('email'));
                $all_Ok = true;
            } else {
                $all_Ok = false;
            }
        
            if($all_Ok){
                if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
                   $this->obj_data->newUser($this->getViewVariable('nom_form'), $this->getViewVariable('prenom_form'),
                                            $this->getViewVariable('treatment'), $this->getViewVariable('uname'),
                                            $this->getViewVariable('theme'), 'es_ES', $this->getViewVariable('passwd'),
                                            $this->getViewVariable('profile'), $this->getViewVariable('email'));
                   $this->setViewVariable('newclient', 'ok');
			       $this->addNavElement(Util::format_URLPath('auth/index.php'), "Inscripción (Paso 2)");
			       $insert_ok = true;
                 } else {
                   $message = 'Error: Las claves no coinciden.';
                 }
            } else {
                 $message = 'Error: Todos los campos son obligatorios.';
            }
            
            if(!$insert_ok){
                $this->setViewVariable('themes', $this->registry->listThemes());
				$this->setViewVariable('profiles', $this->obj_data->getProfileList());
				$this->setViewVariable('treatment', $this->obj_data->getTreatmentList());
				//$this->setViewClass("miguel_VAuth");
				$this->setCacheFile("miguel_VAuth_".$this->getSessionElement("userinfo","username"));
				$this->setCacheFlag(false);
            } else {
                $message = 'Alta de usuario OK';
                //$this->setViewClass("miguel_VAuthStep2");
                $this->setCacheFile("miguel_VAuth2_".$this->getSessionElement("userinfo","username"));
				$this->setCacheFlag(true);
            }
			$this->setMessage($message);
		} else {
			if(!$this->issetViewVariable("back")) {
				$this->addNavElement(Util::format_URLPath('auth/index.php'), "Inscripción (Paso 1)");
				
				//Informamos variables para la vista
				$this->setViewVariable('themes', $this->registry->listThemes());
				$this->setViewVariable('profiles', $this->obj_data->getProfileList());
				$this->setViewVariable('treatment', $this->obj_data->getTreatmentList());

			    $this->setMessage("Inscripción al Campus Virtual");
			    $this->setCacheFile("miguel_VAuth1_".$this->getSessionElement("userinfo","username"));
			    $this->setCacheFlag(true);
			} else {
				//$this->setViewClass("miguel_VAuth");
				$this->addNavElement(Util::format_URLPath('auth/index.php'), "Inscripción (Paso 1)");
			
			    $this->setMessage("En está página puede rellenar su inscripción al Campus Virtual");
			    $this->setCacheFile("miguel_VAuthStep2_".$this->getSessionElement("userinfo","username"));
			    $this->setCacheFlag(true);
			}
		}
		$this->setPageTitle("miguel Authentification Page");
		$this->setHelp("EducUser");
	}
    
}
