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
	  | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
	  |          miguel Development Team                                     |
	  |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
	  +----------------------------------------------------------------------+
*/
class miguel_MEntityManager extends base_Model
{
	function miguel_MEntityManager()
	{	
		$this->base_Model();
	}
	
	//----------------------------------------------------------------
	// getEntity
	// Devuelve un array con los datos del person de la persona indicada
	// Devuelve null si la entidad no existe
	//----------------------------------------------------------------	
	function getEntity ($entityid){
	
		if ($entityid != null){
			//obtiene los datos de person	
			$sql_ret = $this->SelectMultiTable('institution, institution_data', 
											'institution.institution_name, institution.institution_description, institution.institution_identify,
											 institution_data.institution_data_code, institution_data.institution_data_address, institution_data.institution_data_city,
											 institution_data.institution_data_council, institution_data.institution_data_country, institution_data.institution_data_postalcode,
											 institution_data.institution_data_phone, institution_data.institution_data_phone2, institution_data.institution_data_phone3,
											 institution_data.institution_data_fax, institution_data.institution_data_email, institution_data.institution_data_email2,
											 institution_data.institution_data_email3, institution_data.institution_data_web, institution_data.institution_data_logo,
											 institution_data.institution_data_observations',
											"institution.institution_id = institution_data.institution_id and institution.institution_id = $entityid");
			if ($this->hasError()) {
	   			$entity = null;
	   		} else {
	   			
	   			for($i=0;$i<count($sql_ret);$i++){
		   		
		   			$entity['entityid'] = $entityid;
		   			$entity['name'] = $sql_ret[$i]['institution.institution_name'];
		   			$entity['description'] = $sql_ret[$i]['institution.institution_description'];
		   			$entity['identify'] = $sql_ret[$i]['institution.institution_identify'];
		   			$entity['code'] = $sql_ret[$i]['institution_data.institution_data_code'];
		   			$entity['address'] = $sql_ret[$i]['institution_data.institution_data_address'];
		   			$entity['city'] = $sql_ret[$i]['institution_data.institution_data_city'];
		   			$entity['council'] = $sql_ret[$i]['institution_data.institution_data_council'];
		   			$entity['country'] = $sql_ret[$i]['institution_data.institution_data_country'];
		   			$entity['postalcode'] = $sql_ret[$i]['institution_data.institution_data_postalcode'];
		   			$entity['phone1'] = $sql_ret[$i]['institution_data.institution_data_phone'];
		   			$entity['phone2'] = $sql_ret[$i]['institution_data.institution_data_phone2'];
		   			$entity['phone3'] = $sql_ret[$i]['institution_data.institution_data_phone3'];
		   			$entity['fax'] = $sql_ret[$i]['institution_data.institution_data_fax'];
		   			$entity['email1'] = $sql_ret[$i]['institution_data.institution_data_email'];
		   			$entity['email2'] = $sql_ret[$i]['institution_data.institution_data_email2'];
		   			$entity['email3'] = $sql_ret[$i]['institution_data.institution_data_email3'];
		   			$entity['web'] = $sql_ret[$i]['institution_data.institution_data_web'];
		   			$entity['logo'] = $sql_ret[$i]['institution_data.institution_data_logo'];
		   			$entity['observations'] = $sql_ret[$i]['institution_data.institution_data_observations'];
		   			
		   		}
	   		}
	   		
	   		//obtiene los datos de person
			$sql_ret = $this->Select('institution_contact','institution_contact_name, institution_contact_email, institution_contact_phone',"institution_id = $entityid");
	   		
	   		if ($this->hasError()) {
	   			$entity = null;
	   		} else {
	   			
	   			for($i=0;$i<count($sql_ret);$i++){
		   		
		   			$entity['contactname'.$i] = $sql_ret[$i]['institution_contact.institution_contact_name'];
		   			$entity['contactemail'.$i] = $sql_ret[$i]['institution_contact.institution_contact_email'];
		   			$entity['contactphone'.$i] = $sql_ret[$i]['institution_contact.institution_contact_phone'];
		   		}
	   		}
		}else{
			$entity = null;
		}
		
		return $entity;
	}

	

	function getMaxEntityId()
	{
		//insert institution
		$ret_val = $this->Select('institution',
								 'max(institution_id)');

							
		if ($this->hasError())
		{
			$ret_val = null;
		}
		
		$entityid = $ret_val[0]['institution.max(institution_id)'];
		
		return $entityid;
	}	

