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

class miguel_CNotice extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CNotice() 
	{
		$this->miguel_Controller();
		$this->setModuleName('notice');
		$this->setModelClass('miguel_MNotice');
		$this->setViewClass('miguel_VNotice');
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
			$status = $this->setViewVariable('status', 'menu');
		}
		
		//Debug::oneVar($status, __FILE__, __LINE__);
	
		//Según el valor de status abrir una u otra vista
		switch($status)
		{
			case 'new': //Nuevo comentario
				$this->processPetitionNew();
				$this->addNavElement(Util::format_URLPath('notice/index.php', 'status=new'),'Nuevo comentario');
				break;
			case 'list': //Listar comentarios
				$NoticeArray = $this->obj_data->getNotices();
				$this->setViewVariable('notice_array', $NoticeArray);
				$this->addNavElement(Util::format_URLPath('notice/index.php', 'status=list'),'Ver Anuncios');
				break;
			case 'show':
				if($this->issetViewVariable('id')){
					$id = $this->getViewVariable('id');
					$NoticeArray = $this->obj_data->getNotice($id);
					$this->setViewVariable('author', $NoticeArray[0]['notice.author']);
					$this->setViewVariable('subject', $NoticeArray[0]['notice.subject']);
					$this->setViewVariable('time', $NoticeArray[0]['notice.time']);
					$this->setViewVariable('text', $NoticeArray[0]['notice.text']); 		
				}
				break;
			case 'menu': //Ver menú de opciones
				$this->addNavElement(Util::format_URLPath('notice/index.php'), 'Tablón de anuncios');	
		}
	
		//Establecer el título de la página
		$this->setPageTitle("miguel Notice Page");
		$this->setMessage("Tablón de anuncios de miguel");
	
		//Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
		$this->setHelp("");
	}

	/*=========================================================================
		Procesamiento de la petición de nuevo comentario
		=========================================================================*/
	function processPetitionNew()
	{
		$bol_cuestion = true;
		
		//Comprueba el contenido de la Variable nombre. Esta se le pasa como entrada al controlador y puede venir de un formulario o un link
		if( $this->issetViewVariable('asunto') && $this->getViewVariable('asunto') != ''){
			if( $this->issetViewVariable('comentario') && $this->getViewVariable('comentario') != ''){
				//Poner control
				$bol_cuestion = false;
			
				$now = date("Y-m-d H:i:s");
				$strAuthor = Session::getValue('USERINFO_USER_ALIAS');
				$strSubject = $this->getViewVariable('asunto');
				$strText = $this->getViewVariable('comentario');
						
				//Realizamos una llamada al Modelo $this->obj_data->Método(Parámetros);
				$this->obj_data->insertSugestion($strAuthor, $strSubject, $strText, $now);
			
			
				//Enviamos a la vista la información a Mostrar
				//$this->setViewVariable('notice_nombre', $this->arr_form['nombre']);
				//$this->setViewVariable('notice_comentario', $this->arr_form['comentario']);
			} 
		}
			
		//Si está relleno se muestra el contenido
		if (!$bol_cuestion){
			$this->setViewVariable('author', $strAuthor);
			$this->setViewVariable('subject', $strSubject);
			$this->setViewVariable('time', $now);
			$this->setViewVariable('text', $strText); 	
			$this->setViewVariable('status', 'show');
		}
	}
}
?>
