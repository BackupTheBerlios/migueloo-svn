<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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


class miguel_CCourseViewer extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CCourseViewer()
	{	
		$this->miguel_Controller();
		$this->setModuleName('courseViewer');
		$this->setModelClass('miguel_MCourseViewer');
		$this->setViewClass('miguel_VCourseViewer');
		$this->setCacheFlag(false);
	}
     
	function processPetition() 
	{
		$arr_cvw = $this->getSessionData();
		//Debug::oneVar($arr_cvw, __FILE__,__LINE__);

		//Obtención del id de curso
		//Parametro temporal para demo
		$course_id = $this->getViewVariable('id');
		if (!isset($course_id)) {
			if (!isset($arr_cvw['course_id'])) {
				$course_id = 8;
			} else {
				$course_id = $arr_cvw['course_id'];
			}
		} else {
			$arr_cvw = array();
		}
		
		//En un futuro deberia ser lo siguiente
		//$course_id = Session::getValue('course_id');
		if($course_id != $arr_cvw['course_id']){
			unset($arr_cvw);
			$arr_cvw['course_id'] = $course_id;
		}
		

		//Si el curso se inicializa correctamente...
		if ( isset($course_id) && $course_id != '' ) {       
			include_once( Util::app_Path('common/control/classes/miguel_courseinfo.class.php') );
			$infoCourse = miguel_CourseInfo::getInfo($this->obj_data, $course_id);
			//Debug::oneVar($infoCourse, __FILE__,__LINE__);
			//$this->setViewVariable('infoCourse', $infoCourse);
			//$arr_cvw['module_path'] = $this->obj_data->CourseModules($course_id);

			//Se obtiene el orden de documentos
			$arr_cvw['sec_docs'] = $this->obj_data->CourseModulesOrder($course_id);
	
			//Hay que ver si se nos redirecciona desde el exterior
			//Si existe la variable mid (id de módulo) reorientamos el índice
			$module_id = $this->getViewVariable('mid');
			if ( isset($module_id) && $module_id != '' ) {
				$this->moveIndex($module_id, $arr_cvw);
			} else { //Hay que navegar
				$option = $this->getViewVariable('opt');
				//$this->processNavigation($option, $arr_cvw);
				$index = $arr_cvw['index'];
				$document_id = $arr_cvw['sec_docs'][$index]['document'];
			
		
				//Procesar datos de formulario
				if($arr_cvw['accion']){
					//Procesamos el formulario, si existe
					$this->processForm($document_id, $arr_cvw);

					//Sólo si no hay que mostrar un resultado se sigue
					if (!isset($arr_cvw['result'])){
						//Procesamos la navegacion
						$this->processNavigation($option, $arr_cvw);
					}
				} else {
					$this->processNavigation($option, $arr_cvw);
				}
			}
		
			$index = $arr_cvw['index'];
			$document_id = $arr_cvw['sec_docs'][$index]['document'];
			$module_id = $arr_cvw['sec_docs'][$index]['module'];
			$arr_path = $this->getFolderNavInfo($document_id);
			
			//Debug::oneVar($arrPath, __FILE__,__LINE__);
			if($arr_path['fl_type']){
				$this->setViewVariable('view_elem', $this->processNextForm($arr_cvw));
				$this->setViewClass('miguel_VCourseActioner');
				$arr_cvw['accion'] = true;
			} else {
				$this->setViewClass('miguel_VCourseViewer');
				$arr_cvw['accion'] = false;
			}	


			$this->setViewVariable('ban_mid', $this->obj_data->getCourseModulesPosition($arr_cvw['course_id'],$module_id));

			
			$this->setViewVariable('esInicio', $index==0);
			$this->setViewVariable('hayPrevio', $index!=0);
			$this->setViewVariable('haySiguiente', $index < (count($arr_cvw['sec_docs'])-1));
			$this->setViewVariable('actual', Util::formatPath(MIGUEL_APPDIR.'var/courses/course_'.$course_id.'/pages/'.$arr_path['fl_actual'])); //Util::formatPath(MIGUEL_APPDIR.'var/courses/'.$file);
			$this->setViewVariable('path', 'var/courses/course_'.$course_id.'/pages/');
			//Guardamos variables de navegacion
			$this->setSessionElement('cvw', $arr_cvw);
			
			$this->addNavElement(Util::format_URLPath("courseViewer/index.php",  'url='.$this->getViewVariable('url').'&name='.$this->getViewVariable('name')), 
									$infoCourse['description']);
			
			$this->setPageTitle("miguel Course Viewer Page ");
			$this->setMessage('');
			//$this->setCacheFile("miguel_vParser");
			$this->setCacheFlag(true);
			$this->setHelp("");
		}
	}

	function moveIndex($_module_id, &$_arr_cvw)
	{
		//Indexamos al primer documento del módulo pasado
		for ($i=0; $i<count($_arr_cvw['sec_docs']); $i++)	{
			if ($_module_id == $_arr_cvw['sec_docs'][$i]['module']){
				$_arr_cvw['index'] = $i;
				break;
			}
		}
	}
	
	function getSessionData()
	{
		$data = $this->getSessionElement('cvw');
		
		foreach($data as $item => $value){
			$ret_val[$item] = $value;
		}
		
		return $ret_val;
	}

	function isValidModule($module_id, $arr_invalid)
	{
			return (!isset($arr_invalid[$module_id]) || $arr_invalid[$module_id]==false);
	}

	function processNavigation($_option, &$arr_cvw)
	{
		//Debug::oneVar("opcion: $_option", __FILE__, __LINE__);
		//Debug::oneVar($arr_cvw, __FILE__, __LINE__);
		switch ($_option) {
			case 'init':
				/*
				$index = $arr_cvw['index'];
				if ($index != 0) {				
					$module_id = $arr_cvw['sec_docs'][$index]['module'];

					//Retroceder hasta encontrar un módulo diferente al actúal
					while ( $index>0 && $module_id == $arr_cvw['sec_docs'][$index-1]['module']) {
							$index--;
					}
					$arr_cvw['index'] = $index;			
				}*/
				$arr_cvw['index'] = 0;
				
				break;
			case 'prev':
				//Buscamos hacia atrás el primer documento válido
				$index = $arr_cvw['index'];

				//Caso especial de retroceso
				$document_id = $arr_cvw['sec_docs'][$index]['document'];
				switch($document_id)
				{
						case 26: $index--;
										break;
				}

				do
				{
						$index--;			
				}
				while ($index>=0 && !$this->isValidModule($arr_cvw['sec_docs'][$index]['module'], $arr_cvw['invalid_mod']) );
				
				if ($index>=0)
				{
					$arr_cvw['index'] = $index;
				}
				break;
			case 'next':
			default:
				//Buscamos hacia adelante el primer documento válido
				$index = $arr_cvw['index'];
				$limiteSup = count($arr_cvw['sec_docs']);
				do
				{
						$index++;			
				}
				while ($index<$limiteSup && !$this->isValidModule($arr_cvw['sec_docs'][$index]['module'], $arr_cvw['invalid_mod']));
				
				if ($index<$limiteSup)
				{
					$arr_cvw['index'] = $index;
				}
				break;
		}
	}
		
	function getFolderNavInfo($_folder_id)
	{
		$arr_path = $this->obj_data->getFolderInfo($_folder_id);
		return $arr_path;
	}
	
	function processForm($_document_id, &$arr_cvw)
	{	
		$arr_action = null;
		//Obtenemos los pares campo-valor asociados al documento
		$arr_camp = $this->obj_data->getActionValues($_document_id);

		//Comprobamos si se recibe uno/alguno
		foreach($arr_camp as $key => $val){
		//	Debug::oneVar($key, __FILE__, __LINE__);
		//	Debug::oneVar($val, __FILE__, __LINE__);
			if ($this->issetViewVariable($key)) {
				//Si no hay valor asociado o el valor coincide con el asociado...
				if($val=='' || $val == $this->getViewVariable($key)) {
						//Obtenemos las acciones asociadas
						$arr_func = $this->obj_data->getAction($_document_id, $key);
					
						//Construimos las acciones como funciones php variables
						for($i=0; $i<count($arr_func); $i++){
							$function = $arr_func[$i]['accion'];
							$arr_action[] = $this->$function($arr_func[$i]['param'], $arr_cvw);
						}
					}
			}
		}
		
		//$arr_action = $this->obj_data->getAction($_document_id);
		//$arr_camp = $this->obj_data->getActionValues($_document_id);
		//Debug::oneVar($arr_cvw['nav_force'], __FILE__, __LINE__);
		//Debug::oneVar($arr_action, __FILE__, __LINE__);
		//Debug::oneVar($arr_cvw, __FILE__, __LINE__);
		
		return;
	}
	
	function processNextForm(&$arr_cvw)
	{
		$index = $arr_cvw['index'];
		$document_id = $arr_cvw['sec_docs'][$index]['document'];
		$arr_Elem = $this->obj_data->getViewDetails($document_id);
//		Debug::oneVar($document_id,  __FILE__,__LINE__);
//		Debug::oneVar($arr_Elem, __FILE__,__LINE__);
	
		switch( $document_id)
		{
			case 23:
					$sinBotones = true;

					//Se copian los valores
					for($i=0; $i < count($arr_Elem); $i++){
						switch($arr_Elem[$i]['name'])	 {
							case 'checkbox1':	
									$isInvalid = $arr_cvw['invalid_mod'][9];
									break;
							case 'checkbox2':	
									$isInvalid = $arr_cvw['invalid_mod'][10];
									break;
							case 'checkbox3':	
									$isInvalid = $arr_cvw['invalid_mod'][11];
									break;
							case 'checkbox4':	
									$isInvalid = $arr_cvw['invalid_mod'][12];
									break;
							case 'checkbox5':	
									$isInvalid = $arr_cvw['invalid_mod'][13];
									break;
						}
						$arr_Elem[$i]['default'] = !($isInvalid);
					}

					//Se vuelven a inicializar para esperar la respuesta del alumno
					$arr_cvw['invalid_mod'][9] = true;
					$arr_cvw['invalid_mod'][10] = true;
					$arr_cvw['invalid_mod'][11] = true;
					$arr_cvw['invalid_mod'][12] = true;
					$arr_cvw['invalid_mod'][13] = true;

					$ret_val = $arr_Elem;
//					Debug::oneVar($arr_cvw['invalid_mod'], __FILE__, __LINE__);
					break;
			case 25:
					$sinBotones = true;

					//Se copian los valores
					for($i=0; $i < count($arr_Elem); $i++){
						switch($arr_Elem[$i]['name'])	 {
							case 'label1':	
									$isInvalid = $arr_cvw['invalid_mod'][9];
									break;
							case 'label2':	
									$isInvalid = $arr_cvw['invalid_mod'][10];
									break;
							case 'label3':	
									$isInvalid = $arr_cvw['invalid_mod'][11];
									break;
							case 'label4':	
									$isInvalid = $arr_cvw['invalid_mod'][12];
									break;
							case 'label5':	
									$isInvalid = $arr_cvw['invalid_mod'][13];
									break;
							default:
									$isInvalid = false;
									break;
						}
						if (!$isInvalid) {
							$ret_val[] = $arr_Elem[$i];
						}
					}
					break;
			case 27:
					$sinBotones = true;
					$ret_val = $arr_Elem;
					break;
			case 16:
					//Debug::oneVar($this->arr_form, __FILE__, __LINE__);
					$sinBotones = true;
					$arr_cvw['invalid_mod'][9] = true;
					$arr_cvw['invalid_mod'][10] = true;
					$arr_cvw['invalid_mod'][11] = true;
					$arr_cvw['invalid_mod'][12] = true;
					$arr_cvw['invalid_mod'][13] = true;
					$ret_val = $arr_Elem;
					//Debug::oneVar($arr_Elem, __FILE__, __LINE__);
					break;
			case 24:
					$sinBotones = true;
					for($i=0; $i < count($arr_Elem); $i++){
						if($this->issetViewVariable($arr_Elem[$i]['name'])){
							$ret_val[] = $arr_Elem[$i];
						}
					}
					break;
			case 30:
			case 31:
			case 32:
					$sinBotones = true;
					for($i=0; $i < count($arr_Elem); $i++){
						if($arr_Elem[$i]['variable'] != 'helptext' || $arr_Elem[$i]['name'] == $arr_cvw['result']){
							$ret_val[] = $arr_Elem[$i];
						}
					}
					break;
			default:
					$sinBotones = false;
					$ret_val = $arr_Elem;
					break;
		}
		$this->setViewVariable('sinBotones', $sinBotones);
		return $ret_val;
	}
	
	function multiPathSelection($module_id, &$arr_cvw)
	{
		$arr_cvw['invalid_mod'][$module_id] = false;
//		Debug::oneVar($arr_cvw['invalid_mod'], __FILE__, __LINE__);
		return true;
	}

	function sendInfo2Profesor($none, &$arr_cvw)
	{
		$pregunta1 =  $this->getViewVariable('pregunta1');
		$pregunta2 =  $this->getViewVariable('pregunta2');
		$pregunta3 = $this->getViewVariable('pregunta3');

		//Se envía al Profesor con id 8
		$strSubject = 'Info';
		$strBody = 'Pregunta 1: ' . $pregunta1 . '; Pregunta 2: ' . $pregunta2 . '; Pregunta 3: ' . $pregunta3;
		$this->obj_data->sendMessage(array(8), 'Info', $strBody);
	}

	//Vuelve para revisar los puntos anteriores
    function returnInterview($none, &$arr_cvw)
	{
			$index = 6;
			$limiteSup = count($arr_cvw['sec_docs']);
			do
			{
					$index++;			
			}
			while ($index<$limiteSup && !$this->isValidModule($arr_cvw['sec_docs'][$index]['module'], $arr_cvw['invalid_mod']));
				
			if ($index<$limiteSup)
			{
				$arr_cvw['index'] = $index;
			}
	}

	//Pasamos las páginas indicadas
    function goNext($pages, &$arr_cvw)
	{
		//Se resta uno porque hay que contar la página que pasa automáticamente
		$arr_cvw['index'] = $arr_cvw['index'] + $pages - 1;
	}

    function checkAnswer($answer, &$arr_cvw)
	{
		$answer = $this->arr_form['radiobutton'];

//		Debug::oneVar($this->arr_form, __FILE__, __LINE__);
		//Debug::oneVar("Answer: $answer", __FILE__, __LINE__);
		//Analizamos cual es la respuesta correcta según página
		$index = $arr_cvw['index'];
		$document_id = $arr_cvw['sec_docs'][$index]['document'];
		switch($document_id)
		{
			case 30: 
			case 32: 
				$correct='helptext3';
				break;
			case 31: 
				$correct='helptext2';
				break;
		}

		if ($arr_cvw['result'] == $correct ) { 		//Ya se ha respondido correctamente
			unset($arr_cvw['result']);
			$this->setViewVariable('radiobutton', 1);
		} else {
			switch ($answer){
				case 0: 
						$arr_cvw['result']='helptext1';
						break;
				case 1: 
						$arr_cvw['result']='helptext2';
						break;
				case 2: 
						$arr_cvw['result']='helptext3';
						break;
				default:
						$arr_cvw['result']='';
						break;
			}
		}
	}
}
?>