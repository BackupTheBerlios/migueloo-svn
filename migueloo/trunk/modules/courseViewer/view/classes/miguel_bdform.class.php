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
 
class miguel_bdForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();

		$arrElem = $this->getViewVariable('view_elem');

		if ($arrElem[0]['document_view_element.element_name']!=null)  { //Si no está vacío
	 		 	for ($i=0; $i<count($arrElem); $i++){
					switch($arrElem[$i]['document_view_element.type_id'])
					{
						case 1: //Text
							$arrObj[$i] = $this->_formatElem("FEText", 
												$arrElem[$i]['document_view_element.element_name'], 
												$arrElem[$i]['document_view_element.variable_name'], 
												FALSE, 
												50);
							break;
						case 2: //TextArea
							$arrObj[$i] = $this->_formatElem("FETextArea", 
												$arrElem[$i]['document_view_element.element_name'], 
												$arrElem[$i]['document_view_element.variable_name'], 
												FALSE, 
												10,
												60,
												'500px',
												'100px');
							break;
						case 3: //ListBox
							//Componer la lista de valores
							$arrIndex=explode (";", $arrElem[$i]['document_view_element.default']);
/*							for ($i=0; $i<count($arrIndex);$i++)
							{
								$arrValues["$arrIndex[$i]"]="$arrIndex[$i]";
							}

							Debug::oneVar($arrValues);
*/
								$arrOrden['Por fecha']='fecha';
							$arrOrden['Por autor']='autor';
							$arrOrden['Por tema']='tema';

							$arrObj[$i] = $this->_formatElem("FEListBox",  
												$arrElem[$i]['document_view_element.element_name'], 
												$arrElem[$i]['document_view_element.variable_name'], 
												FALSE, 
												'100px',
												NULL,
												$arrOrden);
												//$arrValues);
							break;
						case 4: //CheckBox
							$arrObj[$i] = $this->_formatElem("FECheckBox",  
												$arrElem[$i]['document_view_element.element_name'], 
												$arrElem[$i]['document_view_element.variable_name']);
							break;
					}
				}
			}
			Debug::oneVar($arrObj);
			//Añadimos la lista de objetos
			for ($i=0; $i<count($arrObj);$i++) {
				$arrObj[$i]->set_attribute('class','ptabla03');
		   		$this->add_element($arrObj[$i]);
			}
	}

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guÃ­a al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    { 	
		$arrElem = $this->getViewVariable('arrElem');
		/*
		if ($arrElem[0]['document_view_element.element_name']!=null)  { //Si no está vacío
	 		 	for ($i=0; $i<count($arrElem); $i++){
					if ($arrElem[$i]['document_view_element.type_id'] != 3) { //Las listas tomana los valores en su creación 
						 $this->set_element_value($arrElem[$i]['document_view_element.element_name'],
							 										$arrElem[$i]['document_view_element.default']);
					} //if
				} //for
		}//if
		*/
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form() 
    {
    	  //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);
        $table->set_class('ptabla02');
      
		$arrElem = $this->getViewVariable('arrElem');

		if ($arrElem[0]['document_view_element.element_name']!=null) { //Si no está vacío
			for ($i=0; $i<count($arrElem); $i++) {
				if($arrElem[$i]['document_view_element.type_id'] != 4){
					$table->add_row($this->_showElement($arrElem[$i]['document_view_element.element_name'], 
														'0', 
														$arrElem[$i]['document_view_element.variable_name'],
														$arrElem[$i]['document_view_element.label'],
														$arrElem[$i]['document_view_element.element_name'],
														'left'));
				} else {
					$table->add_row($this->formatCheckBox($arrElem[$i]['document_view_element.element_name'], 
															'0', 
															$arrElem[$i]['document_view_element.label'],
															'ok'
															));
				}
			} //for
		}//if
    
    /*    $this->set_form_tabindex('Aceptar', '10'); 
        $label = html_label( 'submit' );
        $label->add($this->element_form('Aceptar'));
        $table->add_row(html_td('', 'left',  $label));
      */  
        return $table; 
    }
	
	function formatCheckBox($element, $tab_index, $text, $status = '')
    {
	    $this->set_form_tabindex($element, $tab_index);
        $cont = container();
        $cont->add($this->element_form($element));
		switch($status){
			case 'ok':
				$img = Theme::getThemeImagePath('boton_green.gif');
				break;
			case 'ko':
				$img = Theme::getThemeImagePath('boton_red.gif');
				break;
			default:
				$img = Theme::getThemeImagePath('invisible.gif');
		}
		$cont->add(html_img($img));
		$cont->add(html_b(agt($text)));
	
	    return $cont;
    }
}

?>

