<?php
/*
      +----------------------------------------------------------------------+
      |email                                                        |
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
 * @package email
 * @subpackage view
 * @version 1.0.0
 */

class miguel_selectoptionsForm extends base_FormContent
{
    function form_init_elements()
    {
				$arrOpt = $this->getViewVariable('arrOptions');
				$arrModuleFolders = $this->getViewVariable('arrModuleFolders');
				for ($i=0; $i<count($arrOpt); $i++) {
					if ($arrOpt[$i]['name'] != '')	{
						$opt_id = 'option' . $arrOpt[$i]['option_id'];
						$checkOpt[$i] = $this->_formatElem("FECheckBox",  $opt_id, $opt_id);
					    $checkOpt[$i]->set_attribute('class','ptabla03');
						$this->add_element($checkOpt[$i]);
						
						$combo_id = 'modulefile' . $arrOpt[$i]['option_id'];
						$comboOpt[$i] = $this->_formatElem("FEListBox", $combo_id, $combo_id, FALSE, "100px", NULL, $arrModuleFolders);
						$comboOpt[$i]->set_attribute('class','');
						$this->add_element($comboOpt[$i]);

						$param_id = 'param' .  $arrOpt[$i]['option_id'];
					    $paramOpt[$i] = $this->_formatElem("FEText", $param_id, $param_id, FALSE, 50);
					    $paramOpt[$i]->set_attribute('class','ptabla03'); 
						$this->add_element($paramOpt[$i]);
					}
				}

                //AÃ±ade un boton con la acciÃ³n submit  
                $submit = $this->_formatElem('base_SubmitButton', 'submit', 'submit', 'Aceptar');
                $submit->set_attribute('id','submit');
                $submit->set_attribute('class','p');
                $submit->set_attribute('accesskey','e');
                $this->add_element($submit);

                $this->add_hidden_element('status');
                $this->add_hidden_element('menu_id');
                $this->add_hidden_element('submenu_id');
                $this->set_hidden_element_value('status', 'selectOptions');
                $this->set_hidden_element_value('submenu_id', $this->getViewVariable('submenu_id'));
                $this->set_hidden_element_value('menu_id', $this->getViewVariable('menu_id'));

				$arrOpt = $this->getViewVariable('arrOptions');
				for ($i=0; $i<count($arrOpt); $i++) {
					if ($arrOpt[$i]['name'] != '')	{
						$opt_id = 'option' . $arrOpt[$i]['option_id'];
						$this->set_element_value($opt_id, $arrOpt[$i]['check']);
						$combo_id = 'modulefile' . $arrOpt[$i]['option_id'];
						$this->set_element_value($combo_id, $arrOpt[$i]['module_name']);
						$param_id = 'param' .  $arrOpt[$i]['option_id'];
						$this->set_element_value($param_id, $arrOpt[$i]['param']);
					}
				}

	}

        function form_init_data()
        {
		}
        function form()
        {
               $table = &html_table($this->_width,0,2,2);
                $table->set_class('ptabla03');

				$labelAdd = html_label( 'submit' );
                $labelAdd->add($this->element_form('submit'));
                $tdsubmit = html_td('', 'left',  $labelAdd);
                $this->set_form_tabindex('submit', '10');

				$menu_id = $this->getViewVariable('menu_id');
				$submenu_id = $this->getViewVariable('submenu_id');

				$arrOpt = $this->getViewVariable('arrOptions');
				for ($i=0; $i<count($arrOpt); $i++) {
					if ($arrOpt[$i]['name'] != '')	{
						$option_id = $arrOpt[$i]['option_id'];
						$strParam = $arrOpt[$i]['param'];
						if ($strParam!='') {
							$tdInfo = html_td('', '', "$strParam");
						} 
						$opt_id = 'option' . $option_id;
						$combo_id = 'modulefile' . $arrOpt[$i]['option_id'];
						$param_id = 'param' . $arrOpt[$i]['option_id'];
						$tdCheck = $this->_showElement($opt_id, 7+3*$i, $opt_id, $arrOpt[$i]['name'],$opt_id, 'left' );
		                $tdCombo = $this->_showElement($combo_id, 8+3*$i, $combo_id, 'módulo' ,$combo_id, 'left' );
		                $tdParam = $this->_showElement($param_id, 9+3*$i, $combo_id, 'parámetros' ,$param_id, 'left' );
						$tdDelete = html_td('', '', html_a(Util::format_URLPath('moduleManager/index.php',"status=deleteOption&menu_id=$menu_id&submenu_id=$submenu_id&option_id=$option_id"), 'Eliminar'));
		                $table->add_row($tdCheck, $tdCombo, $tdParam, $tdDelete); 

					}
				}

				$table->add_row($tdsubmit);

                return $table;
        }
}
?>
