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
	  | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
	  |          miguel Development Team                                     |
	  |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
	  +----------------------------------------------------------------------+
*/
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_FichaEntityManagerForm extends miguel_FormContent
{
	/**
	 * Este metodo se llama cada vez que se instancia la clase.
	 * Se utiliza para crear los objetos del formulario
	 */
	function form_init_elements() 
	{

		$elemNombre = $this->_formatElem("FEText", "Nombre comercial", "nomcom_form", FALSE, "50", "70");
		$elemNombre->set_attribute('class',''); 
		$this->add_element($elemNombre);
		
		$elemRazon  = $this->_formatElem("FEText", "Razón social", "razon_form", FALSE, "80", "100");
		$elemRazon ->set_attribute('class',''); 
		$this->add_element($elemRazon);
		
		$elemCodigo  = $this->_formatElem("FEText", "Código", "codigo_form", FALSE, "20","20");
		$elemCodigo ->set_attribute('class',''); 
		$this->add_element($elemCodigo);
			
		$elemCIF = $this->_formatElem("FEText", "CIF" , "cif_form", FALSE, "20", "9");
		$elemCIF->set_attribute('class',''); 
		$this->add_element($elemCIF);

		$elemDireccion = $this->_formatElem("FEText", "Dirección" , "dir_form", FALSE, "80", "150");
		$elemDireccion->set_attribute('class',''); 
		$this->add_element($elemDireccion);
			
		$elemPoblacion = $this->_formatElem("FEText", "Población", "pob_form", FALSE, "60", "100");
		$elemPoblacion->set_attribute('class',''); 
		$this->add_element($elemPoblacion);

		$elemProvincia = $this->_formatElem("FEText", "Provincia", "pro_form", FALSE, "60", "100");
		$elemProvincia->set_attribute('class',''); 
		$this->add_element($elemProvincia);

		$elemPais = $this->_formatElem("FEText", "País", "pais_form", FALSE, "60", "100");
		$elemPais->set_attribute('class',''); 
		$this->add_element($elemPais);

		$elemPostal = $this->_formatElem("FEText", "Código postal", "postal_form", FALSE, "10", "5");
		$elemPostal->set_attribute('class',''); 
		$this->add_element($elemPostal);

		$elemTelefono1 = $this->_formatElem("FEText", "Teléfono1", "telefono1_form", FALSE, "10", "20");
		$elemTelefono1->set_attribute('class',''); 
		$this->add_element($elemTelefono1);
		
		$elemTelefono2 = $this->_formatElem("FEText", "Teléfono2", "telefono2_form", FALSE, "10", "20");
		$elemTelefono2->set_attribute('class',''); 
		$this->add_element($elemTelefono2);

		$elemTelefono3 = $this->_formatElem("FEText", "Teléfono3", "telefono3_form", FALSE, "10", "20");
		$elemTelefono3->set_attribute('class',''); 
		$this->add_element($elemTelefono3);				
		
		$elemFax = $this->_formatElem("FEText", "Fax", "Fax_form", FALSE, "10", "20");
		$elemFax->set_attribute('class',''); 
		$this->add_element($elemFax);				
		
		$elemEmail1 = $this->_formatElem("FEText", "Email1", "email1_form", FALSE, "50", "100");
		$elemEmail1->set_attribute('class',''); 
		$this->add_element($elemEmail1);
		
		$elemEmail2 = $this->_formatElem("FEText", "Email2", "email2_form", FALSE, "50", "100");
		$elemEmail2->set_attribute('class',''); 
		$this->add_element($elemEmail2);

		$elemEmail3 = $this->_formatElem("FEText", "Email3", "email3_form", FALSE, "50", "100");
		$elemEmail3->set_attribute('class',''); 
		$this->add_element($elemEmail3);
		
		$elemWeb = $this->_formatElem("FEText", "Web", "web_form", FALSE, "50", "100");
		$elemWeb->set_attribute('class',''); 
		$this->add_element($elemWeb);		
		
		$elemLogo = $this->_formatElem("FEText", "Logotipo", "logo_form", FALSE, "50", "100");
		$elemLogo->set_attribute('class',''); 
		$this->add_element($elemLogo);			
				
        //--------------------------------------------------	
       
        $elemPerContacto1 = $this->_formatElem("FEText", "persona contacto1", "contact_person1_form", FALSE, "50", "100");
		$elemPerContacto1->set_attribute('class',''); 
		$this->add_element($elemPerContacto1);
		$elemPerContacto2 = $this->_formatElem("FEText", "persona contacto2", "contact_person2_form", FALSE, "50", "100");
		$elemPerContacto2->set_attribute('class',''); 
		$this->add_element($elemPerContacto2);
		$elemPerContacto3 = $this->_formatElem("FEText", "persona contacto3", "contact_person3_form", FALSE, "50", "100");
		$elemPerContacto3->set_attribute('class',''); 
		$this->add_element($elemPerContacto3);
		$elemPerContacto4 = $this->_formatElem("FEText", "persona contacto4", "contact_person4_form", FALSE, "50", "100");
		$elemPerContacto4->set_attribute('class',''); 
		$this->add_element($elemPerContacto4);
		
		$elemEmailContacto1 = $this->_formatElem("FEText", "email contacto1", "email_person1_form", FALSE, "50", "100");
		$elemEmailContacto1->set_attribute('class',''); 
		$this->add_element($elemEmailContacto1);
		$elemEmailContacto2 = $this->_formatElem("FEText", "email contacto2", "email_person2_form", FALSE, "50", "100");
		$elemEmailContacto2->set_attribute('class',''); 
		$this->add_element($elemEmailContacto2);
		$elemEmailContacto3 = $this->_formatElem("FEText", "email contacto3", "email_person3_form", FALSE, "50", "100");
		$elemEmailContacto3->set_attribute('class',''); 
		$this->add_element($elemEmailContacto3);
		$elemEmailContacto4 = $this->_formatElem("FEText", "email contacto4", "email_person4_form", FALSE, "50", "100");
		$elemEmailContacto4->set_attribute('class',''); 
		$this->add_element($elemEmailContacto4);

		$elemTelContacto1 = $this->_formatElem("FEText", "teléfono contacto1", "telefono_person1_form", FALSE, "50", "100");
		$elemTelContacto1->set_attribute('class',''); 
		$this->add_element($elemTelContacto1);
		$elemTelContacto2 = $this->_formatElem("FEText", "teléfono contacto2", "telefono_person2_form", FALSE, "50", "100");
		$elemTelContacto2->set_attribute('class',''); 
		$this->add_element($elemTelContacto2);
		$elemTelContacto3 = $this->_formatElem("FEText", "teléfono contacto3", "telefono_person3_form", FALSE, "50", "100");
		$elemTelContacto3->set_attribute('class',''); 
		$this->add_element($elemTelContacto3);
		$elemTelContacto4 = $this->_formatElem("FEText", "teléfono contacto4", "telefono_person4_form", FALSE, "50", "100");
		$elemTelContacto4->set_attribute('class',''); 
		$this->add_element($elemTelContacto4);

        //--------------------------------------------------

		$elemCourse1 = $this->_formatElem("FEText", "curso1", "curso1_form", FALSE, "80", "100");
		$elemCourse1->set_attribute('class',''); 
		$this->add_element($elemCourse1);
		$elemCourse2 = $this->_formatElem("FEText", "curso2", "curso2_form", FALSE, "80", "100");
		$elemCourse2->set_attribute('class',''); 
		$this->add_element($elemCourse2);
		$elemCourse3 = $this->_formatElem("FEText", "curso3", "curso3_form", FALSE, "80", "100");
		$elemCourse3->set_attribute('class',''); 
		$this->add_element($elemCourse3);
		        		        
		//--------------------------------------------------	
		
		$elemObservation = $this->_formatElem("FETextArea", "Observaciones", "observation_form", FALSE, "2", "100");
		$elemObservation->set_attribute('class',''); 
		$this->add_element($elemObservation);
		        		        
        //--------------------------------------------------	
		$elemActualizar = $this->_formatElem("base_SubmitButton", "Actualizar", "submit", agt('Actualizar datos'));
		$elemActualizar->set_attribute('class','p'); 
		$this->add_element($elemActualizar);
		
		/*$elemImprimir = $this->_formatElem("base_SubmitButton", "Imprimir", "submit", agt('imprimir ficha'));
		$elemImprimir->set_attribute('class','p'); 
		$this->add_element($elemImprimir);
		*/
		//--------------------------------------------------
		$this->add_hidden_element('status');
		$this->add_hidden_element('view');
		$this->add_hidden_element('entityid');
	}

	function form_init_data() 
	{
		$this->initialize();
	}

	function initialize() 
	{
		$arr_info = $this->getViewVariable('arr_info');

		$this->set_hidden_element_value('entityid', $arr_info['entityid']);

		$this->set_element_value('Nombre comercial',$arr_info['name']);
		$this->set_element_value('Razón social',$arr_info['description']);
		$this->set_element_value('Código',$arr_info['code']);
		$this->set_element_value('CIF',$arr_info['identify']);
		$this->set_element_value('Dirección',$arr_info['address']);
		$this->set_element_value('Población',$arr_info['city']);
		$this->set_element_value('Provincia',$arr_info['council']);
		$this->set_element_value('País',$arr_info['country']);
		$this->set_element_value('Código postal',$arr_info['postalcode']);
		$this->set_element_value('Teléfono1',$arr_info['phone1']);
		$this->set_element_value('Teléfono2',$arr_info['phone2']);
		$this->set_element_value('Teléfono3',$arr_info['phone3']);
		$this->set_element_value('Fax',$arr_info['fax']);
		$this->set_element_value('Email1',$arr_info['email1']);
		$this->set_element_value('Email2',$arr_info['email2']);
		$this->set_element_value('Email3',$arr_info['email3']);
		$this->set_element_value('Web',$arr_info['web']);
		$this->set_element_value('Logotipo',$arr_info['logo']);
		$this->set_element_value('Observaciones',$arr_info['observations']);
		
		$this->set_element_value('persona contacto1',$arr_info['contactname0']);
		$this->set_element_value('email contacto1',$arr_info['contactemail0']);
		$this->set_element_value('teléfono contacto1',$arr_info['contactphone0']);

		$this->set_element_value('persona contacto2',$arr_info['contactname1']);
		$this->set_element_value('email contacto2',$arr_info['contactemail1']);
		$this->set_element_value('teléfono contacto2',$arr_info['contactphone1']);
		
		$this->set_element_value('persona contacto3',$arr_info['contactname2']);
		$this->set_element_value('email contacto3',$arr_info['contactemail2']);
		$this->set_element_value('teléfono contacto3',$arr_info['contactphone2']);				

		$this->set_element_value('persona contacto4',$arr_info['contactname3']);
		$this->set_element_value('email contacto4',$arr_info['contactemail3']);
		$this->set_element_value('teléfono contacto4',$arr_info['contactphone3']);
				   					
		//--------------------------------------------------
		$this->set_hidden_element_value('status', $arr_info['status']);
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
		
		//Inicializa campos
		$this->initialize();
		
		//inicializa la tabla princuipal
		$table = &html_table($this->_width,0,0,0);
		$table->set_class("mainInterfaceWidth");
		
						

/*
		//añade filas a la tabla detalle 
		$this->add_class_row($detail_table,"Nombre");
		$detail_table->add_row(html_td('ptabla02','',agt('Apellido')), html_td('ptabla03', '', container($this->element_form("Primer Apellido"), $this->element_form("Segundo Apellido"))));
		$this->add_class_row($detail_table,"Ultima Modificacion");
		
		$row = html_tr();
		$row->set_class('ptabla03');
		
		$img = Theme::getThemeImagePath("anonimo.jpg");
		$image = html_td('', '', html_img($img, 90, 118));
		$image->set_tag_attribute("width","12%");
		$image->set_tag_attribute("align","center");
		
		$row->add($image);
		
		$row->add($detail_table);
		$table->add($row);
					
		//Tabla de detalle
		$row = html_tr();
*/
		//añade filas a la tabla		
		$this->add_class_row($table,"Nombre comercial");
		$this->add_class_row($table,"Razón social");
		$this->add_class_row($table,"Código");
		$this->add_class_row($table,"CIF");
		$this->add_class_row($table,"Dirección");
		$this->add_class_row($table,"Población");
		$this->add_class_row($table,"Provincia");
		$this->add_class_row($table,"País");
		$this->add_class_row($table,"Código postal");
		$table->add_row(html_td('ptabla02','',agt('Teléfonos')), html_td('ptabla03', '', container($this->element_form("Teléfono1"), $this->element_form("Teléfono2"), $this->element_form("Teléfono3"))));
		$this->add_class_row($table,"Fax");
		$table->add_row(html_td('ptabla02','',agt('E-mail')), html_td('ptabla03', '', container($this->element_form("Email1"), $this->element_form("Email2"), $this->element_form("Email3"))));
		$this->add_class_row($table,"Web");
		$this->add_class_row($table,"Logotipo");
		
		//inicializa tabla contacto		
		$table_contact = &html_table($this->_width,0,0,0);
		$table_contact->set_class("mainInterfaceWidth");		
		
		$row = html_tr();
		$row->add(html_td('ptabla01', '', 'Persona de contacto'));
		$row->add(html_td('ptabla01', '', 'E-mail'));
		$row->add(html_td('ptabla01', '', 'Teléfono'));
		$table_contact->add_row($row);     
        
        for($i=1;$i<5;$i++){
	        $row = html_tr();
			$row->add(html_td('ptabla03', '', container($this->element_form('persona contacto'.$i))));
			$row->add(html_td('ptabla03', '', container($this->element_form('email contacto'.$i))));
			$row->add(html_td('ptabla03', '', container($this->element_form('teléfono contacto'.$i))));
			$table_contact->add_row($row); 
		}

        $row = html_tr();
        $row->add(html_td('ptabla02', '', 'Personas de contacto'));
        $row->add($table_contact);
        $table->add($row);
        		
		//inicializa tabla cursos		
		$table_course = &html_table($this->_width,0,0,0);
		$table_course->set_class("mainInterfaceWidth");
		
		$row = html_tr();
		$row->add(html_td('ptabla01', '', 'Cursos'));
		$table_course->add_row($row);
		
		for($i=1;$i<4;$i++){
	        $row = html_tr();
			$row->add(html_td('ptabla03', '', container($this->element_form('curso'.$i))));
			$table_course->add_row($row); 
		}
		
		$row = html_tr();
        $row->add(html_td('ptabla02', '', 'cursos'));
        $row->add($table_course);
        $table->add($row);
		
		$this->add_class_row($table,"Observaciones");
	
		//añade el boton de guardar
		$table->add_row(_HTML_SPACE);
		$table->add_row(_HTML_SPACE, container($this->element_form("Actualizar")));//, $this->element_form("Imprimir")));

		return $table;
	}
}

?>
