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
 
class miguel_todoForm extends base_FormContent 
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
        $elemT = new FEText("Nombre", FALSE, 50);
        $elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemT->set_attribute("id","nombre");
        $elemT->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemT);

        //Crea una caja de texto llamada Email y longitud 60
        $elemP = new FEText("Email", FALSE, 60);
        $elemP->set_style_attribute('align', 'right');
        //Le asignamos el id email y la tecla de acceso m (ctrl+m)        
        $elemP->set_attribute("id","email");
        $elemP->set_attribute("accesskey","l");
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemP);
		
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
        $this->add_hidden_element("id");

        //Añade un boton con la acción submit
        $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("miguel_Enter"));
        $submit->set_attribute("id","submit"); 
        $submit->set_attribute("accesskey","e");               
        $this->add_element($submit);        
    }

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guía al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        $this->set_hidden_element_value("id", "todo");
        $this->set_element_value("Email", agt("miguel_todoEmailSuggestion"));
        $this->set_element_value("Nombre", agt("miguel_todoNameSuggestion"));
        $this->set_element_value("Comentario", agt("miguel_todoCommentSuggestion"));                
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form() 
    {
    	  //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);

        //Indica el indice de tabulado del campo. Será necesario para navegadores donde no se use el ratón
        $this->set_form_tabindex("Nombre", '7');
        //Creamos una etiqueta(<label>) que lleva asociados el texto de la etiqueta y el campo
        $label = html_label( "nombre" );
        //Construye el contenido de la etiqueta: texto y campo
        $label->add(container(agt("miguel_TodoName"), html_br(), $this->element_form("Nombre")));
        //Crea el contenedor celda que se va a incluir en la fila de la tabla. El contenido es $label
        $elem = html_td("", "", $label);
        //Añade en la tabla la fila con el campo        
        $table->add_row($elem);

        $this->set_form_tabindex("Email", '8');
        $label = html_label( "email" );        
        $label->add(container(agt("miguel_TodoEmail"), html_br(), $this->element_form("Email")));                
        $elem = html_td("", "", $label);
        $table->add_row($elem);

        
        $this->set_form_tabindex("Comentario", '9');
        $label = html_label( "comentario" );        
        $label->add(container(agt("miguel_TodoComment"), html_br(), $this->element_form("Comentario")));   
        $elem = html_td("", "", $label);
        $table->add_row($elem);
 
        $this->set_form_tabindex("Aceptar", '10'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Aceptar"));
        $table->add_row(html_td("", "left",  $label));
        
        return $table;
    }
}

?>