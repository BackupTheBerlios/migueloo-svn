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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
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

class miguel_selectsubmenuForm extends base_FormContent
{
    function form_init_elements()
    {
				$arrSmn = $this->getViewVariable('arrSubmenus');

				for ($i=0; $i<count($arrSmn); $i++) {
					if ($arrSmn[$i]['name'] != '')	{
						$opt_id = 'submenu' . $arrSmn[$i]['submenu_id'];
						$checkOpt[$i] = $this->_formatElem("FECheckBox",  $opt_id, $opt_id);
					    $checkOpt[$i]->set_attribute('class','ptabla02');
						$this->add_element($checkOpt[$i]);
						$this->set_element_value($opt_id, $arrSmn[$i]['check']);
					}
				}

                //Añade un boton con la acción submit  
                $submit = $this->_formatElem('base_SubmitButton', 'submit', 'submit', 'Aceptar');
                $submit->set_attribute('id','submit');
                $submit->set_attribute('class','p');
                $submit->set_attribute('accesskey','e');
                $this->add_element($submit);

                $this->add_hidden_element('status');
                $this->add_hidden_element('menu_id');
                $this->set_hidden_element_value('status', 'selectSubmenus');
                $this->set_hidden_element_value('menu_id', $this->getViewVariable('menu_id'));

    }

        function form_init_data()
        {
		}
        function form()
        {
               $table = &html_table($this->_width,0,2,2);
                $table->set_class('ptabla02');

				$labelAdd = html_label( 'submit' );
                $labelAdd->add($this->element_form('submit'));
                $tdsubmit = html_td('', 'left',  $labelAdd);
                $this->set_form_tabindex('submit', '10');
			
				
				$menu_id = $this->getViewVariable('menu_id');

				$arrSmn = $this->getViewVariable('arrSubmenus');
				for ($i=0; $i<count($arrSmn); $i++) {
					if ($arrSmn[$i]['name'] != '')	{
						$submenu_id = $arrSmn[$i]['submenu_id'];
						$tdDelete = html_td('', '', html_a(Util::format_URLPath('moduleManager/index.php',"status=deleteSubmenu&menu_id=$menu_id&submenu_id=$submenu_id"), 'Eliminar'));
						$opt_id = 'submenu' . $submenu_id;
		                $table->add_row($this->_showElement($opt_id, 7+$i, $opt_id, $arrSmn[$i]['name'],$opt_id, 'left' ), $tdDelete); 
					}
				}

				$table->add_row($tdsubmit);

                return $table;
        }
}
?>
