<?php
/*
      +----------------------------------------------------------------------+
      |email                                                        |
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
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package email
 * @subpackage view
 * @version 1.0.0
 */

class miguel_coursecardform extends base_FormContent
{
    function form_init_elements()
    {
         $objectives=$this->_formatElem('FETextArea', 'objectives', 'objectives', FALSE, 10, 60, '500px', '100px');
         $objectives->set_attribute('class','ptabla03');
         $description=$this->_formatElem('FETextArea', 'description', 'description', FALSE, 10, 60, '500px', '100px');
         $description->set_attribute('class','ptabla03');
         $contents=$this->_formatElem('FETextArea', 'contents', 'contents', FALSE, 10, 60, '500px', '100px');
         $contents->set_attribute('class','ptabla03');

        //AÃ±ade un boton con la acciÃ³n submit
        $submit = $this->_formatElem('base_SubmitButton', 'Guardar', 'submit', 'Guardar');
        $submit->set_attribute('id','submit');
        $submit->set_attribute('class','p');
        $submit->set_attribute('accesskey','e');

        $this->add_element($objectives);
        $this->add_element($description);
        $this->add_element($contents);
        $this->add_element($submit);

        $this->add_hidden_element('status');
        $this->set_hidden_element_value('status', 'update');

		$arrCourseCard = $this->getViewVariable('arrCourseCard');
         $this->set_element_value('objectives', $arrCourseCard['objectives']);
         $this->set_element_value('description', $arrCourseCard['description']);
         $this->set_element_value('contents', $arrCourseCard['contents']);
    }

    function form_init_data()
    {
	
    }

    function form()
    {
        $table = &html_table($this->_width,0,2,2);
        $table->set_class('ptabla02');
        $table->add_row($this->_showElement('objectives', '7', 'objectives', 'Objetivos', 'objectives', 'left' ));
        $table->add_row($this->_showElement('description', '8', 'description', 'Descripción', 'description', 'left' ));
        $table->add_row($this->_showElement('contents', '9', 'contents', 'Contenidos', 'contents', 'left' ));


        $this->set_form_tabindex('Guardar', '10');
        $label = html_label( 'submit' );
        $label->add($this->element_form('Guardar'));
        $table->add_row(html_td('', 'left',  $label));

        return $table;
    }
}
?>
