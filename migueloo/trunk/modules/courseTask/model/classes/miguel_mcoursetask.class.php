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
 * @package miguel auth
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MCourseTask extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MCourseTask() 
    {
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
	
	//Implementa el método readNotice
    function getEventTypes()
    {
		$events = $this->Select('event_type', 'event_type_id, event_type_description');
		
    	if ($this->hasError()) {
    		$arr_events = null;
    	}
		for ($i=0; $i < count($events); $i++) {
    		$arr_events[$events[$i]['event_type.event_type_description']] = $events[$i]['event_type.event_type_id'];
    	}

    	return ($arr_events);
    }
	
    function getEventTypeDescription($event)
    {
		$events = $this->Select('event_type', 'event_type_description', "event_type_id = $event");

    	if ($this->hasError()) {
    		$event_desc = '';
    	} else {
			$event_desc = $events[0]['event_type.event_type_description'];
		}
		
    	return ($event_desc);
    }
	
	function getCourseDescription($course_id)
    {
		$data = $this->Select('course', 'course_description', "course_id = $course_id");

    	if ($this->hasError()) {
    		$data_desc = '';
    	} else {
			$data_desc = $data[0]['course.course_description'];
		}
		
    	return ($data_desc);
    }
	
    //Implementa el método insertSugestion
    function insertEvent($id_course, $event, $subject, $content, $dt_ini, $dt_fin, $dt_aud, $user_aud)
    {       
		//Inserta en la tabla todo. Los parámetros de Insert son: tabla, campos y valores
        $ret_val = $this->Insert('calendar',
                                 'course_id, event_type_id, title, description, date_start, date_end, all_day, aud_time, aud_user_id',
                                 array($id_course, $event, $subject, $content, $dt_ini, $dt_fin, 0, $dt_aud, $user_aud));

        //Comprueba si ha ocurrido algún error al realizar la operación
    	if ($this->hasError()) {
    		$ret_val = 0;
    	}
    	return ($ret_val);
    }
    
    //Implementa el método readNotice
    function getEvents()
    {
		 $data = $this->SelectMultiTable('calendar, event_type', 'calendar.calendar_id, calendar.course_id, calendar.title, calendar.description, calendar.date_start, calendar.date_end, calendar.all_day, calendar.aud_time, calendar.aud_user_id, event_type.event_type_description','event_type.event_type_id = calendar.event_type_id');

    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$count = count($data);
    		for ($i=0; $i < $count; $i++) {
                $ret_val[] = array ( 'calendar' => $data[$i]['calendar.calendar_id'],
                               		 'course' => $this->getCourseDescription($data[$i]['calendar.course_id']),
									 'event_type' => $data[$i]['event_type.event_type_description'],
									 'subject' => $data[$i]['calendar.title'] ,
									 'content' => $data[$i]['calendar.description'] ,
									 'dt_ini' => $data[$i]['calendar.date_start'] ,
									 'dt_fin' => $data[$i]['calendar.date_end']
								   );
            }
		}

    	return ($ret_val);
    }
    
    function getEvent($event_id)
    {
		 $ret_val = $this->Select('calendar', 'course_id, event_type_id, title, description, date_start, date_end, all_day, aud_time, aud_user_id', "calendar_id = $event_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return ($ret_val);
    }
	
	function deleteEvent($event_id)
    {
		 $ret_val = $this->Delete('calendar', "calendar_id = $event_id");

    	if ($this->hasError()) {
    		$ret_val = false;
    	} else {
			$ret_val = true;
		}

    	return ($ret_val);
    }
}    
