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
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_CBibliography extends miguel_Controller
{
	function miguel_CBibliography() 
	{	
		$this->miguel_Controller();
		$this->setModuleName('bibliography');
		$this->setModelClass('miguel_MBibliography');
		$this->setViewClass('miguel_VBibliography');
		$this->setCacheFlag(false);
	}
	
	function processPetition() 	
	{
		//Consultar la variable status. Si no existe se establece a 'menú' 
		if ($this->issetViewVariable('status')) {
			$status = $this->getViewVariable('status');
		} else {
			$status = 'menu';
			$status = $this->setViewVariable('status', 'menu');
		}
		
		//Debug::oneVar($this->arr_form, __FILE__, __LINE__);

		switch($status)
		{
			case 'new': //Nueva ficha
				if ($this->issetViewVariable("submit") ){
					$this->processNewBook();
					
					//$this->setViewVariable('arrBook', $this->obj_data->getCatalogo());
					//$this->addNavElement(Util::format_URLPath('bibliography/index.php'),'Bibioteca');
				} else {
					$this->addNavElement(Util::format_URLPath('bibliography/index.php', 'status=new'),'Alta de ficha');
				}
				break;
			case 'com': //Nuevo comentario
				if ($this->issetViewVariable("submit") ){
					$this->processNewComent();
					
					$this->processDetail();
				}
				$arr_data = $this->obj_data->getBookInfo($this->getViewVariable('id'));
				$this->setViewVariable('bookTitle', $arr_data['ptabla01']);
				
				break;	
			case 'val': //Nueva valoracion
				if ($this->issetViewVariable("submit") ){
					$this->processNewValoration();
				} 
				
				$this->processDetail();
				break;		
			case 'link': //Referencias
				if ($this->issetViewVariable("submit") ){
					$this->processNewLink();
					
					//$this->setViewVariable('status', 'link');
				} 
				
				$this->processLinks();
				$this->addNavElement(Util::format_URLPath('bibliography/index.php'),'Enlaces');
				break;	
			case 'detail': //Ficha del libro
				$this->processDetail();
				break; 		
			case 'resum': //Resumen del libro
				$arr_data = $this->obj_data->getBookInfo($this->getViewVariable('id'));
				$this->setViewVariable('arrBook', $arr_data);
				$this->setViewClass('miguel_VResume');
				break; 			
			case 'ref': //Referencias bibliograficas
				$this->clearNavBarr();
				
				$this->setViewVariable('arrReference', $this->obj_data->getReference());
				$this->addNavElement(Util::format_URLPath('bibliography/index.php', 'status=ref'), 'Bibioteca > Referencias');
			default: //Catalogo
				$this->clearNavBarr();
				
				$this->setViewVariable('arrBook', $this->obj_data->getCatalogo());
				$this->addNavElement(Util::format_URLPath('bibliography/index.php'),'Bibioteca > Catálogo');	
		}

		//Establecer el título de la página
		$this->setPageTitle("miguel Bibliography Page");
		$this->setMessage('');
	
		//Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
		$this->setHelp('');

	}
	
	function processLinks()
	{
		//$this->setViewVariable('status', 'link');
		
		$this->setViewVariable('arrLink', $this->obj_data->getLinks());
				
		$this->addNavElement(Util::format_URLPath('bibliography/index.php', 'status=ref'),'Referencias'); 
	}
	
	function processDetail()
	{
		$this->setViewVariable('status', 'detail');
		
		$this->setViewVariable('arrComment', $this->obj_data->getComments($this->getViewVariable('id')));
		$arr_data = $this->obj_data->getBookInfo($this->getViewVariable('id'));
		$this->setViewVariable('arrBook', $arr_data);
		$this->setViewVariable('arrValor', array($arr_data['val_num'], $arr_data['valoracion']));
		
		$this->addNavElement(Util::format_URLPath('bibliography/index.php', 'status=detail&id='.$this->getViewVariable('id')),'Ficha'); 
	}
	
	function processNewBook()
	{
		$all_Ok = false;
		
		if ($this->checkVar('ptabla01', 'titulo de la obra') && 
			$this->checkVar('autor',  'autor de la obra') &&
			$this->checkVar('descripcion', 'descripción')) {
				if($_FILES['imagen']['tmp_name'] != null){
					list($name, $ext) = explode(".", $_FILES['imagen']['name']);
				} else {
					$filename = '';
				}		
				$book_id = $this->obj_data->newBook($this->getViewVariable('ptabla01'), 
													 $this->getViewVariable('autor'),
													 $this->getViewVariable('f_edicion'), 
													 $this->getViewVariable('editorial'),
													 $this->getViewVariable('lugar_pub'), 
													 $this->getViewVariable('descripcion'),
													 $this->getViewVariable('indice'), 
													 $this->getViewVariable('isbn'),
													 $ext
													);
	
				$all_Ok = true;
				
				if($_FILES['imagen']['tmp_name'] != null){
					$filename = 'bookref_'.$book_id.'.'.$ext;
					//Procesamos fichero imagen
					$file_orig = $_FILES['imagen']['tmp_name'];
					if(is_uploaded_file($file_orig)){
						$file_dest = Util::formatPath(MIGUEL_APPDIR.'var/bibliography/image/'.$filename);
						move_uploaded_file($file_orig, $file_dest);
					}	
				}
		}else {
			$message = 'Error: Rellene todos los campos obligatorios (*).';
		}
		
		return $all_Ok;
	}
	
	function processNewComent()
	{
		if ($this->IsSetVar('id') && $this->IsSetVar('comentario')){
			if ($this->IsSetVar('valoracion')){
				$valor = $this->getViewVariable('valoracion');
			} else {
				$valor = 0;
			}
			$ret_val = $this->obj_data->newComment($this->getViewVariable('id'), 
													Session::getValue('USERINFO_USER_ID'),
													$this->getViewVariable('comentario'), 
													$valor
													);
		}
		
		return;
	}
	
	function processNewValoration()
	{
		if ($this->IsSetVar('id') && $this->IsSetVar('valoracion')){
			
			$ret_val = $this->obj_data->newComment($this->getViewVariable('id'), 
													Session::getValue('USERINFO_USER_ID'),
													'', 
													$this->getViewVariable('valoracion')
													);
		}
		
		return;
	}
	
	function processNewLink()
	{
		if ($this->IsSetVar('ptabla01') && $this->IsSetVar('enlace')){
			
			$ret_val = $this->obj_data->newLink($this->getViewVariable('ptabla01'), 
													$this->getViewVariable('enlace')
													);
		}
		
		return;
	}
	
	function IsSetVar($var) 
	{
		return ($this->issetViewVariable($var) && $this->getViewVariable($var) != '');
	}
	
	function checkVar($nom_var, $textoError)
	{
		$bol_cck = $this->issetViewVariable($nom_var) && $this->getViewVariable($nom_var) != '';
		if (!$bol_cck){
			$this->setMessage("El campo $textoError es obligatorio. Debe rellenarlo");
		}
		
		return $bol_cck;
	}

}
?>
