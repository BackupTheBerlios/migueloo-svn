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

class miguel_searchForm extends FormContent
{
  var $arr_viewvars = null;

  /*
   * Recibe el array de variables de vista, para tener la pantalla en la que estamos y la
   * información proporcionada por el controlador
   *
   */
  function miguel_searchForm($arr_commarea)
  {
    $this->FormContent();
    $this->arr_viewvars = $arr_commarea;
  }

  /*
   *
   */
  function form_init_elements()
  {
    $elem = new FEText('search', FALSE, 20, 20);
    $elem->set_style_attribute('align', 'right');
    $this->add_element($elem);

    $this->add_element(new FEListBox('field', FALSE, '180px', NULL, array('Nombre de usuario'=>'USER_ALIAS',
                                     'Password (sólo para pruebas)'=>'USER_PASSWORD')));

    $this->add_element(new FEListBox('sort_by', FALSE, '180px', NULL, array('Nombre de usuario'=>'USER_ALIAS',
                                     'Password (sólo para pruebas)'=>'USER_PASSWORD')));

    $this->add_element(new FERadioGroup('reverse', array('Ascendente'=>0, 'Descendente'=>1)));

    $this->add_hidden_element('id');
    $this->set_hidden_element_value('id', $this->getViewVariable('admin_screen'));

    $this->add_hidden_element('form_name_search');
    $this->set_hidden_element_value('form_name_search', 'search');

    $this->set_element_value('reverse', 'Ascendente');
  }

  /*
   * Este metodo asigna valores a los diferentes objetos.
   * Solo se llama una vez, al instanciar esta clase
   */
  function form_init_data()
  {
    $this->set_element_value('field', 'Nombre de usuario');
    $this->set_element_value('sort_by', 'Nombre de usuario');
  }

  /*
   * Este metodo construye el formulario en sí.
   */
  function form()
  {
    $table = html_table($this->_width,0,1,3);

    //Título: (primera fila de la tabla principal
    $table->add_row(html_b('Buscar:'));

    //Campo para introducir la búsqueda: (segunda fila de la tabla principal)
    $fila = html_tr();
    $elem = html_td('color1-bg', 'left', $this->element_form('search'), $this->add_hidden_action('Buscar', 'search'));
    $elem->set_id('identification');
    $fila->add($elem);
    $table->add_row($fila);
    unset($fila);

    //"Opciones de búsqueda": (tercera fila de la tabla principal)
    $fila = html_tr();
    $fila->set_class('colorMedium-bg');

    //Título de "Opciones de búsqueda": (primera columna)
    $elem = html_td('', 'left', 'Opciones de búsqueda');
    $elem->set_id('identification');
    $fila->add($elem);

    //Opciones de búsqueda: (tabla en la segunda columna)
    $search_opt = html_table($this->_width, 0, 1, 3);
    $fila2 = html_tr();
    $elem = html_td('color1-bg', 'left', 'Campo a buscar:');
    $elem->set_id('identification');
    $fila2->add($elem);
    $elem = html_td('color1-bg', 'left', $this->element_form('field'));
    $elem->set_id('identification');
    $fila2->add($elem);
    $fila2->add(html_td('color1-bg', 'left', ''));
    $search_opt->add_row($fila2);
    unset($fila2);

    $fila2 = html_tr();
    $elem = html_td('color2-bg', 'left', 'Ordenar por:');
    $elem->set_id('identification');
    $fila2->add($elem);
    $elem = html_td('color2-bg', 'left', $this->element_form('sort_by'));
    $elem->set_id('identification');
    $fila2->add($elem);
    $elem = html_td('color2-bg', 'left', $this->element_form('reverse'));
    $elem->set_id('identification');
    $fila2->add($elem);
    $search_opt->add_row($fila2);
    unset($fila2);

    $fila->add($search_opt);
    $table->add_row($fila);
    unset($fila);

    //Nota final
    $elem = html_td('color1-bg', 'left', 'Nota: el símbolo % es un carácter comodín.');
    $elem->set_id('identification');
    $table->add_row($elem);

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

    /*
   * Recupera el valor de una variable. Funcion adaptada de la clase base_layoutpage.
   * He copiado las variables de la vista para poder construir el formulario, ya que obtiene
   * los datos de dichas variables.
   * @param string $str_name Nombre de la variable
   * @return mixto Valor de la variable
   */
  function getViewVariable($str_name)
  {
    if($str_name != '')
    {
      return $this->arr_viewvars[$str_name];
    }
    else
    {
      return null;
    }
  }

}
?>
