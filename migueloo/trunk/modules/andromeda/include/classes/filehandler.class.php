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
 * Define la clase para trabajar sobre un fichero.
 * Se plantea un manejador de ficheros para su uso en el sistema de Logs, ....
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */
class FileHandler
{
	/**
	 * @access private
	 */
	var $locked = false;
	/**
	 * @access private
	 */
	var $max_attempts = 1;
	/**
	 * @access private
	 */
	var $waitTime = 10000;
	/**
	 * @access private
	 */
	var $error;
	
    /**
     * Constructor
     * @param boolean $lockFile Marca si se bloquea, o no, el fichero.
     * @param integer $retry Número de reintentos.
     * @param integer $time Tiempo de espera entre intentos.
     */
	function FileHandler($lockFile = true, $retry = 5, $time = 1000)
	{
	   $this->locked       = $lockFile;
	   $this->max_attempts = $retry;
	   $this->waitTime     = $waitTime;
	   $this->error        = NO_ERROR;
	}
	
	/**
     * Abre el fichero solicitado.
     * @param string $str_fileName Nombre del fichero
     * @param string $str_mode Modo de apertura
     * @param string $bol_create Si el fichero no existe se crea
     */
	function Open($str_fileName, $str_mode = 'a', $bol_create = true)
	{
        $ret_val = false;		

        if(file_exists($str_fileName)){
		  $file_handle = @fopen($str_fileName, $str_mode);
		  
		  if(!$file_handle) {
		      $this->int_error = COULD_NOT_OPEN_FILE;
		  } else {
		      $ret_val = $file_handle;
		  }
		} else if ($bol_create) {
		  $file_handle = @fopen($str_fileName, 'a');
		
		  if(!$file_handle) {
		      $this->error->setError(ERROR_NOTICE, COULD_NOT_CREATE_FILE);
		  } else {
		      $ret_val = $file_handle;
		  }
		} else {
		  $this->obj_error->setError(ERROR_NOTICE, FILE_DOES_NOT_EXIST);
		}
		
		return $ret_val;
    }

	
    /**
     * Recupera el contenido de un fichero
     * @param string $file_name Nombre del fichero a leer
     */
	function Read($file_name)
	{
		// abrir en modo escritura el fichero cache
    	$file = @fopen($file_name,'r');
    	
    	// escribir el contenido de $html en el fichero cache
    	$ret = @fread ($file, filesize($file_name));
		
    	// cerrar fichero
    	@fclose($file);
    	
    	return $ret;
    }

    /**
     * Escribe en un fichero el contenido dado
     * @param string $file_name Nombre del fichero para guardar la información
     * @param string $content Contenido a guardar
     */
    function WriteTo($file_name, $content)
    {
    	//dbg_echo("_createCache: $cache_name");
    	// abrir en modo escritura el fichero cache
    	$file = @fopen($file_name,'w');

    	// escribir el contenido de $html en el fichero cache
    	@fwrite($file, $content);

    	// cerrar fichero
    	@fclose($file);
    }

    /**
     * Borra  un fichero
     * @param string $file_name Nombre del fichero a borrar
     */
	function Delete($file_name)
	{
    	if(file_exists($file_name)) {
    		unlink($file_name);
    	}
    }

?>
