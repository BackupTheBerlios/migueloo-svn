<?php

/*
    +----------------------------------------------------------------------+
    | miguel_cerror.class.php    1.0                                       |
    +----------------------------------------------------------------------+
    | This software is part of miguel    version 0.1.1 $Revision: 1.3 $    |
    +----------------------------------------------------------------------+
    | Copyright (c) 2003, Asociacion Hispalinux                            |
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
    | Authors:                                                             |
    |         Jesus Martinez <jamarcer at inicia dot es>                   |
    +----------------------------------------------------------------------+
    | Email bugs/suggestions to the authors                                |
    +----------------------------------------------------------------------+
*/
/**
  * This class implements miguel's error system.
  *
  * @author     Jesus Martinez
  * @package    miguel
  * @subpackage utils
  * @version    1.4.1
  * 
  */
class miguel_CError extends base_Controller
{
    /**
	 *
	 */
	var $error = 0;
    /**
	 *
	 */
	var $error_message = '';

	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CError($err, $err_msg)
	{	
        $this->error = $err;
		$this->error_message = $err_msg;
		$this->base_Controller();
		$this->setModuleName('error');
		$this->setModelClass('');
		$this->setViewClass('miguel_VError');
		$this->setCacheFlag(false);
	}

	function processPetition()
	{
	    if($this->issetViewVariable('desc')){
	       $this->setViewVariable('str_error', $this->getViewVariable('desc'));
	    } else {
			$this->setViewVariable('str_error', $this->error.': '.$this->error_message);
		}
	    
	    if($this->issetViewVariable('url')){
	       $this->setViewVariable('str_url', $this->getViewVariable('url'));
	    } else {
	       $this->setViewVariable('str_url', Util::main_URLPath('index.php'));
	    }

        $this->setPageTitle('Error en miguel');

        $this->clearNavBarr();

        $this->setMessage(agt('miguel_ErrorLit'));
        
        $this->setHelp('');

        $this->setCacheFlag(true);
	}
}
?>
