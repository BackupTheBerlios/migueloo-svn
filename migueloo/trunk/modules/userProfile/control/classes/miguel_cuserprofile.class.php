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
          | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
          |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
          |          miguel Development Team                                     |
          |                       <e-learning-desarrollo@listas.hispalinux.es>   |
          +----------------------------------------------------------------------+
*/

class miguel_CUserProfile extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CUserProfile()
        {
                $this->miguel_Controller();
                $this->setModuleName('userProfile');
                $this->setModelClass('miguel_MUserProfile');
                $this->setViewClass('miguel_VNewUserProfile');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {

                //Debug::oneVar($_SESSION);

                if ($this->issetViewVariable('personid')){
                        $personid = $this->getViewVariable('personid');
                }else{
                        $personid =  $this->getSessionElement('userinfo','user_id');
                }

                $person_data = $this->obj_data->getPerson($personid);
                if ($person_data == null){
                        $this->setViewVariable('userProfileSave', 'noid');
                }else{
                        //Comprueba si se han guardado los datos del perfil
                        if ($this->issetViewVariable("submit") ){
                                $this->processSaveUserProfile($person_data);
                                $this->setViewVariable('arr_info', $this->obj_data->getPersonProfile($person_data));
                                $this->setViewVariable('userProfileSave', 'ok'); //pone txto de perfil salvado
                        }else{
                                //Carga los datos del perfil, para inicializar los datos
                                $arr_info = $this->obj_data->getPersonProfile($person_data);
                                $this->setViewVariable('arr_info', $arr_info);
                        }
                }

        }

/*
        +----------------------------------------------------------------------+
        |getUserProfile                                                                    |
        |Obtiene los datos de profile                                                                    |
        +----------------------------------------------------------------------+
*/
        function processSaveUserProfile($_person_data)
        {

                //$process4 = $this->checkVar('who_form', 'quien soy');
                //$process5 = $this->checkVar('what_offer_form', 'que te puedo ofrecer');
                //$process6 = $this->checkVar('what_learn_form', 'que estoy dispuesto a aprender');
                //$process7 = $this->checkVar('web_interest_form', 'paginas de interes');
                //$process8 = $this->checkVar('mention_favorite_form', 'cita favorita');

                //if($process4 && $process5 && $process6 &&$process7 && $process8){

                        //obtiene array del formulario
                        $person_profile['status'] = $this->getViewVariable('status');
                        $person_profile['nombre'] = $_person_data['nombre'];
                        $person_profile['apellido1'] = $_person_data['apellido1'];
                        $person_profile['apellido2'] = $_person_data['apellido2'];
                        $person_profile['personid'] = $this->getViewVariable('personid');
                        $person_profile['last_modify'] = date('Y-m-d H:i:s');
                        $person_profile['who'] = $this->getViewVariable('who_form');
                        $person_profile['what_offer'] = $this->getViewVariable('what_offer_form');
                        $person_profile['what_learn'] = $this->getViewVariable('what_learn_form');
                        $person_profile['web_interest'] = $this->getViewVariable('web_interest_form');
                        $person_profile['mention_favorite'] = $this->getViewVariable('mention_favorite_form');

                        $user_profile = $this->obj_data->saveUserProfile($person_profile);

                        if ($user_profile == null){//Si ha habido error en la actualizacion

                        }
                //}

                return $person_profile;

        }//function processSaveUserProfile

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