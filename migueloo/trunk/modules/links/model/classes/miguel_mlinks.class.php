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
      | Authors: Eukene Elorza Bernaola <eelorza@ikusnet.com>                |
      |          Mikel Ruiz Diez <mruiz@ikusnet.com>                         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 
 * @author Eukene Elorza Bernaola <eelorza@ikusnet.com>
 * @author Mikel Ruiz Diez <mruiz@ikusnet.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class miguel_mLinks extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_mLinks() 
    {	
		$this->base_Model();
    }
    
    function getLinks($course_id="0")
    {

        $ret_val = $this->Select( "link", "link_id, link_name, link_description, link_url", "course_id = $course_id"); 

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
    
    function insertLinks($course_id="0", $link_name='', $link_description='', $link_url)
    {

        $ret_val = $this->Insert( "link", "course_id, link_name, link_description, link_url",  $course_id.' , '.$link_name.' , '.$link_description.' , '.$link_url); 

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	return ($ret_val);
    }
	
    function modifyLinks($course_id="0", $link_name='', $link_description='', $link_id, $link_url)
    {

        $ret_val = $this->Update( "link", "course_id, link_name, link_description, link_url",  $course_id.' , '.$link_name.' , '.$link_description.' , '.$link_url, 'link_id = '.$link_id); 

    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	return ($ret_val);
    }


    function deleteLinks($link_id)
    {
        
        $ret_val = $this->Delete('link',
                                 "link_id = ".$link_id);
        if ($this->hasError()) {
            $ret_val = null;
        }
        return $ret_val;
    }
	
   function invalidLink($link_id)
    {
        $ret_val = $this->Update( "link", "link_valid", '1', 'link_id = '.$link_id); 

        if ($this->hasError()) {
            $ret_val = null;
        }
        return $ret_val;
    }

}
?>
