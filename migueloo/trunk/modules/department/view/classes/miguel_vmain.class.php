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
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas  <antoniofcano@telefonica.net>
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

class miguel_VMain extends miguel_VMenu
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
    function miguel_VMain($title, $arr_commarea) 
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
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$ret_val->add($hr);
		
		$div = html_div("ul-big");
		
		$div->add(Theme::getThemeImage("edcenters.png"));
		$div->add(agt('miguel_Center'));
		$div->add( html_br(2) );

	        $div->add( $this->_categoryTable());
                $div->add( $this->_courseList()); 	

		$ret_val->add($div);
        return $ret_val;
    }

    function _courseList()
    {
        $ret_val = new container();

        $div = html_div("medium-text");                
        $div->add(html_br(2));

        $course = $this->getViewVariable('arr_courses');
        if ( is_array($course) && $course[0]['course_id'] ) {
            $ul = html_ul();
            $countCourse = count($course);
            for($i=0; $i < $countCourse; $i++) {
                    $elem = container();
                    $elem->add(html_a(Util::format_URLPath("course/index.php", "course=".$course[$i]["course_id"]), $course[$i]["course_name"], null, "_top"));
                    $elem->add(html_br());
                    $elem->add($course[$i]["course_description"]);
                    $ul->add($elem);
            }
            $div->add($ul);
 
            $ret_val->add($div);
        }
        return $ret_val;
    }	

    function _categoryTable()
    {
    	$ret_val = container();
    	$category = $this->getViewVariable('arr_categories');
    	
    	if (is_array($category) && $category[0]['name']) {
    		$div = html_div('medium-text');
    		
    		$ul = html_ul();
            $countCategory = count($category);
        	for($i=0; $i < $countCategory; $i++) {
        		$elem = container();
        		$elem->add(html_a(Util::format_URLPath('area/index.php', 'institution_id=' . $this->getViewVariable('institution_id') . '&faculty_id=' . $this->getViewVariable('faculty_id') . '&department_id=' . $category[$i]['id']), $category[$i]['name'], null, '_top'));
        		$elem->add(html_small('(' . $category[$i]['num'] . ')'));
        		$ul->add($elem);
        	}
        	$div->add($ul);
        	
        	$ret_val->add($div);
        }
    	
        return $ret_val;
    }

}

?>
