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

class miguel_prefsForm extends base_FormContent
{
/**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        $elem1 = new FEText("miguel_campus_name", FALSE, 60);
		$elem1->set_value($this->getViewVariable('inst_campus_name'));
		//$elem1->set_style_attribute('id', 'install');
		$this->add_element($elem1);
		
		$elem2 = new FEText("miguel_inst_name", FALSE, 60);
		$elem2->set_value($this->getViewVariable('inst_inst_name'));
		$elem2->set_style_attribute('id', 'install');
		$this->add_element($elem2);
		
		$elem3 = new FEText("miguel_inst_url", FALSE, 60);
		$elem3->set_value($this->getViewVariable('inst_inst_url'));
		$elem3->set_style_attribute('id', 'install');
		$this->add_element($elem3);
		
		$elem4 = new FEText("miguel_director_name", FALSE, 60);
		$elem4->set_value($this->getViewVariable('inst_director_name'));
		$elem4->set_style_attribute('id', 'install');
		$this->add_element($elem4);
		
		$elem5 = new FEText("miguel_director_email", FALSE, 60);
		$elem5->set_value($this->getViewVariable('inst_director_email'));
		$elem5->set_style_attribute('id', 'install');
		$this->add_element($elem5);
		
		$elem6 = new FEText("miguel_inst_phone", FALSE, 60);
		$elem6->set_value($this->getViewVariable('inst_inst_phone'));
		$elem6->set_style_attribute('id', 'install');
		$this->add_element($elem6);
		
		$elem7 = new FEListBox("miguel_campus_lang", FALSE, "300px", NULL);
		$elem7->set_list_data($this->getViewVariable('inst_campus_lang'));
		$elem7->set_style_attribute('id', 'install');
		$this->add_element($elem7);
		
		$elem8 = new FEText("miguel_admin_name", FALSE, 60);
		$elem8->set_value($this->getViewVariable('inst_admin_name'));
		$elem8->set_style_attribute('id', 'install');
		$this->add_element($elem8);
		
		$elem9 = new FEText("miguel_admin_surname", FALSE, 60);
		$elem9->set_value($this->getViewVariable('inst_admin_surname'));
		$elem9->set_style_attribute('id', 'install');
		$this->add_element($elem9);
		
		$elem10 = new FEText("miguel_admin_user", FALSE, 8);
		$elem10->set_value($this->getViewVariable('inst_admin_user'));
		$elem10->set_style_attribute('id', 'install');
		$this->add_element($elem10);
		
		$elem11 = new FEPassword("miguel_admin_passwd", FALSE, 8);
		$elem11->set_value($this->getViewVariable('inst_admin_passwd'));
		$elem11->set_style_attribute('id', 'install');
		$this->add_element($elem11);
		
		$elem12 = new FEPassword("miguel_admin_passwd2", FALSE, 8);
		$elem12->set_value('');
		$elem12->set_style_attribute('id', 'install');
		$this->add_element($elem12);
		
		$elem13 = new FEListBox("miguel_admin_theme", FALSE, "110px", NULL);
		$elem13->set_list_data(Theme::getActiveThemes());
		$elem13->set_style_attribute('id', 'install');
		$this->add_element($elem13);
		
		$elem14 = new FEYesNoRadioGroup("miguel_cript_passwd", FALSE, agt('Si'), agt('No'));
		if($this->getViewVariable('inst_cript_passwd')){
            $elem14->set_value(agt('Si'));
        } else {
            $elem14->set_value(agt('No'));
        }
		$elem14->set_style_attribute('id', 'install');
		$this->add_element($elem14);

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

        $table->add_row(agt("Nombre del Campus Virtual"), $this->element_form("miguel_campus_name"));
		$table->add_row(agt("Nombre de la Institución"), $this->element_form("miguel_inst_name"));
		$table->add_row(agt("URL de la Institución"), $this->element_form("miguel_inst_url"));
		$table->add_row(agt("Jefe de Estudios"), $this->element_form("miguel_director_name"));
		$table->add_row(agt("E-mail de contacto"), $this->element_form("miguel_director_email"));
		$table->add_row(agt("Teléfono de contacto"), $this->element_form("miguel_inst_phone"));
		$table->add_row(agt("Idioma del Campus"), $this->element_form("miguel_campus_lang"));
		$table->add_row(agt("Nombre del administrador"), $this->element_form("miguel_admin_name"));
		$table->add_row(agt("Apellido del administrador"), $this->element_form("miguel_admin_surname"));
		$table->add_row(agt("Usuario del administrador"), $this->element_form("miguel_admin_user"));
		$table->add_row(agt("Contraseña del administrador"), $this->element_form("miguel_admin_passwd"));
		$table->add_row(agt("Cofirmación de Contraseña"), $this->element_form("miguel_admin_passwd2"));
		$table->add_row(agt("Tema visual del administrador"), $this->element_form("miguel_admin_theme"));
		$table->add_row(agt("Encriptar contraseñas de usuarios"), $this->element_form("miguel_cript_passwd"));

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
		$row->add($col1, $col2);
		$table->add($row);
		$ret_val->add($table);

        return $ret_val;
    }
}
?>
