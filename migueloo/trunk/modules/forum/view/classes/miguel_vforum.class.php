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
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once(Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VForum extends miguel_VMenu
{
        function miguel_VForum($title, $arr_commarea)
        {
                $this->miguel_VMenu($title, $arr_commarea);
        }

        function addForumList()
        {
                $title = 'Foro';
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $table->add_row(html_td('ptabla01', '', $title));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla03', '', $this->addForumListData()));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla01pie', '', $title));

                return $table;
        }

        function addForumListData()
        {
                $arrForums = $this->getViewVariable('arrForums');

                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                for ($i=0; $i<count($arrForums); $i++) {
                        $content = html_td('','', $this->addForumItemData($arrForums[$i]['forum.forum_name'], $arrForums[$i]['forum.forum_description'],$arrForums[$i]['forum.forum_date'], $arrForums[$i]['forum.forum_num'], $arrForums[$i]['forum.forum_id']));

                        $table->add_row($content);
                }

                return($table);
        }

        function addForumItemData($_name, $_desc, $_date, $_num, $_link)
        {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $nombre = html_td('ptabla02', '', $_name);
                $nombre->set_tag_attribute('width', '10%');

                $details = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $details->set_class('ptabla03');

                $row1 = html_tr();

                $date = html_td('ptabla03', '', agt('Fecha').': '.$_date);
                $msgs = html_td('ptabla03', '', agt('Temas').': '.$_num);
                $date->set_tag_attribute('width', '85%');
                $msgs->set_tag_attribute('width', '15%');
                $row1->add($date);
                $row1->add($msgs);

                $details->add_row($row1);

                $desc = html_td('ptabla03', '', nl2br("\n".$_desc."\n"._HTML_SPACE));
                $desc->set_tag_attribute('colspan', '2');

                $details->add_row($desc);

                $link = html_a(Util::format_URLPath('forum/index.php',"status=list_topic&id_forum=$_link"),
                                                agt('Entrar'), 'p');
                $boton = html_td('ptabla03', '', $link);
                $boton->set_tag_attribute('colspan', '2');


                $b_row = html_tr();
                $b_row->set_tag_attribute('align', 'center');
                $b_row->add($boton);


                $details->add_row($b_row);

                $table->add_row($nombre, $details);

                return($table);
        }

        function addNewForumInfo()
        {
                        $elem1 = html_p('Foro creado correctamente.');
                        $elem1->set_class('ptabla01');
                        return($elem1);
        }

        function addHeadForum(&$div)
        {
                $forumInfo = $this->getViewVariable('forumInfo');
                $strForumName = $forumInfo[0]['forum.forum_name'];
                $titulo = html_p(agt('Foro').': '.$strForumName);
                $titulo->set_class('ptabla01');
                $div->add($titulo);
        }

        function addTopicHeader()
        {
                $table = html_tr();

                $name = html_td('ptabla02','',_HTML_SPACE);
                $date = html_td('ptabla02','',agt('Fecha'));
                $own = html_td('ptabla02','',agt('Autor'));

                $name->set_tag_attribute('width','75%');
                $date->set_tag_attribute('width','10%');
                $own->set_tag_attribute('width','15%');

                $table->add($name);
                $table->add($date);
                $table->add($own);

                return $table;
        }

        function addTopic($title, $poster, $date, $post_poster, $post_time, $id_topic)
        {
                $table = html_tr();

                //$table->set_class('simple');
                $id_forum = $this->getViewVariable('id_forum');

                $nom = html_a(Util::format_URLPath('forum/index.php',"status=list_post&id_forum=$id_forum&id_topic=$id_topic"),$title,'titulo03a');
                $name = html_td('ptabla03','', $nom);
                $date = html_td('ptabla03','', $date);
                $own = html_td('ptabla03','', $poster);

                $name->set_tag_attribute('width','75%');
                $date->set_tag_attribute('width','10%');
                $own->set_tag_attribute('width','15%');

                $table->add($name);
                $table->add($date);
                $table->add($own);


                return $table;
        }

        function addTopicList()
        {
                $forumInfo = $this->getViewVariable('forumInfo');
                $strForumName = $forumInfo[0]['forum.forum_name'];
                $title = agt('Foro').': '.$strForumName;

                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $table->add_row(html_td('ptabla01', '', $title));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla03', '', $this->addTopicListContent()));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla01pie', '', $title));

                return $table;
        }

        function addTopicListContent()
        {
                $arrUsers = $this->getViewVariable('arrUsers');
                //Debug::oneVar($arrUsers);
                //$arrForumData = $this->getViewVariable('arrForumData');
                $arrTopics = $this->getViewVariable('arrTopics');
                //Debug::oneVar($arrTopics);

                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $table->add_row($this->addTopicHeader());

                if ($arrTopics[0]['forum_topic.forum_topic_title']!=null) {
                        for ($i=0; $i<count($arrTopics); $i++) {
                                $table->add_row($this->addTopic($arrTopics[$i]['forum_topic.forum_topic_title'],
                                                                                $arrUsers[$arrTopics[$i]['forum_topic.forum_topic_poster']],
                                                                                $arrTopics[$i]['forum_topic.forum_topic_date'],
                                                                                $arrUsers[$arrTopics[$i]['forum_post.forum_post_poster']],
                                                                                $arrTopics[$i]['forum_post.forum_post_time'],
                                                                                $arrTopics[$i]['forum_topic.forum_topic_id']));
                        }
                }

                return $table;
        }

        function addHeadTopic(&$div)
        {
                $topicInfo = $this->getViewVariable('topicInfo');
                $strForumName = $topicInfo[0]['forum.forum_name'];
                $pTopicTitle = html_p(agt('Tema').': '.$topicInfo[0]['forum_topic.forum_topic_title']);
                $pTopicTitle->set_class('ptabla01');
                /*
                $id_forum = $this->getViewVariable('id_forum');
                $aTitulo = html_a(Util::format_URLPath('forum/index.php',"status=list_topic&id_forum=$id_forum"),html_b($strForumName));
                $aTitulo->set_class('ptabla03');
                $div->add($aTitulo);
                $div->add(html_br());
                */

                $div->add($pTopicTitle);
        }


        function addPost($poster, $time, $text, $ip, $id_post, $parent, $title, $_log)
        {
                $arrUsers = $this->getViewVariable('arrUsers');
				$poster_name = $arrUsers[$poster];
				$arrUsersAlias = $this->getViewVariable('arrUsersAlias');
                $poster_alias = $arrUsersAlias[$poster];
                $id_forum = $this->getViewVariable('id_forum');
                $id_topic = $this->getViewVariable('id_topic');

                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $content = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                //Si es un nodo padre
                $rowTitle = html_td('ptabla01','',$title);
                $rowFecha = html_td('ptabla01','',$time);
                $rowMail = html_td('ptabla01','',$this->addMessagePopup($poster_alias));

                $rowTitle->set_tag_attribute('width','90%');
                $rowFecha->set_tag_attribute('width','10%');
                $rowMail->set_tag_attribute('width','10%');

                $row1 = html_tr();
                $row1->add($rowTitle);
                $row1->add($rowFecha);
                $row1->add($rowMail);

                //Si es un nodo padre
                $rowAutor = html_td('ptabla02','',$poster_name);
                $rowNums = html_td('ptabla02','','Enviados: 0');

                if($_log){
                        $img_type =  html_img(Theme::getThemeImagePath('conectado.gif'), 23, 20, 0);
                } else {
                        $img_type =  html_img(Theme::getThemeImagePath('desconectado.gif'), 23, 20, 0);
                }

                $rowLogged = html_td('ptabla02','', $img_type);

                $rowAutor->set_tag_attribute('width','90%');
                $rowNums->set_tag_attribute('width','10%');
                $rowLogged->set_tag_attribute('width','10%');

                $row2 = html_tr();
                $row2->add($rowAutor);
                $row2->add($rowNums);
                $row2->add($rowLogged);


                $rowText = html_td('ptabla03','',nl2br($text));
                $rowText->set_tag_attribute('colspan',3);

                $row3 = html_tr();
                $row3->add($rowText);

                //Si es un nodo padre
                $rowGoBack = html_td('ptabla03','','Volver arriba');
                $rowNew = html_td('ptabla03','',html_a(Util::format_URLPath('forum/index.php',"status=new_post&id_forum=$id_forum&id_topic=$id_topic&post_parent=$id_post"),'Responder', 'p'));
                $rowDelete = html_td('ptabla03','',html_a(Util::format_URLPath('forum/index.php',"status=list_post&id_forum=$id_forum&id_topic=$id_topic&id_post=$id_post&delete=1"),'Eliminar', 'p'));

                $rowAutor->set_tag_attribute('width','90%');
                $rowNums->set_tag_attribute('width','10%');
                $rowDelete->set_tag_attribute('width','10%');

                $row4 = html_tr();
                $row4->add($rowGoBack);
                $row4->add($rowNew);
                $row4->add($rowDelete);


                $content->add_row($row1);
                $content->add_row($row2);
                $content->add_row($row3);
                $content->add_row($row4);


                //Si se ordena por hilo es una respuesta le añadimos un margen blanco.
                if (!$this->issetViewVariable('orden') || $this->getViewVariable('orden')!='tema' || $id_post == $parent)  {
                        $table->add_row(html_td('ptabla03','', $content));
                } else {
                        $margen = html_td('','',' ');
                        $margen->set_tag_attribute('width','4%');
                        $table->add_row($margen, html_td('ptabla03','', $content));
                }

                return($table);
        }

        function addPostList(&$div)
        {
                $arrPosts = $this->getViewVariable('arrPosts');

                for ($i=0; $i<count($arrPosts); $i++) {
                        if ($arrPosts[$i]['forum_post.forum_post_poster']!=NULL) {
                                $div->add($this->addPost($arrPosts[$i]['forum_post.forum_post_poster'],
                                                                                $arrPosts[$i]['forum_post.forum_post_time'],
                                                                                $arrPosts[$i]['forum_post.forum_post_text'],
                                                                                $arrPosts[$i]['forum_post.forum_post_ip'],
                                                                                $arrPosts[$i]['forum_post.forum_post_id'],
                                                                                $arrPosts[$i]['forum_post.forum_post_parent'],
                                                                                $arrPosts[$i]['forum_post.forum_post_title'],
                                                                                $arrPosts[$i]['is_logged']));
                                $div->add(html_hr());
                        }
                }
        }

          function right_block()
    {
                $main = container();

                $main->add($this->right_section());

                return $main;
        /*
                //Crea el contenedor del right_block
                $main = container();

                      $hr = html_hr();
                 $hr->set_tag_attribute('noshade');
          $hr->set_tag_attribute('size', 2);

          //AÃ±ade la linea horizontal al contenedor principal
          $main->add($hr);

                                        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
                                        $table->set_class('simple');

                                        $elem1 = html_td('', '', $this->left_section());
                                        $elem1->set_tag_attribute('width', '20%');
                                        $elem1->set_tag_attribute('valign', 'top');
                                        $elem2 = html_td('', '',$this->right_section());
                                        $elem2->set_tag_attribute('valign', 'top');

                                        $row = html_tr();
                                        $row->add($elem1);
                                        $row->add($elem2);

                                        $table->add_row($row);

                $main->add( $table );

                                        return $main;
        */
    }

    function left_section()
    {
                        $div = html_div();
                        $div->set_id('content');
                        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
                        //$table->set_class('ptabla02');
                        $table->add_row(html_td('ptabla02','',html_a(Util::format_URLPath('forum/index.php','status=new'),'Nuevo Debate')));
                        $table->add_row(html_td('ptabla02','',html_a(Util::format_URLPath('forum/index.php','status=list'),'Listado de Debates')));
                        //$table->add_row(html_a(Util::format_URLPath('forum/index.php','status=new_post'),'Nueva Opinión'));
                        $div->add($table);

                         $status = $this->getViewVariable('status');
                         switch($status)
                         {
                                         case 'list_post':
                                                                $div->add($this->addForm('forum', 'miguel_forumMenuform'));
                                                                break;
                         }
                        return($div);
    }

        function right_section()
        {
                $div = html_div();
                $div->set_id('content');
                $div->add(html_br());

                $status = $this->getViewVariable('status');
                switch($status) {
                        case 'new_post':
                                $div->add($this->addForm('forum', 'miguel_newpostform'));
                                break;
                        case 'new_topic':
                                $div->add($this->addForm('forum', 'miguel_newtopicform'));
                                break;
                        case 'list_topic':
                                $div->add($this->addTopicList());
                                break;
                        case 'list_post':
                                $search = $this->addForm('forum', 'miguel_forumMenuform');
                                $div->add($search);
                                $this->addHeadTopic($div);
                                $this->addPostList($div);
                                $div->add($search);
                                break;
                        case 'new':
                                if ($this->issetViewVariable('submit')) {
                                        $div->add($this->addNewForumInfo());
                                }  else {
                                        $div->add($this->addForm('forum', 'miguel_forumform'));
                                }
                                break;
                        case 'list_forum':
                        default:
                                $div->add($this->addForumList());
                }
                $div->add(html_br());
                $div->add(html_img(Theme::getThemeImagePath("hr01.gif"), 400, 15));
                $div->add(html_br(2));

                return $div;
        }
}
?>
