<?php
/*
    +----------------------------------------------------------------------+
    | Miguel file manager class                                            |
    +----------------------------------------------------------------------+
    | This software is part of Miguel    version 0.1.0 $Revision: 1.3 $    |
    +----------------------------------------------------------------------+
    | Copyright (c) 2003, 2004 Asociacion Hispalinux                       |
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
	|         Jesús Martínez <jamarcer at inicia dot es>                   |
    +----------------------------------------------------------------------+

  Fecha ultima modificacion:
  	11/05/2003	01:36
	12/05/2003	13:30
	16/05/2003	00:50
	11/09/2003 23:40 - antoniofcano
		- Make a private method with insertFile and insertDirectory
		- Insert upload zip files
		- Fix a security problem in changeDir with '..' paths
*/
@require_once ("filetools.class.php");
@require_once ("pclzip/pclzip.lib.php");
@require_once ("miguel_dirtemp.class.php");

class fileManager extends fileTools
{
	var $modName = '';
	var $courseId = '';

	var $currentDir = '';
	var $parentDir = '';

	var $maxFilledSpace = 0;

	var $dbTable = '';
	var $hdDataBase = NULL;

	var $dirList = NULL;
	var $fileList = NULL;

	var $uid;
	var $gid;
	var $isAdmin=false;

	function fileManager( $modName, $modTable, &$connexion, $currentCourseID, $webDir, $uid, $isAdmin)
	{
		$this->modName		= $modName;
		$this->dbTable		= $modTable;
		$this->hdDataBase	= $connexion;
		$this->courseId		= $currentCourseID;

		/**************************************
		FILEMANAGER BASIC VARIABLES DEFINITION
		**************************************/
		if ( $this->modName == "document" ) {
			$dirMod = "document";
		} else {
			$dirMod = "work";
		}

		$this->fileTools($webDir, 'course_'."$currentCourseID/$dirMod/");

		$this->currentDir = "";
		$this->parentDir = "";

		$this->uid = $uid;
		$this->isAdmin = $isAdmin;

		$strSQL = "SELECT team FROM user_group WHERE user='$uid'";
		$findTeamUser = mysql_query( $strSQL, $this->hdDataBase );
		if ($findTeamUser) {
			while ( $myTeamUser = mysql_fetch_array($findTeamUser, MYSQL_ASSOC) ) {
				$this->gid = $myTeamUser['team'];
			}
		}
	}

	function setMaxFilledSpace( $size )
	{
		if ( isset($size) && ($size != "") ) {
			$this->maxFilledSpace = $size;
			return 0;
		}
		return 3;
	}

