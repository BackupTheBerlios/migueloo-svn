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

class miguel_VCourseCard extends miguel_VMenu
{
    function miguel_VCourseCard($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
    }

	  function add_info($objectives, $description, $contents)
      {
    //        $row = html_tr();

			$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,5);
			$title = html_td('ptabla01', '', 'Ficha del curso');
			$title->set_tag_attribute('colspan', 2);
			$titleObj = html_td('ptabla02', '', 'Objetivos');
			$textObj = html_td('ptabla03', '', $objectives);
			$titleDes = html_td('ptabla02', '', 'Descripción');
			$textDes = html_td('ptabla03', '', $description);
			$titleCon = html_td('ptabla02', '', 'Contenidos');
			$textCon = html_td('ptabla03', '', $contents);
    		$table->add_row($title);	
    		$table->add_row($titleObj, $textObj);	
    		$table->add_row($titleDes, $textDes);	
    		$table->add_row($titleCon, $textCon);	
    		$table->add_row($title);	
			return $table;
      }

    function right_block()
    {
        //Crea el contenedor del right_block
		$main = container();

		$main->add(html_br());

		$status = $this->getViewVariable('status');
		switch($status)
		{
			case 'showForm':	$main->add($this->addForm('courseCard', 'miguel_coursecardform'));
									break;
			case 'update':
			case 'show':
			default:
									$arrCourseCard = $this->getViewVariable('arrCourseCard');
									$tableInfo = $this->add_info($arrCourseCard['objectives'], $arrCourseCard['description'], $arrCourseCard['contents']);
									$main->add( $tableInfo );
									$tableForm = $this->addForm('courseCard', 'miguel_coursesubmitform');
									$main->add($tableForm);
									break;
		}
		return $main;
    }
}
?>
