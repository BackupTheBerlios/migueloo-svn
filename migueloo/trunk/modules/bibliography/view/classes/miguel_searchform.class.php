<?php
/*
      +----------------------------------------------------------------------+
      | bibliography                                                          |
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
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel main
 * @version 1.0.0
 */

class miguel_navForm extends base_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        $elemTema= $this->_formatElem("FEListBox", "Tema", "theme", FALSE, "200px", NULL, $this->getViewVariable('themes'));
		$elemTema->set_attribute('class','ptabla03');    
		$this->add_element($elemTema);
		
		$elemNombre = $this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "20");
		$elemNombre->set_attribute('class','ptabla03');
		$this->add_element($elemNombre);
		
		$submit = $this->_formatElem("base_SubmitButton", "Regresar", "submit", agt("Regresar"));
		$submit->set_attribute('class','boton');
		$submit->set_attribute("id","submit"); 
		$submit->set_attribute("accesskey","r");               
		$this->add_element($submit);
    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data()
    {
        return;
    }


    /**
     * Este metodo construye el formulario en sÌ.
     */
    function form()
    {
        $table = &html_table($this->_width,0,2,2);
		$rowNombre = $this->_tableRow("Nombre");
				$rowNombre->set_class('ptabla03');
				$table->add_row($rowNombre);
		
		$rowTema = $this->_tableRow("Tema");
				$rowTema->set_class('ptabla03');
				$table->add_row($rowTema);		
				
        $table->add_row(html_td('ptexto01', '',$this->element_form("Regresar")));
		
		$btnCancelar = $this->element_form("Cancelar");
				$btnCancelar->set_class('ptabla03');
				$btnAceptar = $this->element_form("Aceptar");
				$btnAceptar->set_class('ptabla03');
        $table->add_row($btnCancelar, $btnAceptar, _HTML_SPACE);
        return $table;
    }
}

?>
