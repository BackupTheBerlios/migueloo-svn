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
      | Authors: Eukene Elorza Bernaola <eelorza@ikusnet.com>                |
      |          Mikel Ruiz Diez <mruiz@ikusnet.com>                         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla común para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentará la información
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
 * @author Eukene Elorza Bernaola <eelorza@ikusnet.com>
 * @author Mikel Ruiz Diez <mruiz@ikusnet.com>
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

class miguel_VInsert extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string - $title - the title for the page and the
	 *                 titlebar object.
	 * @param - string - The render type (HTML, XHTML, etc. )	
	 *                   default value = HTML
     *
	 */
    function miguel_VInsert($title, $arr_commarea)
    {
        //Debug::oneVar($arr_commarea, __FILE__, __LINE__);
        $this->miguel_VMenu($title, $arr_commarea);
     }

    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function right_block()
    {
        $ret_val = container();
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$ret_val->add($hr);
		
		$ret_val->add(html_h4("Insertar nuevo enlace"));
	
		 if ($this->issetViewVariable('newlink') && $this->getViewVariable('newlink') == 'ok') {
            $ret_val->add(html_h2(agt('Inserción de enlace correcto.')));
			$ret_val->add(html_a(Util::main_URLPath('index.php'), agt('Regresar a la página principal')));
			$ret_val->add(html_br(2));
			$ret_val->add(html_a(Util::app_URLPath('links/index.php'), agt('Página de Enlaces')));
		} else {		
		               if ($this->issetViewVariable('msgError')  && $this->getViewVariable('msgError')!=''){
		               $ret_val->add(html_h2($this->getViewVariable('msgError')));
		                }
			$ret_val->add($this->addForm('links', 'miguel_insertionform'));
		}
        return $ret_val;
    }
}
