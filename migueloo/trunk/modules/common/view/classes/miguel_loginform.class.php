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
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
 
class miguel_loginForm extends base_FormContent 
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();
        
        $elemT = new FEText( "Nombre de usuario", FALSE, 10);
        $elemT->set_style_attribute('align', 'right');
        $elemT->set_attribute("id","nombre_de_usuario");
        $elemT->set_attribute("accesskey","u");        
        $this->add_element($elemT);

        $elemP = new FEPassword("Clave de acceso", FALSE, 10, 25);
        $elemP->set_style_attribute('align', 'right');
        $elemP->set_attribute("id","clave_de_acceso");
        $elemP->set_attribute("accesskey","p");        
        $this->add_element($elemP);

        $submit = $this->_formatElem("base_SubmitButton", "Entrar", "submit", agt("miguel_Enter") . " >");
        $submit->set_attribute("id","submit");
        $submit->set_attribute("accesskey","e");       
        $this->add_element($submit);        
        //lets add a hidden form field
        $this->add_hidden_element("id");
    }

    /**
     * Este metodo asigna valores a los diferentes objetos.
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
        $this->set_hidden_element_value("id", "logon");
        //$this->set_element_value('Nombre de usuario', 'guest');
        //$this->set_element_value('Clave de acceso', 'guest');
        
    }


    /**
     * Este metodo construye el formulario en sÌ.
     */
    function form() 
    {
        $table = &html_table($this->_width,0,1,3);
        //$table->set_style("border: 1px solid");

        $this->set_form_tabindex("Nombre de usuario", '6');        
        $label = html_label( "nombre_de_usuario" );
        $label->add(container(html_b( agt('miguel_UserName') ), html_br(), $this->element_form("Nombre de usuario")));        
        $elem = html_td("colorLogin-bg", "center", $label);
        $elem->set_id("identification");        
        $table->add_row($elem);

        $this->set_form_tabindex("Clave de acceso", '6');   
        $label = html_label( "clave_de_acceso" );
        $label->add(container(html_b( agt('miguel_UserPassword') ), html_br(), $this->element_form("Clave de acceso")));                                
        $elem = html_td("colorLogin-bg", "center", $label);
        $elem->set_id("identification");       
        $table->add_row($elem);

        $this->set_form_tabindex("Entrar", '11'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Entrar"));         
        $table->add_row(html_td("", "center",  $label));
                                
        return $table;
    }
}

?>
