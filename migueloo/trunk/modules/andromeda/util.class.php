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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage util
 */

/**
 * Define funciones útiles para miguel.
 * Se definen funciones de uso común para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage util
 * @version 1.0.0
 *
 */
class Util
{
    /**
	 * Formatea una dirección (path) en función del SO de la máquina.
	 *
	 * @param string $str_path Path a formatear.
	 * @return string Path formateado.
	 *
	 */
	function formatPath($str_path)
    {
        $str_val = chop($str_path);

        //switch (MIGUELBASE_USR_OS) {
        //    case 'Win':
        //        $ret_val = str_replace("/", "\\", $str_val);
        //        break;
        //    default:
                $ret_val = str_replace('\\', '/', $str_val);
	      //}

        return $ret_val;
    }

    /*
     * Formatea una dirección (path)
	 * Relativo a la dirección del framework modules/andromeda/
	 *
	 * @param string $str_path Path a formatear.
	 * @return string Path formateado.
	 *
     */
    function base_Path($str_path)
    {
        return Util::formatPath(MIGUELBASE_DIR.chop($str_path));
    }
    
    /*
     * Formatea una dirección (path)
     * Relativo a la dirección donde estan los modulos: modules/
	 *
	 * @param string $str_path Path a formatear.
	 * @return string Path formateado.
	 *
     */
    function app_Path($str_path)
    {
        return Util::formatPath(MIGUELBASE_MAINDIR.chop($str_path));
    }
	
	/*
     * Formatea una dirección (path)
     * Relativo a la dirección donde está la aplicación: /
	 *
	 * @param string $str_path Path a formatear.
	 * @return string Path formateado.
	 *
     */
    function main_Path($str_path)
    {
        return Util::formatPath(MIGUELBASE_APPDIR.chop($str_path));
    }
    
    /*
     * Formatea una dirección URL, sin sesión.
	 *
	 * @param string $str_path Path a formatear.
	 * @return string URL formateada.
	 *
     */
    function app_URLPath($str_path)
    {
        return str_replace('\\', '/', MIGUELBASE_MODULES_URL.chop($str_path));
    }

    /*
     * Formatea una dirección URL, sin sesión, relativa al superdirectorio de la aplicación.
	 *
	 * @param string $str_path Path a formatear.
	 * @return string URL formateada.
	 *
     */
    function main_URLPath($str_path)
    {
        return str_replace('\\', '/', MIGUELBASE_URL.chop($str_path));
    }

    /*
     * Formatea una dirección URL, añadiendo sesión.
     * Relativo a dirección module/.
	 *
	 * @param string $str_path Path a formatear.
	 * @return string URL formateada.
	 *
     */
    function format_URLPath($str_path, $str_param = '')
    {
        return Util::session_URLPath(MIGUELBASE_MODULES_URL.$str_path, $str_param);
    }

    /*
     * Formatea una dirección URL, añadiendo el identificador de sesión.
     *
	 * @param string $str_path Path a formatear.
	 * @return string URL formateada.
	 *
     */
    function session_URLPath($str_path, $str_param = '')
    {
        if ($str_path == '') {
            $ret_val = '';
        } else {
            //No nos sirve usar SID. Se cambia la sesión de forma dinámica.
            $sid = session_name().'='.session_id();

        	if($str_param == ''){
        		$ret_val = chop($str_path)."?$sid";
        	} else {
        		$ret_val = chop($str_path)."?$sid&".chop($str_param);
        	}
        }

        return str_replace('\\', '/', $ret_val);
    }

    /*
     * Formatea una dirección (path).
     * Relativo a dirección modules/.
	 *
	 * @param string $str_path Path a formatear.
	 * @return string Path formateado.
	 *
     */
    function format_pathApp($str_path)
    {
        return Util::formatPath(MIGUELBASE_MAINDIR.chop($str_path));
    }

	/*
	 * Genera una clave de forma aleatoria.
	 *
	 * @param integer $num_char Número de caracteres en la clave.
	 * @return string Clave generada..
	 *
	 */
	function newPasswd($num_char = 8)
	{
		$chars  = 'abcdefghijklmnopqrstuvwxyzABDCEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$passwd = '';

		for($i=0; $i<$num_char; $i++)
		{
			$passwd .= $chars[rand()%strlen($chars)];
		}

		return $passwd;
	}
}
?>
