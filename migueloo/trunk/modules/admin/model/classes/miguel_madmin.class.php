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
 * Define la clase del modelo del modulo admin.
 *
 * @author Manuel R. Freire Santos <mfreires@alumnos.nebrija.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package miguel admin
 * @subpackage model
 * @version 1.0.0
 *
 */

class miguel_MAdmin extends base_Model
{
  var $int_total_elements;

  function miguel_MAdmin()
  {
    $this->base_Model();
    $this->int_total_elements = 0;
  }


  /*
   * Esta funcion obtiene un array con las entradas desde $min_index a $max_index de la tabla indicada.
   * Devuelve un array asociativo de la forma campo->valor, donde se han rellenado los primeros campos (desde
   * cero hasta $max_index-$min_index).
   * Si no se puede obtener, devuelve null.
   *
   */
  function search($table, $text, $field_to_search, $fields_to_get, $sort_by, $bol_reverse, $min_index, $max_index)
  {
    if ($text != null)
    {
      $arr_tmp = $this->SelectOrder($table, $fields_to_get, $sort_by, "$field_to_search LIKE $text", $bol_reverse);
      if ($arr_tmp[0]["$table.$field_to_search"] == null)
      {
        return null;
      }
    }
    else
    {
      $arr_tmp = $this->SelectOrder($table, $fields_to_get, $sort_by, '', $bol_reverse);
    }

    if ($this->hasError())
    {
      return null;
    }

    $this->int_total_elements = count($arr_tmp);

    for ($i=$min_index-1; $i<$max_index; $i++)
    {
      $arr_return[] = $arr_tmp[$i];
    }

    return $arr_return;
  }


  /*
   * Devuelve un valor booleano: true -> el usuario existe; false -> no existe
   *
   */
  function doesUserExist($user_alias)
  {
    $arr_tmp = $this->Select('user', 'USER_ALIAS', "USER_ALIAS = $user_alias");

    if (! $this->hasError())
    {
      if ($arr_tmp[0]['user.USER_ALIAS'] != null)
      {
        return true;
      }
    }

    return false;
  }

  /*
   * Esta función da de alta un usuario
   *
   */
  //NOTA: No entiendo por qué no funciona esta función
  function addUser($user_alias, $password)
  {
    if ($user_alias != null && $password != null)
    {
      if (is_string($user_alias) && is_string($password))
      {
        if (! $this->doesUserExist($user_alias))
        {
          $this->Insert('user',
                        'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                        "$user_alias, default, es_ES, $password, '1', '', 0, 0, 0, 0, 0, 0, ''");

          if (! $this->hasError())
          {
            return true;
          }
        }
      }
    }

    return false;
  }

  /*
   * Función copiada de _insertUser (módulo 'auth')
   *
   *//*
  function addUser($user, $theme, $lang, $passwd, $person, $profile, $treatment, $email)
  {
    $ret_val = $this->Insert('user',
                             'user_alias, theme, language, user_password, active, activate_hash, institution_id, forum_type_bb, main_page_id, person_id, id_profile, treatment_id, email',
                             "$user, $theme, $lang, $passwd, '1', '', 0, 0, 0, $person, $profile, $treatment, $email");

    if ($this->hasError()) {
      $ret_val = null;
    }

    return ($ret_val);
  }*/

  /*
   * Esta función da de baja un usuario.
   *
   * Devuelve: true si se consiguió, false si no.
   */
  function delUser($str_user_alias)
  {
    if ($str_user_alias != null)
    {
      if ($this->doesUserExist($str_user_alias))
      {
        $this->Delete('user', "USER_ALIAS = $str_user_alias");

        if (! $this->hasError())
        {
          return true;
        }
      }
    }

    return false;
  }


  function getTotalElements()
  {
    return $this->int_total_elements;
  }

}

