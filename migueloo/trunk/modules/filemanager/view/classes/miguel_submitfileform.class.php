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
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_submitFileForm extends miguel_FormContent
{
    function form_init_elements() 
    {
        $this->add_element($this->_formatElem("FEFile", agt("Nombre del archivo"), "fileName", FALSE, "100"));

        $elemCB1 = new FECheckBox('fileZip', agt('El archivo está comprimido') );
        $elemCB1->set_style_attribute('align', 'left');
        $elemCB1->set_attribute('class','ptabla03');
        $elemCB1->set_attribute("accesskey","o");
        $this->add_element( $elemCB1 );
	
		$submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("Aceptar"));
		$submit->set_attribute('class','p'); 
		$submit->set_attribute('accesskey','e');               
		$this->add_element($submit);
		
		$this->add_hidden_element("folder_id"); 
    }

    function form_init_data() 
    {
        $this->set_hidden_element_value("folder_id", $this->getViewVariable('folder_id') );
		
		return;
    }

    function form() 
    {
        $table = &html_table($this->_width,0,3);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        
        $table->add_row($this->_tableRow("Nombre del archivo"));

        $this->set_form_tabindex("fileZip", '15');
        $elem = html_td('ptabla03', '', container($this->element_form("fileZip"), _HTML_SPACE, $this->element_form("Aceptar")));
		$elem->set_tag_attribute('colspan','9');
        $table->add_row($elem);      

        return $table;
    }
}

?>
