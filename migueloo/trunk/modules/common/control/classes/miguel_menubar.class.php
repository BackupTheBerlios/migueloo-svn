<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
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
      | Authors: Miguel Majuelos Mudarra <www.polar.es>                      |
	  |          Jesús A. Martínez Cerezal <jamarcer@inicia.es>              | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage control
 */

 /**
 */

class miguel_MenuBar
{
    var $menus = array();

	
    function miguel_MenuBar($menu_file = '')
    {
		$file = Util::app_Path('common/include/menu.xml');
		if(!empty($menu_file)) {
			$file = Util::app_Path('common/include/'.$menu_file);
		} 
		$this->_processXMLInitData($file);
		//Debug::oneVar($this, __FILE__, __LINE__);
    }

	
    function getMenu($i)
	{
		return ($this->menus[$i]);
	}

    function getMenuName($i)
	{
		return ($this->menus[$i]['name']);
    }

    function countMenu()
	{
		return (count($this->menus));
    } 
    
    //Devuelve el código html para mostrar los submenús del menú $_menu
    function getMenuCode($_menu)
    {
    	$menu = $this->getMenu($_menu);
		
			$strName = $menu['name'];
			$strCode = "['$strName','',null,";
			for ($i=1; $i<count($menu); $i++)
			{
				$strHref = $menu[$i]['link'];
				$strName = $menu[$i]['name'];
				$strCode = $strCode . "['$strName','$strHref'],";
			} 	
			$strCode = $strCode . '],';
			return($strCode);		
    }
   
	/*
	 * Procesa el fichero de configuración
	 * El fichero de configuración está en formato XML.
	 * @param string $str_fileName Nombre del fichero de configuración
	 *
	 * @internal
	 *
	 */
  	function _processXMLInitData($str_fileName)
	{
	
		//Include XMLMini
		require_once (MIGUELBASE_MINIXML.'/minixml.inc.php');

		//Abrimos el fichero
		$xml_obj = new MiniXMLDoc();

		//Procesamos el contenido
		$xml_obj->fromFile($str_fileName);

		//Cargamos la variable
		$xml_root 		=& $xml_obj->getElementByPath('menuBar');
		$num_elem 		=  $xml_root->numChildren();
		$root_elements 	=& $xml_root->getAllChildren();
			
		for($i=0; $i < $num_elem; $i++)
		{

			if ($root_elements[$i]->name() == 'menu')
			{
	    	//Datos del menu
				$menu		= &$root_elements[$i];

				$num_menus		= $menu->numChildren();
				$menu_items 	= &$menu->getAllChildren();
				
				for ($j=0; $j < $num_menus; $j++)
				{
					switch($menu_items[$j]->name())
					{
						case 'name':
							$menuName = $menu_items[$j]->getValue();
							$this->menus[$i]['name'] = $menuName;
							break;
						case 'option':
				   			//Datos del menu
							$option		= & $menu_items[$j];
							$num_options		= $option->numChildren();
							$option_items 	= & $option->getAllChildren();

							for ($k=0; $k < $num_options; $k++)
							{
								//Debug::oneVar($option_items[$k]->name(),__FILE__,__LINE__);
								switch($option_items[$k]->name())
								{
									case 'name':
										$opt_name = $option_items[$k]->getValue();
										break;
									case 'type':
										$opt_type = $option_items[$k]->getValue();
										break;
									case 'link':
										$opt_link = $option_items[$k]->getValue();
										break;
									case 'param':
										$opt_param = $option_items[$k]->getValue();
										break;
								}
							}
							
							if($opt_type == 'i'){
								$strOptionValue = Util::format_URLPath($opt_link.'/index.php', $opt_param);
							} else {
									$strOptionValue = $opt_link;
							}
							$this->menus[$i][$j]['name'] = $opt_name;
							$this->menus[$i][$j]['link'] = $strOptionValue;
							break;
					}	
				}
			}
		}
		//Debug::oneVar($this->menus, __FILE__, __LINE__);
		
		//Cerramos el xml
		unset($xml_obj);
	}

}
?>
