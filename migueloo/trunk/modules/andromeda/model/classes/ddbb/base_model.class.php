<?php
/*
      +----------------------------------------------------------------------+
      | andromeda:  miguel Framework, written in PHP                         |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003,2004 miguel Development Team                      |
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
 * Todo el patrón MVC se define es este paquete llamado framework
 * @package framework
 * @subpackage model
 */
/**
 *
 */ 
include_once(MIGUELBASE_DIR.'model/classes/ddbb/base_ddbberror.class.php');

/**
 * Define la clase modelo base de miguel.
 * Se definen los elementos básicos del acceso al modelo de datos para miguelOO.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage model
 * @version 1.0.0
 *
 */ 

class base_Model extends base_ddbbError
{
	/**
	 *
	 */
	var $obj_data = null;
	/**
	 *
	 */
	var $bol_dataMeth = false;
	/**
	 *
	 */
	var $bol_hasDDBB = false;
	
	/**
	 * This is the constructor.
	 *
	 */
    function base_model($connect = true)
    {	
		$this->base_ddbbError();
		$this->bol_hasDDBB = $connect;
	}
	
	/**
	 * Prepara el acceso del modelo a los diferentes tipos de datos
	 */
    function openModel()
    {
        if($this->bol_hasDDBB){
            $this->useDDBB();
        }
    }
    
    /**
	 * Prepara el acceso del modelo a los diferentes tipos de datos
	 */
    function closeModel()
    {
        if($this->bol_hasDDBB){
            $this->closeDDBB();
        }
    }
    
	/**
	 * Prepara al modelo para acceder a la base de datos
	 */
	function useDDBB()
	{
		//Include database access class
		require_once Util::base_Path('model/classes/ddbb/base_ddbbdata.class.php');
		//Instanciamos la clase responsable
		$this->obj_data = new base_ddbbData();
		$this->obj_data->openConnection();
		//Debug::oneVar($this->obj_data, __FILE__, __LINE__);
		//Activamos los métodos asociados
		$this->bol_dataMeth = true;
	}
	
	/**
	 * Cierra el acceso a base de datos
	 */
	function closeDDBB()
	{
		$this->obj_data->closeConnection();
		//Desactivamos los métodos asociados
		$this->bol_dataMeth = false;
	}
	
