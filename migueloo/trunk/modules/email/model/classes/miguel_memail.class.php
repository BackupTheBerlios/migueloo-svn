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
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MEmail extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MEmail() 
    { 
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
    
    //Implementa el método insertSugestion
    function sendMessage($arrId, $str_subject, $str_body)
    {
        //Obtiene la fecha actual, función de PHP
        $now = date("Y-m-d H:i:s");
        
        //Debug::oneVar($str_subject, __FILE__, __LINE__);
        //Debug::oneVar($str_body, __FILE__, __LINE__);
        //Debug::oneVar($str_now, __FILE__, __LINE__);
        
       $iMyId = Session::getValue('USERINFO_USER_ID');
        
        //Inserta en la tabla todo. Los parámetros de Insert son: tabla, campos y valores
        $iMsgId = $this->Insert('message',
                                 'sender,subject,body,date',
                                 array($iMyId,$str_subject,$str_body,$now));
                                 
       	if ($this->hasError()) 
				{
    			$ret_val = null;
    		}
    		else
    		{
    			for ($i=0; $i<count($arrId); $i++)
    			{
    				if ($arrId[$i]!='')
    				{
	    				//Debug::oneVar($arrId[$i], __FILE__, __LINE__);
							//Inserta en la tabla de mensajes_recividos 
  		      	$this->Insert('receiver_message',
                                 'id_receiver,id_message,status',
                                 "$arrId[$i],$iMsgId,0");
            }
          }
    			$ret_val=$iMsgId;
        }
        //Comprueba si ha ocurrido algún error al realizar la operación
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	
    	return ($ret_val);
    }

	    /*===================================================================
    	Devuelve la lista de usuarios para mostrarla en una lista
    	===================================================================*/
	    function getListUsersForCombo()
		{
		 	$arrUsers = $this->SelectMultiTable('user, person', 
														'user.user_id, person.person_name, person.person_surname', 
														'user.person_id = person.person_id');

    		if ($this->hasError() || count($arrUsers) == 0 || $arrUsers[0]['user.user_id']==null) 	{
    			$ret_val = null;
    		}
    		else
    		{
				for ($i=0; $i<count($arrUsers); $i++)
				{
					$key = $arrUsers[$i]['person.person_name'] . '  ' . $arrUsers[$i]['person.person_surname'];
    				$ret_val[$key] = $arrUsers[$i]['user.user_id'];
				}
    		}

    	return ($ret_val);
    }


    /*===================================================================
    	Devuelve el id del usuario cuyo alias sea user_alias
    	===================================================================*/
    function getUserFromAlias($user_alias)
    {
		 	$arrUsers = $this->Select('user', 'user_id', "USER_ALIAS = $user_alias");

    	if ($this->hasError() || count($arrUsers) == 0) 
			{
    		$ret_val = null;
    	}
    	else
    	{
    			$ret_val= $arrUsers[0]['user.user_id'];
    	}

    	return ($ret_val);
    }

    /*===================================================================
    	Devuelve el id del usuario cuyo alias sea user_alias
    	===================================================================*/
    function getAliasFromUser($user_id)
    {
		 	$arrUsers = $this->Select('user', 'user_alias', "user_id = $user_id");

	    //Debug::oneVar($arrUsers,__FILE__,__LINE__);

    	if ($this->hasError() || count($arrUsers) == 0) 
			{
    		$ret_val = null;
    	}
    	else
    	{
    			$ret_val= $arrUsers[0]['user.user_alias'];
    	}

    	return ($ret_val);
    }
	   /*===================================================================
    	Devuelve el nombre del usuario
    	===================================================================*/
    function getNameFromUser($user_id)
    {
			if ($user_id == null || $user_id == '') {
				return(null);
			}
		 	$arrUsers = $this->SelectMultiTable('user,person', 'person.person_name, person.person_surname, person.person_id', "user_id = $user_id AND person.person_id = user.person_id");

	    //Debug::oneVar($arrUsers,__FILE__,__LINE__);

    	if ($this->hasError() || count($arrUsers) == 0) 
			{
    		$ret_val = null;
    	}
    	else
    	{
    			$ret_val= $arrUsers[0]['person.person_name'] . ' ' . $arrUsers[0]['person.person_surname'];
    	}

    	return ($ret_val);
    }

    function getUserMessages($_user_id)
    {
		$ret_val = $this->SelectMultiTable('person,message,receiver_message,user', 
										'user.user_alias, user.user_id, message.sender,message.subject,message.body,message.date,receiver_message.status,message.id, person.person_name, person.person_surname',
										'user.user_id = message.sender AND receiver_message.id_message = message.id AND receiver_message.id_receiver = '.$_user_id.' AND receiver_message.status < 2 AND user.person_id = person.person_id');

		if ($this->hasError()) {
			$ret_val = null;
		} else {
			for($i=0; $i<count($ret_val);$i++){
				$ret_val[$i]['is_logged'] = $this->isLogged($ret_val[$i]['user.user_alias']);
			}
		}
		
		return $ret_val ;
    }

    /*===================================================================
    	Devuelve los mensajes borrados por el usuario actual
    	===================================================================*/
    function getDeletedMessages()
    {
		$iMyId = Session::getValue('USERINFO_USER_ID');
			
		$ret_val = $this->SelectMultiTable('message,receiver_message,user,person', 
											'user.user_id, user.user_alias, message.sender,message.subject,message.body,message.date,receiver_message.status,message.id, person.person_name, person.person_surname',
											"user.user_id = receiver_message.id_receiver AND receiver_message.id_message = message.id AND receiver_message.id_receiver = $iMyId AND receiver_message.status = 2  AND user.person_id = person.person_id");
		
		if ($this->hasError()) {
			$ret_val = null;
		} else {
			for($i=0; $i<count($ret_val);$i++){
				$ret_val[$i]['is_logged'] = $this->isLogged($ret_val[$i]['user.user_alias']);
			}
		} 
				
		return($ret_val);
    }

    /*===================================================================
    	Cambia de estado un mensaje.
    	Estados: 0 - Sin leer, 1 - Leído, 2 - Borrado
    =====================================================================*/
    function changeMessageStatus($id_msg, $messageStatus)
    {
     		$iMyId = Session::getValue('USERINFO_USER_ID');

				//Atención: Los mensajes con estado 2 no se verán afectados.    
      	$ret_val = $this->Update('receiver_message', 
																 'status', 
																  $messageStatus, 
																	"id_message = $id_msg AND id_receiver = $iMyId AND status < 2"
																	); 

        if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 	
		}

    /*===================================================================
    	Borra el mensaje id_msg
    =====================================================================*/
    function deleteMessage($id_msg)
    {
     		$iMyId = Session::getValue('USERINFO_USER_ID');

				//Atención: Los mensajes con estado 2 no se verán afectados.    
      	$ret_val = $this->Delete('receiver_message', 
																	"id_message = $id_msg AND id_receiver = $iMyId"
																	); 

        if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 	
		}

    /*===================================================================
    	Devuelve los mensajes enviados por el usuario actual
    	===================================================================*/
    function getSendedMessages()
    {
		$iMyId = Session::getValue('USERINFO_USER_ID');
		
		$ret_val = $this->SelectMultiTable('message,receiver_message,user,person', 
											'user.user_id, user.user_alias, message.sender,message.subject,message.body,message.date,receiver_message.status,message.id, person.person_name, person.person_surname',
											"user.user_id = receiver_message.id_receiver AND receiver_message.id_message = message.id AND message.sender = $iMyId AND receiver_message.status < 2  AND user.person_id = person.person_id");

        if ($this->hasError()) {
        	$ret_val = null;
        } else {
			for($i=0; $i<count($ret_val);$i++){
				$ret_val[$i]['is_logged'] = $this->isLogged($ret_val[$i]['user.user_alias']);
			}
		}
		
		return($ret_val);
    }

    /*===================================================================
    	Devuelve el contenido del mensaje con identificador $message_id
    	===================================================================*/
    function getMessage($message_id)
    {
		//$iMyId = Session::getValue('USERINFO_USER_ID');
		$ret_val = $this->Select('message', 
                                 'sender, subject, body, date',
                                 "id = $message_id");
				
        if ($this->hasError())  {
        	$ret_val = null;
        } 
		
		return($ret_val);
    }

    /*===================================================================
    	Devuelve los destinatarios del mensaje con identificador $message_id
    	===================================================================*/
    function getMessageReceivers($message_id)
    {
		$ret_val = $this->Select('receiver_message', 
                                 'id_receiver',
                                 "id_message = $message_id"); 	
        
		if ($this->hasError()) {
        	$ret_val = null;
        } 
		
		return($ret_val);
    }

    /*===================================================================
    	Devuelve los mensajes sin leerisLogged($_nick)
    	===================================================================*/
    function getCountUnreaded()
    {
		$iMyId = Session::getValue('USERINFO_USER_ID');
    
    	$ret_val = $this->SelectCount('receiver_message',
    					"id_receiver = $iMyId AND status = 0");
    						
    	return($ret_val);
	}
	
	function isLogged($_nick)
    {
		$log_sql = $this->SelectMultiTable('user, user_logged', 'user_logged.is_logged', 'user.user_id = user_logged.user_id AND user.user_alias = '.$_nick);

		if ($this->hasError()) {
			$ret_val = false;
		} else {
			if($log_sql[0]['user_logged.is_logged'] == null){
				$ret_val = false;
			} else {
				$ret_val = true;
			}	
		}
		
		return $ret_val;
    }
}    
?>