#!/usr/bin/php
<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
class miguel_HTMLParser
{
	var $funct = '';
	var $end = '';
		
	function miguel_HTMLParser($func = 'src=', $end = '" ')
	{
		$this->funct = $func;
		$this->end = $end;
	}
	
	function setParam($func = 'src=', $end = '" ')
	{
		$this->funct = $func;
		$this->end = $end;
	}

	function processFile($filename)
	{
		//Abrimos el fichero
		$lines = $this->readFile($filename);
		
		//Definicion de variables auxiliares
		$content = '';
		
		//Tratamos el fichero
		$token = '<body';
		$save_line = false;
		$init = 0;
		$end = 0;
		
		for($i=1; $i < count($lines); $i++) {
			$findit = stristr($lines[$i], $token);
			if(!empty($findit)){
				if($token == '<body'){
					$token = '</body';
					$init = $i+1;
				} else {
					$end = $i;
				}
				
			}
		}
		
		if($end == 0){
			$init = 0;
			$end = count($lines);
		}		
		
		for($i=$init; $i < $end; $i++) {
			$token = $lines[$i];
			$changed = $lines[$i];
			$ini_pos = strlen($this->funct);
			do {
				//echo "pp: $token\n";
				$gettext = stristr($token, $this->funct);
				//echo "b: $gettext\n";
				$fin = strpos($gettext, $this->end);
				//echo "xx: $fin\n";
				$literal = substr($gettext,$ini_pos,$fin-$ini_pos+1);
				$token = substr($gettext,$fin);
				//echo "c: $literal\n";
				//echo "d: $token\n";
				//Reemplazamos en cadena
				$changed = str_replace($literal, '"<?php echo $this->_coursePath('.$literal.'); ?>"', $changed);
			} while(strpos($token, $this->funct));

			$content .= $changed;
		}
		$this->writeFile($filename, $content);
	}

	function addFile($filename)
	{
		if(!file_exists($filename)){
			die("El fichero $filename no existe");
		} else {
			if(!is_file($filename)) {
				die("$filename no es un fichero procesable por miguel_HTMLParser");
			}
			
			$this->processFile($filename);
		}
	}
	
	function writeFile($filename, $file_content)
	{
		if(file_exists($filename)){
			unlink($filename);
		}
		//Writes file into $folder
		$fp = fopen($filename,'wb');
		fwrite($fp,$file_content);
		fclose($fp);
	}
	
	function readFile($filename)
	{
		$file_content = array();
		$numLin = 0;
		// Read in the file's contents
		$fp = fopen($filename,'rb');
		while($reg = fgets($fp)) {
			$file_content[$numLin] = $reg;
			$numLin++;
		}
		//$this->file_content = fread($fp, filesize($filename));
		fclose($fp);
		
		//Salvaguarda
		copy($filename, $filename.'_bckp');

		//
		return $file_content;
	}
}

if ($argc < 1 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

Procesador de ficheros de un curso en formato HTML del proyecto miguel

  Uso:
  <?php echo $argv[0]; ?> <option>

  <option> puede ser
  *  --help, -help, -h o -? para obtener esta ayuda;
  * -d para procesar todos los ficheros en el directorio actual
  * lista de ficheros a procesar

<?php
} else {
	$gen = new miguel_HTMLParser();
	
	for($i = 1; $i < $argc; $i++)	{
		if($argv[$i] == '-p'){
			$gen->setParam($argv[$i+1], $argv[$i+2]);
			$i = $i +3;
		}
		
		if($argv[$i] == '-d') {
			$dirname = getcwd();
			$dir = opendir($dirname);

			while($file = @readdir($dir)) {
				if($file == '.' || $file == '..') {
					continue;
				} else if(@is_dir($dirname.'/'.$file)) {
					continue;
				} else if(@file_exists($dirname.'/'.$file)) {
					if($file != 'miguel_HTMLParser.php'){
						echo "Procesado fichero: $file\n";
						$gen->addFile($file);
					}
				}
			}
	
			@closedir($dir);
		} else {
			$gen->addFile($argv[$i]);
		}
	}
}
?>
