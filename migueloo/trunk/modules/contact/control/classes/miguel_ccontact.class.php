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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */
/**
 *
 */

class miguel_CContact extends miguel_Controller
{
        function miguel_CContact()
        {
                $this->miguel_Controller();
                $this->setModuleName('contact');
                $this->setModelClass('miguel_MContact');
            $this->setViewClass('miguel_VMain');
                $this->setCacheFlag(false);
        }

		function _setContactLists($id)
		{
			$arr_contacts_teacher = $this->obj_data->listContact($id, 2);
			$arr_contacts_tutor = $this->obj_data->listContact($id, 3);
			$arr_contacts_alumn = $this->obj_data->listContact($id, 4);
			$arr_external_contacts = $this->obj_data->listExternalContact($id);
            $this->setViewVariable('arr_contacts_teacher', $arr_contacts_teacher );
            $this->setViewVariable('arr_contacts_tutor', $arr_contacts_tutor );
            $this->setViewVariable('arr_contacts_alumn', $arr_contacts_alumn );
            $this->setViewVariable('arr_external_contacts', $arr_external_contacts );
		}

        function processPetition()
        {
                //Primero comprueba si estamos identificados y si no es asi entonces vamos a ver si es una peticion de autenticacion
                $user_id = $this->getSessionElement( 'userinfo', 'user_id' );
                if ( isset($user_id) && $user_id != '' ) {
                        $this->setViewVariable('user_id', $user_id );
                        switch ($this->getViewVariable('option')) {
                                case show:
                                        $ext_id = $this->getViewVariable('user');
										$this->_setContactLists($ext_id);
                                        $this->setViewClass('miguel_VMain');
                                        break;
                                case detail:
                                        //$this->addNavElement(Util::format_URLPath('contact/index.php'), agt('miguel_Contact') );
                                        $contact_id=$this->getViewVariable('contact_id');
                                        $detail_contacts = $this->obj_data->getContact($user_id, $contact_id);
                                        $this->setViewVariable('detail_contacts', $detail_contacts);
                                        $this->setViewClass('miguel_VDetail');
                                        break;
                                case insert:
									    $id_profile = $this->getViewVariable('profile');
										switch($id_profile)
										{
											case '2':
											case '3':
													$arrUsers = $this->obj_data->getUsers(2);
													$arrUsers += $this->obj_data->getUsers(3);
													break;
											default:
													$arrUsers = $this->obj_data->getUsers($id_profile);
													break;
										}
										$this->setViewVariable('arrUsers', $arrUsers);
                                        $this->setViewClass('miguel_VNewContact');
                                        break;
                                case newdata:
										$contact_user_id = $this->getViewVariable('uname');
                                        $this->obj_data->insertContact($user_id, $this->getViewVariable('nom_form'), $this->getViewVariable('prenom_form'), $contact_user_id, $this->getViewVariable('email'), $this->getViewVariable('jabber'), $this->getViewVariable('comentario'), $contact_user_id!=null);
                                        $this->setViewClass('miguel_VMain');
										$this->_setContactLists($user_id);
                                        $this->setViewClass('miguel_VMain');
                                        break;
                                case delete:
                                        $this->obj_data->deleteContact($this->getViewVariable('contact_id'));
										$this->_setContactLists($user_id);
                                        $this->setViewClass('miguel_VMain');
                                        break;
                                default:
                                        $this->clearNavBarr();
										$this->_setContactLists($user_id);
										$this->setViewClass('miguel_VMain');
                                        break;
                        }

                        $this->clearNavBarr();
                        $this->addNavElement(Util::format_URLPath('contact/index.php'), agt('Contactos') );
                        $this->setCacheFile("miguel_VMain_Contact_" . $this->getSessionElement("userinfo", "user_id"));
                        $this->setMessage('' );
                        $this->setPageTitle( 'Contactos' );

                        $this->setCacheFlag(true);
                        $this->setHelp("EducContent");
                } else {
                        header('Location:' . Util::format_URLPath('main/index.php') );
                }
        }
}

?>