<?php
/*
      +----------------------------------------------------------------------+
      |userManager/view form                                                 |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
class miguel_searchUserform extends base_FormContent
{
    function form_init_elements()
    {
		$arrOrden['Por nombre'] 	= 1;
		$arrOrden['Por apellido'] 	= 2;
		$arrOrden['Por dni']		= 3;
		$arrOrden['Por curso']		= 4;
		$arrOrden['Por usuario']	= 5;

		$ListOrden = $this->_formatElem("FEListBox", "orden", "orden", FALSE, "100px", NULL, $arrOrden);
		$ListOrden->set_attribute('class','');
		$this->add_element($ListOrden);
		
		$elemNombre = $this->_formatElem("FEText", "data_form", "data_form", FALSE, "20");
		$elemNombre->set_attribute('class','');
		$this->add_element($elemNombre);
		
		//Añade un boton con la acción submit
		$submit = $this->_formatElem('base_SubmitButton', 'Aceptar', 'sort', 'Buscar');
		$submit->set_attribute('class','p');
		$submit->set_attribute('accesskey','e');
		$this->add_element($submit);
		
		$this->add_hidden_element('status');
    }

    function form_init_data()
    {
		$this->set_hidden_element_value('status', 'search_user');
    }

	function form()
    {
		//El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
		
		$table = &html_table('40%', 0, 0, 0, 'center');
		$table->set_class('ptabla03');
		
		$this->set_form_tabindex('orden', '13');
		$sort = html_td('ptabla03','',$this->element_form('orden'));
		
		$this->set_form_tabindex('orden', '14');
		$link = html_td('ptabla03','',$this->element_form('data_form'));
		
		$this->set_form_tabindex('Aceptar', '15');
		$boton = html_td('ptabla03','', $this->element_form('Aceptar'));
		//$boton->set_tag_attribute('valign', 'center');
		
		$table->add_row($sort, $link, $boton);
		
		return $table;
    }
}
?>
