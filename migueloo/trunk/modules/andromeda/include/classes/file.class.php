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
 * Define la clase para la manipulación de un fichero.
 * Se define la funcionalidad más común de uso sobre un fichero: leer, escribir, borrar, ....
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */ 
class File
{
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
    function Write($file_name, $content)
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
	
	/**
     * Actualiza las fechas de última modificación y último acceso del fichero
	 *         Si no existe el fichero lo crea.
	 *
     * @param string $file_name Nombre del fichero
     */
	function Touch($file_name)
	{
    	if(file_exists($file_name)) {
    		touch($file_name);
    	}
    }

/*
 * @Name: unlink_wc($dir,$pattern)
 * @Description: A unlink function that support wildcards ( * and ? )
 * (based on code taked from php.net manual comments)
 * @Author: Pablo Rosciani [ pabloATnkstudiosDOTnet ] [ http://pi.nks.com.ar ]
 * @Date: 15/10/03
 * @param string $dir      Directory to search files
 * @param string $pattern  Pattern to find.
 *
 */
/*
function unlink_wc($dir, $pattern){
   if ($dh = opendir($dir)) {
       while (false !== ($file = readdir($dh))){
           if ($file != '.' && $file != '..') {
               $files[] = $file;
           }
       }
       closedir($dh);
       if(strpos($pattern,'.')) {
           $baseexp=substr($pattern,0,strpos($pattern,'.'));
           $typeexp=substr($pattern,strpos($pattern,'.')+1,strlen($pattern));
       }else{
           $baseexp=$pattern;
           $typeexp='';
       }
       $baseexp=preg_quote($baseexp);
       $typeexp=preg_quote($typeexp);
       $baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
       $typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);
       $i=0;
       foreach($files as $file) {
           $filename=basename($file);
           if(strpos($filename,'.')) {
               $base=substr($filename,0,strpos($filename,'.'));
               $type=substr($filename,strpos($filename,'.')+1,strlen($filename));
           }else{
               $base=$filename;
               $type='';
           }
           if(preg_match("/^".$baseexp."$/i",$base) && preg_match("/^".$typeexp."$/i",$type))  {
               $matches[$i]=$file;
               $i++;
           }
       }
       if (count($matches) > 0){
               while(list($idx,$val) = each($matches)){
                   if (substr($dir,-1) == '/'){
                       unlink($dir.$val);
                   }else{
                       unlink($dir.'/'.$val);
                   }
               }
       }

   }
}

unlink_wc('/path/to/folder/','*.*');
*/
}

?>
