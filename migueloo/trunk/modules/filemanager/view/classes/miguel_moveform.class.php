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
      | Authors: Antonio F. Cano Damas  <antonio@igestec.com  >              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Antonio F. Cano Damas  <antonio@igestec.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel filemanager
 * @version 1.0.0
 */
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_moveForm extends miguel_FormContent
{
    function form_init_elements() 
    {
        //Make ListBox Data
        $folderTreeList = $this->getViewVariable( 'folderTree' );
        $listCount = count( $folderTreeList );
        $dataListBox['/'] = 0;
        for ( $i=0; $i < $listCount; $i++ ) {
              $name = "";
              for ( $countSpace = 0; $countSpace < $folderTreeList[$i][1]; $countSpace++ ) {
                  $name .= _HTML_SPACE . _HTML_SPACE;
              }
              $name .= $folderTreeList[$i][0]['folder_name'];
              $dataListBox["$name"] = $folderTreeList[$i][0]['folder_id'];
        }

        //$list_box = $this->_formatElem("FEListBox", agt("Nuevo Destino"), "newDest", FALSE, "200", "100");
        $list_box = new FEListBox( agt("Nuevo Destino"), false, '200px', '100px');
        $list_box->set_list_data( $dataListBox );
        $this->add_element($list_box);

	$submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("Aceptar"));
	$submit->set_attribute('class','p'); 
	$submit->set_attribute('accesskey','e');               
	$this->add_element($submit);

        $folder_id = $this->getViewVariable('folder_id');
        if ( isset($folder_id) ) {
            $this->add_hidden_element("folder_id");	
        }
	$this->add_hidden_element("id"); 
        $this->add_hidden_element("tp");
        $this->add_hidden_element("status");
    }

    function form_init_data() 
    {
        $folder_id = $this->getViewVariable('folder_id');
        if ( isset($folder_id) ) {
            $this->set_hidden_element_value('folder_id', $folder_id );
        }
        $this->set_hidden_element_value("id", $this->getViewVariable('id') );
        $this->set_hidden_element_value("tp", $this->getViewVariable('tp') );
        $this->set_hidden_element_value("status", 'move' );

        return;
    }

    function form() 
    {
        $table = &html_table($this->_width,0,3);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        
        $table->add_row($this->_tableRow(agt("Nuevo Destino")));

        $elem = html_td('ptabla03', '', container($this->element_form("Aceptar")));
	$elem->set_tag_attribute('colspan','9');
        $table->add_row($elem);      

        return $table;
    }
}

?>
