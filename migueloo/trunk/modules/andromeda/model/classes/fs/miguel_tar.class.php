<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       | 
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |      
      +----------------------------------------------------------------------+
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

include_once "./include/mbt_config.php";

require_once mbt_Path("classes/tar.class.php");
//require_once miguel_Path("miguel/admin/miniXML/minixml.inc.php");


/**
  * class mBT_Directory
  * 
  */

class mBT_Tar extends tar
{

  	/**Attributes: */
	/**
      * 
      */
    var $error 			= '';
    /**
      * 
      */
    var $bError 		= FALSE;    
    
 
	/**Methods: public*/
  
	/**
 	  *
 	  */
 	function mBT_Tar()
 	{  
    	$this->_clearError();
    	$this->tar();
  	} 
	
	function clearTar()
	{
			$filename 		= '';
			$isGzipped 		= '';
			$tar_file		= '';
			$files			= '';
			$directories	= '';
			$numFiles		= '';
			$numDirectories	= '';
	}
	
	function addRecurseDirectory($dirname) 
	{
		$curdir = getcwd();
		@chdir(dirname($dirname));
		
		$filelist = array();

		if(@is_dir($dirname)) {
			$temp = $this->_parsedirectories(basename($dirname));
			foreach($temp as $filename) {
				//echo "fichero: $filename <br>\n";
				$filelist[] = $filename;
			}
		} else {
			$this->_setError("mBT_Tar: $dirname in not a directory");
		}
		
		$this->addfiles($filelist);
		
		@chdir($curdir);
	}
	
	function addTotalRecurseDirectory($dirname) 
	{
		$filelist = array();

		if(@is_dir($dirname)) {
			$temp = $this->_parsedirectories($dirname);
			foreach($temp as $filename) {
				$filelist[] = $filename;
			}
		} else {
			$this->_setError("mBT_Tar: $dirname in not a directory");
		}
		
		$this->addfiles($filelist);
	}


	/**
   	  * 
   	  */
	function writeNewTar($filename)
	{
		$useGzip = false;
		
		if(function_exists("gzencode")) {
				$useGzip = true;
				//$filename .= '.gz';
		}
		
		$this->toTar($filename,$useGzip);	
	}
	
	/**
  	  *
  	  */
	function addFiles($filelist) 
	{
		foreach($filelist as $current) {
			$this->addFile($current);
		}
	}
	
	/**
	  *
	  */
	function getTarContents() 
	{		
		if($this->numFiles > 0) {
			$file_list = array();
			foreach($this->files as $key => $information) {
				$file_list[] = $information["name"];
			}
		} else {
			$file_list = '';
		}

		return $file_list;
	}
	
	/**
	  *
	  */
	function getTarTree() 
	{		
		$dir_list = array();
		$i = 0;
		
		if($this->numFiles > 0) {
			foreach($this->files as $key => $information) {
				$dir_list[$i]['name'] = dirname($information["name"]);
				$dir_list[$i]['mode'] = '0'.substr($information["mode"], 3, 4);
				$i++;
			}
		} 
		
		if($this->numDirectories > 0) {
			foreach($this->directories as $key => $information) {	
				$dir_list[$i]['name'] = $information["name"];
				$dir_list[$i]['mode'] = '0'.substr($information["mode"], 3, 4);
				$i++;
			}
		} 
		
		sort($dir_list);
		
		$comp = '';

		for($i=0; $i < count($dir_list); $i++) {
			if ($comp != $dir_list[$i]['name']) {
				$ret_list[] = $dir_list[$i];
				$comp = $dir_list[$i]['name'];
			}			
		}
		
		//sort($ret_list);
		
		return $ret_list;
	}
	
	/**
	  *
	  */
	function extractTarFile($dest_folder) 
	{	
		$tardirs = $this->getTarTree();
		
		for($i=0; $i < count($tardirs); $i++) {
			if (!file_exists($dest_folder.$tardirs[$i]['name'])) {
				//Force mode to 0777 for all directories
				//@mkdir($dest_folder.$tardirs[$i]['name'], $mode = $tardirs[$i]['mode']);
				@mkdir($dest_folder.$tardirs[$i]['name'], 0777);
			}			
		}
		
		$tarfiles = $this->getTarContents();
		
		for($i=0; $i < count($tarfiles); $i++) {
			if (!file_exists($dest_folder.$tarfiles[$i])) {
				$this->extractFile($tarfiles[$i], $dest_folder);
			}			
		}
		

	}
	
	/**
	  *
	  */
	function extractFile($filename, $dest_folder) 
	{
		//Check if file exists in tar file
		if ($this->containsFile($filename)) {
			//Gets file contents
			$file_info = $this->getFile($filename);
			
			//Writes file into $folder
			$fp = fopen($dest_folder.$filename,"wb");
			fwrite($fp,$file_info['file']);
			fclose($fp);
		} else {
			$this->_setError("mBT_Tar: file $filename no exists into tar file");
		}
	}
	
	/**
  	  *
  	  */
	function hasError()
	{
		return $this->bError;
	}
	
	/** 
	  *
	  */
	function getError()
	{
		return $this->error;
	}
	
	
 	/** Methods: private */
	
	/**
      * 
      */
	function _readDir($folder)
	{
		// Open target directory
		$dh = opendir(realpath($folder));
		
		// Read target directory
		while ($file = readdir($dh))
		{
			//If file not is '.' or '..', procces it
			if (($file !=".") && ($file !="..")) { 
				//Make file name as /path_to_$folder/$file
				$file = miguel_formatPath($folder.'/'.$file);
				
				// Process file
				if (is_file(realpath("$file"))) {
					$this->files_array[] 	= realpath("$file");
				} elseif (is_dir(realpath("$file"))) {
					$this->dir_array[] 		= realpath("$file");
				} else {
					$this->files_error[] 	= realpath("$file");
				}
			}
		}
		
		// Close target directory
		closedir($dh);
	}
	

	/**
	  *
	  */
	function _setError($error)
	{
		$this->error  = $error;	 
		$this->bError = TRUE;
	}
	
	/**
	  *
	  */
	function _clearError()
	{
		$this->error  = '';	 
		$this->bError = FALSE;
	}
	
	/**
	  *
	  */
	function _parsedirectories($dirname) 
	{
		$filelist = array();
		$dir = @opendir($dirname);

		while($file = @readdir($dir)) {
			if($file == "." || $file == "..")
				continue;
			else if(@is_dir($dirname."/".$file)) {
				$temp = $this->_parsedirectories($dirname."/".$file);
				if (count($temp) == 0) {
					$this->addDirectory($dirname."/".$file);
				} else {
					foreach($temp as $file2) {
						$filelist[] = $file2;
					}
				}
			}
			else if(@file_exists($dirname."/".$file))
				$filelist[] = $dirname."/".$file;
		}

		@closedir($dir);

		return $filelist;
	}
}
?>
