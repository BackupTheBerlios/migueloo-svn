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
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VDetail extends miguel_VMenu
{
	function miguel_VDetail($title, $arr_commarea) 
	{
		$this->miguel_VMenu($title, $arr_commarea);
	}

    function right_block() 
    {
		$div = html_div();
		$titulo = html_p(agt('miguel_ContactDetail'));
		$titulo->set_tag_attribute('class', 'ptabla01');
		$div->add($titulo);
		
		$div->add( $this->_contactDetail()); 
        
		return $div;	
	}

    function _contactDetail()
    {
        $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		
        $contact = $this->getViewVariable('detail_contacts');
     
        if ( is_array($contact) && $contact[0]['contact.contact_id'] != null) {
            $table->add_row($this->add_info('Nombre', $contact[0]['contact.contact_name']));
			$table->add_row($this->add_info('Apellido', $contact[0]['contact.contact_surname']));
			if ($contact[0]['contact.contact_nick']!=null)
			{
				$table->add_row($this->add_info('Usuario', $contact[0]['contact.contact_nick']));
			}
			$table->add_row($this->add_info('Correo electrónico', $contact[0]['contact.contact_mail']));
			$table->add_row($this->add_info('Comentarios', nl2br($contact[0]['contact.contact_comments'])));
		}
		$btDel = html_a(Util::format_URLPath("contact/index.php", "contact_id=".$contact[0]['contact.contact_id']."&option=delete"), 'Eliminar', null, '_top');
		$btDel->set_tag_attribute('class', '');
		$btBack = html_a(Util::format_URLPath("contact/index.php", ''), 'Volver', null, '_top');
		$btBack->set_tag_attribute('class', '');
		$table->add_row($btBack, $btDel);
        return $table;
    }
	
	function add_info($_title, $_value)
	{
        $row = html_tr();
    
		$item1 = html_td('ptabla02', '',$_title);
		$item2 = html_td('ptabla03', '', $_value);
		
		$item1->set_tag_attribute('width','35%');
 		$item2->set_tag_attribute('width','65%');
		
		$row->add($item1);
		$row->add($item2);
		
 		return $row;
	}
}

?>
