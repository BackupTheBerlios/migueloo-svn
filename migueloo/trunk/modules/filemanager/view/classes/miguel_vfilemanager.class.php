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
      | Authors: Antonio F. Cano Damas <antonio@igestec.com>                 |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla comË™n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentarÂÂ· la informaciÃ›n
 *  + Bloque de pie en la parte inferior
 *
 * --------------------------------
 * |         header block         |
 * --------------------------------
 * |                              |
 * |         data block           |
 * |                              |
 * --------------------------------
 * |         footer block         |
 * --------------------------------
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Antonio F. Cano Damas  <antonio@igestec.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VFileManager extends miguel_VMenu
{
        function miguel_VFileManager($title, $arr_commarea)
        {
                $this->miguel_VMenu($title, $arr_commarea);
        }

        function addDocuments()
        {
                $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
                $table->add($this->addDocumentTitle());

                $arr_data = $this->getViewVariable('arr_folders');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);
                if ($arr_data[0]['folder_name'] != null) {
                        for ($i=0; $i<count($arr_data); $i++) {
                                //Debug::oneVar($arr_data[$i], __FILE__, __LINE__);
                                $table->add($this->addDocumentInfo($arr_data[$i]['folder_id'],
                                                                   $arr_data[$i]['folder_name'],
                                                                   $arr_data[$i]['folder_date'],
                                                                   $arr_data[$i]['folder_autor'],
                                                                   $arr_data[$i]['folder_user_id'],
                                                                   0,
                                                                   $arr_data[$i]['folder_count_element'],
                                                                   $arr_data[$i]['folder_visible'],
                                                                   1,1,
                                                                   true));
                        }
                        //$bol_hasFolders = true;
                } /*else {
                        $bol_hasFolders = false;
                }*/

                $arr_data = $this->getViewVariable('arr_files');
                //Debug::oneVar($arr_data, __FILE__, __LINE__);
                if ($arr_data[0]['document_name'] != null) {
                        for ($i=0; $i<count($arr_data); $i++) {
                                $table->add($this->addDocumentInfo($arr_data[$i]['document_id'],
                                                                   $arr_data[$i]['document_name'],
                                                                   $arr_data[$i]['document_date'],
                                                                   $arr_data[$i]['document_autor'],
                                                                   $arr_data[$i]['document_user_id'],
                                                                   0,
                                                                   $arr_data[$i]['document_size'],
                                                                   $arr_data[$i]['document_visible'],
                                                                   $arr_data[$i]['document_lock'],
                                                                   $arr_data[$i]['document_share']));
                        }
                } /*else {
                        if(!$bol_hasFolders){
                                $table->add(html_td('ptabla02', '', 'El directorio está vacio'));
                        }
                }*/

                return $table;
        }

        function addDocumentTitle()
        {
                $folder_parent_id = $this->getViewVariable('folder_parent_id');
                if($folder_parent_id != 0 ){
                        $link = $this->imag_alone(Util::format_URLPath('filemanager/index.php',"folder_id=$folder_parent_id"),
                                                                        Theme::getThemeImagePath('filemanager/parentdir.png'), agt('Subir'),15,12);
                } else {
                        $link = _HTML_SPACE;
                }

                //Titulo de tabla
                $row = html_tr();
                $row->set_class('ptabla02');
                $elem1 = html_td('ptabla02', "", $link);
                $elem2 = html_td('ptabla02', "", html_p(agt('Tipo')));
                $elem3 = html_td('ptabla02', "", html_p(agt('Nombre')));
                $elem4 = html_td('ptabla02', "", html_p(agt('Fecha')));
                $elem5 = html_td('ptabla02', "", html_p(agt('Autor')));
                $elem6 = html_td('ptabla02', "", html_p(agt('Descargas')));
                $elem7 = html_td('ptabla02', "", html_p(agt('Tamaño')));
                $elem8 = html_td('ptabla02', "", _HTML_SPACE);
                $elem9 = html_td('ptabla02', "",_HTML_SPACE);
                $elem10 = html_td('ptabla02', "",_HTML_SPACE);
                $elem11 = html_td('ptabla02', "",_HTML_SPACE);
                $elem12 = html_td('ptabla02', "",_HTML_SPACE);
                $elem13 = html_td('ptabla02', "",_HTML_SPACE);
                $elem14 = html_td('ptabla02', "",_HTML_SPACE);

                $elem1->set_tag_attribute('width', '1%');
                $elem2->set_tag_attribute('width', '1%');
                $elem3->set_tag_attribute('width', '20%');
                $elem4->set_tag_attribute('width', '10%');
                $elem5->set_tag_attribute('width', '20%');
                $elem6->set_tag_attribute('width', '5%');
                $elem7->set_tag_attribute('width', '5%');
                $elem8->set_tag_attribute('width', '1%');
                $elem9->set_tag_attribute('width', '1%');
                $elem10->set_tag_attribute('width', '1%');
                $elem11->set_tag_attribute('width', '1%');
                $elem12->set_tag_attribute('width', '1%');
                $elem13->set_tag_attribute('width', '1%');
                $elem14->set_tag_attribute('width', '1%');

                $row->add($elem1);
                $row->add($elem2);
                $row->add($elem3);
                $row->add($elem4);
                $row->add($elem5);
                $row->add($elem6);
                $row->add($elem7);
                $row->add($elem8);
                $row->add($elem9);
                $row->add($elem10);
                $row->add($elem11);
                $row->add($elem12);
                $row->add($elem13);
                $row->add($elem14);
                return $row;
        }

        function addDocumentInfo($_id, $_name, $_date, $_owner, $_owner_id, $_downs, $_size, $_visible=1, $_lock=1, $_share=1, $_folder = false)
        {
                $user_id = $this->getViewVariable('user_id');
                $profile_id = $this->getViewVariable('profile_id');
                //If not Admin, teacher or tutor
                if ( $profile_id >= 4) {
                    //Test ownership and visibility
                    if ( ( $user_id != $_owner_id ) && ($_visible == 0 ) ) {
                        return ;
                    }
                }

                //Necesito dos clases: una para visible y otra para invisible. La de invisible es para diferenciar en la vista del propietario o administrador
                $row = html_tr();

                $elem1 = html_td('ptabla03', '', _HTML_SPACE);

                if($_folder){
                        $link = $this->imag_alone(Util::format_URLPath('filemanager/index.php',"folder_id=$_id"),
                                                                        Theme::getThemeImagePath('filemanager/folder.png'), agt('Entrar'));
                } else {
                        include_once (Util::app_Path("filemanager/include/classes/filedisplay.class.php"));
                        $image =  Theme::getThemeImagePath("filemanager/" . fileDisplay::choose_image($_name));

                        $link = html_a("#","");
                        $link->add(html_img($image,16,16,null,agt('Ver')));
                        $path_action = Util::main_URLPath('var/data/'.$_name);
                        $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");
                }
                $elem2 = html_td('ptabla03', '', $link);
                $elem2->set_tag_attribute('align', 'center');

                $elem3 = html_td('ptabla03', '', $_name);
                $elem4 = html_td('ptabla03', '', $_date);
                $elem5 = html_td('ptabla03', '', $_owner);
                $elem6 = html_td('ptabla03', '', $_downs);
                $elem7 = html_td('ptabla03', '', $_size);

                if(!$_folder){
                        $link = html_a("#","");
                        $link->add(html_img(Theme::getThemeImagePath('disquette.jpg'),null,null,null,agt('Descargar')));
                        $path_action = Util::main_URLPath('var/data/'.$_name);
                        $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."',750,400,25,100)");
                } else {
                        $link = _HTML_SPACE;
                }
                $elem8 = html_td('ptabla03', '', $link);
                $elem8->set_tag_attribute('align', 'center');

                //---------------- TEST LOCK ---------------------------------------
                if ( ($_lock == 0) && ($profile_id >= 4) ){
                    $elem9 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem9->set_tag_attribute('align', 'center');

                    $elem10 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem10->set_tag_attribute('align', 'center');

                    $elem11 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem11->set_tag_attribute('align', 'center');

                    $elem12 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem12->set_tag_attribute('align', 'center');

                    $elem13 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem13->set_tag_attribute('align', 'center');

                    $elem14 = html_td('ptabla03', '', _HTML_SPACE);
                    $elem14->set_tag_attribute('align', 'center');
                  
                    $row->add($elem1);
                    $row->add($elem2);
                    $row->add($elem3);
                    $row->add($elem4);
                    $row->add($elem5);
                    $row->add($elem6);
                    $row->add($elem7);
                    $row->add($elem8);
                    $row->add($elem9);
                    $row->add($elem10);
                    $row->add($elem11);
                    $row->add($elem12);
                    $row->add($elem13);
                    $row->add($elem14);

                    return $row;
                }

                //----------------- COMMON OPERATIONS ------------------------------
                $_fid = $this->getViewVariable('folder_id');

                if($_folder){
                        $status = 'folder_id='.$_fid.'&status=del&tp=f&id=';
                } else {
                        $status = 'folder_id='.$_fid.'&status=del&tp=d&id=';
                }
                $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                         Theme::getThemeImagePath('filemanager/delete.png'), agt('Borrar'));
                $elem9 = html_td('ptabla03', '', $img);
                $elem9->set_tag_attribute('align', 'center');

                $_fid = $this->getViewVariable('folder_id');

                if($_folder){
                        $status = 'oldName='.$_name.'&operation_id=rename&tp=f&id=';
                } else {
                        $status = 'oldName='.$_name.'&operation_id=rename&tp=d&id=';
                }
                $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                         Theme::getThemeImagePath('filemanager/rename.png'), agt('Renombrar'));
                $elem10 = html_td('ptabla03', '', $img); 
                $elem10->set_tag_attribute('align', 'center');

                if($_folder){
                        $status = 'operation_id=move&tp=f&id=';
                } else {
                        $status = 'folder_id='.$_fid.'&operation_id=move&tp=d&id=';
                }
                $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                         Theme::getThemeImagePath('filemanager/move.png'), agt('Mover'));
                $elem11 = html_td('ptabla03', '', $img); 
                $elem11->set_tag_attribute('align', 'center');
                if ($_visible == 0) {
                    $status= 'visible';
                    $icon='invisible.png';
                    $tooltip='Visible';
                } else {
                    $status='invisible';
                    $icon='visible.png';
                    $tooltip='Invisible';
                }
                if($_folder){
                        $status = 'status='.$status.'&tp=f&id=';
                } else {
                        $status = 'status='.$status.'&tp=d&id=';
                }
                $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                         Theme::getThemeImagePath('filemanager/'.$icon), agt($tooltip));
                $elem12 = html_td('ptabla03', '', $img); 
                $elem12->set_tag_attribute('align', 'center');

                if( !$_folder ) {
                    //--------- ONLY TEACHER, TUTOR OR ADMIN CAN LOCK FILES ----------------
                    if ($profile_id < 4) {
                        if ($_lock == 0) {
                            $status= 'lock';
                            $icon='lock.png';
                            $tooltip='Bloquear';
                        } else {
                            $status='unlock';
                            $icon='unlock.png';
                            $tooltip='Desbloqear';
                        }
                        $status = 'status='.$status.'&id=';
                        $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                                 Theme::getThemeImagePath('filemanager/'.$icon), agt($tooltip));
                    } else {
                        $img = _HTML_SPACE;
                    }
                    $elem13 = html_td('ptabla03', '', $img);
                    $elem13->set_tag_attribute('align', 'center');

                    if ($_share == 0) {
                        $status= 'share';
                        $icon='invisible.png';
                        $tooltip='Compartir';
                    } else {
                        $status='unshare';
                        $icon='visible.png';
                        $tooltip='No compartir';
                    }
                    $status = 'status='.$status.'&id=';
                    $img = $this->imag_alone(Util::format_URLPath('filemanager/index.php',$status.$_id),
                                             Theme::getThemeImagePath('filemanager/'.$icon), agt($tooltip));

                    $elem14 = html_td('ptabla03', '', $img);
                    $elem14->set_tag_attribute('align', 'center');
                } else {
                    $link = _HTML_SPACE;
                    $elem13 = html_td('ptabla03', '', $link);
                    $elem13->set_tag_attribute('align', 'center');
                    $elem14 = html_td('ptabla03', '', $link);
                    $elem14->set_tag_attribute('align', 'center');
                }
                //--------------------- ADD OPERATIONS INTO TR CONTAINET -----------------
                $row->add($elem1);
                $row->add($elem2);
                $row->add($elem3);
                $row->add($elem4);
                $row->add($elem5);
                $row->add($elem6);
                $row->add($elem7);
                $row->add($elem8);
                $row->add($elem9);
                $row->add($elem10);
                $row->add($elem11);
                $row->add($elem12);
                $row->add($elem13);
                $row->add($elem14);
                return $row;
        }

        function _operationForm()
        {
                if ($this->issetViewVariable('operation_id') ) {
                        switch ($this->getViewVariable('operation_id') ) {
                                case 'newFolder':
                                        $ret_val = $this->addForm('filemanager', 'miguel_newFolderForm');
                                        break;
                                case 'submitFile':
                                        $ret_val = $this->addForm('filemanager', 'miguel_submitFileForm');
                                        break;
                                case 'rename':
                                        $ret_val = $this->addForm('filemanager', 'miguel_renameForm');
                                        break; 
                                case 'move':
                                        $ret_val = $this->addForm('filemanager', 'miguel_moveForm');
                                        break;
                                case 'comment':
                                        $ret_val = $this->addForm('filemanager', 'miguel_submitFileForm');
                                        break;  
                        }
                } else {
                        $ret_val = $this->addOperationBar();
                }

                return $ret_val;
    }

        function addOperationBar()
        {
                $current_folder_id = $this->getViewVariable('folder_id');
                $ret_val = html_tr();

                $content = container();

                $link1 = html_a(Util::format_URLPath('filemanager/index.php', 'folder_id=' . $current_folder_id . '&amp;operation_id=newFolder'), agt('Nueva carpeta'), 'p', '_top');
                $link2 = html_a(Util::format_URLPath('filemanager/index.php', 'folder_id=' . $current_folder_id . '&amp;operation_id=submitFile'), agt('Añadir documento'), 'p', '_top');

                $content->add( $link1);
                $content->add(_HTML_SPACE);
                $content->add($link2);

                $ret_val->add(html_td('ptabla03', '', $content));
                return $ret_val;
        }


    function content_section()
    {
        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
        $title = agt('Mis documentos');//.'/'.$this->getViewVariable('current_folder_name');

        $table->add_row(html_td('ptabla01', '', $title));

        $table->add_row(html_td('ptabla03', '', $this->addDocuments() ));
        //$table->add_row(html_td('ptabla03', '', $this->init_content() ));
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row($this->_operationForm());
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla01pie', '', $title));

        return $table;
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
                //$titulo->set_class('ptabla01');
                $main->add($titulo);

                $main->add($this->content_section());

                $main->add(html_br());

                $div_line = html_div();
                $div_line->set_tag_attribute('align', 'left');
                $div_line->add(html_img(Theme::getThemeImagePath("hr01.gif"), 400, 15));
                $main->add($div_line);

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
		
		$item1 = html_td('', '', 'Mi progreso');
                $item1->set_tag_attribute('width', '12%');
		$item2 = html_td('', '', 'Mis accesos directos' );
                $item2->set_tag_attribute('width', '16%');
		$item3 = html_td('', '', 'Mis contactos');
                $item3->set_tag_attribute('width', '12%');
		$item4 = html_td('', '', 'Mis notas');
                $item4->set_tag_attribute('width', '10%');

                $link = html_a(Util::format_URLPath("filemanager/index.php"), agt('Mis documentos'), null, "_top");
                $link->set_tag_attribute('class', '');
                $item5 = html_td('', '', $link);
                $item5->set_tag_attribute('width', '12%');

                $row->add($blank);
                $row->add($image);
                $row->add($item1);
                $row->add($item2);
                $row->add($item3);
		$row->add($item4);
		$row->add($item5);

                $table->add_row($row);

                $div->add($table);

                return $div;
        }
}

?>
