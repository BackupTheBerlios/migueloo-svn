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

class miguel_userprofileForm extends miguel_FormContent
{
        /**
         * Este metodo se llama cada vez que se instancia la clase.
         * Se utiliza para crear los objetos del formulario
         */
        function form_init_elements()
        {

                $elemNombre = $this->_formatElem("FEText", "Nombre", "nom_form", FALSE, "50", "50");
                $elemNombre->set_attribute('class','');
                $elemNombre->set_attribute('class','');
                $elemNombre->set_disabled(true);
                $this->add_element($elemNombre);

                $elemApellido1  = $this->_formatElem("FEText", "Primer Apellido", "prenom_form", FALSE, "60", "80");
                $elemApellido1 ->set_attribute('class','');
                $elemApellido1->set_attribute('class','');
                $elemApellido1->set_disabled(true);
                $this->add_element($elemApellido1);

                $elemApellido2  = $this->_formatElem("FEText", "Segundo Apellido", "prenom_form2", FALSE, "60","80");
                $elemApellido2 ->set_attribute('class','');
                $elemApellido2->set_attribute('class','');
                $elemApellido2->set_disabled(true);
                $this->add_element($elemApellido2 );

                $elemUltMod = $this->_formatElem("FEText", "Ultima Modificacion" , "last_modify_form", FALSE, "20", "20");
                $elemUltMod->set_attribute('class','');
                $elemUltMod->set_attribute('class','');
                $elemUltMod->set_disabled(true);
                $this->add_element($elemUltMod);


                $elemWho = $this->_formatElem("FETextArea", "Quién soy", "who_form", FALSE, "2", "150");
                $elemWho->set_attribute('class','');
                $this->add_element($elemWho);

                $elemWhatOffer = $this->_formatElem("FETextArea", "Qué te puedo ofrecer", "what_offer_form", FALSE, "2","150");
                $elemWhatOffer->set_attribute('class','');
                $this->add_element($elemWhatOffer);

                $elemWhatLearn = $this->_formatElem("FETextArea", "Qué estoy dispuesto a aprender", "what_learn_form", FALSE, "2", "150");
                $elemWhatLearn->set_attribute('class','');
                $this->add_element($elemWhatLearn);

                $elemWebInterest = $this->_formatElem("FETextArea", "Páginas de interes", "web_interest_form", FALSE, "2","150");
                $elemWebInterest->set_attribute('class','');
                $this->add_element($elemWebInterest);

                $elemMention = $this->_formatElem("FETextArea", "Cita favorita", "mention_favorite_form", FALSE, "2","150");
                $elemMention->set_attribute('class','');
                $this->add_element($elemMention);

                // file upload
        $elemFile = new FEFile("imagen", false, "200px");
        $elemFile->add_valid_type('image/gif');
        $elemFile->add_valid_type('image/jpeg');
        $elemFile->set_max_size(1024 * 10); //1024 * numero de KB
        $this->add_element($elemFile);


                $elemOK = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt('guardar cambios'));
                $elemOK->set_attribute('class','p');
                $this->add_element($elemOK);

                $this->add_hidden_element('status');
                $this->add_hidden_element('personid');
        }

        function form_init_data()
        {
                $this->initialize();
        }

        function initialize()
        {
                $arr_info = $this->getViewVariable('arr_info');

                $this->set_hidden_element_value('status', $arr_info['status']);
                $this->set_hidden_element_value('personid',$arr_info['personid']);
                $this->set_element_value('Nombre',$arr_info['nombre']);
                $this->set_element_value('Primer Apellido',$arr_info['apellido1']);
                $this->set_element_value('Segundo Apellido',$arr_info['apellido2']);
                $this->set_element_value('Ultima Modificacion',$arr_info['last_modify']);

                $this->set_element_value('Quién soy',$arr_info['who']);
                $this->set_element_value('Qué te puedo ofrecer',$arr_info['what_offer']);
                $this->set_element_value('Qué estoy dispuesto a aprender',$arr_info['what_learn']);
                $this->set_element_value('Páginas de interes',$arr_info['web_interest']);
                $this->set_element_value('Cita favorita',$arr_info['mention_favorite']);
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

                //inicializa la tabla
                $table = &html_table($this->_width,0,0,0);
                $table->set_class("mainInterfaceWidth");


                //inicializa tabla detalle de la primera fila
                $detail_table = &html_table($this->_width,0,0,0);
                $detail_table->set_class("mainInterfaceWidth");

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

                //añade filas a la tabla
                $this->add_class_row($table,"Quién soy");
                $this->add_class_row($table,"Qué te puedo ofrecer");
                $this->add_class_row($table,"Qué estoy dispuesto a aprender");
                $this->add_class_row($table,"Páginas de interes");
                $this->add_class_row($table,"Cita favorita");


                $row = html_tr();
                //$row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
                $row->add("Politica de privacidad", "Los datos serán almacenados de forma segura y no se cederán a terceras partes.");
                //$table->add_row($row);

                //añade el boton de guardar
                $table->add_row(_HTML_SPACE, $this->element_form("Aceptar"));

                return $table;
        }
}

?>
