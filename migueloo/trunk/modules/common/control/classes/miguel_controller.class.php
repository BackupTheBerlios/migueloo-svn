<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
 * Todo el patrÛn MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage control
 */

/**
 * Define la clase controlador base de miguel.
 * Se definen los elementos b·sicos de un controlador para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage control
 * @version 1.0.0
 *
 */

class miguel_Controller extends base_Controller
{
	/**
	 * @access private
	 * @var boolean
	 */
	var $arr_menuElem = array();
	/**
	 * @access private
	 */
	var $str_pageTitle = '';
	

	/**
	 * Constructor.
	 * @param boolean $check Control de aplicaciÛn configurada. Por defecto, se controla (true).
	 */
	function miguel_Controller($bol_check = true)
	{	
	   $this->base_Controller($bol_check);
    }

	/**
	 * Arranca el controlador y ejecuta su funcionalidad
	 *
	 */
	function Exec()
	{
        //Recuperamos los par·metros recibidos
        if (!empty($_POST)) {
			foreach($_POST as $key => $value){
				$this->arr_form[$key] = $value;
			}
		} 
		if (!empty($_GET)) {
			foreach($_GET as $key => $value){
				$this->arr_form[$key] = $value;
			}		
		}

		if(isset($this->arr_form)){
			foreach($this->arr_form as $key => $value){
				$this->setViewVariable($key, $value);
			}
		}
		
        //Controlamos que el usuario esta logeado. Para evitar retornos desde el navegador
       	if (!$this->getSessionElement('session')){
	    	$this->alertView('Sesi�n no activa', 
							 'Para continuar trabajando en este Campus Virtual debe regresar a la p�gina de inicio y acceder de nuevo');
            //Session::setValue('session', true);
		} else {
	    	//Abrimos y Activamos acceso a BBDD
            if($this->str_modelClass != ''){
    	   	   	if(file_exists(Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($this->str_modelClass).".class.php"))) {
    	   	   		include (Util::app_Path($this->str_moduleName.'/model/classes/'.strtolower($this->str_modelClass).".class.php"));
                   	$this->obj_data = new $this->str_modelClass();

                   	$this->obj_data->openModel();
		  	   }
            }
            
            //Procesamos lÛgica de negocio
            $this->processPetition();
                   	
   	   //Desactivamos y Cerramos acceso a Base de datos
   	   if($this->str_modelClass != ''){
                $this->obj_data->closeModel();
                unset($this->obj_data);
           }
        }

        //Damos de alta en el registro el mÛdulo.
        $this->registry->pushApp($this->str_moduleName);
		    
    	//Preparamos el contenido de la pagina
	if($this->bol_isCacheable && file_exists($this->str_cacheFile) && (time() - filemtime($this->str_cacheFile) < MIGUELBASE_CACHE_TIME)) {
   		$str_content = File::Read($this->str_cacheFile);
    	} else {
    	   $this->_menuFile();
    	   $str_content = $this->_getViewContent();
    	}

	if($this->bol_isCacheable) {
		File::Write($this->str_cacheFile, $str_content);
	}

