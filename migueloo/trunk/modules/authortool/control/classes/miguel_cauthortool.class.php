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
/*
 * Include libraries
 */
 
include_once(Util::app_Path('common/control/classes/miguel_courseinfo.class.php'));

/*
 * Defines the miguel control class
 *
 * @author Antonio F. Cano <antoniofcano@telefonica.net>
 * @author Eduardo Robles Elvira <edulix@iespana.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */
class miguel_CAuthorTool extends miguel_Controller
{
	/*
	 * This is the constructor.
	 */
	function miguel_CAuthorTool()
	{
		$this->miguel_Controller();
		$this->setModuleName('authortool');
		$this->setModelClass('miguel_MAuthorTool');
		$this->setViewClass('miguel_VAuthorTool');
		$this->setCacheFlag(false);
	}

	/*
	 * This function executes the controller
	 */
	function processPetition() 
	{
		/*
		 * Set various "burocratic" things
		 */
		$this->addNavElement(Util::format_URLPath('authortool/index.php'), 
			agt("nav_authortool"));
		$this->setMessage(agt('miguel_AuthorTool'));              
        $this->setPageTitle(agt('miguel_AuthorTool'));
		$this->setHelp("EducAuthorTool"); 
		
		/*
		 * Get action status, if none -> set to list
		 */
		if ($this->IsSetVar('status'))
		{
			$status = $this->getViewVariable('status');
		} else {
			$status = 'list';
			$this->setViewVariable('status', $status);
		}

		/*
		 * Get current folder id, if none -> set to 0,
		 * which is the root one of actual course
		 */
		
		if ($this->issetViewVariable('current_folder_id'))
		{
			$folder_id = $this->getViewVariable('current_folder_id');
		} else {
			$folder_id = 0;
			$this->setViewVariable('current_folder_id', $folder_id);
		}
		
		/*
		 * Sets read access to this course files and folder
		 */
		$bol_hasaccess = false;
		$user_id = $this->getSessionElement('userinfo', 'user_id');
		$course_id = $this->getSessionElement('courseinfo', 'course_id');
		$course_id = 7;
		if (isset($user_id) && $user_id != '' && isset($course_id) && $course_id != '')
		{
			$bol_hasaccess = true;
			$user_alias = $this->getSessionElement('userinfo', 'user_alias');
			$ret_sql = $this->obj_data->Select('user', 'id_profile', 'user_id = ' . 
				$user_id);
			$user_profile_id = $ret_sql[0]['user.id_profile'];
			
			$this->setCacheFile('miguel_VAuthorTool_'.$course_id.'_'.$user_id);
			$this->setCacheFlag(true);

			/*
			 * Execute the required action depdending on status once checked
			 * access permission.
			 */
			 
			$this->_exec_by_status($status, $folder_id, $user_id, $user_profile_id,
			$course_id);
		} else {
			/* 
			 * Otherwise, give control to main module
			 */
			$this->giveControl('main', 'miguel_CMain');
		}
	}

	/*
	 * @param string $var(s) viewVariable to check
	 * @return Returns if the ViewVariable(a) is/are initialised and set 
	 */
	function IsSetVar() 
	{
		if (func_num_args() > 0)
		{
			foreach(func_get_args() as $var)
			{
				if ($this->issetViewVariable($var) && $this->getViewVariable($var) != '') 
				{
					continue;
				} else {
					return false;
				}
			}
			return true;
		} else {
			return false;
		}
		
	}

