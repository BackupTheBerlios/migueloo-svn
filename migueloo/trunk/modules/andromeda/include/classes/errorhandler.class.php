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
 * @subpackage include
 */
/**
 * Define la clase para el control de errores.
 * Se plantea un manejador de errores para su uso en el framework
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */

class ErrorHandler
{
	/**
	* Constructor.
	*
	* @public
	*/
	function ErrorHandler()
	{
		error_reporting(E_ALL);
		//error_reporting  (FATAL + ERROR + WARNING);
		set_error_handler(array($this, "processError"));
	}

	// funcion de gestion de errores definida por el usuario
	function processError($num_err, $mens_err, $nombre_archivo, $num_linea, $vars)
	{
		// conjunto de errores de los cuales se almacenara un rastreo
		$errores_de_usuario = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

		if (in_array($num_err, $errores_de_usuario)){
		    // marca de fecha/hora para el registro de error
    		$dt = date("Y-m-d H:i:s (T)");

    		// definir una matriz asociativa de cadenas de error
    		// en realidad las unicas entradas que deberiamos
    		// considerar son E_WARNING, E_NOTICE, E_USER_ERROR,
    		// E_USER_WARNING y E_USER_NOTICE

    		$tipo_error = array (
				E_ERROR          => "Error",
				E_WARNING        => "Advertencia",
				E_PARSE          => "Error de Intérprete",
				E_NOTICE          => "Anotación",
				E_CORE_ERROR      => "Error de Núcleo",
				E_CORE_WARNING    => "Advertencia de Núcleo",
				E_COMPILE_ERROR  => "Error de Compilación",
				E_COMPILE_WARNING => "Advertencia de Compilacón",
				E_USER_ERROR      => "Error de Usuario",
				E_USER_WARNING    => "Advertencia de Usuario",
				E_USER_NOTICE    => "Anotación de Usuario"
				//,
				//E_STRICT          => "Anotaci&oacute;n de tiempo de ejecuci&oacute;n"
    		);

	      	$err = "<errorentry>\n";
	       	$err .= "\t<datetime>" . $dt . "</datetime>\n";
    	    $err .= "\t<errornum>" . $num_err . "</errornum>\n";
		    $err .= "\t<errortype>" . $tipo_error[$num_err] . "</errortype>\n";
    		$err .= "\t<errormsg>" . $mens_err . "</errormsg>\n";

	       	if(!empty($nombre_archivo)){
	       	  $err .= "\t<scriptname>" . $nombre_archivo . "</scriptname>\n";
            }

            if(!empty($num_linea)){
	       	  $err .= "\t<scriptlinenum>" . $num_linea . "</scriptlinenum>\n";
		    }

    		//if (in_array($num_err, $errores_de_usuario)){
    		//	$err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    		//}
    		$err .= "</errorentry>\n\n";
		
			// guardar en el registro de errores, y enviar un correo
			error_log($err, 3, MIGUELBASE_ERRORLOG_FILE);
			//)mail("jamarcer@inicia.es", "Error Critico de Usuario en miguel", $err);
			if($num_err != E_USER_ERROR){
				include_once(Util::app_Path('error/control/classes/miguel_cerror.class.php'));
				$obj_error = new miguel_CError($tipo_error[$num_err], $mens_err);
				$obj_error->Exec();
			} else {
				$err = "\n";
				$err .= "\tdatetime: ".$dt."\n";
				$err .= "\terrornum: ".$num_err."\n";
				$err .= "\terrortype: ".$tipo_error[$num_err]."\n";
				$err .= "\terrormsg: ".$mens_err."\n";

				if(!empty($nombre_archivo)){
				$err .= "\tscriptname: ".$nombre_archivo."\n";
				}

				if(!empty($num_linea)){
				$err .= "\tscriptlinenum: ".$num_linea."\n";
				}
                    echo '<h1>Error Fatal</h1><br>';
					echo '<pre>'.$err.'</pre><br>';
					echo '<h3>Consulte con el administrador</h3><br>';
					Session::close();
					die();
			}
		}
	}
}
?>
