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
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vbase.class.php"));

class miguel_VExit extends miguel_VBase
{
	function miguel_VExit($title, $arr_commarea)
	{
		$this->miguel_VBase($title, $arr_commarea);
		
		// <META HTTP-EQUIV="refresh" content="5; URL=http://">
		//$this->add(html_meta  ('5', "refresh", Util::main_URLPath('index.php'));
	}

    function main_block() 
    {
		$main = html_div();

		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1,0);
		$table->add_row($this->_block());
        
        $main->add( $table );

		return $main;
    }
    
    function _block() 
    {
		include_once (Util::app_Path("common/view/classes/miguel_navform.class.php"));
		$ret_val = container();
		
		$titulo = html_h4('Ha salido correctamente de la aplicación');
		$titulo->set_tag_attribute('class', 'ptexto01');
		
		$msg = html_p('Para continuar trabajando en este Campus debe regresar a la página de inicio y acceder de nuevo.');
		$msg->set_tag_attribute('class', 'ptexto01');
		
		$ret_val->add($titulo);
		$ret_val->add($msg);
		//Dejar así, no usar  $this->addForm(), ya que el enlace se hace sin SID
		$ret_val->add(new FormProcessor(new miguel_navForm(), 'reload', Util::main_URLPath('index.php')));

        return $ret_val;
    }
}

?>
