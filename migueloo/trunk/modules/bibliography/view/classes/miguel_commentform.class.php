<?php
/*
      +----------------------------------------------------------------------+
      | bibliography                                                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 * @package miguel bibliography
 * @version 1.0.0
 */

class miguel_commentForm extends base_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        //Creamos un Area de Texto llamada comentario
        $elemTA = new FETextArea("Comentario", FALSE, 10, 60,"100%", "100px");
                $elemTA->set_attribute('class', '');
        //$elemTA->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)
        //$elemTA->set_attribute("id","comentario");
        //$elemTA->set_attribute("accesskey","d");
        //AÃ±ade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemTA);

                $elem = new FEImgRadioGroup("valoracion",
                                        array('1' => 1,
                                              '2' => 2,
                                                  '3' => 3,
                                                  '4' => 4,
                                                  '5' => 5),
                    array(Theme::getThemeImagePath('valoracion1.gif'),
                                              Theme::getThemeImagePath('valoracion2.gif'),
                                                  Theme::getThemeImagePath('valoracion3.gif'),
                                                  Theme::getThemeImagePath('valoracion4.gif'),
                                                  Theme::getThemeImagePath('valoracion5.gif')));
                //$elem->set_attribute('class','ptabla03');
                $this->add_element($elem);

                $submit = $this->_formatElem("base_SubmitButton", "aceptar", "submit", agt('Añadir Comentario'));
                $submit->set_attribute('class','p');
                $submit->set_attribute("id","submit");
                $submit->set_attribute("accesskey","r");
                $this->add_element($submit);
    }

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guÃ­a al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data()
    {
        $this->set_element_value('valoracion', 3);
        $this->set_element_value("Comentario", '');
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form()
    {
                $table = &html_table($this->_width,0,2,2, 'center');

                $label = html_label( "comentario" );
        $label->add(container(agt('Añadir comentario'), html_br(), $this->element_form("Comentario")));
        $elem = html_td('ptabla03', '', $label);
        $table->add_row($elem);

                $item1 = html_td('', '',$this->element_form("valoracion"));
                $item1->set_tag_attribute('align', 'center');

                $item2 = html_td('', '',$this->element_form("aceptar"));
                $item2->set_tag_attribute('align', 'center');

                $table->add_row($item1);
        $table->add_row($item2);

        return $table;



    }
}

?>
