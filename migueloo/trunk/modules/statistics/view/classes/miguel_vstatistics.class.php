<?php
/*
      +----------------------------------------------------------------------+
      |statistics/view                                                       |
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

class miguel_VStatistics extends miguel_VMenu
{

    function miguel_VStatistics($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }
	
    function right_block() 
    {
		$main = html_div();
		$main->set_tag_attribute('width', Session::getContextValue('mainInterfaceWidth'));
		
		$hr = html_hr();
		$hr->set_tag_attribute('noshade');
		$hr->set_tag_attribute('size', 2);
		
		
		//AÃ±ade la linea horizontal al contenedor principal
		$main->add($hr);
		
		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
		$table->set_tag_attribute('border');
		
		//Cabecera
		$elem1 = html_td('ptabla02', '', html_b('Perfil'));
		$elem1->set_tag_attribute('width', '50%');
		$elem2 = html_td('ptabla02', '', html_b('Conexiones'));
		$elem2->set_tag_attribute('align', 'right');
		$elem3 = html_td('ptabla02', '', html_b('%'));
		$elem3->set_tag_attribute('align', 'right');
		$table->add_row($elem1, $elem2, $elem3);
		
	
		$arrUsers = $this->getViewVariable('arrUsers');	
		$iTotalCon = $this->getViewVariable('iTotalCon');
		for ($i=0; $i<count($arrUsers); $i++) {
			$elem1 = html_td('ptabla03', '', $arrUsers[$i]['user.user_alias']);
			$elem2 = html_td('ptabla03', '', $arrUsers[$i]['countLogin']);			
			$elem2->set_tag_attribute('align', 'right');
			$porc = sprintf('%.2f', ($arrUsers[$i]['countLogin'] * 100)/$iTotalCon);
			$elem3 = html_td('ptabla03', '', $porc);			
			$elem3->set_tag_attribute('align', 'right');
			$table->add_row($elem1, $elem2, $elem3);
		}
		
		$elem1 = html_td('ptabla03', '', html_b('TOTAL'));
		$elem2 = html_td('ptabla03', '', html_b($iTotalCon));			
		$elem2->set_tag_attribute('align', 'right');
		$elem3 = html_td('ptabla03', '', html_b(100));			
		$elem3->set_tag_attribute('align', 'right');
		$table->add_row($elem1, $elem2, $elem3);
		
		$main->add( $table );
		
		return $main;
    }
}
?>
