<?php

/* vim: set expandtab tabstop=4 shiftwidth=4:
  +----------------------------------------------------------------------+
  | CLAROLINE version 1.3.1 $Revision: 1.3 $                             |
  +----------------------------------------------------------------------+
  | Copyright (c) 2000, 2001 Universite catholique de Louvain (UCL)      |
  +----------------------------------------------------------------------+
  | $Id: fileManageLib.inc.php,v 1.3 2004/08/06 10:23:09 chet Exp $  |
  +----------------------------------------------------------------------+
  | This source file is subject to the GENERAL PUBLIC LICENSE,           |
  | available through the world-wide-web at                              |
  | http://www.gnu.org/copyleft/gpl.html                                 |
  +----------------------------------------------------------------------+
  | Authors: Thomas Depraetere <depraetere@ipm.ucl.ac.be>                |
  |          Hugues Peeters    <peeters@ipm.ucl.ac.be>                   |
  |          Christophe Gesch�<gesche@ipm.ucl.ac.be>                    |
  | Modify by: Fernando Acero Martin <facero@teleline.es>
  |		Antonio F. Cano <antoniofcano@telefonica.net>		|
  +----------------------------------------------------------------------+
  05/09/2003 17:36 - Fix a problem showing filemanager commands when user is not logged
  19/09/2003 12:42 - antoniofcano
  	W3C standar revised
*/

/**
 * Update the file or directory path in the document db document table
 *
 * @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
 * @param  - action (string) - action type require : 'delete' or 'update'
 * @param  - oldPath (string) - old path info stored to change
 * @param  - newPath (string) - new path info to substitute
 * @desc Update the file or directory path in the document db document table
 *
 */
 // Antonio F. Cano <antoniofcano@telefonica.net>
 // Se pasa la tabla de trabajo como parametro