	/**
	 * Obtiene la sentencia SQL procesada.
	 * @return string Sentencia SQL.
	 */
	function getSQLQuery()
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->getSQLQuery();
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Obtiene los registros de una tabla que cumplen la condición dada.
	 * @param string $str_table Nombre de la tabla en la que se consulta
 	 * @param string $str_fields Campos a buscar (cadena formada por los campos separados por comas)
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Registros obtenidos.
	 */
	function Select($str_table, $str_fields, $str_cond = '' )
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, 0, $str_fields, '', $str_cond, false);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Obtiene los registros de varias tablas que cumplen la condición dada.
	 * @param string $str_table Nombre de las tablas en la que se consulta (cadena formada por los campos separados por comas)
	 * @param string $str_fields Campos a buscar (cadena formada por los campos separados por comas)
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Registros obtenidos.
	 */
	function SelectMultiTable($str_table, $str_fields, $str_cond = '' )
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, 2, $str_fields, '', $str_cond, false);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Obtiene todos los campos de los registros de una tabla que cumplen la condición dada.
	 * @param string $str_table Nombre de la tabla en la que se consulta
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Registros obtenidos.
	 */
	function SelectAll($str_table, $str_cond = '' )
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, 0, '*', '', $str_cond, false);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Obtiene todos los registros diferentes de una tabla y que cumplen la condición dada.
	 * @param string $str_table Nombre de la tabla.
	 * @param string $str_fields Campos a buscar (cadena formada por los campos separados por comas)
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Registros obtenidos.
	 */
	function SelectDistinct($str_table, $str_fields, $str_cond = '' )
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, 1, $str_fields, '', $str_cond, false);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Obtiene todos los registros (diferentes o no) de una tabla que cumplen 
	 *la condición dada. Los ordena en función de los campos y tipo especificado
	 * @param string $str_table Nombre de la tabla.
	 * @param string $str_fields Campos a buscar (cadena formada por los campos separados por comas)
	 * @param string $str_sort_by Campos por los que ordenar(cadena formada por los campos separados por comas)
 	 * @param string $str_cond Condición a cumplir
 	 * @param boolean $bol_reverse Tipo de ordenación: false -> ascendente; true -> descendente
 	 * @param boolean $bol_distinct Select type: false -> normal; true -> distinct
 	 * @return array Registros obtenidos.
	 */
	function SelectOrder($str_table, $str_fields, $str_sort_by, $str_cond = '', $bol_reverse = false, $bol_distinct = false)
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, $bol_distinct, $str_fields, 
				$str_sort_by, $str_cond, $bol_reverse);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Selects the table entries that fulfil the given condition.
	 * Orders them by specified fields and order type (reverse or normal)
	 * @param string $str_table Tables names where we select fields from (it's a string
	 * with tables names separated with commas)
	 * @param string $str_fields Fields to select (also separated with commas but every fields
	 * preceed by "<table name>.")
	 * @param string $str_sort_by Fileds to order by and separated with commas
 	 * @param string $str_cond Condition to fullfil
 	 * @param boolean $bol_reverse Order type: false -> asc; true -> desc
 	 * @return array Selected entries.
	 */
	function SelectMultiTableOrder($str_table, $str_fields, $str_sort_by, $str_cond = '', 
		$bol_reverse = false)
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_select($str_table, 2, $str_fields, $str_sort_by, $str_cond, $bol_reverse);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}
	
	/**
	 * Cuenta los registros de una tabla que cumplen la condición dada.
	 * @param string $str_table Nombre de la tabla en la que se consulta
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Total registros
	 */
	function SelectCount($str_table, $str_cond = '' )
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_selectCount($str_table, $str_cond);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}
	}

	/**
	 * Inserta un registro en la tabla.
	 * @param string $table Nombre de la tabla.
	 * @param string $fields Campos a insertar (cadena formada por los campos separados por comas)
 	 * @param mixed $values Valores a insertar (puede recibirse los valores separados por comas, o en un 
	 *                      array ordenado como los $fields. Se aconseja usar la opción del array)
 	 * @return array Éxito de la inserción.
	 */
	function Insert($table, $fields, $values)
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_insert($table, $fields, $values);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}	
	}
	
	/**
	 * Borra los registros de una tabla que cumplen una condición.
	 * @param string $str_table Nombre de la tabla.
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Éxito del borrado.
	 */
	function Delete($str_table, $str_cond)
	{
		if($this->bol_dataMeth) {
			return $this->obj_data->_delete($str_table, $str_cond);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}	
	}
	
	/**
	 * Actualiza los registros en la tabla que cumplen la condición..
	 * @param string $str_table Nombre de la tabla.
	 * @param string $str_fields Campos a modificar (cadena formada por los campos separados por comas)
 	 * @param string $str_values Valores a modificar (puede recibirse los valores separados por comas, o en un 
	 *                      array ordenado como los $fields. Se aconseja usar la opción del array)
 	 * @param string $str_cond Condición a cumplir
 	 * @return array Éxito de la modificación.
	 */
	function Update($str_table, $str_fields, $str_values, $str_cond='')
	{
		//Debug::oneVar($str_table,__FILE__, __LINE__);
		//Debug::oneVar($str_fields,__FILE__, __LINE__);
		//Debug::oneVar($str_values,__FILE__, __LINE__);
		//Debug::oneVar($str_cond,__FILE__, __LINE__);
		if($this->bol_dataMeth) {
			return $this->obj_data->_update($str_table, $str_fields, $str_values, $str_cond);
		} else {
			$this->_setError('Model ::  DDBB service not active');
		}	
	}
	
	/**
	 * Intenta ejecutar cualquier sentencia SQL que se pasa como parámetro
	 *
	 * Sólo en la versión de desarrollo. Se eliminará en producción.
	 *
	 * @param string $str_sql Sentencia SQL
 	 * @return mixto Retorno de la ejecución
	 */
	function freeExec($str_sql)
	{
		return $this->obj_data->_exec($str_sql);
	}
	
	/**
	 * Escribe un mensaje en el log
	 * @param string $message Mensaje a guardar en el Log
     * @param string $priority Nivel de log
	 */
    function log($message, $priority)
    {	
    	include_once(Util::base_Path('include/classes/loghandler.class.php'));
  		LogHandler::log($message, $this->str_moduleName.'_controller', $priority);
    }
}
?>
