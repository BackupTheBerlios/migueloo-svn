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
      | Authors: Eduardo Robles Elvira <edulix@iespana.es>                   |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

/*
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

/*
 * Defines the View class .
 *
 * @author Eduardo Robles Elvira <edulix@iespana.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage view
 * @version 1.0.0
 *
 */ 
class miguel_VAuthorTool_List extends miguel_FormContent
{
	/*
	 * This is the array containing the data about files contained in current folder
	 */
	var $FileList;

	/*
	 * This is the array containing the data about folders contained in current folder
	 */
	var $FolderList;

	/*
	 * This is the array containing the data about current folder
	 */
	var $FolderProperties;

	/*
	 * FolderDeeps is an array of actual folder deeps to root folder (name & id)
	 */
	var $FolderDeeps;

	/*
	 * This is the constructor where the vars are initialised
	 */
	function miguel_VAuthorTool_List($arr_commarea = NULL)
	{
		$this->miguel_FormContent($arr_commarea);
		
		$this->FileList		= $this->getViewVariable("FileList");
		$this->FolderList		= $this->getViewVariable("FolderList");
		$this->FolderProperties	= $this->getViewVariable("FolderProperties");
		$this->FolderDeeps		= $this->getViewVariable("FolderDeeps");
		$this->orderby		= $this->getViewVariable("orderby");
		$this->orderhow		= $this->getViewVariable("orderhow");
		$this->fdOrderbyArray	= $this->getViewVariable("fdOrderbyArray");
	}
	
	/*
	 * This method gets called EVERY time the object is
	 * created.  It is used to build all of the 
	 * FormElement objects used in this Form.
	 */
	function form_init_elements() 
	{
		$this->add_hidden_element('operation_id');
	}

	/*
	 * This method is called only the first time the form
	 * page is hit.  This enables u to query a DB and 
	 * pre populate the FormElement objects with data.
	 *
	 */
	function form_init_data() 
	{
		$this->set_hidden_element_value("operation_id", "submit");
	}

