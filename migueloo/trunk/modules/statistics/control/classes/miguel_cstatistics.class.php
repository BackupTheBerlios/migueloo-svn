<?php
/*
      +----------------------------------------------------------------------+
      |statistics/controller                                                 |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

class miguel_CStatistics extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CStatistics() 
	{	
		$this->miguel_Controller();
		$this->setModuleName('statistics');
		$this->setModelClass('miguel_MStatistics');
		$this->setViewClass('miguel_VStatistics');
		$this->setCacheFlag(false);
	}
	function processPetition() 	
	{
	
	  if ($this->issetViewVariable('status'))
	  {
	  	$status = $this->getViewVariable('status');
	  }
	  else
	  {
	  	$status = 'main';
	  	$status = $this->setViewVariable('status', 'main');
	  }
	  $this->addNavElement(Util::format_URLPath('statistics/index.php'), 'Página de Estadísticas');	
		  
    switch($status)
	  {
	  	case 'main': 
	  	default: 		
	  		//Presentación de tablón de anuncios
  			$arrUsers = $this->obj_data->getUsers();
  			$iTotalCon = 0;
				for ($i=0; $i<count($arrUsers); $i++)
				{
						$userId = $arrUsers[$i]['user.user_id'];
						$count = $this->obj_data->countLogin($userId);
						$arrUsers[$i]['countLogin'] = $count;
						$iTotalCon += $count;
				}  			
      	$this->setViewVariable('arrUsers', $arrUsers);	  		
      	$this->setViewVariable('iTotalCon', $iTotalCon);	  		
				break;
		}
		
		$this->setPageTitle("miguel statistics");
	  $this->setMessage("Estadísticas de miguel");

	  $this->setHelp("");
	}
}
?>