<?php
/*
      +----------------------------------------------------------------------+
      |forum                                                                 |
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
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package forum
 * @subpackage view
 * @version 1.0.0
 */
 
class miguel_forumMenuform extends base_FormContent 
{
    function form_init_elements() 
    {
		$arrOrden['Por fecha']='fecha';
		$arrOrden['Por autor']='autor';
		$arrOrden['Por tema']='tema';
				
		$ListOrden = $this->_formatElem("FEListBox", "orden", "orden", FALSE, "100px", NULL, $arrOrden);
		$ListOrden->set_attribute('class','');
        $this->add_element($ListOrden);    		  
				
		//AÃ±ade un boton con la acciÃ³n submit
        $submit = $this->_formatElem('base_SubmitButton', 'Aceptar', 'sort', 'Ordenar');
        $submit->set_attribute('class','p'); 
        $submit->set_attribute('accesskey','e');               
        $this->add_element($submit);    		  
        
		$this->add_hidden_element('status');
   		$this->set_hidden_element_value('status', 'list_post');
		$this->add_hidden_element('id_forum');
		$this->add_hidden_element('id_topic');
    }

    function form_init_data() 
    { 			
    		$this->set_hidden_element_value('id_forum', $this->getViewVariable('id_forum'));
    		$this->set_hidden_element_value('id_topic', $this->getViewVariable('id_topic'));
	     	 //$this->set_element_value('From', $this->getViewVariable('from'));
	       //$this->set_element_value('Nombre', $this->getViewVariable('nombre'));
	       //$this->set_element_value('Descripción', $this->getViewVariable('descripcion'));
    }
    
	function form() 
    {
    	  //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario

        $table = &html_table('40%', 0, 0, 0, 'center');
        $table->set_class('ptabla03');
		
		$param = '&id_forum='.$this->getViewVariable('id_forum').'&id_topic='.$this->getViewVariable('id_topic');
		
		$link = html_td('p','',html_a(Util::format_URLPath('forum/index.php','status=new_post'.$param), agt('Añadir nuevo hilo'), 'boton02a'));
		
		$this->set_form_tabindex('orden', '14'); 
		$sort = html_td('ptabla03','',$this->element_form('orden'));
				
        $this->set_form_tabindex('Aceptar', '15'); 
        $boton = html_td('ptabla03','', $this->element_form('Aceptar'));
        //$boton->set_tag_attribute('valign', 'center');
		
		$table->add_row($link, $sort, $boton);
        
        return $table; 
    }
}

?>

