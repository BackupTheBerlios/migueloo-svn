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
 * Esta clase se encarga de gestionar el formulario para presentar la licencia
 * en la instalación de la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
class miguel_licenceForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //Debug::oneVar(Util::app_Path('install/include/gpl.txt'), __FILE__, __LINE__);
		if(file_exists(Util::app_Path('install/include/gpl.txt'))){
    		$str_content = File::Read(Util::app_Path('install/include/gpl.txt'));
    	}
        $textarea = new FETextArea("Licence", false, 15, 90);
        $textarea->set_value($str_content);
        $this->add_element($textarea);
        	
		$this->add_element($this->_formatElem("base_SubmitButton", "Salir", "quit", agt("Salir")));	
		$this->add_element($this->_formatElem("base_SubmitButton", "Acepto", "submit", agt("Acepto")." >"));
		$this->add_element($this->_formatElem("base_SubmitButton", "Regresar", "back", "< ".agt("Regresar")));
    }



    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
        $ret_val = container();
		
		$table = &html_table($this->_width,0,2);
        $table->set_class("table100 main-info-cell");
        
		$row0 = html_tr("");
		$col0 = html_td("");
		$col0->set_tag_attribute("align", "center"); 
		$col0->set_tag_attribute("colspan", "2"); 
		$col0->add($this->element_form("Licence"));
		$row0->add($col0);
		$table->add($row0);
		
		$row00 = html_tr("");
		$col00 = html_td("");
		$col00->set_tag_attribute("align", "center"); 
		$col00->set_tag_attribute("colspan", "2"); 
		$col00->add(html_a(Util::app_urlPath('install/include/gpl_print.txt'), agt('Versión Imprimible')));
		$row00->add($col00);
		$table->add($row00);
				
		$row = html_tr("");
		$col1 = html_td("");
		$col1->set_tag_attribute("align", "left"); 
		$col1->add($this->element_form("Salir"));
				
		$container = container();
		$container->add($this->element_form("Regresar"));
		$container->add($this->element_form("Acepto"));
		
		$col2 = html_td("");
		$col2->set_tag_attribute("align", "right"); 
		
		$col2->add($container);
		$row->add($col1, $col2);
		$table->add($row);
		$ret_val->add($table);

        return $ret_val;
    }
}

?>
