<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
	  |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CNewCourse extends miguel_Controller
{
	/**
	* This is the constructor.
	*
	*/
	function miguel_CNewCourse()
	{	
		$this->miguel_Controller();
		$this->setModuleName('newCourse');
		$this->setModelClass('miguel_MNewCourse');
		$this->setViewClass('miguel_VNewCourse');
		$this->setCacheFlag(false);
		$this->addNavElement(Util::format_URLPath("newCourse/index.php"), "Nuevo Curso");	
		$this->setHelp("");	
	}
	
	function processPetition() 
	{
		$this->setHelp("EducContent");  
						
		//Primero comprueba si estamos identificados y si no es asi 
		//entonces vamos a ver si es una peticion de autenticacion
		if ($this->HasAccess())
		{
			if ($this->issetViewVariable('submit')) 
			{
				$courseData = $this->GetForm();
				
				if ($this->CheckForm($courseData))
				{
				$this->obj_data->createNewCourse($courseData, $user_id);
				
				$this->setViewClass('miguel_VResultNewCourse');   
				$this->setViewVariable('courseName', $courseData['c_name']);
				$this->setViewVariable('courseDescription', $courseData['cd_descripcion']);
				
				//$this->SendNotification();
		
				$this->setCacheFile("miguel_VResultNewCourse_" . $this->getSessionElement("userinfo","user_id"));
				$this->setCacheFlag(true);  		
				
				$this->setPageTitle( 'miguel_ResultNewCourse' );
		
				return;
				}
				
				$this->setViewVariable('courseDataForm', $courseData);
			}
			else
			{
				$this->setMessage(agt('Rellene el formulario para insertar un nuevo curso.') );
			}
		
			$this->setPageTitle( 'miguel_NewCourse' );
			$this->setViewVariable('courseDataForm', $this->GetDefaultForm() );
		
			//$this->addNavElement(Util::format_URLPath("newCourse/index.php", "course=".$course_id), $infoCourse['name']);
			$this->setCacheFile("miguel_VNewCourse_" . $this->getSessionElement("userinfo","user_id"));
			$this->setCacheFlag(true);  		
		}
		else
		{
			header('Location:' . Util::format_URLPath('main/index.php') );
		}
	}  
	
	
	function HasAccess()
	{
		$user_id = $this->getSessionElement( 'userinfo', 'user_id' );
		if ( isset($user_id) && $user_id != '' ){
			return true;
		} else {
			return false;
		}
	}
	
	function CheckForm($formData)
	{
		if ($formData['c_name'] == '')
		{
			$this->setMessage(agt('El campo nombre es obligatorio'));
			return false;
		}
		if ($formData['cd_descripcion'] == '')
		{
			$this->setMessage(agt('El campo descripción es obligatorio'));
			return false;
		}
		if ($formData['cd_destinatarios'] == '')
		{
			$this->setMessage(agt('El campo destinatario es obligatorio'));
			return false;
		}
		if ($formData['cd_metodologia'] == '')
		{
			$this->setMessage(agt('El campo metodología es obligatorio'));
			return false;
		}
		
		return true;
	}              
	
	function GetForm()
	{
		return Array(
			//'institution' => $navinfo_institution,
			//'faculty' => $navinfo_faculty,
			//'department' => $this->getSessionElement( 'navinfo', 'department_id' ),
			//'area' => $this->getSessionElement( 'navinfo', 'area_id' ),
			//'user_id' => $user_id,
			'c_name' => $this->getViewVariable('coursename'),
			'c_language' => $this->getViewVariable('courselanguage'),
			'c_description' => $this->getViewVariable('coursedatadescripcion'),
			'c_access' => $this->getViewVariable('courseaccess'),
			'c_active' => $this->getViewVariable('courseactive'),
			'c_user' => $this->getSessionElement( 'userinfo', 'user_id' ),
			'cd_descripcion' => $this->getViewVariable('coursedatadescripcion'),
			'cd_version' => $this->getViewVariable('coursedataversion'),
			'cd_claves' => $this->getViewVariable('coursedatapalabrasclaves'),
			'cd_destinatarios' => $this->getViewVariable('coursedatadestinatarios'),
			'cd_conocimientos' => $this->getViewVariable('coursedataconocimientosprevios'),
			'cd_metodologia' => $this->getViewVariable('coursedatametodologia'));
	}              
	
	function GetDefaultForm()
	{
		return Array(
			//'institution' => $navinfo_institution,
			//'faculty' => $navinfo_faculty,
			//'department' => $this->getSessionElement( 'navinfo', 'department_id' ),
			//'area' => $this->getSessionElement( 'navinfo', 'area_id' ),
			//'user_id' => $user_id,
			'c_name' => '',
			'c_language' => '',
			'c_description' => '',
			'c_access' => '',
			'c_active' => '',
			'cd_descripcion' => '',
			'cd_version' => '',
			'cd_claves' => '',
			'cd_destinatarios' => '',
			'cd_conocimientos' => '',
			'cd_metodologia' => '');
	}              
				
	function SendNotification()
	{
		//Realiza la notificacion si esta permitido
	if ( $this->getSessionElement( 'userinfo', 'notify_email' ) ) 
	{
		include_once(Util::base_Path("include/classes/mailer.class.php"));
		$mail = new miguel_mailer();
	
		$mail->From = $this->getSessionElement( 'userinfo', 'email' );
		$mail->FromName =  $this->getSessionElement( 'userinfo', 'name' ) . ' ' . $this->getSessionElement( 'userinfo', 'surname' ) ;
		$mail->AddAddress($this->getSessionElement( 'userinfo', 'email' ), $this->getSessionElement( 'userinfo', 'name' ));
		$mail->AddReplyTo($this->getSessionElement( 'userinfo', 'email' ), $this->getSessionElement( 'userinfo', 'name' ));
					
		$mail->Subject = agt('miguel_newCourseSubject') . ' ' . $courseData['name'];
		$mail->Body    = $course_name . ',\n ' . agt('miguel_newCourseSubscriptionBody') . '\n' . agt('miguel_disclaimer');                  
		if(!$mail->Send()) 
		{
		echo "Message could not be sent. <p>";
		echo "Mailer Error: " . $mail->ErrorInfo;
		}
	}
	}           
}
?>