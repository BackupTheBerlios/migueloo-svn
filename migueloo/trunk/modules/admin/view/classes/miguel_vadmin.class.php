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
 * Define la clase de la vista del modulo admin.
 *
 * @author Manuel R. Freire Santos <mfreires@alumnos.nebrija.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package miguel admin
 * @subpackage view
 * @version 1.0.0
 *
 */

include_once (Util::app_Path('common/view/classes/miguel_vmenu.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_searchForm.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_searchresultForm.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_adduserlistForm.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_adduserForm.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_deluserForm.class.php'));
include_once (Util::app_Path('admin/view/include/classes/miguel_edituserprofileForm.class.php'));

class miguel_VAdmin extends miguel_VMenu
{
  var $arr_commarea = null;

  function miguel_VAdmin($title, $arr_commarea)
  {
    $this->miguel_VMenu($title, $arr_commarea);
    $this->arr_commarea = $arr_commarea;
  }

  function right_block()
  {
    if (($ret_val = $this->_checkAdminErrors()) == true)  //Comprueba si se han producido errores
    {
      return $ret_val;
    }

    $div = html_div();
    $div->add($this->_checkAdminMessages()); //Comprueba y muestra los mensajes pasados por el controlador

    $str_screen = $this->getViewVariable('admin_screen');
    switch ($str_screen)
    {
      case 'users':
        $ret_val = $this->_usersView();
        break;

      case 'courses':
        $ret_val = $this->_coursesView();
        break;

      case 'petitions':
        $ret_val = $this->_petitionsView();
        break;

      case 'sysconfig':
        $ret_val = $this->_sysconfigView();
        break;

      case 'add_user':
        $ret_val = $this->_addUserView();
        break;

      case 'del_user':
        $ret_val = $this->_delUserView();
        break;

      case 'add_user_list':
        $ret_val = $this->_addUserListView();
        break;

      case 'edit_user_profile':
        $ret_val = $this->_editUserProfileView();
        break;

      case 'user_list':
        $ret_val = $this->_userListView();
        break;

      default:
        $ret_val = $this->_defaultView();
        break;
   }

    $div->add($ret_val);
    return $div;
  }

  function _checkAdminErrors()
  {
    if ($this->issetViewVariable('admin_error'))
    {
      $div = html_div();

      switch ($this->getViewVariable('admin_error'))
      {
        case 'no_auth':
          $div->add('Debes ser administrador para acceder a este área.');
          $div->add(html_br(2));
          break;

        case 'no_logged':
          $div->add('No estás loggeado. Debes ser administrador para acceder a este área.');
          $div->add(html_br(2));
          break;

        default:
          $div->add('Se ha producido un error');
          $div->add(html_br(2));
          break;
      }

      return $div;
    }

    return null;
  }

  function _checkAdminMessages()
  {
    if ($this->issetViewVariable('admin_msg'))
    {
      $div = html_div();

      switch ($this->getViewVariable('admin_msg'))
      {
        case 'add_user_ok':
          $div->add('El usuario '.$this->getViewVariable('added_user').' se dado de alta correctamente');
          $div->add(html_br(2));
          break;

        case 'del_user_ok':
          $div->add('El usuario '.$this->getViewVariable('deleted_user').' se dado de baja correctamente');
          $div->add(html_br(2));
          break;

        case 'distinct_pass':
          $div->add('Las contraseñas introducidas son diferentes');
          $div->add(html_br(2));
          break;

        case 'not_all_data':
          $div->add('Debes rellenar todos los campos');
          $div->add(html_br(2));
          break;

        case 'user_exists':
          $div->add('El usuario introducido ya existe. Debes introducir un nombre de usuario válido.');
          $div->add(html_br(2));
          break;

        case 'user_not_exists':
          $div->add('El usuario introducido no existe. Debes introducir un nombre de usuario válido.');
          $div->add(html_br(2));
          break;

        case 'del_user_failed':
          $div->add('No se ha podido dar de baja el usuario indicado.');
          $div->add(html_br(2));
          break;

        case 'add_user_failed':
          $div->add('No se ha podido dar de alta el usuario indicado.');
          $div->add(html_br(2));
          break;

        case 'search_not_found':
          $div->add('No se ha encontrado ningún elemento.');
          $div->add(html_br(2));
          break;

        default:
          break;
      }

      return $div;
    }

    return null;
  }

