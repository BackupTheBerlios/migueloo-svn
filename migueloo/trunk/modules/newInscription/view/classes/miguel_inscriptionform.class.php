<?php
/*
      +----------------------------------------------------------------------+
      |newInscription/view form                                              |
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
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_inscriptionForm extends miguel_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //$elemTratamiento = $this->_formatElem("FEListBox", "Tratamiento", "treatment", FALSE, "200px", NULL, $this->getViewVariable('treatmentList')) ;
        //$elemTratamiento->set_attribute('class',''); 
		//$this->add_element($elemTratamiento);

		$elemNombre = $this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "50", "50");
        $elemNombre->set_attribute('class',''); 
		if($this->getViewVariable('status') == 'show'){
			$elemNombre->set_attribute('class',''); 
			$elemNombre->set_disabled(true);
		}
		$this->add_element($elemNombre);
		
        $elemApellido1  = $this->_formatElem("FEText", "Primer Apellido", "prenom_form", FALSE, "60", "80");
        $elemApellido1 ->set_attribute('class',''); 
		if($this->getViewVariable('status') == 'show'){
			$elemApellido1->set_attribute('class',''); 
			$elemApellido1->set_disabled(true);
		}
		$this->add_element($elemApellido1);
		
        $elemApellido2  = $this->_formatElem("FEText", "Segundo Apellido", "prenom_form2", FALSE, "60","80");
        $elemApellido2 ->set_attribute('class',''); 
		if($this->getViewVariable('status') == 'show'){
			$elemApellido2->set_attribute('class',''); 
			$elemApellido2->set_disabled(true);
		}
		$this->add_element($elemApellido2 );
			
        $elemNIF = $this->_formatElem("FEText", "DNI" , "nif", FALSE, "20", "20");
        $elemNIF->set_attribute('class',''); 
		if($this->getViewVariable('status') == 'show'){
			$elemNIF->set_attribute('class',''); 
			$elemNIF->set_disabled(true);
		}
		$this->add_element($elemNIF);

        //$date = $this->_formatElem("FEDate" ,"Fecha de nacimiento", "fecha", FALSE,"","","ymd",'1900');
        //$date->set_text_format('%s-%s-%s');
        //$date->set_attribute('class','ptabla03'); 
        //$this->add_element($date);

        $elemCalle = $this->_formatElem("FEText", "Dirección", "calle", FALSE, "130", "150");
        $elemCalle->set_attribute('class',''); 
		$this->add_element($elemCalle);

        $elemLocalidad = $this->_formatElem("FEText", "Población", "localidad", FALSE, "50","50");
        $elemLocalidad->set_attribute('class',''); 
		$this->add_element($elemLocalidad);
        				
		$elemProvincia = $this->_formatElem("FEText", "Provincia", "provincia", FALSE, "50", "50");
        $elemProvincia->set_attribute('class',''); 
		$this->add_element($elemProvincia);
        
		$elemPais = $this->_formatElem("FEText", "Pais", "pais", FALSE, "50","50");
        $elemPais->set_attribute('class',''); 
		$this->add_element($elemPais);
        
		$elemCP = $this->_formatElem("FEText", "Código Postal", "codigo postal", FALSE, "5","5");
        $elemCP->set_attribute('class',''); 
		$this->add_element($elemCP);
        
		$elemTel1 = $this->_formatElem("FEText", "Teléfono1", "telefono1", FALSE, "20","20");
        $elemTel1->set_attribute('class','');
		$this->add_element($elemTel1);

		$elemTel2 = $this->_formatElem("FEText", "Teléfono2", "telefono2", FALSE, "20","20");
        $elemTel2->set_attribute('class',''); 
		$this->add_element($elemTel2);
		
		$elemFax = $this->_formatElem("FEText", "Fax", "fax", FALSE, "20","20");
        $elemFax->set_attribute('class',''); 
		$this->add_element($elemFax);
        
		$elemE1 = $this->_formatElem("FEText", "E-mail1", "email", FALSE, "40","100");
        $elemE1->set_attribute('class',''); 
		$this->add_element($elemE1);
		
		$elemE2 = $this->_formatElem("FEText", "E-mail2", "email2", FALSE, "40","100");
        $elemE2->set_attribute('class',''); 
		$this->add_element($elemE2);
				
		$elemE3 = $this->_formatElem("FEText", "E-mail3", "email3", FALSE, "40","100");
        $elemE3->set_attribute('class',''); 
		$this->add_element($elemE3);
				
		$elemW = $this->_formatElem("FEText", "Web", "web", FALSE, "100","100");
        $elemW->set_attribute('class',''); 
		$this->add_element($elemW);
			
        $elemOK = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt('Preinscribirse'));
        $elemOK->set_attribute('class','p'); 
		$this->add_element($elemOK);
    }

    function form_init_data() 
    {
		return;
    }

	function add_class_row(&$table, $name)
	{
		$row=$this->_tableRow($name);
		$row->set_class('ptabla03');
		$table->add_row($row);
	}

    /**
     * Este metodo construye el formulario en sí.
     */
    function form() 
    {
		$table = &html_table($this->_width,0,0,0);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        //$titulo = html_td('ptabla01','', agt('Ficha alumno'));
		//$titulo->set_tag_Attribute('colspan', '2');
		//$table->add_row($titulo);
		
		//Tabla de detalle
		$row = html_tr();
		
		$this->add_class_row($table,"Nombre");
		$table->add_row(html_td('ptabla02','',agt('Apellido')), html_td('ptabla03', '', container($this->element_form("Primer Apellido"), $this->element_form("Segundo Apellido"))));
		
		$this->add_class_row($table,"DNI");
		$this->add_class_row($table,"Dirección");
        $this->add_class_row($table,"Población");
        $this->add_class_row($table,"Provincia");
        $this->add_class_row($table,"Pais");
        $this->add_class_row($table,"Código Postal");
		
        //$this->add_class_row($table,"Teléfono");
		$table->add_row(html_td('ptabla02','',agt('Teléfono')), html_td('ptabla03', '', container($this->element_form("Teléfono1"), $this->element_form("Teléfono2"))));
        $this->add_class_row($table,"Fax");
        //$this->add_class_row($table,"E-mail");
		$table->add_row(html_td('ptabla02','',agt('e-mail')), html_td('ptabla03', '', container($this->element_form("E-mail1"), $this->element_form("E-mail2"), $this->element_form("E-mail3"))));
		$this->add_class_row($table,"Web");
		
        $row = html_tr();
        //$row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
        $row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
        //$table->add_row($row);
	
        $table->add_row(_HTML_SPACE, $this->element_form("Aceptar"));

        return $table;
    }
}

?>
