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
include_once(Util::app_Path("common/view/classes/miguel_vpage.class.php"));

class miguel_VMenu extends miguel_VPage
{
    function miguel_VMenu($title, $arr_commarea)
    {
        $this->miguel_VPage($title, $arr_commarea);
     }

    function main_block() 
    {
    	$main = html_div();
		$main->set_id('content');

		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
		$table->set_class('simple');
		
		
        //Barra Herramientas
		if ($this->str_type == 'toolbar') {
			$elem1 = html_td('', '', $this->left_block());
			//$elem1->set_id("anonymous");
			//$elem1->set_tag_attribute('width', 40);
			//$elem1->set_tag_attribute('valign', 'top');
		}
		//Principal
		$elem2 = html_td('toolmain', '',$this->right_block());
		//$elem2->set_tag_attribute('valign', 'top');
		//$elem2->set_id("identification");
        
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);

		$table->add_row($row);
        
        $main->add( $table );

		return $main;
	}
    
    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function left_block() 
    {
		$ret_val = container();
		
		//$hr = html_hr();
		//$hr->set_tag_attribute("noshade");
		//$hr->set_tag_attribute("size", 2);
		//$ret_val->add($hr);
		
		$div = html_div();
		$table = html_table('',0,0,0,'');
		//$table = html_table('100%',0,0,0,'center');
		//$table->set_class('toolbar');
		$table->set_class('rollover');
		//$table->set_id('barra');
		
		$arr_elem = $this->_getBarrElements();
		//$arr_elem = $this->_getBarrElementsbyFile();

		$profile = $this->getSessionElement('userinfo', 'profile_id');

		foreach ($arr_elem as $app => $params) {
            //Para acceso con gacl. Bloquada hasta versiones superiores.
			//if($this->checkAccess('miguel_VMenu', $params[0], 'profile', $profile)){
			if($this->checkAccess($params[0], $profile)){
            	if(strncmp($params[1], 'http://', 7) != 0) {
    		  		$table->add_row($this->imag_alone(Util::format_URLPath($params[1], $params[2]), 
    		  										  Theme::getThemeImagePath('menu/'.$params[3]),
    		  										  $params[4]));
    		  	} else {
    		  		$table->add_row($this->imag_alone($params[1], 
    		  										  Theme::getThemeImagePath('menu/'.$params[3]),
    		  										  $params[4]));
    		  	}
    		}
        }
		
		$div->add( $table );
		$ret_val->add($div);
            	
        return $ret_val;
    }
    
    /**
     * Obtiene los elementos a incluir en la barra
     * @internal
     */
    function _getBarrElements()
    {
    	$registry = &Registry::start();
    	$services = $registry->listServices();
	
    	return $services;
    } 
}

?>
