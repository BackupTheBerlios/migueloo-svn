<?php
/*
      +----------------------------------------------------------------------+
      |forum                                                                 |
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
 * @package forum
 * @subpackage control
 * @version 1.0.0
 *
 */
/**
 * Include libraries
 */


class miguel_CForum extends miguel_Controller
{
        function miguel_CForum()
        {
                $this->miguel_Controller();
                $this->setModuleName('discuss');

                //Nombre de la clase del Modelo

                $this->setModelClass('miguel_MForum');

                $this->setViewClass('miguel_VForum');


                $this->setCacheFlag(false);
        }

  //Crea un nuevo foro
        function insertNewForum()
        {
                $nombre = $this->getViewVariable('nombre');
                $descripcion = $this->getViewVariable('descripcion');
                $forum_id = $this->obj_data->insertForum($nombre,$descripcion);
                $this->setViewVariable('forum_id', $forum_id);
        }

  //Crea un nuevo hilo
        function insertNewTopic($forum_id)
        {
                $title = $this->getViewVariable('nombre');
                $this->obj_data->insertTopic($forum_id, $title);
        }

  //Crea un nuevo mensaje
        function insertNewPost($forum_id, $topic_id, $title)
        {
                $text = $this->getViewVariable('opinion');
                $ip = '127.0.0.1';
                if (!$this->issetViewVariable('post_parent') || $this->getViewVariable('post_parent')=='') {
                        $this->obj_data->insertPost($topic_id, $forum_id, $text, $ip, $title);
                } else {
                        $this->obj_data->insertPost($topic_id, $forum_id, $text, $ip, $title, $this->getViewVariable('post_parent'));
                }
        }

        function processPetition()
        {
                $status = $this->getViewVariable('status');
            switch($status) {
                    case 'new_post':
                                if($this->issetViewVariable('post_parent')){
                                        $this->setViewVariable('topic_name',$this->obj_data->getPostName($this->getViewVariable('post_parent')));
                                } else {
                                        $this->setViewVariable('topic_name',$this->obj_data->getTopicName($this->getViewVariable('id_forum')));
                                }
                                break;
                    case 'list_topic':
                                    $iId_forum = $this->getViewVariable('id_forum');
                                if ($this->issetViewVariable('submit')) {
                                        $this->insertNewTopic($iId_forum);
                                } else {
                                        if ($this->issetViewVariable('delete') && $this->issetViewVariable('id_topic')) {
                                                $this->obj_data->deleteTopic($this->getViewVariable('id_topic'));
                                        }
                                }
                                $arrUsers = $this->obj_data->getUsers();
                                    $this->setViewVariable('arrUsers',$arrUsers);
                                    $arrTopics = $this->obj_data->getTopics($iId_forum);
                                    $this->setViewVariable('arrTopics',$arrTopics);
                                    $forumInfo = $this->obj_data->getForum($iId_forum);
                                    $this->setViewVariable('forumInfo',$forumInfo);
                                    $this->clearNavBarr();
                                    $this->addNavElement(Util::format_URLPath('discuss/index.php', "status=list_topic&id_forum=$iId_forum"),'Tema');
                                    break;
                        case 'list_post':
                                    $iId_forum = $this->getViewVariable('id_forum');
                                    $iId_topic = $this->getViewVariable('id_topic');
                                if ($this->issetViewVariable('submit')) {
                                        $title = $this->getViewVariable('nombre');
                                        $this->insertNewPost($iId_forum, $iId_topic, $title);
                                } else if ($this->issetViewVariable('delete') && $this->issetViewVariable('id_post')) {
                                        $this->obj_data->deletePost($this->getViewVariable('id_post'));
                                }
                                    $arrPosts = $this->obj_data->getPostForum($iId_forum, $iId_topic, $this->getViewVariable('orden'));
                                    $this->setViewVariable('arrPosts',$arrPosts);
                                    $arrUsers = $this->obj_data->getUsers();
                                    $this->setViewVariable('arrUsers',$arrUsers);
                                    $topicInfo = $this->obj_data->getTopic($iId_topic);
                                    $this->setViewVariable('topicInfo',$topicInfo);
                                    $this->addNavElement(Util::format_URLPath('discuss/index.php', "status=list_post&id_forum=$iId_forum&id_topic=$iId_topic"),'Mensaje');
                                    //$arrForumData = $this->obj_data->getForum($iId_forum);
                                    //$this->setViewVariable('arrForumData',$arrForumData);
                            break;
                    case 'new':
                                if ($this->issetViewVariable('submit')) {
                                                $this->insertNewForum();
                                }
                                break;
                        case 'list_forum':
                    default:
                            $arrForums = $this->obj_data->getForums();
                                    $this->setViewVariable('arrForums',$arrForums);
                                    $this->clearNavBarr();
                                    $this->addNavElement(Util::format_URLPath('discuss/index.php', 'status=list_forum'),'Foro');
                                    break;
                }

                $this->setPageTitle("miguel Forum area ");
                $this->setMessage('');
                //$this->setCacheFile("miguel_vParser");
                $this->setCacheFlag(false);
                $this->setHelp("");
        }
}
?>