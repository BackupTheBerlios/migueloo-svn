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
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage view
 */
/**
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 * Utiliza la libreria phphtmllib.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */

class miguel_FormContent extends FormContent
{
    /**
	 * @access private
	 */
	var $arr_commarea = null;
	
	function miguel_FormContent($arr_commarea = null)
    {   
        $this->arr_commarea = $arr_commarea;
        
        $this->FormContent();
    }
    
    function form_action() {
        return true;
    }
	
	function form_backend_validation() 
    {
        return true;
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
     * @access private
     */
    function _tableRow($name, $style = '', $width = '')
    {
    	$label = html_td('ptabla02', '', $this->element_label($name));
    	$action = html_td('ptabla03', '', $this->element_form($name));
		
		if($width != ''){
			$label->set_tag_attribute('width', $width);
		}
		
		$row = html_tr();
        $row->add($label, $action);
    	
    	return($row);
    }
    
    /**
     * @access private
     */
    function _formatElem($classname) 
    {
	    $phpcode = "return new {$classname}(";
	    
	    if (func_num_args() > 2) {
	       $newparams = array_slice(func_get_args(),1);

	       for($i=1; $i<count($newparams) ; $i++) {
		   if ($i > 1) {
		       $phpcode .= ',';
		   }
		   $phpcode .= '$newparams[' . $i . ']';
	       }
	   }
	   
	   $phpcode .= ');';
	   
	   //echo "<pre>"; print_r($newparams); echo $phpcode; echo "</pre>";
	   $elem = eval($phpcode);
	   $elem->set_label_text($newparams[0]);
	   
	   return($elem);
    }
    
    /**
     * @access private
     */
    function _submitButton($value, $label)
    {
	    $button = new  FESubmitButton($value, $label);
	    $button->set_style_attribute('class', '');
	    //$button->set_attribute('loc');
	    $button->onClick("disable=false");
	   
	    return($button);
    }
	
	/**
     * @access private
     */
    function _getShowElement($name, $tab_index, $label, $text, $element)
    {
	    $this->set_form_tabindex($name, $tab_index);
        $label = html_label($label);
        $label->add(container(html_b( agt($text) ), html_br(), $this->element_form($element)));
	
	    return($label);
    }
    
    /**
     * @access private
     */
    function _showElement($name, $tab_index, $label, $text, $element, $align )
    {
	    $label = $this->_getShowElement($name, $tab_index, $label, $text, $element);
        $elem = html_td("", $align, $label);
        //$elem->set_id("identification");
	
	    return($elem);
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
                $link = html_a("#","");
                $link->add(html_img(Theme::getThemeImagePath($str_image), null, null, null, $str_image_text));
                if($str_param == ''){
                        $path_action = Util::format_URLPath($str_url);
                } else {
                        $path_action = Util::format_URLPath($str_url, $str_param);
                }

                $path_action = Util::format_URLPath($str_url, $str_param);
                $link->set_tag_attribute("onClick", "javascript:newWin('".$path_action."', ".$int_w.", ".$int_h.", ".$int_x.", ".$int_y.")");

                return $link;
        }
}

?>
