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

class miguel_newoptionForm extends base_FormContent
{
    function form_init_elements()
    {
                $nameopt=$this->_formatElem("FEText", "nameopt", "nameopt", FALSE, "50");
                $nameopt->set_attribute('class','ptabla03');

                //AÃ±ade un boton con la acciÃ³n submit  
                $submit = $this->_formatElem('base_SubmitButton', 'anadir', 'submit', 'Añadir');
                $submit->set_attribute('id','submit');
                $submit->set_attribute('class','p');
                $submit->set_attribute('accesskey','e');


                $this->add_element($nameopt);
                $this->add_element($submit);

                $this->add_hidden_element('status');
                $this->add_hidden_element('submenu_id');
                $this->add_hidden_element('menu_id');
                $this->set_hidden_element_value('status', 'newOption');
                $this->set_hidden_element_value('menu_id', $this->getViewVariable('menu_id'));
                $this->set_hidden_element_value('submenu_id', $this->getViewVariable('submenu_id'));
    }

        function form_init_data()
        {
			 //$this->set_element_value('nameopt', '');
        }

        function form()
        {
                $table = &html_table($this->_width,0,2,2);
                $table->set_class('ptabla01');

				$labelAdd = html_label( 'anadir' );
                $labelAdd->add($this->element_form('anadir'));
                $tdAnadir = html_td('', 'left',  $labelAdd);
                $this->set_form_tabindex('anadir', '10');

                $table->add_row($this->_showElement('nameopt', '7', 'nameopt', 'Nueva opción', 'nameopt', 'left' ), $tdAnadir); 

                return $table;
        }
}
?>
