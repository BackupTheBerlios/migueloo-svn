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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CNewInscription extends miguel_Controller
{
	function miguel_CNewInscription()
	{	
		$this->miguel_Controller();
		$this->setModuleName('newInscription');
		$this->setModelClass('miguel_MNewInscription');
		$this->setViewClass('miguel_VNewInscription');
		$this->setCacheFlag(false);
	}
    
	function processPetition() 
	{
		//$this->setViewVariable('treatmentList', $this->obj_data->getTreatmentList());
        if ($this->issetViewVariable("submit") ){
			$this->processNewInscription();
			$this->setViewVariable('newclient', 'ok');
			$this->giveControl('main', 'miguel_CMain');
		}		
	}
    
	function processNewInscription()
	{
		//$this->setViewVariable('treatmentList', $this->obj_data->getTreatmentList());
        if ($this->issetViewVariable("submit") ){
			$process1 = $this->checkVar('nom_form', 'Nombre');
			$process2 = $this->checkVar('prenom_form', 'Primer apellido');
			$process3 = $this->checkVar('prenom_form2', 'Segundo apellido');
			$process4 = $this->checkVar('email', 'E-mail');
			$process5 = $this->checkVar('telefono1','Teléfono');

			if($process1 && $process2 && $process3 &&$process4 && $process5){
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
												$this->getViewVariable('web')
												);
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