<?php
/*
      +----------------------------------------------------------------------+
      |notice/model                                                          |
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

class miguel_MNotice extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MNotice() 
    {
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
    
    function insertSugestion($str_name, $str_subject, $str_content, $now)
    {       
        //Inserta en la tabla todo. Los parámetros de Insert son: tabla, campos y valores
        $ret_val = $this->Insert('notice',
                                 'author, subject, text, time',
                                 "$str_name,$str_subject,$str_content,$now");

        //Comprueba si ha ocurrido algún error al realizar la operación
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	return ($ret_val);
    }
    
    function getNotices()
    {
		 $ret_val = $this->Select('notice', 'author, subject, text, time, notice_id', '');

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
     function getNotice($id_notice)
    {
		 $ret_val = $this->Select('notice', 'author, subject, text, time', "notice_id = $id_notice");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
}    
?>