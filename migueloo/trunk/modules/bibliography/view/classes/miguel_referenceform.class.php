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
 * @package miguel main
 * @version 1.0.0
 */

class miguel_referenceForm extends base_FormContent
{
    function form_init_elements()
    {
                $elemTA = new FEText('ptabla01', FALSE, '100%', 100);
                $elemTA->set_attribute('class', '');
                //$elemTA->set_attribute('wrap', 'physical');
                //Le asignamos el id email y la tecla de acceso c (ctrl+c)
                //$elemTA->set_attribute("id","comentario");
                //$elemTA->set_attribute("accesskey","d");
                //AÃ±ade en el contenedor formulario el elemento creado e inicializado
                $this->add_element($elemTA);

                $elemTB = new FEText('enlace', FALSE, '100%', 100);
                $elemTB->set_attribute('class', '');
                //$elemTB->set_attribute('wrap', 'physical');
                //Le asignamos el id email y la tecla de acceso c (ctrl+c)
                //$elemTB->set_attribute("id","comentario");
                //$elemTB->set_attribute("accesskey","d");
                //AÃ±ade en el contenedor formulario el elemento creado e inicializado
                $this->add_element($elemTB);

                $submit = $this->_formatElem("base_SubmitButton", "aceptar", "submit", agt("Añadir enlace"));
                $submit->set_attribute('class','p');
                $submit->set_attribute("id","submit");
                $submit->set_attribute("accesskey","r");
                $this->add_element($submit);
    }

    function form_init_data()
    {
                $this->set_element_value('ptabla01','');
                $this->set_element_value('enlace','');
    }

    function form()
    {
                $table = &html_table($this->_width,0,2,2, 'center');

                $row = html_tr();

                $label = html_label( "título" );
        $label->add(container(agt("Nombre del enlace"), _HTML_SPACE, $this->element_form('ptabla01')));
        $elem1 = html_td('ptabla02', '', $label);
        $row->add($elem1);

                $label = html_label( "enlace" );
        $label->add(container(agt("Dirección Web"), _HTML_SPACE, $this->element_form("enlace")));
        $elem2 = html_td('ptabla02', '', $label);
        $row->add($elem2);
                  $table->add_row($row);

                 $row2 = html_tr();
                $elem3 = html_td('ptabla02', '',$this->element_form("aceptar"));
                $elem3->set_tag_attribute('align', 'center');
                $elem3->set_tag_attribute('colspan', '2');
                $row2->add($elem3);

                $table->add_row($row2);

        return $table;
    }
}
?>
