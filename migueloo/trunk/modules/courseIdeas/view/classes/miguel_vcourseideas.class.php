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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VCourseIdeas extends miguel_VMenu
{
    function miguel_VCourseIdeas($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
    }


	  function add_info($arrIdeas)
      {
			$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,5);
			$title = html_td('ptabla01', '', 'Ideas del curso');
			$title->set_tag_attribute('colspan', 3);
			$table->add_row($title);
		    for ($i=0; $i<count($arrIdeas); $i++) {
				$table->add($this->add_idea($arrIdeas[$i]['title'], $arrIdeas[$i]['body'], $arrIdeas[$i]['id'], $i));
		    }
			$table->add_row($title);
			return $table;	 
	  }

	  function add_idea($title, $body, $id, $index)
      {
			$row = html_tr();

			$lDelete = html_a(Util::format_URLPath('courseIdeas/index.php',"status=delete&idi=$id"), 'Eliminar');
			$lUpdate = html_a(Util::format_URLPath('courseIdeas/index.php',"status=showForm&index=$index"), 'Modificar');
			$tdLinks = html_td('ptabla03','', $lDelete, $lUpdate);
			$title = html_td('ptabla02', '', $title);
			$body = html_td('ptabla03', '', $body);
    		$row->add($title);
			$row->add($body);	
			$row->add($tdLinks);	
			return($row);
      }

    function right_block()
    {
        //Crea el contenedor del right_block
		$main = container();

		$main->add(html_br());

		$status = $this->getViewVariable('status');
		switch($status)
		{
			case 'showForm':	$main->add($this->addForm('courseIdeas', 'miguel_courseideasform'));
									break;
			case 'update':
			case 'new':
			default:
									$arrCourseIdeas = $this->getViewVariable('arrCourseIdeas');
									$tableInfo = $this->add_info($arrCourseIdeas);
									$main->add( $tableInfo );
									$tableForm = $this->addForm('courseIdeas', 'miguel_coursesubmitform');
									$main->add($tableForm);
									break;
		}
		return $main;
    }

}
?>
