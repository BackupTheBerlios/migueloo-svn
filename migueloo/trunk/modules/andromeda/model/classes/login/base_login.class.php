<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
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
      | Authors: Guillermo Halys Ortuño    <yursoft@yursoft.com>             |
	  |          Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage model
 */
/**
 *
 */ 
 
/**
 * Esta clase abstrae la seleccion un creación del objeto de login.
 *  
 *
 * @author Guillermo Halys Ortuño <yursoft@yursoft.com>
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */ 
 
 // ESTE INCLUDE ELIMINARLO YA QUE ES DE PRUEBAS
//include_once ('../../../common/miguel_base.inc.php');
include_once('./base_loginbase.php');
include_once('./base_loginmd5.php');
include_once('./base_loginplano.php');
include_once('./base_loginmcrypt.php');
 
class base_login
{
  function base_login()
  {

  } 
  
  function crearLogin()
  {
    $typeLogin = strtoupper(Session::getContextValue('typeLogin'));
    $typeEncrypt = strtoupper(Session::getContextValue('typeEncrypt'));
    $typeEncryptMcrypt = Session::getContextValue('typeEncryptMcrypt');
    
    if ($typeLogin == 'BBDD')
    {
      if ($typeEncrypt == 'PLAIN')
      {
        return new base_loginPlano();
      }
      else
      if ($typeEncrypt == 'MD5')
      {
        return new base_loginMD5();
      }
      else
      if ($typeEncrypt == 'MCRYPT')
      {        
        return new base_loginMCRYPT($typeEncryptMcrypt);
      }      
    }
    else
    if ($typeLogin == 'LDAP')
    {
    
    }
 	}    	
}

?>

