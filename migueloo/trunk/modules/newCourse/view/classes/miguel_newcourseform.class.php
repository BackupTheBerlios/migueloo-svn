<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004 miguel Development Team                     |
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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
class miguel_newCourseForm extends base_FormContent 
{
	function form_init_elements() 
	{
		$elemT1 = new FEText( "courseName", false, 78, 70);
		$elemT1->set_attribute('class','');
		$elemT1->set_attribute("id","coursename");
		$elemT1->set_attribute("accesskey","n");        
		$this->add_element($elemT1);
		
		$elemP1 = new FETextArea("coursedataDescripcion", false, 20, 80);
		$elemP1->set_attribute('class','');
		$elemP1->set_attribute("id","coursedatadescripcion");        
		$elemP1->set_attribute("accesskey","d");        
		$this->add_element($elemP1);
		
		include(Util::app_Path("andromeda/include/classes/nls.inc.php"));
		$language = $this->_formatElem("FEListBox", "courseLanguage", "courseLanguage", false, "100px", NULL, $nls['languages_form']);
		$language->set_attribute('class','');
		$language->set_attribute("id","courselanguage");
		$language->set_attribute("accesskey","l");        
		$this->add_element($language);
			
		$elemT2 = new FEText( "coursedataVersion", false, 10, 8);
		$elemT2->set_attribute('class','');
		$elemT2->set_attribute("id","coursedataversion");
		$elemT2->set_attribute("accesskey","v");        
		$this->add_element($elemT2);
			
		$elemP2 = new FETextArea("coursedataPalabrasClaves", false, 20, 80, null, 300);
		$elemP2->set_attribute('class','');
		$elemP2->set_attribute("id","coursedatapalabrasclaves");
		$elemP2->set_attribute("accesskey","w");        
		$this->add_element($elemP2);
		
		$elemT3 = new FEText( "coursedataDestinatarios", false, 10);
		$elemT3->set_attribute('class','');
		$elemT3->set_attribute("id","coursedatadestinatarios");
		$elemT3->set_attribute("accesskey","u");        
		$this->add_element($elemT3);
			
		$elemP3 = new FETextArea("coursedataConocimientosPrevios", false, 20, 80, null, 300);
		$elemP3->set_attribute('class','');
		$elemP3->set_attribute("id","coursedataconocimientosprevios");
		$elemP3->set_attribute("accesskey","k");        
		$this->add_element($elemP3);
		
		$elemT4 = new FETextArea( "coursedataMetodologia", false, 20, 80, null, 300, 200);
		$elemT4->set_attribute('class','');
		$elemT4->set_attribute("id","coursedatametodologia");
		$elemT4->set_attribute("accesskey","m");        
		$this->add_element($elemT4);
		
		$elemCB1 = new FECheckBox('courseActive'); //,agt('Poner el curso activo.') );
		$elemCB1->set_attribute('class','');
		$elemCB1->set_attribute("id","courseactive");        
		$elemCB1->set_attribute("accesskey","o");                
		$this->add_element( $elemCB1 );
		
		$elemCB2 = new FECheckBox('courseAccess'); //, agt('Poner el curso accesible.') );        
		$elemCB2->set_attribute('class','');
		$elemCB2->set_attribute("id","courseaccess");
		$elemCB2->set_attribute("accesskey","p");                
		$this->add_element( $elemCB2 );        
		
		$submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("Insertar Curso"));
		$submit->set_attribute('class','');
		$submit->set_attribute("id","submit"); 
		$submit->set_attribute("accesskey","e");               
		$this->add_element($submit);
	}

	function form_init_data() 
	{
		//$this->set_hidden_element_value("id", "logon");
		$dataForm = $this->getViewVariable('courseDataForm');
		
		$this->set_element_value("courseName", $dataForm['c_name'] );
		$this->set_element_value("courseLanguage", $dataForm['c_language'] );
		$this->set_element_value("courseActive", $dataForm['c_active'] );
		$this->set_element_value("courseAccess", $dataForm['c_access'] );
		$this->set_element_value("coursedataDescripcion", $dataForm['cd_descripcion'] );
		$this->set_element_value("coursedataVersion", $dataForm['cd_version'] );
		$this->set_element_value("coursedataPalabrasClaves", $dataForm['cd_claves'] );
		$this->set_element_value("coursedataDestinatarios", $dataForm['cd_destinatarios'] );
		$this->set_element_value("coursedataConocimientosPrevios", $dataForm['cd_conocimientos'] );
		$this->set_element_value("coursedataMetodologia", $dataForm['cd_metodologia'] );
	}
	
	function form() 
	{
		$table = &html_table($this->_width,0,1,3);
      
		$table->add_row($this->createRow(7, 'Nombre', "courseName"));
		$table->add_row($this->createRow(8, 'Descripción', "coursedataDescripcion"));
		$table->add_row($this->createRow(9, 'Idioma', "courseLanguage"));
		$table->add_row($this->createRow(10, 'Versión', "coursedataVersion"));
		$table->add_row($this->createRow(11, 'Palabras Clave', "coursedataPalabrasClaves"));
		$table->add_row($this->createRow(12, 'Destinatarios', "coursedataDestinatarios"));
		$table->add_row($this->createRow(13, 'Conocimientos Previos', "coursedataConocimientosPrevios"));
		$table->add_row($this->createRow(14, 'Metodología', "coursedataMetodologia"));
		$table->add_row($this->createRow(15, 'Curso activo', "courseActive"));
		$table->add_row($this->createRow(16, 'Curso accesible', "courseAccess"));
		$table->add_row($this->createRow(17, '', "Aceptar"));
	
		return $table;
	}
	
	function createRow($tab_index, $label, $obj)
	{
		$ret_val = html_tr();
		$this->set_form_tabindex("$obj", "$tab_index");
		if(empty($label)){
			$col1 = html_td("", '',$this->element_form("$obj"));
			$col2 = html_td('', '', "&nbsp;");
		} else {
			$col1 = html_td('ptabla02', '', html_b( agt($label)));
			$col2 = html_td("", '',$this->element_form("$obj"));
		}
		
		$col1->set_tag_attribute('width','35%');
 		$col2->set_tag_attribute('width','65%');
		
		$col2->set_id("$obj");        
		$ret_val->add($col1);
		$ret_val->add($col2);
		
		return $ret_val;
	}
}

?>
