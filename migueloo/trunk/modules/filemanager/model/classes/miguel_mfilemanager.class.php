<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
      | Authors: Antonio F. Cano Damas <antonio@igestec.com>                 |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Antonio F. Cano Damas <antonio@igestec.com>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */
class miguel_MFileManager extends base_Model
{
    function miguel_MFileManager()
    {
                $this->base_Model();
    }

    function getFileList( $current_course, $current_folder_id)
    {
        $document = $this->SelectMultiTable('fm_course_document_folder, fm_document',
                                           "fm_course_document_folder.document_id, fm_document.document_name, fm_document.document_size, fm_document.user_id,  fm_document.date_publish, fm_document.document_visible, fm_document.document_lock, fm_document.document_share",
                                           'fm_course_document_folder.course_id = ' . $current_course . ' AND fm_course_document_folder.folder_id = ' . $current_folder_id . ' AND fm_course_document_folder.document_id = fm_document.document_id');
            if ($this->hasError()) {
                    $ret_val = null;
            }
        $countDocument = count($document);
        for ($i=0; $i < $countDocument; $i++) {
             $ret_val[] = array ( 'document_id' => $document[$i]['fm_course_document_folder.document_id'],
                                  'document_name' => $document[$i]['fm_document.document_name'],
                                  'document_size' => $document[$i]['fm_document.document_size'],
                                  'document_date' => $document[$i]['fm_document.date_publish'],
                                  'document_autor' => $this->_getNameFromUser($document[$i]['fm_document.user_id']),
                                  'document_user_id' => $document[$i]['fm_document.user_id'],
                                  'document_visible' => $document[$i]['fm_document.document_visible'],
                                  'document_lock' => $document[$i]['fm_document.document_lock'],
                                  'document_share' => $document[$i]['fm_document.document_share']
                                );
        }

            return ($ret_val);
    }

    function _getFileCount($course_id, $folder_id)
    {
            $ret_val = $this->SelectCount('fm_course_document_folder', "course_id = $course_id AND folder_id = $folder_id");

            if ($this->hasError()) {
                    $ret_val = 0;
            }

            return $ret_val;
    }

    function _getFolderCount($course_id, $folder_id)
    {
                  $ret_val = $this->SelectCount('fm_folder', "course_id = $course_id AND folder_parent_id = $folder_id");

                if ($this->hasError()) {
                $ret_val = 0;
        }

        return $ret_val;
    }

    function getFolderList( $current_course, $current_folder_id)
    {
        //$current_course = 0;
        $folder = $this->Select("fm_folder", "folder_id, folder_name, folder_parent_id, folder_date, user_id, folder_visible",
                                "course_id = $current_course AND folder_parent_id = $current_folder_id");

        if ($this->hasError()) {
                $ret_val = null;
        }

        $countFolder = count($folder);
        for ($i=0; $i < $countFolder; $i++) {
             $fileCount = $this->_getFileCount( $current_course, $folder[$i]['fm_folder.folder_id']);
             $currentFolderCount = $this->_getFolderCount( $current_course, $folder[$i]['fm_folder.folder_id']);

             $ret_val[] = array ( 'folder_id' => $folder[$i]['fm_folder.folder_id'],
                                  'folder_name' => $folder[$i]['fm_folder.folder_name'],
                                  'folder_parent_id' => $folder[$i]['fm_folder.folder_parent_id'],
                                  'folder_date' => $folder[$i]['fm_folder.folder_date'],
                                  'folder_count_element' => $fileCount + $currentFolderCount,
                                  'folder_autor' => $this->_getNameFromUser($folder[$i]['fm_folder.user_id']),
                                  'folder_user_id' => $folder[$i]['fm_folder.user_id'],
                                  'folder_visible' => $folder[$i]['fm_folder.folder_visible']
                                );
        }

        return ($ret_val);
    }

