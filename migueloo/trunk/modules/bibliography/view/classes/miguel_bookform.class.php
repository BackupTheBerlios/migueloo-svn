<?php
/*
      +----------------------------------------------------------------------+
      | bibliography                                                         |
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
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_bookForm extends miguel_FormContent
{
    function form_init_elements()
    {
                $elemTitulo = $this->_formatElem("FEText", 'titulo', 'titulo', FALSE, "100");
                $elemTitulo->set_attribute('class','ptabla03');
                $this->add_element($elemTitulo);

                $elemAutor = $this->_formatElem("FEText","autor", "autor", FALSE, "100");
                $elemAutor->set_attribute('class','ptabla03');
                $this->add_element($elemAutor);

                $elemDate = $this->_formatElem("FEYears" ,"año", "f_edicion", FALSE, null, null, '1900', date('Y'));
                $elemDate->set_attribute('class','ptabla03');
                $this->add_element($elemDate);

                $elemEditorial = $this->_formatElem("FEText", "editorial" , "editorial", FALSE, "100");
                $elemEditorial->set_attribute('class','ptabla03');
                $this->add_element($elemEditorial);

                $elemLugar = $this->_formatElem("FEText", "lugar de publicación" , "lugar_pub", FALSE, "100");
                $elemLugar->set_attribute('class','ptabla03');
                $this->add_element($elemLugar);

                $elemIsbn = $this->_formatElem("FEText", "ISBN" , "isbn", FALSE, "20");
                $elemIsbn->set_attribute('class','ptabla03');
                $this->add_element($elemIsbn);

                $elemDescripcion = $this->_formatElem("FETextArea", "descripción", "descripcion", FALSE, 20, 10,"400px", "100px");
                $elemDescripcion->set_attribute('class','ptabla03');
                $this->add_element($elemDescripcion);

                $elemIndice = $this->_formatElem("FETextArea", "tabla de contenidos", "indice", FALSE, 20, 10,"400px", "100px");
                $elemIndice->set_attribute('class','ptabla03');
                $this->add_element($elemIndice);

                /*
                $elemDonde = $this->_formatElem("FEText", "Lugar y/o forma de obtenerlo", "como_obtener", FALSE, "100");
                $elemDonde->set_attribute('class','ptabla03');
                $this->add_element($elemDonde);
                */

                // file upload
        $elemFile = new FEFile("imagen", false, "200px");
        $elemFile->add_valid_type('image/gif');
        $elemFile->add_valid_type('image/jpeg');
        $elemFile->set_max_size(1024 * 10); //1024 * numero de KB
        $this->add_element($elemFile);

                $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", agt('Añadir'));
                $submit->set_attribute('class','p');
                $submit->set_attribute('accesskey','e');
                $this->add_element($submit);

                $this->add_hidden_element("status");
    }

    function form_init_data()
    {
                 $this->set_hidden_element_value("status", "new");
                return;
    }

    function form()
    {
                $table = &html_table($this->_width,0,0);

                $row=$this->_tableRow("autor");
                $table->add_row($row);

                $row=$this->_tableRow('titulo');
                $table->add_row($row);

                $row=$this->_tableRow("año");
                $table->add_row($row);

                $row=$this->_tableRow("editorial");
                $table->add_row($row);

                $row=$this->_tableRow("lugar de publicación");
                $table->add_row($row);

                $row=$this->_tableRow("ISBN");
                $table->add_row($row);

                $row=$this->_tableRow("descripción");
                $table->add_row($row);

                $row=$this->_tableRow("tabla de contenidos");
                $table->add_row($row);
                /*
                $row=$this->_tableRow("Lugar y/o forma de obtenerlo");
                $table->add_row($row);
                */

                $row=$this->_tableRow("imagen");
                $table->add_row($row);

                $this->set_form_tabindex("Aceptar", '10');
                $label = html_label( "submit" );
                $label->add($this->element_form("Aceptar"));
                $table->add_row(html_td("", "left",  $label));

                return $table;
    }
}
?>