	/*
	 * This function executes the required action
	 * @param string $status
	 * @param int $folder_id
	 * @param int $user_id
	 * @param $user_profile_id
	 * @param int $course_id
	 * @returns Returns 0 in success; 1 when an error occured
	 */
	function _exec_by_status($status, $folder_id, $user_id, $user_profile_id, $course_id)
	{
		/*
		 * We have success by default ;-)
		 */
		$this->SetViewVariable('opstat', 'success');
		
		/*
		 * Select the action given by status
		 */
		switch($status)
		{
			case 'list':
				/*
				 * First, we must check our permissions
				 */
				if (!$this->obj_data->checkFolderPerms("r", $course_id, $user_profile_id, 
				$folder_id))
				{
					$this->giveControl('main', 'miguel_CMain');
				}
				
				/*
				* Get/set order list:
				*/
				/*
				 * Relation among fileds of tables folder and document about order
				 */
				$fdOrderRelations = array(
					"id"			=> array("folder_id", "document.document_id"),
					"name"			=> array("folder_name", "document.document_name"),
					"date"			=> array("folder_date", "document.date_publish,
						document.document_name"),
					"comment"		=> array("folder_comment", "document.document_comment"),
					"user_alias"	=> array("folder_name", "user.user_alias,
						document.document_name"),
					"accepted"		=> array("folder_name", "document.document_accepted,
						document.document_name"),
					"mime"			=> array("folder_name", "document.document_mime,
						document.document_name"),
					"actions"		=> array("folder_perms, foldeer_name", 
						"document.document_name"));
				
				/*
				 * This is somewhat a "hack" but it works and doesn't overload the server.
				 * The problem is that we cannot use in_array('orderby', $fdOrderRelations)
				 * because..??.. in_array sucks! 
				 */
				$fdOrderbyArray = array("id", "name", "date", "comment", "user_alias", 
				"accepted", "mime", "actions");
				$this->setViewVariable('fdOrderbyArray', $fdOrderbyArray);
				
				if ($this->IsSetVar('orderby', 'orderhow') &&
				in_array($this->getViewVariable('orderby'), $fdOrderbyArray) &&
				($this->getViewVariable('orderhow') == 0 ||
				$this->getViewVariable('orderhow') == 1)) // 0 = ASC, 1 = DESC
				{
					$orderby = $this->getViewVariable('orderby');
					$orderhow = $this->getViewVariable('orderhow');
				} else {
					$orderby = 'name';
					$this->setViewVariable('orderby', $orderby);
					$orderhow = 0;
					$this->setViewVariable('orderhow', $orderhow);
				}
				/*
				 * No real action to execute,
				 * but we'll get some data that we'll need in View class
				 */
 				$this->setViewVariable('FolderList', 
					$this->obj_data->getFolderList($course_id, $folder_id,
					$user_profile_id, $fdOrderRelations[$orderby][0], $orderhow));
				
				$this->setViewVariable('FileList', 
					$this->obj_data->getFileList($course_id, $folder_id,
					$user_profile_id, $user_id, $fdOrderRelations[$orderby][1], $orderhow));
				
				$this->setViewVariable('FolderProperties', 
					$this->obj_data->getFolderProperties($course_id, $folder_id,
					$user_profile_id, $user_id));
				$this->setViewVariable('FolderDeeps', 
				
				$this->obj_data->getFolderDeeps($course_id, $folder_id));
				break;
			case 'send_file':
				/*
				 * First, we must check our permissions
				 */
				if (!$this->obj_data->checkFilePerms("w", $course_id, $user_id, 
				$user_profile_id, $this->getViewVariable('document_id')))
				{
					$this->giveControl('main', 'miguel_CMain');
				}
				
				/*
				 * We get the junk var of actual file from the BBDD if we're updating
				 * instead of creating one
				 */
				 if ($this->IsSetVar('document_id'))
				 {
					$this->setViewVariable('document_junk', 
						$this->obj_data->getFileJunk($course_id, 
							$this->getViewVariable('document_id')));
				 }
				 
				/*
				 * Send a file
				 */
				if ($this->IsSetVar('submit') && $_FILES['filename']['tmp_name'] != NULL)
				{
					include_once 
					(Util::app_Path("filemanager/include/classes/filemanager.class.php"));
					
					$md5 = md5_file($_FILES['filename']['tmp_name']);
					
					if (!$this->getViewVariable('filezip'))
					{
						if (!$file_properties = fileManager::uploadFile($_FILES['filename'], 
							$this->getViewVariable('document_junk')))
						{
							$this->SetViewVariable('opstat', 'fserror');
						}
						
						if(!$this->obj_data->insertFile(
							$file_properties['name'],
							$file_properties['type'],
							$file_properties['size'],
							$file_properties['junk'],
							$md5,
							$this->getViewVariable('document_comment'),
							$course_id,
							$user_id,
							$folder_id,
							NULL,
							$this->getViewVariable('document_id'),
							$this->getViewVariable('document_accepted')))
						{
							$this->SetViewVariable('opstat', 'dberror');
						}
					} else {
						/*
						 * ZIP files: 
						 */
						if(!$listUploadFiles = fileManager::uploadFileZip($_FILES['filename']))
						{
							$this->SetViewVariable('opstat', 'fserror');
						}
						
						$listCount = count($listUploadFiles);
						
						if (!$folder_zip_id = $this->obj_data->insertFolder( 
							$_FILES['filename']['name'],
							$course_id,
							$folder_id,
							$ZipElement['comment'],
							$this->getViewVariable('shared'),
							$this->getViewVariable('folder_perms'),
							NULL))
						{
							$this->SetViewVariable('opstat', 'dberror');
						}
						
						foreach ($listUploadFiles as $ZipElement)
						{
							if (!$ZipElement['folder'])
							{
								/*
								 * Upload the zip files in the folders they belong to
								 *
								 * $folder_parent_id -> find dirname() in 
								 * $listFolder[ruta_completa] and obtain name and id
								 */
								$search_folder_name = basename( 
								dirname($ZipElement['stored_filename']));
								 
								$search_folder_dir = dirname( 
								dirname($ZipElement['stored_filename']));
								 
								$j = 0;
								$countList = count($listFolder);
								$find = false;
								$folder_parent_id = $folder_zip_id;
								 
								while (($j < $countList) && (!$find))
								{
									if (($listFolder[$j][0] == $search_folder_name) &&
									($listFolder[$j][1] == $search_folder_dir))
									{
										$folder_parent_id = $listFolder[$j][2];
										$find = true;
									}
									$j++;
								}
								
								$fileJunk = substr(md5(time()), 10, 20);
								$fileFullPath = Util::app_Path("../var/data/").
								basename($ZipElement['stored_filename']."-$fileJunk");
								
								if(!copy($ZipElement['filename'], $fileFullPath))
								{
									$this->SetViewVariable('opstat', 'fserror');
								}
								
								if(!$this->obj_data->insertFile(
									basename($ZipElement['stored_filename']),
									"application/download",
									$ZipElement['size'],
									md5_file($fileFullPath),
									$fileJunk,
									$ZipElement['comment'],
									$user_id,
									$course_id,
									$folder_id,
									NULL,
									NULL,
									$this->getViewVariable('document_accepted'),
									1))
								{
									$this->SetViewVariable('opstat', 'zipdirdberror');
								}
							} else {
								/*
								 * Recreate the zip dirs structure
								 *
								 * Create a folder list (id, folder_name, folder_full_path)
								 * needed to know the path deepness:
								 * folder_name -> basename(path)
								 * parent_folder_name -> basename(dirname(ruta))
								 */
								 $folder_name = basename($ZipElement['stored_filename']);
								 $folder_dir = dirname($ZipElement['stored_filename']);
								 $folder_parent_id = $folder_zip_id;
								 
								 if ( $folder_dir != '.' )
								 {
								 	/*
									 * Find in listFolder if current element
									 * is contained into other folder.
									 * In order to do that, it looks for
									 * folder_name & folder_dir in current
									 * folder_dir and obtains the id.
									 */
									 $search_folder_name = basename($folder_dir);
									 $search_folder_dir = dirname($folder_dir);
									 
									 $j = 0;
									 $countList = count($listFolder);
									 $find = false;
									 
									 while (($j<$countList) && (!$find))
									 {
									 	if ( ($listFolder[$j][0] == $search_folder_name) &&
										($listFolder[$j][1] == $search_folder_dir))
										{
											$folder_parent_id = $listFolder[$j][2];
											$find = true;
										}
										$j++;
									}
								}
								
								/*
								 * Finally insert the folder and create a new
								 * element in $listFolder for it
								 */
								
								if(!$_folder_id = $this->obj_data->insertFolder(
									$folder_name,
									$course_id,
									$folder_parent_id,
									$ZipElement['comment'],
									$this->getViewVariable('shared'),
									$this->getViewVariable('folder_perms'),
									NULL))
								{
									$this->SetViewVariable('zipdir', 'error');
									$this->SetViewVariable('opstat', 'dberror');
								}
								
								$listFolder[] = array($folder_name, $folder_dir , $_folder_id);
							}
						}
					}
				} else {
					/*
					 * If form is not being submitted but we're editing a file
					 * then we'll get document vars that we'll need in View
					 */
					if ($this->IsSetVar('document_id'))
					{
						$this->setViewVariable("FileProperties",
							$this->obj_data->getFileProperties( 
								$this->getViewVariable('document_id'),
								$course_id,
								$user_profile_id,
								$user_id));
						
					}
				}
				break;
			case 'send_folder':
				/*
				 * First, we must check our permissions
				 */
				if (!$this->obj_data->checkFolderPerms("w", $course_id,
				$user_profile_id, $this->getViewVariable('folder_id')))
				{
					$this->giveControl('main', 'miguel_CMain');
				}
				/*
				 * Submit a folder (this means either update or create one).
				 */
				if ($this->IsSetVar('submit', 'folder_name'))
				{
					if (!$this->obj_data->insertFolder(
						$this->getViewVariable('folder_name'),
						$course_id,
						$folder_id,
						$this->getViewVariable('folder_comment'),
						$this->getViewVariable('shared'),
						$this->getViewVariable('folder_perms'),
						$this->getViewVariable('folder_id')))
					{
						$this->SetViewVariable('opstat', 'dberror');
					}
				} else {
					/*
					 * If form is not being submitted but we're editing a folder
					 * then we'll get document vars that we'll need in View
					 */
					if ($this->IsSetVar('folder_id'))
					{
						$this->setViewVariable("FolderProperties",
							$this->obj_data->getFolderProperties(
								$this->getViewVariable('folder_id'),
								$course_id,
								$user_profile_id));
						
					}
				}
				break;
			case 'send_document':
				/*
				 * First, we must check our permissions
				 */
				if (!$this->obj_data->checkFilePerms("w", $course_id, $user_id, 
				$user_profile_id, $this->getViewVariable('document_id')))
				{
					$this->giveControl('main', 'miguel_CMain');
				}
				
				/*
				 * We get the junk var of actual file from the BBDD if we're updating
				 * instead of creating one
				 */
				 if ($this->IsSetVar('document_id'))
				 {
					$this->setViewVariable('document_junk', 
						$this->obj_data->getFileJunk($course_id, 
							$this->getViewVariable('document_id')));
				 }
				 
				/*
				 * Send a document (that means either create or update a document)
				 */
				if ($this->IsSetVar('submit', 'name', 'content', 'type'))
				{
					include_once 
					(Util::app_Path("filemanager/include/classes/filemanager.class.php"));
					
					$md5 = md5($this->getViewVariable('document_content'));
					
					if(!$file_properties = fileManager::uploadDocument(
						$this->getViewVariable('document_name'), 
						$this->getViewVariable('document_content'),
						$this->getViewVariable('document_junk')))
					{
						$this->SetViewVariable('opstat', 'fserror');
					}
						
					if(!$this->obj_data->insertFile(
						$file_properties['name'],
						$file_properties['type'],
						$file_properties['size'],
						$file_properties['junk'],
						$md5,
						$this->getViewVariable('document_comment'),
						$course_id,
						$user_id,
						$folder_id,
						$this->getViewVariable('authortool_editable'),
						$this->getViewVariable('document_id'),
						$this->getViewVariable('document_accepted')))
					{
						$this->SetViewVariable('opstat', 'dberror');
					}
				} else {
					/*
					 * If form is not being submitted but we're editing a file
					 * then we'll get document vars that we'll need in View
					 */
					if ($this->IsSetVar('document_id'))
					{
						$this->setViewVariable("FileProperties",
							$this->obj_data->getFileProperties( 
								$this->getViewVariable('document_id'),
								$course_id,
								$user_profile_id,
								$user_id));
						
					}
				}
				break;
			case 'delete':
				/*
				 * First we check we have the most inmediate needed var
				 */
				if (!$this->IsSetVar('what'))
				{
					$this->giveControl('main', 'miguel_CMain');
				} else {
					switch ($this->getViewVariable('what'))
					{
						case 'folder':
							/*
							 * First, we must check needed var
							 */
							if (!$this->IsSetVar('folder_id'))
							{
								$this->giveControl('main', 'miguel_CMain');
							}
							/*
							 * Delete folder
							 */
							
							if (!$this->obj_data->deleteFolder(
								$this->getViewVariable('folder_id'),
								$course_id,
								$user_profile_id,
								$user_id))
							{
								$this->SetViewVariable('opstat', 'foldererror');
							}
							break;
						case 'document':
							/*
							 * First, we must check our permissions
							 */
							if (!$this->IsSetVar('document_id'))
							{
								 $this->giveControl('main', 'miguel_CMain');
							}
							
							/*
							 * Delete folder
 							 */
							if (!$this->obj_data->deleteFile(
								$this->getViewVariable('document_id'),
								$course_id,
								$user_profile_id,
								$user_id))
							{
								$this->SetViewVariable('opstat', 'fileerror');
							}
							break;
					}
				}
				break;
		}
	}
}
?>