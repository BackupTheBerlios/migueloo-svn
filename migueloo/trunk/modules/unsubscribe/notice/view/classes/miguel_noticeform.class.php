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
      | Authors: Miguel Majuelos Mudarra <www.polar.es> 				             |
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author  Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
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
        $elemT->set_attribute("id","asunto");
        $elemT->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemT);
	
        //Creamos un Area de Texto llamada comentario
        $elemTA = new FETextArea("Comentario", FALSE, 10, 60,"500px", "100px");
        $elemTA->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)        
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
    	  //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);
        $table->add_row($this->_showElement("Asunto", '6', "asunto_de_usuario", 'Asunto', "Asunto", "left" ));     
        $table->add_row($this->_showElement("Comentario", '7', "comentario", 'Texto', "Comentario", "left" ));     
 
        $this->set_form_tabindex("Aceptar", '10'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Aceptar"));
        $table->add_row(html_td("", "left",  $label));
        
        return $table; 
    }
}

?>

