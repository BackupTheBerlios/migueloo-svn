<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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
      | Authors: Antonio F. Cano <antoniofcano@telefonica.net>               |
      |          Eduardo Robles Elvira <edulix@iespana.es>                   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define the main miguel class
 *
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author Eduardo Robles Elvira <edulix@iespana.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class miguel_MAuthorTool extends base_Model
{
	
	/*
	 * folderdeeps is an array f actual folder deeps to root folder (name & id)
	 */
	var $_folderdeepsarray;
	 
	/*
	 * This is the constructor.
	 */
	function miguel_MAuthorTool()
	{
		$this->base_Model();
	}

	/*
	 * This function returns the number of files that a folder contains
	 * @param int $course_id
	 * @param int $folder_id
	 * @return Returns the number of files that a folder contains
	 * or NULL if there was an error
	 */
	function _getFileCount($course_id, $folder_id)
	{
		$ret_val = $this->SelectCount('course_document_folder',
			"course_id = $course_id AND folder_id = $folder_id");
		
		if ($this->hasError()) {
			return NULL;
		}
	
		return $ret_val;
	}

	/*
	 * This function returns the number of folders that a folder contains
	 * @param int $course_id
	 * @param int $folder_id
	 * @return Returns the number of folders that a folder contains
	 * or NULL if there was an error
	 */
	function _getFolderCount($course_id, $folder_id)
	{
		$ret_val = $this->SelectCount('folder',
			"course_id = $course_id AND folder_parent_id = $folder_id");
	
		if ($this->hasError()) {
			return NULL;
		}
	
		return $ret_val;
	}

	/*
	 * This function returns the list of files included in a folder
	 * @param string $current_course
	 * @param int $current_folder_id
	 * @param int $user_profile_id
	 * @param int $user_id
	 * @param string $orderby
	 * @param bol $orderhow
	 * @return Returns the list of files included in a folder
	 * or NULL if there was an error
	 */
	function getFileList($current_course, $current_folder_id, $user_profile_id, $user_id,
		$orderby, $orderhow)
	{
		$documents = $this->SelectMultiTableOrder('course_document_folder, document, user', 
			'document.document_id, document.document_comment, 
			 document.document_accepted, document.document_mime, document.document_md5, 
			 document.document_junk, document.date_publish, document.user_id, 
			 document.document_name, document.document_size, document.authortool_editable, 
			 user.user_alias',
			$orderby,
			"course_document_folder.course_id = $current_course AND 
			 course_document_folder.folder_id = $current_folder_id AND 
			 course_document_folder.document_id = document.document_id AND
			 document.user_id = user.user_id",
			$orderhow);
			
		if ($this->hasError()) {
			return NULL;
		}
		
		foreach ($documents as $document) {
			$ret_val[] = array( 
				'document_id'		=> $document['document.document_id'],
				'document_comment'	=> $document['document.document_comment'],
				'document_accepted'	=> $document['document.document_accepted'],
				'document_mime'		=> $document['document.document_mime'],
				'document_md5'		=> $document['document.document_md5'],
				'document_junk'		=> $document['document.document_junk'],
				'date_publish'		=> $document['document.date_publish'],
				'user_id'		=> $document['document.user_id'],
				'user_alias'		=> $document['user.user_alias'],
				'document_name'		=> $document['document.document_name'],
				'document_size'		=> $document['document.document_size'],
				'authortool_editable'	=> $document['document.authortool_editable']);
		}
		
		return $ret_val;
        }

	/*
	 * This function returns the list of folders included in a folder
	 * @param string $current_course
	 * @param int $current_folder_id
	 * @param int $user_profile_id
	 * @param string $orderby
	 * @param bol $orderhow
	 * @return Returns the list of folders included in a folder
	 * or NULL if there was an error
	 */
	function getFolderList($current_course, $current_folder_id,  $user_profile_id, $orderby,
		$orderhow)
	{
		$folders = $this->SelectOrder("folder",
			"folder_id, folder_name, folder_comment, folder_date, shared, folder_perms",
			$orderby,
			"course_id = $current_course AND folder_parent_id = $current_folder_id",
			$orderhow);
		
		if ($this->hasError() || $folder['folder.folder_id'] != NULL) {
			return NULL;
		}
		
		foreach ($folders as $folder) {
			/*
			 * Check whether we can see the folder or not. 
			 * If not, we'll just hide it (i.e. not add it to the array)
			 */
			if ($this->checkFolderPerms("s", $current_folder_id, $user_profile_id, $folder['folder.folder_id']) && 
			$folder['folder.folder_id'] != NULL)
			{
				$fileCount = $this->_getFileCount($current_course,
				$folder['folder.folder_id']);
				$currentFolderCount = $this->_getFolderCount($current_course,
				$folder['folder.folder_id']);
				
				$ret_val[] = array( 
					'folder_id'			=> $folder['folder.folder_id'],
					'folder_name'			=> $folder['folder.folder_name'],
					'folder_comment'	=> $folder['folder.folder_comment'],
					'folder_date'		=> $folder['folder.folder_date'],
					'shared'			=> $folder['folder.shared'],
					'folder_perms'		=> $this->getFolderPerms($current_course, $user_profile_id,
						$folder_id),
					'folder_count_element'	=> $fileCount + $currentFolderCount + 0);
			}
		}
		
		return $ret_val;
	}

	/*
	 * This function returns the properties of a folder
	 * @param int $current_course
	 * @param int $folder_id
	 * @param int $user_profile_id
	 * @param int $user_id
	 * @return Returns the properties of a folder
	 * or NULL if there is an error
	 */
	function getFolderProperties($current_course, $folder_id, $user_profile_id, $user_id)
	{
		$properties = $this->Select("folder", "*",
			"folder_id = $folder_id AND course_id = $current_course");
		
		if ($this->hasError()) {
			return NULL;
		}
		
		return array(
			'folder_id'		=> $folder_id,
			'folder_parent_id'	=> $property[0]['folder.folder_parent_id'],
			'folder_name'		=> $property[0]['folder.folder_name'],
			'folder_comment'	=> $property[0]['folder.folder_comment'],
			'folder_date'		=> $property[0]['folder.folder_date'],
			'course_id'		=> $property[0]['folder.course_id'],
			'shared'		=> $property[0]['folder.shared'],
			'folder_perms'		=> $this->getFolderPerms($current_course, $user_profile_id,
				$folder_id),
			'folder_perms2'		=> $property[0]['folder.folder_perms']);
	}

	/*
	 * This function add all needed values to $var ViewVariable arrays
	 * @param int $course_id
	 * @param string $folder_id
	 * @param bol $init To know if we have to clear $this->_folderdeepsarray.
	 * 0=clear and it's 0 by default. 1 = not clear.
	 * @return Returns the $this->_folderdeepsarray
	 */
	function getFolderDeeps($course_id, $folder_id, $init = 0)
	{
		if ($init == 0)
		{
			$this->_folderdeepsarray = array();
		}
		
		$properties = $this->Select('folder', 'folder_id, folder_name, folder_parent_id',
			"folder_id = $folder_id AND course_id = $course_id");
		
		if ($this->hasError())
		{
			return NULL;
		}
		
		$this->_folderdeepsarray[] = array(
			'folder_id' => $properties[0]['folder.folder_id'],
			'folder_name' => $properties[0]['folder.folder_name']);
		
		if ($properties['folder.folder_parent_id'] == ("0" || NULL))
		{
			return $this->_folderdeepsarray;
		} else {
			$this->getFolderDeeps($course_id, $properties[0]['folder.folder_parent_id'], 1);
		}
	}

	/*
	 * This function returns the properties of a file/document
	 * @param int $document_id
	 * @param int $current_course
	 * @return Returns the properties of a file/document
	 * or NULL if there is an error
	 */
	function getFileProperties($document_id, $current_course, $user_id, $user_profile_id)
	{
		$documents = $this->SelectMultiTable('document, course_document_folder, folder',
			'course_document_folder.document_id, document.document_comment,  
			 document.document_accepted, document.document_mime, document.document_md5, 
			 document.document_junk, document.date_publish, document.user_id, 
			 document.document_name, document.authortool_editable, folder.folder_perms',
			"course_document_folder.course_id = $current_course AND document.document_id = 
			 $document_id AND document.user_id = $user_id AND folder.folder_id =  
			 course_document_folder.folder_id");
			
		if ($this->hasError()) {
			return NULL;
		} elseif ($document[0]['folder.folder_id'] == (NULL || 0)) {
			$document[0]['folder.folder_id'] = "55331";
		}
		
		return array( 
			'document_id'		=> $document_id,
			'document_comment'	=> $document[0]['document.document_comment'],
			'document_accepted'	=> $document[0]['document.document_accepted'],
			'document_mime'		=> $document[0]['document.document_mime'],
			'document_md5'		=> $document[0]['document.document_md5'],
			'document_junk'		=> $document[0]['document.document_junk'],
			'date_publish'		=> $document[0]['document.date_publish'],
			'user_id'		=> $document[0]['document.user_id'],
			'document_name'		=> $document[0]['document.document_name'],
			'authortool_editable'	=> $document[0]['document.authortool_editable'],
			'document_perms'		=> $this->getFilePerms($current_course, $user_id, 
				$user_profile_id, $document_id),
			'document_perms2'		=> $document[0]['folder.folder_perms']);
	}

	/*
	 * This function returns the junk var of a given file id
	 * @param int $document_id
	 * @param int $current_course
	 * @return Returns the junk var of a given file id
	 * or NULL if there is an error
	 */
	function getFileJunk($document_id, $current_course)
	{
		
		$documents = $this->SelectMultiTable('document, course_document_folder',
		'document.document_junk',
		"course_document_folder.course_id = $current_course AND document.document_id = 
		$document_id");
		
		if ($this->hasError()) {
			return NULL;
		}
		
		return $junkarr[0]['document.document_junk'];
	}

	/*
	 * This function returns whether required action is possible within the
	 * given enviroment vars
	 * @param string $operation
	 * @param $course_id
	 * @param $user_id
	 * @param $user_profile_id
	 * @param $document_id
	 */
	function checkFilePerms($operation, $course_id, $user_id, $user_profile_id, $document_id)
	{
		/*
		 * First we check if the file belongs to a folder and therefore exists
		 */
		$folder_idarr = $this->Select('course_document_folder',
			'folder_id',
			"course_id = $course_id AND document_id = $document_id");
	
		if ($this->hasError()) {
			return false;
		}
		
		$folder_id = $folder_idarr[0]['course_document_folder.folder_id'];
		
		switch ($operation)
		{
			/*
			* read file:
			*/
			case "r":
				return $this->checkFolderPerms("r", $course_id, $user_profile_id, 
					$folder_id);
				break;
			/*
			* write file:
			*/
			case "w":
				/*
				* Then we'll check if the user created the file
				*/
				$ret_val = $this->SelectMultiTable('document, course_document_folder',
					'course_document_folder.document_id',
					"course_document_folder.course_id = $course_id AND document.document_id = 
					$document_id AND document.user_id = $user_id");
				$user_created_file = count($ret_val);
				
				
				if ($this->hasError()) {
					return false;
				}
				
				/*
				* Then we'll check if the user is course admin
				*/
				$user_id_course_admin = $this->SelectCount('course',
					"course_id = $course_id AND user_id = $user_id");
				
				if (($user_created_file || $user_id_course_admin) == 1 && 
				!$this->hasError())
				{
					return $this->checkFolderPerms("w", $course_id, $user_profile_id, 
						$folder_id);
				} else {
					return $this->checkFolderPerms("a", $course_id, $user_profile_id, 
						$folder_id);
				}
				break;
			/*
			* publish file:
			*/
			case "p":
				/*
				* Then we'll check if the user created the file
				*/
				$ret_val = $this->SelectMultiTable('document, course_document_folder',
					'course_document_folder.document_id',
					"course_document_folder.course_id = $course_id AND document.document_id = 
					 $document_id AND document.user_id = $user_id");
				 $user_created_file = count($ret_val);
				
				if ($this->hasError()) {
					return false;
				}
				
				if ($user_created_file == 1)
				{
					return $this->checkFolderPerms("p", $course_id, $user_profile_id, 
						$folder_id);
				} else {
					return $this->checkFolderPerms("a", $course_id, $user_profile_id, 
						$folder_id);
				}
				break;
		}
	}


	/*
	 * This function returns whether required action is possible within the
	 * given enviroment vars or not
	 * @param string $operation
	 * @param $course_id
	 * @param $user_profile_id
	 * @param folder_id
	 * @returns Returns whether required action is possible within the
	 * given enviroment vars or not
	 */
	function checkFolderPerms($operation, $course_id, $user_profile_id, 
		$folder_id)
	{
/*
Las propiedades de los directorios:
- dígito 1: verlo - sustituye a FOLDER_VISIBILITY
- dígito 2: leer sus ficheros
- dígito 3: subir nuevos ficheros y editarlos (sólo lo que uno mismo ha subido) 
y eliminarlos
- dígito 4: publicar ficheros propios
- dígito 5: administrar (todo lo anterior) ficheros ajenos
*/
		if ($folder_id == 0)
		{
			$n = 1;
		} else {
			$n = $this->SelectCount('folder',
			"course_id = $course_id AND folder_id = $folder_id");
		}
		if ($n == 1)
		{
			$permsarr = $this->Select('folder',
			"folder_perms",
			"course_id = $course_id AND folder_id = $folder_id");
			
			if ($this->hasError()) {
				return NULL;
			}
			if ($folder_id == 0)
			{
				$perms = "55331";
			} else {
				$perms =$permsarr[0]['folder.folder_perms'];
			}
			
			if (!preg_match("/[1-9]{5}/", $perms)) {
				return false;
			}
			switch ($operation)
			{
				/*
				* see folder:
				*/
				case "s":
					if($perms{0} >= $user_profile_id)
					{
						return true;
					}
					break;
				/*
				* read folder:
				*/
				case "r":
					if($perms{1} >= $user_profile_id &&
					$this->checkFolderPerms("s", $course_id, $user_profile_id, $folder_id))
					{
						return true;
					}
					break;
				/*
				* write in folder:
				*/
				case "w":
					if($perms{2} >= $user_profile_id &&
					$this->checkFolderPerms("r", $course_id, $user_profile_id, $folder_id))
					{
						return true;
					}
					break;
				/*
				* publish in folder:
				*/
				case "p":
					if($perms{3} >= $user_profile_id &&
					$this->checkFolderPerms("w", $course_id, $user_profile_id, $folder_id))
					{
						return true;
					}
					break;
				/*
				* admin folder:
				*/
				case "a":
					if($perms{4} >= $user_profile_id &&
					$this->checkFolderPerms("p", $course_id, $user_profile_id, $folder_id))
					{
						return true;
					}
					break;
			}
		} else
			return $folder_id;
	}

	/*
	 * This function returns which actions can a user do with a file
	 * given enviroment vars
	 * @param $course_id
	 * @param $user_id
	 * @param $user_profile_id
	 * @param $document_id
	 * @return array("r" => "1|0", "w" => "1|0", "p"=>"1|0")
	 */
	function getFilePerms($course_id, $user_id, $user_profile_id, $document_id)
	{
		return array(
			"r" => $this->checkFilePerms("r", $course_id,  $user_id, $user_profile_id, $document_id),
			"w" => $this->checkFilePerms("w", $course_id,  $user_id, $user_profile_id, $document_id),
			"p" => $this->checkFilePerms("p", $course_id,  $user_id, $user_profile_id, $document_id));
	}

	/*
	 * This function returns which actions can a user do with a file
	 * given enviroment vars
	 * @param $course_id
	 * @param $user_id
	 * @param $user_profile_id
	 * @param $document_id
	 * @return array("s" => "1|0", "r" => "1|0", "w" => "1|0", "p"=>"1|0")
	 */
	function getFolderPerms($course_id, $user_profile_id, $folder_id)
	{
		return array(
			"s" => $this->checkFolderPerms("s", $course_id, $user_profile_id, $folder_id),
			"r" => $this->checkFolderPerms("r", $course_id, $user_profile_id, $folder_id),
			"w" => $this->checkFolderPerms("w", $course_id, $user_profile_id, $folder_id),
			"p" => $this->checkFolderPerms("p", $course_id, $user_profile_id, $folder_id));
	}

	/*
	 * This function inserts a folder in the BBDD or updates 
	 * it if $folder_id is set
	 * @param string $folder_name
	 * @param int $course_id
	 * @param int $folder_parent_id
	 * @param string $folder_comment
	 * @param bol $shared
	 * @param int $folder_perms
	 * @param int $folder_id
	 * @return Returns inserted folder id
	 * or NULL if there was an error
	 */
	function insertFolder($folder_name, $course_id, $folder_parent_id=NULL, $folder_comment=NULL, $shared=NULL, $folder_perms=NULL, $folder_id=NULL)
	{
		if ($folder_id == NULL)
		{
			$ret_val = $this->Insert('folder',
				'folder_name,  course_id, folder_parent_id,
				 folder_comment,  folder_date,       shared,
				 folder_perms',
				"$folder_name, $course_id, $folder_parent_id,
				 $folder_comment,  '".date("Y-m-d")."', $shared,
				 $folder_perms");
		} else {
			if ($this->_getFolderCount($course_id, $folder_id) == 1)
			{
				$ret_val = $this->Update('folder',
				'folder_name,  course_id, folder_parent_id,
				 folder_comment,  folder_date,       shared,
				 folder_perms',
				"$folder_name, $course_id, $folder_parent_id,
				 $folder_comment,  '".date("Y-m-d")."', $shared,
				 $folder_perms",
				 "course_id = $course_id AND folder_id = $folder_id");
			} else {
				return NULL;
			}
		}
		
		if ($this->hasError()) {
			return NULL;
		}
		
		return ($ret_val);
	}

	/*
	 * This function inserts a folder in the BBDD
	 * @param file &$postFilesInfo Reference to the file array (we'll get size, name, type and file)
	 * @param string $document_name
	 * @param string $document_mime
	 * @param string $document_size
	 * @param string $document_md5
	 * @param string $document_comment
	 * @param int $user_id
	 * @param int $course_id
	 * @param int $folder_id
	 * @param bol $authortool_editable
	 * @param int $document_id
	 * @param bol $document_accepted
	 * @param bol $zip
	 * @return Returns inserted file id
	 * or NULL if there was an error
	 */
	function insertFile($document_name, $document_mime, $document_size, $document_md5, $document_comment, $user_id, $course_id, $folder_id, $authortool_editable=NULL, $document_id=NULL, $document_accepted=NULL,
	$zip=NULL)
	{
		if ($document_id == NULL)
		{
			$document_id = $this->Insert('document',
				'document_name,  document_mime,  document_size, 
				 document_md5,  document_comment,  date_publish,
				 user_id,  document_accepted,  authortool_editable',
				"$document_name, $document_mime, $docouemnt_size,
				 $document_md5, $document_comment,'".date("Y-m-d")."',
				 $user_id, $document_accepted, $authortool_editable");
			
			if ($this->hasError()) {
				return NULL;
			} else {
				$ret_val = $this->Insert('course_document_folder',
					'course_id,  document_id,  folder_id',
					"$course_id, $document_id, $folder_id");
			}
		} else {
			if ($this->_getFileCount($course_id, $folder_id) == 1)
			{
				$document_id = $this->Update('document',
					'document_name,  document_mime,  document_size, 
					 document_md5,  document_comment,  date_publish,
					 user_id,  document_accepted,  authortool_editable',
					"$document_name, $document_mime, $docouemnt_size,
					 $document_md5, $document_comment, '".date("Y-m-d")."',
					 $user_id, $document_accepted, $authortool_editable",
					"document_id = $document_id");
			} else {
				return NULL;
			}
			
			if ($this->hasError()) {
				return NULL;
			} else {
				$ret_val = $this->Update('course_document_folder',
					'course_id,  folder_id',
					"$course_id, $folder_id",
					"document_id = $document_id");
			}
		}
		
		if ($this->hasError()) {
			return NULL;
		}
	return $ret_val;
	}

	/*
	 * This function deletes a Folder from the DDBB
	 * it if $fdocument_id
	 * @param string $folder_id
	 * @param int $course_id
	 * @param int $user_profile_id
	 * @param int $user_id
	 * @return Returns true or false if there was an error
	 */
	function deleteFolder($folder_id, $course_id, $user_profile_id, $user_id)
	{
		
		if (!$this->checkFolderPerms("w", $course_id, $user_profile_id, 
		$folder_id)) {
			return FALSE;
		}
		
		/*
		 * Get & delete inside folders recursively
		 */
		$folders = $this->Select("folder", "folder_id",
			"course_id = $course_id AND folder_parent_id = $folder_id");
		
		foreach($folders as $thisfolder)
		{
			deleteFolder($thisfolder, $course_id, $user_profile_id, $user_id);
		}
		
		/*
		 * Delete inside files
		 */
		
		$documents = $this->Select("document", "document_id",
			"course_id = $course_id AND folder_parent_id = $folder_id");
		
		foreach($documents as $thisdocument)
		{
			if (!deleteFile($thisdocument, $course_id, $user_profile_id, $user_id))
			{
				return FALSE;
			}
		}
		
		/*
		 * Finally, delete Folder
		 */
		$this->Delete("folder",
			"course_id = $course_id AND folder_id = $folder_id");
		
		if ($this->hasError()) {
			return FALSE;
		}
		
		return TRUE;
	}

	/*
	 * This function deletes a File from the DDBB
	 * it if $fdocument_id
	 * @param string $document_id
	 * @param int $course_id
	 * @param int $user_profile_id
	 * @param int $user_id
	 * @return Returns true or false if there was an error
	 */
	function deleteFile($document_id, $course_id, $user_profile_id, $user_id)
	{
		/*
		 * Always check permissions!
		 */
		if (!$this->checkFilePerms("w", $course_id, $user_id, $user_profile_id,
		$document_id)) {
			return FALSE;
		}
		
		/*
		 * Before deleting the entry, first get the neede info to delete the real file
		 */
		$docinfoarr = $this->Select("document", "document_name, document_junk",
			"course_id = $course_id AND document_id = $document_id");
		
		if(!unlink(Util::app_Path("../var/data/".$docinfo[0]["document_name"].'-'.
		$docinfo[0]["document_junk"]))) {
			return FALSE;
		}
		
		/*
		 * Finally, delete the entry
		 */
		$this->Delete("document",
			"course_id = $course_id AND document_id = $document_id");
		
		if ($this->hasError()) {
			return FALSE;
		}
		
		return TRUE;
	}

}
?>