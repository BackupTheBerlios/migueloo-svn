<?php

class fileTools
{
        function insertFile( $fileName, $fileSize, $userFileFrom, $mimeType="" )
        {
                /*** Try to add an extension to files witout extension ***/
                $fileNameTmp = fileTools::add_ext_on_mime($fileName, $mimeType);

                /*** Handle Scripts files ***/
                $fileNameTmp = fileTools::php2phps($fileNameTmp);
                if ( fileTools::check_name_exist( $fileNameTmp ) ) {
                        return 2;
                } else {
                        if( ! $fileName ) {
                                $fileName = $fileNameTmp;
                        }

                        //$userFileTo = "/Library/WebServer/Documents/migueloo/var/data/" . $fileName;
						$userFileTo = Util::formatPath(MIGUEL_APPDIR.'var/data/'.$fileName);
                        move_uploaded_file( $userFileFrom, $userFileTo );

                        return 0;

                }
                return 2;
        }

	function replace_dangerous_char($string)
	{
		$search[]="\/"; $replace[]="-";
		$search[]="\\"; $replace[]="-";
		$search[]="\|"; $replace[]="-";
		$search[]="\""; $replace[]="";

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
		$fileName = ereg_replace(".php$", ".phps", $fileName);
		$fileName = ereg_replace(".phtml", ".phps", $fileName);
		$fileName = ereg_replace(".asp", ".asps", $fileName);
		$fileName = ereg_replace(".pl", ".pls", $fileName);
		return $fileName;
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
		if(!ereg("([[:alnum:]]|[[[:punct:]])+\.[[:alnum:]]+$", $fileName) && $fileMimeType) {
                        /*** Build a "MIME-types/extensions" connection table ***/
                        $mimeType = array();

			$mimeType[] = "application/msword";		$extension[] =".doc";
			$mimeType[] = "application/rtf";		$extension[] =".rtf";
			$mimeType[] = "application/vnd.ms-powerpoint";	$extension[] =".ppt";
			$mimeType[] = "application/vnd.ms-excel";	$extension[] =".xls";
			$mimeType[] = "application/pdf";		$extension[] =".pdf";
			$mimeType[] = "application/postscript";		$extension[] =".ps";
			$mimeType[] = "application/mac-binhex40";	$extension[] =".hqx";
			$mimeType[] = "application/x-gzip";		$extension[] ="tar.gz";
			$mimeType[] = "application/x-shockwave-flash";	$extension[] =".swf";
			$mimeType[] = "application/x-stuffit";		$extension[] =".sit";
			$mimeType[] = "application/x-tar";		$extension[] =".tar";
			$mimeType[] = "application/zip";		$extension[] =".zip";
			$mimeType[] = "application/x-tar";		$extension[] =".tar";
			$mimeType[] = "text/html";			$extension[] =".htm";
			$mimeType[] = "text/plain";			$extension[] =".txt";
			$mimeType[] = "text/rtf";			$extension[] =".rtf";
			$mimeType[] = "image/gif";			$extension[] =".gif";
			$mimeType[] = "image/jpeg";			$extension[] =".jpg";
			$mimeType[] = "image/png";			$extension[] =".png";
			$mimeType[] = "audio/midi";			$extension[] =".mid";
			$mimeType[] = "audio/mpeg";			$extension[] =".mp3";
			$mimeType[] = "audio/x-aiff";			$extension[] =".aif";
			$mimeType[] = "audio/x-pn-realaudio";		$extension[] =".rm";
			$mimeType[] = "audio/x-pn-realaudio-plugin";	$extension[] =".rpm";
			$mimeType[] = "audio/x-wav";			$extension[] =".wav";
			$mimeType[] = "video/mpeg";			$extension[] =".mpg";
			$mimeType[] = "video/quicktime";		$extension[] =".mov";
			$mimeType[] = "video/x-msvideo";		$extension[] =".avi";


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

	function check_name_exist($fileName)
	{
                //$filePath = "/Library/WebServer/Documents/migueloo/var/data/";
		$filePath =  Util::formatPath(MIGUEL_APPDIR.'var/data/');		
				
		clearstatcache();

		if ( chdir ( dirname($filePath) ) ) {
			if ( file_exists( $fileName ) ) {
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
}
?>