	function getNameById($idFile)
	{
		if ( isset($idFile) && ($idFile !="") ) {
			$workName = "";
			$strSQL = "SELECT path FROM " . $this->dbTable . " WHERE id=$idFile";

			$result = mysql_query( $strSQL, $this->hdDataBase );
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$workName = $row['path'];
			}
			return $workName;
		}
	}

	function uploadFile(&$userFileFrom, &$postFilesInfo, $uploadPath, $titre="", $comment="", $gid=0, $zip=0)
	{
		if ( isset($userFileFrom) && isset($postFilesInfo) && isset($uploadPath) ) {
			$fileName = basename( $postFilesInfo['userFile']['name'] );
			$fileSize = $postFilesInfo['userFile']['size'];
			$mimeType = $postFilesInfo['userFile']['type'];

			$fileName = trim ($fileName);

			/**** Check for no desired characters ***/
			$fileName = $this->replace_dangerous_char($fileName);

			if ( isset($zip) && ($zip != 0 ) ) {
				//Generate Temp Dir
				$tempDir = new miguel_DirTemp( $this->baseServDir . "/var/lib/temp/" );
				$tempDir->createName();

				$userFileTo = $tempDir->getDirTemp() . "/" . $fileName;

				move_uploaded_file( $userFileFrom, $userFileTo )
				or die("<tr><td colspan=\"2\">\n
				<font size=\"2\" face=\"arial, helvetica\">Nop:$langImposible</font>\n
				</td></tr>\n
				</table>");
				$zipContent = new PclZip($userFileTo);

				$tempDirZip = new miguel_DirTemp( $tempDir->getDirTemp() );
				$tempDirZip->createName();
				if (($list = $zipContent->extract($tempDirZip->getDirTemp(), "data")) == 0) {
					echo "Error : No fue posible descomprimir el archivo";
					@include_once('miguel_footer.php');
					exit();
				}

				for ($i=0; $i<sizeof($list); $i++) {
					$zipUncompressedSize = 0;
					$zipUncompressedSize += $list[$i][size];
				}

				$this->createDir("", $fileName, 0);
				$error =  $this->_insertDirectory($tempDirZip->getDirTemp(), "/" . $fileName, $zipUncompressedSize);
				$tempDir->deleteName();
				return $error;
			}
			return ( $this->_insertFile($fileName, $fileSize, $userFileFrom, $uploadPath, $comment, $titre, $gid, $mimeType) );
		}
		return 3;
	}

	function uploadFromGroupFile($userFile, $comment, $titre, $uploadPath, $gid)
	{
		if ( isset($userFile) && isset($uploadPath) && isset($titre) && isset($comment) && ($gid != "") && isset($gid) ) {
			$nameFile = basename($userFile);

			$path= $this->baseWorkDir . $uploadPath . $nameFile;

			if( ! $titre ) {
				$titre = $nameFile;
			}
			//Moves from Group Directory to Document one.
			if ( $this->move($this->baseServDir . $userFile, $this->baseWorkDir . $uploadPath) ) {
				$strSQL ="INSERT INTO " . $this->dbTable . " (id, path, titre, comment, uid, visibility, accepted, gid)
					VALUES ('', '$uploadpath/$nameFile', '" . trim($titre) . "', '" . trim($comment) . "', '" . $this->uid . "', 'i', '1', '$gid')";
				mysql_query($strSQL, $this->hdDataBase);
				return 0;
			} else {
				return 1;
			}
		}
		return 3;
	}

	function deleteFile($idFile)
	{
		if ( isset($idFile) && ($idFile != "") ) {
			if ( $this->_permModify( $idFile ) ) {
				$name = $this->getNameById( $idFile );
				if ( $this->my_delete( $this->baseWorkDir . $name ) ) {
					$strSQL = "DELETE FROM " . $this->dbTable
						. " WHERE path LIKE \"$name%\"";

					if ( !$this->isAdmin ) {
						$strSQL .= " AND uid= " . $this->uid;
					}

					mysql_query($strSQL, $this->hdDataBase);
					return 0;
				}
			}
		}
		return 3;
	}

	function renameFile($idFile, $renameTo)
	{
		if ( isset($idFile) && ($idFile != "") && isset($renameTo) && ($renameTo != "") ) {
			if ( $this->_permModify( $idFile ) ) {
				$sourceFile = $this->getNameById($idFile);
				if ( $this->my_rename($sourceFile, $renameTo) ) {
					//Indetec: Controlamos el cambio de nombres en el directorio raiz.
					$path = "";
					if (dirname($sourceFile) != "/") {
						$path = dirname($sourceFile);
					}

					$strSQL = "UPDATE " . $this->dbTable .
						" SET path = CONCAT(\"$path/$renameTo\", SUBSTRING(path, LENGTH(\"$sourceFile\")+1) )
						WHERE path LIKE \"$sourceFile%\"";

					if ( !$this->isAdmin ) {
						$strSQL .= " AND uid= " . $this->uid;
					}

					mysql_query($strSQL, $this->hdDataBase);

					return 0;
				} else {
					return 1;
				}
			}
		}
		return 3;
	}

	function getComment($idFile)
	{
		if ( isset($idFile) && ($idFile != "") ) {
			$strSQL = "SELECT comment FROM " . $this->dbTable . " WHERE id = $idFile";
			$result = mysql_query ( $strSQL, $this->hdDataBase );

			$strComment = "";
			while( $row = mysql_fetch_array($result, MYSQL_ASSOC) )
				$strComment = $row['comment'];

			return $strComment;
		}
	}

	function setComment($idFile, $comment)
	{
		if ( isset($idFile) && ($idFile != "") && isset($comment)  ) {
			if ( $this->_permModify( $idFile ) ) {
				$strSQL = "UPDATE " . $this->dbTable . " SET comment='$comment' WHERE id=$idFile";
				if ( !$this->isAdmin ) {
					$strSQL .= " AND uid= " . $this->uid;
				}

				mysql_query( $strSQL, $this->hdDataBase );
				return 0;
			}
		}
		return 3;
	}

	function moveFile($idFile, $moveTo)
	{
		if ( isset($idFile) && ($idFile != "") && isset($moveTo) ) {
			if ( $this->_permModify( $idFile ) ) {
				$sourceFile = $this->getNameById($idFile);

				if ( $this->move($this->baseWorkDir . $sourceFile, $this->baseWorkDir . $moveTo) ) {
					$strSQL = "UPDATE " . $this->dbTable .
						" SET path = CONCAT(\"$moveTo/" . basename($sourceFile) . "\", SUBSTRING(path, LENGTH(\"$sourceFile\")+1) )
						WHERE path LIKE \"$sourceFile%\"";
					if ( !$this->isAdmin ) {
						$strSQL .= " AND uid= " . $this->uid;
					}
					mysql_query( $strSQL, $this->hdDataBase );
					return 0;
				} else {
					return 1;
				}
			}
		}
		return 3;
	}

	function visibilityFile( $idFile, $visibilityStatus )
	{
		if ( (isset($idFile)) && ($idFile != "") && ( isset($visibilityStatus) && ( ($visibilityStatus != "v") || ($visibilityStatus != "i") ) ) ) {
			if ( $this->_permModify( $idFile ) ) {
				$strSQL = "UPDATE " . $this->dbTable . " SET visibility='$visibilityStatus' WHERE id=$idFile";
				if ( !$this->isAdmin ) {
					$strSQL .= " AND uid= " . $this->uid;
				}
				mysql_query( $strSQL, $this->hdDataBase );

				return 0;
			}
		}
		return 3;
	}

	function lockFile( $idFile, $lockStatus )
	{
		if ( (isset($idFile)) && ($idFile != "") && ( isset($lockStatus) && ( ($lockStatus != "1") || ($lockStatus != "0") ) ) ) {
			if ( $this->_permModify( $idFile ) ) {
				$strSQL = "UPDATE " . $this->dbTable . " SET accepted='$lockStatus' WHERE id=$idFile";
				if ( !$this->isAdmin ) {
					$strSQL .= " AND uid= " . $this->uid;
				}
				mysql_query( $strSQL, $this->hdDataBase );

				return 0;
			}
		}
		return 3;
	}

	function getDir()
	{
		return $this->currentDir;
	}

	function setDir( $newDir )
	{
		if ( isset($newDir) ) {
			$this->currentDir = $newDir;
			return 0;
		}
		return 3;
	}

	function getParentDir()
	{
		return $this->parentDir;
	}

	function setParentDir( $newDir )
	{
		if ( isset( $newDir ) ) {
			$this->parentDir = $newDir;
			return 0;
		}
		return 3;
	}

	function changeDir( $newDir )
	{
		if ( isset($newDir) ) {
			$this->currentDir .= $newDir;
			if ( $this->currentDir == "." || $this->currentDir == "/" || $this->currentDir == "\\" || ereg("\.\.", $this->currentDir) ) {
				$this->currentDir = ""; // manage the root directory problem
			}

			//$this->currentDir = basename($this->currentDir);
			$this->parentDir = dirname($this->currentDir);

			if ( $this->parentDir == "." || $this->parentDir == "/" || $this->parentDir == "\\" ) {
				$this->parentDir = ""; // manage the root directory problem
			}
			return 0;
		}
		return 3;
	}

	function createDir( $dirPath, $dirName, $gid = 0 )
	{
		if ( isset($dirPath) && isset($dirName) && ($dirName != "") ) {
			if ($this->isAdmin) {
				$newDirName = $this->replace_dangerous_char( $dirName );
				if ( $this->check_name_exist($this->baseWorkDir . $dirPath . "/" . $newDirName) ) {
					return 1;
				} else {
					@mkdir($this->baseWorkDir . $dirPath . "/" . $newDirName, 0700);

					$titre = $newDirName;
					$path= $dirPath . "/" . $newDirName;
					if ( $this->modName != "document" ) {
						$strSQL ="INSERT INTO " . $this->dbTable . " (id, path, titre, comment, uid, visibility, accepted, gid) VALUES ('', '$path', '$titre', '', '" . $this->uid . "', 'i', '0',$gid)";
					} else {
						$strSQL = "INSERT INTO " . $this->dbTable . " (id, path, comment, visibility) VALUES ('','$path','','i')";
					}
					mysql_query($strSQL, $this->hdDataBase);
				}
				return 0;
			}
		}
		return 3;
	}

	function loadDir( $curDirpath = "") {
		/*----------------------------------------
		SEARCHING FILES & DIRECTORIES INFOS
			ON THE DB
		--------------------------------------*/
		if ( !isset($curDirpath) || $curDirpath == "" ) {
			$loadDirPath = $this->currentDir;
		} else {
			$loadDirPath = $curDirpath;
		}
		/*** Search infos in the DB about the current directory the user is in ***/
		$strSQL = "SELECT id, path, comment, visibility";
		if ($this->modName == "work") {
			$strSQL .= ", titre, accepted, uid, gid";
		}
		$strSQL .= " FROM " . $this->dbTable
			   . " WHERE (path LIKE \"$loadDirPath/%\") AND (path NOT LIKE \"$loadDirPath/%/%\")";

		$result = mysql_query ($strSQL, $this->hdDataBase);

		while( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$attribute['id'][] = $row['id'];
			$attribute['path'][] = $row['path'];
			$attribute['comment'][] = $row['comment'];
			$attribute['visibility'][] = $row['visibility'];
			if ( $this->modName != "document" ) {
				$attribute['titre'][] = $row['titre'];
				$attribute['accepted'][] = $row['accepted'];
				$attribute['uid'][] = $row['uid'];
				$attribute['gid'][] = $row['gid'];
			}
		}

		/*----------------------------------------
		LOAD FILES AND DIRECTORIES INTO ARRAYS
		--------------------------------------*/

		if ( ($loadDirPath == '.' ) || ($loadDirPath == '' ) || !isset($loadDirPath) ) {
			$loadDirPath = '';
		}
		@chdir( realpath($this->baseWorkDir . $loadDirPath) );

		$handle = @opendir(".");
		$iCntFile = 0;
		$iCntDir = 0;

		while ( $file = @readdir($handle) ) {
			if ( ($file == ".") || ($file == "..") ) {
				continue;	// Skip current and parent directories
			}
			if( @is_dir($file) ) {
				$this->dirList[$iCntDir]['file'] = $file;
				if ( $attribute ) {
					$i=0;
					$find=false;
					$cntAttribute = count($attribute['path']);
					while ( ($i < $cntAttribute ) && ($find==false) ) {
						if ( ($attribute['path'][$i]) == ($loadDirPath . "/" . $file) ) {
							$keyAttribute = $i;
							$find=true;
						}
						$i++;
					}
					if ( $keyAttribute >= 0  ) {
						if ( isset( $attribute['titre'][$keyAttribute] ) ) {
							$this->dirList[$iCntDir]['titre'] = $attribute['titre'][$keyAttribute];
						} else {
							$this->dirList[$iCntDir]['titre'] = $file;
						}
						$this->dirList[$iCntDir]['id'] = $attribute['id'][$keyAttribute];
						$this->dirList[$iCntDir]['comment'] = $attribute['comment'][$keyAttribute];
						$this->dirList[$iCntDir]['visibility'] = $attribute['visibility'][$keyAttribute];
					} else {
						return 1;
					}
				}
				$iCntDir++;
			}

			if( @is_file($file) ) {
				$this->fileList[$iCntFile]['size'] = filesize($file);
				$this->fileList[$iCntFile]['date'] = filectime($file);

				if ($attribute) {
					$i=0;
					$find=false;
					$cntAttribute = count($attribute['path']);
					while ( ($i < $cntAttribute ) && ($find==false) ) {
						if ( ($attribute['path'][$i]) == ($loadDirPath . "/" . $file) ) {
							$keyAttribute = $i;
							$find=true;
						}
						$i++;
					}
					if ( $keyAttribute >= 0 ) {
						$this->fileList[$iCntFile]['id'] = $attribute['id'][$keyAttribute];
						$this->fileList[$iCntFile]['path'] = $attribute['path'][$keyAttribute];
						$this->fileList[$iCntFile]['comment'] = $attribute['comment'][$keyAttribute];
						$this->fileList[$iCntFile]['visibility'] = $attribute['visibility'][$keyAttribute];
						if ( isset($attribute['titre'][$keyAttribute]) ) {
							$this->fileList[$iCntFile]['titre'] = $attribute['titre'][$keyAttribute];
						} else {
							$this->fileList[$iCntFile]['titre'] = $file;
						}
						if ( $this->modName != "document" ) {
							$this->fileList[$iCntFile]['uid'] = $attribute['uid'][$keyAttribute];
							$this->fileList[$iCntFile]['lock'] = $attribute['accepted'][$keyAttribute];
							$this->fileList[$iCntFile]['gid'] = $attribute['gid'][$keyAttribute];
						}
					} else {
						return 1;
					}
				}
				$iCntFile++;
			}
		} // end while ($file = readdir($handle))

		@closedir($handle);
  /*** Sort alphabetically ***/

/*
		if ($this->dirList) {
			asort($this->dirList);
		}

		if ($this->fileList) {
			sort($this->fileList);
		}
*/
		return 0;
	}

	function getUId() {
		return $this->uid;
	}

	function getAdmin() {
		return $this->isAdmin;
	}

	/*
	A logged user only can Modify a file in that cases:
		1) Admin of the course.
		2) Own of the file.
		3) A member of the group that owns the file.
		4) The file isn't lock.
	*/
	function _permModify( $idFile ) {
		/* Check if the user is logged */
		if ( isset($this->uid) && ($this->uid != "") ) {
			if ( $this->isAdmin ) {
				return true;
			} else {
				$strSQL = "SELECT uid, gid, accepted FROM " . $this->dbTable . " WHERE id = $idFile";
				$result = mysql_query( $strSQL, $this->hdDataBase );
				while ( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
					/* The file is locked */
					if ( !$row['accepted'] ) {
						return false;
					}
					/* Check if the user is the owner */
					if ( ($this->uid == $row['uid']) || ($this->gid == $row['gid']) ) {
						return true;
					}
				}
			}
		}
		return false;
	}

	function _insertFile( $fileName, $fileSize, $userFileFrom, $uploadPath, $comment, $titre, $gid=0, $mimeType="" )
	{
		/* Check the file size doesn't exceed
		* the maximum file size authorized in the directory
		*/
		$alreadyFilledSpace = $this->enough_size($fileSize, $this->baseWorkDir, $this->maxFilledSpace);
		if ( $alreadyFilledSpace < 0 ) {
			return 1;
		} else {
			if ( ($realFileSize + $alreadyFilledSpace) > $this->maxFilledSpace ) {// check the real size.
				return 1;
			}

			/*** Try to add an extension to files witout extension ***/
			$fileName = $this->add_ext_on_mime($fileName, $mimeType);

			/*** Handle Scripts files ***/
			$fileName = $this->php2phps($fileName);
			if ( $this->check_name_exist( $this->baseWorkDir . $uploadPath . "/" . $fileName) ) {
				return 2;
			} else {
				if( ! $titre ) {
					$titre = $fileName;
				}
				$userFileTo = $this->baseWorkDir . $uploadPath . "/" . $fileName;
				@move_uploaded_file( $userFileFrom, $userFileTo )
				or die("<tr><td colspan=\"2\">$langImposible</td></tr></table>");


				$path= $uploadPath . "/" . $fileName;

				if ( $this->modName == "document" ) {
					$strSQL = "INSERT INTO " . $this->dbTable . " (id, path, comment, visibility)  VALUES ('', '$path', '" . trim($comment) . "', 'i')";
				} else {
					$strSQL = "INSERT INTO " . $this->dbTable . " (id, path, titre, comment, uid, visibility, accepted, gid, dc) VALUES ('', '$path', '" . trim($titre) . "', '" . trim($comment) . "', '" . $this->uid . "', 'i', '1',$gid, NOW())";
				}
				mysql_query( $strSQL, $this->hdDataBase );
				return 0;
			}

		} // end else
	}

	function _insertDirectory( $dirPath, $dirName, $fileSize )
	{
		@chdir($dirPath);
		$handle = @opendir($dirPath) ;

		$cntDir = 0;
		while ( $element = @readdir($handle) ) {
			if ( $element == "." || $element == ".." ) {
				continue;	// skip current and parent directories
			} elseif ( @is_file($dirPath . "/" . $element) ) {
				$userFileTo = $this->baseWorkDir . $dirName . "/" . $element;
                                copy( $dirPath."/".$element, $userFileTo )
				or die("<tr><td colspan=\"2\">$langImposible</td></tr></table>");
                                
				$path= $dirName . "/" . $element;
 				
 				if ( $this->modName == "document" ) {
				    $strSQL = "INSERT INTO " . $this->dbTable . " (id, path, comment, visibility)  VALUES ('', '$path', '', 'i')";
				} else {
				    $strSQL = "INSERT INTO " . $this->dbTable . " (id, path, titre, comment, uid, visibility, accepted, gid, dc) VALUES ('', '$path', '$element', '', '" . $this->uid . "', 'i', '1',$gid, NOW())";
				}
				mysql_query( $strSQL, $this->hdDataBase );
																														
			} elseif ( @is_dir ($dirPath . "/" . $element) ) {
				$dirToEnter[$cntDir]['path'] = $dirPath."/".$element;
				$dirToEnter[$cntDir]['element'] = $dirName . "/" . $element;
				$cntDir = $cntDir + 1;
				$error = $this->createDir( $dirName, $element );
			}
		}

		@closedir ($handle) ;

		if ( @sizeof($dirToEnter) > 0) {
			foreach($dirToEnter as $j) {
				$this->_insertDirectory($j['path'], $j['element'], $fileSize) ; // recursivity
			}
		}

		return 0;
	}

}
?>
