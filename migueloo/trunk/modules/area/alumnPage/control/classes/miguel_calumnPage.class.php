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
 

//El controlador hereda de miguel_Controller la superclase controlador de miguelOO
class miguel_CAlumnPage extends miguel_Controller
{
	/**
	 * This is the constructor.
	 *
	 */
	function miguel_CAlumnPage() 
	{	

    //Ejecuta el constructor de la clase padre
		$this->miguel_Controller();

    //Inicializamos algunas propiedades del m�dulo
    //Nombre del m�dulo, ha de coincidir con registry.xml
		$this->setModuleName('alumnPage');

    //Nombre de la clase del Modelo
		$this->setModelClass('miguel_MAlumnPage');

    //Nombre de la clase Vista por defecto, como la p�gina no se renderiza hasta el final de la ejecuci�n esta puede cambiar en cualquier momento
		$this->setViewClass('miguel_VAlumnPage');

     //Indicamos si deseamos Cachear la p�gina
		$this->setCacheFlag(false);
	}
    
  /*=========================================================================
		Devuelve si la variable est� inicializada y no es vac�a
		=========================================================================*/
	function IsSetVar($var) 
	{
		return ($this->issetViewVariable($var) && $this->getViewVariable($var) != '');
	}

	/*=========================================================================
		Esta funci�n ejecuta el Controlador 
		=========================================================================*/
	function processPetition() 	
	{
	
    //En la barra de navegaci�n superior, la que se usa para no perdernos. A�ade un enlace a esta barra de enlaces.

	/*	if ($this->registry->hasInterface('email::getUserMessages'))
		{
			$miresult = $this->registry->callInterface('email::getUserMessages');
			Debug::oneVar($miresult);
		}
		*/
		 
		//Consultar la variable status. Si no existe se establece a 'men�' 
	  if ($this->issetViewVariable('status'))
	  {
	  	$status = $this->getViewVariable('status');
	  }
	  else
	  {
	  	$status = 'main';
	  	$status = $this->setViewVariable('status', 'main');
	  }
	  $this->addNavElement(Util::format_URLPath('alumnPage/index.php'), 'P�gina del Alumno');	
		  
    
    switch($status)
	  {
	  	case 'main': 
	  	default:
	  		//Presentaci�n de mensajer�a
	  		$arrMessages = $this->obj_data->getNewUserMessages();
	  		$this->setViewVariable('arrMessages', $arrMessages);
	  		
	  		//Presentaci�n de tabl�n de anuncios
  			$NoticeArray = $this->obj_data->getNotices();
      	$this->setViewVariable('notice_array', $NoticeArray);	  		
				break;
		}

 
  	//Establecer el t�tulo de la p�gina
		$this->setPageTitle("miguel Alumn Page");
	  $this->setMessage("P�gina del Alumno de miguel");

    //Establecer cual va a ser el archivo de la ayuda on-line, este se obtiene del directorio help/
	  $this->setHelp("");

	}
	
}
?>
