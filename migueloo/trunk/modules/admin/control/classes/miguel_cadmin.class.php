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
 * Define la clase de control del modulo admin.
 *
 * @author Manuel R. Freire Santos <mfreires@alumnos.nebrija.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package miguel admin
 * @subpackage control
 * @version 1.0.0
 *
 */

include_once (Util::app_Path('common/control/classes/miguel_userinfo.class.php'));


//Fijamos el numero maximo de peticiones en pantalla
define('max_shown_elements', 5);

class miguel_CAdmin extends miguel_Controller
{
  function miguel_CAdmin()
  {
    $this->miguel_Controller();
    $this->setModuleName('admin');
    $this->setModelClass('miguel_MAdmin');
    $this->setViewClass('miguel_VAdmin');
    $this->setCacheFlag(false);
  }

  /*
   * Logica de negocio. Comprueba que el usuario es administrador, y si lo es genera el contenido
   * según la variable admin_screen.
   *
   */
  //DUDA: ¿Es un error tirar tanto del switch en vez de varios if?
  function processPetition()
  {
    $this->setMessage('Administración');

    $user_id = $this->getSessionElement('userinfo', 'user_id');

    if (isset($user_id) && $user_id != '')  //Comprueba si el usuario está loggeado
    {
      $user = $this->getSessionElement('userinfo', 'user_alias');

      if (miguel_UserInfo::isAdmin(&$this->obj_data, $user)) //Comprueba si el usuario es administrador
      {
        $this->addNavElement(Util::format_URLPath('admin/index.php'), 'Administración');

        if ($this->issetViewVariable('admin_screen')) //Obtenemos la pantalla en la que estamos (se pasa como GET)
        {
          $str_screen = $this->getViewVariable('admin_screen');
        }
        else //Si se ha hecho submit en un formulario, la pantalla se pasa como variable oculta 'id'
        {
          if ($this->issetViewVariable('id'))
          {
            $str_screen = $this->getViewVariable('id');
          }
        }

        switch ($str_screen)
        {
          case 'users':  //Procesar pantalla "Gestión de usuarios"
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->setMessage('Gestión de usuarios');
            break;

          case 'courses':  //Procesar pantalla "Gestión de cursos"
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=courses'),
                                 'Gestión de cursos');
            $this->setMessage('Gestión de cursos');
            break;

          case 'petitions':  //Procesar pantalla "Procesar peticiones"
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=petitions'),
                                 'Procesar peticiones');
            $this->setMessage('Procesar las peticiones al administrador');
            break;

          case 'sysconfig':  //Procesar pantalla "Configuración del sistema"
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=sysconfig'),
                                 'Configuración del sistema');
            $this->setMessage('Configuración del sistema');
            break;

          case 'add_user':  //Procesar pantalla "Dar de alta usuarios" (en "Gestión de usuarios")
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=add_user'),
                                 'Altas');
            $this->setMessage('Dar de alta usuarios');
            $this->_processAddUser();
            break;

