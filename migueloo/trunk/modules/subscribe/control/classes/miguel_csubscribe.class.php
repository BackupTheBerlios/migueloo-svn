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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 *
 */

class miguel_CSubscribe extends miguel_Controller
{	
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CSubscribe()
	{	
		$this->miguel_Controller();
		$this->setModuleName('subscribe');
		$this->setModelClass('miguel_MSubscribe');
		$this->setViewClass('miguel_VIntro');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
		//Se controla que el usuario no tenga acceso. 
                $bol_hasaccess = false;
		
                //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
                $user_id = $this->getSessionElement( 'userinfo', 'user_id' );

                if ( isset($user_id) && $user_id != '' ) {
                    $bol_hasaccess = true;
                    $user = $this->getSessionElement( 'userinfo', 'user_alias' );
                } else {
                }
 
                if($bol_hasaccess) {
                    if ( $user == 'guest' ) { 
                    //Error, el usuario no puede ser el invitado
          
                    } else {
                    	//Miramos si se puede hacer la inscripción directa
                      $course_id = $this->getViewVariable('course_id');                    	
                    	$courseAccess = miguel_CourseInfo::getAccess($this->obj_data, $course_id);
                    	if ( !$courseAccess ) {
                        //Realiza la inscripciÛn directa en el curso
                        $this->_subscribeCourse($user_id, $course_id);
                        $this->addNavElement(Util::format_URLPath('main/index.php'), agt('miguel_Courses') );
                        $course_name = $this->obj_data->getCourseName( $course_id );
                        $this->setViewVariable( 'course_name', $course_name);
                        $subject = agt('miguel_newCourseSubscriptionSubject') . ' ' . $course_name;
                        $body = $course_name . ',\n ' . agt('miguel_newCourseSubscriptionBody') . '\n' . agt('miguel_disclaimer');
                    	} else {
                    		//La inscripción ha de ser validada por el responsable
                        $subject = agt('miguel_newCourseSubscriptionPending') . ' ' . $course_name;
                        $body = $course_name . ',\n ' . agt('miguel_newCourseSubscriptionBody') . '\n' . agt('miguel_disclaimer');                   		
                    	}

                      //Realiza la notificacion si esta permitido
                      if ( $this->getSessionElement( 'userinfo', 'notify_email' ) ) {
                        	include_once(Util::base_Path("include/classes/mailer.class.php"));
                          $mail = new miguel_mailer();

                          $mail->From = $this->getSessionElement( 'userinfo', 'email' );
                          $mail->FromName =  $this->getSessionElement( 'userinfo', 'name' ) . ' ' . $this->getSessionElement( 'userinfo', 'surname' ) ;
                          $mail->AddAddress($this->getSessionElement( 'userinfo', 'email' ), $this->getSessionElement( 'userinfo', 'name' ));
                          $mail->AddReplyTo($this->getSessionElement( 'userinfo', 'email' ), $this->getSessionElement( 'userinfo', 'name' ));
                  
                          $mail->Subject = $subject;
                          $mail->Body    = $body;
                          if(!$mail->Send()) {
                              echo "Message could not be sent. <p>";
                              echo "Mailer Error: " . $mail->ErrorInfo;
                             //exit;
                          }
                      }

                      $this->setCacheFile("miguel_VSubscribe_" . $this->getSessionElement("userinfo", "user_id"));
                      $this->setMessage(agt("miguel_userSubscribe"));
                      $this->setPageTitle("miguel_userSubscribe");
                  }
                } else { 
                    //Bienvenida
                }
                $this->setCacheFlag(true);
                $this->setHelp("EducContent");                
        }

        function _subscribeCourse($user_id, $course_id)
        {
            $this->obj_data->subscribeUserCourse($user_id, $course_id);
        }
}
?>
