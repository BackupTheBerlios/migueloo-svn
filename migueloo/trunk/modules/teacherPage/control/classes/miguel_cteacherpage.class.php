<?php
/*
      +----------------------------------------------------------------------+
      |teacherPage/controller                                                |
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

class miguel_CTeacherPage extends miguel_Controller
{
        function miguel_CTeacherPage()
        {
                $this->miguel_Controller();
                $this->setModuleName('teacherPage');
                $this->setModelClass('miguel_MTeacherPage');
                $this->setViewClass('miguel_VTeacherPage');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {
          if ($this->issetViewVariable('status'))
          {
                  $status = $this->getViewVariable('status');
          }
          else
          {
                  $status = 'main';
                  $status = $this->setViewVariable('status', 'main');
          }
          //$this->addNavElement(Util::format_URLPath('teacherPage/index.php'), 'Página del Profesor');


    switch($status)
          {
                  case 'main':
                  default:
                          //Presentación de mensajería
                          $arrMessages = $this->obj_data->getNewUserMessages(Session::getValue('USERINFO_USER_ID'));
                          $this->setViewVariable('arrMessages', $arrMessages);

                          //Presentación de tablón de anuncios
                          $NoticeArray = $this->obj_data->getNotices();
              $this->setViewVariable('notice_array', $NoticeArray);
                                break;
                }


          //Establecer el título de la página
                $this->setPageTitle("miguel Teacher Page");
          $this->setMessage('');

    //Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
          $this->setHelp("");

        }
}
?>