<?php
/*
      +----------------------------------------------------------------------+
      |email                                                        |
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
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_CEmail extends miguel_Controller
{
	function miguel_CEmail() 
	{	
		$this->miguel_Controller();
		$this->setModuleName('email');
		$this->setModelClass('miguel_MEmail');
		$this->setViewClass('miguel_VEmail');
		$this->setCacheFlag(false);
	}
	
	function IsSetVar($var) 
	{
		return ($this->issetViewVariable($var) && $this->getViewVariable($var) != '');
	}
	
	function ParserTo($strTo)
	{
		$arrRet = explode (";", $strTo); 
		for ($i=0; $i<count($arrRet); $i++) {
			//Quito los espacios
			$arrRet[$i] = trim($arrRet[$i]);
			
			//Convierto el alias en su identificador numérico
			$arrRet[$i] = $this->obj_data->getUserFromAlias($arrRet[$i]);
		}
		return($arrRet);
	}

	function delTo()
	{
			$this->setViewVariable('to', ''); 	
			$this->setViewVariable('arrto', ''); 
	}

	function add2To()
	{
			$strTo = $this->getViewVariable('arrto');
			$listto = $this->getViewVariable('listto');
			if ($strTo != null)
			{
				$strTo = $strTo . ',';
			}
			$strTo = $strTo . $listto;
		
			$arrTo = explode(',',$strTo);
			$to = $this->obj_data->getNameFromUser($arrTo[0]);
			for ($i=1; $i<count($arrTo); $i++) {
				$name = $this->obj_data->getNameFromUser($arrTo[$i]);
				$to =  $to . ';' . $name;		
			}
			$this->setViewVariable('to', $to); 	
			$this->setViewVariable('arrto', $strTo); 
	}

	function SendMessage()
	{
		$bSended = false;
		if($this->IsSetVar('arrto') && $this->IsSetVar('body') && $this->IsSetVar('subject')) {
			$arrId = explode(',',$this->getViewVariable('arrto'));
			if (count($arrId)>0) {       
				//Realizamos una llamada al Modelo $this->obj_data->Método(Parámetros);
				if ($this->obj_data->sendMessage($arrId, $this->getViewVariable('subject'), $this->getViewVariable('body')) != null) {
					$bSended = true;
					$this->setViewVariable('strResult','El mensaje fue enviado correctamente.');
				} else {
					$this->setViewVariable('strResult','Error enviando mensaje.');
				}
			} else {
				$this->setViewVariable('strResult','Destinatario desconocido.');
			}
		}
		return($bSended);	  
	}

	function getShowData($id_msg)	
	{
		$arrMsg = $this->obj_data->getMessage($id_msg);
		$arrReceivers = $this->obj_data->getMessageReceivers($id_msg);
			
		//Componer la cadena de destinatarios
		for ($i=0; $i<count($arrReceivers); $i++)
		{
			$userAlias = $this->obj_data->getNameFromUser($arrReceivers[$i]['receiver_message.id_receiver']); 
			$strTo = $strTo . $userAlias . ';';
		}
					
		if ($arrMsg != null) {
			//Cambiamos el estado del mensaje a leído.
			$this->obj_data->changeMessageStatus($id_msg, 1);
	
			$from = $this->obj_data->getNameFromUser($arrMsg[0]['message.sender']);      	
			$this->setViewVariable('from', $from);	      	
			//Debug::oneVar($from, __FILE__, __LINE__);
			$this->setViewVariable('to', $strTo);
			$this->setViewVariable('date', $arrMsg[0]['message.date']);
			$this->setViewVariable('subject', $arrMsg[0]['message.subject']);
			$this->setViewVariable('body', $arrMsg[0]['message.body']);
		}
 	      
	}
	function processPetition() 	
	{
		//Consultar la variable status. Si no existe se establece a 'menú' 
	  if ($this->issetViewVariable('status'))
	  {
	  	$status = $this->getViewVariable('status');
	  }
	  else
	  {
	  	$status = 'menu';
	  	$status = $this->setViewVariable('status', 'menu');
	  }
	  //$this->addNavElement(Util::format_URLPath('email/index.php'), 'Mensajería');	
		  
		$this->setViewVariable('countUnreaded', $this->obj_data->getCountUnreaded());    
    switch($status)
	  {
	  	case 'new': //Nuevo comentario
			$this->setViewVariable('arrUsersCombo', $this->obj_data->getListUsersForCombo());
			if ($this->issetViewVariable('borrar')) {
				$this->delTo();
			} else if ($this->issetViewVariable('anadir')) { //Se necesita añadir un destinatario a la lista
				$this->add2To();
		    } else { //Se envía el mensaje
	  			$strResult = $this->setViewVariable('bSended', $this->SendMessage());	
		    }
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=new'),'Enviar');
	  		break;
	  	case 'show':
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=show'),'Lectura'); 
	   		$this->getShowData($this->getViewVariable('id'));
	   		break; 		
	  	case 'inbox': //Listar comentarios
	  	default:
			$this->clearNavBarr();
	  		//Si es necesario borrar algún correo se hace de forma lógica
		    if ($this->issetViewVariable('delete_id')) {
				$this->obj_data->changeMessageStatus($this->getViewVariable('delete_id'), 2);
    		}
    		
			$arrMessages = $this->obj_data->getUserMessages(Session::getValue('USERINFO_USER_ID'));
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=inbox'),'Bandeja de entrada');
	  		break;
	  	case 'outbox': //Listar comentarios
	  		//Si es necesario borrar algún correo se hace de forma lógica
		    if ($this->issetViewVariable('delete_id')) {
	 			$this->obj_data->changeMessageStatus($this->getViewVariable('delete_id'), 2);
    		}

	  		$arrMessages = $this->obj_data->getSendedMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=outbox'),'Bandeja de salida');
	  		break;
	  	case 'bin': //Listar comentarios
	  		//Si es necesario borrar algún correo se hace de forma definitiva
		    if ($this->issetViewVariable('delete_id')) {
	 			$this->obj_data->deleteMessage($this->getViewVariable('delete_id'), 2);
    		}

	  		$arrMessages = $this->obj_data->getDeletedMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	   		$this->addNavElement(Util::format_URLPath('email/index.php', 'status=bin'),'Papelera');
	  		break;
		}
	  	
		$this->setPageTitle("miguel Email Page");
	  $this->setMessage('');
	  $this->setHelp("");
	}
}
?>