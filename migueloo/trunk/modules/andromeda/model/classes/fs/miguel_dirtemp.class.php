<?php
/*
    +----------------------------------------------------------------------+
    | Miguel Temp Dir Manager class                                        |
    +----------------------------------------------------------------------+
    | This software is part of Miguel    version 0.1.0 $Revision: 1.3 $    |
    +----------------------------------------------------------------------+
    | Copyright (c) 2003, Asociacion Hispalinux                            |
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
    | Author:                                                              |
    |         Antonio F. Cano <antoniofcano at telelefonica dot net>       |
    +----------------------------------------------------------------------+
    | Modified by:                                                         |
    |         Jesús Martínez <jamarcer at inicia dot es>                   |
    +----------------------------------------------------------------------+

  Fecha ultima modificacion:
  	11/09/2003 23:25 - antoniofcano
		- Fixed problem with paths in deleteName
		- Added @ to Directory's commands in createName 
  	11/09/2003 17:45 - jamarcer
  		- Included:
  			* Superclass miguel_Error
  			* Methods: _readFromTempFile, _writeInTempFile, _deleteTempFile
  		- Modified:
  			* createName, deleteName, generateRandomName

  	02/09/2003 00:40 - Initial release
*/
include_once (Util::app_Path("common/control/classes/miguel_Error.class.php"));

class miguel_DirTemp extends miguel_Error
{
	var $name = "";
	var $dirBase = "";

	function miguel_DirTemp ( $strDirBase = "")
	{
		//Set a prime seed for random nums
		srand( (double)microtime()*7919 );

		$this->name = "";
		$this->dirBase = $strDirBase;

		//Call to superclass constructor
		$this->miguel_Error();
	}

	function getName()
	{
		return $this->name;
	}

	function setName($newName)
	{
		$this->name = $newName;
	}

	function getDirTemp()
	{
		return ( $this->dirBase . "/" . $this->name );
	}

	function generateRandomName($length = 8)
	{
        //$length = 8;

		//Get the random string
		for(;strlen($strName)<=$length; $strName .= chr(rand($a=ord('A'),ord('Z')) + rand()%2*(ord('a')-$a)));
		return $strName;
	}

	function createName()
	{
		do {
			$this->name = $this->generateRandomName();
		} while ( is_dir( $this->getDirTemp() ) );

		//Create Directory
		@umask(0);
		@mkdir( $this->getDirTemp(), 0777 );
	}

	function deleteName($dirPath="")
	{
		if ( $dirPath == "" ) {
			$dirPath = $this->dirBase . "/" . $this->name;
		}
                /* Try to remove the directory. If it can not manage to remove it,
                * it's probable the directory contains some files or other directories,
                * and that we must first delete them to remove the original directory.
               */
               if ( !@rmdir($dirPath) ) {// If PHP can not manage to remove the dir...
                  @chdir($dirPath);
                  $handle = @opendir($dirPath) ;
                  while ($element = @readdir($handle) ) {
		      $elementPath = $dirPath . "/" . $element;
                      if ( $element == "." || $element == "..") {
                         continue;       // skip current and parent directories
                      } elseif ( @is_file($elementPath) ) {
                         @unlink($elementPath);
                      } elseif ( @is_dir ($elementPath) ) {
			 $dirToRemove[] = $elementPath;
		      }
		}

		@closedir ($handle) ;
                if ( @sizeof($dirToRemove) > 0) {
		   foreach($dirToRemove as $j) $this->deleteName($j) ; // recursivity
		}
                @rmdir( $dirPath ) ;
	      }
	}

	function _readFromTempFile($filename)
	{
		$file = $this->getDirTemp().'/'.$filename;
		$file_content = '';
		
		//Read data from a file in temp folder
		if (@is_file($file)) {
			if (($fp = fopen($file,"rb"))) {
				$file_content = fread($fp, filesize($file));
				fclose($fp);
			} else {
				$this->_setError("System can not open file $filename in Temp folder");
			}
		} else {
			$this->_setError("File $filename do not exists in Temp folder");
		}
		
	}
	
	function _writeInTempFile($filename, $data)
	{
		//Write data in a file in temp folder
		if (($fp = fopen($this->getDirTemp().'/'.$filename,"wb"))) {
			fwrite($fp, $data);
			fclose($fp);
		} else {
			$this->_setError("System can not open file $filename in Temp folder");
		}
	}

	function _deleteTempFile($filename)
	{
		$deletefile = $this->getDirTemp().'/'.$filename;
		//Write data in a file in temp folder
		if (@is_file($deletefile)) {
			@unlink($deletefile);
		} else {
			$this->_setError("System can not delete file $filename in Temp folder");
		}
	}
}

?>
