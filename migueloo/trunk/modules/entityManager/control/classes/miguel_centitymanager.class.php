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
	  | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
	  |          miguel Development Team                                     |
	  |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
	  +----------------------------------------------------------------------+
*/

class miguel_CEntityManager extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CEntityManager()
	{	
		$this->miguel_Controller();
		$this->setModuleName('entityManager');
		$this->setModelClass('miguel_MEntityManager');
		$this->setViewClass('miguel_VEntityManager');
		$this->setCacheFlag(false);
	}
	
	function processPetition() 
	{
		
		//Debug::oneVar($_SESSION);
		
		
		$entityid = 32;
		
		//Consultar la variable status.
		if ($this->issetViewVariable('submit')) {
			$accion = $this->getViewVariable('submit');
		} else {
			$accion = $this->setViewVariable('submit', '');
		}

		$strError = '';
		switch($accion)
		{
			case 'Actualizar datos': 
				
				$arr_info = $this->ActualizaFicha($entityid, &$strError);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('view', 'fic');
				$this->setViewVariable('strError', $strError);
				break;
			case 'imprimir ficha':
				$arr_info = $this->ImprimeFicha($entityid);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('view', 'fic');
				$this->setViewVariable('strError', 'Imprimiendo ficha ..... ');
				break;
			case 'Registrar entidad':
				$arr_info = $this->RegistraFicha(&$strError);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('view', 'reg');
				$this->setViewVariable('strError', $strError);
				break;
			case 'new':
				//Muestra un registro vacio
				$this->setViewVariable('view', 'reg');
				break;
			case 'del':
			
				$this->BorraFicha($entityid, &$strError);
				$this->setViewVariable('view', 'reg');	
				break;
			default:
				//Muestra la ficha
				$arr_info = $this->obj_data->getEntity($entityid);
				$this->setViewVariable('arr_info', $arr_info);
				$this->setViewVariable('view', 'fic');
		}	
		$this->setViewVariable('id', $entityid);
	}
	
	function BorraFicha(&$strError)
	{
		$entityid = $this->getViewVariable('entity');
		
		$sqlError = $this->obj_data->deleteEntity($entityid);
		
		if ($sqlError){//Si ha habido error en la actualizacion
			$strError = 'Error borrando datos';
			$arr_info = $this->obj_data->getEntity($entityid);
		}else{
			$strError = 'Entidad borrada';
			$arr_info = $entityUpdate;
		}
	}
	
	function ActualizaFicha($entityid, &$strError)
	{
		
		$process1 = $this->checkVar("nomcom_form", "nombre comercial");
		$process2 = $this->checkVar("razon_form", "razón social");
		$process3 = $this->checkVar("cif_form", "CIF");
		$process4 = $this->checkVar("telefono1_form", "teléfono1");

		if($process1 && $process2 && $process3 &&$process4){
			
			//obtiene array del formulario
			
			$entityUpdate['entityid'] = $entityid;
   			$entityUpdate['name'] = $this->getViewVariable('nomcom_form');
   			$entityUpdate['description'] = $this->getViewVariable('razon_form');
   			$entityUpdate['identify'] = $this->getViewVariable('cif_form');
   			$entityUpdate['code'] = $this->getViewVariable('codigo_form');
   			$entityUpdate['address'] = $this->getViewVariable('dir_form');
   			$entityUpdate['city'] = $this->getViewVariable('pob_form');
   			$entityUpdate['council'] = $this->getViewVariable('pro_form');
   			$entityUpdate['country'] = $this->getViewVariable('pais_form');
   			$entityUpdate['postalcode'] = $this->getViewVariable('postal_form');
   			$entityUpdate['phone1'] = $this->getViewVariable('telefono1_form');
   			$entityUpdate['phone2'] = $this->getViewVariable('telefono2_form');
   			$entityUpdate['phone3'] = $this->getViewVariable('telefono3_form');
   			$entityUpdate['fax'] = $this->getViewVariable('fax_form');
   			$entityUpdate['email1'] = $this->getViewVariable('email1_form');
   			$entityUpdate['email2'] = $this->getViewVariable('email2_form');
   			$entityUpdate['email3'] = $this->getViewVariable('email3_form');
   			$entityUpdate['web'] = $this->getViewVariable('web_form');
   			$entityUpdate['logo'] = $this->getViewVariable('logo_form');
   			$entityUpdate['observations'] = $this->getViewVariable('observation_form');
			
			$entityUpdate['contactname0'] = $this->getViewVariable('contact_person1_form');
			$entityUpdate['contactemail0'] = $this->getViewVariable('email_person1_form');
			$entityUpdate['contactphone0'] = $this->getViewVariable('telefono_person1_form');
			
			$entityUpdate['contactname1'] = $this->getViewVariable('contact_person2_form');
			$entityUpdate['contactemail1'] = $this->getViewVariable('email_person2_form');
			$entityUpdate['contactphone1'] = $this->getViewVariable('telefono_person2_form');

			$entityUpdate['contactname2'] = $this->getViewVariable('contact_person3_form');
			$entityUpdate['contactemail2'] = $this->getViewVariable('email_person3_form');
			$entityUpdate['contactphone2'] = $this->getViewVariable('telefono_person3_form');

			$entityUpdate['contactname3'] = $this->getViewVariable('contact_person4_form');
			$entityUpdate['contactemail3'] = $this->getViewVariable('email_person4_form');
			$entityUpdate['contactphone3'] = $this->getViewVariable('telefono_person4_form');
			
			$sqlError = $this->obj_data->updateEntity($entityUpdate);
						
			if ($sqlError){//Si ha habido error en la actualizacion
				$strError = 'Error actualizando datos';
				$arr_info = $this->obj_data->getEntity($entityid);
			}else{
				$strError = 'Entidad actualizada';
				$arr_info = $entityUpdate;
			}
			
		}else{
			$strError = 'Faltan campos obligatorios';
			$arr_info = $this->obj_data->getEntity($entityid);
		}
		
		return $arr_info;
				
	}
	
	function ImprimeFicha($entityid)
	{
		return $this->obj_data->getEntity($entityid);;
	}
	
	function RegistraFicha(&$strError)
	{
		$process1 = $this->checkVar("nomcom_form", "nombre comercial");
		$process2 = $this->checkVar("razon_form", "razón social");
		$process3 = $this->checkVar("cif_form", "CIF");
		$process4 = $this->checkVar("telefono1_form", "teléfono1");

		if($process1 && $process2 && $process3 &&$process4){
			
			//obtiene array del formulario
			$entityid = 22;//$this->obj_data->getMaxEntityId()+1;

			$entityInsert['entityid'] = $entityid;
			$entityInsert['name'] = $this->getViewVariable('nomcom_form');
   			$entityInsert['description'] = $this->getViewVariable('razon_form');
   			$entityInsert['identify'] = $this->getViewVariable('cif_form');
   			$entityInsert['code'] = $this->getViewVariable('codigo_form');
   			$entityInsert['address'] = $this->getViewVariable('dir_form');
   			$entityInsert['city'] = $this->getViewVariable('pob_form');
   			$entityInsert['council'] = $this->getViewVariable('pro_form');
   			$entityInsert['country'] = $this->getViewVariable('pais_form');
   			$entityInsert['postalcode'] = $this->getViewVariable('postal_form');
   			$entityInsert['phone1'] = $this->getViewVariable('telefono1_form');
   			$entityInsert['phone2'] = $this->getViewVariable('telefono2_form');
   			$entityInsert['phone3'] = $this->getViewVariable('telefono3_form');
   			$entityInsert['fax'] = $this->getViewVariable('fax_form');
   			$entityInsert['email1'] = $this->getViewVariable('email1_form');
   			$entityInsert['email2'] = $this->getViewVariable('email2_form');
   			$entityInsert['email3'] = $this->getViewVariable('email3_form');
   			$entityInsert['web'] = $this->getViewVariable('web_form');
   			$entityInsert['logo'] = $this->getViewVariable('logo_form');
   			$entityInsert['observations'] = $this->getViewVariable('observation_form');
			
			$entityInsert['contactname0'] = $this->getViewVariable('contact_person1_form');
			$entityInsert['contactemail0'] = $this->getViewVariable('email_person1_form');
			$entityInsert['contactphone0'] = $this->getViewVariable('telefono_person1_form');
			
			$entityInsert['contactname1'] = $this->getViewVariable('contact_person2_form');
			$entityInsert['contactemail1'] = $this->getViewVariable('email_person2_form');
			$entityInsert['contactphone1'] = $this->getViewVariable('telefono_person2_form');

			$entityInsert['contactname2'] = $this->getViewVariable('contact_person3_form');
			$entityInsert['contactemail2'] = $this->getViewVariable('email_person3_form');
			$entityInsert['contactphone2'] = $this->getViewVariable('telefono_person3_form');

			$entityInsert['contactname3'] = $this->getViewVariable('contact_person4_form');
			$entityInsert['contactemail3'] = $this->getViewVariable('email_person4_form');
			$entityInsert['contactphone3'] = $this->getViewVariable('telefono_person4_form');
			
			$sqlError = $this->obj_data->insertEntity($entityInsert);
						
			if ($sqlError){//Si ha habido error en la actualizacion
				$strError = 'Error insertando datos';
				$arr_info = $this->obj_data->getEntity($entityid);
			}else{
				$strError = 'Entidad insertada';
				$arr_info = $entityInsert;
			}
			
		}else{
			$strError = 'Faltan campos obligatorios';
			$arr_info = $this->obj_data->getEntity($entityid);
		}
		
		return $arr_info;

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