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
 * Define la clase para la visualización de páginas HTML estáticas en miguel.
 *
 * Se visualiza páginas HTML o PHP dentro del control de la aplicación
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once(Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VPageViewer extends miguel_VMenu
{
        var $file_path = '';

        function miguel_VPageViewer($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
        $this->file_path = dirname($this->getViewVariable('url'));
        //Debug::oneVar($this->file_path);
     }

    function right_block()
    {
             //$this->add(html_br());
                $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
               $table->add_row(html_td('', '', $this->_getFileContent($this->getViewVariable('url'))));

                return $table;
    }

    function _getFileContent($file)
    {
        $data = 'Fichero vacio o no existe';

        $filename = Util::formatPath(MIGUEL_APPDIR.'var/carton/'.$file);
        //Debug::oneVar($filename, __FILE__, __LINE__);
        if(file_exists($filename)) {
            ob_start();
            include_once("$filename");
            $data = ob_get_contents();
            ob_end_clean();
        }
        //Debug::oneVar($data, __FILE__, __LINE__);

        return $data;
    }

    function _coursePath($file)
        {
                  //return Util::main_URLPath('var/carton/'.$this->file_path.'/'.$file);
                  return Util::main_URLPath('var/carton/'.$file);
        }
}

?>