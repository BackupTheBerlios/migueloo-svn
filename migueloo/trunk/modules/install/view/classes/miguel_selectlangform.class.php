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
 * Esta clase se encarga de gestionar el formulario para selecci�n de idioma
 * en la instalaci�n de la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
class miguel_selectLangForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        $elem1 = new FEListBox("miguel_lang", FALSE, "200px", NULL);
		$elem1->set_list_data($this->getViewVariable('select_lang'));
		//$elem1->set_style_attribute('id', 'install');
		//$elem1->set_value($this->getViewVariable('inst_lang'));
		$this->add_element($elem1);
        	
		$this->add_element($this->_formatElem("base_SubmitButton", "Siguiente", "submit", agt("Siguiente")." >"));
		$this->add_element($this->_formatElem("base_SubmitButton", "Salir", "quit", "< ".agt("Salir")));
    }

    /**
     * Este metodo construye el formulario en s�.
     */
    function form() 
    {
        $ret_val = container();
		
		$table = &html_table($this->_width,0,3);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        
        $row = html_tr("");
		$col1 = html_td("");
		$col1->set_tag_attribute("align", "right"); 
		$col1->add(html_b(agt("Idioma")));
		$col2 = html_td("");
		$col2->set_tag_attribute("align", "left"); 
		$col2->add($this->element_form("miguel_lang"));	
		$row->add($col1, $col2);
		$table->add($row);
		$ret_val->add($table);
		
		$ret_val->add(html_br(2));
		
		$table = &html_table($this->_width,0,0);
        $table->set_class("table100 main-info-cell");

		$row = html_tr("");
		$col1 = html_td("");
		$col1->set_tag_attribute("align", "left"); 
		$col1->add($this->element_form("Salir"));
		$col2 = html_td("");
		$col2->set_tag_attribute("align", "right"); 
		$col2->add($this->element_form("Siguiente"));
		$row->add($col1, $col2);
		$table->add($row);
		$ret_val->add($table);

        return $ret_val;
    }
}

?>
