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

include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

/*
 * Define miguel View main class
 *
 * @author Eduardo Robles Elvira <edulix@iespana.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage view
 * @version 1.0.0
 *
 */ 
class miguel_VAuthorTool extends miguel_VMenu
{
	/*
	 * This is the constructor.
	 * @param string $title  Page title
	 * @param array $arr_commarea View data that was set in Control class
	 */
	function miguel_VAuthorTool($title, $arr_commarea)
	{
		$this->miguel_VMenu($title, $arr_commarea);
		$this->add_css_link(Theme::getThemeCSSPath('authortool.inc.css'));
	}

    /*
     * This function returns the contents of the right block.
     * @return HTMLTag object
     */
	function right_block()
	{
		/*
		 * As usual, we create a container and add to it the main elements
		 * and set some of its properties
		 */
		$ret_val = container();
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$ret_val->add($hr);
		
		$ret_val->add(html_h4(agt("miguel_AuthorTool")));
		
		/*
		 * Arrays of possible statuses. We'll use them to simplify the code
		 */
		$statusArray = array(1=>"List", "Send_File", "Send_Document", "Send_Folder", "Delete");
		$statusArray2 = array(1=>"list", "send_file", "send_document", "send_folder", "delete");
		$status = $this->getViewVariable('status');
		
		/*
		 * We check that satatus has a recognizable status for security.
		 * Note that we obviate that status var exists nbecause it was set in
		 * control class.
		 */
		if ($id = array_search($status, $statusArray2))
		{
			/*
			 * If any change form operation was executed,
			 * then show operation status.
			 */
			if ($this->issetViewVariable('submit'))
			{
				/*
				 * getViewVariable('opstat') is either
				 * '(db|fs|zipdirdb)?error' or 'success'.
				 */
				$opStat = html_div(agt("opstat-$status-".
					$this->getViewVariable('opstat')));
				
				$opStat->set_id("opstat");
				
				$ret_val->add($opStat);
			}
			
			$ret_val->add($this->addForm('authortool', 
				"miguel_VAuthorTool_".$statusArray[$id]));
		} elseif ($status == "Show_File")
		{
		 /*
		  * Show document!!!
		  */
		}
		
		return $ret_val;
	}
}
?>