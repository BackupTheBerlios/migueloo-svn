<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |      
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage control
 */

/**
 * Define la clase controlador base de miguel.
 * Se definen los elementos básicos de un controlador para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage control
 * @version 1.0.0
 *
 */
class base_Controller
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_moduleName = '';
    /**
	 * @access private
	 * @var string
	 */
	var $str_viewClass = '';
	/**
	 * @access private
	 * @var string
	 */
	var $str_modelClass = '';
	/**
	 * @access private
	 * @var boolean
	 */
	var $bol_isCacheable = true;
	/**
	 * @access private
	 * @var boolean
	 */
	var $str_cacheFile = '';
	/**
	 * @access private
	 */
	var $obj_data = null;
	/**
	 * @access private
	 */
	var $arr_commarea = null;
	/**
	 * @access private
	 */
	var $arr_form = null;
	/**
	 * @access private
	 */
	var $registry = null;


	/**
	 * Constructor.
	 * @param boolean $check Control de aplicación configurada. Por defecto, se controla (true).
	 */
	function base_Controller($bol_check = true)
	{
        if($bol_check){
			//Preparamos la sesión
			$obj_session = &Session::start();

			//Obtenemos el registro de miguel
			$this->registry = &Registry::start();
			
			
		}

		if(MIGUELBASE_CACHEABLE){
			$this->bol_isCacheable = true;
		} else {
			$this->bol_isCacheable = false;
		}
    }

	/**
	 * Permite asignar una Vista al controlador.
	 * @param string $str_nameClass Nombre de la clase que define la vista.
	 */
	function setViewClass($str_nameClass)
	{
    	if(file_exists(Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($str_nameClass).'.class.php'))) {
    		$this->str_viewClass = $str_nameClass;
    		
    		if($this->str_cacheFile == ''){
				if($this->bol_isCacheable){
					$this->str_cacheFile = MIGUELBASE_CACHE_DIR.$str_nameClass.'.cch';
				}
    	   }
    	}    	
    }
    
    /**
	 * Asigna el valor de una variable que se usará en la vista.
	 * @param string $str_name Nombre de la variable.
	 * @param mixto $mix_value Valor de la variable.
	 */
	function setViewVariable($str_name, $mix_value)
	{
    	if($str_name != ''){
    		$this->arr_commarea["$str_name"] = $mix_value;
    	}

    }

    /**
	 * Obtiene el valor de una variable que se definió en la vista.
	 * @param string $str_name Nombre de la variable.
	 * @return mixto Valor de la variable, null si no existe.
	 */
	function getViewVariable($str_name)
	{
    	$ret_val = null;
    	if (isset($this->arr_form["$str_name"]) ){
    		$ret_val = $this->arr_form["$str_name"];
    	} else {
			if (isset($this->arr_commarea["$str_name"]) ){
    			$ret_val = $this->arr_commarea["$str_name"];
    		}
		}

    	return $ret_val;
    }

    /**
	 * Comprueba la existencia de una variable en el retorno de la vista.
	 * @param string $str_name Nombre de la variable.
	 * @return boolean Valor de la variable, null si no existe.
	 */
	function issetViewVariable($str_name)
	{
    	$ret_val = false;

    	if(isset($this->arr_form)){
    		if (isset($this->arr_form["$str_name"]) ){
    			$ret_val = true;
    		}
    	} else {
    		if(isset($this->arr_commarea)){
    			if (isset($this->arr_commarea["$str_name"]) ){
    				$ret_val = true;
    			}
    		}
    	}

    	return $ret_val;
    }

    /**
	 * Permite asignar una Vista al controlador.
	 * @param string $str_newClass Nombre de la clase que define el modelo.
	 */
	function setModelClass($str_nameClass)
	{
	   if($str_nameClass != ''){
    	   if(file_exists(Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($str_nameClass).'.class.php'))) {
    		  $this->str_modelClass = $str_nameClass;
    	   }
	   } else {
	       $this->str_modelClass = $str_nameClass;
	   }
    }

    /**
	 * Permite activar o desactivar el sistema de cache.
	 * @param boolean $bol_cache Para activar true, para desactivar false.
	 */
	function setCacheFlag($bol_cache)
	{
    	if(MIGUELBASE_CACHEABLE){
			$this->bol_isCacheable = $bol_cache;
		} else {
			$this->bol_isCacheable = false;
		}
    }

    /**
	 * Permite asignar un título a la página.
	 * @param boolean $str_title Título.
	 */
	function setPageTitle($str_title)
	{
    	if($str_title == ''){
    	   $str_title = 'Default title';
    	}
        $this->str_pageTitle = $str_title;
    }

    /**
	 * Asigna el nombre del módulo al que pertenece el controlador.
	 * @param string $str_name Nombre del módulo en el que se engloba el controlador.
	 */
	function setModuleName($str_name)
	{
    	if($str_name != ''){
    	   $this->str_moduleName = $str_name;
    	}
    }
    
    /**
	 * Permite asignar el nombre del fichero de cache.
	 * @param string $str_cacheName Nombre, sin extensiones ni path, del fichero.
	 */
	function setCacheFile($str_cacheName)
	{
        if($this->bol_isCacheable){
			if($str_cacheName == '') {
				$this->str_cacheFile = MIGUELBASE_CACHE_DIR.$this->str_viewClass.'.cch';
			} else {
				$this->str_cacheFile = MIGUELBASE_CACHE_DIR.$str_cacheName.'.cch';
			}
		}

    }

    /**
	 * Permite asignar un nuevo elemento (variable) a los datos de sesión.
	 * @param string $str_name Nombre del elemento (variable).
	 * @param mixto $mix_value Valor asociado.
	 */
	function setSessionElement($str_name, $mix_value)
	{
    	Session::setValue("$str_name", $mix_value);
    }
    
    /**
	 * Permite asignar un nuevo elemento (variable) a los datos de sesión partiendo de un array.
	 * Genera elementos de sesión, uno por cada elemento del array.
	 * @param string $str_name Nombre del elemento (variable).
	 * @param array $arr_value Valor asociado en un array.
	 */
	function setSessionArray($str_name, $arr_value)
	{
        if(is_string($str_name)) {
            if(is_array($arr_value)) {
                foreach($arr_value as $key => $val) {
		  		  Session::setValue($str_name.'_'.$key, $val);
		  	    }
	       }
        }
    }

    /**
	 * Elimina un elemento (variable) de los datos de sesión.
	 * @param string $str_name Nombre del elemento (variable).
	 * @return mixto Valor asociado.
	 */
	function unsetSessionElement($str_name, $str_key = '')
	{
		if($str_name != ''){
			if($str_key != ''){
				$name ="$str_name".'_'.$str_key;
				Session::unsetValue($name);
			} else {
				$name = $str_name;
				Session::unsetValue($name);
			}
		}
    }

    /**
	 * Elimina un elemento (variable) de los datos de sesión.
	 * @param string $str_name Nombre del elemento (variable).
	 * @return mixto Valor asociado.
	 *
	 * @deprecated.
	 */
	function clearSessionElement($str_name, $str_key = '')
	{
    	$this->unsetSessionElement($str_name, $str_key = '');
    }

    /**
	 * Elimina un elemento (variable) de los datos de sesión.
	 * @param string $str_name Nombre del elemento (variable).
	 * @return mixto Valor asociado.
	 */
	function getSessionElement($str_name, $str_key = '')
	{
		$ret_val = null;
		if($str_name != ''){
			if($str_key != ''){
				$name ="$str_name".'_'.$str_key;
				$ret_val = Session::getValue($name);
			} else {
				$name = $str_name;
				$ret_val = Session::getValue($name);
			}
		}
		return $ret_val;
    }

	/**
	 * Comprueba la existencia de una variable en el retorno de la vista.
	 * @param string $str_name Nombre de la variable.
	 * @return boolean Valor de la variable, null si no existe.
	 */
	function issetSessionElement($str_name, $str_key = '')
	{
    	$ret_val = false;

        if($str_name != ''){
			if($str_key != ''){
				if(Session::issetValue($str_name.'_'.$str_key)){
					$ret_val = true;
				}
			}
		}

    	return $ret_val;
    }

    /**
	 * Contiene la funcionalidad del controlador.
	 * Se debe sobreescribir por las clases que heredan de esta.
	 */
    function processPetition()
    {
    	$arr_menuElem[]= array ('url' => app_URLPath('index.php'), 'name' => Session::getValue('siteName'));
    }

    /**
	 * Obtiene el contenido de la Vista ya procesado.
	 * @internal
	 */
    function _getViewContent()
    {	
    	$ret_val = '';
        //include_once(Util::base_Path('view/classes/miguel_VPage.class.php'));
        if(file_exists(Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($this->str_viewClass).'.class.php'))) {
            include (Util::app_Path($this->str_moduleName.'/view/classes/'.strtolower($this->str_viewClass).'.class.php'));
            $obj_view = new $this->str_viewClass($this->str_pageTitle, $this->arr_commarea);
		}

		if (isset($obj_view)) {
			$obj_view->initialize();
    		$ret_val = $obj_view->render();
    		unset($obj_view);
    	}
        return $ret_val;
    }
	
	/**
	 * Pasa el control a un controlador diferente
	 * @param string $moduleName Nombre del módulo a instanciar
     * @param string $class Clase controlador
	 *
	 */
	function giveControl($moduleName, $class)
	{
		if(file_exists(Util::app_Path($moduleName.'/control/classes/'.strtolower($class).'.class.php'))) {
            include (Util::app_Path($moduleName.'/control/classes/'.strtolower($class).'.class.php'));
            $new_control = new $class();
		}
		
		if (isset($new_control)) {
			$new_control->Exec();
    	}
		
		exit();
	}
    
    /**
	 * Escribe un mensaje en el log.
	 * @param string $message Mensaje a guardar en el Log.
     * @param string $priority Nivel de log.
	 */
    function log($message, $priority)
    {	
    	include_once(Util::base_Path('include/classes/loghandler.class.php'));
  		LogHandler::log($message, $this->str_moduleName.'_controller', $priority);
    }
    
    /**
	 * Lanza un error al sistema de errores.
	 * @param string $msg_error Literal asociado al error
	 *
	 * @todo Optimización general del sistema de errores
	 *
	 * @internal
     *
	 */
    function _setError($msg_error, $type_error = E_USER_ERROR)
    {
		trigger_error($msg_error, $type_error);
    }
}
?>
