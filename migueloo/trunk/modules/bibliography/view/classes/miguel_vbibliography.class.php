<?php
/*
      +----------------------------------------------------------------------+
      |bibliography                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 * @package bibliography
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VBibliography extends miguel_VMenu
{
        function miguel_VBibliography($title, $arr_commarea)
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

                $link = html_a(Util::format_URLPath("bibliography/index.php"), agt('Catálogo'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item1 = html_td('', '', $link);
                $item1->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("bibliography/index.php",'status=ref'), agt('Referencias bibliográficas'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item2 = html_td('', '', $link);
                $item2->set_tag_attribute('width', '20%');

                $link = html_a(Util::format_URLPath("bibliography/index.php", 'status=link'), agt('Enlaces de interés'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item3 = html_td('', '', $link);
                $item3->set_tag_attribute('width', '20%');
				
				$link = html_a(Util::format_URLPath("pageViewer/index.php", 'url=glosario.htm'), agt('Glosario'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item4 = html_td('', '', $link);
                $item4->set_tag_attribute('width', '20%');

                $row->add($blank);
                $row->add($image);
                $row->add($item1);
                $row->add($item2);
                $row->add($item3);
				$row->add($item4);

                $table->add_row($row);

                $div->add($table);

                return $div;
        }

        function content_section()
    {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                switch($this->getViewVariable('status')) {
                        case 'new':
                                $title = agt('Nueva ficha');
                                $content = $this->addForm('bibliography', 'miguel_bookForm');
                                break;
                        case 'com':
                                $title = $this->getViewVariable('bookTitle');
                                $content = $this->addForm('bibliography', 'miguel_commentForm', 'status=com&id='.$this->getViewVariable('id'));
                                break;
                        case 'val':
                        case 'detail':
                                $arr_data = $this->getViewVariable('arrBook');
                                $title = $arr_data['ptabla01'];
                                $content = $this->add_detail($arr_data);
                                break;
                        case 'link':
                                $title = agt('enlaces de interés');
                                $content = $this->add_link();
                                break;
                        case 'ref':
                                $title = agt('Referencias');
                                $content = $this->add_reference();
                                break;
                        case 'cat':
                        default:
                                $title = agt('Catálogo');
                                $content = $this->add_catalogo();
                                break;
                }

                $table->add_row(html_td('ptabla01', '', $title));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla03', '', $content));
                $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
                $table->add_row(html_td('ptabla01pie', '', $title));

                return $table;
    }

        function add_detail($arr_data)
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                //Debug::oneVar($arr_data, __FILE__, __LINE__);

                if ($arr_data['book_id'] != null) {
                        //Tabla de detalle
                        $row = html_tr();
                        $img = Util::main_URLPath('var/bibliography/image/bookref_'.$arr_data['book_id'].'.'.$arr_data['imagen']);
                        $image = html_td('', '', html_img($img, 74, 100));
                        $image->set_tag_attribute("width","12%");
                        $image->set_tag_attribute("align","center");
                        $detail_table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                        $detail_table->add($this->add_Row('autor', $arr_data['autor']));
                        $detail_table->add($this->add_Row('título', $arr_data['ptabla01']));
                        $detail_table->add($this->add_Row('año', $arr_data['año']));
                        $detail_table->add($this->add_Row('editorial', $arr_data['editorial']));
                        $detail_table->add($this->add_Row('lugar de publicación', $arr_data['place']));
                        $detail_table->add($this->add_Row('ISBN', $arr_data['isbn']));

                        $row->add($image);
                        $row->add($detail_table);
                        $table->add($row);

                        $table->add($this->add_Row('descripción', nl2br($arr_data['descripcion'])));
                        $table->add($this->add_Row('tabla de contenidos', nl2br($arr_data['indice'])));
                        //Valoracion
                        $table->add($this->add_Row('valoración', $this->add_valoracion($arr_data['book_id'])));
                        //Comentarios
                        $table->add($this->add_Row('comentarios', $this->add_comment($arr_data['book_id'])));
                } else {
                        $table->add(html_td('ptabla02', '', 'La ficha no existe'));
                }

                return $table;
        }

        function add_comment($_id)
        {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                //$table->set_class('ptexto01');
                $arr_data = $this->getViewVariable('arrComment');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);


                for ($i=0; $i<count($arr_data); $i++) {
                        //Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
                        $table->add_row($this->add_commentInfo($_id, $arr_data[$i]['autor'],
                                                $arr_data[$i]['comentario'],
                                                $arr_data[$i]['valoracion']));
                }

                if(count($arr_data) == 0){
                        $link = html_td('', '', html_a(Util::format_URLPath('bibliography/index.php',"status=com&id=".$_id),'Añadir comentario', 'p'));
                        $link->set_tag_attribute('align', 'center');
                        $link->set_tag_attribute('colspan', '2');
                        $table->add_row($link);
                }

                return $table;
        }

        function add_commentInfo($_id, $_autor, $_comment, $_value)
        {
                //$cont = container();
                //$cont->add(agt('Este libro ha sido valorado por: ').$text);
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,2,0);

                $row = html_tr();
                $autor = html_td('ptabla02', '', agt('autor:').' '.$_autor);
                $cont = container();
                //$cont->add(agt('autor:').' '.$_autor);
                //$cont->add(_HTML_SPACE);
                $cont = container();
                $cont->add(agt('valoración:').' ');
                $cont->add(_HTML_SPACE);
                $cont->add(html_img(Theme::getThemeImagePath('valoracion'.$_value.'.gif')));

                $valor = html_td('', '', $cont);

                $autor->set_tag_attribute('width', '90');
                $valor->set_tag_attribute('width', '10');
                $row->add($autor);
                $row->add($valor);
                //$cont->add(html_br());
                $table->add($row);
                $comm = html_td('', '', $_comment);
                $comm->set_tag_attribute('colspan', '2');
                $table->add_row($comm);

                $link = html_td('', '', html_a(Util::format_URLPath('bibliography/index.php',"status=com&id=".$_id),'añadir comentario', 'p'));
                $link->set_tag_attribute('align', 'center');
                $link->set_tag_attribute('colspan', '2');
                $table->add_row($link);

                return $table;
        }

        function add_valoracion($_id)
        {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                //$table->set_class('ptexto01');
                $arr_data = $this->getViewVariable('arrValor');
                $num = $arr_data[0];
                $media = $arr_data[1];
                //Debug::oneVar($arr_data, __FILE__, __LINE__);

                //Titulo de tabla
                $row = html_tr();
                //$row->set_class('ptexto01');

                if($num == 1){
                        $text = $num.' '.agt('persona.');
                } else {
                        $text = $num.' '.agt(' personas.');
                }

                $resum = html_td('ptabla03', "", agt('Este libro ha sido valorado por: ').$text);
                //$resum->set_tag_attribute('align', 'left');

                $cont = container();
                //$cont->add(agt('Este libro ha sido valorado por: ').$text);
                $cont->add(agt('valoración: '));
                $cont->add(_HTML_SPACE);
                $cont->add(html_img(Theme::getThemeImagePath('valoracion'.$media.'.gif')));
                $value = html_td('ptabla03', '', $cont);
                //$value->set_tag_attribute('align', 'left');

                $row->add($resum);
                $row->add($value);
                $table->add($row);
                $row2 = html_tr();
                //Dejar así, no usar  $this->addForm(), ya que el enlace apunta con otros parámetros
                $content = html_td('', '',$this->addForm('bibliography', 'miguel_valorateForm', 'status=val&id='.$_id));
                $content->set_tag_attribute('colspan', '2');
                $row2->add($content);

                $table->add($row2);

                return $table;
        }

        function add_catalogo()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $arr_data = $this->getViewVariable('arrBook');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);

                if ($arr_data[0]['book_id'] != null) {
                        //Titulo de tabla
                        $row = html_tr();
                        $row->set_class('ptabla02');
                        $resum = html_td('ptabla02', "", html_p(agt('Resumen')));
                        $resum->set_tag_attribute('align', 'center');
                        $title = html_td('ptabla02', "", html_p(agt('Titulo')));
                        $title->set_tag_attribute('align', 'center');
                        $ficha = html_td('ptabla02', "", html_p(agt('Ficha')));
                        $ficha->set_tag_attribute('align', 'center');
                        $value = html_td('ptabla02', "", html_p(agt('Valoración')));
                        $value->set_tag_attribute('align', 'center');

                        $row->add($resum);
                        $row->add($title);
                        $row->add($ficha);
                        $row->add($value);
                        $table->add($row);

                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
                                $table->add($this->add_catalogInfo($arr_data[$i]['book_id'],
                                                        $arr_data[$i]['title'],
                                                        $arr_data[$i]['valoracion']));
                        }
                } else {
                        $table->add(html_td('ptabla02', '', 'El catálogo está vacio'));
                }

                return $table;
        }

        function add_catalogInfo($_bookid, $_title, $_value)
        {
                $row = html_tr();


                //$link = $this->imag_alone(Util::format_URLPath('bibliography/index.php',"status=resum&id=$_bookid"),
                //                                                , agt('Resumen'));
                /*$link = html_a("#","");
       		$link->add(html_img(Theme::getThemeImagePath('icono02.gif'), 0, 0, 0, 'resumen'));
                $path_action = Util::format_URLPath('bibliography/index.php',"status=resum&id=$_bookid");
                $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");*/
		$link = $this->addPopup('bibliography/index.php', 
					'icono02.gif', 
					"wm&status=resum&id=$_bookid", 
					agt('Resumen'), 
					750, 400, 25, 100);
                $resum = html_td('ptabla03', '', $link);
                $resum->set_tag_attribute('align', 'center');

                $title = html_td('ptabla03', '', agt($_title));

                $link = $this->imag_alone(Util::format_URLPath('bibliography/index.php',"status=detail&id=$_bookid"),
                                                                Theme::getThemeImagePath('boton_mensaje_leido.gif'), agt('Detalle'));
                $detail = html_td('ptabla03', '', $link);
                $detail->set_tag_attribute('align', 'center');

                $value = html_td('ptabla03', '', html_img(Theme::getThemeImagePath('valoracion'.$_value.'.gif')));
                $value->set_tag_attribute('align', 'center');

                $resum->set_tag_attribute("width","10%");
                $title->set_tag_attribute("width","72%");
                $detail->set_tag_attribute("width","8%");
                $value->set_tag_attribute("width","10%");

                $row->add($resum);
                $row->add($title);
                $row->add($detail);
                $row->add($value);

                return $row;
        }

        function add_link()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $arr_data = $this->getViewVariable('arrLink');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);

                if ($arr_data[0]['link_name'] != null) {
                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
                                $table->add($this->add_linkInfo($arr_data[$i]['link_name'],
                                                        $arr_data[$i]['link_url'],
                                                        $arr_data[$i]['link_broken']));
                        }
                } else {
                        $table->add(html_td('ptabla02', '', 'El catálogo está vacio'));
                }
                //$table->add(html_td('ptabla03', '', _HTML_SPACE));
                $content = html_td('ptabla02', '',$this->addForm('bibliography', 'miguel_referenceForm', 'status=link'));
                $table->add($content);

                return $table;
        }

        function add_linkInfo($_name, $_url, $_active)
        {
                $row = html_tr();

                if($_active == 0){ //Active
                        $link = html_a('#',$_name, 'titulo03a');
                $link->set_tag_attribute("onClick", "MyWindow=window.open('".$_url."','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=600,left=300,top=40'); return false;");
                } else {
                        $link = $_name;
                }
                $resum = html_td('ptabla03', '', $link);
                $resum->set_tag_attribute('align', 'center');

                $row->add($resum);

                return $row;
        }

        function add_reference()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $arr_data = $this->getViewVariable('arrReference');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);

                if ($arr_data[0]['book_id'] != null) {
                        //Titulo de tabla
                        $row = html_tr();
                        $row->set_class('ptabla02');
                        $resum = html_td('ptabla02', "", html_p(agt('Resumen')));
                        $resum->set_tag_attribute('align', 'center');
                        $title = html_td('ptabla02', "", html_p(agt('Referencia')));
                        $title->set_tag_attribute('align', 'center');
                        $value = html_td('ptabla02', "", html_p(agt('Valoración')));
                        $value->set_tag_attribute('align', 'center');

                        $row->add($title);
                        $row->add($resum);
                        $row->add($value);
                        $table->add($row);

                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
                                $table->add($this->add_referenceInfo($arr_data[$i]['book_id'],
                                                        $arr_data[$i]['title'],
                                                        $arr_data[$i]['valoracion']));
                        }
                } else {
                        $table->add(html_td('ptabla02', '', 'El catálogo está vacio'));
                }

                return $table;
        }

        function add_referenceInfo($_bookid, $_title, $_value)
        {
                $row = html_tr();

                $title = html_td('ptabla03', '', agt($_title));

                //$link = $this->imag_alone(Util::format_URLPath('bibliography/index.php',"status=resum&id=$_bookid"),
                //                                                , agt('Resumen'));
                $link = html_a("#","");
        $link->add(html_img(Theme::getThemeImagePath('icono01.gif'), 0, 0, 0, 'resumen'));
                $path_action = Util::format_URLPath('bibliography/index.php',"status=resum&id=$_bookid");
                $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");
                $resum = html_td('ptabla03', '', $link);
                $resum->set_tag_attribute('align', 'center');

                $value = html_td('ptabla03', '', html_img(Theme::getThemeImagePath('valoracion'.$_value.'.gif')));
                $value->set_tag_attribute('align', 'center');

                $title->set_tag_attribute("width","80%");
                $resum->set_tag_attribute("width","10%");
                $value->set_tag_attribute("width","10%");


                $row->add($title);
                $row->add($resum);
                $row->add($value);

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
