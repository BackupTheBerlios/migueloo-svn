<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
 * Define la clase base para las pantallas de miguel.
 *
 * Se define una plantilla común para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentará la información
 *  + Bloque de pie en la parte inferior
 * <pre>
 * --------------------------------
 * |         header block         |
 * --------------------------------	
 * |                              |	
 * |         data block           |
 * |                              |
 * --------------------------------	
 * |         footer block         |
 * --------------------------------
 * </pre>
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */ 
include_once (Util::app_Path("common/view/classes/miguel_vbase.class.php"));

class miguel_VAlert extends miguel_VBase 
{
   	var $banner = 'Aviso de plataforma';
	var $text = 'Mensaje del sistema';
	
	function miguel_VAlert($str_title, $arr_commarea)
    {   
		$this->miguel_VBase($this->str_title, $arr_commarea);
		
		$this->banner = $this->getViewVariable('alert_banner');
		$this->text = $this->getViewVariable('alert_text');
    }

	function main_block()
	{
		$table = html_table(Session::getContextValue("mainInterfaceWidth"));
		$table->set_tag_attribute('align', 'center');
		
		//Cabecera
		$row0 = html_tr();
	
		$item1 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta00.gif"),42, 106));
		$item1->set_tag_attribute('width','1%');
		$item1->set_tag_attribute('valign','top');
		$row0->add($item1);
		
		$item2 = html_td('tituloalerta', '', $this->banner);
		$item2->set_tag_attribute('background', Theme::getThemeImagePath("fondo_alerta02.gif"));
		$item2->set_tag_attribute('width','95%');
		$item2->set_tag_attribute('valign','middle');
		$row0->add($item2);
		
		$item3 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta03.gif"),40, 106));
		$item3->set_tag_attribute('width','4%');
		$item3->set_tag_attribute('valign','top');
		$row0->add($item3);
		
		//$table->add_row($row0);
		
		//Cuerpo
		$row1 = html_tr();
	
		$item11 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta04.gif"),42, 106));
		$item11->set_tag_attribute('width','1%');
		$item11->set_tag_attribute('valign','top');
		//$row1->add($item11);
		$row1->add(html_td('ptexto01','',$this->text));
		
		$item13 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta05.gif"),40, 106));
		$item13->set_tag_attribute('width','4%');
		$item13->set_tag_attribute('valign','top');
		//$row1->add($item13);
		
		$table->add_row($row1);
		
		$row2 = html_tr();
	
		$item21 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta04.gif"),42, 106));
		$item21->set_tag_attribute('width','1%');
		$item21->set_tag_attribute('valign','top');
		//$row2->add($item21);
		//Dejar así, no usar  $this->addForm(), ya que el enlace se hace sin SID
		include_once (Util::app_Path("common/view/classes/miguel_navform.class.php"));
		$boton = html_td('','',new FormProcessor(new miguel_navForm(), 'reload', Util::main_URLPath('index.php')));
		$row2->add($boton);
		
		$item23 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta05.gif"),40, 106));
		$item23->set_tag_attribute('width','4%');
		$item23->set_tag_attribute('valign','top');
		//$row2->add($item23);
		
		$table->add_row($row2);
	
		//Pie
		$row9 = html_tr();
	
		$item91 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta06.gif"),42, 42));
		//$item91->set_tag_attribute('width','1%');
		$item91->set_tag_attribute('valign','top');
		$row9->add($item91);
		
		$item92 = html_td('', '', _HTML_SPACE);
		$item92->set_tag_attribute('background', Theme::getThemeImagePath("fondo_alerta07.gif"));
		//$item92->set_tag_attribute('width','95%');
		$item92->set_tag_attribute('valign','top');
		$row9->add($item92);
		
		$item93 = html_td('', '', html_img(Theme::getThemeImagePath("fondo_alerta08.gif"),40, 42));
		//$item93->set_tag_attribute('width','4%');
		$item93->set_tag_attribute('valign','top');
		$row9->add($item93);
		
		//$table->add_row($row9);
		
		return $table;
	}
}
?>
