<?php
/*
      +----------------------------------------------------------------------+
      |userManager/view form                                              |
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
		
		$elemNick  = $this->_formatElem("FEText", "Usuario", "usuario", FALSE, "10", "10");
        $elemNick ->set_attribute('class',''); 
		if($this->getViewVariable('status') == 'show'){
			$elemNick->set_attribute('class',''); 
			$elemNick->set_disabled(true);
		}
		$this->add_element($elemNick);
		
		$elemPasswd  = $this->_formatElem("FEText", "Contraseña", "contraseña", FALSE, "15", "15");
        $elemPasswd ->set_attribute('class',''); 
		$this->add_element($elemPasswd);
			
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
		
		// file upload: photography
        $elemFile = new FEFile("imagen", false, "200px");
        $elemFile->add_valid_type('image/gif');
        $elemFile->add_valid_type('image/jpeg');
		$elemFile->add_valid_type('image/png');
        $elemFile->set_max_size(1024 * 10); //1024 * numero de KB
		$elemFile->set_attribute('class', '');
        $this->add_element($elemFile);	
		
		// file upload: teacher CV
        $elemCV = new FEFile("cv_doc", false, "200px");
        //$elemCV->add_valid_type('image/gif');
        //$elemCV->add_valid_type('image/jpeg');
		//$elemCV->add_valid_type('image/png');
        //$elemCV->set_max_size(1024 * 10); //1024 * numero de KB
		$elemCV->set_attribute('class', '');
        $this->add_element($elemCV);	
		
		$elemDescripcion = $this->_formatElem("FETextArea", "Observaciones", "observaciones", FALSE, 20, 10,"400px", "100px");
		$elemDescripcion->set_attribute('class',''); 
		$this->add_element($elemDescripcion);
	
		switch($this->getViewVariable('pid')) {
			case 3:
				$title0 = 'docente';
				break;
			case 4:
				$title0 = 'alumno';
				break;	
		}
		
		switch($this->getViewVariable('status')){
			case 'cand':
				$boton_label = agt('Registrar candidato');
				break;
			case 'new':
				$boton_label = agt('Registrar'.' '.$title0);
				break;
			case 'del':
				$boton_label = agt('Dar de baja'.' '.$title0);
				break;	
			default:
				$boton_label = 'Guardar cambios';
				break;
		}
		
        $elemOK = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", $boton_label);
        $elemOK->set_attribute('class','p'); 
		$this->add_element($elemOK);

        //lets add a hidden form field
        $this->add_hidden_element("status");
		$this->add_hidden_element("id");
		$this->add_hidden_element("pid");
    }

    function form_init_data() 
    {
		//$this->initialize();
        
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
        $this->initialize();
		
		$table = &html_table($this->_width,0,0,0);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
        //$titulo = html_td('ptabla01','', agt('Ficha alumno'));
		//$titulo->set_tag_Attribute('colspan', '2');
		//$table->add_row($titulo);
		
		//Tabla de detalle
		$row = html_tr();
		$arr_data = $this->getViewVariable('arr_info');
		//Debug::oneVar($arr_data);
		if($arr_data['image'] != ''){
			$img = Util::main_URLPath('var/secretary/user_image/user_'.$arr_data['person_id'].'.'.$arr_data['image']);
		} else {
			$img = Theme::getThemeImagePath("anonimo.jpg");
		}
		$image = html_td('', '', html_img($img, 90, 118));
		$image->set_tag_attribute("width","12%");
		$image->set_tag_attribute("align","center");
		
		$detail_table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		
		$this->add_class_row($detail_table,"Nombre");
		$detail_table->add_row(html_td('ptabla02','',agt('Apellido')), html_td('ptabla03', '', container($this->element_form("Primer Apellido"), $this->element_form("Segundo Apellido"))));
		//Condicionar vvvvvvvvv
		$label1 = $this->element_label("Usuario");
		$label1->set_tag_attribute('class', 'ptabla02');
		
		$label2 = $this->element_label("Contraseña");
		$label2->set_tag_attribute('class', 'ptabla02');
		
		if($this->getViewVariable('status') == 'show'){
				$detail_table->add_row(html_td('ptabla02','',agt('Datos de acceso')), html_td('ptabla03', '', container($label1, $this->element_form("Usuario"), $label2, $this->element_form("Contraseña"))));
		}
		
		
		$this->add_class_row($detail_table,"DNI");
		$this->add_class_row($detail_table,"Dirección");
        $this->add_class_row($detail_table,"Población");
        $this->add_class_row($detail_table,"Provincia");
        $this->add_class_row($detail_table,"Pais");
        $this->add_class_row($detail_table,"Código Postal");
		
		$row->add($image);
		$row->add($detail_table);
		$table->add($row);
		
		/*
        //$this->add_class_row($table,"Tratamiento");
        $this->add_class_row($table,"Nombre");
        //$this->add_class_row($table,"Primer Apellido");
        //$this->add_class_row($table,"Segundo Apellido");
		$table->add_row(html_td('ptabla02','',agt('Apellido')), html_td('ptabla03', '', container($this->element_form("Primer Apellido"), $this->element_form("Segundo Apellido"))));
        $this->add_class_row($table,"DNI");
        //$this->add_class_row($table,"Fecha de nacimiento");
        $this->add_class_row($table,"Dirección");
        $this->add_class_row($table,"Población");
        $this->add_class_row($table,"Provincia");
        $this->add_class_row($table,"Pais");
        $this->add_class_row($table,"Código Postal");
		*/
        //$this->add_class_row($table,"Teléfono");
		$table->add_row(html_td('ptabla02','',agt('Teléfono')), html_td('ptabla03', '', container($this->element_form("Teléfono1"), $this->element_form("Teléfono2"))));
        $this->add_class_row($table,"Fax");
        //$this->add_class_row($table,"E-mail");
		$table->add_row(html_td('ptabla02','',agt('e-mail')), html_td('ptabla03', '', container($this->element_form("E-mail1"), $this->element_form("E-mail2"), $this->element_form("E-mail3"))));
		$this->add_class_row($table,"Web");
		if($this->getViewVariable('status') == 'new'){
			$table->add_row(html_td('ptabla02','',agt('Fotografía')), html_td('ptabla03', '', $this->element_form("imagen")));
		}
		if($this->getViewVariable('pid') == 3){
			$table->add_row(html_td('ptabla02','',agt('C.V.')), html_td('ptabla03', '', $this->element_form("cv_doc")));
		}
		
		if($arr_data['cv'] != ''){
			$link = Util::main_URLPath('var/secretary/user_cv/user_'.$arr_data['person_id'].'.'.$arr_data['cv']);
			$table->add_row(html_td('ptabla02','',agt('CV')), html_td('ptabla03', '', html_a($link, agt('Abrir'),'titulo03a')));
		} 
		
        $this->add_class_row($table,"Observaciones");
		
        //$table->add_row($this->_tableRow("Nombre de usuario"));
        //$table->add_row($this->_tableRow("Clave de acceso"));
        //$table->add_row($this->_tableRow("Clave de acceso (confirmación)"));
        //$table->add_row($this->_tableRow("Correo electrónico"));
        //$table->add_row($this->_tableRow("Tema"));
        //$table->add_row($this->_tableRow("Perfil de usuario"));
	    //$table->add_row($this->_tableRow("Politica de privacidad"));
	
        $row = html_tr();
        //$row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
        $row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
        //$table->add_row($row);
	
        $table->add_row(_HTML_SPACE, $this->element_form("Aceptar"));

        return $table;
    }
	
	function initialize() 
    {
		if($this->getViewVariable('status') == 'show' || $this->getViewVariable('status') == 'cand'){
			$arr_info = $this->getViewVariable('arr_info');

			$this->set_element_value('DNI',$arr_info['person_dni']);
			$this->set_element_value('Nombre',$arr_info['person_name']);
			$this->set_element_value('Primer Apellido',$arr_info['person_surname']);
			$this->set_element_value('Segundo Apellido',$arr_info['person_surname2']);
			$this->set_element_value('Dirección',$arr_info['street']);
			$this->set_element_value('Población',$arr_info['city']);
			$this->set_element_value('Provincia',$arr_info['council']);
			$this->set_element_value('Pais',$arr_info['country']);
			$this->set_element_value('Código Postal',$arr_info['postalcode']);
			$this->set_element_value('Teléfono1',$arr_info['phone']);
			$this->set_element_value('Teléfono2',$arr_info['phone2']);
			$this->set_element_value('Fax',$arr_info['fax']);
			$this->set_element_value('E-mail1',$arr_info['email']);
			$this->set_element_value('E-mail2',$arr_info['email2']);
			$this->set_element_value('E-mail3',$arr_info['email3']);
			$this->set_element_value('Web',$arr_info['web']);
			$this->set_element_value('Observaciones',$arr_info['notes']);
			//$this->set_element_value('image',$arr_info['imagen']);
			//$this->set_element_value('cv',$arr_info['cv_doc']);
			$this->set_element_value('Usuario',$arr_info['user_alias']);
			$this->set_element_value('Contraseña',$arr_info['user_password']);
		}
        //$this->set_element_value("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
		$this->set_hidden_element_value("status", $this->getViewVariable('status'));
		$this->set_hidden_element_value("id", $this->getViewVariable('id'));
		$this->set_hidden_element_value("pid", $this->getViewVariable('pid'));
        
		return;
    }
}

?>
