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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
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

class miguel_newPostForm extends base_FormContent
{
    function form_init_elements()
    {
                //Crea una caja de texto llamada nombre y longitud 50
        $elemT = new FEText("nombre", FALSE, 50);
        $elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemT->set_attribute("id","nombre");
                $elemT->set_attribute('class','ptabla03');
        $elemT->set_attribute("accesskey","n");
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemT);

                $elemTA = new FETextArea('opinion', FALSE, 10, 60,"500px", "100px");
        $elemTA->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)
        $elemTA->set_attribute('id','opinion');
        $elemTA->set_attribute('class','ptabla03');
        $elemTA->set_attribute('accesskey','d');
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemTA);

                $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("Enviar"));
        $submit->set_attribute('class','ptabla03');
        $submit->set_attribute('accesskey','e');
        $this->add_element($submit);

                $this->add_hidden_element('status');
            $this->set_hidden_element_value('status', 'list_post');

                $this->add_hidden_element('id_forum');
                $this->add_hidden_element('id_topic');
                $this->add_hidden_element('post_parent');
    }

    function form_init_data()
    {
                $this->set_element_value("nombre", 'Re: '.$this->getViewVariable('topic_name'));
                $this->set_hidden_element_value('id_forum', $this->getViewVariable('id_forum'));
                $this->set_hidden_element_value('id_topic', $this->getViewVariable('id_topic'));
                $this->set_hidden_element_value('post_parent', $this->getViewVariable('post_parent'));
    }

    function form()
    {
              //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);
        $table->set_class('ptabla02');

                $table->add_row($this->_showElement('nombre', '8', 'nombre', agt('Mensaje').':', 'nombre', 'left' ));

        $table->add_row($this->_showElement('opinion', '9', 'opinion', agt('Comentario').':', 'opinion', 'left' ));

        $this->set_form_tabindex('Aceptar', '10');
        $label = html_label( 'submit' );
        $label->add($this->element_form('Aceptar'));
        $table->add_row(html_td('', 'left',  $label));

        return $table;
    }
}
?>
