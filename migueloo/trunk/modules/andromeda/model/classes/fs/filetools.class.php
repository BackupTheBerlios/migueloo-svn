<?php
class fileTools
{
	var $baseWorkDir;
	var $baseServDir;
	/**
	* replaces some dangerous character in a string for HTML use
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - string (string) string
	* @return - the string cleaned of dangerous character
	*/

	function fileTools($baseDir, $workDir)
	{
		$this->baseServDir = $baseDir;
		$this->baseWorkDir = $baseDir . $workDir;
	}

	function replace_dangerous_char($string)
	{
		$search[]="\/"; $replace[]='-';
		$search[]="\\"; $replace[]='-';
		$search[]="\|"; $replace[]='-';
		$search[]="\""; $replace[]='';

		foreach($search as $key=>$char ) {
			$string = str_replace($char, $replace[$key], $string);
		}

		return $string;
	}

	//------------------------------------------------------------------------------

	/**
	* change the file name extension from .php to .phps
	* Useful to secure a site !!
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - fileName (string) name of a file
	* @return - the filenam phps'ized
	*/

	function php2phps ($fileName)
	{
		$fileName = ereg_replace('.php$', '.phps', $fileName);
		//Antonio: Other scripts extensions
		$fileName = ereg_replace('.phtml', '.phps', $fileName);
		$fileName = ereg_replace('.asp', '.asps', $fileName);
		$fileName = ereg_replace('.pl', '.pls', $fileName);
		return $fileName;
	}

	//------------------------------------------------------------------------------


	/**
	* Check if there is enough place to add a file on a directory
	* on the base of a maximum directory size allowed
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - fileSize (int) - size of the file in byte
	* @param  - dir (string) - Path of the directory
	*           whe the file should be added
	* @param  - maxDirSpace (int) - maximum size of the diretory in byte
	* @return - boolean true if there is enough space
	* @return - false otherwise
	*
	* @see    - enough_size() uses  dir_total_space() function
	*/

	function enough_size($fileSize, $dir, $maxDirSpace)
	{
		if ($maxDirSpace) {
			$alreadyFilledSpace = $this->dir_total_space($dir);
			if ( ($fileSize + $alreadyFilledSpace) > $maxDirSpace) {
				return -1;
			}
		}

		return $alreadyFilledSpace;
	}

	//------------------------------------------------------------------------------

	/**
	* Compute the size already occupied by a directory and is subdirectories
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - dirPath (string) - size of the file in byte
	* @return - int - return the directory size in bytes
	*/

	function dir_total_space($dirPath)
	{
		$sumSize = 0;
		@chdir ($dirPath) ;
		$handle = @opendir($dirPath);

		while ( $element = @readdir($handle) ) {
			if ( $element == '.' || $element == '..') {
				continue; // skip the current and parent directories
			}
			if ( @is_file($element) ) {
				$sumSize += filesize($element);
			}
			if ( @is_dir($element) ) {
				$dirList[] = $dirPath . '/' . $element;
			}
		}

		closedir($handle);

		if ( sizeof($dirList) > 0) {
			foreach($dirList as $j) {
				$sizeDir = $this->dir_total_space($j);	// recursivity
				$sumSize += $sizeDir;
			}
		}

		return $sumSize;
	}


	//------------------------------------------------------------------------------

	/**
	* Try to add an extension to files witout extension
	* Some applications on Macintosh computers don't add an extension to the files.
	* This subroutine try to fix this on the basis of the MIME type send
	* by the browser.
	*
	* Note : some browsers don't send the MIME Type (e.g. Netscape 4).
	*        We don't have solution for this kind of situation
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - fileName (string) - Name of the file
	* @return - fileName (string)
	*
	*/

