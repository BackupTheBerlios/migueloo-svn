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
class miguel_mContact extends base_Model
{
    function miguel_mContact()
    {
                $this->base_Model();
    }

         //Devuelve la lista de contactos asociados a $user_id y de perfil $profile_id
    function listExternalContact($user_id=0)
    {
            $contact = $this->Select('contact', 'contact_id, contact_name, contact_surname, contact_mail, is_from_miguel', "user_id = $user_id AND is_from_miguel = 0");

            if ($this->hasError()) {
                    $ret_val = null;
            }
            $countContact = count($contact);
            for ($i=0; $i < $countContact; $i++) {
                $contactelem[$i]= array ("contact_id" => $contact[$i]['contact.contact_id'],
                                "contact_name" => $contact[$i]['contact.contact_name'],
                                "contact_surname" => $contact[$i]['contact.contact_surname'],
                                                                "contact_email" => $contact[$i]['contact.contact_mail'],
                                                                "contact_internal" => $contact[$i]['contact.is_from_miguel'],
                                                                "contact_logged" => false
                                                                );
            }

            return ($contactelem);
        }

        //Devuelve la lista de contactos asociados a $user_id y de perfil $profile_id
    function listContact($user_id=0, $profile_id=2)
    {
            $contact = $this->SelectMultiTable('contact, user', 'contact.contact_id, contact.contact_name, contact.contact_surname, contact.contact_user_id, contact.contact_mail, contact.is_from_miguel, user.user_alias, user.id_profile', "contact.user_id = $user_id AND contact.contact_user_id = user.user_id AND user.id_profile = $profile_id"); //AND contact.is_from_miguel = $from_miguel");

            if ($this->hasError()) {
                    $ret_val = null;
            }
            $countContact = count($contact);
            for ($i=0; $i < $countContact; $i++) {
                $contactelem[$i]= array ("contact_id" => $contact[$i]['contact.contact_id'],
                                "contact_name" => $contact[$i]['contact.contact_name'],
                                "contact_surname" => $contact[$i]['contact.contact_surname'],
                                                                "contact_user" => $contact[$i]['contact.contact_user_id'],
                                                                "contact_email" => $contact[$i]['contact.contact_mail'],
                                                                "contact_internal" => $contact[$i]['contact.is_from_miguel'],
                                                                "contact_logged" => $this->isLogged($contact[$i]['contact.contact_user_id']),
                                                                "contact_alias" => $contact[$i]['user.user_alias'],
                                                                "contact_profile" => $contact[$i]['user.id_profile']
                                                                );
            }

            return ($contactelem);

    }


        function getUsers($id_profile=2)
        {
            $users = $this->Select('user', 'user_id, user_alias, id_profile', "id_profile = $id_profile");

            if ($this->hasError()) {
                    $ret_val = null;
            }

                if ($users[0]['user.user_id']!=null) {
                    $countUsers = count($users);
                    for ($i=0; $i < $countUsers; $i++) {
                                        $id = $users[$i]['user.user_alias'];
                                $userselem[$id] = $users[$i]['user.user_id'];
                    }
                }

            return ($userselem);
        }

        function isLogged($_user_id)
    {
                $log_sql = $this->Select('user_logged', 'is_logged', "user_id  = $_user_id");

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

    function deleteContact($contact_id=0)
    {
            $this->Delete('contact', "contact_id = $contact_id");
    }

    function getContact($user_id="0", $contact_id="0")
    {
        $ret_val = $this->Select( 'contact', 'contact_id, contact_name, contact_surname, contact_user_id, contact_mail, contact_comments',
                                                                  "user_id = $user_id AND contact_id = $contact_id");

            if ($this->hasError()) {
                    $ret_val = null;
            }

                return ($ret_val);
    }

    function insertContact($user, $name, $surname, $contact_user_id, $mail, $jabber, $comment, $type = 0)
    {
        $ret_val = $this->Insert('contact',
                                 'user_id, contact_name, contact_surname, contact_user_id, contact_mail, contact_jabber, contact_comments, is_from_miguel',
                                 array($user, $name, $surname, $contact_user_id, $mail, $jabber, $comment, $type));

            if ($this->hasError()) {
                    $ret_val = null;
            }

                return ($ret_val);
    }
}
?>