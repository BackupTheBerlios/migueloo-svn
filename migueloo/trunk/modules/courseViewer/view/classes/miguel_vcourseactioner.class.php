<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
 * Include classes library
 */
include_once(Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VCourseActioner extends miguel_VMenu
{
        function miguel_VCourseActioner($title, $arr_commarea)
    {
                $this->miguel_VMenu($title, $arr_commarea);
                $this->file_path = $this->getViewVariable('path');
                $this->add_css_link($this->_coursePath('css/estilo.css'));
     }

     function right_block()
    {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);

                //$sinBotones = $this->getViewVariable('sinBotones');

                //if (!isset($sinBotones) || $sinBotones==false) {
                        //Botonera de navegación
                        $table->add_row(html_td('', '', $this->_getControlContent($this->getViewVariable('esInicio'),$this->getViewVariable('hayPrevio'),$this->getViewVariable('haySiguiente'))));
                //}

                //Contenido de la página
                $table->add_row(html_td('', '', $this->_getFileContent($this->getViewVariable('actual'))));

                //Botonera de navegación
                if (!isset($sinBotones) || $sinBotones==false) {
                        $table->add_row(html_td('', '', $this->_getControlContent($this->getViewVariable('esInicio'),$this->getViewVariable('hayPrevio'),$this->getViewVariable('haySiguiente'))));
                }

                return $table;
    }

        function _getFileContent($filename)
    {
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

                $row = html_tr();

                if($this->getViewVariable('ban_mid') < 10){
                        $img = 'imgcurso/0'.$this->getViewVariable('ban_mid').'.gif';
                } else {
                        $img = 'imgcurso/'.$this->getViewVariable('ban_mid').'.gif';
                }

                $menu = html_td('','',html_img($this->_coursePath($img)));
                $menu->set_tag_attribute('valign','top');
                //$row->add($menu);

                $content = html_td('','', $this->formatContent($filename));
                $content->set_tag_attribute('valign','top');
        $row->add($content);

                $table->add_row($row);

        return $table;
    }

        function formatContent($filename)
        {
                $table = html_table(Session::getContextValue("mainInterfaceWidth"));
                $table->set_tag_attribute('align', 'center');

                //Cuerpo
                $row1 = html_tr();

                $data = 'Fichero vacio o no existe';
                //Debug::oneVar($filename, __FILE__, __LINE__);
        if(file_exists($filename) && is_file($filename)) {
            ob_start();
            include_once($filename);
            $data = ob_get_contents();
            ob_end_clean();
        }
                $table->add_row($data);

                $form = html_td('ptexto01','',$this->addForm('courseViewer', 'miguel_externalForm'));
                $form->set_tag_attribute('align','center');
                $table->add_row($form);

                return $table;
        }
   function _getControlContent($init, $prev, $sig)
    {
                $ret_val = html_table('100',0,3,0);

                if(!$init){
                        $inicio = html_img_href(Util::format_URLPath('courseViewer/index.php', 'opt=init'), //url
                                                                        Theme::getThemeImagePath('inicio.jpg'), //imagen
                                                                        28, 21, 0, 'Inicio'); //width, height, border, alt
                } else {
                        $inicio = html_img(Theme::getThemeImagePath("invisible.gif"), 17, 20, 0);
                }
                $c_inicio = html_td('','',$inicio);

                if($prev){
                        $previo = html_img_href(Util::format_URLPath('courseViewer/index.php', 'opt=prev'), //url
                                                                        Theme::getThemeImagePath('anterior.jpg'), //imagen
                                                                        65, 21, 0, 'Previo'); //width, height, border, alt
                } else {
                        $previo = html_img(Theme::getThemeImagePath("invisible.gif"),74, 20, 0);
                }
                $c_previo = html_td('','',$previo);

                $sinBotones = $this->getViewVariable('sinBotones');
                if (!isset($sinBotones) || $sinBotones==false) {
                        if($sig){
                                $siguiente = html_img_href(Util::format_URLPath('courseViewer/index.php', 'opt=next'), //url
                                                                                Theme::getThemeImagePath('siguiente.jpg'), //imagen
                                                                                75, 21, 0, 'Siguiente'); //width, height, border, alt
                        } else {
                                $siguente = html_img(Theme::getThemeImagePath("invisible.gif"), 81, 20, 0);
                        }
                } else {
                        $siguiente = _HTML_SPACE;
                }
                $c_siguiente = html_td('','',$siguiente);

                $row = html_tr();
                $row->add($c_inicio);
                $row->add($c_previo);
                $row->add($c_siguiente);

                $ret_val->add_row($row);
            return $ret_val;
    }

        function _coursePath($file)
        {
                return Util::main_URLPath($this->file_path.$file);
        }
}
?>