	function add_ext_on_mime($fileName, $fileMimeType)
	{
		/*** check if the file has an extension AND if the browser has send a MIME Type ***/
		if(!ereg("([[:alnum:]]|[[[:punct:]])+\.[[:alnum:]]+$", $fileName)
			&& $fileMimeType) {
			/*** Build a "MIME-types/extensions" connection table ***/

			static $mimeType = array();

			$mimeType[] = 'application/msword';		$extension[] ='.doc';
			$mimeType[] = 'application/rtf';		$extension[] ='.rtf';
			$mimeType[] = 'application/vnd.ms-powerpoint';	$extension[] ='.ppt';
			$mimeType[] = 'application/vnd.ms-excel';	$extension[] ='.xls';
			$mimeType[] = 'application/pdf';		$extension[] ='.pdf';
			$mimeType[] = 'application/postscript';		$extension[] ='.ps';
			$mimeType[] = 'application/mac-binhex40';	$extension[] ='.hqx';
			$mimeType[] = 'application/x-gzip';		$extension[] ='tar.gz';
			$mimeType[] = 'application/x-shockwave-flash';	$extension[] ='.swf';
			$mimeType[] = 'application/x-stuffit';		$extension[] ='.sit';
			$mimeType[] = 'application/x-tar';		$extension[] ='.tar';
			$mimeType[] = 'application/zip';		$extension[] ='.zip';
			$mimeType[] = 'application/x-tar';		$extension[] ='.tar';
			$mimeType[] = 'text/html';			$extension[] ='.htm';
			$mimeType[] = 'text/plain';			$extension[] ='.txt';
			$mimeType[] = 'text/rtf';			$extension[] ='.rtf';
			$mimeType[] = 'image/gif';			$extension[] ='.gif';
			$mimeType[] = 'image/jpeg';			$extension[] ='.jpg';
			$mimeType[] = 'image/png';			$extension[] ='.png';
			$mimeType[] = 'audio/midi';			$extension[] ='.mid';
			$mimeType[] = 'audio/mpeg';			$extension[] ='.mp3';
			$mimeType[] = 'audio/x-aiff';			$extension[] ='.aif';
			$mimeType[] = 'audio/x-pn-realaudio';		$extension[] ='.rm';
			$mimeType[] = 'audio/x-pn-realaudio-plugin';	$extension[] ='.rpm';
			$mimeType[] = 'audio/x-wav';			$extension[] ='.wav';
			$mimeType[] = 'video/mpeg';			$extension[] ='.mpg';
			$mimeType[] = 'video/quicktime';		$extension[] ='.mov';
			$mimeType[] = 'video/x-msvideo';		$extension[] ='.avi';


			/*** Check if the MIME type send by the browser is in the table ***/

			foreach($mimeType as $key=>$type) {
				if ($type == $fileMimeType) {
					$fileName .=  $extension[$key];
					break;
				}
			}

			unset($mimeType, $extension, $type, $key); // Delete to eschew possible collisions
		}

		return $fileName;
	}
	//------------------------------------------------------------------------------

	/**
	* Cheks a file or a directory actually exist at this location
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - filePath (string) - path of the presume existing file or dir
	* @return - boolean TRUE if the file or the directory exists
	*           boolean FALSE otherwise.
	*/

	function check_name_exist($filePath)
	{
		clearstatcache();

		if ( @chdir ( dirname($filePath) ) ) {
			$fileName = basename ($filePath);

			if ( @file_exists( $fileName ) ) {
				return true;
			}
			else {
				return false;
			}
			return true;
		} else {
			return true;
		}
	}


	/**
	* Delete a file or a directory
	*
	* @author - Hugues Peeters
	* @param  - $file (String) - the path of file or directory to delete
	* @return - bolean - true if the delete succeed
	*           bolean - false otherwise.
	* @see    - delete() uses check_name_exist() and removeDir() functions
	*/

	function my_delete($file)
	{
		if ( $this->check_name_exist($file) ) {
			if ( @is_file($file) ) {// FILE CASE
				@unlink($file);
				return true;
			} elseif ( @is_dir($file) ) {  // DIRECTORY CASE
				$this->removeDir($file);
				return true;
			}
		} else {
			return false; // no file or directory to delete
		}

	}

	//------------------------------------------------------------------------------

	/**
	* Delete a directory and its whole content
	*
	* @author - Hugues Peeters
	* @param  - $dirPath (String) - the path of the directory to delete
	* @return - no return !
	*/


