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
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage view
 */
/**
 *
 */
include_once(Util::base_Path('view/includes.inc.php'));

/**
 * Define la clase base para las pantallas de miguel.
 *
 * Se define una plantilla común para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentará la información
 *  + Bloque de pie en la parte inferior
 * <pre>
 * --------------------------------
 * |         header block         |
 * --------------------------------
 * |                              |
 * |         data block           |
 * |                              |
 * --------------------------------
 * |         footer block         |
 * --------------------------------
 * </pre>
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */

class base_LayoutPage extends PageWidget
{
        /**
         * @access private
         * @var string
         */
        var $str_renderType = XHTML;
        /**
         * @access private
         */
        var $arr_commarea = null;
        /**
         * @access private
         */
        var $registry = null;

        /**
         * Constructor.
         * @param string $str_title Título de la página
         * @param array $arr_commarea Variables necesarias para la visualización de la vista
         *
         */
    function base_LayoutPage($str_title, $arr_commarea)
    {
        $this->arr_commarea = $arr_commarea;

        //Obtenemos el registro de miguel
        $this->registry = &Registry::start();

        //Superclass initialization
        $this->PageWidget(agt($str_title), $this->str_renderType );
    }

    function initialize()
    {
                return null;
    }

        /**
         * Define la estructura global de la página
         *
         */
        function body_content()
        {
                return null;
        }

	/**
		* Permite añadir un formulario en la página
		* @param string $str_moduleName Nombre del módulo al que pertenece
		* @param string $str_className Nombre de la clase Formulario
		* @param string $str_param Parametros adicionales (opcional)
		* @return object FormProcessor
		*/
	function addForm($str_moduleName, $str_className, $str_param = '')
	{
		$ret_val = container();

		$this->registry->pushApp('common');


		$file_name = Util::app_Path($str_moduleName.'/view/classes/'.strtolower($str_className).'.class.php');
		
		/*
		if($this->issetViewVariable('wm')){
			if($str_param == ''){
				$str_param = 'wm';
			} else {
				$str_param = 'wm&'.$str_param;
			}
			$str_param = 'wm';
		}
		*/
		
		if($this->issetViewVariable('wm')){
		
		}

		if(file_exists($file_name)) {
			include($file_name);
			if($str_param == ''){
				$ret_val = new FormProcessor(new $str_className($this->arr_commarea), strtolower($str_className), Util::format_URLPath(trim(str_replace( '/'.MIGUELBASE_MODULES_BASE, ' ', $_SERVER['PHP_SELF']))));
			} else {
				$ret_val = new FormProcessor(new $str_className($this->arr_commarea), strtolower($str_className), Util::format_URLPath(trim(str_replace( '/'.MIGUELBASE_MODULES_BASE, ' ', $_SERVER['PHP_SELF'])), $str_param));
			}
			//$ret_val->set_form_target('parent');
			
			/*
			if($this->issetViewVariable('wm')){
				$ret_val->set_onsubmit('self.close()');
			}
			*/
		}

		$this->registry->popApp('common');

		return $ret_val;
    }

        /**
         * Permite añadir un enlace pop-up en la ventana
         * @param string $str_url Nombre del módulo que se invoca
         * @param string $str_param Parametros adicionales (opcional)
         * @param string $str_image Nombre de la imagen
         * @param string $str_image_text Texto para la imagen (opcional)
         * @param string $int_h Ancho de la ventana (opcional)
         * @param string $int_w Alto de la ventana (opcional)
         * @param string $int_x Posición horizontal de la ventana (opcional)
         * @param string $int_y Posición vertical de la ventana (opcional)
         * @return object Instancia de html_a
         */
        function addPopup($str_url, $str_image, $str_param = '', $str_image_text = '', $int_w = 0, $int_h = 0, $int_x = 0, $int_y = 0)
        {
                if($str_param == ''){
                        $path_action = Util::format_URLPath($str_url);
                } else {
                        $path_action = Util::format_URLPath($str_url, $str_param);
                }
				$path_action = Util::format_URLPath($str_url, $str_param);
				$link = html_a($path_action);
				//$link = html_a('#','');
                $link->add(html_img(Theme::getThemeImagePath($str_image), null, null, null, $str_image_text));
                /*
				if($str_param == ''){
                        $path_action = Util::format_URLPath($str_url);
                } else {
                        $path_action = Util::format_URLPath($str_url, $str_param);
                }

                $path_action = Util::format_URLPath($str_url, $str_param);
                $link->set_tag_attribute('onClick', "javascript:newWin('".$path_action."', ".$int_w.", ".$int_h.", ".$int_x.", ".$int_y.")");
				$link->set_tag_attribute('onClick', "javascript:ponerIframe('".$path_action."')");
				*/
				$link->set_tag_attribute('target', 'myFrame');

                return $link;
        }

