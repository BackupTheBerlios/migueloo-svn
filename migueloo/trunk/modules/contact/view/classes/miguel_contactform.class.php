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

class miguel_contactForm extends miguel_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        $nombre= $this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "20");
		$nombre->set_attribute('class','ptabla03'); 
		$apellido = $this->_formatElem("FEText","Apellido", "prenom_form", FALSE, "40");
		$apellido->set_attribute('class','ptabla03'); 
		$arrUsers = $this->getViewVariable('arrUsers');
		$nick = $this->_formatElem("FEListBox", "Nombre de usuario", "uname", FALSE, "100px", NULL, $arrUsers);
		//$nick->set_attribute('class','');
        //$nick = $this->_formatElem("FEText", "Nombre de usuario" , "uname", FALSE, "10");
		$nick->set_attribute('class','ptabla03'); 
		$email = $this->_formatElem("FEText" ,"Correo electrónico", "email", FALSE);
		$email->set_attribute('class','ptabla03'); 
        $jabber = $this->_formatElem("FEText" ,"Cuenta Jabber", "jabber", FALSE);
		$jabber->set_attribute('class','ptabla03'); 
		//Creamos un Area de Texto llamada comentario
        $elemTA = new FETextArea("Comentario", FALSE, 10, 60,"500px", "100px");
        $elemTA->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)        
        $elemTA->set_attribute("id","comentario");
        $elemTA->set_attribute("accesskey","d");
		$elemTA->set_attribute('class','ptabla03'); 
        //AÃ±ade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($nombre);
		$this->add_element($apellido);
		$this->add_element($nick);
		$this->add_element($email);
		$this->add_element($jabber);
		$this->add_element($elemTA);

        
        //build a large textarea 
        //$this->add_element( new FETextArea("Politica de privacidad", FALSE, 20, 10,"400px", "100px" ) );
	
	   $accept = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", "Aceptar");
	   $accept->set_attribute('class',''); 
	   //$cancel = $this->_formatElem("base_SubmitButton", "Cancelar", "back", "Cancelar");
	   //$cancel->set_attribute('class',''); 
	   $this->add_element($accept);
	   //$this->add_element($cancel);
	
        //lets add a hidden form field
        $this->add_hidden_element('option');
        

    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
     	$this->set_hidden_element_value('option', 'newdata');
        
	return;
    }


    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,3);
        $table->set_class('ptabla02');
        //$table->set_style("border: 1px solid");
        
        $table->add_row($this->_tableRow("Nombre"));
        $table->add_row($this->_tableRow("Apellido"));

		$profile = $this->getViewVariable('profile');
		if (isset($profile))
		{
	        $table->add_row($this->_tableRow("Nombre de usuario"));
		}
        $table->add_row($this->_tableRow("Correo electrónico"));
		$table->add_row($this->_tableRow("Cuenta Jabber"));
	    $table->add_row($this->_tableRow("Comentario"));
        
        $table->add_row(/*$this->element_form("Cancelar"),*/ $this->element_form("Aceptar"), _HTML_SPACE);

        return $table;
    }
}

?>