	function removeDir($dirPath)
	{

		/* Try to remove the directory. If it can not manage to remove it,
		* it's probable the directory contains some files or other directories,
		* and that we must first delete them to remove the original directory.
		*/

		if ( !@rmdir($dirPath) ) {// If PHP can not manage to remove the dir...
			@chdir($dirPath);
			$handle = @opendir($dirPath) ;

			while ($element = @readdir($handle) ) {
				if ( $element == '.' || $element == '..') {
					continue;	// skip current and parent directories
				} elseif ( @is_file($element) ) {
					@unlink($element);
				}
				elseif ( @is_dir ($element) ) {
					$dirToRemove[] = $dirPath.'/'.$element;
				}
			}

			closedir ($handle) ;

			if ( @sizeof($dirToRemove) > 0) {
				foreach($dirToRemove as $j) $this->removeDir($j) ; // recursivity
			}

			@rmdir( $dirPath ) ;
		}
	}

	//------------------------------------------------------------------------------


	/**
	* Rename a file or a directory
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - $filePath (string) - complete path of the file or the directory
	* @param  - $newFileName (string) - new name for the file or the directory
	* @return - boolean - true if succeed
	*         - boolean - false otherwise
	* @see    - rename() uses the check_name_exist() and php2phps() functions
	*/

	function my_rename($filePath, $newFileName)
	{
		$path = $this->baseWorkDir . dirname($filePath);
		$oldFileName = basename($filePath);

		if ( $this->check_name_exist( $path . '/' . $newFileName )
			&& $newFileName != $oldFileName) {
			return false;
		} else {
			/*** check if the new name has an extension ***/
			if ((!ereg("[[:print:]]+\.[[:alnum:]]+$", $newFileName))
				&& ereg("[[:print:]]+\.([[:alnum:]]+)$", $olFileName, $extension)) {

				$newFileName .= '.' . $extension[1];
			}
			/*** Prevent file name with php extension ***/
			$newFileName = $this->php2phps($newFileName);
			$newFileName = $this->replace_dangerous_char($newFileName);

			@chdir($path);
			@rename($oldFileName, $newFileName);

			return true;
		}
		return true;
	}

	//------------------------------------------------------------------------------


	/**
	* Move a file or a directory to an other area
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - $source (String) - the path of file or directory to move
	* @param  - $target (String) - the path of the new area
	* @return - bolean - true if the move succeed
	*           bolean - false otherwise.
	* @see    - move() uses check_name_exist() and copyDirTo() functions
	*/
	function move($source, $target)
	{
		if ( check_name_exist($source) ) {
			$fileName = basename($source);
			if ( check_name_exist($target.'/'.$fileName) ) {
				return false;
			} else {	/*** File case ***/
				if ( @is_file($source) ) {
					@copy($source , $target.'/'.$fileName);
					@unlink($source);
					return true;
				}
				/*** Directory case ***/
				elseif ( @is_dir($source)) {
					// check to not copy the directory inside itself
					if ( ereg('^'.$source, $target) ) {
						return false;

					} else {
						$this->copyDirTo($source, $target);
						return true;
					}
				}
			}
		} else {
			return false;
		}
	}
	//------------------------------------------------------------------------------
	/**
	* Move a directory and its content to an other area
	*
	* @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
	* @param  - $origDirPath (String) - the path of the directory to move
	* @param  - $destination (String) - the path of the new area
	* @return - no return !!
	*/

	function copyDirTo($origDirPath, $destination)
	{
		// extract directory name - create it at destination - update destination trail
		$dirName = basename($origDirPath);
		@mkdir ($destination.'/'.$dirName, 0775);
		$destinationTrail = $destination.'/'.$dirName;

		@chdir ($origDirPath) ;
		$handle = @opendir($origDirPath);

		while ($element = @readdir($handle) ) {
			if ( $element == '.' || $element == '..') {
				continue; // skip the current and parent directories
			} elseif ( @is_file($element) ) {
				@copy($element, $destinationTrail.'/'.$element);
				@unlink($element) ;
			} elseif ( @is_dir($element) ) {
				$dirToCopy[] = $origDirPath.'/'.$element;
			}
		}

		closedir($handle) ;

		if ( sizeof($dirToCopy) > 0) {
			foreach($dirToCopy as $thisDir) {
				$this->copyDirTo($thisDir, $destinationTrail);	// recursivity
			}
		}

		@rmdir ($origDirPath) ;

	}
}
?>
