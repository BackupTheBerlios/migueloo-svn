<?php
/*
      +----------------------------------------------------------------------+
      |forum                                                                 |
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
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package forum
 * @subpackage view
 * @version 1.0.0
 */

class miguel_newTopicForm extends base_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();


                                $TextNombre = $this->_formatElem("FEText", 'nombre', 'nombre', FALSE, 50);
                                $TextNombre->set_attribute('class','ptabla03');
                           $this->add_element($TextNombre);

                                $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("miguel_Enter"));
        $submit->set_attribute('class','ptabla03');
        $submit->set_attribute('accesskey','e');
        $this->add_element($submit);

                                $this->add_hidden_element('status');
                    $this->set_hidden_element_value('status', 'list_topic');

                                $this->add_hidden_element('id_forum');
    }

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guÃ­a al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data()
    {
                                //if ($this->issetViewVariable('id_forum'))
                                //{
               $this->set_hidden_element_value('id_forum', $this->getViewVariable('id_forum'));
              //}
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form()
    {
              //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);
        $table->set_class('ptabla02');
        $table->add_row($this->_showElement('nombre', '8', 'nombre', 'Nuevo Tema: ', 'nombre', 'left' ));

        $this->set_form_tabindex('Aceptar', '10');
        $label = html_label( 'submit' );
        $label->add($this->element_form('Aceptar'));
        $table->add_row(html_td('', 'left',  $label));

        return $table;
    }
}

?>