          case 'del_user':  //Procesar pantalla "Dar de baja usuarios" (en "Gestión de usuarios")
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=del_user'),
                                 'Bajas');
            $this->setMessage('Dar de baja usuarios');
            $this->_processDelUser();
            break;

          case 'edit_user_profile':  //Procesar pantalla "Editar perfil de un usuario" (en "Gestión de usuarios")
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile'),
                                 'Editar');
            $this->setMessage('Editar perfil de un usuario');
            $this->_processEditUserProfile();
            break;

          case 'add_user_list':  //Procesar pantalla "Importar lista de usuarios" (en "Gestión de usuarios")
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=add_user_list'),
                                 'Importar lista de usuarios');
            $this->setMessage('Importar una lista de usuarios');
            $this->_processAddUserList();
            break;

          case 'user_list':  //Procesar pantalla "Lista de usuarios" (en "Gestión de usuarios")
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
                                 'Gestión de usuarios');
            $this->addNavElement(Util::format_URLPath('admin/index.php', 'admin_screen=user_list'),
                                 'Lista de usuarios');
            $this->setMessage('Lista de usuarios');
            $this->_processUserList();
            break;

          //case 'add_course':  //Procesar pantalla "Crear un curso" (en "Gestión de cursos")
          //  $this->setMessage('Crear un curso');
          //  $this->_processAddCourse();
          //  break;

          //case 'course_list':  //Procesar pantalla "Lista de cursos" (en "Gestión de cursos")
          //  $this->setMessage('Lista de cursos');
          //  $this->_processCourseList();
          //  break;

          //case 'del_course':  //Procesar pantalla "Borrar un curso" (en "Gestión de cursos")
          //  $this->setMessage('Borrar curso');
          //  $this->_processDelCourse();
          //  break;

          //case 'edit_course':  //Procesar pantalla "Editar un curso" (en "Gestión de cursos")
          //  $this->setMessage('Editar curso');
          //  $this->_processEditCourse();
          //  break;

          default:
            break;
        }

        $this->setSessionElement('admin_screen', $str_screen);
        $this->setViewVariable('admin_screen', $str_screen);
      }
      else //Si el usuario loggeado no es administrador
      {
        $this->setViewVariable('admin_error', 'no_auth');
        $this->setViewClass('miguel_VAdmin');
        return false;
      }
    }
    else //Si el usuario no está loggeado
    {
      $this->setViewVariable('admin_error', 'no_logged');
      $this->setViewClass('miguel_VAdmin');
      return false;
    }
  }

  function _search($str_table, $str_ddbb_fields, $arr_field_names, $arr_field_descriptions)
  {
    if ($this->issetViewVariable('search'))
    {
      $text = $this->getViewVariable('search');
      $field_to_search = $this->getViewVariable('field');
    }
    else
    {
      $text = $this->getSessionElement('search_text');
      $field_to_search = $this->getSessionElement('search_field');
    }

    $this->setSessionElement('search_text', $text);
    $this->setSessionElement('search_field', $field_to_search);

    switch ($this->getViewVariable('_form_action'))
    {
      case 'next':
        $int_min_index = $this->getSessionElement('min_index') + max_shown_elements;
        $int_max_index = $int_min_index + max_shown_elements - 1;
        break;

      case 'prev':
        $int_min_index = $this->getSessionElement('min_index') - max_shown_elements;
        if ($int_min_index < 1)
        {
          $int_min_index = 1;
        }
        $int_max_index = $int_min_index + max_shown_elements - 1;
        break;

      case 'search': //Si acabamos de hacer clic en 'Buscar', guardamos como variables de sesión $sort_by y $bol_reverse
        $this->setSessionElement('sort_by', $this->getViewVariable('sort_by'));
        $this->setSessionElement('bol_reverse', $this->getViewVariable('reverse'));
      default:
        $int_min_index = 1;
        $int_max_index = $int_min_index + max_shown_elements - 1;
        break;
    }

    //Obtenemos las entradas:
    $arr_tmp = $this->obj_data->search($str_table, $text, $field_to_search, $str_ddbb_fields,
                                       $this->getSessionElement('sort_by'), $this->getSessionElement('bol_reverse'),
                                       $int_min_index, $int_max_index);

    if (is_array($arr_tmp))
    {
      $this->setViewArrayFromBBDD($arr_tmp);
    }
    else
    {
      $this->setViewVariable('admin_msg', 'search_not_found');
    }

    $int_total_elements = $this->obj_data->getTotalElements();
    if ($int_max_index > $int_total_elements)
    {
      $int_max_index = $int_total_elements;
    }
    $this->setSessionElement('min_index', $int_min_index);
    $this->setViewVariable('min_index', $int_min_index);
    $this->setViewVariable('max_index', $int_max_index);
    $this->setViewVariable('total_elements', $int_total_elements);
    $this->setViewArray('col', 'description', $arr_field_descriptions);
    $this->setViewArray('col', 'name', $arr_field_names);
  }

  function _processAddUser()
  {
    if ($this->getViewVariable('_form_action') == 'add_user')
    {
      //Comprueba que se hayan introducido todos los datos
      if (($this->getViewVariable('name') != null) && ($this->getViewVariable('pass') != null) &&
          ($this->getViewVariable('pass_confirm') != null))
      {
        //Comprueba que las dos contraseñas sean iguales
        if ($this->getViewVariable('pass') == $this->getViewVariable('pass_confirm'))
        {
          //Busca en la base de datos que no exista el usuario indicado. Si no existe lo crea
          if (! $this->obj_data->doesUserExist($this->getViewVariable('name')))
          {
            if ($this->obj_data->addUser($this->getViewVariable('name'), 'default', 'es_ES',
                $this->getViewVariable('pass'), '', '', '0', ''))
            {
              $this->setViewVariable('admin_msg', 'add_user_ok');
              $this->setViewVariable('added_user', $this->getViewVariable('name'));
            }
            else
            {
              $this->setViewVariable('admin_msg', 'add_user_failed');
            }
          }
          else
          {
            $this->setViewVariable('admin_msg', 'user_exists');
          }
        }
        else
        {
          $this->setViewVariable('admin_msg', 'distinct_pass');
        }
      }
      else
      {
        $this->setViewVariable('admin_msg', 'not_all_data');
      }
    }
  }

  function _processAddUserList()
  {
    for ($i=0; list($key,$value) = each($this->arr_form); $i++)
    {
      print "Clave=$key|Valor=$value###";
    }

    switch ($this->getViewVariable('_form_action'))
    {
      case 'Procesar':
        //$arr_csv = $this->CSVaArray($this->getViewVariable('path'));
        break;

      default:
        break;
    }
  }

  function _processDelUser()
  {
    if ($this->issetViewVariable('form_name_search'))
    {
      switch ($this->getViewVariable('form_name_search'))
      {
        case 'search':  //Si hemos hecho submit en 'Buscar'
          $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                         array('Nombre de usuario', 'Contraseña'));
          break;

        case 'search_result': //Si hemos hecho submit en 'Anterior', 'Siguiente' o 'Dar de baja'
          switch ($this->getViewVariable('_form_action'))
          {
            case 'prev':
            case 'next':
              $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                             array('Nombre de usuario', 'Contraseña'));
              break;

            default:  //Cuando se ha ejecutado una acción sobre la lista del formulario ('Dar de baja')
              if ($this->issetViewVariable('_form_action') && is_string($this->getViewVariable('_form_action')))
              {
                if ($this->obj_data->doesUserExist($this->getViewVariable('_form_action')))
                {
                  $this->obj_data->delUser($this->getViewVariable('_form_action'));
                  $this->setViewVariable('admin_msg', 'del_user_ok');
                  $this->setViewVariable('deleted_user', $this->getViewVariable('_form_action'));
                }
                $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                               array('Nombre de usuario', 'Contraseña'));
              }
              break;
          }
          break;
      }
    }
    else
    {
      //Si hemos hecho submit en 'Dar de baja' introduciendo el usuario manualmente
      if ($this->issetViewVariable('_form_action') && $this->getViewVariable('_form_action') == 'del_user')
      {
        //Comprueba que se hayan introducido todos los datos
        if (($this->getViewVariable('name') != null))
        {
          //Busca en la base de datos si existe el usuario indicado. Si existe lo borra
          if ($this->obj_data->doesUserExist($this->getViewVariable('name')))
          {
            if ($this->obj_data->delUser($this->getViewVariable('name')))
            {
              $this->setViewVariable('admin_msg', 'del_user_ok');
              $this->setViewVariable('deleted_user', $this->getViewVariable('name'));
            }
            else
            {
              $this->setViewVariable('admin_msg', 'del_user_failed');
            }
          }
          else
          {
            $this->setViewVariable('admin_msg', 'user_not_exists');
          }
        }
        else
        {
          $this->setViewVariable('admin_msg', 'not_all_data');
        }
      }
    }
  }

  function _processEditUserProfile()
  {
    if ($this->issetViewVariable('form_name_search'))
    {
      switch ($this->getViewVariable('form_name_search'))
      {
        case 'search':  //Si hemos hecho submit en 'Buscar'
          $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                         array('Nombre de usuario', 'Contraseña'));
          break;

        case 'search_result': //Si hemos hecho submit en 'Anterior', 'Siguiente' o 'Editar perfil'
          switch ($this->getViewVariable('_form_action'))
          {
            case 'prev':
            case 'next':
              $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                             array('Nombre de usuario', 'Contraseña'));
              break;

            default:  //Cuando se ha ejecutado una acción sobre la lista del formulario ('Editar perfil')
              if ($this->issetViewVariable('_form_action') && is_string($this->getViewVariable('_form_action')))
              {
                if ($this->obj_data->doesUserExist($this->getViewVariable('_form_action')))
                {
                  //$this->obj_data->editUser($this->getViewVariable('_form_action'));
                }
              }
              break;
          }
          break;
      }
    }
    else
    {
      //Si hemos hecho submit en 'Editar perfil' introduciendo el usuario manualmente
      if ($this->issetViewVariable('_form_action') && $this->getViewVariable('_form_action') == 'edit_user_profile')
      {
        //Comprueba que se hayan introducido todos los datos
        if (($this->getViewVariable('name') != null))
        {
          //Busca en la base de datos si existe el usuario indicado. Si existe edita su perfil
          if ($this->obj_data->doesUserExist($this->getViewVariable('name')))
          {
            //$this->obj_data->delUser($this->getViewVariable('name')))
          }
          else
          {
            $this->setViewVariable('admin_msg', 'user_not_exists');
          }
        }
        else
        {
          $this->setViewVariable('admin_msg', 'not_all_data');
        }
      }
    }
  }

  function _processUserList()
  {
    if ($this->issetViewVariable('form_name_search'))
    {
      switch ($this->getViewVariable('form_name_search'))
      {
        case 'search':  //Si hemos hecho submit en 'Buscar'
          $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                         array('Nombre de usuario', 'Contraseña'));
          break;

        case 'search_result': //Si hemos hecho submit en 'Anterior' o 'Siguiente'
          switch ($this->getViewVariable('_form_action'))
          {
            case 'prev':
            case 'next':
              $this->_search('user', 'USER_ALIAS, USER_PASSWORD', array('username', 'password'),
                             array('Nombre de usuario', 'Contraseña'));
              break;

            default:
              break;
          }
          break;

        default:
          break;
      }
    }
  }

  /*
   * Funcion que pasa un array con una lista obtenida de la BBDD a la vista
   *
   */
  function setViewArrayFromBBDD($arr_value)
  {
    if (is_array($arr_value))
    {
      for ($j=0; $arr_value[$j] != null; $j++)
      {
        for ($i=0; list($key, $val) = each($arr_value[$j]); $i++)
        {
          $this->setViewVariable('col_'.($i+1).'_value_'.($j+1), $val);
        }
      }
    }
  }

  /*
   * Funcion que pasa un array a la vista
   *
   */
  function setViewArray($str_prefix, $str_sufix, $arr_value)
  {
    if (is_array($arr_value))
    {
      for ($i=0; $arr_value[$i] != null; $i++)
      {
        $this->setViewVariable($str_prefix.'_'.($i+1).'_'.$str_sufix, $arr_value[$i]);
      }
    }
  }

}

