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
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla comÀôn para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar¬∑ la informaci√õn
 *  + Bloque de pie en la parte inferior
 *
 * --------------------------------
 * |         header block         |
 * --------------------------------	
 * |                              |	
 * |         data block           |
 * |                              |
 * --------------------------------	
 * |         footer block         |
 * --------------------------------
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));
class miguel_VCalendar extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El t√åtulo para la p¬∑gina
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesi√õn).
     *
	 */
    function miguel_VCalendar($title, $arr_commarea)
    {
        //Ejecuta el constructor de la superclase de la Vista
        $this->miguel_VMenu($title, $arr_commarea);
     }
    
    /**
     * this function returns the contents
     * of the right block.  It is already wrapped
     * in a TD
     * Solo se define right_block porque heredamos de VMenu y el left_block se encuentra ya definido por defecto con el men˙ del sistema.
     * Si heredara de miguel_VPage entonces habrÌa que definir de igual forma right_block y main_block. Esta ˙ltima es un contenedor de left_block y right_block
     * @return HTMLTag object
     */
    function right_block() 
    {
        //Crea el contenedor del right_block
        $ret_val = container();
		
        //Vamos a ir creando los distintos elementos (Estos a su vez son tambiÈn contenedores) del contenedor principal.
        //hr es una linea horizontal de HTML.
        $hr = html_hr();
        $hr->set_tag_attribute('noshade');
        $hr->set_tag_attribute('size', 2);

        //Añade la linea horizontal al contenedor principal
        $ret_val->add($hr);
		
        //Crea un bloque div y le asigna la clase ul-big del CSS
        $div = html_div();

        //Añade una imagen del tema
        //$div->add(Theme::getThemeImage('modules/agenda.png'));

        //Incluimos texto en negrita
        $titulo = html_p('Agenda del Curso');
        $titulo->set_class('ptabla01');
        $div->add($titulo);

        //Ahora dos retornos de carro

        //$ret_val->add($div);
		
        //$div = html_div('medium-text');
        
        $status = $this->getViewVariable('status');
        switch($status)
        {
			case 'new':      
				$pTitulo = html_p('Alta de evento');
				$pTitulo->set_class('ptabla01');
				$ret_val->add($pTitulo);
				$ret_val->add($this->addForm('calendar', 'miguel_calendarForm'));
				break;
			case 'show':
				$ret_val->add($this->show_Details($this->getViewVariable('calendar'), 
												  $this->getViewVariable('course'), 
												  $this->getViewVariable('event'),
												  $this->getViewVariable('subject'),
												  $this->getViewVariable('content'),
												  $this->getViewVariable('dt_ini'),
												  $this->getViewVariable('dt_fin'),
												  false
												 ));
				break;
			case 'menu':
				//$div->add($this->icon_link(Util::format_URLPath('calendar/index.php', 'status=new'), 
					//		Theme::getThemeImagePath('modules/agenda.png'), agt('miguel_Nuevo_Evento')));
				//$div->add(html_br(2));
				//$div->add($this->icon_link(Util::format_URLPath('calendar/index.php', 'status=list'), 
					//		Theme::getThemeImagePath('modules/agenda.png'), agt('miguel_Ver_Eventos')));
				//$div->add(html_br(2));
				$pNew = html_p(html_a(Util::format_URLPath('calendar/index.php', 'status=new'),'Nuevo Evento'));
				$pNew->set_class('ptabla03');
				$pShow = html_p(html_a(Util::format_URLPath('calendar/index.php', 'status=list'),'Ver Eventos'));
				$pShow->set_class('ptabla03');
				$div->add($pNew);
				$div->add($pShow);
				$ret_val->add($div);
				break;					
			case 'list':
			default: 
				$calendar_array=($this->getViewVariable('calendar_array'));
				for ($i=0; $i < count($calendar_array); $i++){
					$div->add($this->show_Details($calendar_array[$i]['calendar'], 
												  $calendar_array[$i]['course'], 
												  $calendar_array[$i]['event_type'],
												  $calendar_array[$i]['subject'],
												  $calendar_array[$i]['content'],
												  $calendar_array[$i]['dt_ini'],
												  $calendar_array[$i]['dt_fin'],
												  true
												 ));
					$div->add(html_br(2));
		 		}
				$ret_val->add($div);
		 		break;	
		}
		
		return $ret_val;
    }
	
		/**
		* Devuelve una table con la noticia $i del array de noticias $calendar_array
		*
		*/
		function add_calendar($author, $subject, $time, $calendar_id)
		{
			$table = &html_table(Session::getContextValue("mainInterfaceWidth"),0,2,2);
			$nombre = html_td('ptabla02', '', html_a(Util::format_URLPath('calendar/index.php',"status=show&id=$calendar_id"),$author));
			$nombre->set_tag_attribute('bgcolor','#808000');
			$nombre->set_tag_attribute('width','80%');
			$tiempo = html_td('ptabla03', '', html_a(Util::format_URLPath('calendar/index.php',"status=show&id=$calendar_id"),$time));
			$tiempo->set_tag_attribute('bgcolor','#99CE99');
			$tiempo->set_tag_attribute('align','right');
			$subject = html_td('ptabla03', '', html_a(Util::format_URLPath('calendar/index.php',"status=show&id=$calendar_id"),$subject));
			$subject->set_tag_attribute('bgcolor','#99CE99');
			$subject->set_tag_attribute('colspan',2);
			$table->add_row($nombre, $tiempo); 		 	
			$table->add_row($subject); 
			
			return $table;
		}
    
	function show_Details($calendar, $course, $event, $subject, $content, $dt_ini, $dt_fin, $opers = false)
	{
		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,2,2);
		//$dia = html_td('', '', html_b(ucfirst(NLS::localiseDateTime("%B %Y", $dt_ini))));
		$dia = html_td('ptabla02', '', html_b('Dia: '.ucfirst(NLS::localiseDateTime("%A, %d-%m-%Y", $dt_ini)).' desde '.NLS::localiseDateTime("%H:%M", $dt_ini).' hasta '.NLS::localiseDateTime("%H:%M", $dt_fin)));
		$dia->set_tag_attribute('bgcolor','#C0C0C0');
		$dia->set_tag_attribute('width','80%');
		
		$row = html_tr();
		$row->add($dia);
		if(!empty($calendar) && $opers && Session::getValue('isCourseAdmin')){
			$container = container();
			//$container->add(html_a(Util::format_URLPath('calendar/index.php',"status=modify&id=$calendar"), agt('miguel_modify')));
			//$container->add(' - ');
			$container->add(html_a(Util::format_URLPath('calendar/index.php',"status=delete&id=$calendar"), agt('miguel_delete')));
			$oper= html_td('ptabla03', '', $container);
			//$oper->set_tag_attribute('bgcolor','#C0C0C0');
			$oper->set_tag_attribute('width','20%');
			$row->add($oper);
		}
		$table->add_row($row);
		/*
		$tiempo = html_td('', '', html_a(Util::format_URLPath('calendar/index.php',"status=show&id=$calendar_id"),$time));
		$tiempo->set_tag_attribute('bgcolor','#99CE99');
		$tiempo->set_tag_attribute('align','right');
		*/
		if(!empty($course)){
			$cont2 = container();
			$cont2->add(html_b('Curso: '));
			$cont2->add($course);
			
			$row2 = html_tr();
			
			$row2->add(html_td('ptabla02', '', $cont2));
			$table->add_row($row2);
		}
		
		$cont3 = container();
		$cont3->add(html_b($subject));
		$cont3->add("&nbsp;");
		$cont3->add('Tipo de evento: '.$event);
		$table->add_row(html_td('ptabla02', '', $cont3));
		
		$table->add_row(html_td('ptabla03', '', nl2br($content)));
		
		return $table;
	}
 
}

?>
