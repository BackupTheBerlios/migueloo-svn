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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla com˙n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar· la informaciÛn
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
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vbase.class.php"));
class miguel_VIntro extends miguel_VBase
{
    function miguel_VIntro($title, $arr_commarea)
    {
        $this->miguel_VBase($title, $arr_commarea);
    }

    function main_block()
        {
                $main = html_div();
		$main->set_id("content");

		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1,0);
		$table->set_class("simple");
		
		//Centros
		$elem1 = html_td("color1-bg", "", $this->left_block());
		$elem1->set_id("anonymous");
		//Nombre del sitio web
		$elem2 = html_td("colorLogin-bg", "",$this->right_block());
		$elem2->set_id("identification");

		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);
		$table->add_row($row);
		$main->add( $table );

		return $main;
    }

        function right_block()
    {
            $div = html_div();
        $div->add($this->addForm('common', 'miguel_loginForm'));

        return $div;
    }

        function left_block()
    {
                $ret_val = container();
		
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$ret_val->add($hr);
		
		
		$div = html_div("ul-big");
                //Mensaje de bienvenida
                $div->add($this->_addFileContent(Theme::getTheme().Session::getContextValue('texto_ini')));

                $ret_val->add($div);
        return $ret_val;
    }
}
?>
