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
class miguel_MUserProfile extends base_Model
{
        function miguel_MUserProfile()
        {
                $this->base_Model();
        }

        //----------------------------------------------------------------
        // getPerson
        // Devuelve un array con los datos del person de la persona indicada
        // Devuelve null si la persona no existe
        //----------------------------------------------------------------
        function getPerson ($_personid)
        {
                if ($_personid != null){

                        //obtiene los datos de person
                        $person = $this->SelectMultiTable('person, user',
                                                          'person.person_name, person.person_surname, person.person_surname2',
                                                          "person.person_id = user.person_id and user.user_id = $_personid");

                        if (! $this->hasError()){

                                if (isset($person[0]['person.person_name'])){
                                        for($i=0;$i<count($person);$i++){

                                                $aux = $person[$i]['person.person_name'];
                                                $person_data["nombre"] = $aux;
                                                $aux = $person[$i]['person.person_surname'];
                                                $person_data["apellido1"] = $aux;
                                                $aux = $person[$i]['person.person_surname2'];
                                                $person_data["apellido2"] = $aux;

                                                $person_data["personid"] = $_personid;
                                        }
                                }else{ //la consulta no ha devuelto datos
                                        $person_data = null;
                                }
                        }else{ //La consulta ha devuelto un error
                                $person_data = null;
                        }
                }else{
                        $person_data = null;
                }

                return $person_data;

        }

        //----------------------------------------------------------------
        // getPersonProfile
        // Devuelve un array con los datos del profile de la persona indicada
        // Devuelve null si la persona no tiene profile
        //----------------------------------------------------------------
        function getPersonProfile ($_person_data)
        {

                $person_profile = null;

                if ($_person_data != null){

                        //obtiene los datos de perfil
                        $personid = $_person_data['personid'];
                        $perfil = $this->Select('person_profile','last_modify, who,what_offer, what_learn, web_interest, mention_favorite',"person_id = $personid");

                        if (! $this->hasError()){

                                if (isset($perfil[0]['person_profile.last_modify'])){
                                        for($i=0;$i<count($perfil);$i++){

                                                $person_profile["status"] = 'upd';

                                                $person_profile['nombre'] = $_person_data['nombre'];
                                                $person_profile['apellido1'] = $_person_data['apellido1'];
                                                $person_profile['apellido2'] = $_person_data['apellido2'];
                                                $person_profile['personid']= $_person_data['personid'];

                                                $aux = $perfil[$i]['person_profile.last_modify'];
                                                $person_profile['last_modify'] = $aux;
                                                $aux = $perfil[$i]['person_profile.who'];
                                                $person_profile['who'] = $aux;
                                                $aux = $perfil[$i]['person_profile.what_offer'];
                                                $person_profile['what_offer'] = $aux;
                                                $aux = $perfil[$i]['person_profile.what_learn'];
                                                $person_profile['what_learn'] = $aux;
                                                $aux = $perfil[$i]['person_profile.web_interest'];
                                                $person_profile['web_interest'] = $aux;
                                                $aux = $perfil[$i]['person_profile.mention_favorite'];
                                                $person_profile['mention_favorite'] = $aux;
                                        }
                                }else{
                                        $person_profile["status"] = 'ins';

                                        $person_profile['nombre'] = $_person_data['nombre'];
                                        $person_profile['apellido1'] = $_person_data['apellido1'];
                                        $person_profile['apellido2'] = $_person_data['apellido2'];
                                        $person_profile['personid']= $_person_data['personid'];
                                }

                        }else{ //La consulta ha devuelto un error
                                $person_profile = null;
                        }
                }else{ // id person es null
                        $person_profile = null;
                }

                return $person_profile;
        }// function getUserProfile


        function saveUserProfile($_person_profile)
        {
                if( $_person_profile['status'] == 'ins'){
                        $ok = $this->_insertUserProfile($_person_profile);
                }
                else{
                        $ok = $this->_updateUserProfile($_person_profile);
                }

                return $ok;

        }

        function _insertUserProfile($p)
        {

                $ret_val = $this->Insert('person_profile',
                                                                 'person_id, last_modify, who, what_offer, what_learn, web_interest, mention_favorite',
                                                                 array($p['personid'],$p['last_modify'],$p['who'],$p['what_offer'],$p['what_learn'],$p['web_interest'],$p['mention_favorite']));

                if ($this->hasError())
                {
                        $ret_val = null;
                }

                return $ret_val;
        }

        function _updateUserProfile($p)
        {
                $personid = $p['personid'];
                $ret_val = $this->Update('person_profile',
                                                                 'last_modify, who, what_offer, what_learn, web_interest, mention_favorite',
                                                                 array($p['last_modify'],$p['who'],$p['what_offer'],$p['what_learn'],$p['web_interest'],$p['mention_favorite']),
                                                                 "person_id = $personid");

                if ($this->hasError())
                {
                        Debug::oneVar($ret_val);
                        $ret_val = null;
                }

                return $ret_val;
        }

}
?>