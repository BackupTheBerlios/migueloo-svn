<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       | 
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |      
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase para la pantalla de error de miguel.
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
class base_VError extends base_LayoutPage
{
	/**
	 * @access private
	 */
	var $gettext_domain = "error"; 

	/**
	 * This is the constructor.
	 *
	 * @param string - $title - the title for the page and the
	 *                 titlebar object.
	 * @param - string - The render type (HTML, XHTML, etc. )	
	 *                   default value = HTML
     *
	 */
    function base_VError($title, $arr_commarea) 
    {
        $this->base_LayoutPage($title, $arr_commarea);
    }


	/**
	 *
	 */
	function main_block() 
	{

		$main = html_div();
		$main->set_id("content");
		
		$title = html_h2("Se ha producido un error");
		$title->set_tag_attribute("class", "warncolor");
		$main->add($title);
		
		//Puede no estar definido el contexto
		$width = Session::getContextValue("mainInterfaceWidth");
		if(!isset($width)) {
			$width = "100%";
		} 
		$table = html_table($width,0,1,0);
		
		//Puede no estar definido el error
		$error = $this->getViewVariable('str_error');
		if(!isset($error)) {
			$error = "No error code was given";
		} 
		
		$row = html_td("warncolor", "",$error);
		$row->set_tag_attribute("align", "center");
		$table->add_row($row);
		
		//Puede no estar definido la url de retorno
		$url = $this->getViewVariable('str_url');
		if(isset($url)) {
			$row = html_td("", "",html_a($url, agt('Volver')));
			$row->set_tag_attribute("align", "center");
			$table->add_row($row);
		} 
		
		$main->add( $table );

		return $main;
	}

}

?>
