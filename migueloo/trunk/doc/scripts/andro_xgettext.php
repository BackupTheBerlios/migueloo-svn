#!/usr/bin/php 

<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
class andro_xgettext
{
	/**
	 *
	 */
	var $file_content = ''; 
	var $file_name = 'output.po';
	var $funct = 'agt';
	var $item = array();
		
	/**
	 * 
	 */
	function andro_xgettext()
	{
		$this->file_content = $this->makePreData();
	}
	
	/**
	 * 
	 */
	function setFileName($fileout = '')
	{
		if (!empty($fileout)){
			$this->file_name = $fileout;
		}
	}

	/**
	 *
	 */
	function processFile($filename)
	{
		//Abrimos el fichero
		$lines = $this->readFile($filename);
		
		//Definicion de variables auxiliares
		$literal = array();
		
		//Tratamos el fichero
		$j = 0;
		for($i=0; $i < count($lines); $i++) {
			$j=$i+1;
			$ini_pos = strlen($this->funct) + 1;
			
			$token = trim($lines[$i]);
			do {
				//echo "a: $token\n";
				$gettext = strstr($token, $this->funct.'(');
				//echo "b: $gettext\n";
				$fin = strpos($gettext, ')');
				//echo "xx: $fin\n";
				$literal = substr($gettext,$ini_pos,$fin-4);
				$token = substr($gettext,$fin);
				//echo "c: $literal\n";
				//echo "d: $token\n";
				if (!empty($literal)){
					if(in_array(substr($literal,0,1), array('\'', '"'))){
						$literal = substr($literal,1, -1);
						if(substr($literal,0,1) != '$'){
							if(!in_array($literal, $this->item)){
								$this->item[] = $literal;	
								$this->file_content .= $this->_indexVal($filename, $literal);
							}
						}
					} 
					//else {
					//	$this->file_content .= $this->_indexVal($filename, $literal);
					//}
				}
			} while(strpos($token, $this->funct.'('));
		}	
	}
	
	/**
	 *
	 */
	function generateFile()
	{
		$this->writeFile($this->file_name, $this->file_content);
	}
	
	/**
   	 *
   	 */
  	function makePreData()
    {
      	$ret_buffer = '# translation of '.$filename.' to Español
# This file is distributed under the same license as the miguel package.
# Copyright (C) 2003, 2004 miguel.
# miguel Development Team <e-learning-desarrollo@listas.hispalinux.es>, '.date("Y").'
#
msgid ""
msgstr ""
"Project-Id-Version: setup\n"
"POT-Creation-Date: '.date("Y-m-d H:i:s").'+0100\n"
"PO-Revision-Date: '.date("Y-m-d H:i:s").'+0100\n"
"Last-Translator: Jesús A. Martínez Cerezal <jamarcer@inicia.es>\n"
"Language-Team: Español <es@li.org>\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset = iso-8859-1\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Generator: miguel script 1.0.0\n"';
		
		return $ret_buffer;
    }

	/**
	 * 
	 */
	function addFile($filename)
	{
		if(!file_exists($filename)){
			die("El fichero $filename no existe");
		} else {
			if(!is_file($filename)) {
				die("$filename no es un fichero procesable por andro_xgettext");
			}
			
			$this->processFile($filename);
		}
	}
	
	/**
	 * 
	 */
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
	
	/**
	 * 
	 */
	function readFile($filename)
	{
		$file_content = array();
		$numLin = 0;
		// Read in the file's contents
		$fp = fopen($filename,'rb');
		while($reg = fgets($fp)) {
			$file_content[$numLin] =$reg;
			$numLin++;
		}
		//$this->file_content = fread($fp, filesize($filename));
		fclose($fp);

		//
		return $file_content;
	}
	
	/**
	 *
	 */
	function _indexVal($filename, $literal)
	{
		$ret_val = '
#: '.$filename.':'.$j.'
msgid "'.$literal.'"
msgstr "'.$literal.'"

';
		return $ret_val;
	} 
}

if ($argc < 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

Extractor de literales para gettext del proyecto miguel

  Uso:
  <?php echo $argv[0]; ?> <option>

  <option> puede ser
  *  --help, -help, -h o -? para obtener esta ayuda;
  *  -o <fichero> para generar la salida con el nombre <fichero> y
  * lista de ficheros a procesar

<?php
} else {
	$gen = new andro_xgettext();
	for($i = 1; $i < $argc; $i++){
		if($argv[$i] == '-o') {
			$gen->setFileName($argv[$i+1]);
			$i = $i+1;
			continue;
		}

		$gen->addFile($argv[$i]);
	}
	$gen->generateFile();
} 
?>
