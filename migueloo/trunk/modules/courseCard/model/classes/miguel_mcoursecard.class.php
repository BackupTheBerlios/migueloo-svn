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
      | Authors: Miguel Majuelos Mudarra <www.polar.es>                      |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel auth
 * @subpackage model
 * @version 1.0.0
 *
 */
/**
 * Include libraries
 */



class miguel_MCourseCard extends base_Model
{
        /**
         * This is the constructor.
         *
         */
    function miguel_MCourseCard()
    {
        //Llama al constructor de la superclase del Modelo
        $this->base_Model();
    }

	function getCourseCard($course_id)
	{
	    $arrTmp = $this->Select('course_card', ' objectives, description, contents',"course_id = $course_id");

	    if (!$this->hasError() && $arrTmp[0]['course_card.objectives']!=null)	{
				$arrRet['objectives'] = $arrTmp[0]['course_card.objectives'];
				$arrRet['description'] = $arrTmp[0]['course_card.description'];
				$arrRet['contents'] = $arrTmp[0]['course_card.contents'];
		}
		return $arrRet;
	}

	//===============================================================
	//	Crea un nueva ficha.
	//===============================================================
	function newCourseCard($course_id, $objectives, $descripton, $contents)
	{
			$this->Insert('course_card', 
			 					' course_id,objectives, description, contents',
								array($course_id,$objectives,$descripton,$contents));

	        if ($this->hasError()) {
		    	$ret_val = null;
				} 
			return($ret_val);			 	
	}

	//===============================================================
	//	Modifica la ficha indicada
	//===============================================================
	function updateCourseCard($course_id, $objectives, $descripton, $contents)
    {
     		$iMyId = Session::getValue('USERINFO_USER_ID');

			//Atención: Los mensajes con estado 2 no se verán afectados.    
	      	$ret_val = $this->Update('course_card', 
								 					' objectives, description, contents',
													  array($objectives,$descripton,$contents), 
													 "course_id = $course_id"); 

	        if ($this->hasError()) {
		    	$ret_val = null;
				} 
			return($ret_val);			 	
	}

}