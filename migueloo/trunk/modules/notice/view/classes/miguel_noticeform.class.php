<?php
/*
      +----------------------------------------------------------------------+
      |notice/view form                                                      |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
 
class miguel_noticeForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();

        //Crea una caja de texto llamada nombre y longitud 50
        $elemT = new FEText("Asunto", FALSE, 50);
        //$elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemT->set_attribute('class','ptabla03'); 
        $elemT->set_attribute("id","asunto");
        $elemT->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemT);
	
        //Creamos un Area de Texto llamada comentario
        $elemTA = new FETextArea("Comentario", FALSE, 10, 60,"500px", "100px");
        $elemTA->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)   
				$elemTA->set_attribute('class','ptabla03');      
        $elemTA->set_attribute("id","comentario");
        $elemTA->set_attribute("accesskey","d");
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemTA);

        //Añade un campo oculto llamado id. En ocasiones este campo se utiliza para indicar ciertas operaciones.
        //OJO!! es un punto sensible porque el usuario podría cambiar su valor de forma inexperada para el código.
//        $this->add_hidden_element("id");

        //Añade un boton con la acción submit
        $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("miguel_Enter"));
        //$submit->set_attribute('id',''); 
        $submit->set_attribute('class','ptabla03'); 
        $submit->set_attribute('accesskey','e');               
        $this->add_element($submit);    
				
				$this->add_hidden_element('status');
    		$this->set_hidden_element_value('status', 'new');
    }

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guía al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
	       //$this->set_element_value("Asunto", agt("miguel_noticeSubjectSuggestion"));
        //$this->set_element_value("Comentario", agt("miguel_noticeCommentSuggestion")); 
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form() 
    {
    	  //Crear la tabla
        $table = &html_table($this->_width,0,2,2);

				//A�adir el texto de asunto
        $row = $this->_showElement("Asunto", '6', "asunto_de_usuario", 'Asunto', "Asunto", "left" );
        $row->set_class('ptabla03');
        $table->add_row($row);     
        
        //A�adir el texto de comentario
        $row = $this->_showElement("Comentario", '7', "comentario", 'Texto', "Comentario", "left" );
        $row->set_class('ptabla03');
        $table->add_row($row);     
 
        $this->set_form_tabindex("Aceptar", '10'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Aceptar"));
        $table->add_row(html_td("", "left",  $label));
        
        return $table; 
    }
}

?>

