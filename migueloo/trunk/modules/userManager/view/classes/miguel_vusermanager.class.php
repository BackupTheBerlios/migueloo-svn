<?php
/*
      +----------------------------------------------------------------------+
      |userManager/view                                                   |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de administrador de usuarios
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel userManager
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VUserManager extends miguel_VMenu
{
    function miguel_VUserManager($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }

         function right_block()
        {
                //Crea el contenedor del right_block
                $main = container();

                // $main->add(html_hr());
                //$main->add($this->add_mainMenu());

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

                $link = html_a(Util::format_URLPath("userManager/index.php",'status=new&pid='.$this->getViewVariable('pid')), agt('Registrar'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item1 = html_td('', '', $link);
                $item1->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("userManager/index.php",'status=list&pid='.$this->getViewVariable('pid')), agt('Ficha'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item2 = html_td('', '', $link);
                $item2->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("userManager/index.php", 'status=del&pid='.$this->getViewVariable('pid')), agt('Baja'), null, "_top");
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

        function content_section()
        {
        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $show_search = false;

                switch($this->getViewVariable('pid')) {
                        case 3:
                                $title0 = 'docente';
                                break;
                        case 4:
                                $title0 = 'alumno';
                                break;
                }

                switch($this->getViewVariable('status')) {
                        case 'new':
                                        $title = agt('Registrar'.' '.$title0);
                                        $content = $this->addData();
                                        break;
                        case 'del':
                                        $title = agt('Baja'.' '.$title0);
                                        //$content = $this->add_reference();
                                        break;
                        case 'show':
                                        $title = agt('Ficha'.' '.$title0);
                                        $content = $this->addData();
                                        break;
                        case 'cand':
                                        $title = agt('Ficha de candidato');
                                        $content = $this->addData();
                                        break;
                        default:
                                        $title = agt('Listado'.': '.$title0);
                                        $content = $this->add_catalogo();
                                        $show_search = true;
                                        break;
                }

                $table->add_row(html_td('ptabla01', '', $title));
                if($show_search){
                        $table->add_row(html_td('ptabla03', '', $this->add_Search()));
                        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                }
                $table->add_row(html_td('ptabla03', '', $content));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla01pie', '', $title));

                        return $table;
        }

        function addData()
    {
        $ret_val = container();

                if ($this->issetViewVariable('strError')) {
                        $strError=$this->getViewVariable('strError');
                        $ret_val->add(html_b(agt('Falta de informar los siguientes campos obligatorios: ').$strError));
                        $ret_val->add(html_br(2));
                }

                if ($this->issetViewVariable('newclient') && $this->getViewVariable('newclient') == 'ok') {
                        $ret_val->add(html_h2(agt('Preinscripción de usuario correcta.')));
                        //$ret_val->add(html_a(Util::format_URLPath("main/index.php", 'id=institution'), agt('Volver')));
                        //$ret_val->add(_HTML_SPACE);
                        $ret_val->add(html_a(Util::format_URLPath('userManager/index.php'), agt('Nueva Inscripción')));
                } else {
                        $ret_val->add($this->addForm('userManager', 'miguel_inscriptionForm'));
                }

                return $ret_val;
    }

        function add_Search()
        {
                $ret_val = container();

                $ret_val->add($this->addForm('userManager', 'miguel_searchUserForm'));

                return $ret_val;
        }

        function add_catalogo()
        {
                        $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                        $arr_data = $this->getViewVariable('arrUsers');
                        //Debug::oneVar($arr_data, __FILE__, __LINE__);

                        if ($arr_data[0]['person_name'] != null) {
                                        //Titulo de tabla
                                        $row = html_tr();
                                        $row->set_class('ptabla02');
                                        $elem0 = html_td('ptabla02', "", _HTML_SPACE);
                                        $elem0->set_tag_attribute('align', 'center');
                                        $elem1 = html_td('ptabla02', "", html_p(agt('Nombre')));
                                        $elem1->set_tag_attribute('align', 'center');
                                        $elem2 = html_td('ptabla02', "", html_p(agt('Apellido')));
                                        $elem2->set_tag_attribute('align', 'center');
                                        $elem3 = html_td('ptabla02', "", _HTML_SPACE);
                                        $elem3->set_tag_attribute('align', 'center');
                                        $elem4 = html_td('ptabla02', "", html_p(agt('DNI')));
                                        $elem4->set_tag_attribute('align', 'center');
                                        $elem5 = html_td('ptabla02', "", html_p(agt('Usuario')));
                                        $elem5->set_tag_attribute('align', 'center');
                                        $elem6 = html_td('ptabla02', "", _HTML_SPACE);
                                        $elem6->set_tag_attribute('align', 'center');
                                        $elem7 = html_td('ptabla02', "", html_p(agt('Teléfono')));
                                        $elem7->set_tag_attribute('align', 'center');
                                        $elem8 = html_td('ptabla02', "", html_p(agt('E-mail')));
                                        $elem8->set_tag_attribute('align', 'center');

                                        $row->add($elem0);
                                        $row->add($elem1);
                                        $row->add($elem2);
                                        $row->add($elem3);
                                        $row->add($elem4);
                                        $row->add($elem5);
                                        $row->add($elem6);
                                        $row->add($elem7);
                                        $row->add($elem8);

                                        $table->add($row);

                                        for ($i=0; $i<count($arr_data); $i++) {
                                                        //Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
                                                        $table->add($this->add_catalogInfo($arr_data[$i]['person_name'],
                                                                                                        $arr_data[$i]['person_surname'],
                                                                                                        $arr_data[$i]['person_surname2'],
                                                                                                        $arr_data[$i]['person_dni'],
                                                                                                        $arr_data[$i]['user_alias'],
                                                                                                        $arr_data[$i]['phone'],
                                                                                                        $arr_data[$i]['email'],
                                                                                                        $arr_data[$i]['is_logged']
                                                                                                        ));
                                        }
                        } else {
                                        $table->add(html_td('ptabla02', '', agt('No existen usuarios con este perfil')));
                        }

                        return $table;
        }

        function add_catalogInfo($_name, $_surname, $_surname2, $_dni, $_user, $_phone, $_email, $_log)
        {
                        $row = html_tr();

                        $link = $this->imag_alone(Util::format_URLPath('userManager/index.php','status=show&id='.$_user.'&pid='.$this->getViewVariable('pid')),
                                                                Theme::getThemeImagePath('icono05.gif'), agt('Ver'));

                        if($_log){
                                $img_type =  html_img(Theme::getThemeImagePath('conectado.gif'), 23, 20, 0);
                        } else {
                                $img_type =  html_img(Theme::getThemeImagePath('desconectado.gif'), 23, 20, 0);
                        }
                        $conectado = html_td('', '', $img_type);

                        //$link = _HTML_SPACE;
                        $elem1 = html_td('ptabla03', '', $link);
                        $elem1->set_tag_attribute('align', 'center');

                        $elem2 = html_td('ptabla03', '', agt($_name));
                        $elem3 = html_td('ptabla03', '', agt($_surname));
                        $elem4 = html_td('ptabla03', '', agt($_surname2));
                        $elem5 = html_td('ptabla03', '', agt($_dni));
                        $elem6 = html_td('ptabla03', '', agt($_user));
                        $elem7 = html_td('ptabla03', '', $img_type);
                        $elem8 = html_td('ptabla03', '', agt($_phone));
                        $elem9 = html_td('ptabla03', '', agt($_email));

                        $elem1->set_tag_attribute('width', '2%');
                        $elem2->set_tag_attribute('width', '10%');
                        $elem3->set_tag_attribute('width', '10%');
                        $elem4->set_tag_attribute('width', '10%');
                        $elem5->set_tag_attribute('width', '8%');
                        $elem6->set_tag_attribute('width', '8%');
                        $elem7->set_tag_attribute('width', '2%');
                        $elem8->set_tag_attribute('width', '10%');
                        $elem9->set_tag_attribute('width', '40%');

                        $row->add($elem1);
                        $row->add($elem2);
                        $row->add($elem3);
                        $row->add($elem4);
                        $row->add($elem5);
                        $row->add($elem6);
                        $row->add($elem7);
                        $row->add($elem8);
                        $row->add($elem9);

                        return $row;
        }

        function add_Row($label, $value)
        {
                $row = html_tr();
                //$row->set_class('ptabla01');

                $title = html_td('ptabla02', "", agt($label));
                $title->set_tag_attribute("width","12%");
                $value = html_td('ptabla03', "", $value);
                //$value->set_tag_attribute("width","90%");

                $row->add($title);
                $row->add($value);

                return $row;
        }
}
?>
