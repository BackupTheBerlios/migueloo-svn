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
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_CCalendar extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CCalendar() 
	{
		$this->miguel_Controller();
		$this->setModuleName('calendar');
		$this->setModelClass('miguel_MCalendar');
		$this->setViewClass('miguel_VCalendar');
		$this->setCacheFlag(false);
	}
    
  /*=========================================================================
		Esta función ejecuta el Controlador 
		=========================================================================*/
	function processPetition() 	
	{ 
		//Consultar la variable status. Si no existe se establece a 'menú' 
		if ($this->issetViewVariable('status')){
			$status = $this->getViewVariable('status');
		} else {
			$status = 'menu';
			$this->setViewVariable('status', 'menu');
		}
		
		//Debug::oneVar($this->arr_form, __FILE__, __LINE__);
	
		//Según el valor de status abrir una u otra vista
		switch($status)
		{
			case 'new': 
				if ($this->issetViewVariable('submit')){
					$this->processNewEvento();
				} else {
					$this->setViewVariable('events', $this->obj_data->getEventTypes());
					$this->addNavElement(Util::format_URLPath('calendar/index.php', 'status=new'),'Nuevo evento');
					$this->setMessage("Inserción de un nuevo evento");
				}
				
				break;
			case 'delete': 
				if($this->issetViewVariable('id')){
					$this->obj_data->deleteEvent($this->getViewVariable('id'));
				} 
				$this->setViewVariable('calendar_array', $this->obj_data->getEvents());
				$this->addNavElement(Util::format_URLPath('calendar/index.php', 'status=list'),'Ver eventos');
				
				break;	
			case 'list': 
				$this->setViewVariable('calendar_array', $this->obj_data->getEvents());
				$this->addNavElement(Util::format_URLPath('calendar/index.php', 'status=list'),'Ver eventos');
				break;
			case 'show':
				if($this->issetViewVariable('id')){
					$id = $this->getViewVariable('id');
					$event = $this->obj_data->getEvent($id);
					$this->setViewVariable('calendar', $id);
					$this->setViewVariable('course', $this->obj_data->getCourseDescription($event[0]['course_id']));
					$this->setViewVariable('event', $this->obj_data->getEventTypeDescription($event[0]['event_type_id']));
					$this->setViewVariable('subject', $event[0]['title']);
					$this->setViewVariable('content', $event[0]['description']);
					$this->setViewVariable('dt_ini', $event[0]['date_start']);
					$this->setViewVariable('dt_fin', $event[0]['date_end']);
				}
				break;
			case 'menu': 
				$this->addNavElement(Util::format_URLPath('calendar/index.php'), 'Agenda del Curso');
				$this->setMessage("Agenda del curso");
		}
	
		//Establecer el título de la página
		$this->setPageTitle("miguel Calendar Page");
	
		//Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
		$this->setHelp("");
	}

	/*=========================================================================
		Procesamiento de la petición de nuevo comentario
		=========================================================================*/
	function processNewEvento()
	{
		if ($this->issetViewVariable('_days') && $this->issetViewVariable('_months') && $this->issetViewVariable('_years')){
			$date = $this->getViewVariable('_years').'-'.$this->getViewVariable('_months').'-'.$this->getViewVariable('_days');
		} 
		
		if ($this->issetViewVariable('hora_inicio_hours') && $this->issetViewVariable('hora_inicio_minutes')){
			$ini_time = $this->getViewVariable('hora_inicio_hours').':'.$this->getViewVariable('hora_inicio_minutes').':00';
		}
		
		if ($this->issetViewVariable('hora_fin_hours') && $this->issetViewVariable('hora_fin_minutes')){
			$fin_time = $this->getViewVariable('hora_fin_hours').':'.$this->getViewVariable('hora_fin_minutes').':00';
		}

		$bol_cuestion = true;
		
		//Comprueba el contenido de la Variable nombre. Esta se le pasa como entrada al controlador y puede venir de un formulario o un link
		if( $this->issetViewVariable('asunto') && $this->getViewVariable('asunto') != ''){
			if( $this->issetViewVariable('comentario') && $this->getViewVariable('comentario') != ''){
				//Poner control
				$bol_cuestion = false;
			
				$course_id = Session::getValue('courseinfo_course_id');
				$course_name = Session::getValue('courseinfo_course_name');
				if(empty($course_id)){
					$course_id = 0;
					$course_name = '';
				}
	
				$event 		= $this->getViewVariable('tipo_de_evento');
				$subject 	= $this->getViewVariable('asunto');
				$content	= $this->getViewVariable('comentario');
				$dt_ini		= $date.' '.$ini_time;
				$dt_fin		= $date.' '.$fin_time;
				$dt_aud		= date("Y-m-d H:i:s");
				$user_aud	= Session::getValue('userinfo_user_id');
						
				//Realizamos una llamada al Modelo $this->obj_data->Método(Parámetros);
				$calendar_id = $this->obj_data->insertEvent($course_id, $event, $subject, $content, $dt_ini, $dt_fin, $dt_aud, $user_aud);
			} 
		}
			
		//Si está relleno se muestra el contenido
		if (!$bol_cuestion){
			$this->setViewVariable('calendar', $calendar_id);
			$this->setViewVariable('course', $course_name);
			$this->setViewVariable('event', $this->obj_data->getEventTypeDescription($event));
			$this->setViewVariable('subject', $subject);
			$this->setViewVariable('content', $content);
			$this->setViewVariable('dt_ini', $dt_ini);
			$this->setViewVariable('dt_fin', $dt_fin);
			
			$this->setViewVariable('status', 'show');
		}
	}
}
?>
