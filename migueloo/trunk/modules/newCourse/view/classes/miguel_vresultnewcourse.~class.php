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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla com�n para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar� la informaci�n
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
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));
include_once (Util::app_Path("newCourse/view/classes/miguel_resultnewcourseform.class.php"));

class miguel_VResultNewCourse extends miguel_VMenu 
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
  function miguel_VResultNewCourse($title, $arr_commarea)
  {
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
     $hr->set_tag_attribute('noshade');
     $hr->set_tag_attribute('size', 2);
     $ret_val->add($hr);
     $div = html_div('ul-big');
     $div->add(html_img(Util::app_URLPath('../var/themes/Miguel/image/menu/addcourse.png'), 0, 0, 0, ''));
     $div->add(html_b('Nuevo Curso Adicionado'));
     $div->add(html_br(2));
     $ret_val->add($div);
     $div1 = html_div();
     $div1->add(agt('El curso se ha adicionado correc6tamente en la base de datos.'));
     $div1->add( html_br(2) );
     $div1->add(agt('NOMBRE DEL CUSRSO'), ' : ', $this->getViewVariable('courseName') );
     $div1->add(html_br(2), agt('DESCRIPCION'), ' : ', $this->getViewVariable('courseDescription') );
     $div1->add(new FormProcessor(new miguel_resultNewCourseForm(), 'resultNewCourse', Util::format_URLPath('main/index.php')));
     $ret_val->add($div1);
     return $ret_val;            	
  }
    
}

?>