function update_db_info($dbTable, $action, $oldPath, $newPath="")
{
	/*** DELETE ***/
	if ($action == "delete")
	{
		$query = "DELETE FROM " . $dbTable . "
		WHERE path LIKE \"".$oldPath."%\"";
	}

	/*** UPDATE ***/
	if ($action == "update")
	{
		$query = "UPDATE " . $dbTable . "
		SET path = CONCAT(\"".$newPath."\", SUBSTRING(path, LENGTH(\"".$oldPath."\")+1) )
		WHERE path LIKE \"".$oldPath."%\"";
	}

	mysql_query($query);
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
	chdir ( dirname($filePath) );
	$fileName = basename ($filePath);

	if (file_exists( $fileName ))
	{
		return true;
	}
	else
	{
		return false;
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
	if ( check_name_exist($file) )
	{
		if ( is_file($file) ) // FILE CASE
		{
			unlink($file);
			return true;
		}

		elseif ( is_dir($file) ) // DIRECTORY CASE
		{
			removeDir($file);
			return true;
		}
	}
	else
	{
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

	if ( !@rmdir($dirPath) ) // If PHP can not manage to remove the dir...
	{
		chdir($dirPath);
		$handle = opendir($dirPath) ;

		while ($element = readdir($handle) )
		{
			if ( $element == "." || $element == "..")
			{
				continue;	// skip current and parent directories
			}
			elseif ( is_file($element) )
			{
				unlink($element);
			}
			elseif ( is_dir ($element) )
			{
				$dirToRemove[] = $dirPath."/".$element;
			}
		}

		closedir ($handle) ;

		if ( sizeof($dirToRemove) > 0)
		{
			foreach($dirToRemove as $j) removedir($j) ; // recursivity
		}

		rmdir( $dirPath ) ;
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
	$path = $baseWorkDir.dirname($filePath);
	$oldFileName = basename($filePath);

	if (check_name_exist($path."/".$newFileName)
		&& $newFileName != $oldFileName)
	{
		return false;
	}
	else
	{
		/*** check if the new name has an extension ***/
		if ((!ereg("[[:print:]]+\.[[:alnum:]]+$", $newFileName))
			&& ereg("[[:print:]]+\.([[:alnum:]]+)$", $olFileName, $extension))
		{
			$newFileName .= ".".$extension[1];
		}
		
		/*** Prevent file name with php extension ***/
		$newFileName = php2phps($newFileName);

		$newFileName = replace_dangerous_char($newFileName);

		chdir($path);
		rename($oldFileName, $newFileName);

		return true;
	}
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

//Este archivo no visualiza las variables definidas en otros modulos.
//Por ejemplo, cuando es usado por document.php las de document.inc.php.
//Por ello es necesario poner los textos directamente y no se pueden usar
//variables de idioma. Hay que estudiar la forma de solucionarlo.

function move($source, $target)
{
	if ( check_name_exist($source) )
	{
		$fileName = basename($source);
		if ( check_name_exist($target."/".$fileName) )
		{
			return false;
		}
		else
		{	/*** File case ***/
			if ( is_file($source) )
			{
				copy($source , $target."/".$fileName);
				unlink($source);
				return true;
			}
			/*** Directory case ***/
			elseif (is_dir($source))
			{
				// check to not copy the directory inside itself
				if (ereg("^".$source."*", $target))
				{
					return false;
				}
				else
				{
					copyDirTo($source, $target);
					return true;
				}
			}
		}
	}
	else
	{
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
	mkdir ($destination."/".$dirName, 0775);
	$destinationTrail = $destination."/".$dirName;

	chdir ($origDirPath) ;
	$handle = opendir($origDirPath);

	while ($element = readdir($handle) )
	{
		if ( $element == "." || $element == "..")
		{
			continue; // skip the current and parent directories
		}
		elseif ( is_file($element) )
		{
			copy($element, $destinationTrail."/".$element);
			unlink($element) ;
		}
		elseif ( is_dir($element) )
		{
			$dirToCopy[] = $origDirPath."/".$element;
		}
	}

	closedir($handle) ;

	if ( sizeof($dirToCopy) > 0)
	{
		foreach($dirToCopy as $thisDir)
		{
			copyDirTo($thisDir, $destinationTrail);	// recursivity
		}
	}

	rmdir ($origDirPath) ;

}

//------------------------------------------------------------------------------


/* NOTE: These functions batch is used to automatically build HTML forms
 * with a list of the directories contained on the course Directory.
 *
 * From a thechnical point of view, form_dir_lists calls sort_dir wich calls index_dir
 */

/**
 * Indexes all the directories and subdirectories
 * contented in a given directory
 *
 * @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
 * @param  - path (string) - directory path of the one to index
 * @return - an array containing the path of all the subdirectories
 */

function index_dir($path)
{
	chdir($path);
	$handle = opendir($path);

	// reads directory content end record subdirectoies names in $dir_array
	while ($element = readdir($handle) )
	{
		if ( $element == "." || $element == "..") continue;	// skip the current and parent directories
		if ( is_dir($element) )	 $dirArray[] = $path."/".$element;
	}

	closedir($handle) ;

	// recursive operation if subdirectories exist
	$dirNumber = sizeof($dirArray);
	if ( $dirNumber > 0 )
	{
		for ($i = 0 ; $i < $dirNumber ; $i++ )
		{
			$subDirArray = index_dir( $dirArray[$i] ) ;			    // function recursivity
			$dirArray  =  array_merge( $dirArray , $subDirArray ) ;	// data merge
		}
	}

	chdir("..") ;

	return $dirArray ;

}


/**
 * Indexes all the directories and subdirectories
 * contented in a given directory, and sort them alphabetically
 *
 * @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
 * @param  - path (string) - directory path of the one to index
 * @return - an array containing the path of all the subdirectories sorted
 *           false, if there is no directory
 * @see    - index_and_sort_dir uses the index_dir() function
 */

function index_and_sort_dir($path)
{
	$dir_list = index_dir($path);

	if ($dir_list)
	{
		sort($dir_list);
		return $dir_list;
	}
	else
	{
		return false;
	}
}


/**
 * build an html form listing all directories of a given directory
 *
 */

// Se ha aadido la variable $languaje para que pueda ver las variables de document.inc.php
function form_dir_list($sourceType, $sourceComponent, $command, $baseWorkDir, $language)
{
    //Aadido por Fernando Acero Martin
    include_once("../lang/english/trad4all.inc.php");
    include_once("../lang/$language/trad4all.inc.php");
    include_once("../lang/english/document.inc.php");
    include_once("../lang/$language/document.inc.php");
    //Fin del aadido

	$dirList = index_and_sort_dir($baseWorkDir);

	$dialogBox .= "<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\">\n" ;
	$dialogBox .= "<input type=\"hidden\" name=\"$sourceType\" value=\"$sourceComponent\">\n" ;
	$dialogBox .= "$langMove ".$sourceComponent." $langTo: \n" ;
	$dialogBox .= "<select name=\"$command\">\n" ;
	$dialogBox .= "<option value=\"\" style=\"color:#999999\">Ra&iacute;z\n";

	$bwdLen = strlen($baseWorkDir) ;	// base directories lenght, used under

	/* build html form inputs */

	if ($dirList)
	{
		while (list( , $pathValue) = each($dirList) )
		{

			$pathValue = substr ( $pathValue , $bwdLen );		// truncate cunfidential informations confidentielles
			$dirname = basename ($pathValue);					// extract $pathValue directory name du nom

			/* compute de the display tab */

			$tab = "";					// $tab reinitialisation
			$depth = substr_count($pathValue, "/");		// The number of nombre '/' indicates the directory deepness
			for ($h=0; $h<$depth; $h++)
			{
				$tab .= "&nbsp;&nbsp";
			}
			$dialogBox .= "<option value=\"$pathValue\">$tab>$dirname\n";
		}
	}

	$dialogBox .= "</select>\n";
	$dialogBox .= "<input type=\"submit\" value=\"$langOk\">";
	$dialogBox .= "</form>\n";

	return $dialogBox;
}
//------------------------------------------------------------------------------

/**
 * Display Update Form.
 *
 * @author - Antonio F. Cano <antoniofcano AT telefonica DOT net >
 * @param  - path (string) - directory path of the one to index
 */
function form_upload($webDir, $pathServer, $language, $submitGroupWorkUrl="", $extended=true, $zip=false)
{
    //Aadido por Fernando Acero Martin
    include("$webDir/miguel/lang/spanish/trad4all.inc.php");
    include("$webDir/miguel/lang/$language/trad4all.inc.php");
    include("$webDir/miguel/lang/spanish/document.inc.php");
    include("$webDir/miguel/lang/$language/work.inc.php");

	echo	"<table><form method=\"POST\" action=\"" . $_SERVER[PHP_SELF] . "\" enctype=\"multipart/form-data\" >";

	if (isset($submitGroupWorkUrl) && $submitGroupWorkUrl) {// Si el usuario está publicando desde el espacio de trabajo d su Grupo
		$realpath = str_replace ($webDir, $pathServer, str_replace("\\", "/", realpath($submitGroupWorkUrl) ) ) ;
		echo	"
		<tr>
			<td>
				<input type=\"hidden\" name=\"userFile\"  value=\"$realpath\">
				<font size=2 face='arial, helvetica'>$langDocument:</font>
			</td>
			<td>
				<a href=\"$submitGroupWorkUrl\">
				<font size=2 face='arial, helvetica'>" . basename($realpath) . "</font></a>
			</td>
		</tr>";
	} else { // else Subida de archivos estandar.
		echo	"
		<tr>
			<td>$langDownloadFile:</td>
			<td><input type=\"file\" name=\"userFile\" size=\"20\"></td>
		</tr>";
	}
	if ( $extended ) {
		//Indetec: Utilizamos el formulario de Document.php, ajustando las variables.
		if ( !isset($titreFile) ) {
			$titreFile ="";
		}
		if ( !isset($commentFile) ) {
			$commentFile ="";
		}

		echo	"
			<tr>
				<td>$langTitleWork:</td>
				<td>
					<input type=\"text\" name=\"titreFile\" value=\"$titre\" size=\"30\">
				</td>
			</tr>
			<tr>
				<td valign=\"top\">$langComment:</td>
				<td>
					<textarea name=\"commentFile\" cols=\"30\" rows=\"3\">
					$commentFile
					</textarea>
				</td>
			</tr>";
	}
	if ( $zip ) {
		echo "<tr><td><input type=\"checkbox\" name=\"zip\" value=\"1\">$langUncompress</td></tr>";
	}
	echo   "<tr>
			<td colspan=\"2\" align=\"right\">
				<input type=\"Submit\" name=\"submit\" value=\"$langOk\">
			</td>
		</tr>";
	echo "</form></table>";
}

function fileManageDisplayHead($webDir, &$fileManage, $language, $lock=false)
{
    //Aadido por Fernando Acero Martin
    include("$webDir/miguel/lang/spanish/trad4all.inc.php");
    include("$webDir/miguel/lang/$language/trad4all.inc.php");
    include("$webDir/miguel/lang/spanish/document.inc.php");
    include("$webDir/miguel/lang/$language/document.inc.php");


    //Fin del aadido
	echo "<tr>\n";
	echo "<td colspan=8>\n";

	/*** go to parent directory ***/
	if ( $fileManage->getDir() != "" ) { // if the $curDirName is empty, we're in the root point and we can't go to a parent dir
		echo "<!-- parent dir -->\n";
		echo "<a href=\"" . $_SERVER[PHP_SELF] . "?openDir=" . $fileManage->getParentDir() . "\">\n";
		echo "<img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/parentdir.png\" border=\"0\" align=\"absbottom\" hspace=\"5\" alt=\"$langUp\" title=\"$langToolTipParentDir\">\n";
		echo "<small>$langUp</small>\n";
		echo "</a>\n";
	}

	if( $fileManage->getAdmin() ) {   // if teacher
		/*** create directory ***/
		echo "<!-- create dir -->\n";
		echo "<a href=\"" . $_SERVER[PHP_SELF] . "?createDir=" . $fileManage->getDir() . "\">";
		echo "<img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/adddir.png\" border=\"0\" align=\"absbottom\" hspace=\"5\" alt=\"$langCreateDir\" title=\"$langToolTipAddDir\">";
		echo "<small> $langCreateDir</small>";
		echo "</a>";
	}

	echo "</tr>\n";
	echo "</td>\n";

	if ( $fileManage->getDir() != "") { // if the $curDirName is empty, we're in the root point and there is'nt a dir name to display
		/*** current directory ***/
		echo "<!-- current dir name -->\n";
		echo "<tr>\n";
		echo "<td colspan=\"9\" align=\"left\" class=\"colorDark\">\n";
		echo "<img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/opendir.png\" align=\"absbottom\" vspace=\"2\" hspace=\"5\">\n";
		echo "<font color=\"#CCCCCC\">" . $fileManage->getDir() . "</font>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}

	echo "<tr class=\"color2-bg\"  align=\"center\" valign=\"top\">
	      <td>$langName</td>
	      <td>$langSize</td>
	      <td>$langDate</td>
	      <td>$langDelete</td>
	      <td>$langMove</td>
	      <td>$langRename</td>
	      <td>$langComment</td>
	      <td>$langVisible</td>";
	if ($lock) {
	     echo "<td>$langLock</td>";
	}
 	echo "</tr>";
}

function fileManageDisplayDir(&$fileManage, $is_adminOfCourse, $language, $webDir)
{
    //Aadido por Fernando Acero Martin
    include("$webDir/miguel/lang/spanish/trad4all.inc.php");
    include("$webDir/miguel/lang/$language/trad4all.inc.php");
    include("$webDir/miguel/lang/spanish/document.inc.php");
    include("$webDir/miguel/lang/$language/document.inc.php");
                    
	$lDirListCount = count( $fileManage->dirList );
    for ($i = 0 ; $i < $lDirListCount ; $i++) {
		$dirName = $fileManage->dirList[$i]['titre'];
		$dirPath = $fileManage->dirList[$i]['file'];
		$dirId = $fileManage->dirList[$i]['id'];
		$dspDirName = htmlentities( $dirName );
		$cmdDirName = rawurlencode($fileManage->getDir() . $curDirpath . "/" . $dirPath);
		$dirComment = $fileManage->dirList[$i]['comment'];
		$dirVisibility = $fileManage->dirList[$i]['visibility'];

		if ( $dirVisibility == "i" ) {
			$style=" class=\"invisible\"";
			if ( !$is_adminOfCourse ) {
				continue;
			}
		}
		else {
			$style="";
		}

		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">\n";
		echo "<a href=\"" . $_SERVER[PHP_SELF] . "?openDir=$cmdDirName\" $style>\n";
		echo "<img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/folder.png\" border=\"0\" hspace=\"5\" alt=\"\">\n";
		echo $dspDirName."\n";
		echo "</a>\n";

		/*** skip display date and time ***/
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		if( $is_adminOfCourse ) //Only teachers can create/modify directories
		{
			/*** delete command ***/
			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?delete=$dirId\" onClick=\"return confirmation('" . addslashes($dspDirName) . "');\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/delete.png\" border=\"0\" alt=\"$langDelete\" title=\"$langToolTipDelete\"></a></td>\n";
			/*** copy command ***/
			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?move=$dirId\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/move.png\" border=\"0\" alt=\"$langMove\" title=\"$langToolTipMove\"></a></td>\n";
			/*** rename command ***/
			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?rename=$dirId\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/rename.png\" border=\"0\" alt=\"$langRename\" title=\"$langToolTipRename\"></a></td>\n";
			/*** comment command ***/
			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?comment=$dirId\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/comment.png\" border=\"0\" alt=\"$langComment\" title=\"$langToolTipComment\"></a></td>\n";

			/*** visibility command ***/
			if ( $dirVisibility == "i") {
				echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkVisibl=$dirId\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/invisible.png\" border =\"0\" alt=\"$langVisible\" title=\"$langToolTipInvisible\"></a>\n</td>\n";
			} else {
				echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkInvisibl=$dirId\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/visible.png\" border=\"0\" alt=\"$langVisible\" title=\"$langToolTipVisible\"></a></td>\n";
			}
		} else {
			echo "<td><td><td><td><td><td>";
		}

		echo "</tr>\n";

		/*** comments ***/
		if ( $dirComment != "" ) {
			$dirComment = htmlentities( $dirComment );
			$dirComment = nl2br( $dirComment );

			echo "<tr align=\"left\">\n";
			echo "<td colspan=\"8\">\n";
			echo "<div class=\"comment\">";
			echo $dirComment;
			echo "</div>\n";
			echo "</td>\n";
			echo "</tr>\n";
		}
	}
}

function fileManageDisplayFile(&$fileManage, $uid, $is_adminOfCourse, $lock, $language, $webDir )
{
    //Aadido por Fernando Acero Martin
    include("$webDir/miguel/lang/spanish/trad4all.inc.php");
    include("$webDir/miguel/lang/$language/trad4all.inc.php");
    include("$webDir/miguel/lang/spanish/document.inc.php");
    include("$webDir/miguel/lang/$language/document.inc.php");
                        
	$lFileListCount = count( $fileManage->fileList );
	for ($i = 0 ; $i < $lFileListCount ; $i++) {
		$cmdFileName = $fileManage->fileList[$i]['id'];
		$image       = choose_image( $fileManage->fileList[$i]['titre'] );
		$size        = format_file_size( $fileManage->fileList[$i]['size'] );
		$date        = format_date( $fileManage->fileList[$i]['date'] );
		$pathFileName = format_url( $GLOBALS[currentCourseID] . "/" . $fileManage->modName . $fileManage->fileList[$i]['path'] );
		$dspFileName = htmlentities( $fileManage->fileList[$i]['titre'] );
		$commentFile = $fileManage->fileList[$i]['comment'];
		$visibilityStatus = $fileManage->fileList[$i]['visibility'];

		if ( $fileManage->modName != "document" ) {
			$lockStatus = $fileManage->fileList[$i]['lock'];
			$UIDFile = $fileManage->fileList[$i]['uid'];
			$GIDFile = $fileManage->fileList[$i]['gid'];
		} else {
			$lockStatus = 1;
		}

		//Indetec: Elige el estilo de la tupla en función d la visibilidad y el bloqueo.
		if ($visibilityStatus == "i") {
			$style=" class=\"invisible\"";
			//Si no somos administradores o dueños y es una tupla invisible pasamos a la siguiente
			if ( (!$is_adminOfCourse) && ($uid != $UIDFile) && ($GIDFile != $fileManage->gid) ) {
				continue;
			}
		} else {
			$style="";
		}

		echo "<tr align=\"center\"$style>\n";
		echo "<td align=\"left\">\n";
		echo "<a href=\"" . $GLOBALS[urlServer] . $pathFileName . "\" $style target=\"top\">\n";
		echo "<img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/$image\" border=\"0\" hspace=\"5\" alt=\"\">\n";
		echo $dspFileName."\n";
		echo "</a>\n";

		/*** size ***/
		echo "<td><small>$size</small></td>\n";
		/*** date ***/
		echo "<td><small>$date</small></td>\n";

        if ( isset($uid) ) {
    		/*** delete command ***/
    		//Indetec: Solo puede borrar si no está bloqueado y es el dueño o es el administrador del curso(profesor).
    		if ( ($lockStatus == 1) && ( ($GIDFile == $fileManage->gid) || ($UIDFile == $uid) || ($is_adminOfCourse))) {
    			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?delete=$cmdFileName\" onClick=\"return confirmation('" . addslashes($dspFileName) . "');\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/delete.png\" border=\"0\" alt=\"$langDelete\" title=\"$langToolTipDelete\"></a></td>\n";
    		} else {
    			echo "<td></td>";
    		}

    		if ( ($lockStatus == 1) && ($is_adminOfCourse) ) {
    			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?move=$cmdFileName\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/move.png\" border=\"0\" alt=\"$langMove\" title=\"$langToolTipMove\"></a></td>\n";
    		} else {
    			echo "</td><td>";
    		}
    		//Indetec: En caso de no estar bloqueado y ser dueño o ser profesor
    		if (($lockStatus == 1) && ( ($GIDFile == $fileManage->gid) || ($UIDFile == $uid) || ($is_adminOfCourse) )) {
    			/*** rename command ***/
    			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?rename=$cmdFileName\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/rename.png\" border=\"0\" alt=\"$langRename\" title=\"$langToolTipRename\"></a></td>\n";
    			/*** comment command ***/
    			echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?comment=$cmdFileName\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/comment.png\" border=\"0\" alt=\"$langComment\" title=\"$langToolTipComment\"></a></td>\n";
    		} else {
    			echo "<td><td>";
    		}

    		if($is_adminOfCourse) {   // if theache
    			/*** visibility command ***/
    			if ( $visibilityStatus == "i") {
    				echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkVisibl=$cmdFileName\"><img src=\"" .$GLOBALS[urlServer] . "/miguel/image/filemanager/invisible.png\" border=\"0\" alt=\"$langVisible\" title=\"$langToolTipVisible\"></a>\n</td>\n";
    			} else {
    				echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkInvisibl=$cmdFileName\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/visible.png\" border=\"0\" alt=\"$langInvisible\" title=\"$langToolTipInvisible\"></a></td>\n";
    			}

    			/*** Indetec: Lock command ***/
    			if ( $lock ){
    				if ( $lockStatus == 1) {
    					echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkUnLock=$cmdFileName\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/lock.png\" border=\"0\" alt=\"$langLock\" title=\"$langToolTipUnlock\"></a>\n</td>\n";
    				} else {
    					echo "<td><a href=\"" . $_SERVER[PHP_SELF] . "?mkLock=".$cmdFileName."\"><img src=\"" . $GLOBALS[urlServer] . "/miguel/image/filemanager/unlock.png\" border=\"0\" alt=\"$langUnlock\" title=\"$langToolTipLock\"></a></td>\n";   				}
    			}
    		} else {
    			echo "<td><td>";
    		}
        } else {
            echo "<td colspan=\"5\"></td>";
        }
		echo "</tr>\n";
		/*** comments ***/
		if ( $commentFile != "" ) {
			$commentFile = htmlentities($commentFile);
			$commentFile = nl2br($commentFile);

			echo "<tr align=\"left\">\n";
			echo "<td colspan=\"8\">\n";
			echo "<div class=\"comment\">";
			echo $commentFile;
			echo "</div>\n";
			echo "</td>\n";
			echo "</tr>\n";
		}
	}
}
?>