        function closePopup()
        {
                return;
        }

    /**
     * Lee el contenido de un fichero
     * @access private
     */
    function _addFileContent($filename)
    {
            return File::Read($filename);
    }

     /**
         * Comprueba la existencia de una variable en el retorno de la vista.
         * @param string $str_name Nombre de la variable
         * @return boolean Valor de la variable, null si no existe
         */
        function issetViewVariable($str_name)
        {
            $ret_val = false;

            if(isset($this->arr_commarea)){
                    if (isset($this->arr_commarea["$str_name"]) ){
                            $ret_val = true;
                    }
            }

            return $ret_val;
    }

    /**
         * Recupera el valor de una variable que se usará en la vista.
         * @param string $str_name Nombre de la variable
         * @return mixto Valor de la variable
         */
        function getViewVariable($str_name)
        {
            if($str_name != ''){
                    return $this->arr_commarea["$str_name"];
            } else {
                    return null;
            }
    }

    /**
         * Permite recuperar un elemento (variable) de los datos de sesión
         * @param string $str_name Nombre del elemento (variable)
         * @return mixto Valor asociado
         */
        function getSessionElement($str_name, $str_key = '')
        {
            $ret_val = null;
            if($str_name != ''){
               if($str_key != ''){
             $ret_val = Session::getValue("$str_name".'_'.$str_key);
           } else {
             $ret_val = Session::getValue("$str_name");
           }
        }

        return $ret_val;
    }

    /**
     * Permite comprobar el "permiso" en el sistema
            * @param string $str_name Nombre servicio
            * @param string $str_profile Perfil solicitante
            * @return boolean
            */
        function checkAccess($str_name, $str_profile)
           {
        return $this->registry->checkServiceAccess($str_name, $str_profile);
        }

        /**
     * Permite comprobar el "permiso" en el sistema usando gacl
            * @param string $str_name Nombre del elemento (variable)
            * @param string $str_name Nombre del elemento (variable)
            * @param string $str_name Nombre del elemento (variable)
            * @param string $str_name Nombre del elemento (variable)
            * @return boolean
         *
         * @since Despalzada implementación hasta versiones posteriores
            */
        /*
           function checkAccess($str_aco_sys, $str_aco_elem, $str_aro_sys, $str_aro_elem)
           {
        //Debug::oneVar($str_aco_sys,__FILE__, __LINE__);
        //Debug::oneVar($str_aco_elem,__FILE__, __LINE__);
        //Debug::oneVar($str_aro_sys,__FILE__, __LINE__);
        //Debug::oneVar($str_aro_elem,__FILE__, __LINE__);
        //Incluimos el API de phpgacl
        //define('ADODB_DIR', MIGUELBASE_ADODB);
               include_once(Util::base_Path('include/gacl/gacl.class.php'));

        //Probar el sistema de cache: ¿para qué? ADOdb cacheado ya.
               $arr_gacl_options = array(
                                                                'debug' => FALSE,
                                                                'items_per_page' => 100,
                                                                'max_select_box_items' => 100,
                                                                'max_search_return_items' => 200,
                                                                'db_type' => Session::getContextValue('ddbbSgbd'),
                                                                'db_host' => Session::getContextValue('ddbbServer'),
                                                                'db_user' => Session::getContextValue('ddbbUser'),
                                                                'db_password' => Session::getContextValue('ddbbPassword'),
                                                                'db_name' => Session::getContextValue('ddbbMainDb'),
                                                                'db_table_prefix' => 'gacl_',
                                                                'caching' => FALSE,
                                                                'force_cache_expire' => TRUE,
                                                                'cache_dir' => MIGUELBASE_CACHE_DIR,
                                                                'cache_expire_time' => MIGUELBASE_CACHE_TIME
                                                        );

               $obj_gacl = new gacl($arr_gacl_options);

               return $obj_gacl->acl_check($str_aco_sys, $str_aco_elem, $str_aro_sys, $str_aro_elem);
           }
        */
}
?>
