<?php
/*
      +----------------------------------------------------------------------+
      |bibliography                                                          |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package bibliography
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmessage.class.php"));

class miguel_VResume extends miguel_VMessage
{
	function miguel_VResume($title, $arr_commarea)
	{
		$this->miguel_VMessage($title, $arr_commarea);
	}
	
	function main_block()
	{
		$wrapper_div = html_div('');
				
		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,0,0);
		
		$elem1 = html_td('', '',  html_img(Theme::getThemeImagePath("esquina.gif"), 37, 39, 0, ''));
		$elem1->set_tag_attribute('width', '1%');
		
		$elem2 = html_td('', '', '');
		$elem2->set_tag_attribute('width', '96%');	

		$elem3 = html_td('', '', '');
		$elem3->set_tag_attribute('width', '3%');	
		
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);
		$row->add($elem3);
		
		$table->add_row($row);
		
		$row = html_tr();
		$space = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif")));
		$space->set_tag_attribute('width', '3%');
		$row->add($space);
		//Preparamos contenido		
		$content = html_td('', '', $this->content());
		$content->set_tag_attribute('width', '94%');
		$row->add($content);
		$row->add($space);
		$table->add_row($row);

		$marco = html_table(Session::getContextValue("mainInterfaceWidth"),0,0,0);
		$mc_cont = html_td('plomoizda', '', $table);
		$mc_cont->set_tag_attribute('valign','top');
		$marco->add_row($mc_cont);
		
		//add the main body
		$wrapper_div->add( $marco );

		//linea fondo
		$linea = html_table(Session::getContextValue("mainInterfaceWidth"),0,0,0);		
		$yellowLine = html_tr();
		$yellowLine->set_tag_attribute('bgcolor','#FFCC33');
		//$yellowLine->set_tag_attribute('valign','top');
		$line = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
		$line->set_tag_attribute('colspan','3');
		$yellowLine->add($line);
		$linea->add_row($yellowLine);

		$wrapper_div->add( $linea );
		
		$this->add( $wrapper_div );
	}
	
	function content() 
    {
		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		$arr_data = $this->getViewVariable('arrBook');
		$title = $arr_data['ptabla01'];
		$content = $this->add_resume($arr_data);
		
		
		$table->add_row(html_td('ptabla01', '', $title));
		$table->add_row(html_td('ptabla03', '', _HTML_SPACE));
		$table->add_row(html_td('ptabla03', '', $content));
		$table->add_row(html_td('ptabla03', '', _HTML_SPACE));
		$table->add_row(html_td('ptabla01pie', '', $title));
		$table->add_row(html_td('ptabla03', '', _HTML_SPACE));
		$table->add_row(html_td('ptabla02', '', html_a('javascript:window.close();',agt('Cerrar'),'titulo02a')));
		
		return $table;
    }
	    
    function add_resume($arr_data) 
    {
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		
		if ($arr_data['book_id'] != null) {
			//Tabla de detalle
			$row = html_tr();
			$img = Util::main_URLPath('var/bibliography/image/bookref_'.$arr_data['book_id'].'.'.$arr_data['imagen']);
			$image = html_td('', '', html_img($img, 74, 100));
			$image->set_tag_attribute("width","12%");
			$image->set_tag_attribute("align","center");
			$detail_table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
			$detail_table->add($this->add_Row('autor', $arr_data['autor']));
			$detail_table->add($this->add_Row('título', $arr_data['ptabla01']));
			$detail_table->add($this->add_Row('año', $arr_data['año']));
			$detail_table->add($this->add_Row('editorial', $arr_data['editorial']));
			$detail_table->add($this->add_Row('lugar de publicación', $arr_data['place']));
			$detail_table->add($this->add_Row('ISBN', $arr_data['isbn']));
						
			$row->add($image);
			$row->add($detail_table);
			$table->add($row);
						
			$table->add($this->add_Row('descripción', nl2br($arr_data['descripcion'])));
		} else {
			$table->add($this->add_Row('', agt('La ficha no existe')));
		}
	
		return $table;
	}
		
	function add_Row($label, $value)
	{
		$row = html_tr();
		//$row->set_class('ptabla01');
			
		$title = html_td('ptabla02', "", agt($label));
		$title->set_tag_attribute("width","12%");		
		$value = html_td('ptabla03', "", $value);
		//$value->set_tag_attribute("width","90%");
		
		$row->add($title);
		$row->add($value);
		
		return $row;
	}
}
?>