	function deleteEntity($p)
	{


		//delete institution contact
		$ret_val = $this->Delete('institution_contact', "institution_id = $p");

		if ($this->hasError())
		{
			return true;
		}
		
		//delete institution data
		$ret_val = $this->Delete('institution_data', "institution_id = $p");

		if ($this->hasError())
		{
			return true;
		}
		
		//delete institution
		$ret_val = $this->Delete('institution', "institution_id = $p");

		if ($this->hasError())
		{
			return true;
		}
		
		return false;
	}
		
	function insertEntity($p)
	{
		//insert institution
		$entityid = $this->Insert('institution',
								 'institution_name, institution_description, institution_identify',
								 array($p['name'],$p['description'],$p['identify']));

		if ($this->hasError())
		{
			return true;
		}
		
		//insert institution
		$p['entityid'] = $entityid;
		$ret_val = $this->Insert('institution_data',
								 'institution_id, institution_data_code, institution_data_address, 
								 institution_data_city, institution_data_council, institution_data_country,
								 institution_data_postalcode, institution_data_phone, institution_data_phone2,
								 institution_data_phone3, institution_data_fax, institution_data_email,
								 institution_data_email2, institution_data_email3, institution_data_web,
								 institution_data_logo, institution_data_observations',
								 array($p['entityid'],$p['code'],$p['address'],$p['city'],$p['council'],$p['country'],$p['postalcode'],$p['phone1'],$p['phone2'],$p['phone3'],$p['fax'],$p['email1'],$p['email2'],$p['email3'],$p['web'],$p['logo'],$p['observations']));

		if ($this->hasError())
		{
			return true;
		}

		//insert contact 0
		if ($p['contactname0'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname0'],$p['contactemail0'],$p['contactphone0']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 1
		if ($p['contactname1'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname1'],$p['contactemail1'],$p['contactphone1']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 2
		if ($p['contactname2'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname2'],$p['contactemail2'],$p['contactphone2']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 3
		if ($p['contactname3'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname3'],$p['contactemail3'],$p['contactphone3']));
		}	
		if ($this->hasError())
		{
			return true;
		}				
		return false;
	}
	
	function updateEntity($p)
	{
		
		//update institution
		$ret_val = $this->Update('institution',
								 'institution_name, institution_description, institution_identify',
								 array($p['name'],$p['description'],$p['identify']),
								 "institution_id = $p[entityid]");
							
		if ($this->hasError())
		{
						
			return true;
		}

		//update institution_data
		$ret_val = $this->Update('institution_data',
							 'institution_data_code, institution_data_address, institution_data_city, institution_data_council,
							 institution_data_country, institution_data_postalcode, institution_data_phone, institution_data_phone2,
							 institution_data_phone3, institution_data_fax, institution_data_email,
							 institution_data_email2, institution_data_email3, institution_data_web, institution_data_logo ,
							 institution_data_observations',
							 array($p['code'],$p['address'],$p['city'],$p['council'],$p['country'],$p['postalcode'],$p['phone1'],$p['phone2'],$p['phone3'],$p['fax'],$p['email1'],$p['email2'],$p['email3'],$p['web'],$p['logo'],$p['observations']),
							 "institution_id = $p[entityid]");
						
		if ($this->hasError())
		{
			return true;
		}


		//delete institution contact
		$ret_val = $this->Delete('institution_contact', "institution_id = $p[entityid]");

		if ($this->hasError())
		{
			return true;
		}
		
		//insert contact 0
		if ($p['contactname0'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname0'],$p['contactemail0'],$p['contactphone0']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 1
		if ($p['contactname1'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname1'],$p['contactemail1'],$p['contactphone1']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 2
		if ($p['contactname2'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname2'],$p['contactemail2'],$p['contactphone2']));
		}	
		if ($this->hasError())
		{
			return true;
		}
		//insert contact 3
		if ($p['contactname3'] != ''){
			$contactid = $this->Insert('institution_contact',
								 'institution_id, institution_contact_name, institution_contact_email, institution_contact_phone',
								 array($p['entityid'],$p['contactname3'],$p['contactemail3'],$p['contactphone3']));
		}	
		if ($this->hasError())
		{
			return true;
		}				

				
		return false;
		
		//update institution_contact
		
		
	}
	
}
?>