  function _defaultView()
  {
    $ret_val = html_div();

    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=users'),
    //                                          'Gestión de usuarios'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user'), 
							       Theme::getThemeImagePath('menu/inscription.png'), 
								   agt('miguel_Module') .  'Altas de usuarios' ));   
	//$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=courses'),
    //                                          'Gestión de cursos'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user'), 
							       Theme::getThemeImagePath('menu/inscription.png'), 
								   agt('miguel_Module') .  'Altas de usuarios' ));   
	//$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=petitions'),
    //                                          'Peticiones pendientes'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user'), 
							       Theme::getThemeImagePath('menu/inscription.png'), 
								   agt('miguel_Module') .  'Altas de usuarios' ));   
	//$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=sysconfig'),
    //                                          'Configuración del sistema'), html_br());
	$ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user'), 
							       Theme::getThemeImagePath('menu/inscription.png'), 
								   agt('miguel_Module') .  'Altas de usuarios' ));   
								   
    return $ret_val;
  }

  function _usersView()
  {
    $ret_val = html_div();

    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=add_user'),
    //                                          'Altas de usuarios'), html_br());
	$ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user'), 
							       Theme::getThemeImagePath('menu/inscription.png'), 
								   agt('miguel_Module') .  'Altas de usuarios' ));                                          
	
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=del_user'),
    //                                          'Bajas de usuarios'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=del_user'), 
							       Theme::getThemeImagePath('delete.png'), 
								   agt('miguel_Module') .  'Bajas de usuarios' ));                   
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile'),
    //                                          'Editar perfil'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile'), 
							       Theme::getThemeImagePath('menu/profileedit.png'), 
								   agt('miguel_Module') .  'Editar perfil' ));                   
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=add_user_list'),
    //                                          'Importar lista usuarios'), html_br());
    $ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=add_user_list'), 
							       Theme::getThemeImagePath('modules/group.png'), 
								   agt('miguel_Module') .  'Importar lista de usuarios' ));                   
	//$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=user_list'),
    //                                          'Lista de usuarios'), html_br());
	$ret_val->add($this->imag_ref( Util::format_URLPath('admin/index.php', 'admin_screen=user_list'), 
							       Theme::getThemeImagePath('modules/listusers.png'), 
								   agt('miguel_Module') .  'Lista de usuarios' ));                   
								   
    return $ret_val;
  }

  function _coursesView()
  {
    $ret_val = html_div();

    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=add_course'),
    //                                          'Crear un curso'), html_br());
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=del_course'),
    //                                          'Borrar un curso'), html_br());
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=edit_course'),
    //                                          'Editar un curso'), html_br());
    //$ret_val->add(html_a(Util::format_URLPath('admin/index.php', 'admin_screen=course_list'),
    //                                          'Lista de cursos'), html_br());
    $ret_val->add('No implementado');

    return $ret_val;
  }

  function _petitionsView()
  {
    $ret_val = html_div();

    $ret_val->add('No implementado');

    return $ret_val;
  }

  function _sysconfigView()
  {
    $ret_val = html_div();

    $ret_val->add('No implementado');

    return $ret_val;
  }

  function _addUserView()
  {
    $ret_val = html_div();
    $ret_val->add(new FormProcessor(new miguel_adduserForm(), 'adduser_form',
                                    Util::format_URLPath('admin/index.php', 'admin_screen=add_user')));
    return $ret_val;
  }

  function _delUserView()
  {
    $ret_val = html_div();

    if ($this->issetViewVariable('form_name_search')) //Submit en 'search' o 'search_result' => mostramos 'search_result'
    {
      $ret_val->add(new FormProcessor(new miguel_searchresultForm($this->arr_commarea), 'search_form',
                                      Util::format_URLPath('admin/index.php', 'admin_screen=del_user')));
    }
    else //Si no => mostramos 'deluser_form'
    {
      $ret_val->add(new FormProcessor(new miguel_deluserForm(), 'deluser_form',
                                      Util::format_URLPath('admin/index.php', 'admin_screen=del_user')));
    }

    $ret_val->add(html_hr());
    $ret_val->add(new FormProcessor(new miguel_searchForm($this->arr_commarea), 'search_form',
                                    Util::format_URLPath('admin/index.php', 'admin_screen=del_user')));

    return $ret_val;
  }

  function _addUserListView()
  {
    $ret_val = html_div();
    $ret_val->add(new FormProcessor(new miguel_adduserlistForm(), 'adduserlist_form',
                                    Util::format_URLPath('admin/index.php', 'admin_screen=add_user_list')));

    return $ret_val;
  }

  function _editUserProfileView()
  {
    $ret_val = html_div();

    if ($this->issetViewVariable('form_name_search')) //Submit en 'search' o 'search_result' => mostramos 'search_result'
    {
      $ret_val->add(new FormProcessor(new miguel_searchresultForm($this->arr_commarea), 'search_form',
                                      Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile')));
    }
    else //Si no => mostramos 'edituserprofile_form'
    {
      $ret_val->add(new FormProcessor(new miguel_edituserprofileForm(), 'edituserprofile_form',
                                      Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile')));
    }

    $ret_val->add(html_hr());
    $ret_val->add(new FormProcessor(new miguel_searchForm($this->arr_commarea), 'search_form',
                                    Util::format_URLPath('admin/index.php', 'admin_screen=edit_user_profile')));

    return $ret_val;
  }

  function _userListView()
  {
    $ret_val = html_div();

    if ($this->issetViewVariable('form_name_search')) //Submit en 'search' o 'search_result' => mostramos 'search_result'
    {
      $ret_val->add(new FormProcessor(new miguel_searchresultForm($this->arr_commarea), 'search_form',
                                      Util::format_URLPath('admin/index.php', 'admin_screen=user_list')));
    }

    $ret_val->add(html_hr());
    $ret_val->add(new FormProcessor(new miguel_searchForm($this->arr_commarea), 'search_form',
                                    Util::format_URLPath('admin/index.php', 'admin_screen=user_list')));

    return $ret_val;
  }

}
?>
