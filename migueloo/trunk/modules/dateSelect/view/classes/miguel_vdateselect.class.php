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
include_once (Util::app_Path("common/view/classes/miguel_vpage.class.php"));
require_once (Util::app_Path("andromeda/view/classes/base_calendar.class.php"));

//		;$path_fs = substr($_SERVER['PATH_TRANSLATED'], 0, strrpos($_SERVER['PATH_TRANSLATED'],"/"));
//		$path_fs = 'C:\php5xampp-dev\htdocs';
//		$phphtmllib = $path_fs . "/phphtmllib";
		include_once("$phphtmllib/includes.inc");
		//require_once($phphtmllib."/widgets/Calendar.inc");
		//require_once('./base_calendar.class.php');


		// build the calendar
		class MyCalendar extends Calendar {

			var $_link;

			function MyCalendar($ancho, $hora, $idioma, $link, $param, $addParam)
			{
				$this->Calendar($ancho, $hora, $idioma);
				$this->_link =  $link . $addParam . '&' . $param .'=';
			}

			function GetLink($d, $m, $y) {
				$link=$this->_link;
				$date = $d . '-' . $m . '-' . $y;
				return "$link$date";
			}


			function DayIsEvent($day) {
			// you could query a database here, instead we only return the 15 every month as a day that should be marked different
			$date = getdate($day);
			//if ($date['mday'] == 15) return true;
			return false;
			}
		}



class miguel_VDateSelect extends miguel_VPage
{
    function miguel_VDateSelect($title, $arr_commarea)
    {
       $this->miguel_VPage($title, $arr_commarea);
    }

    function right_block()
    {
		$link = $this->getViewVariable('link');
		$param = $this->getViewVariable('param');
		if ($this->issetViewVariable('fini')) {
			$addParam = '&fini=' . $this->getViewVariable('fini');
		} else if ($this->issetViewVariable('ffin')) {
			$addParam = '&ffin=' . $this->getViewVariable('ffin');
		}
		$calendar = new MyCalendar(150, mktime(), array("spanish","ES"), $link, $param, $addParam);
		return($calendar);
    }
}
?>