    function getFolderTree( $current_course, &$result, $profundidad = 0, $current_folder_id = 0 )
    {
        $folderList = $this->getFolderList($current_course, $current_folder_id);

        // recursive operation if subdirectories exist
        if ( $folderList[0]['folder_id'] != null ) {
            $folderCount = sizeof($folderList);
            $profundidad++;
            if ( $folderCount > 0 ) {
                for ($i = 0 ; $i < $folderCount ; $i++ ) {
                      $result[]  =  array($folderList[$i], $profundidad);
                      $this->getFolderTree( $current_course, $result, $profundidad, $folderList[$i]['folder_id'] ) ;             // function recursivity
                }
            }
        }
    }

    //Maqueta
    function getFolderId( $course_id )
    {
        $folder = $this->Select("fm_folder", "folder_id",
                                "course_id = $course_id and folder_parent_id = 0");

        if ($this->hasError()) {
                $ret_val = null;
        } else {
                              $ret_val = $folder[0]['fm_folder.folder_id'];
                }

        return ($ret_val);

    }

    //Maqueta
    function getFolderName( $folder_id )
    {
        $folder = $this->Select("fm_folder", "folder_name, folder_parent_id",
                                "folder_id = $folder_id");

        if ($this->hasError()) {
                $ret_val = null;
        }

        $countFolder = count($folder);
        for ($i=0; $i < $countFolder; $i++) {
             $ret_val[] = array ( 'folder_name' => $folder[$i]['fm_folder.folder_name'],
                                  'folder_parent_id' => $folder[$i]['fm_folder.folder_parent_id']);
        }

        return ($ret_val);

    }

    function insertFolder($parent_folder_id, $course_id, $folder_name, $user_id)
    {
		$now = date("Y-m-d");

		$ret_val = $this->Insert('fm_folder',
					'folder_parent_id, course_id, folder_name, user_id, folder_date, folder_visible',
					"$parent_folder_id,$course_id,$folder_name, $user_id, $now, 1");
		
		
		if ($this->hasError()) {
				$ret_val = null;
		}
	
		return ($ret_val);

    }

    function insertFile($document_name, $document_mime, $course_id, $folder_id, $user_id, $size = 0)
    {
		$now = date("Y-m-d");

        $documentID = $this->Insert('fm_document',
                                 'document_mime, document_name, user_id, document_size, date_publish, document_visible, document_lock, document_share',
                                 "$document_mime, $document_name, $user_id, $size, $now,0,1,0");

        if ($this->hasError()) {
                $ret_val = null;
        } else {
            $ret_val = $this->Insert('fm_course_document_folder',
                                     'course_id, document_id, folder_id',
                                     "$course_id, $documentID , $folder_id");

            if ($this->hasError()) {
                    $ret_val = null;
            }
        }
        return ($ret_val);

    }

    function visibleElement($id, $status, $type='document') {
        if ($type='document') {
            $ret_val = $this->Update('fm_document', 'document_visible', $status, 'document_id = '.$id);
        } else {
            $ret_val = $this->Update('fm_folder', 'folder_visible', $status, 'folder_id = '.$id);
        }
        if ($this->hasError() ) {
            $ret_val = null;
        }
        return ($ret_val);
    }
	
    function lockDocument($id, $status) {
        $ret_val = $this->Update('fm_document', 'document_lock', $status, 'document_id = '.$id);
        if ($this->hasError() ) {
            $ret_val = null;
        }

        return ($ret_val);
    }

    function shareDocument($id, $status) {
        $ret_val = $this->Update('fm_document', 'document_share', $status, 'document_id = '.$id);
        
        if ($this->hasError() ) {
            $ret_val = null;
        }
        
        return ($ret_val);
    }

    //Maqueta
    function _getFileName( $document_id )
    {
        $document = $this->Select("fm_document", "document_name",
                                "document_id = $document_id");

        if ($this->hasError()) {
                $ret_val = null;
        }

        $countDocument = count($document);
        for ($i=0; $i < $countDocument; $i++) {
             $ret_val[] = array ( 'document_name' => $document[$i]['fm_document.document_name']);
        }

        return ($ret_val);

    }

