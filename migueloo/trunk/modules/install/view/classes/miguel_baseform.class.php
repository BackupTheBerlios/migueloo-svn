<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
 * Esta clase se encarga de gestionar el formulario configurar el entorno base
 * en la instalación de la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
class miguel_baseForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements()
    {
        $elem1 = new FEText("miguel_appdir", FALSE, 60);
		$elem1->set_value($this->getViewVariable('miguel_path'));
		$this->add_element($elem1);

		$elem2 = new FEText("miguel_urldir", FALSE, 60);
		$elem2->set_value($this->getViewVariable('miguel_url'));
		$this->add_element($elem2);

		$elem3 = new FEText("miguelbase_phphtmllib", FALSE, 60);
		$elem3->set_value($this->getViewVariable('phl_path'));
		$this->add_element($elem3);

		$elem4 = new FEText("miguelbase_adodb", FALSE, 60);
		$elem4->set_value($this->getViewVariable('ado_path'));
		$this->add_element($elem4);

        $elem5 = new FEListBox("miguelbase_cacheable", FALSE, "110px", NULL,
        								  array(agt("Inactivo") => 0,agt("Activo") => 1));
        $elem5->set_value($this->getViewVariable('cache_bol'));
		$this->add_element($elem5);

		if($this->getViewVariable('cache_bol')){
            $elem6 = new FEText("miguelbase_cache_dir", FALSE, 60);
			$elem6->set_value($this->getViewVariable('cache_path'));
			$this->add_element($elem6);
			$elem7 = new FEText("miguelbase_cache_time", FALSE, 5);
			$elem7->set_value($this->getViewVariable('cache_time'));
			$this->add_element($elem7);
		}
        $this->add_element( new FEListBox("miguelbase_log_active", FALSE, "110px", NULL,
        								  array(agt("Inactivo") => 0, agt("Activo") => 1)) );
        $this->add_element( new FEListBox("miguelbase_log_type", FALSE, "110px", NULL,
        								  array(agt("Usando PHP") => 'error_log',
        								  agt("Fichero") => 'file',
        								  agt("Tabla") => 'adodb')));
        $this->add_element(new FEText("miguelbase_log_file", FALSE, 60));
        $this->add_element(new FEText("miguelbase_log_table", FALSE, 5));
        $this->add_element( new FEListBox("miguelbase_log_level", FALSE, "110px", NULL,
        								  array(agt("Ninguno") => 'NONE',
        								  agt("Emergencia") => 'EMERG',
        								  agt("Alerta") => 'ALERT',
        								  agt("Crítico") => 'CRITIC',
        								  agt("Error") => 'ERROR',
        								  agt("Aviso") => 'WARNING',
        								  agt("Relevante") => 'NOTICE',
        								  agt("Informativo") => 'INFO',
        								  agt("Debug") => 'DEBUG',
        								  agt("Todos") => 'ALL')));

        $this->add_element(new FEText("miguelbase_session_dir", FALSE, 60));


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

        $table->add_row(agt("Directorio local"), $this->element_form("miguel_appdir"));
        $table->add_row(agt("URL"), $this->element_form("miguel_urldir"));
        $table->add_row(agt("Directorio de phpHtmlLib"), $this->element_form("miguelbase_phphtmllib"));
        $table->add_row(agt("Directorio de ADOdb"), $this->element_form("miguelbase_adodb"));
        
        $table->add_row(agt("Cache interno"), $this->element_form("miguelbase_cacheable"));
		if($this->getViewVariable('cache_bol')){
			$table->add_row('* '.agt("Directorio Cache"), $this->element_form("miguelbase_cache_dir"));
			$table->add_row('* '.agt("Tiempo de Cache"), $this->element_form("miguelbase_cache_time"));
		}

        $table->add_row(agt("Sistema de LOG"), $this->element_form("miguelbase_log_active"));
        $table->add_row('* '.agt("Tipo de LOG"), $this->element_form("miguelbase_log_type"));
        $table->add_row('* '.agt("Fichero de LOG"), $this->element_form("miguelbase_log_file"));
        $table->add_row('* '.agt("Tabla de LOG"), $this->element_form("miguelbase_log_table"));
        $table->add_row('* '.agt("Nivel de LOG"), $this->element_form("miguelbase_log_level"));
        $table->add_row(agt("Directorio de Sessiones"), $this->element_form("miguelbase_session_dir"));
        
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
