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

class miguel_inscriptionForm extends miguel_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        $this->add_element($this->_formatElem("FEListBox", "Tratamiento", "treatment", FALSE, "200px", NULL, $this->getViewVariable('treatment')) );
        $this->add_element($this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "20"));
		$this->add_element($this->_formatElem("FEText","Apellido", "prenom_form", FALSE, "40") );
        $this->add_element($this->_formatElem("FEText", "Nombre de usuario" , "uname", FALSE, "10") );
        $this->add_element($this->_formatElem("FEPassword", "Clave de acceso", "passwd", FALSE, "15", "25"));
        $this->add_element($this->_formatElem("FEPassword", "Clave de acceso (confirmación)", "passwd2", FALSE, "15", "25"));
        $this->add_element($this->_formatElem("FEText" ,"Correo electrónico", "email", FALSE));
        $this->add_element($this->_formatElem("FEListBox", "Tema", "theme", FALSE, "200px", NULL, $this->getViewVariable('themes')) );
        $this->add_element($this->_formatElem("FEListBox", "Perfil de usuario", "profile", FALSE, "200px", NULL, $this->getViewVariable('profiles')) );
        
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
        
        $table->add_row($this->_tableRow("Tratamiento"));
        $table->add_row($this->_tableRow("Nombre"));
        $table->add_row($this->_tableRow("Apellido"));
        $table->add_row($this->_tableRow("Nombre de usuario"));
        $table->add_row($this->_tableRow("Clave de acceso"));
        $table->add_row($this->_tableRow("Clave de acceso (confirmación)"));
        $table->add_row($this->_tableRow("Correo electrónico"));
	    $table->add_row($this->_tableRow("Tema"));
        $table->add_row($this->_tableRow("Perfil de usuario"));
	    //$table->add_row($this->_tableRow("Politica de privacidad"));
	
	    $row = html_tr();
        $row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
	    $table->add_row($row);
	
        $table->add_row($this->element_form("Cancelar"), $this->element_form("Aceptar"), _HTML_SPACE);

        return $table;
    }
}

?>
