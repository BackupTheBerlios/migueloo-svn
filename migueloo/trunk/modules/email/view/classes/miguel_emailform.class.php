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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
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

class miguel_emailForm extends base_FormContent
{
    function form_init_elements()
    {

			   $arrUsersCombo = $this->getViewVariable('arrUsersCombo');

                //Caja de texto de To
                $TextTo=$this->_formatElem("FEText", "To", "to", FALSE, "80");
                $TextTo->set_attribute('class','ptabla03');
                $this->add_element($TextTo);
				$TextTo->set_attribute('class',''); 
				$TextTo->set_disabled(true);

				$ListTo = $this->_formatElem("FEListBox", "listto", "listto", FALSE, "200px", NULL, $arrUsersCombo);
                $ListTo->set_attribute('class','ptabla03');
                $this->add_element($ListTo);


                $subject=$this->_formatElem("FEText", "Subject", "subject", FALSE, "50");
                $subject->set_attribute('class','ptabla03');
                $body=$this->_formatElem("FETextArea", "Body", "body", FALSE, 10, 60, '500px', '100px');
                $body->set_attribute('class','cajatexto');

                //Añade un boton con la acción submit  
                $submit = $this->_formatElem('base_SubmitButton', 'Enviar', 'submit', 'Enviar correo');
                $submit->set_attribute('id','submit');
                $submit->set_attribute('class','p');
                $submit->set_attribute('accesskey','e');

                //Añade un boton con la acción submit  
                $anadir = $this->_formatElem('base_SubmitButton', 'Anadir', 'anadir', 'A�adir');
                $anadir->set_attribute('id','anadir');
                $anadir->set_attribute('class','p');
                $anadir->set_attribute('accesskey','a');

                //Añade un boton con la acción submit  
                $borrar = $this->_formatElem('base_SubmitButton', 'Borrar', 'borrar', 'Borrar');
                $borrar->set_attribute('id','borrar');
                $borrar->set_attribute('class','p');
                $borrar->set_attribute('accesskey','b');

                $this->add_element($subject);
                $this->add_element($body);
                $this->add_element($submit);
                $this->add_element($anadir);
                $this->add_element($borrar);

                $this->add_hidden_element('status');
                $this->add_hidden_element('arrto');
                $this->set_hidden_element_value('status', 'new');
				$arrTo =  $this->getViewVariable('arrto');
				$this->set_hidden_element_value('arrto',$arrTo);
			    $this->set_element_value('To', $this->getViewVariable('to'));
    }

        function form_init_data()
        {
			   $this->set_element_value('To', $this->getViewVariable('to'));
                $this->set_element_value('Subject', $this->getViewVariable('subject'));
                $this->set_element_value('Body', $this->getViewVariable('body'));            
        }

        function form()
        {
                $table = &html_table($this->_width,0,2,2);
                $table->set_class('ptabla01');

                $labelAdd = html_label( 'anadir' );
                $labelAdd->add($this->element_form('Anadir'));
                $tdAnadir = html_td('', 'left',  $labelAdd);
                $this->set_form_tabindex('Anadir', '10');

                $labelDel = html_label( 'borrar' );
                $labelDel->add($this->element_form('Borrar'));
                $tdBorrar = html_td('', 'left',  $labelDel);
                $this->set_form_tabindex('Borrar', '8');

				
				//$table->add_row($this->_showElement('From', '6', 'To', 'miguel_fromMail', 'From', 'left' ));
                $table->add_row($this->_showElement('To', '7', 'To', 'Para', 'To', 'left' ), $tdBorrar, $this->_showElement('listto', '9', 'listto', 'Destinatarios', 'listto', 'left' ), $tdAnadir);
                $table->add_row($this->_showElement('Subject', '10', 'Subject', 'Asunto', 'Subject', 'left' ));
                $table->add_row($this->_showElement('Body', '11', 'Body', 'Mensaje', 'Body', 'left' ));


                $this->set_form_tabindex('Enviar', '12');
                $label = html_label( 'submit' );
                $label->add($this->element_form('Enviar'));
                $table->add_row(html_td('', 'left',  $label));

                return $table;
        }
}
?>
