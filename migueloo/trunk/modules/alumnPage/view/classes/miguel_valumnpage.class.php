<?php
/*
      +----------------------------------------------------------------------+
      | miguel_valumnpage.class.php                                          |
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
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VAlumnPage extends miguel_VMenu
{
    function miguel_VAlumnPage($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
    }

        function add_head()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $row = html_tr();
                $image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
                $image->set_tag_attribute('align', 'right');
                $progress = html_td('', '', 'Mi progreso');
                $state = html_td('', '', 'Estado Actual');
                $continue = html_td('', '', html_a(Util::format_URLPath('courseViewer/index.php','id=7&mid=1'),'Comenzar', ''));
                $row->add($image);
                $row->add($progress);
                $row->add($state);
                $row->add($continue);
                $table->add_row($row);
                 return $table;
        }

        function add_sectionHead($strName, $strIcon)
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
            $row = html_tr();

                $name = html_td('ptabla01', '', html_b($strName));
                //$name->set_tag_attribute('width','70%');

                //$icon = html_td('ptabla01', '', Theme::getThemeImage($strIcon));
                //$icon->set_tag_attribute('width','30%');
                //$icon->set_tag_attribute('align','right');

                $row->add($name);
                //$row->add($icon);
                $table->add($row);
                 return $table;
        }

        function add_mailHead($from_to)
        {
            $row = html_tr();

                $from = html_td('ptabla01', "", html_b($from_to));
                $subject = html_td('ptabla01', "", html_b('Asunto'));
                $date = html_td('ptabla01', "", html_b('Recibido'));

                 $from->set_tag_attribute('width',"30%");
                 $subject->set_tag_attribute('width',"50%");
                 $date->set_tag_attribute('width',"20%");

                $row->add($from);
                $row->add($subject);
                $row->add($date);

                 return $row;
        }

        function add_emailInfo($_from, $_subject, $_date, $_id_msg)
        {
        $row = html_tr();

                $link = html_a(Util::format_URLPath('email/index.php','status=new&to=' . $_from),$_from);
                $link->set_tag_attribute('class', 'titulo03a');
                $from = html_td('ptabla03', '', $link);

                $link = html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_subject);
                $link->set_tag_attribute('class', 'titulo03a');
                $subject = html_td('ptabla03', '', $link);
                $date = html_td('ptabla03', '', $_date);

                 $from->set_tag_attribute('width','30%');
                 $subject->set_tag_attribute('width','50%');
                 $date->set_tag_attribute('width','20%');

                $row->add($from);
                $row->add($subject);
                $row->add($date);

                 return $row;
        }

        function add_inbox()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
                $arrMessages = $this->getViewVariable('arrMessages');

                if ($arrMessages[0]['user.user_alias']!=null){
                        $table->add($this->add_mailHead('De'));
                        for ($i=0; $i<count($arrMessages); $i++){
                                $table->add($this->add_emailInfo($arrMessages[$i]['user.user_alias'],
                                                                                                 $arrMessages[$i]['message.subject'],
                                                                                                 $arrMessages[$i]['message.date'],
                                                                                                 $arrMessages[$i]['message.id'],
                                                                                                 $arrMessages[$i]['receiver_message.status']));
                        }
                } else {
                        $table->add(html_td('ptabla02', '', 'La carpeta está vacía'));
                }

                return $table;
        }

        function add_noticeHead($from_to)
        {
        $row = html_tr();

                $from = html_td('ptabla01', '', html_b($from_to));
                $subject = html_td('ptabla01', '', html_b('Aviso'));
                $date = html_td('ptabla01', '', html_b('Fecha'));

                 $from->set_tag_attribute('width','30%');
                 $subject->set_tag_attribute('width','50%');
                 $date->set_tag_attribute('width','20%');

                $row->add($from);
                $row->add($subject);
                $row->add($date);

                 return $row;
        }

        function add_notice($author, $text, $_date, $id)
        {
            $row = html_tr();

                $link = html_a(Util::format_URLPath('notice/index.php',"status=show&id=$id"),$text);
                $link->set_tag_attribute('class', 'titulo03a');
                $subject = html_td('ptabla03', '', $link);
                $from = html_td('ptabla03', '', $author);
                $date = html_td('ptabla03', '', $_date);

                 $from->set_tag_attribute('width','30%');
                 $subject->set_tag_attribute('width','50%');
                 $date->set_tag_attribute('width','20%');

                $row->add($from);
                $row->add($subject);
                $row->add($date);

                 return $row;
        }

        function add_notices()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
                $notice_array=($this->getViewVariable('notice_array'));

                if ($notice_array != null){
                        $table->add($this->add_noticeHead('De'));
                        for ($i=0; $i < count($notice_array); $i++) {
                                $table->add($this->add_notice($notice_array[$i]['notice.author'],
                                                                                        $notice_array[$i]['notice.subject'],
                                                                                        $notice_array[$i]['notice.time'],
                                                                                        $notice_array[$i]['notice.notice_id'])
                                                                                        );
                        }
                } else {
                        $table->add(html_td('ptabla02', '', 'El tablón está vacío'));
                }

                return $table;
        }

        function add_resume($strName, $strNumber)
        {
            $row = html_tr();

                $name = html_td('ptabla02', "", $strName);
                $number = html_td('ptabla03', "", $strNumber);
                $name->set_tag_attribute('width','80%');
                $row->add($name);
                $row->add($number);

                return($row);
        }

        function left_section()
        {
        $ret_val = html_div();

        $ret_val->add(html_br(2));

                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);

                $title = html_td('ptabla01', "", 'Para hoy');
                $title->set_tag_attribute('colspan',2);
                $table->add($title);

                 $arrMessages = $this->getViewVariable('arrMessages');
                 $unreaded=count($arrMessages);
                //Si es 1 hay que mirar que no sea nulo
                 if ($unreaded == 1 && $arrMessages[0]['message.id']==null){
                           $unreaded=0;
                 }
                $table->add($this->add_resume('Mensajes', $unreaded));

                $notice_array=($this->getViewVariable('notice_array'));
                $unreaded=count($notice_array);
                //Si es 1 hay que mirar que no sea nulo
                 if ($unreaded == 1 && $notice_array[0]['notice.author']==null){
                           $unreaded=0;
                 }
                $table->add($this->add_resume('Tablón de anuncios', $unreaded));

                $ret_val->add($table);

        return $ret_val;
        }

        function right_section()
        {
        $div = html_div();

            $status = $this->getViewVariable('status');

            switch($status)
        {
                case 'menu':
                default:
                                  $div->add($this->add_head());
                                  $div->add(html_br());
                        //$div->add(html_hr());

                                $arrMessages = $this->getViewVariable('arrMessages');
                            $unreaded=count($arrMessages);
                            //Si es 1 hay que mirar si no es nulo
                            if ($unreaded == 1 && $arrMessages[0]['message.id']==null){
                                       $unreaded=0;
                               }
                                  $div->add($this->add_sectionHead('Mensajería ' . "($unreaded)",'modules/email.png'));
                                $div->add($this->add_inbox());

                                $div->add(html_img(Theme::getThemeImagePath("hr01.gif"), 400, 15));
                            $div->add(html_br());
                            //$div->add(html_hr());
                                $notice_array=($this->getViewVariable('notice_array'));
                                $unreaded=count($notice_array);
                                //Si es 1 hay que mirar que no sea nulo
                                 if ($unreaded == 1 && $notice_array[0]['notice.author']==null){
                                           $unreaded=0;
                                 }
                                  $div->add($this->add_sectionHead('Tablón de anuncios ' . "($unreaded)",'modules/announces.png'));
                                $div->add($this->add_notices());

                                $div_line = html_div();
                                $div_line->set_tag_attribute('align', 'right');
                                $div_line->add(html_img(Theme::getThemeImagePath("hr02.gif"), 400, 15));

                                $div->add($div_line);
                                break;
                }

                //$ret_val->add($div);

        return $div;
        }

    function right_block()
    {
        //Crea el contenedor del right_block
            $main = container();

                //$hr = html_hr();
               //$hr->set_tag_attribute('noshade');
        //$hr->set_tag_attribute('size', 2);

        //AÃ±ade la linea horizontal al contenedor principal
        //$main->add($hr);
        $main->add(html_br());

                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,5);

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
    }
}
?>
