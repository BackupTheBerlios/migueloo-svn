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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
class miguel_MCourseViewer extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MCourseViewer() 
    {	
		$this->base_Model();
    }

	function CourseModulesOrder($course_id)
	{
    	$sql_modulos = $this->SelectOrder('course_module', 'module_id', 'module_order', "course_id = $course_id");

		if ($sql_modulos[0]['course_module.module_id'] != null) {
			$countModulos = count($sql_modulos);
		} else {
			$countModulos = 0;
		}


		$indexDoc = 0;
		for ($i=0; $i<$countModulos; $i++) {
			$module_id = $sql_modulos[$i]['course_module.module_id'];
			$sql_doc =  $this->SelectOrder('module_document', 'document_id', 'md_order', "module_id = $module_id");

			if ($sql_doc[0]['module_document.document_id'] != null) {
				$countDoc = count($sql_doc);
			} else {
				$countDoc = 0;
			}

			for ($j=0; $j<$countDoc; $j++) {
				$ret_val[$indexDoc] = array('module' => $module_id,
															  'document' => $sql_doc[$j]['module_document.document_id']);
				$indexDoc++;
			}
		}
		
		return($ret_val);
	}

    function CourseModules($course_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('course_module', 'module_id', "course_id = $course_id");
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$last = count($sql_ret);
			for($i=0; $i < $last - 1; $i++){
				$ret_val[$sql_ret[$i]['course_module.module_id']] = intval($sql_ret[$i+1]['course_module.module_id']);
			}
			$ret_val[$sql_ret[$last -1]['course_module.module_id']] = 0;
		}
    	
    	return $ret_val;
    }
	
	function getCourseModulesPosition($course_id, $module_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('course_module', 'module_order', "course_id = $course_id AND module_id = $module_id");
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val = intval($sql_ret[0]['course_module.module_order']);
			
		}
    	
    	return $ret_val;
    }
	
    function firstDocument($module_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('module_document', 'document_id', "module_id = $module_id AND MD_ORDER = 1");
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val= $sql_ret[0]['module_document.document_id'];
    	}
    	
    	return $ret_val;
    }
	
	function lastDocument($module_id)
    {
    	//Get code contact
    	$sql_ret = $this->SelectOrder('module_document', 'document_id', 'md_order', "module_id = $module_id", true);
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val= $sql_ret[0]['module_document.document_id'];
    	}
    	
    	return $ret_val;
    }
	
	function getFolderId($document_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('folder', 'folder_id', "document_id = $document_id");
		//Debug::oneVar($sql_ret,__FILE__, __LINE__);
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val = $sql_ret[0]['folder.folder_id'];    	 
    	}
    	
    	return $ret_val;
    }
	
	function getFolderInfo($folder_id)
    {
    	//Get code contact
    	$sql_folder = $this->Select('folder', 
									'folder_id, folder_parent_id, document_id', 
									"folder_id = $folder_id");
		//Debug::oneVar($sql_ret,__FILE__, __LINE__);

    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val['fl_actual']= $this->getDocumentName($sql_folder[0]['folder.folder_id']);
			$ret_val['fl_previo']= $sql_folder[0]['folder.folder_parent_id'];
			
			//Buscamos el folder siguiente
			$sql_parent = $this->Select('folder', 
										'folder_id', 
										'folder_parent_id = '.$sql_folder[0]['folder.folder_id']);
			
			if ($this->hasError()) {
    			$ret_val['fl_siguiente'] = 0;
    		} else {
				$ret_val['fl_siguiente']= $sql_parent[0]['folder.folder_id'];
			}
			
			$sql_type = $this->Select('document', 
									  'document_active', 
									  'document_id = '.$sql_folder[0]['folder.folder_id']);
			
			if ($this->hasError()) {
    			$ret_val['fl_type'] = 0;
    		} else {
				$ret_val['fl_type']= intval($sql_type[0]['document.document_active']);
			}    	 
    	}
    	
    	return $ret_val;
    }

	function getDocumentName($folder_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('folder', 'folder_name', 'folder_id = '.$folder_id);

    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val= $sql_ret[0]['folder.folder_name'];
    	}
    	
    	return $ret_val;
    }
	
	function getAction($_document_id, $_name)
	{
		$sql_ret = $this->SelectMultiTable('document_action_checkvalue, document_action, document_action_type',
										   'document_action_type.dat_function, document_action_checkvalue.dcv_actionvalue, document_action.da_order',
										   'document_action_checkvalue.document_id = '.$_document_id.' and document_action_checkvalue.dcv_name = '.$_name.' and document_action.da_action = document_action_checkvalue.dcv_action and document_action.da_action = document_action_type.dat_id');
		//Debug::oneVar($sql_ret, __FILE__, __LINE__);
		if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			for($i = 0; $i < count($sql_ret); $i++){
				$ret_val[$i]['accion']= $sql_ret[$i]['document_action_type.dat_function'];
				$ret_val[$i]['param']= $sql_ret[$i]['document_action_checkvalue.dcv_actionvalue'];
				$ret_val[$i]['orden']= $sql_ret[$i]['document_action.da_order'];
			}
    	}
    	
    	return $ret_val;
	}
	
	function getActionValues($_document_id)
	{
		$sql_ret = $this->Select('document_action_checkvalue',
								 'dcv_name, dcv_value',
								 'document_id = '.$_document_id);

		if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			for($i = 0; $i < count($sql_ret); $i++){
				$ret_val[$sql_ret[$i]['document_action_checkvalue.dcv_name']]= $sql_ret[$i]['document_action_checkvalue.dcv_value'];
			}
    	}
    	
    	return $ret_val;
	}
	
	function getViewDetails($document_id)
    {
		$sql_ret = $this->SelectMultiTable('document_view, document_view_element',
											'document_view_element.element_name, document_view_element.variable_name, document_view_element.type_id, document_view_element.label, document_view_element.dve_default',
											"document_view.document_id = $document_id AND document_view.view_id = document_view_element.view_id");
		
		if ($this->hasError()) {
			$ret_val = null;
		} else {
			for($i = 0; $i < count($sql_ret); $i++){
				$ret_val[$i]['name']= $sql_ret[$i]['document_view_element.element_name'];
				$ret_val[$i]['variable']= $sql_ret[$i]['document_view_element.variable_name'];
				$ret_val[$i]['type']= $sql_ret[$i]['document_view_element.type_id'];
				$ret_val[$i]['label']= $sql_ret[$i]['document_view_element.label'];
				$ret_val[$i]['default']= $sql_ret[$i]['document_view_element.dve_default'];
			}
		}      
		
		return $ret_val;
    }
	
	//Manda un mail
    function sendMessage($arrId, $str_subject, $str_body) 
	{
        //Obtiene la fecha actual, función de PHP
        $now = date("Y-m-d H:i:s"); 
             
       $iMyId = Session::getValue('USERINFO_USER_ID');
        
        $iMsgId = $this->Insert('message',
                                 'sender,subject,body,date',
                                 array($iMyId,$str_subject,$str_body,$now));
                                 
       	if ($this->hasError()) {
    			$ret_val = null;
    	}	else	{
    			for ($i=0; $i<count($arrId); $i++) {
    				if ($arrId[$i]!='') 	{
	  		      			$this->Insert('receiver_message',
		                             'id_receiver,id_message,status',
			                         "$arrId[$i],$iMsgId,0");
					}
				}
    			$ret_val=$iMsgId;
        }

        //Comprueba si ha ocurrido algún error al realizar la operación
    	if ($this->hasError()) {
    		$ret_val = null;
    	}
    	
    	return ($ret_val);
    }

	/*
	function firstModule($course_id)
    {
    	//Get code contact
    	$sql_ret = $this->Select('course_module', 'module_id', "course_id = $course_id AND MODULE_ORDER = 1");
		
    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val= $sql_ret[0]['course_module.module_id'];
		}
    	
    	return $ret_val;
    }
	
	function getAction($_document_id)
	{
		$sql_ret = $this->SelectMultiTable('document_action, document_action_type',
										   'document_action_type.dat_function, document_action.da_action, document_action.da_order',
										   'document_action.document_id = '.$_document_id.' and document_action.da_action = document_action_type.dat_id');
		//Debug::oneVar($sql_ret, __FILE__, __LINE__);
		if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			for($i = 0; $i < count($sql_ret); $i++){
				$ret_val[$i]['accion']= $sql_ret[$i]['document_action_type.dat_function'];
				$ret_val[$i]['action_id']= $sql_ret[$i]['document_action.da_action'];
				$ret_val[$i]['orden']= $sql_ret[$i]['document_action.da_order'];
			}
    	}
    	
    	return $ret_val;
	}
	
	function getActionValues($_document_id)
	{
		$sql_ret = $this->Select('document_action_checkvalue',
								 'dcv_name, dcv_type, dcv_value, dcv_action, dcv_actionvalue',
								 'document_id = '.$_document_id);
		//Debug::oneVar($sql_ret, __FILE__, __LINE__);
		if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			for($i = 0; $i < count($sql_ret); $i++){
				$ret_val[$i]['campo']= $sql_ret[$i]['document_action_checkvalue.dcv_name'];
				$ret_val[$i]['tipo']= $sql_ret[$i]['document_action_checkvalue.dcv_type'];
				$ret_val[$i]['valor']= $sql_ret[$i]['document_action_checkvalue.dcv_value'];
				$ret_val[$i]['ac_tipo']= $sql_ret[$i]['document_action_checkvalue.dcv_action'];
				$ret_val[$i]['ac_param']= $sql_ret[$i]['document_action_checkvalue.dcv_actionvalue'];
			}
    	}
    	
    	return $ret_val;
	}
	*/
}
?>
