<?php
/*
      +----------------------------------------------------------------------+
      | miguel install                                                       |
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
 * Define formulario para la configuración de la base de datos
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel install
 * @subpackage view
 * @version 1.0.0
 *
 */
/**
 * Include libraries
 */

class miguel_ddbbForm extends base_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        $elem10 = new FEListBox("miguel_ddbb_sgbd", FALSE, "110px", NULL);
		$elem10-> set_list_data($this->getViewVariable('inst_ddbb_sgbd'));
		//$elem10->set_style_attribute('id', 'install');
		//$elem0->set_value(agt("MySQL"));
		$this->add_element($elem10);
		
        $elem1 = new FEText("miguel_ddbb_host", FALSE, 30);
		$elem1->set_value($this->getViewVariable('inst_ddbb_host'));
		$elem1->set_style_attribute('id', 'install');
		$this->add_element($elem1);
		
		$elem2 = new FEText("miguel_ddbb_name", FALSE, 30);
		$elem2->set_value($this->getViewVariable('inst_ddbb_name'));
		$elem2->set_style_attribute('id', 'install');
		$this->add_element($elem2);
		
		$elem3 = new FEText("miguel_ddbb_user", FALSE, 30);
		$elem3->set_value($this->getViewVariable('inst_ddbb_user'));
		$elem3->set_style_attribute('id', 'install');
		$this->add_element($elem3);
		
		$elem4 = new FEPassword("miguel_ddbb_passwd", FALSE, 30);
		$elem4->set_value('');
		$elem4->set_style_attribute('id', 'install');
		$this->add_element($elem4);
		
		$elem5 = new FEPassword("miguel_ddbb_passwd2", FALSE, 30);
		$elem5->set_value('');
		$elem5->set_style_attribute('id', 'install');
		$this->add_element($elem5);

		$this->add_element($this->_formatElem("base_SubmitButton", "Salir", "quit", agt("Salir")));
		$this->add_element($this->_formatElem("base_SubmitButton", "Siguiente", "submit", agt("Siguiente")." >"));
		$this->add_element($this->_formatElem("base_SubmitButton", "Regresar", "back", "< ".agt("Regresar")));
    }

	function form_init_data()
	{
        //set a few of the checkboxlist items as checked.
		return;

    }

    /**
     * Este metodo construye el formulario en sí.
     */
    function form()
    {
        $ret_val = container();

		$table = &html_table($this->_width,0,2,2);
        //$table->set_style("border: 1px solid");
        
        $table->add_row(agt("Sistema Gestor de la Base de Datos"), $this->element_form("miguel_ddbb_sgbd"), agt("Por ejemplo MySQL"));
        $table->add_row(agt("Alojamiento de la Base de Datos"), $this->element_form("miguel_ddbb_host"), agt("Por ejemplo ").$this->getViewVariable('inst_ddbb_host'));
        $table->add_row(agt("Nombre de la Base de Datos"), $this->element_form("miguel_ddbb_name"), agt('Por ejemplo ').$this->getViewVariable('inst_ddbb_name'));
        $table->add_row(agt("Usuario de acceso a la Base de Datos"), $this->element_form("miguel_ddbb_user"), agt('Por ejemplo ').$this->getViewVariable('inst_ddbb_user'));
        $table->add_row(agt("Contraseña de acceso a la Base de Datos"), $this->element_form("miguel_ddbb_passwd"), agt('Por ejemplo '.$this->getViewVariable('inst_ddbb_passwd')));
        $table->add_row(agt("Confirmación de la contraseña de acceso a la Base de Datos"), $this->element_form("miguel_ddbb_passwd2"));

		$row = html_tr("");
		$col1 = html_td("");
		$col1->set_tag_attribute("align", "left");
		$col1->add($this->element_form("Salir"));

		$container = container();
		$container->add($this->element_form("Regresar"));
		$container->add($this->element_form("Siguiente"));

		$col2 = html_td("");
		$col2->set_tag_attribute("align", "right");

		$col2->add($container);
		$row->add($col1, _HTML_SPACE, $col2);
		$table->add($row);
		$ret_val->add($table);

        return $ret_val;
    }
}
?>
