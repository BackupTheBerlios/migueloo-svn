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
      | Authors: Miguel Majuelos Mudarra <www.polar.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patr�n MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage control
 */

 /**
 */

class MenuBar
{
    var $menus = array();

	
    function MenuBar()
    {
         //Inicia el contexto de la clase
					$this->_processXMLInitData(Util::app_Path('common/include/menu.xml'));	
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
    
    //Devuelve el c�digo html para mostrar los submen�s del men� $_menu
    function getMenuCode($_menu)
    {
    	$menu = $this->getMenu($_menu);
			
			for ($i=1; $i<count($menu); $i++)
			{
				$strHref = $menu[$i]['link'];
				$strName = $menu[$i]['name'];
				$strRet = $strRet . "addref('$strHref','$strName');";
			} 	
			return($strRet);		
    }
    
    
    
	/*
	 * Procesa el fichero de configuraci�n
	 * El fichero de configuraci�n est� en formato XML.
	 * @param string $str_fileName Nombre del fichero de configuraci�n
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
					$menu		= & $root_elements[$i];
					$num_menus		= $menu->numChildren();
					$menu_items 	= & $menu->getAllChildren();

					for ($j=0; $j < $num_menus; $j++)
					{
						switch($menu_items[$j]->name())
						{
							case 'name':
									$menuName = $menu_items[$j]->getValue();
									$this->menus[$i]['name'] = $menuName;
							case 'option':
				    			//Datos del menu
									$option		= & $menu_items[$j];
									$num_options		= $option->numChildren();
									$option_items 	= & $option->getAllChildren();

									for ($k=0; $k < $num_options; $k++)
									{
										$strOptionName = $option_items[$k]->name();
										$strOptionValue = $option_items[$k]->getValue();
										$this->menus[$i][$j][$strOptionName] = $strOptionValue;
									}
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
