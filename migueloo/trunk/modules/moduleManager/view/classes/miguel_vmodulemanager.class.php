<?php
/*
      +----------------------------------------------------------------------+
      | miguel_valumnpage.class.php                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VModuleManager extends miguel_VMenu
{
    function miguel_VModuleManager($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
    }

	function addSubmenu($_menu_id, $_submenu, $submenu_id, $_extreme)
	{
		$row = html_tr();
		$class = 'ptabla02';
		$submenu = html_td($class, '',$_submenu);
		$imgUp = $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=upSubmenu&menu_id=$_menu_id&submenu_id=$submenu_id&menu_id=$_menu_id"),Theme::getThemeImagePath('boton_arriba.gif'), agt('Subir'));
		$imgDown = $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=downSubmenu&menu_id=$_menu_id&submenu_id=$submenu_id&menu_id=$_menu_id"),Theme::getThemeImagePath('boton_abajo.gif'), agt('Bajar'));
		$manageSubmenu = html_td($class, 'center', $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=selectOptionsForm&menu_id=$_menu_id&submenu_id=$submenu_id"),Theme::getThemeImagePath('redactar_mensaje.gif'), agt('Editar')));

		switch($_extreme)
		{
			case 'none':
					$updownSubmenu = html_td($class, 'center', ' ');
					break;
			case 'first':
					$updownSubmenu = html_td($class, 'center', $imgDown);
					break;
			case 'last':
					$updownSubmenu = html_td($class, 'center', $imgUp);
					break;
			default:
					$updownSubmenu = html_td($class, 'center', $imgUp, $imgDown);
					break;
		}

		$submenu->set_tag_attribute('width', '80%');
		$manageSubmenu->set_tag_attribute('width', '10%');
		$updownSubmenu->set_tag_attribute('width', '10%');
		
		$row->add($submenu);
		$row->add($manageSubmenu);
		$row->add($updownSubmenu);
		return $row;
	}

	function addOption($_menu_id, $submenu_id, $_option='', $option_id=0, $_extreme ='')
	{
		$row = html_tr();
		$class = 'ptabla03';
		$option = html_td($class, '',$_option);
		$option->set_tag_attribute('width', '80%');
		$option->set_tag_attribute('colspan', '2');
		$imgUp = $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=upOption&menu_id=$_menu_id&submenu_id=$submenu_id&option_id=$option_id"),Theme::getThemeImagePath('boton_arriba.gif'), agt('Subir'));
		$imgDown = $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=downOption&menu_id=$_menu_id&submenu_id=$submenu_id&option_id=$option_id"),Theme::getThemeImagePath('boton_abajo.gif'), agt('Bajar'));

		switch($_extreme)
		{
			case 'none':
					$updownOption = html_td($class, 'center', ' ');
					break;
			case 'first':
					$updownOption = html_td($class, 'center', $imgDown);
					break;
			case 'last':
					$updownOption = html_td($class, 'center', $imgUp);
					break;
			default:
					$updownOption = html_td($class, 'center', $imgUp, $imgDown);
					break;
		}
		

		$row->add($option);
		$row->add($updownOption);
		return $row;
	}

	function addMenu()
	{
		$row = html_tr();
		$tdTitulo = html_td('ptabla01', '', 'Menú'); 
		$manageMenu = html_td('ptabla01', 'center', $this->imag_alone(Util::format_URLPath('moduleManager/index.php',"status=selectSubmenusForm&menu_id=$_menu_id"),Theme::getThemeImagePath('redactar_mensaje.gif'), agt('Editar')));
		$tdWriteXML = html_td('ptabla01', '', html_a(Util::format_URLPath('moduleManager/index.php',"status=writeXML&menu_id=$_menu_id"), 'Crear XML'));
		$row->add($tdTitulo, $manageMenu, $tdWriteXML);
		return($row);
	}

	function showMenu($arrMenu)
	{
			$menu = $this->getViewVariable('menu');
			$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
			$table->add($this->addMenu());
			$iLimit = count($arrMenu);
			for ($i=0; $i<$iLimit; $i++) {
				$table->add($this->addSubmenu( $menu, $arrMenu[$i]['name'], $arrMenu[$i]['submenu_id'], $this->getExtreme($i, $iLimit)));
				$jLimit = count($arrMenu[$i])-2;
				for ($j=0; $j<$jLimit; $j++) {
					$table->add($this->addOption($menu,
																	$arrMenu[$i]['submenu_id'], 
																	$arrMenu[$i][$j]['name'], 
																	$arrMenu[$i][$j]['option_id'],
																	$this->getExtreme($j, $jLimit)
											));
				}
			}
			return($table);
	}

	//====================================
	//Devuelve los botones up-down necesarios
	// 'none' si el tamaño es 1
	// 'first' si es el primero
	// 'last' si es el ultimo
	// '' en otro caso
	//====================================
	function getExtreme($_index, $_size)
	{
		if ($_size ==1) $extreme = 'none';
		else if ($_index==0) $extreme = 'first';
		else if ($_index+1==$_size) $extreme = 'last';
					else $extreme = '';
		return($extreme);
	}

    function right_block()
    {
        //Crea el contenedor del right_block
		$main = container();

		$main->add(html_br());

		$status = $this->getViewVariable('status');
		switch($status)
		{
			case selectOptionsForm:
					$main->add($this->addform('moduleManager','miguel_selectoptionsform'));
					$main->add(html_br());
					$main->add($this->addform('moduleManager','miguel_newoptionform'));
					break;
			case selectSubmenusForm:
					$main->add($this->addform('moduleManager','miguel_selectsubmenuform'));
					$main->add(html_br());
					$main->add($this->addform('moduleManager','miguel_newsubmenuform'));
					break;
			default:
			case writeXML:
			case main: 
					$arrMenu = $this->getViewVariable('arrMenu');
					$main->add($this->showMenu($arrMenu));
					break;
		}


		return $main;
    }
}
?>
