<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                          |
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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |
      +----------------------------------------------------------------------+
*/
/**
 * Todo el patrÛn MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage view
 */
/**
 * Define la clase que construye la cabecera para las pantallas de miguel.
 * Utiliza la libreria phphtmllib.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */
class miguel_Header
{
	var $str_help ='';
	var $str_message = '';
	
	function miguel_Header($help, $message)
	{
		$this->str_help = $help;
		$this->str_message = $message;
	}
	
	function getContent()
	{
		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1);
		$table->set_class("header");
		$table->set_id("header");
	
		//Icono y bienvenida
		$elem1 = html_td('campuslogo', '', $this->getCabecera());
	
		//Campus virtual
		if(Session::getContextValue("siteName") != ''){
			$link = html_a(Util::main_URLPath("index.php"),agt("Campus").":&nbsp;".Session::getContextValue("siteName"));
			$link->set_tag_attribute('accesskey','c');
			$link->set_tag_attribute('tabindex','1');
			$elem2 = html_td("", "", $link);
		} else {
			$elem2 = html_td("colorMedium-bg", "", agt("Campus"));
		}
		$elem2->set_id("cell-sitename");
		$elem2->set_tag_attribute("target","_top");
		//miguel
		$link = html_a("https://developer.berlios.de/projects/migueloo/","miguel");
		$link->set_tag_attribute('accesskey','m');
		$link->set_tag_attribute('tabindex','2');		    
		$elem3 = html_td("colorLight-bg", "", $link);
		$elem3->set_id("cell-indetec");
		$elem3->set_tag_attribute("target","_blank");
		
		//Nombre del sitio web
		$link = html_a(Session::getContextValue("InstitutionUrl"),Session::getContextValue("Institution"));
		$link->set_tag_attribute('accesskey','i');
		$link->set_tag_attribute('tabindex','4');	       
		$elem4 = html_td("colorDark-bg", "", $link);
		$elem4->set_id("cell-institution");
		$elem4->set_tag_attribute("target","_blank");
	
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);
		$row->add($elem3);
		$row->add($elem4);
			
		$table->add_row($row);
		
		$elemM = html_td('', '', '&nbsp;');
        //$elemM->set_tag_attribute('bgcolor', Session::getContextValue('menucolor'));

        $table->add_row($elemM);
		
		//Sistema de mensajes de la aplicaciÛn
		$row = html_tr();
	
		if($this->str_message){
			$msg = html_td("infocontainer", "", html_b($this->str_message));
		} else {
			$msg = html_td("", "", '');
		}	
		//$msg->set_tag_attribute("colspan","4");
		$msg->set_tag_attribute("colspan","3");
		$row->add($msg);
				
		if($this->str_help){
			$help = html_td("helpbox", "", $this->help_img(Util::format_URLPath("help/miguel_help.php","help=".$this->str_help), Theme::getThemeImagePath("help_mini.png"), ""));
		} else {
			$help = html_td("", "", '');
		}
		$row->add($help);
		$table->add_row($row);
		
		//Sistema de menues
		$barra =  $this->_menuBar();
		if(!empty($barra)){
			$container = container(html_img(Theme::getThemeImagePath("logo.png"), 0, 0, 0, "miguel Home"), html_br(), "&nbsp;");
			$row = html_tr();
	
			$menu = html_td('navigator', '', $barra/*,html_img()*/);
			$menu->set_tag_attribute("colspan","3");
		
			$row->add($menu);
		}
		
		$table->add_row($row);
				
		return $table;
	}
	
		/**
		* Construye la barra de navegaciÛn
		* @access private
		*/
	function _menuBar()
	{
		$ret_val = '';
		
		/*
		$menu[]= array ("url" => Util::format_URLPath("lib/index.php"), "name" => Session::getContextValue("siteName"));
		//$menu = array_merge ($menu, $this->getViewVariable("menubar"));
		$menu = array_merge ($menu, $this->getSessionElement('bar_array'));
		*/
		
		$menu = Session::getValue('bar_array');
		if (is_array($menu) && !empty($menu)) {
			$ret_val = container();
			for($i=0; $i < count($menu) -1; $i++) {
				$ret_val->add(html_a($menu[$i]["url"], $menu[$i]["name"], null, "_top"));
				$ret_val->add(">");
			}
			$ret_val->add(html_a($menu[count($menu) - 1]["url"], $menu[count($menu) - 1]["name"], null, "_top"));
		}
		return $ret_val;
	
	}
	
	function getCabecera()
	{
		if(Session::getValue("userinfo_user_alias") == null) {
			$container = container(html_img(Theme::getThemeImagePath("logo.png"), 0, 0, 0, "miguel Home"), html_br(), "&nbsp;");
		} else {
			if (Session::getValue("userinfo_user_alias") != 'guest') {
				$str_userName = Session::getValue('userinfo_treatment') . ' ' . Session::getValue("userinfo_name").' '.Session::getValue("userinfo_surname");
			} else {
				$str_userName = agt("Guest");
			}
			$container = container(html_img(Theme::getThemeImagePath("logo.png"), 0, 0, 0, "miguel Home"), html_br(), agt("LoggedAs")."&nbsp;".$str_userName);	
		}
		
		return $container;
	}
	
	function getUtilBar()
	{
				$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,0,0);
	
				//Icono y bienvenida
				//NO CAMBIAR CLASE en elemento 1
				$elem1 = html_td('fondopagina', '', html_img(Theme::getThemeImagePath("esquina.gif"), 37, 39));
				$elem1->set_tag_attribute('width', '1%');
				$elem1->set_tag_attribute('height', '39');
	
				$elem2 = html_td('', '', $this->getNavBar());
				$elem2->set_tag_attribute('width', '99%');
				$elem2->set_tag_attribute('height', '39');
	
				$row = html_tr();
				$row->add($elem1);
				$row->add($elem2);
	
				$table->add_row($row);
	
				return $table;
	}
	
		/**
		* Define el formato de la cabecera
		* @access private
		*/
	function getNavBar()
	{
				$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,0,0);
				$table->set_class('fecha');
				$row = html_tr();
				//$row->set_tag_attribute('valign', 'bottom');
	
				$msg = html_td('', "", $this->str_message);
				$msg->set_tag_attribute('align', 'left');
	
				$fecha = html_script();
				$fecha->add('damefecha();');
	
				$row->add($msg);
				$row->add(html_td('', '', $fecha));
	
				$table->add_row($row);
	
				return $table;
	}
	
	/**
		* Construye una imagen con referencia
		* @access private
		*/
	function help_img($path_action, $path_img, $text)
	{
			$table = container();
	
			if($text == ''){
				$elem = html_a("#","");
				$elem->add(html_img($path_img, 0, 0, 0, "help"));
				$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=600,left=300,top=40'); return false;");
				$elem->set_tag_attribute('accesskey', 'h');
				$elem->set_tag_attribute('tabindex', '5');
				$table->add($elem);
			} else {
				$elem = html_a("#","");
				$elem->add(html_img($path_img, 0, 0, 0, ""));
				$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
				$table->add($elem);
				
				$elem = html_a("#",$text);
				$elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
				$table->add($elem);
		}
		
		return $table;
	}
}
?>
