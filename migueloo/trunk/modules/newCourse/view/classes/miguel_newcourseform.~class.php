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
      | Authors: Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase se encarga de gestionar el formulario para crear nuevos cursos
 *
 * @author  Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
class miguel_newCourseForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
  function form_init_elements() 
  {
      //we want an confirmation page for this form.
      //$this->set_confirm();

      // Course Info        
    $elemT1 = new FEText( "courseName", true, 10);
    $elemT1->set_style_attribute('align', 'left');
    $elemT1->set_attribute("id","coursename");
    $elemT1->set_attribute("accesskey","n");        
    $this->add_element($elemT1);

    $elemP1 = new FETextArea("coursedataDescripcion", true, 10, 50, null, 300);
    $elemP1->set_style_attribute('align', 'left');
    $elemP1->set_attribute("id","coursedatadescripcion");        
    $elemP1->set_attribute("accesskey","d");        
    $this->add_element($elemP1);

    include(Util::app_Path("andromeda/include/classes/nls.inc.php"));
    $language = $this->_formatElem("FEListBox", "courseLanguage", "courseLanguage", FALSE, "100px", NULL, $nls['languages_form']);
    $language->set_style_attribute('align', 'left');
    $language->set_attribute("id","courselanguage");
    $language->set_attribute("accesskey","l");        
    $this->add_element($language);
        
    $elemT2 = new FEText( "coursedataVersion", FALSE, 10);
    $elemT2->set_style_attribute('align', 'left');
    $elemT2->set_attribute("id","coursedataversion");
    $elemT2->set_attribute("accesskey","v");        
    $this->add_element($elemT2);
        
    $elemP2 = new FETextArea("coursedataPalabrasClaves", false, 10, 50, null, 300);
    $elemP2->set_style_attribute('align', 'left');
    $elemP2->set_attribute("id","coursedatapalabrasclaves");
    $elemP2->set_attribute("accesskey","w");        
    $this->add_element($elemP2);

    $elemT3 = new FEText( "coursedataDestinatarios", FALSE, 10);
    $elemT3->set_style_attribute('align', 'left');
    $elemT3->set_attribute("id","coursedatadestinatarios");
    $elemT3->set_attribute("accesskey","u");        
    $this->add_element($elemT3);
        
    $elemP3 = new FETextArea("coursedataConocimientosPrevios", false, 10, 50, null, 300);
    $elemP3->set_style_attribute('align', 'left');
    $elemP3->set_attribute("id","coursedataconocimientosprevios");
    $elemP3->set_attribute("accesskey","k");        
    $this->add_element($elemP3);

    $elemT4 = new FEText( "coursedataMetodologia", FALSE, 10);
    $elemT4->set_style_attribute('align', 'left');
    $elemT4->set_attribute("id","coursedatametodologia");
    $elemT4->set_attribute("accesskey","m");        
    $this->add_element($elemT4);

    $elemCB1 = new FECheckBox('courseActive', agt('Poner el curso activo.') );
    $elemCB1->set_style_attribute('align', 'left');
    $elemCB1->set_attribute("id","courseactive");        
    $elemCB1->set_attribute("accesskey","o");                
    $this->add_element( $elemCB1 );

    $elemCB2 = new FECheckBox('courseAccess', agt('Poner el curso accesible.') );        
    $elemCB2->set_style_attribute('align', 'left');
    $elemCB2->set_attribute("id","courseaccess");
    $elemCB2->set_attribute("accesskey","p");                
    $this->add_element( $elemCB2 );        

    $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt("Insertar Curso"));
    $submit->set_attribute("id","submit"); 
    $submit->set_attribute("accesskey","e");               
    $this->add_element($submit);
  }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
  function form_init_data() 
  {
      //$this->set_hidden_element_value("id", "logon");
    $dataForm = $this->getViewVariable('courseDataForm');

    $this->set_element_value("courseName", $dataForm['c_name'] );
    $this->set_element_value("courseLanguage", $dataForm['c_language'] );
    //$this->set_element_value("coursedescription", $dataForm['c_description'] );
    $this->set_element_value("courseActive", $dataForm['c_active'] );
    $this->set_element_value("courseAccess", $dataForm['c_access'] );
    $this->set_element_value("coursedataDescripcion", $dataForm['cd_descripcion'] );
    $this->set_element_value("coursedataVersion", $dataForm['cd_version'] );
    $this->set_element_value("coursedataPalabrasClaves", $dataForm['cd_claves'] );
    $this->set_element_value("coursedataDestinatarios", $dataForm['cd_destinatarios'] );
    $this->set_element_value("coursedataConocimientosPrevios", $dataForm['cd_conocimientos'] );
    $this->set_element_value("coursedataMetodologia", $dataForm['cd_metodologia'] );

  }


    /**
     * Este metodo construye el formulario en sÃŒ.
     */
  function form() 
  {
    $table = &html_table($this->_width,0,1,3);
    //$table->set_style("border: 1px solid");

    $this->set_form_tabindex("courseName", '7');
    $label = html_label( "coursename" );        
    $label->add(container(html_b( agt('Nombre: ') ), html_br(), $this->element_form("courseName")));
    $elem = html_td("", "left",$label);
    $elem->set_id("courseName");        
    $table->add_row($elem);

    $this->set_form_tabindex("coursedataDescripcion", '8');
    $label = html_label( "coursedatadescripcion" );
    $label->add(container(html_b( agt('Descripción: ') ), html_br(), $this->element_form("coursedataDescripcion")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedataDescripcion");
    $table->add_row($elem);

    $this->set_form_tabindex("courseLanguage", '9');            
    $label = html_label( "courselanguage" );
    $label->add(container(html_b( agt('Idioma: ') ), html_br(), $this->element_form("courseLanguage")));
    $elem = html_td("", "left", $label);
    $elem->set_id("courseLanguage");
    $table->add_row($elem);
  
    $this->set_form_tabindex("coursedataVersion", '10');            
    $label = html_label( "coursedataversion" );
    $label->add(container(html_b( agt('Version: ') ), html_br(), $this->element_form("coursedataVersion")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedataversion");
    $table->add_row($elem);
  
    $this->set_form_tabindex("coursedataPalabrasClaves", '11');            
    $label = html_label( "coursedatapalabrasclaves" );
    $label->add(container(html_b( agt('Palabras Claves: ') ), html_br(), $this->element_form("coursedataPalabrasClaves")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedatapalabrasclaves");
    $table->add_row($elem);
    
    $this->set_form_tabindex("coursedataDestinatarios", '12');            
    $label = html_label( "coursedatadestinatarios" );
    $label->add(container(html_b( agt('Destinatarios: ') ), html_br(), $this->element_form("coursedataDestinatarios")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedatadestinatarios");
    $table->add_row($elem);

    $this->set_form_tabindex("coursedataConocimientosPrevios", '13');            
    $label = html_label( "coursedataconocimientosprevios" );
    $label->add(container(html_b( agt('Conocimientos Previos: ') ), html_br(), $this->element_form("coursedataConocimientosPrevios")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedataconocimientosprevios");
    $table->add_row($elem);

    $this->set_form_tabindex("coursedataMetodologia", '14');            
    $label = html_label( "coursedatametodologia" );
    $label->add(container(html_b( agt('Metodologia: ') ), html_br(), $this->element_form("coursedataMetodologia")));
    $elem = html_td("", "left", $label);
    $elem->set_id("coursedatametodologia");
    $table->add_row($elem);

    $this->set_form_tabindex("courseActive", '15');
    $label = html_label( "courseactive" );
    $label->add(container('', html_br(), $this->element_form("courseActive")));
    $elem = html_td("", "left", $label);
    $elem->set_id("courseActive");
    $table->add_row($elem);
       
    $this->set_form_tabindex("courseAccess", '16');        
    $label = html_label( "courseaccess" );
    $label->add(container('', html_br(), $this->element_form("courseAccess")));
    $elem = html_td("", "left", $label);
    $elem->set_id("courseAccess");       
    $table->add_row($elem);

    $this->set_form_tabindex("Aceptar", '17'); 
    $label = html_label( "submit" );
    $label->add($this->element_form("Aceptar"));
    $table->add_row(html_td("", "left",  $label));

    return $table;
  }
}

?>
