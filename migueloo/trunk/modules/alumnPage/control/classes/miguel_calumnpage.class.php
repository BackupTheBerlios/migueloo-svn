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
          |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/

class miguel_CAlumnPage extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CAlumnPage()
        {
                $this->miguel_Controller();
                $this->setModuleName('alumnPage');
                $this->setModelClass('miguel_MAlumnPage');
                $this->setViewClass('miguel_VAlumnPage');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {
                if ($this->issetViewVariable('status')){
                        $status = $this->getViewVariable('status');
                } else {
                        $status = 'main';
                        $status = $this->setViewVariable('status', 'main');
                }

                switch($status){
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

                $this->clearNavBarr();
				$this->addNavElement(Util::format_URLPath('alumnPage/index.php'), agt('Inicio'));

                $this->setPageTitle("miguel Alumn Page");
                $this->setMessage('');

                $this->setHelp("");
        }
}
?>
