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
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VMain extends miguel_VMenu
{
        function miguel_VMain($title, $arr_commarea)
        {
                $this->miguel_VMenu($title, $arr_commarea);
        }

        function right_block()
    {
                //Crea el contenedor del right_block
                $main = container();

               // $main->add(html_hr());
                $main->add($this->add_mainMenu());

                //Titulo

                //$titulo = html_p(agt('Biblioteca'));
                $titulo = html_br();
                $titulo->set_class('ptabla01');
                $main->add($titulo);

                $main->add($this->content_section());

                $main->add(html_br());

                /*$div_line = html_div();
                $div_line->set_tag_attribute('align', 'left');
                $div_line->add(html_img(Theme::getThemeImagePath("hr01.gif"), 400, 15));
                $main->add($div_line);
                  */
                $main->add(html_br());

                return $main;
    }

    function content_section()
        {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $title = agt('Contactos');

                $table->add_row(html_td('ptabla01', '', $title));
                //$table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla03', '', $this->content()));
                //$table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla01pie', '', $title));

                return $table;
        }

        function content()
    {
                //cargamos las listas de contactos
                $arrTeacher = $this->_getContactList('arr_contacts_teacher');
                $arrTutor = $this->_getContactList('arr_contacts_tutor');
                $arrAlumn = $this->_getContactList('arr_contacts_alumn');
                $arrExternal = $this->_getContactList('arr_external_contacts');

                $div = html_div();

                $div->add($this->addList('Docentes', $arrTeacher, $arrTutor, 2));
                $div->add($this->addList('Alumnos', $arrAlumn, null, 4));
                $div->add($this->addList('Externos', $arrExternal));

                return $div;
        }

        function addList($title, $_array1, $_array2 = null, $id_profile=-1)
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
                $table->add($this->add_head($title));
                if ($_array1!=null || $_array2!=null) {
                        $this->_contactList($_array1, $table);
                        $this->_contactList($_array2, $table);
                }
                if ($id_profile!=-1) {
                        //$boton = html_a(Util::format_URLPath("contact/index.php", "option=insert&profile=$id_profile"), "Añadir", null, "_top");
                        //$boton = _HTML_SPACE;
                } else {
                        $boton = html_a(Util::format_URLPath("contact/index.php", "option=insert"), "Nuevo", null, "_top");
                        $boton->set_tag_attribute('class', '');
                        $table->add_row($boton);
                }
                //$boton->set_tag_attribute('class', '');
                //$table->add_row($boton);
                return($table);
        }

        //Devuelve la lista de contactos solicitada. Si devuelve null es que está vacía.
        function _getContactList($name_list)
        {
                  $contact = $this->getViewVariable($name_list);
          if ($contact[0]['contact_name'] == null){
                          $contact = null;
                  }
                  return($contact);
        }

    function _contactList($contact, &$table)
    {
                if ($contact!=null && $contact[0]['contact_name'] != null){
                                for ($i=0; $i<count($contact); $i++){
                                                //Debug::oneVar($contact, __FILE__, __LINE__);
                                                $table->add($this->add_info($contact[$i]['contact_name'],
                                                                            $contact[$i]['contact_surname'],
                                                                            $contact[$i]['contact_email'],
                                                                            $contact[$i]['contact_id'],
                                                                            $contact[$i]['contact_user'],
                                                                            $contact[$i]['contact_internal'],
                                                                            $contact[$i]['contact_logged'],
                                                                            $contact[$i]['contact_alias']
                                                                            ));
                                }
                }
    }

        function add_head($titulo=' ')
        {
                $row = html_tr();

                $type = html_td('ptabla02', '', $titulo);
                $type->set_tag_attribute('rowspan','50');

                $log = html_td('ptabla01', "", _HTML_SPACE);
                $name = html_td('ptabla01', "", html_b('Nombre'));
                $perfil = html_td('ptabla01', "", html_b('Perfil'));
                $mail = html_td('ptabla01', "", _HTML_SPACE);
                //$email = html_td('ptabla01', "", html_b('Correo electrónico'));
                //$info = html_td('ptabla01', "", html_b('Ficha'));

                $log->set_tag_attribute('width',"5%");
                $name->set_tag_attribute('width',"70%"); //50 + 20 de email
                $perfil->set_tag_attribute('width',"5%");
                $mail->set_tag_attribute('width',"5%");
                //$email->set_tag_attribute('width',"20%");
                //$info->set_tag_attribute('width','10%');

                $row->add($type);
                $row->add($log);
                $row->add($name);
                $row->add($perfil);
                $row->add($mail);
                //$row->add($email);
                //$row->add($info);

                return $row;
        }

        function add_info($_name, $_surname, $_email, $_id, $_user, $_type, $_log, $_alias)
        {
                $row = html_tr();

                $name = html_td('ptabla03', '',  $_name . ' ' . $_surname);
                //$ficha = html_td('ptabla03', '', $this->icon_link(Util::format_URLPath('contact/index.php','contact_id='.$_id."&option=detail"),
                //                                                        Theme::getThemeImagePath('boton_mensaje_leido.gif'), '', 'titulo03a'));
                //$profile = html_td('ptabla03', '', $this->icon_link(Util::format_URLPath('pageViewer/index.php','url=perfil_alumno_prueba.htm'),
                //                                                                                                                Theme::getThemeImagePath('icono04.gif'), '', 'titulo03a'));
                $profile = html_td('ptabla03', '', $this->addCardPopup($_user));
                if($_type){
                        if($_log){
                                        $img_type =  html_img(Theme::getThemeImagePath('conectado.gif'), 23, 20, 0);
                        } else {
                                        $img_type =  html_img(Theme::getThemeImagePath('desconectado.gif'), 23, 20, 0);
                        }
                        //$img_email = $this->icon_link(Util::format_URLPath('email/index.php', 'status=new&to='.$_alias),
                        //                                                                                                Theme::getThemeImagePath('sobre_cerrado.gif'), '', 'titulo03a');
                        $img_email = $this->addMessagePopup($_alias);
                        $email_icon = html_td('ptabla03', '', $img_email);
                } else {
                        $img_type =  html_img(Theme::getThemeImagePath('conectado_fuera.gif'), 23, 20, 0);
                        $email_icon = html_td('ptabla03', '', '-');

                }

                $internal = html_td('ptabla03', '', $img_type);
                //$email = html_td('ptabla03', '', $_email); //html_a(Util::format_URLPath('email/index.php',"status=new&to=".$_email),$_email)

                $row->add($internal);
                $row->add($name);
                $row->add($profile);
                //$row->add($email);
                $row->add($email_icon);
                //$row->add($ficha);

                return $row;
        }

        function add_mainMenu()
        {
                $div = html_div('');
                $div->add(html_br());

                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $row = html_tr();
                $blank = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
                //$blank->set_tag_attribute('colspan','4');

                $image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
                $image->set_tag_attribute('align', 'right');
                $image->set_tag_attribute('width', '40%');

                $link = html_a(Util::format_URLPath("pageViewer/index.php", 'url=agenda_tareas_pendientes.htm'), agt('Tareas pendientes'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item1 = html_td('', '', $link);
                $item1->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("pageViewer/index.php",'url=agenda_calendario.htm'), agt('Calendario'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item2 = html_td('', '', $link);
                $item2->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("contact/index.php"), agt('Contactos'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item3 = html_td('', '', $link);
                $item3->set_tag_attribute('width', '20%');

                $row->add($blank);
                $row->add($image);
                $row->add($item1);
                $row->add($item2);
                $row->add($item3);

                $table->add_row($row);

                $div->add($table);

                return $div;
        }
}

?>
