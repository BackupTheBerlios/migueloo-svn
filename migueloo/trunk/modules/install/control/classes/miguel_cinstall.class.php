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
 * Define el controlador para la instalación de miguelOO.
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

class miguel_CInstall extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CInstall()
	{	
		$this->miguel_Controller(false);
		$this->setModuleName('install');
		$this->setModelClass('miguel_MInstall');
		$this->setViewClass('miguel_VInstall');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
		//Declaraciones comunes
		$virtual_user = array('username' => 'installer', 
	 						  'name' => 'instalación', 
							  'surname' => '' );
        $message = '';
		$this->setSessionArray("userinfo", $virtual_user);

		//Paso en la instalación
		$install_step = intval($this->getSessionElement('install_step'));


		//Control de salida por peticion de usuario
		if ($this->issetViewVariable('quit')) {
			$install_step = -1;
		} 
		
		
		switch ($install_step) {
			case -1:
				$this->currentStep = 0;
				break;
			case 1:
			    include_once(Util::base_Path('include/classes/nls.class.php'));

	            NLS::setLang($this->getViewVariable('miguel_lang'));
                //NLS::setTextdomain('install', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());
        
				if ($this->issetViewVariable('submit')) {
					$this->currentStep = 2;
				}
				break;
			case 2:
				if ($this->issetViewVariable('submit')) {
					$this->currentStep = 3;
				}
				if ($this->issetViewVariable('back')) {
					$this->currentStep = 1;
				}
				break;
			case 3:
				if ($this->issetViewVariable('submit')) {
					$this->currentStep = 4;
				}
				if ($this->issetViewVariable('back')) {
					$this->currentStep = 2;
				}
				break;
			case 4:
                if ($this->issetViewVariable('submit')) {
                    $all_Ok = false;
                    //Control sobre variables de vista definidas
                    if ($this->issetViewVariable('miguel_ddbb_sgbd') && $this->getViewVariable('miguel_ddbb_sgbd') != '') {
                        $this->setViewVariable('inst_ddbb_sgbd', $this->getViewVariable('miguel_ddbb_sgbd'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_ddbb_host') && $this->getViewVariable('miguel_ddbb_host') != '') {
                        $this->setViewVariable('inst_ddbb_host', $this->getViewVariable('miguel_ddbb_host'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_ddbb_name') && $this->getViewVariable('miguel_ddbb_name') != '') {
                        $this->setViewVariable('inst_ddbb_name', $this->getViewVariable('miguel_ddbb_name'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_ddbb_user') && $this->getViewVariable('miguel_ddbb_user') != '') {
                        $this->setViewVariable('inst_ddbb_user', $this->getViewVariable('miguel_ddbb_user'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_ddbb_passwd') && $this->getViewVariable('miguel_ddbb_passwd') != '') {
                        $this->setViewVariable('inst_ddbb_passwd', $this->getViewVariable('miguel_ddbb_passwd'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_ddbb_passwd2') && $this->getViewVariable('miguel_ddbb_passwd2') != '') {
                        $this->setViewVariable('inst_ddbb_passwd2', $this->getViewVariable('miguel_ddbb_passwd2'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    
                    if($all_Ok){
                        if($this->getViewVariable('miguel_ddbb_passwd') == $this->getViewVariable('miguel_ddbb_passwd2')){
                            $this->setSessionElement('host_sgbd', $this->getViewVariable('miguel_ddbb_sgbd'));
                            $this->setSessionElement('host_name', $this->getViewVariable('miguel_ddbb_host'));
                            $this->setSessionElement('ddbb_name', $this->getViewVariable('miguel_ddbb_name'));
                            $this->setSessionElement('ddbb_user', $this->getViewVariable('miguel_ddbb_user'));
                            $this->setSessionElement('ddbb_passwd', $this->getViewVariable('miguel_ddbb_passwd'));
                            
							$this->currentStep = 5;
                        } else {
                            $this->currentStep = 4;
                            $message = 'Error: Las claves no coinciden.';
                        }
                    } else {
                        $this->currentStep = 4;
                        $message = 'Error: Todos los campos son obligatorios.';
                    }
					
				}
				if ($this->issetViewVariable('back')) {
					$this->currentStep = 3;
				}
				break;
			case 5:
			    if ($this->issetViewVariable('submit')) {
                    $all_Ok = false;
                    
                    if ($this->issetViewVariable('miguel_campus_name') && $this->getViewVariable('miguel_campus_name') != '') {
                        $this->setViewVariable('inst_campus_name', $this->getViewVariable('miguel_campus_name'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_inst_name') && $this->getViewVariable('miguel_inst_name') != '') {
                        $this->setViewVariable('inst_inst_name', $this->getViewVariable('miguel_inst_name'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_inst_url') && $this->getViewVariable('miguel_inst_url') != '') {
                        $this->setViewVariable('inst_inst_url', $this->getViewVariable('miguel_inst_url'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_director_name') && $this->getViewVariable('miguel_director_name') != '') {
                        $this->setViewVariable('inst_director_name', $this->getViewVariable('miguel_director_name'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_director_email') && $this->getViewVariable('miguel_director_email') != '') {
                        $this->setViewVariable('inst_director_email', $this->getViewVariable('miguel_director_email'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_inst_phone') && $this->getViewVariable('miguel_inst_phone') != '') {
                        $this->setViewVariable('inst_inst_phone', $this->getViewVariable('miguel_inst_phone'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_campus_lang') && $this->getViewVariable('miguel_campus_lang') != '') {
                        $this->setViewVariable('inst_campus_lang', $this->getViewVariable('miguel_campus_lang'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_campus_lang') && $this->getViewVariable('miguel_campus_lang') != '') {
                        $this->setViewVariable('inst_campus_lang', $this->getViewVariable('miguel_campus_lang'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_name') && $this->getViewVariable('miguel_admin_name') != '') {
                        $this->setViewVariable('inst_admin_name', $this->getViewVariable('miguel_admin_name'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_surname') && $this->getViewVariable('miguel_admin_surname') != '') {
                        $this->setViewVariable('inst_admin_surname', $this->getViewVariable('miguel_admin_surname'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_user') && $this->getViewVariable('miguel_admin_user') != '') {
                        $this->setViewVariable('inst_admin_user', $this->getViewVariable('miguel_admin_user'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_passwd') && $this->getViewVariable('miguel_admin_passwd') != '') {
                        $this->setViewVariable('inst_admin_passwd', $this->getViewVariable('miguel_admin_passwd'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_passwd2') && $this->getViewVariable('miguel_admin_passwd2') != '') {
                        $this->setViewVariable('inst_admin_passwd2', $this->getViewVariable('miguel_admin_passwd2'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_admin_theme') && $this->getViewVariable('miguel_admin_theme') != '') {
                        $this->setViewVariable('inst_admin_theme', $this->getViewVariable('miguel_admin_theme'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    if ($this->issetViewVariable('miguel_cript_passwd') && $this->getViewVariable('miguel_cript_passwd') != '') {
                        $this->setViewVariable('inst_cript_passwd', $this->getViewVariable('miguel_cript_passwd'));
                        $all_Ok = true;
                    } else {
                        $all_Ok = false;
                    }
                    
                    if($all_Ok){
                        if($this->getViewVariable('miguel_admin_passwd') == $this->getViewVariable('miguel_admin_passwd2')){
                            $this->setSessionElement('campus_name', $this->getViewVariable('miguel_campus_name'));
                            $this->setSessionElement('inst_name', $this->getViewVariable('miguel_inst_name'));
                            $this->setSessionElement('inst_url', $this->getViewVariable('miguel_inst_url'));
                            $this->setSessionElement('director_name', $this->getViewVariable('miguel_director_name'));
                            $this->setSessionElement('director_email', $this->getViewVariable('miguel_director_email'));
                            $this->setSessionElement('inst_phone', $this->getViewVariable('miguel_inst_phone'));
                            $this->setSessionElement('campus_lang', $this->getViewVariable('miguel_campus_lang'));
                            $this->setSessionElement('admin_name', $this->getViewVariable('miguel_admin_name'));
                            $this->setSessionElement('admin_surname', $this->getViewVariable('miguel_admin_surname'));
                            $this->setSessionElement('admin_user', $this->getViewVariable('miguel_admin_user'));
                            $this->setSessionElement('admin_passwd', $this->getViewVariable('miguel_admin_passwd'));
                            $this->setSessionElement('admin_theme', $this->getViewVariable('miguel_admin_theme'));
                            if($this->getViewVariable('miguel_cript_passwd') == agt('Si')){
                                $cripted = 'true';
                            } else {
                                $cripted = 'false';
                            }
                            $this->setSessionElement('cript_passwd', $cripted);

							$this->currentStep = 6;
                        } else {
                            $this->currentStep = 5;
                            $message = 'Error: Las claves no coinciden.';
                        }
                    } else {
                        $this->currentStep = 5;
                        $message = 'Error: Todos los campos son obligatorios.';
                    }
                }
								
				if ($this->issetViewVariable('back')) {
					$this->currentStep = 4;
				}
				break;
			case 6:
				if ($this->issetViewVariable('submit')) {
					$this->obj_data->makeXMLData();
					$this->currentStep = 7;
				}
				if ($this->issetViewVariable('back')) {
					$this->currentStep = 5;
				}
				break;
			default:
				$this->currentStep = 1;
		}//end switch

		switch ($this->currentStep) {
			case 0:
				//$this->Close();
				$this->setViewVariable("install_step", 0);
				break;
			case 1:
				
				if (!$this->issetViewVariable('inst_lang')){
			         $this->setViewVariable('inst_lang', NLS::getLangLabel('es_ES'));
                }
                $this->setViewVariable('select_lang', $this->obj_data->getAllLang());

				$this->setViewVariable("install_step", 1);
				break;
			case 2:
				$this->setViewVariable("install_step", 2);
				$this->setViewVariable("install_require", $this->_getRequire());
				break;
			case 3:
				$this->setViewVariable("install_step", 3);
				break;
			case 4:
                if (!$this->issetViewVariable('inst_ddbb_sgbd')){
			         $this->setViewVariable('inst_ddbb_sgbd', $this->obj_data->getAllSGBD());
			    } 			
			    if (!$this->issetViewVariable('inst_ddbb_host')){
			         $this->setViewVariable('inst_ddbb_host', 'localhost');
			    }
			    if (!$this->issetViewVariable('inst_ddbb_name')){
			         $this->setViewVariable('inst_ddbb_name', 'miguel');
			    }
			    if (!$this->issetViewVariable('inst_ddbb_user')){
			         $this->setViewVariable('inst_ddbb_user', 'root');
                }
			    if (!$this->issetViewVariable('inst_ddbb_passwd')){
			         $this->setViewVariable('inst_ddbb_passwd', Util::newPasswd());
			    }
			    if (!$this->issetViewVariable('inst_ddbb_paswwd2')){
			         $this->setViewVariable('inst_ddbb_paswwd2', '');
			    }

				$this->setViewVariable("install_step", 4);
				break;
			case 5:
			     if (!$this->issetViewVariable('inst_campus_name')){
			         $this->setViewVariable('inst_campus_name', 'miguel (OO)');
			    }
			    if (!$this->issetViewVariable('inst_inst_name')){
			         $this->setViewVariable('inst_inst_name', 'Hispalinux');
			    }
			    if (!$this->issetViewVariable('inst_inst_url')){
			         $this->setViewVariable('inst_inst_url', 'http://www.hispalinux.es');
			    }
			    if (!$this->issetViewVariable('inst_director_name')){
			         $this->setViewVariable('inst_director_name', 'Juan Español');
			    }
			    if (!$this->issetViewVariable('inst_director_email')){
			         $this->setViewVariable('inst_director_email', 'root@localhost');
			    }
			    if (!$this->issetViewVariable('inst_inst_phone')){
			         $this->setViewVariable('inst_inst_phone', '(515) 648 208');
			    }
			    
			    $this->setViewVariable('inst_campus_lang', $this->obj_data->getAllLang());
			
			    if (!$this->issetViewVariable('inst_admin_name')){
			         $this->setViewVariable('inst_admin_name', 'Juan');
			    }
			    if (!$this->issetViewVariable('inst_admin_surname')){
			         $this->setViewVariable('inst_admin_surname', 'Español');
			    }
			    if (!$this->issetViewVariable('inst_admin_user')){
			         $this->setViewVariable('inst_admin_user', 'admin');
			    }
			    if (!$this->issetViewVariable('inst_admin_passwd')){
			         $this->setViewVariable('inst_admin_passwd', '');
			    }
			    if (!$this->issetViewVariable('inst_cript_passwd')){
			         $this->setViewVariable('inst_cript_passwd', true);
			    }

				$this->setViewVariable("install_step", 5);
				break;
			case 6:
				$this->setViewVariable("install_step", 6);
				break;
			case 7:
				$this->setViewVariable("install_step", 7);
				break;
		}
		
    	if($this->currentStep == 0) {
			$step = "Salida a petición de usuario.";
		} else {
			$step = "Paso ".$this->currentStep." de 7.";
		}
		$this->setSessionElement('install_step', $this->currentStep);

		$this->setPageTitle("miguel Instalation Page");
		if($message == ''){
		  $this->setMessage('Proceso de instalación y configuración de su plataforma miguel - '.$step);		
		} else {
		  $this->setMessage($message);
		}
		$this->setHelp("EducInstall");
	}
	
	function _getRequire()
	{
		$buffer = array();
				
		$buffer["standard"]	= extension_loaded("standard");
		$buffer["gettext"]  = extension_loaded("gettext");
		$buffer["session"]  = extension_loaded("session");
		$buffer["mysql"]  	= extension_loaded("mysql");
		$buffer["zlib"]  	= extension_loaded("zlib");
		$buffer["pcre"]  	= extension_loaded("pcre");
		//$buffer["nameOfExtention"]  = extension_loaded("nameOfExtention");
		
		//echo "<pre>"; print_r($buffer); echo "</pre>";
		return $buffer;
	}
    
}
?>
