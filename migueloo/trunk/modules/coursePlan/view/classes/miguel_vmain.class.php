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
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VMain extends miguel_VMenu
{
	function miguel_VMain($title, $arr_commarea)
	{
		$this->miguel_VMenu($title, $arr_commarea);
	}

    function right_block()
    {
		$ret_val = container();

		$ret_val->add(html_br());
		$ret_val->add( $this->add_mainMenu());
		$ret_val->add(html_br());
		
		$ret_val->add( $this->_courseplanList());
                
		return $ret_val;
	}

    function _courseplanList()
    {
        $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		
		$title = html_td('ptabla01', '', 'Plan del curso');
		$title->set_tag_attribute('colspan', 2);
		$table->add_row($title);

		$courseplan = $this->getViewVariable('arr_courseplan');

		if ($courseplan[0]['id'] !=  null){
			$table->add($this->add_head());
			for ($i=0; $i<count($courseplan); $i++){
				$table->add($this->add_info($courseplan[$i]['name'],
								$courseplan[$i]['description'],
								$courseplan[$i]['id']));
			}
		} else {
				$table->add(html_td('ptabla02', '', 'Lista vacia'));
		}
		$pie = html_td('ptabla01pie', '', 'Plan del curso');
		$pie->set_tag_attribute('colspan', 2);
		$table->add_row($title);

		return $table;
    }

        function add_head()
        {
            $row = html_tr();

                $col1 = html_td('ptabla01', "", html_b('Unidad'));
                $col2 = html_td('ptabla01', "", html_b('Descripción'));

                 $col1->set_tag_attribute('width',"35%");
                 $col2->set_tag_attribute('width',"65%");

                $row->add($col1);
                $row->add($col2);

                 return $row;
        }

        function add_info($_name, $_desc, $_id)
        {
                $course_id = $this->getViewVariable('courseid');
        $row = html_tr();

                $col1 = html_td('ptabla02', '', html_a(Util::format_URLPath('courseViewer/index.php','id='.$course_id.'&mid='.$_id),$_name, 'titulo02a'));
                $col2 = html_td('ptabla03', '', nl2br($_desc));

                 $col1->set_tag_attribute('width',"35%");
                 $col2->set_tag_attribute('width',"65%");

                $row->add($col1);
                $row->add($col2);

                 return $row;
        }

	function add_mainMenu()
	{
		$div = html_div('');
		$div->add(html_br());

		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		$row = html_tr();
		$blank = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
		//$blank->set_tag_attribute('colspan','4');

		$image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
		$image->set_tag_attribute('align', 'right');
		$image->set_tag_attribute('width', '40%');

		$link = html_a(Util::format_URLPath("courseCard/index.php"), agt('Ficha del curso'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item1 = html_td('', '', $link);
		$item1->set_tag_attribute('width', '15%');

		$link = html_a(Util::format_URLPath("coursePlan/index.php"), agt('Mapa del curso'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item2 = html_td('', '', $link);
		$item2->set_tag_attribute('width', '15%');

		$link = html_a(Util::format_URLPath("courseIdeas/index.php"), agt('Ideas clave'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item3 = html_td('', '', $link);
		$item3->set_tag_attribute('width', '15%');
		
		$link = html_a(Util::format_URLPath("courseActivities/index.php"), agt('Actividades'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item4 = html_td('', '', $link);
		$item4->set_tag_attribute('width', '15%');
		
		$link = html_a(Util::format_URLPath("courseEvaluation/index.php"), agt('Evaluación'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item5 = html_td('', '', $link);
		$item5->set_tag_attribute('width', '15%');

		$row->add($blank);
		$row->add($image);
		$row->add($item1);
		$row->add($item2);
		$row->add($item3);
		$row->add($item4);
		$row->add($item5);

		$table->add_row($row);

		$div->add($table);

		return $div;
	}
}
?>
