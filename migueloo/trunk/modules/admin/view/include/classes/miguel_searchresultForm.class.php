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

class miguel_searchresultForm extends FormContent
{
  var $arr_viewvars = null;

  /*
   * Recibe el array de variables de vista, para tener la pantalla en la que estamos y la
   * información proporcionada por el controlador
   *
   */
  function miguel_searchresultForm($arr_commarea)
  {
    $this->FormContent();
    $this->arr_viewvars = $arr_commarea;
  }

  /*
   *
   */
  function form_init_elements()
  {
    $this->add_hidden_element('id');
    $this->set_hidden_element_value('id', $this->getViewVariable('admin_screen'));

    $this->add_hidden_element('form_name_search');
    $this->set_hidden_element_value('form_name_search', 'search_result');

  }

  /*
   * Este metodo asigna valores a los diferentes objetos.
   * Solo se llama una vez, al instanciar esta clase
   */
  function form_init_data()
  {
  }

  /*
   * Comprueba si existen todas las variables de vista necesarias para construir el formulario.
   * Devuelve true si están, y false si no están.
   *
   */
  function isFormComplete()
  {
    $num_of_cols = 0;
    $num_of_rows = 0;

    for ($i=1; $this->getViewVariable('col_'.$i.'_name'); $i++)
    {
      if ($this->getViewVariable('col_'.$i.'_description'))
      {
        $num_of_cols ++;
      }
    }

    for ($i=1; $this->getViewVariable('col_1_value_'.$i); $i++)
    {
      $num_of_rows ++;
    }

    if ($num_of_cols == 0 || $num_of_rows == 0)
    {
      return false;
    }

    for ($j=1; $j<=$num_of_rows; $j++)
    {
      for ($i=1; $i<=$num_of_cols; $i++)
      {
        if (! $this->getViewVariable('col_'.$i.'_value_'.$j))
        {
          return false;
        }
      }
    }

    return true;
  }

  /*
   * Este metodo construye el formulario en sí.
   */
  function form()
  {
    $table = html_table($this->_width,0,1,3);

    //Comprueba que el formulario ha recibido todos los datos necesarios
    if (! $this->isFormComplete())
    {
      return null;
    }

    $table->add('(Entradas '.$this->getViewVariable('min_index').' a '.$this->getViewVariable('max_index').
               ' de '.$this->getViewVariable('total_elements').')');
    $table->add(html_br(2));

    $fila = html_tr();
    for ($i=1; $this->getViewVariable('col_'.$i.'_description'); $i++)
    {
      $fila->add(html_b($this->getViewVariable('col_'.$i.'_description')));
    }

    $table->add_row($fila);

    //Construimos el formulario a partir de las variables de la vista
    for ($j=1; $this->getViewVariable('col_1_value_'.$j); $j++)
    {
      $fila = html_tr();

      for ($i=1; $this->getViewVariable('col_'.$i.'_value_1'); $i++)
      {
        $fila->add($this->getViewVariable('col_'.$i.'_value_'.$j));
      }

      //Dibujamos la acción que se puede realizar en esta fila según la pantalla en la que estemos
      switch ($this->getViewVariable('admin_screen'))
      {
        case 'del_user':
          $username = $this->getViewVariable('col_1_value_'.$j);
          $fila->add(html_td('color1-bg', '', $this->add_hidden_action('Dar de baja', $username)));
          break;

        case 'edit_user_profile':
          $username = $this->getViewVariable('col_1_value_'.$j);
          $fila->add(html_td('color1-bg', '', $this->add_hidden_action('Editar perfil', $username)));
          break;

        default:
          break;
      }

      $table->add_row($fila);
      unset($fila);
    }

    //Dibujamos los botones para avanzar/retroceder en la lista de peticiones
    $fila = html_tr();
    if ($this->getViewVariable('min_index') > 1)
    {
      $elem1 = container($this->add_hidden_action('Anterior', 'prev'));
    }
    else
    {
      $elem1 = container($this->add_action('Anterior', 1));
    }

    if ($this->getViewVariable('max_index') < $this->getViewVariable('total_elements'))
    {
      $elem2 = container($this->add_hidden_action('Siguiente', 'next'));
    }
    else
    {
      $elem2 = container($this->add_action('Siguiente', 1));
    }

    $fila->add(html_td('', 'left', $elem1, $elem2));

    $table->add_row($fila);

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
