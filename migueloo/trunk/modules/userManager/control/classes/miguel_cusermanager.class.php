<?php
/*
      +----------------------------------------------------------------------+
      |userManager/controller                                                |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CUserManager extends miguel_Controller
{
	function miguel_CUserManager()
	{	
		$this->miguel_Controller();
		$this->setModuleName('userManager');
		$this->setModelClass('miguel_MUserManager');
		$this->setViewClass('miguel_VUserManager');
		$this->setCacheFlag(false);
	}
		 
	function processPetition() 
	{
		//Control de acceso: por perfil
		$status = $this->getViewVariable('status');

		if($this->getSessionElement('userinfo','profile_id') != 5){
			$status = 'show';
		}

		//Debug::oneVar($this->arr_form, __FILE__, __LINE__);
		switch($status)
		{
			case 'cand':
				$user_id = $this->getViewVariable('id');
				
				if($this->issetViewVariable("submit") ){
					$this->processAddCandidate($user_id);
					$this->giveControl('secretariatPage', 'miguel_CSecretariatPage');
				} else {
					$this->setViewVariable('arr_info', $this->obj_data->getCandidateInfo($user_id));
					$this->addNavElement(Util::format_URLPath('userManager/index.php', 'status=cand&id='.$user_id),'Ficha');	
				}

				break;	
			case 'new':
				if($this->issetViewVariable("submit") ){
					if ($this->issetViewVariable("pid") ){
						$profile = $this->getViewVariable("pid");
					} else {
						$profile = 4; //Alumnos
					}
					$this->processNewUser($profile);
				} else {
					$this->addNavElement(Util::format_URLPath('userManager/index.php', 'status=new&pid='.$profile),'Registro');
				}
				break;	
			case 'show':
				//$this->setViewVariable('type', '');
				//$this->setViewVariable('prof', 'alumn');

				if($this->issetViewVariable("submit") ){
					$this->processChangeUser($this->getViewVariable('id'));
				} 

				$user_id = $this->getViewVariable('id');
				if(empty($user_id)){	
					$user_id =$this->getSessionElement( 'userinfo', 'user_alias' );
					$this->setViewVariable('id', $user_id);
				}
				$this->setViewVariable('arr_info', $this->obj_data->getUserInfo($user_id));

				$this->addNavElement(Util::format_URLPath('userManager/index.php', 'status=show&id='.$this->getViewVariable('id')),'Ficha');	
				
				break;
			default:
				if ($this->issetViewVariable("pid") ){
					$profile = $this->getViewVariable("pid");
				} else {
					$profile = 4; //Alumnos
				}
				
				$src_type = 0;
				$src_item = '';
				if ($this->issetViewVariable("orden") ){
					if ($this->issetViewVariable("data_form") && $this->getViewVariable('data_form') != ''){
						$src_type = $this->getViewVariable('orden');
						$src_item = $this->getViewVariable('data_form');
					}
				}
				
				$this->setViewVariable('arrUsers', $this->obj_data->getUserList($profile, $src_type, $src_item));
				
				$this->clearNavBarr();
				$this->addNavElement(Util::format_URLPath('userManager/index.php','status=list&pid='.$profile),'Listado');	
		}

		//Establecer el título de la página
		$this->setPageTitle("miguel User Manager");
		$this->setHelp('');
	}
	
	function processNewUser($profile)
	{
		//$this->setViewVariable('treatmentList', $this->obj_data->getTreatmentList());
        if ($this->issetViewVariable("submit") ){
			$process1 = $this->checkVar('nom_form', 'Nombre');
			$process2 = $this->checkVar('prenom_form', 'Primer apellido');
			$process3 = $this->checkVar('prenom_form2', 'Segundo apellido');
			$process4 = $this->checkVar('email', 'E-mail');
			$process5 = $this->checkVar('telefono1','Teléfono');

			if($process1 && $process2 && $process3 &&$process4 && $process5){
				if($_FILES['imagen']['tmp_name'] != null){
					list($name, $ext) = explode(".", $_FILES['imagen']['name']);
				} 
				
				if($_FILES['cv_doc']['tmp_name'] != null){
					list($namecv, $extcv) = explode(".", $_FILES['cv_doc']['name']);
				}
				
				//$fecha = $this->getViewVariable('_years') . '-' . $this->getViewVariable('_months') . '-' . $this->getViewVariable('_days');
				//if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
				$user_id = $this->obj_data->newInscription($this->getViewVariable('nif'), 
												$this->getViewVariable('nom_form'), 
												$this->getViewVariable('prenom_form'),
												$this->getViewVariable('prenom_form2'), 
												$this->getViewVariable('calle'),
												$this->getViewVariable('localidad'), 
												$this->getViewVariable('provincia'), 
												$this->getViewVariable('pais'), 
												$this->getViewVariable('codigo_postal'), 
												$this->getViewVariable('telefono1'),
												$this->getViewVariable('telefono2'),
												$this->getViewVariable('fax'),
												$this->getViewVariable('email'),
												$this->getViewVariable('email2'),
												$this->getViewVariable('email3'),
												$this->getViewVariable('web'),
												$this->getViewVariable('observaciones'),
												$ext, //imagen ext
												$extcv,//cv ext
												$profile
												);
				
				if($_FILES['imagen']['tmp_name'] != null){
					$filename = 'user_'.$user_id.'.'.$ext;
					//Procesamos fichero imagen
					$file_orig = $_FILES['imagen']['tmp_name'];
					if(is_uploaded_file($file_orig)){
						$file_dest = Util::formatPath(MIGUEL_APPDIR.'var/secretary/user_image/'.$filename);
						move_uploaded_file($file_orig, $file_dest);
					}	
				}
				if($_FILES['cv_doc']['tmp_name'] != null){
					$filename = 'user_'.$user_id.'.'.$ext;
					//Procesamos fichero imagen
					$file_orig = $_FILES['cv_doc']['tmp_name'];
					if(is_uploaded_file($file_orig)){
						$file_dest = Util::formatPath(MIGUEL_APPDIR.'var/secretary/user_cv/'.$filename);
						move_uploaded_file($file_orig, $file_dest);
					}	
				}
            }
		} 
	}
	
	function processChangeUser($user_id)
	{
        if ($this->issetViewVariable("submit") ){
			//$fecha = $this->getViewVariable('_years') . '-' . $this->getViewVariable('_months') . '-' . $this->getViewVariable('_days');
			//if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
			$this->obj_data->modifyUserInfo($user_id,
											$this->getViewVariable('calle'),
											$this->getViewVariable('localidad'), 
											$this->getViewVariable('provincia'), 
											$this->getViewVariable('pais'), 
											$this->getViewVariable('codigo_postal'), 
											$this->getViewVariable('telefono1'),
											$this->getViewVariable('telefono2'),
											$this->getViewVariable('fax'),
											$this->getViewVariable('email'),
											$this->getViewVariable('email2'),
											$this->getViewVariable('email3'),
											$this->getViewVariable('web'),
											$this->getViewVariable('observaciones'),
											$this->getViewVariable('contrase_a')
											);
		}
	}
	
	function processAddCandidate($person_id)
	{
		//$this->setViewVariable('treatmentList', $this->obj_data->getTreatmentList());
        if ($this->issetViewVariable("submit") ){
			$process1 = $this->checkVar('nom_form', 'Nombre');
			$process2 = $this->checkVar('prenom_form', 'Primer apellido');
			$process3 = $this->checkVar('prenom_form2', 'Segundo apellido');
			$process4 = $this->checkVar('email', 'E-mail');
			$process5 = $this->checkVar('telefono1','Teléfono');

			if($process1 && $process2 && $process3 &&$process4 && $process5){
				if($_FILES['imagen']['tmp_name'] != null){
					list($name, $ext) = explode(".", $_FILES['imagen']['name']);
				} 
				
				if($_FILES['cv_doc']['tmp_name'] != null){
					list($namecv, $extcv) = explode(".", $_FILES['cv_doc']['name']);
				}
				
				$profile = 4; //Siempre alumnos
				//$fecha = $this->getViewVariable('_years') . '-' . $this->getViewVariable('_months') . '-' . $this->getViewVariable('_days');
				//if($this->getViewVariable('passwd') == $this->getViewVariable('passwd2')){
				$user_id = $this->obj_data->newInscription($this->getViewVariable('nif'), 
												$this->getViewVariable('nom_form'), 
												$this->getViewVariable('prenom_form'),
												$this->getViewVariable('prenom_form2'), 
												$this->getViewVariable('calle'),
												$this->getViewVariable('localidad'), 
												$this->getViewVariable('provincia'), 
												$this->getViewVariable('pais'), 
												$this->getViewVariable('codigo_postal'), 
												$this->getViewVariable('telefono1'),
												$this->getViewVariable('telefono2'),
												$this->getViewVariable('fax'),
												$this->getViewVariable('email'),
												$this->getViewVariable('email2'),
												$this->getViewVariable('email3'),
												$this->getViewVariable('web'),
												$this->getViewVariable('observaciones'),
												$ext, //imagen ext
												$extcv,//cv ext
												$profile
												);
				
				if($_FILES['imagen']['tmp_name'] != null){
					$filename = 'user_'.$user_id.'.'.$ext;
					//Procesamos fichero imagen
					$file_orig = $_FILES['imagen']['tmp_name'];
					if(is_uploaded_file($file_orig)){
						$file_dest = Util::formatPath(MIGUEL_APPDIR.'var/secretary/user_image/'.$filename);
						move_uploaded_file($file_orig, $file_dest);
					}	
				}
				if($_FILES['cv_doc']['tmp_name'] != null){
					$filename = 'user_'.$user_id.'.'.$ext;
					//Procesamos fichero imagen
					$file_orig = $_FILES['cv_doc']['tmp_name'];
					if(is_uploaded_file($file_orig)){
						$file_dest = Util::formatPath(MIGUEL_APPDIR.'var/secretary/user_cv/'.$filename);
						move_uploaded_file($file_orig, $file_dest);
					}	
				}
				
				//Todo Ok, borramos candidato
				return $this->obj_data->deleteCandidateData($person_id);
            }
		} 
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