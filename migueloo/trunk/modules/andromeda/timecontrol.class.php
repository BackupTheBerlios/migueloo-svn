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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class timeControl 
{ 
	var $arr_time = array(); 
	
	function timeControl()
	{ 
		 $this->getInterval(); 
    } 
	
    function getInterval()
	{ 
		$micro_time = explode(' ', microtime()); 
		$this->arr_time[] = $micro_time[1] + $micro_time[0]; 
    } 

    function seeResults()
	{
		$ret_val = array();
		$int_total = count($this->arr_time);
		
		for($i=1; $i < $int_total; $i++){
			$int_time = $this->arr_time[$i] - $this->arr_time[$i - 1];
			$ret_val[] = 'Intervalo '.$i.' en '.substr($int_time,0,5)." segundos.\n";
		}
		
		$total_time = ($this->arr_time[$int_total - 1] - $this->arr_time[0]);
        $ret_val[] = "\nPágina generada en ".substr($total_time,0,5)." segundos. \n";
		return $ret_val;
    } 
} 

?> 