    function renameFile( $_id, $_newName ) {
        $oldName = $this->_getFileName( $_id ); 
        $ret_val = $this->Update('fm_document', 'document_name', $_newName, 'document_id = '.$_id);
        
        if ($this->hasError() ) {
            $ret_val = null;
        } else {
            //user can't give the old name for security reasons
            $file = Util::main_Path('var/data/' . $oldName[0]['document_name']);
            $newFile = Util::main_Path('var/data/' . $_newName);
            if(file_exists($file)){
                rename($file, $newFile);
            }
        } 
        
        return ($ret_val);
    }

    function renameFolder( $_id, $_newName ) {
        $ret_val = $this->Update('fm_folder', 'folder_name', $_newName, 'folder_id = '.$_id);
  
        if ($this->hasError() ) {
            $ret_val = null;
        }

        return ($ret_val);
    }

    function moveFolder( $_id, $_newParentId ) { 
        $ret_val = $this->Update('fm_folder', 'folder_parent_id', $_newParentId, 'folder_id = '.$_id);
      
        if ($this->hasError() ) {
            $ret_val = null;
        } 
      
        return ($ret_val);
    }

    function moveFile( $_courseId, $_id, $_oldParentId, $_newParentId ) {
        $ret_val = $this->Update('fm_course_document_folder', 'folder_id', $_newParentId, 'folder_id = '.$_oldParentId.' AND document_id = '.$_id.' AND course_id = '.$_courseId);
      
        if ($this->hasError() ) {
            $ret_val = null;
        } 
      
        return ($ret_val);
    } 

    function getFileShareCount( $_id ) {
       $shareCount = $this->SelectCount('fm_course_document_folder', "document_id = $_id");

       if ($this->hasError()) {
            $shareCount = 0;
       }
       return $shareCount;

    }
 
    function deleteFile($_id, $_folder_id, $_course_id) {
        $shareCount = $this->getFileShareCount( $_id );
 
        $sql_ret = $this->Delete('fm_course_document_folder',"course_id = $_course_id AND folder_id = $_folder_id AND document_id = $_id");
 
        if ( $this->hasError() ) {
            $ret_val = null;
        } else {
            if ( $shareCount == 1 ) {
                $show_sql = $this->Select('fm_document', 'document_name', 'document_id = ' . $_id);
                $sql_ret = $this->Delete('fm_document', "document_id = $_id");
 
                if ($this->hasError()) {
                    $ret_val = null;
                } else {
                    $file = Util::main_Path('var/data/'.$show_sql[0]['fm_document.document_name']);
                    if( file_exists($file) ){
                        unlink($file);
                    }
                } 
             }
        } 
		
        return ($ret_val);	
    }
	
    function deleteFolder($_current_course, $_id) 
    {
        $folderList = $this->getFolderList($_current_course, $_id);

        // recursive operation if subdirectories exist
        if ( $folderList[0]['folder_id'] != null ) {
            $folderCount = sizeof($folderList);
            if ( $folderCount > 0 ) {
                for ($i = 0 ; $i < $folderCount ; $i++ ) {
                      //Delete Contents
                      $sql_ret = $this->Delete('fm_course_document_folder', 'course_id = ' . $_current_course . ' AND folder_id = ' . $folderList[$i]['folder_id']);

                      //Delete Folder 
                      $sql_ret = $this->Delete('fm_folder', 'folder_id = ' . $folderList[$i]['folder_id']);

                      $this->deleteFolder( $_current_course, $folderList[$i]['folder_id'] ) ;             // function recursivity
                }
            }
        }		
    }


    function _getNameFromUser($user_id)
    {
            $arrUsers = $this->SelectMultiTable('user, person',
                                                 'person.person_name, person.person_surname, person.person_surname2',
                                                 "person.person_id = user.person_id and user.user_id = $user_id");

            if ($this->hasError() || count($arrUsers) == 0) {
               $ret_val = null;
            } else {
               $ret_val= $arrUsers[0]['person.person_name'].' '.$arrUsers[0]['person.person_surname'].' '.$arrUsers[0]['person.person_surname2'];
            }

            return $ret_val;
    }
}
?>
