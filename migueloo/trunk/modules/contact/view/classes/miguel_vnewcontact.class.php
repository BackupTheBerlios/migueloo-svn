<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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

class miguel_VNewContact extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 */
    function miguel_VNewContact($title, $arr_commarea)
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

		$titulo = html_p("Nuevo Contacto");
		$titulo->set_tag_attribute('class', 'ptabla01');
		$ret_val->add($titulo);
		
		$ret_val->add($this->addForm('contact', 'miguel_contactForm'));
		
        return $ret_val;
    }
}
?>
