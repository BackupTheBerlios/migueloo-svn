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

class miguel_deluserForm extends FormContent
{
  /*
   *
   */
  function form_init_elements()
  {
    $elem1 = new FEText('name', FALSE, 20);
    $elem1->set_style_attribute('align', 'left');
    $this->add_element($elem1);
    $this->set_element_value('name', '');

    $this->add_hidden_element('id');
    $this->set_hidden_element_value('id', 'del_user');
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
    $table = html_table('50%',0,1,3);

    $fila = html_tr();
    $elem = html_td('color1-bg', 'left', $this->element_form('name'), $this->add_action('Dar de baja'));
    $elem->set_id('identification');
    $fila->add($elem);
    $table->add_row($fila);
    unset($fila);
    unset($elem);

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
