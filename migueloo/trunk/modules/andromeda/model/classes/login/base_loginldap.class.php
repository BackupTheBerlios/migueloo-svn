<?php
/*
      +----------------------------------------------------------------------+
      | Miguel common                                                        |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, miguel Development Team                          |
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
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase "abstracta" de login, para el "wrapper" de miguel_userInfo. 
 *
 * @author Guillermo Halys Ortuño <yursoft@yursoft.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel common
 * @subpackage control
 * @version 1.0.0
 *
 */ 
 
class base_loginLDAP
{
  function base_loginBase()
  {
  
  }
  
  function _encrypt($str_userpswd)
  {
   echo '&lt;h3>Prueba de consulta LDAP&lt;/h3>';
    echo 'Conectando ...';
    $ds=ldap_connect('localhost');  
    echo 'El resultado de la conexi&oacute;n es '.$ds.'&lt;p>';
    
    if ($ds) 
    {
      echo 'Autentific&aacute;ndose  ...';
      $r=ldap_bind($ds);    
                             
      echo 'El resultado de la autentificaci&oacute;n es '.$r.'&lt;p>';
      
      echo 'Buscando (sn=P*) ...';
     
      $sr=ldap_search($ds,'o=halys, c=halys', 'sn=h*'); 
      echo 'El resultado de la b&uacute;squeda es '.$sr.'&lt;p>';
      
      echo 'El n&uacute;mero de entradas devueltas es '.ldap_count_entries($ds,$sr).'&lt;p>';
      
      echo 'Recuperando entradas ...&lt;p>';
      $info = ldap_get_entries($ds, $sr);
      echo 'Devueltos datos de '.$info['count'].' entradas:&lt;p>';
      
      for ($i=0; $i<$info['count']; $i++) 
      {
        echo 'dn es: '. $info[$i]['dn'] .'&lt;br>';
        echo 'La primera entrada cn es: '. $info[$i]['cn'][0] .'&lt;br>';
      }
      
      echo 'Cerrando conexi&oacute;n';
      ldap_close($ds);
    
    } 
    else 
    {
      echo '&lt;h4>Ha sido imposible conectar al servidor LDAP&lt;/h4>';
    }   
  }

  function login($obj_model, $str_username, $str_userpswd)
  {

  }
}

?>
