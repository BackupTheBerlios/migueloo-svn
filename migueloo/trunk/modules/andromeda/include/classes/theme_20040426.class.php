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
      |          Antonio F. Cano <antoniofcano at telelefonica dot net>      |
      |          Monica Buj Gelonch <mbuj31@telefonica.net>                  |
      |          Eduardo R.E.    edulix at iespana dot es                    |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage include
 */
/**
 *
 */

/**
 * Define la clase para trabajar con el sistema de Temas.
 * Se plantea un manejador de temas visuales.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright LGPL - Ver LICENCE
 * @package framework
 * @subpackage include
 * @version 1.0.0
 *
 */
class Theme
{
    /**
     * Devuelve una lista con los temas disponibles.
     * 
     */
    function getActiveThemes()
    {
        $themelist = array();
        $dir = opendir(MIGUELBASE_THEME_DIR);

        while ($item = readdir ($dir)){
            if($item != '.' && $item != '..' && $item != 'CVS' && !is_file($item)){
                $themelist["$item"] = $item;
            }
        }
        closedir($dir);

        return $themelist;
    }
    
     /**
     * Comprueba si un tema existe en el sistema
     * @param string $theme Tema a ser comprobado
     * 
     */
    function existTheme($theme)
    {
        if(empty($theme)){
        	$ret_val = false;
        } else {
        	$ret_val = is_dir(MIGUELBASE_THEME_DIR.$theme) ? true : false;
        }
        
        return $ret_val;
    }
    
    /**
      * Devuelve el tema a utilizar
      *
      * @public
      */
     function getTheme ($theme = '') 
     {
     	if(!Theme::existTheme($theme)){
     		$ret_val = Theme::_getNormalTheme();
     	} else {
     		$ret_val = Theme::_getTheme($theme);
     	}
		
     	return $ret_val;
     }
     
     /**
      * Devuelve el tema a utilizar
      *
      * @public
      */
     function getURLTheme ($theme = '') 
     {
     	if(!Theme::existTheme($theme)){
     		$ret_val = Theme::_getURLNormalTheme();
     	} else {
     		$ret_val = Theme::_getURLTheme($theme);
     	}
		
     	return $ret_val;
     }
     
     /**
      * Devuelve el path al tema
      *
      * @public
      */
     function getThemeImagePath($imag_path) 
     {		
     	return Theme::getURLTheme().'image/'.$imag_path;
     }

     /**
      * Devuelve una imagen del tema
      *
      * @public
      */
     function getThemeImage($imag_path, $description = '') 
     {		
        return html_img( Theme::getURLTheme() . 'image/' . $imag_path, 0, 0, 0, $description);
     }
     
     
     /**
      * Devuelve el path al tema
      *
      * @public
      */
     function getThemeCSSPath($css_path) 
     {		
     	return Theme::getURLTheme().'css/'.$css_path;
     }
    
     /**
      * Devuelve el tema base a utilizar.
      *
      * @public
      */
     function _getNormalTheme() 
     {
     	return Theme::_getTheme('Miguel');
     }
     
     /**
      * Devuelve el tema base a utilizar.
      *
      * @public
      */
     function _getURLNormalTheme() 
     {
     	return Theme::_getURLTheme('Miguel');
     }
     
     /**
      * Devuelve el tema base a utilizar.
      *
      * @public
      */
     function _getTheme($theme) 
     {
     	return MIGUELBASE_THEME_DIR.$theme.'/';
     }
     
     /**
      * Devuelve el tema base a utilizar.
      *
      * @public
      */
     function _getURLTheme($theme) 
     {
     	return MIGUELBASE_THEME_URLDIR.$theme.'/';
     }
}
?>

<?php
//        /**
//          * given an user id, it shown the theme that he have selected
//          *
//          * @param $uid this is the user_id of the user we'd like to now it's prefered theme
//          */
//        function getThemeUser($_uid){
//                $getTheme = mysql_query("SELECT theme FROM " . $GLOBALS['mysqlMainDb'] . ".user WHERE user_id='$_uid'");
//                while ($mythemeuser = mysql_fetch_array($getTheme)){
//                        $ThemeUser=$mythemeuser[0];
//                }
//                return $ThemeUser;
//        }
//
//
//        /**
//          * sets a default theme for the user with the id given
//          *
//          * @param $uid this is the user_id of the user we'd like to set it's new prefered theme
//          */
//        function setThemeUser($uid, $theme){
//                $setTheme = $mysql_query("INSERT INTO $mysqlMainDb.user (theme) VALUE($theme) WHERE user_id='$uid'");
//        }
//
//       
//
//        /**
//          * This function set the actual theme to the one given
//          *
//          * @param $theme_actual theme name
//          *
//          * @public
//          */
//
//        function setActualTheme ($theme_actual) {
//                $GLOBAL['theme'] = $theme_actual;
//        }
?>
