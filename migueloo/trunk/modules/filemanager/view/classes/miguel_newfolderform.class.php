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

class miguel_newFolderForm extends miguel_FormContent
{
    function form_init_elements() 
    {
        $elemTitulo = $this->_formatElem("FEText", "Nombre de la carpeta", "folderName", FALSE, "100");
		$elemTitulo->set_attribute('class','ptabla03'); 
		$this->add_element($elemTitulo);
		
		$submit = $this->_formatElem("base_SubmitButton", "Crear", "submit", agt("Crear"));
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
		
		$row = html_tr('ptabla03');
        $row->add(html_td('ptabla02', '', $this->element_label('Nombre de la carpeta')), 
					html_td('ptabla03', '', $this->element_form('Nombre de la carpeta')), 
					html_td('', '', $this->element_form("Crear")));
        
        $table->add_row($row);
         
        //$table->add_row($this->element_form("Crear"), _HTML_SPACE);
		
        return $table;
    }
}

?>
