<?php
/*
	  +----------------------------------------------------------------------+
	  |newInscription/controller                                             |
	  +----------------------------------------------------------------------+
	  | Copyright (c) 2003, 2004, miguel Development Team                    |
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
	  | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
	  |          miguel Development Team                                     |
	  |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
	  +----------------------------------------------------------------------+
*/

class miguel_CProfile extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CProfile()
	{	
		$this->miguel_Controller();
		$this->setModuleName('profileManager');
		$this->setModelClass('miguel_MProfile');
		$this->setViewClass('miguel_VProfile');
		$this->setCacheFlag(false);
	}
	
	function processPetition() 
	{
			
		//Debug::oneVar($this->arr_form);	
		//Consultar la variable status.
		if ($this->issetViewVariable('submit')) {
			$accion = substr($this->getViewVariable('submit'),0,3);
		} else {
			$accion = $this->setViewVariable('submit', '');
		}
		
		$strError = '';
		switch($accion)
		{
			case 'Ins': 
				$arr_info = $this->insertProfile(&$strError);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('strError', $strError);
				break;
			case 'del': 
				$del_profileid = $this->getViewVariable('id');
				$del_priority = $this->getViewVariable('pri');
				$arr_info = $this->deleteProfile($del_profileid, $del_priority, &$strError);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('strError', $strError);
				break;
			case 'mod': 
				$old_priority = rtrim(trim(substr($this->getViewVariable('submit'),-2)));
				settype($old_priority,'integer');	
				$arr_info = $this->modifyPriority($old_priority, &$strError);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('strError', $strError);
				break;
			case 'new': 
				$this->setViewVariable('arr_info', null);
				break;
			default:
				//Muestra la ficha
				$this->setViewVariable('arr_info', null);
				break;
		}	
		
		//Obtiene todos los datos de los perfiles
		$all_profiles = $this->obj_data->getAllProfiles('profile_priority');		
		$this->setViewVariable('perfiles', $all_profiles);
		
		//Establecer el t�tulo de la p�gina
		$this->setPageTitle("miguel Profile Page");
		$this->setMessage('');
	
		//Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
		$this->setHelp('');
	}		
		
	function insertProfile(&$strError)
	{
		
		$profile['nombre'] = $this->getViewVariable('nom_form');
   		$profile['descripcion'] = $this->getViewVariable('des_form');
		$profile['prioridad'] = $this->getViewVariable('pri_form');
		
		$process1 = $this->checkVar("nom_form", "Nombre");
		$process2 = $this->checkVar("des_form", "Descripci�n");
		$process3 = $this->checkVar("pri_form", "Prioridad");
		
		if($process1 && $process2 && $process3){
			
			if ($profile['prioridad']<=0 || $profile['prioridad']>99){
				$strError = 'Prioridad no num�rica o rango no valido 1-99';
				
				
			}else{
				$sqlError = $this->obj_data->insertProfile($profile);
							
				if (!$sqlError){//Si ha habido error en la actualizacion
					$strError = 'Error insertando perfil';
				}else{
					$strError = 'Perfil insertado';
				}
			}
		}else{
			$strError = 'Faltan campos obligatorios';
		}
		
		return $profile;
				
	}

	function modifyPriority($old_priority, &$strError)
	{
	
		$new_priority = $this->getViewVariable('newpri_form_'.$old_priority);
		settype($new_priority,'integer');	
	
		if ($new_priority>0 && $new_priority<100){
			$sqlError = $this->obj_data->modifyPriority($old_priority, $new_priority);
			if (!$sqlError){//Si ha habido error en la actualizacion
				$strError = 'Error modificando prioridad';
			}else{
				$strError = 'Prioridad cambiada';
			}
		}else{
			$strError = 'Prioridad no num�rica o rango no valido 1-99';
		}
	
		return null;
				
	}
		
	function deleteProfile($del_profileid, $del_priority, &$strError)
	{
			
		$sqlError = $this->obj_data->deleteProfile($del_profileid, $del_priority);
						
		if (!$sqlError){//Si ha habido error en la actualizacion
			$strError = 'Error borrando perfil';
		}else{
			$strError = 'Perfil borrado';
		}
			
		return null;
				
	}	

	
	function checkVar($nom_var, $textoError)
	{
		static $strError;
		
		$bRet = $this->issetViewVariable($nom_var) && $this->getViewVariable($nom_var) != '';
		
		if (!$bRet){
			if($strError == ''){
				$strError = $textoError;
			} else {
				$strError .= ", $textoError";
			}
			
			$this->setViewVariable('strError', $strError);
		}
		
		return $bRet;
	}	
}
?>