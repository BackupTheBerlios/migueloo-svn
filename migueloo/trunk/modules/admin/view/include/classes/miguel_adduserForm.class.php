<?php
/*
      +----------------------------------------------------------------------+
      | miguel admin                                                         |
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
      | Authors: Manuel R. Freire Santos (Universidad Antonio de Nebrija)    |
      |                       <mfreires@alumnos.nebrija.es>                  |
      |          miguel development team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/

/**
 *
 * @author Manuel R. Freire Santos <mfreires@alumnos.nebrija.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package miguel admin
 * @subpackage view
 * @version 1.0.0
 *
 */

class miguel_adduserForm extends FormContent
{
  function form_init_elements()
  {
    $elem1 = new FEText('name', FALSE, 10);
    $elem1->set_style_attribute('align', 'right');
    $this->add_element($elem1);

    $elem2 = new FEPassword('pass', FALSE, 10, 25);
    $elem2->set_style_attribute('align', 'right');
    $this->add_element($elem2);

    $elem3 = new FEPassword('pass_confirm', FALSE, 10, 25);
    $elem3->set_style_attribute('align', 'right');
    $this->add_element($elem3);

    $this->add_hidden_element('id');
    $this->set_hidden_element_value('id', 'add_user');
  }

  /*
   * Este metodo asigna valores a los diferentes objetos.
   * Solo se llama una vez, al instanciar esta clase
   */
  function form_init_data()
  {
  }

  /*
   * Este metodo construye el formulario en sí.
   */
  function form()
  {
    $table = html_table('25%',0,1,3);

    $elem = html_td('color1-bg', 'center', container(html_b('Nombre del nuevo usuario'), html_br(),
                    $this->element_form('name')));
    $elem->set_id('identification');
    $table->add_row($elem);

    $elem = html_td('color1-bg', 'center', container(html_b('Clave de acceso'), html_br(),
                    $this->element_form('pass')));
    $elem->set_id('identification');
    $table->add_row($elem);

    $elem = html_td('color1-bg', 'center', container(html_b('Confirmar clave de acceso'), html_br(),
                    $this->element_form('pass_confirm')));
    $elem->set_id('identification');
    $table->add_row($elem);

    $table->add_row(html_td('', 'center', $this->add_hidden_action('Procesar', 'add_user')));

    return $table;
  }

  /*
   * This method gets called after the FormElement data has
   * passed the validation.  This enables you to validate the
   * data against some backend mechanism, say a DB.
   *
   */
  function form_backend_validation()
  {
    //Los controles se hacen en el controlador
    return true;
  }

  /*
   * This method is called ONLY after ALL validation has
   * passed.  This is the method that allows you to
   * do something with the data, say insert/update records
   * in the DB.
   */
  function form_action()
  {
    //Evitamos que se escriba nada
    return false;
  }

}
?>
