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
          |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/

class miguel_CModuleManager extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CModuleManager()
        {
                $this->miguel_Controller();
                $this->setModuleName('moduleManager');
                $this->setModelClass('miguel_MModuleManager');
                $this->setViewClass('miguel_VModuleManager');
                $this->setCacheFlag(false);
        }


		function writeXMLFile($_strFileName, $_arrMenu)
		{
			$xml = new MiniXMLDoc();
      
		  	$xmlRoot =& $xml->getRoot();
      
      		$menuBar =& $xmlRoot->createChild('menuBar');

			for ($i=0; $i<count($_arrMenu); $i++) {
				$menu = & $menuBar->createChild('menu');
				$menuName = & $menu->createChild('name');
		      	$menuName->text($_arrMenu[$i]['name']);
				for ($j=0; $j<count($_arrMenu[$i])-2;$j++) {
					$option = & $menu->createChild('option');
				  	$child = & $option->createChild('name');
			      	$child->text($_arrMenu[$i][$j]['name']);
			      	$child = & $option->createChild('type');
				  	$child->text('i');
	      			$child = & $option->createChild('link');
	      			$child->text($_arrMenu[$i][$j]['module_name']);
	      			$child = & $option->createChild('param');
	      			$child->text($_arrMenu[$i][$j]['param']);
				}
			}
			$this->writeFileFromString($_strFileName, $xml->toString());
	 }

		function writeFileFromString($_strFileName, $_strContent)
		{
		   if ($f = fopen($_strFileName, 'w+')) {
			   fwrite($f, $_strContent);
		   } 
		  fclose($f);
		}

		//Devuelve los módulos existentes
		function getActiveModules()
		{
			$modulelist = array();
			$dir = opendir(MIGUEL_MODULES_DIR);

			 while ($item = readdir ($dir)){
				if($item != '.' && $item != '..' && !is_file($item)){
					$modulelist["$item"] = $item;
				}
			}
			closedir($dir);
			return $modulelist;
	    }


		function readViewVariable($_name, $_default=null)
		{
				if ($this->issetViewVariable($_name)) {
					$var = $this->getViewVariable($_name);
					if ($var == null) {
						$var = $_default;
					}
				} else {
					$var = $_default;
				}
				return($var);
		}
		
        function processPetition()
        {
                $this->clearNavBarr();

				//$this->writeXMLFile('c:/temp/a.xml');

				$menu_id = $this->readViewVariable('menu_id', 1);
				$status = $this->readViewVariable('status', '');

	
				//Estados de transición
				switch($status)
				{
					case newSubmenu:
							$name = $this->getViewVariable('name');
							$this->obj_data->insertSubmenu($menu_id, $name);
							$status = 'selectSubmenusForm';
							$this->setViewVariable('status', $status);
							break;
					case deleteSubmenu:
							$submenu_id = $this->getViewVariable('submenu_id');
							$this->obj_data->deleteSubmenu($submenu_id);
							$status = 'selectSubmenusForm';
							$this->setViewVariable('status', $status);
							break;
					case deleteOption:
							$option_id = $this->getViewVariable('option_id');
							$this->obj_data->deleteOption($option_id);
							$status = 'selectOptionsForm';
							$this->setViewVariable('status', $status);
							break;
					case newOption:
							$submenu_id = $this->getViewVariable('submenu_id');
							$name = $this->getViewVariable('nameopt');
							$this->obj_data->insertOption($submenu_id, $name);
							$status = 'selectOptionsForm';
							$this->setViewVariable('status', $status);
							break;
					case selectOptions:
							$submenu_id = $this->getViewVariable('submenu_id');
							$arrOptions = $this->obj_data->getAllOptions();
							for ($i=0; $i<count($arrOptions); $i++) {
								$option_id = 'option' . $arrOptions[$i]['option_id'];
								if ($this->getViewVariable("$option_id") == 1) {
									$this->obj_data->insertSubmenuOption($submenu_id, $arrOptions[$i]['option_id']);
								} else {
									$this->obj_data->deleteSubmenuOption($submenu_id, $arrOptions[$i]['option_id']);
								}
								$module_folder_name = $this->getViewVariable('modulefile' . $arrOptions[$i]['option_id']);
								$module_folder_id = $this->obj_data->getModuleFolderId($module_folder_name);
								$param = $this->getViewVariable('param' . $arrOptions[$i]['option_id']);
								$this->obj_data->updateOption($arrOptions[$i]['option_id'], $module_folder_id, $param);
							}
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
					case selectSubmenus:
							$arrSubmenus = $this->obj_data->getAllSubmenus();
							for ($i=0; $i<count($arrSubmenus); $i++) {
								$submenu_id = 'submenu' . $arrSubmenus[$i]['submenu_id'];
								if ($this->getViewVariable("$submenu_id") == 1) {
									$this->obj_data->insertMenuSubmenu($menu_id, $arrSubmenus[$i]['submenu_id']);
								} else {
									$this->obj_data->deleteMenuSubmenu($menu_id, $arrSubmenus[$i]['submenu_id']);
								}
							}
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
					case upOption:
							$submenu_id = $this->getViewVariable('submenu_id');
							$option_id = $this->getViewVariable('option_id');
							$this->obj_data->upOrderSubmenuOption($submenu_id, $option_id);
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
					case downOption:
							$submenu_id = $this->getViewVariable('submenu_id');
							$option_id = $this->getViewVariable('option_id');
							$this->obj_data->downOrderSubmenuOption($submenu_id, $option_id);
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
					case upSubmenu:
							$submenu_id = $this->getViewVariable('submenu_id');
							$this->obj_data->upOrderSubmenu($menu_id, $submenu_id);
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
					case downSubmenu:
							$submenu_id = $this->getViewVariable('submenu_id');
							$this->obj_data->downOrderSubmenu($menu_id, $submenu_id);
							$status = 'main';
							$this->setViewVariable('status', $status);
							break;
				}


				//Estados finales
				switch($status)
				{
					default:
					case writeXML:
									$arrMenu = $this->obj_data->getMenu($menu_id);
									$this->setViewVariable('arrMenu',$arrMenu);
									$this->writeXMLFile('c://menu.xml', $arrMenu);
									break;
					case main: 
									$arrMenu = $this->obj_data->getMenu($menu_id);
									$this->setViewVariable('arrMenu',$arrMenu);
									break;
					case selectOptionsForm:
									$submenu_id = $this->getViewVariable('submenu_id');
									$arrOptions = $this->obj_data->getCheckedOptions($submenu_id);
									$this->setViewVariable('arrOptions', $arrOptions);
									$arrModuleFolders = $this->getActiveModules();
									$this->setViewVariable('arrModuleFolders', $arrModuleFolders);
									break;
					case selectSubmenusForm:
									$arrSubmenus = $this->obj_data->getCheckedSubmenus($menu_id);
									$this->setViewVariable('arrSubmenus', $arrSubmenus);
									break;
				}


                $this->setPageTitle("miguel Module Manager");
                $this->setMessage('');
                $this->setHelp("");
        }
}
?>