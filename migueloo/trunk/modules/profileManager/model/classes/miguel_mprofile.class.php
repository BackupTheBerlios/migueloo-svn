<?php
/*
	  +----------------------------------------------------------------------+
	  |newInscription/model                                                  |
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
class miguel_MProfile extends base_Model
{
	function miguel_MProfile()
	{	
		$this->base_Model();
	}
	
	//OK -> Devuelve el array con todo los perfiles ordenados
	//Error -> Devuelve null
	//-------------------------------------------------------------------------------------
	function getAllProfiles($Order)
	{
			
		//obtiene los datos de person
		$profiles = $this->SelectOrder('profile','id_profile, profile_description, profile_notes, profile_priority',$Order);
		
		if (! $this->hasError()){
			
			return $profiles;
			
		}else{ //La consulta ha devuelto un error

			return null;	
		}
			
	}

		
	//true -> OK
	//false -> error
	//-------------------------------------------------------------------------------------
	function addpriority($all_profiles, $cantidad, $priority_ini, $priority_fin){
		
		if ($priority_fin == null){
			$priority_fin = 99;	
		}
		
		//Recorre todos los perfiles
		for($i=0;$i<count($all_profiles);$i++){
						
			//Comprueba si el perfil tiene que aumentar de prioridad
			if ($all_profiles[$i]['profile.profile_priority'] >= $priority_ini && $all_profiles[$i]['profile.profile_priority'] <= $priority_fin ){
				
				$id = $all_profiles[$i]['profile.id_profile'];
				$pri = $all_profiles[$i]['profile.profile_priority'];
				$aux = $pri + $cantidad;
				if ($aux == 100){
					$aux =99;
				}
				if ($aux == 0){
					$aux = 1;
				}
				//Debug::oneVar($cantidad."->".$id."->".$all_profiles[$i]['profile.profile_description']."->".$pri);
				//Actualiza tabla
				$numupdates = $this->Update('profile','profile_priority',array($aux),"id_profile = $id");

				if ($this->hasError()){
					return false;
				}
				
			}
			
		}
		
		return true;
	}
	
	//true -> existe
	//false -> no existe
	//-------------------------------------------------------------------------------------
	function ispriority($all_profiles, $priority){
		
		//Recorre todos los perfiles
		for($i=0;$i<count($all_profiles);$i++){
						
			//Comprueba si el perfil tiene que aumentar de prioridad
			if ($priority == $all_profiles[$i]['profile.profile_priority']){
				return true;				
			}

		}
		
		return false;
	}

	//true -> OK
	//false -> error	
	//-------------------------------------------------------------------------------------
	function insertProfile($new_profile)
	{
		
		//Obtiene todos los perfiles (ordenados por prioridad)
		$all_profiles = $this->getAllProfiles();
		
		//Comprueba si existe esa prioridad
		if ($this->ispriority($all_profiles, $new_profile['prioridad'])){
			//a�ade priorida + 1 a los perfiles con prioridad >= que el perfil a insertar
			$strerror = $this->addpriority($all_profiles, 1, $new_profile['prioridad'], null);			
			if (! $strerror){
				return false;
			}
			
		}
		
		//Inserta perfil
		$ret_val = $this->Insert('profile',
								 'profile_description, profile_notes, profile_priority',
								 array($new_profile['nombre'],$new_profile['descripcion'],$new_profile['prioridad']));	
							
		if ($this->hasError())
		{
			return false;
		}
		
		return true;
		
	}

	function getIdProfile($all_profiles, $priority){
		
		//Recorre todos los perfiles
		for($i=0;$i<count($all_profiles);$i++){
						
			//Comprueba si el perfil tiene que aumentar de prioridad
			
			if ($priority == $all_profiles[$i]['profile.profile_priority']){
				
				return $all_profiles[$i]['profile.id_profile'];
				
			}
			
		}
		
		return false;
	}

	//true -> OK
	//false -> error
	//-------------------------------------------------------------------------------------		
	function deleteProfile($del_profileid, $del_priority)
	{

		//Borra el perfil
		$ret_val = $this->Delete('profile',"id_profile = $del_profileid");	

		if (!$this->hasError())
		{
			
			//Obtiene todos los perfiles (ordenados por prioridad)
			$all_profiles = $this->getAllProfiles('profile.profile_priority');
			//Elimina una prioridad a todos los perfiles por encima del eliminado
			$strerror = $this->addpriority($all_profiles, -1, $del_priority, null);
			if (!$strerror){
				return false;
			}
			
			
		}else{
			return false;
		}
			
		return true;
	}	

	//true -> OK
	//false -> error		
	//-------------------------------------------------------------------------------------
	function modifyPriority($old_priority, $new_priority)
	{

		//Obtiene todos los perfiles (ordenados por prioridad)
		$all_profiles = $this->getAllProfiles('profile.profile_priority');
		
		$priorityid = $this->getIdProfile($all_profiles, $old_priority);
		
		if ($old_priority == $new_priority){
			return true;	
		}
		
		//Comprueba si existe esa prioridad
		$existe = $this->ispriority($all_profiles, $new_priority);
		if ($existe){
			
			if($new_priority > $old_priority){
				//a�ade priorida + 1 a los perfiles con prioridad >= que el perfil a modificar
				$strerror = $this->addpriority($all_profiles, -1, $old_priority+1, $new_priority);			
				if (! $strerror){
					return false;
				}
			}else{
				//a�ade priorida + 1 a los perfiles con prioridad >= que el perfil a modificar
				$strerror = $this->addpriority($all_profiles, 1, $new_priority, $old_priority-1);			
				if (! $strerror){
					return false;
				}
			}
			
		}else{
			$strerror = $this->addpriority($all_profiles, -1, $old_priority+1, $new_priority);	
		}
								
		$ret_val = $this->Update('profile','profile_priority',array($new_priority),"id_profile = $priorityid");	

		if (!$this->hasError()){	
			
			return true;
			
		}else{
			return false;
		}
		
		return true;
	}
		
}
?>