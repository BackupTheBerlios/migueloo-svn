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
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author Eukene Elorza Bernaola <eelorza@ikusnet.com>
 * @author Mikel Ruiz Diez <mruiz@ikusnet.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */

class miguel_insertionForm extends base_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {

        $this->add_element($this->_formatElem("FEText", "Nombre", "nomlink", FALSE, "70"));
		$this->add_element($this->_formatElem("FEText","Descripción", "descrlink", FALSE, "100") );
        $this->add_element($this->_formatElem("FEText", "URL" , "urllink", FALSE, "50") );
        
        //build a large textarea 
        //$this->add_element( new FETextArea("Politica de privacidad", FALSE, 20, 10,"400px", "100px" ) );
	
	   $this->add_element($this->_formatElem("base_SubmitButton", "Aceptar", "submit", "Aceptar"));
	   $this->add_element($this->_formatElem("base_SubmitButton", "Cancelar", "back", "Cancelar"));
	
        //lets add a hidden form field
        //$this->add_hidden_element("date_uid");
        

    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        //$this->set_element_value("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
	//$this->set_hidden_element_value("date_uid", "2004-01-01");
        
	return;
    }


    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,3);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        
        $table->add_row($this->_tableRow("Nombre"));
        $table->add_row($this->_tableRow("Descripción"));
        $table->add_row($this->_tableRow("URL"));

	    //$table->add_row($this->_tableRow("Politica de privacidad"));
	
	    $row = html_tr();
        $row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
	    $table->add_row($row);
	
        $table->add_row($this->element_form("Cancelar"), $this->element_form("Aceptar"), _HTML_SPACE);

        return $table;
    }
}

?>
