<?php
include_once (Util::app_Path("filemanager/include/classes/filetools.class.php"));
$pclzip = MIGUELBASE_PCLZIP; 
require_once ( $pclzip . "/pclzip.lib.php");
require_once (Util::app_Path("filemanager/include/classes/dirtemp.class.php") );

class fileManager 
{
	function uploadFile(&$postFilesInfo, $zip=0)
	{
		if ( isset($postFilesInfo) ) {
			$fileName = basename( $postFilesInfo['name'] );
			$fileSize = $postFilesInfo['size'];
			$mimeType = $postFilesInfo['type'];

			$fileName = trim ($fileName);
                        $filePath = $postFilesInfo['tmp_name'];

			/**** Check for no desired characters ***/
			$fileName = fileTools::replace_dangerous_char($fileName);

			return fileTools::insertFile($fileName, $fileSize, $filePath, $mimeType);
		}
		return 3;
	}

        function uploadFileZip( &$postFilesInfo ) 
        {

            //Generate Temp Dir
           $tempDir = new dirTemp( "/Library/WebServer/Documents/migueloo" . "/var/temp/" );
           $tempDir->createName();
           $userFileTo = $postFilesInfo['tmp_name'];

           $zipContent = new PclZip($userFileTo);

           if (($list = $zipContent->extract($tempDir->getDirTemp(), "data")) == 0) {
		echo "Error : No fue posible descomprimir el archivo";
		exit();
           }

           return $list;
        }
}
?>
