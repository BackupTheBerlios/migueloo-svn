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



class miguel_MModuleManager extends base_Model
{
        /**
         * This is the constructor.
         *
         */
    function miguel_MModuleManager()
    {
        //Llama al constructor de la superclase del Modelo
        $this->base_Model();
    }

  /*===================================================================
   	Crea la asociación entre submenú y opción
   	===================================================================*/
    function insertSubmenuOption($_submenu_id, $_option_id)
	{
			if ($_submenu_id == null || $_option_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$option = $this->Select('mm_submenu_option',
                                 'submenu_id',
                                 "submenu_id = $_submenu_id AND option_id = $_option_id");		

			//Si no está ya lo inserto
			if ($option[0]['mm_submenu_option.submenu_id']==null) {		
				$max = $this->freeExec("SELECT max(`orden`) as max_orden FROM `mm_submenu_option` WHERE `submenu_id` = $_submenu_id");		
				$orden = $max[0]['0'] + 1;
				$this->Insert('mm_submenu_option',
                                 'submenu_id, option_id, orden',
                                 "$_submenu_id,$_option_id, $orden");		
			}

		   	if ($this->hasError()) {
				return;
			}
	}

  /*===================================================================
   	Sube un puesto en el orden de una opción del submenu
   	===================================================================*/
    function upOrderSubmenuOption($_submenu_id, $_option_id)
	{
			if ($_submenu_id == null || $_option_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$arrOption = $this->SelectOrder('mm_submenu_option',
                                 'option_id, orden',
								 'orden',
                                 "submenu_id = $_submenu_id");		

			if ($arrOption[0]['mm_submenu_option.option_id']==null) {		
				return(null);
			}

			for ($i=0; $i<count($arrOption) && $arrOption[$i]['mm_submenu_option.option_id']!=$_option_id; $i++);
			if ($i>0 && $i<count($arrOption)) {
				$myOrder = $arrOption[$i]['mm_submenu_option.orden'];
				$newOrder = $arrOption[$i-1]['mm_submenu_option.orden'];
				$otherOptionId = $arrOption[$i-1]['mm_submenu_option.option_id'];
				$this->Update('mm_submenu_option',
										'orden',
										$newOrder,
		                                 "submenu_id = $_submenu_id AND option_id = $_option_id");		
				$this->Update('mm_submenu_option',
										'orden',
										$myOrder,
		                                 "submenu_id = $_submenu_id AND option_id = $otherOptionId");		
			
			}

			
	}

  /*===================================================================
   	Baja un puesto en el orden de una opción del submenu
   	===================================================================*/
    function downOrderSubmenuOption($_submenu_id, $_option_id)
	{
			if ($_submenu_id == null || $_option_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$arrOption = $this->SelectOrder('mm_submenu_option',
                                 'option_id, orden',
								 'orden',
                                 "submenu_id = $_submenu_id");		

			if ($arrOption[0]['mm_submenu_option.option_id']==null) {		
				return(null);
			}

			for ($i=0; $i<count($arrOption) && $arrOption[$i]['mm_submenu_option.option_id']!=$_option_id; $i++);
			if ($i+1<count($arrOption)) {
				$myOrder = $arrOption[$i]['mm_submenu_option.orden'];
				$newOrder = $arrOption[$i+1]['mm_submenu_option.orden'];
				$otherOptionId = $arrOption[$i+1]['mm_submenu_option.option_id'];
				$this->Update('mm_submenu_option',
										'orden',
										$newOrder,
		                                 "submenu_id = $_submenu_id AND option_id = $_option_id");		
				$this->Update('mm_submenu_option',
										'orden',
										$myOrder,
		                                 "submenu_id = $_submenu_id AND option_id = $otherOptionId");		
			
			}

			
	}

  /*===================================================================
   	Sube un puesto en el orden de un submenu
   	===================================================================*/
    function upOrderSubmenu($_menu_id, $_submenu_id)
	{
			if ($_submenu_id == null || $_menu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$arrOption = $this->SelectOrder('mm_menu_submenu',
                                 'submenu_id, orden',
								 'orden',
                                 "menu_id = $_menu_id");		

			if ($arrOption[0]['mm_menu_submenu.submenu_id']==null) {		
				return(null);
			}

			for ($i=0; $i<count($arrOption) && $arrOption[$i]['mm_menu_submenu.submenu_id']!=$_submenu_id; $i++);
			if ($i>0 && $i<count($arrOption)) {
				$myOrder = $arrOption[$i]['mm_menu_submenu.orden'];
				$newOrder = $arrOption[$i-1]['mm_menu_submenu.orden'];
				$otherSubmenuId = $arrOption[$i-1]['mm_menu_submenu.submenu_id'];
				$this->Update('mm_menu_submenu',
										'orden',
										$newOrder,
		                                 "menu_id = $_menu_id AND submenu_id = $_submenu_id");		
				$this->Update('mm_menu_submenu',
										'orden',
										$myOrder,
		                                 "menu_id = $_menu_id AND submenu_id = $otherSubmenuId");		
			
			}

			
	}

  /*===================================================================
   	Baja un puesto en el orden de un submenu
   	===================================================================*/
    function downOrderSubmenu($_menu_id, $_submenu_id)
	{
			if ($_submenu_id == null || $_menu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$arrOption = $this->SelectOrder('mm_menu_submenu',
                                 'submenu_id, orden',
								 'orden',
                                 "menu_id = $_menu_id");		

			if ($arrOption[0]['mm_menu_submenu.submenu_id']==null) {		
				return(null);
			}

			for ($i=0; $i<count($arrOption) && $arrOption[$i]['mm_menu_submenu.submenu_id']!=$_submenu_id; $i++);
			if ($i+1<count($arrOption)) {
				$myOrder = $arrOption[$i]['mm_menu_submenu.orden'];
				$newOrder = $arrOption[$i+1]['mm_menu_submenu.orden'];
				$otherSubmenuId = $arrOption[$i+1]['mm_menu_submenu.submenu_id'];
				$this->Update('mm_menu_submenu',
										'orden',
										$newOrder,
		                                 "menu_id = $_menu_id AND submenu_id = $_submenu_id");		
				$this->Update('mm_menu_submenu',
										'orden',
										$myOrder,
		                                 "menu_id = $_menu_id AND submenu_id = $otherSubmenuId");		
			
			}

			
	}




  /*===================================================================
   	Crea la asociación entre submenú y opción
   	===================================================================*/
    function deleteSubmenuOption($_submenu_id, $_option_id)
	{
	      $this->Delete('mm_submenu_option',
                                 "submenu_id = $_submenu_id AND option_id = $_option_id");		
	}

/*===================================================================
   	Crea la asociación entre submenú y opción
   	===================================================================*/
    function insertMenuSubmenu($_menu_id, $_submenu_id)
	{
	      	$option = $this->Select('mm_menu_submenu',
                                 'menu_id',
                                 "submenu_id = $_submenu_id AND menu_id = $_menu_id");	
			
			//Si no está ya lo inserto
			if ($option[0]['mm_menu_submenu.menu_id']==null) {		
				$max = $this->freeExec("SELECT max(`orden`) as max_orden FROM `mm_menu_submenu` WHERE `menu_id` = $_menu_id");		
				$orden = $max[0]['0'] + 1;
				$this->Insert('mm_menu_submenu',
                                 'menu_id, submenu_id, orden',
                                 "$_menu_id,$_submenu_id,$orden");		
			}

		   	if ($this->hasError()) {
				return;
			}
	}

  /*===================================================================
   	Crea la asociación entre submenú y opción
   	===================================================================*/
    function deleteMenuSubmenu($_menu_id, $_submenu_id)
	{
	      $this->Delete('mm_menu_submenu',
                                 "submenu_id = $_submenu_id AND menu_id = $_menu_id");		
	}

  /*===================================================================
   	Crea un submenú
   	===================================================================*/
    function insertSubmenu($_menu, $_name)
	{
	      	$submenu_id = $this->Insert('mm_submenu',
                                 'name',
                                 $_name);

		   	if ($this->hasError()) {
				return;
			}

	      	$this->Insert('mm_menu_submenu',
                                 'menu_id, submenu_id',
                                 "$_menu,$submenu_id");		
	}

  /*===================================================================
   	Crea una opción
   	===================================================================*/
    function insertOption($_submenu, $_name)
	{
 		 if ($_submenu == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$option_id = $this->Insert('mm_option',
                                 'name',
                                 $_name);

		   	if ($this->hasError()) {
				return;
			}

	      	$this->Insert('mm_submenu_option',
                                 'submenu_id, option_id',
                                 "$_submenu,$option_id");		
	}

  /*===================================================================
   	Borra un submenú
   	===================================================================*/
    function deleteSubmenu($_submenu)
	{
			if ($_submenu == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

	      	$this->Delete('mm_submenu',
                                 "submenu_id = $_submenu");


	      	$this->Delete('mm_menu_submenu',
                                 "submenu_id = $submenu");		

	      	$this->Delete('mm_submenu_option',
                                 "submenu_id = $submenu");		
	}


  /*===================================================================
   	Borra una opción
   	===================================================================*/
    function deleteOption($_option_id)
	{
			if ($_option_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}
	      	$this->Delete('mm_option',
                                 "option_id = $_option_id");		

	      	$this->Delete('mm_submenu_option',
                                 "option_id = $_option_id");		
	}


   /*===================================================================
   	Devuelve todas las opciones
   	===================================================================*/
    function getAllOptions()
	{
		   $arrOptions = $this->SelectMultiTable('mm_option, mm_module_file', 
											'mm_option.option_id, mm_option.name, mm_option.param, mm_module_file.name', 
											'mm_option.module_file_id = mm_module_file.module_file_id');

	    	if ($this->hasError() || count($arrOptions) == 0 || $arrOptions[0]['mm_option.name']==null) {
    			$ret_val = null;
    		} else {
				for ($i=0; $i<count($arrOptions); $i++) {
					$ret_val[$i]['name'] = $arrOptions[$i]['mm_option.name'];
					$ret_val[$i]['param'] = $arrOptions[$i]['mm_option.param'];
					$ret_val[$i]['option_id'] = $arrOptions[$i]['mm_option.option_id'];
					$ret_val[$i]['module_name'] = $arrOptions[$i]['mm_module_file.name'];
				}
			}

    	return ($ret_val);
	}

  /*===================================================================
   	Devuelve todos los submenus
   	===================================================================*/
    function getAllSubmenus()
	{
		   $arrSubmenus = $this->Select('mm_submenu', 
											'submenu_id, name', 
											'');

	    	if ($this->hasError() || count($arrSubmenus) == 0 || $arrSubmenus[0]['mm_submenu.name']==null) {
    			$ret_val = null;
    		} else {
				for ($i=0; $i<count($arrSubmenus); $i++) {
					$ret_val[$i]['name'] = $arrSubmenus[$i]['mm_submenu.name'];
					$ret_val[$i]['submenu_id'] = $arrSubmenus[$i]['mm_submenu.submenu_id'];
				}
			}

    	return ($ret_val);
	}

   /*===================================================================
   	Devuelve todas las opciones con una variable de asociación al submenu indicado
   	===================================================================*/
    function getCheckedOptions($_submenu_id)
	{
			if ($_submenu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}
		   $arrOptions = $this->getAllOptions();

		   for ($i=0; $i<count($arrOptions); $i++) {
				$option_id = $arrOptions[$i]['option_id'];
				$sub_opt = $this->Select('mm_submenu_option', 
												'option_id', 
												"option_id = $option_id AND submenu_id = $_submenu_id");
				if ($sub_opt[0]['mm_submenu_option.option_id'] == null) {
					$arrOptions[$i]['check'] = false;
				} else {
					$arrOptions[$i]['check'] = true;
				}
		   }
    	return ($arrOptions);
	}

   /*===================================================================
   	Devuelve todas los submenus con una variable de asociación al menu indicado
   	===================================================================*/
    function getCheckedSubmenus($_menu_id)
	{
			if ($_menu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}
		   $arrSubmenus = $this->getAllSubmenus();
		   for ($i=0; $i<count($arrSubmenus); $i++) {
				$submenu_id = $arrSubmenus[$i]['submenu_id'];
				$sub_opt = $this->Select('mm_menu_submenu', 
												'submenu_id', 
												"submenu_id = $submenu_id AND menu_id = $_menu_id");

				if ($sub_opt[0]['mm_menu_submenu.submenu_id'] == null) {
					$arrSubmenus[$i]['check'] = false;
				} else {
					$arrSubmenus[$i]['check'] = true;
				}
		   }
    	return ($arrSubmenus);
	}

   /*===================================================================
   	Devuelve las opciones de un submenú 
   	===================================================================*/
    function getSubmenu($submenu_id)
	{
			if ($submenu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

			$arrOptions = $this->SelectOrder('mm_submenu_option',
																	'option_id',
																	'orden',
																	"submenu_id = $submenu_id");

			if ($this->hasError() || count($arrOptions) == 0 || $arrOptions[0]['mm_submenu_option.option_id']==null) {
    			return(null);
    		}

			for ($i=0; $i<count($arrOptions); $i++) {
			   $option_id = $arrOptions[$i]['mm_submenu_option.option_id'];
			   $aux = $this->SelectMultiTable('mm_option, mm_module_file', 
											'mm_option.name, mm_option.param, mm_module_file.name', 
											"mm_option.option_id = $option_id AND mm_module_file.module_file_id = mm_option.module_file_id");

				$ret_val[$i]['name'] = $aux[0]['mm_option.name'];
				$ret_val[$i]['param'] = $aux[0]['mm_option.param'];
				$ret_val[$i]['option_id'] = $arrOptions[$i]['mm_submenu_option.option_id'];
				$ret_val[$i]['module_name'] = $aux[0]['mm_module_file.name'];
			}

    	return ($ret_val);
	}


   /*===================================================================
   	Devuelve las opciones de un menú 
   	===================================================================*/
    function getMenu($menu_id)
    {
		if ($menu_id == null) {
				Debug::msg('Error', __FILE__, __LINE__);
				return;
			}

			$arrSubmenus = $this->SelectOrder('mm_menu_submenu',
																		'submenu_id',
																		'orden',
																		"menu_id = $menu_id");

			if ($this->hasError() || count($arrSubmenus) == 0 || $arrSubmenus[0]['mm_menu_submenu.submenu_id']==null) {
				return(null);
			}

			for ($i=0; $i<count($arrSubmenus); $i++) {
				$submenu_id = $arrSubmenus[$i]['mm_menu_submenu.submenu_id'];
			 	$aux = $this->Select('mm_submenu', 
																	'name', 
																	"submenu_id = $submenu_id");
   				$ret_val[$i]['name'] = $aux[0]['mm_submenu.name'];
   				$ret_val[$i]['submenu_id'] = $arrSubmenus[$i]['mm_menu_submenu.submenu_id'];
				$arrOptions = $this->getSubmenu($arrSubmenus[$i]['mm_menu_submenu.submenu_id']);
				for ($j=0; $j<count($arrOptions); $j++)	{
							$ret_val[$i][$j]['name'] = $arrOptions[$j]['name'];
							$ret_val[$i][$j]['param'] = $arrOptions[$j]['param'];
							$ret_val[$i][$j]['option_id'] = $arrOptions[$j]['option_id'];
							$ret_val[$i][$j]['module_name'] = $arrOptions[$j]['module_name'];
					}
    		}

    	return ($ret_val);
    }


  /*===================================================================
   	Devuelve el id de una carpeta de módule a partir de su nombre. Si no existe en la tabla de BD 
	lo crea.
   	===================================================================*/
   function getModuleFolderId($_name)
    {

			$arrFolders = $this->Select('mm_module_file',
																		'module_file_id, name',
																		"name = $_name");
			if ($this->hasError() || count($arrFolders) == 0 || $arrFolders[0]['mm_module_file.name']==null) {
				$ret_val = $this->Insert('mm_module_file',
														'name',
														$_name);
			} else {
				$ret_val = $arrFolders[0]['mm_module_file.module_file_id'];
			}

		return ($ret_val);
    }

  /*===================================================================
   	Actualiza los datos de una opción
   	===================================================================*/
   function updateOption($_option_id, $_module_folder_id, $_param)
    {
				//Debug::oneVar($_option_id, __FILE__, __LINE__);
				//Debug::oneVar($_module_folder_id, __FILE__, __LINE__);
				//Debug::oneVar($_param, __FILE__, __LINE__);
			   $this->Update('mm_option', 
											'module_file_id, param',
											array($_module_folder_id, $_param),
											"option_id = $_option_id");
	}

}

