<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
      +----------------------------------------------------------------------+
      |   This library is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU Library General Public        |
      |   License as published by the Free Software Foundation; either       | 
      |   version 2 of the License, or (at your option) any later version.   |
      |                                                                      |
      |   This library is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU  |
      |   Library General Public License for more details.                   |
      |                                                                      |
      |   You should have received a copy of the GNU Library General Public  |
      |   License along with this program; if not, write to the Free         |
      |   Software Foundation, Inc., 59 Temple Place - Suite 330, Boston,    |
      |   MA 02111-1307, USA.                                                |      
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
/**
 * Include libraries
 */

class base_CError extends base_Controller
{
	/**
	 *
	 */
	var $str_error = ''; 
	/**
	 *
	 */
	var $url = ''; 
	/**
	 * This is the constructor.
	 *
	 */
	function base_CError($error = '', $url = '')
	{	
		$this->base_Controller();
		$this->setModuleName('base/include/error');
		//$this->setModelClass('miguel_MInstall');
		$this->setViewClass('base_VError');
		$this->setCacheFlag(false);
		
		if($error != ''){
			$this->str_error = $error;
		}
		if($url != ''){
			$this->url = $url;
		}
	}
	
     
	function processPetition() 
	{
		//$this->addNavElement(Util::format_URLPath($this->url), "Volver");
		//$this->addNavElement(Util::format_URLPath("base/include/error/index.php"), "Error");
		$this->setPageTitle("miguel Error Page");
		$this->setMessage("Detectado un error.");
		$this->setHelp("");
		
		$this->setViewVariable('str_error', $this->str_error);
		$this->setViewVariable('str_url', $this->url);
	}
    
}
