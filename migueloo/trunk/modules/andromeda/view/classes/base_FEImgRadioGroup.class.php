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
class FEImgRadioGroup extends FormElement 
{
    var $_data_list = array();
	var $_img_list = array();
    
	function FEImgRadioGroup($label, $data_list=array(), $img_list=array()) 
	{
        $this->FormElement($label, true);
        foreach ($data_list as $name=>$value) {
            $this->_data_list[] = array($name=>$value);
        }
		
		$this->_img_list = $img_list;
    }

    function get_value_text() 
	{
        $value = $this->get_value();
        foreach( $this->_data_list as $arr) {
            $flip = array_flip($arr);
            if (isset($flip[$value])) {
                return $flip[$value];
            }
        }
        return NULL;
    }

    function get_element() 
	{
        $container = html_table('100%',0,0,0);
		
		$row = html_tr();

        $count = count( $this->_data_list );
        for ($x=0;$x<=$count-1;$x++) {
			list($name, $value) = each($this->_data_list[$x]);
			$elem = container();
			
			$elem->add( $this->_get_index_element($x), html_br(), html_img($this->_img_list[$x]));
			
			$col = html_td('', '', $elem);
			$col->set_tag_attribute('align', 'center');
			$row->add($col);
		}
		
		$container->add_row($row);
		
        return $container;
    }

    function _get_index_element($index) {
        $attributes = $this->_build_element_attributes();
        $attributes["type"] = "radio";

        //list($name, $value) = each($this->_data_list[$index]);
		
        $attributes["value"] = $index + 1;

        if (($value == $this->get_value()))
            $attributes[] = "checked";

        $tag = new INPUTtag($attributes);

        //now build the href so we can click on it.
        //$attr["class"] ="form_link";
        //$attr["href"] = "javascript:void(0)";
        //$js = "javascript: function check(item){item.click();} ".
        //      "check(".$this->get_element_name().".item($index));";
        //$attr["onclick"] = $js;

        $href = new Atag($attr, $value);

        $c = container($tag, $href);
        $c->set_collapse();
        return $c;
    }
}
?>