       	//Visualizamos la pagina
    	print $str_content;
    	unset($str_content);
    }

    /**
	 * Cierra el controlador, borrando contenidos y liberando recursos
	 *
	 */
	function Close(&$obj_model)
	{
		//Log de salida
		include_once(Util::app_Path("common/control/classes/miguel_userinfo.class.php"));
		$ok = miguel_UserInfo::setLogin($obj_model, $this->getSessionElement('userinfo', 'user_alias'), false);
		
		//Borramos menu_item.js
		$filename = Session::getValue('menufile');
		$menuFile = Util::formatPath(MIGUELBASE_CACHE_DIR.'/'.$filename);
		if (file_exists($menuFile)) {
			File::Delete($menuFile);
		}
		
		//Cerramos modelo
		$obj_model->closeDDBB();
		
		//Damos de baja en el registro el mÛdulo.
        $this->registry->popApp();

		//Cerrando la sesiÛn, se cierra el contexto.
		Session::close();
		
		$this->arr_form = array();
    }

    /**
	 * Permite asignar un tÌtulo a la p·gina
	 * @param boolean $str_title TÌtulo
	 */
	function setPageTitle($str_title)
	{
    	if($str_title == ''){
    	   $str_title = 'MiguelOO default title page';
    	}
        $this->str_pageTitle = $str_title;
    }

    /**
	 * Permite asignar un nuevo elemento a la barra de navegaciÛn
	 * @param string $str_url URL destino
	 * @param string $str_text Literal asociado
	 */
	function addNavElement($str_url, $str_text)
	{
    	$int_desp = -1;
    	$arr_bar = $this->getSessionElement('bar_array');
    	
    	for($i = 0;$i < count($arr_bar); $i++) {
    		if($arr_bar[$i]['url'] == $str_url) {
    			$int_desp = $i;
    		}
	    }
	
        if ($int_desp != -1) {
	    	$arr_bar = array_slice($arr_bar, 0, $int_desp);
	    }

	    $arr_bar[] = array ("url" => $str_url, "name" => $str_text);
	    $this->setSessionElement('bar_array', $arr_bar);
    }

    /**
	 * Permite limpiar la barra de navegaciÛn.
	 *
	 * Se eliminan todos los elementos.
	 *
	 */
	function clearNavBarr()
	{
	    $this->setSessionElement('bar_array', array());
    }

    /**
	 * Asigna el texto a mostrar en la barra de avisos
	 * @param string $str_value Texto.
	 */
	function setMessage($str_value)
	{
        if(is_string($str_value)) {
            $this->setViewVariable('str_message', $str_value);
        } else {
            $this->setViewVariable('str_message', '');
        }
    }

    /**
	 * Asigna el texto a mostrar en la barra de avisos
	 * @param string $str_value Texto.
	 */
	function setHelp($str_value)
	{
        if(is_string($str_value)) {
            $this->setViewVariable('str_help', $str_value);
        } else {
            $this->setViewVariable('str_help', '');
        }
    }

    /**
	 * Contiene la funcionalidad de control sobre el usuario.
	 * @param base_model $obj_model Instancia de un modelo
	 * @param string $str_username Identificador de usuario
	 * @param string $str_userpswd Clave de acceso a validar.
	 * @return boolean TRUE si tiene acceso, FALSE si no.
	 */
    function processUser(&$obj_model, $str_username, $str_userpswd)
    {
    	$ret_val = false;
		
        if (isset($str_username) && $str_username != ''){
			if (isset($str_userpswd) && $str_userpswd != ''){
			    include_once(Util::app_Path("common/control/classes/miguel_userinfo.class.php"));
				if(miguel_UserInfo::hasAccess($obj_model, $str_username,  $str_userpswd)) {
					if(miguel_UserInfo::isLogged($obj_model, $str_username)) {
						if($this->getSessionElement('userinfo', 'name') == $str_username) {
							//Control sobre re-login
							$ret_val = true;
						} else {
							$arr_userinfo = miguel_UserInfo::getInfo($obj_model, $str_username);
							$arr_userinfo['isadmin'] = miguel_UserInfo::isAdmin($obj_model, $str_username);
							$this->setSessionArray('userinfo', $arr_userinfo);
	
							$ok = miguel_UserInfo::setLogin($obj_model, $str_username);
	
							$ret_val = true;
						}
					}
				}
				//Debug::oneVar($_SESSION, __FILE__, __LINE__);
			}
		}
		
		return($ret_val);
	}

	/**
	* Presenta en pantalla el error detectado
	* @param string $msg_error Literal asociado al error
	* @param string $msg_url URL para el retorno
	*/
	function setError($msg_error, $type_error = E_USER_ERROR, $file = __FILE__, $line = __LINE__)
	{
		//Debug::oneVar($file, __FILE__, __LINE__);
		//Debug::oneVar($line, __FILE__, __LINE__);
		$msg_error = $this->str_moduleName.'_controller'.'::'.$msg_error;
		//Debug::oneVar($msg_error, __FILE__, __LINE__);
		//Debug::oneVar($type_error, __FILE__, __LINE__);
		//$this->_setError($msg_error, $type_error);
	}
	
	//Escribe el fichero de declaraci�n de items para el men�.
  	function _menuFile()
	{
		if(Session::getValue('USERINFO_USER_ID') != null){
			$file_name = Session::getValue('menufile');
			
			if(empty($file_name)){
				$file_name = 'menu_item_'.Session::getValue('USERINFO_USER_ID').'_'.date("YmdHis").'.js';
			}
			$menuFile = Util::formatPath(MIGUELBASE_CACHE_DIR.'/'.$file_name);
			
			if(file_exists($menuFile) && (time() - filemtime($menuFile) < MIGUELBASE_CACHE_TIME)) {
				File::Touch($menuFile);
			} else {
				//Si existe, se borra
				if (file_exists($menuFile)) {
					File::Delete($menuFile);
				}
				
				//Se crea, seg�n el perfil de usuario
				switch (Session::getValue('USERINFO_PROFILE_ID')) 
				{
					case 1:
						$strFile = 'menu_admin';
						break;
					case 2:
					case 3:
						$strFile = 'menu_profesor';
						break;
					case 4:
						$strFile = 'menu_alumno';
						break;
					case 5:
						$strFile = 'menu_secretaria';
						break;
					default:
						$strFile = 'menu';
						break;
				}
			
				include_once (Util::app_Path("common/control/classes/miguel_menubar.class.php"));
				$menubar = new miguel_MenuBar($strFile . '.xml');
				
				$str_content = 'var MENU_ITEMS = [';
				for ($i=0; $i<$menubar->countMenu(); $i++)
				{
					$str_content .= $menubar->getMenuCode($i, $superior);
				}
				
				$str_content .= '];';

				if (file_exists($menuFile)) {
					File::Delete($menuFile);
				}
				
				File::Write($menuFile, $str_content);
			}
			
			$this->setViewVariable('menufile', MIGUEL_URLDIR.'var/cache/'."$file_name");
			Session::setValue('menufile', $file_name);
		}
	}
	
	/**
	 * Invoca la ventana de mensajes
	 * @param string $_titulo Mensaje prinvipal de la ventana
	 * @param string $_texto Texto explicativo
	 */
	function alertView($_titulo, $_mensaje)
	{
		$this->setModuleName('common');
		$this->setViewClass("miguel_VAlert");
		$this->setSessionElement('bar_array', null);
		$this->setViewVariable('alert_', agt($_titulo));
		$this->setViewVariable('alert_text', agt($_mensaje));
	}
}
?>