	/*
	 * This is the method that builds the layout of where the
	 * FormElements will live.  You can lay it out any way
	 * you like.
	 *
	 */
	function form() 
	{
		$div = &html_div_center();
		$div->set_id("folderlist");
		
		/*
		 * Add folder path to id inside a span
		 */
		
		$path = html_div();
		$link = html_a(Util::format_URLPath('authortool/index.php', 
				"status=list&amp;current_folder_id=0"), 
					"/", NULL, '_top', agt('accessfolder'));
		$path->add(agt("fd_folder:"), $link);
		foreach ($this->FolderDeeps as $FolderElement)
		{
			$link = html_a(Util::format_URLPath('authortool/index.php', 
				"status=list&amp;current_folder_id=".$FolderElement['folder_id']), 
					$FolderElement['folder_name'], NULL, '_top', agt('accessfolder'));
			$path->add($link);
		}
		$div->add($path);
		
		/*
		 * Now we create a table into the div that'll contain folders & files list
		 */
		
		$tableFolder = &html_table();
		
		/*
		 * Header
		 */
		 
		/*
		 * The next lines allow the user order folders & documents
		 * clicking in any of the header th titles
		 */
		$i = 0;
		foreach ($this->fdOrderbyArray as $orderb)
		{
			$fd_orderb_link = '';
			if ($orderb != "id")
			{
				
				if ($this->orderby == $orderb)
				{
					$orderhow2 = ($this->orderhow == 1) ? 0 : 1;
					$fd_orderb_link = html_a(Util::format_URLPath('authortool/index.php', 
						"status=list&amp;current_folder_id=".
						$this->FolderProperties['folder_id']."&amp;orderby=$orderb&amp;
						orderhow=$orderhow2"), NULL, NULL, '_top', 
						agt("fd_orderby")._HTML_SPACE.agt($orderb));
						
					$fd_orderb_image = ($this->orderhow == 1) ? 
						Theme::getThemeImage('up.png') : Theme::getThemeImage('down.png');
						
					$fd_orderb_link->add(agt("fd_$orderb"), _HTML_SPACE, 
						$fd_orderb_image);
				} else {
					$fd_orderb_link = html_a(Util::format_URLPath('authortool/index.php',
						"status=list&amp;current_folder_id=".
						$this->FolderProperties['folder_id']."&amp;orderby=$orderb&amp;
						orderhow=0"), agt("fd_$orderb"), NULL, '_top', 
						agt("fd_orderby")._HTML_SPACE.agt($orderb));
				}
				
				$fd_orderb[$i] = html_th($fd_orderb_link);
				
				if ($orderb == "name")
				{
					$fd_orderb[$i]->set_tag_attribute('colspan', 2);
				}
				
				$i++;
			}
		}
		
		$tableFolder->add(
			//html_th(_HTML_SPACE),
			$fd_orderb[0],
			$fd_orderb[1],
			$fd_orderb[2],
			$fd_orderb[3],
			$fd_orderb[4],
			$fd_orderb[5],
			$fd_orderb[6]);
		
		/*
		 * checkbox index
		 */
		$i = 0;
		/*
		 * initial cell color
		 */
		$altcellcolor = "altcellcolor2";
		/*
		 * Now we'll add the folder list to the table
		 */
		foreach($this->FolderList as $FolderElement)
		{
			/*
			* Alternate cell color
			*/
			$altcellcolor = ($altcellcolor == "altcellcolor1") ? "altcellcolor2": 
				"altcellcolor1";
			
			if ($FolderElement['shared'] == 1)
			{
				$folderImage =  Theme::getThemeImage("modules/links.png");
			} else {
				$folderImage =  Theme::getThemeImage("filemanager/folder.png");
			}
			
			/*
			* Now depending on enviromental permissions, we'll add possible actions:
			*/
			$actions = "";
			if ($FolderElement['folder_perms']['w'])
			{
				/*
				* Add edit action
				*/
				$actions = html_div();
				$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
					"status=send_folder&amp;current_folder_id=".$FolderElement['folder_id']), 
					Theme::getThemeImage("edit.png"), NULL, '_top', agt('editfolder')));
				$actions->add(_HTML_SPACE);
				
				/*
				* Add delete action
				*/
				$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
					"status=delete&amp;what=folder&amp;current_folder_id=".
					$FolderElement['folder_id']), 
					Theme::getThemeImage("delete.png"), NULL, '_top', 
					agt('deletefolder')));
				
				if (!$FolderElement['shared'])
				{
					/*
					* Add share action
					*/
					$actions->add(_HTML_SPACE);
					$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
					"status=send_folder&amp;submit=1&amp;shared=1".
					"&amp;folder_id=".$FolderElement['folder_id'].
					"&amp;current_folder_id=".$FolderProperties['folder_id'].
					"&amp;folder_name=".$FolderElement['folder_name'].
					"&amp;folder_comment=".$FolderElement['folder_comment'].
					"&amp;folder_perms=".$FolderElement['folder_perms2']),
					Theme::getThemeImage("modules/links.png"), NULL, '_top', 
					agt('sharefolder')));
				}
			}
			
			/*
			* Now we'll set the folder name element, which will be a
			* link to access to the folder. It will have the number of
			* direct folder and files it has in brakets.
			*/
			
			$link = html_a(Util::format_URLPath('authortool/index.php', 
				"status=list&amp;current_folder_id=".$FolderElement['folder_id']), 
					$FolderElement['folder_name'], NULL, '_top', agt('accessfolder'));
					
			$count_element = " (".$FolderElement['folder_count_element'].")";
			
			$link_td = html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
				NULL, NULL);
			$link_td->add($link, $count_element);
			
			/*
			* Add current row to the table 
			*/ 
			$tableFolder->add_row(
				/*html_td("altcellcolor2", NULL,
					$this->add_element($this->form_checkbox("ckbxfo[$i]",
						$FolderElement['folder_id']))),*/
				html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
					NULL, NULL, $folderImage),
				$link_td,
				html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
					NULL, NULL, $FolderElement['folder_date']),
				html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
					NULL, NULL, substr($FolderElement['folder_comment'], 0, 30)),
				"&nbsp;", "&nbsp;", agt("fd_folder"),
				html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
					NULL, NULL, $actions));
			$i++;
		}
		
		/*
		 * Needed for guessing file icon depending n the file extension
		 */
		include_once (Util::app_Path("filemanager/include/classes/filedisplay.class.php"));
		
		/*
		 * Now we'll add the file list to the table
		 */
		if ($this->FileList[0]['document_id'] == NULL && $this->FolderList == NULL)
		{
			$the_td = html_td(NULL, NULL, agt('folder_empty'));
			$the_td->set_tag_attribute('colspan', 8);
			$the_td->set_tag_attribute('colspan', 8);
			$tableFolder->add_row($the_td);
		} else {
			foreach($this->FileList as $FileElement)
			{
				/*
				* Alternate cell color
				*/
				$altcellcolor = ($altcellcolor == "altcellcolor1") ? "altcellcolor2": 
				"altcellcolor1";
				
				/*
				* Guess document file type image
				*/
				$fileImage =  Theme::getThemeImage("filemanager/". 
					fileDisplay::choose_image($FileElement['document_name']));
				
				/*
				* Set posible actions depending on permissions
				*/
				$actions = html_div();
				if ($this->FolderProperties['folder_perms']['w'])
				{
					/*
					* Add edit action
					*/
					$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
						"status=send_file&amp;document_id=".$FileElement['document_id']), 
						Theme::getThemeImage("edit.png"), NULL, '_top', agt('editfile')));
					$actions->add(_HTML_SPACE);
					
					/*
					* Add delete action
					*/
					$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
						"status=delete&amp;what=document&amp;document_id=".
						$FileElement['document_id']), 
						Theme::getThemeImage("delete.png"), NULL, '_top', agt('deletefile')));
					
					if ($this->FolderProperties['folder_perms']['p'] && 
					!$FileElement['document_accepted'])
					{
						
						/*
						* Add share action
						*/
						$actions->add(_HTML_SPACE);
						$actions->add(html_a(Util::format_URLPath('authortool/index.php', 
						"status=send_document&amp;submit=1&amp;shared=1".
						"&amp;document_id=".$FileElement['document_id'].
						"&amp;document_comment=".$FileElement['document_comment'].
						"&amp;document_name=".$FileElement['document_name'].
						"&amp;document_mime=".$FileElement['document_mime'].
						"&amp;document_md5=".$FileElement['document_md5'].
						"&amp;document_junk=".$FileElement['document_junk'].
						"&amp;date_publish=".$FileElement['date_publish'].
						"&amp;document_name=".$FileElement['document_name'].
						"&amp;document_size=".$FileElement['document_size'].
						"&amp;authortool_editable=".$FileElement['authortool_editable'].
						"&amp;current_folder_id=".$FolderProperties['folder_id'].
						"&amp;folder_perms=".$FileElement['folder_perms2']),
						Theme::getThemeImage("modules/addpage.png"), NULL, '_top', 
						agt('sharefile')));
					}
				}
				/*
				* Show share satus image
				*/
				if ($FileElement['document_accepted'])
				{
					$accepted = Theme::getThemeImage("right.png");
				} else {
					$accepted = Theme::getThemeImage("wrong.png");
				}
				
				/*
				* Now we'll set the file name element, which will be a
				* link to show the file.
				*/
				$link = html_a(Util::format_URLPath('authortool/index.php', 
					"status=show_file&amp;document_id=".$FileElement['document_id']), 
						$FileElement['document_name'], NULL, '_top', agt('showfile'));
				
				/*
				* Add current row to the table 
				*/
				$tableFolder->add_row(
					/*html_td("altcellcolor2", NULL,
						$this->add_element($this->form_checkbox("ckbxfi[$i]",
							$FolderElement['document_id']))),*/
					html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
						NULL, NULL, $fileImage),
					html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
						NULL, NULL, $link),
					html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
						NULL, NULL, $FileElement['date_publish']),
					html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
						NULL, NULL, substr($FileElement['document_comment'], 0, 30)),
					html_td('altcellcolor2', NULL, $FileElement['user_alias']),
					html_td('altcellcolor2', NULL, $accepted),
					html_td('altcellcolor2', NULL, $FileElement['document_mime']),
					html_td(($altcellcolor == "altcellcolor2") ? $altcellcolor :
						NULL, NULL, $actions));
				$i++;
			}
		}
		/*
		 * Finally add table to the main element (the div)
		 */
		$div->add($tableFolder);
		
		/*
		 * Add checkboxex actions (only delete for now)
		 *//*
		$submitdel = form_submit('delete', agt('delete'));
		$submitdel->add(Theme::getThemeImage('filemanager/delete.gif'));
		
		$div->add(Theme::getThemeImage('filemanager/arrow_ltr.gif'));
		$div->add(_HTML_SPACE);
		$div->add(agt('execution'));
		$div->add(_HTML_SPACE);
		$div->add($submitdel);*/

		return $div;
	}
}
?>