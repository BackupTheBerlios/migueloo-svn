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
 * Tratamiento de las sentencias SQL
 * Esta clase implementa las funcionalidades para la construcción, validación,
 * y ejecución de sentencias SQL.
 * Esta clase implementa las funcionalidades necesarias para acceder a la base de datos,
 * utilizando la librería ADOdb.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage model
 * @version 1.0.0
 *
 */

class base_ddbbData extends base_ddbbError
{
        /**
         * @access private
         * @var string
         */
        var $table         = null;
        /**
         * @access private
         * @var integer
         */
        var $ado_con = 0;
        /**
         * @access private
         * @var string
         */
        var $query         = '';
        /**
         * @access private
         * @var boolean
         */
        var $fields        = null;
        /**
         * @access private
         * @var boolean
         */
        var $bCond        = false;

        /**
         * Constructor.
         */
        function base_ddbdData()
        {
        $this->base_ddbbError();
        }

        /**
         * Obtiene la sentencia SQL procesada.
         * @return string Sentencia SQL.
         */
        function getSQLQuery()
        {
                return $this->query;
        }

        /**
         * Permite desactivar la validación de la clausula WHERE.
         */
        function changeValidateCond()
        {
                $this->bCond = !$this->bCond;
        }

        /**
         * Establece la conexión con la base de datos.
         *
         */
        function openConnection()
        {
                //Inicializamos la librería AdoDB
                include_once(MIGUELBASE_ADODB.'/adodb.inc.php');
                if(MIGUELBASE_CACHEABLE){
                      $ADODB_CACHE_DIR = Util::formatpath(MIGUELBASE_CACHE_DIR);
        }

        if($this->ado_con == 0) {
                        $this->ado_con = &ADONewConnection(Session::getContextValue('ddbbSgbd'));

                        $this->ado_con->PConnect(Session::getContextValue('ddbbServer'),
                                            Session::getContextValue('ddbbUser'),
                                            Session::getContextValue('ddbbPassword'),
                                            Session::getContextValue('ddbbMainDb')
                                                );

                        if($this->ado_con->ErrorMsg() != '' ) {
                            $this->_setError(Session::getContextValue('ddbbSgbd').' :: '.$this->ado_con->ErrorMsg());
                        }
                }

        }

        /**
         * Cierra la conexión con la base de datos
         *
         */
        function closeConnection()
        {
                if($this->ado_con != 0) {
                        $this->ado_con->Close();
                }
        }

        /**
         * Genera las sentencias tipo SELECT
         * @param string $table Nombre de la tabla.
         * @param string $type Tipo de select (1 para select distinct, 2 para select en varias tablas, y 0 para el resto)
         * @param string $fields Campos a modificar (cadena formada por los campos separados por comas)
         * @param string $sort_by Campos por los que ordenar los registros resultantes (cadena formada por los campos separados por comas)
          * @param string $cond Condición a cumplir
          * @param string $order_type Tipo de ordenación: true -> Descendente, false -> Ascencente
          * @return array Registros seleccionados.
         * @access private
         */
          function _select($table, $type, $fields, $sort_by, $cond, $order_type)
          {
                $this->_clearError();

                $this->_validateSelectData($table, $fields, $cond);
                if ($this->hasError()) {
                        return '';
                }

                switch ($type) {
                case 1:
                        $this->table = $table;
                    $sql_query = 'select distinct '.$this->_formatTargetFields($fields).' from ' . $table.$this->_formatWhereConds ($cond);
                    break;
                case 2:
                        $this->_getTableNames($table);
                    $sql_query = 'select '.$this->_formatTargetFields($fields).' from '.$this->_formatTables().$this->_formatWhereConds ($cond);
                    break;
                default:
                        $this->table = $table;
                        $sql_query = 'select '.$this->_formatTargetFields($fields).' from '.$table.$this->_formatWhereConds ($cond);
        }

        if(!empty($sort_by)){
            $sql_query .= ' order by '.$this->_formatOrderFields($sort_by);
            if($order_type){
                $sql_query .= ' desc';
            } else {
                $sql_query .= ' asc';
            }
        }

                $this->query = $sql_query;

                $data = $this->_exec($sql_query);

                for($i=0; $i < count($data);$i++) {
                        for($j=0; $j < count($this->fields);$j++) {
                                $ret[$i][$this->fields[$j]] = $data[$i][$j];
                        }
                }

                return ($ret);
          }

          /**
         * Genera las sentencias tipo SELECT COUNT
         * @param string $table Nombre de la tabla.
          * @param string $cond Condición a cumplir
          * @return integer Número de registros
         * @access private
         */
          function _selectCount($table, $cond)
          {
                $this->_clearError();
                $this->table = $table;

                $this->_validateSelectData($table, 'count(*)', $cond);
                if ($this->hasError()) {
                        return 0;
                }

                $sql_query = "select count(*) from $table".$this->_formatWhereConds ($cond);
                $this->query = $sql_query;

                $ret_val = $this->_exec($sql_query);
                //echo '<pre>'; print_r($ret_val); echo '</pre>';
                return ($ret_val[0][0]);
          }

          /**
         * Genera las sentencias tipo INSERT
         * @param string $table Nombre de la tabla.
         * @param string $fields Campos a modificar (cadena formada por los campos separados por comas)
          * @param string $values Valores para los campos
         * @return boolean Exito o no (Comprobar).
         * @access private
         */
          function _insert($table, $fields, $values)
          {
                $this->_clearError();
                  $this->table = $table;

                  $sql_query = 'insert into '.$table;

                  if ($fields != '') {
                          $sql_query .= " (".$this->_formatTargetFields ($fields).")";
                  }

                  if ($values != '') {
                          $sql_query .= " values (".$this->_formatValuesTarget ($values).")";
                  }
                  $this->query = $sql_query;

                  $ret = $this->_exec($sql_query);
        if (!$this->hasError()) {
                      $ret = $this->_getLastInserted();
        }

                  return $ret;
          }

        /**
         * Genera las sentencias tipo DELETE
         * @param string $table Nombre de la tabla.
          * @param string $cond Condición a cumplir
          * @return integer Número de registros eliminados (comprobar)
         * @access private
         */
        function _delete($table, $cond)
          {
                $this->_clearError();
                  if ($this->bCond) {
                        if(!is_string($cond) || strlen($cond) == 0 ) {
                                $this->_setError('miguel_Data:Delete: no conds selected');
                                return '';
                        }
                }

                $this->table = $table;

                  $sql_query = 'delete from '.$table;

                  if ($cond != '') {
                          $sql_query .= $this->_formatWhereConds ($cond);
                  }
                  $this->query = $sql_query;

                  return $this->_exec($sql_query);
          }

        /**
         * Genera las sentencias tipo UPDATE
         * @param string $table Nombre de la tabla.
         * @param string $fields Campos a modificar (cadena formada por los campos separados por comas)
         * @param string $values Valores para los campos
         * @param string $cond Condición a cumplir
         * @return integer Número de registros eliminados (comprobar)
         * @access private
         */
        function _update($table, $fields, $values, $cond)
          {
                $this->_clearError();

                if ($this->bCond) {
                        if (!is_string($cond) || strlen($cond) == 0 ) {
                                $this->_setError('miguel_Data:Delete: no conds selected');
                                return '';
                        }
                }

                $this->table = $table;

                  $sql_query = 'update '.$table.' set '.$this->_formatUpdateTarget ($fields, $values) ;

                if ($this->hasError()) {
                        return '';
                }

                  if ($cond != '') {
                          $sql_query .= $this->_formatWhereConds ($cond);
                  }
                  $this->query = $sql_query;
                  // Debug::oneVar($this, __FILE__, __LINE__);
                  return $this->_exec($sql_query);
          }

        /**
         * Valida la coherencia de los datos para una sentencia SELECT
         * @param string $table Nombre de la tabla.
         * @param string $fields Campos a modificar (cadena formada por los campos separados por comas)
         * @param string $cond Condición a cumplir
         * @return error Marca el error, si se produce.
         * @access private
         */
        function _validateSelectData ($table, $fields, $cond = '')
        {
                if (!is_string($fields)) {
                        $this->_setError('miguel_Data:Validate: wrong fields type');
                        return;
                }

                if ($fields == '' ) {
                        $this->_setError('miguel_Data:Validate: no fields selected');
                        return;
                }

                if (!is_string($table) || $table == '') {
                        $this->_setError('miguel_Data:Validate: no table selected');
                        return;
                }

                if ($this->bCond) {
                        if (!is_string($cond) || strlen($cond) == 0 ) {
                                $this->_setError('miguel_Data:Validate: no conds selected');
                                return;
                        }
                }
        }

        /**
         * Obtiene los nombres de las tablas en una multi select.
         * @access private
     */
        function _getTableNames($table)
        {
                $this->table = array();

                $fields= ereg_replace("[[:space:]]+",'',$table);
                $fields = explode(',', $fields);

                for ($i=0; $i < count($fields);$i++) {
                        $this->table[] = $fields[$i];
                }

                return;
        }

        /**
         * Formatea los nombres de las tablas
         * @access private
     */
        function _formatTables()
        {
                return implode(', ', $this->table);
        }

        /**
         * Formatea los nombres de los campos ('tabla.campo').
         * @access private
     */
        function _formatTargetFields ($fields)
        {
                if ($fields == '*') {
                        return $fields;
                } else {
                        $fields= ereg_replace("[[:space:]]+",'',$fields);
                        $fields = explode(',', $fields);

                        if(!is_array($this->table)){
                                for ($i=0; $i < count($fields);$i++) {
                                        $fields[$i] = $this->table.'.'.$fields[$i];
                                }
                        } else {
                                for ($i=0; $i < count($fields);$i++) {
                                        list($item_table, $item_field) = explode('.', $fields[$i], 2);
                                        if(is_null($item_field)){
                                                $item_field = $item_table;
                                        }
                                        if(!in_array($item_table, $this->table)) {
                                                $fields[$i] = $this->table[0].'.'.$item_field;
                                        }
                                }
                        }
                        $this->fields = $fields;

                        return implode(', ', $fields);
                }
        }

        /**
         * Valida la coherencia y genera la clausula WHERE
         * @access private
     */
        function _formatWhereConds ($cond)
        {
                if ($cond !='') {
                        $cond= ereg_replace("[[:space:]]+",' ',$cond);
                        $elem = explode(' ', $cond);
                        //Debug::oneVar($cond, __FILE__, __LINE__);
                        for($i=0;$i<count($elem);$i = $i+4) {
                                //20040712
                                //Si se reciben paréntesis
                                //if($elem[$i] == '(' or $elem[$i] == ')'){
                                $special_char = array('(', ')');

                                if (in_array($elem[$i], $special_char)){
                                        $i++;
                                }
                                //20040712
                                if(!is_array($this->table)){
                                        $elem[$i]         = $this->table.'.'.$elem[$i];
                                        $elem[$i+2]        = "'".$elem[$i+2]."'";
                                } else {
                                        list($item_table, $item_field) = explode('.', $elem[$i], 2);
                                        if(is_null($item_field)){
                                                $item_field = $item_table;
                                        }
                                        if(!in_array($item_table, $this->table)) {
                                                $elem[$i] = $this->table[0].'.'.$elem[$i];
                                        }

                                        list($item_table, $item_field) = explode('.', $elem[$i+2], 2);
                                        if(is_null($item_field)){
                                                $item_field = $item_table;
                                                $elem[$i+2]        = "'".$elem[$i+2]."'";
                                        } else {
                                                if(!in_array($item_table, $this->table)) {
                                                        $elem[$i+2] = $this->table[0].'.'.$elem[$i];
                                                }
                                        }
                                }
                                $elem[$i+1]        = $elem[$i+1];

                                if (isset($elem[$i+3])) {
                                        $elem[$i+3]        = $elem[$i+3];
                                }
                        }
                        $sel_cond = ' where '.implode(' ', $elem);
                } else {
                        $sel_cond = '';
                }

                return $sel_cond;
        }

        /**
         * Formatea los campos para la condición de ordenación.
         * @access private
     */
        function _formatOrderFields($fields)
        {
                if ($fields !='') {
                        //$fields= ereg_replace("[[:space:]]+",' ',$fields);
                        $elem = explode(' ', $fields);
                        //Debug::oneVar($cond, __FILE__, __LINE__);
                        for($i=0;$i<count($elem);$i++) {
                            $elem[$i] = trim($elem[$i]);
                                if(!is_array($this->table)){
                    $elem[$i]         = $this->table.'.'.$elem[$i];
                                } else {
                                    if(strchr($elem[$i],'.')){
                                           list($item_table, $item_field) = explode('.', $elem[$i], 2);
                                        } else {
                                           $item_table = '';
                       $item_field = $elem[$i];
                                        }
                                        if(!in_array($item_table, $this->table)) {
                                                $elem[$i] = $this->table[0].'.'.$item_field;
                                        }
                                }
                        }
                        $sel_cond = implode(' ', $elem);
                }

                return $sel_cond;
        }

        /**
         * Formatea los valores de los campos, colocando el valor entre comillas: 'valor'.
         * @access private
     */
        function _formatValuesTarget ($fields)
        {
                 if ($fields == '*') {
                        return $fields;
                } else {
                        if(!is_array($fields)){
                                //$fields= ereg_replace("[[:space:]]+",'',$fields);
                                $fields = explode(',', $fields);
                        }

                        for ($i=0; $i < count($fields);$i++) {
                                $fields[$i] = "'".trim($fields[$i])."'";
                        }

                        return implode(', ', $fields);
                }
        }

        /**
         * Formatea los pares nombre-valor para una sentencia UPDATE.
         * @access private
     */
        function _formatUpdateTarget ($fields, $values)
        {
                if ($fields == '') {
                        $this->_setError('miguel_Data:Update: no fields selected');
                        return '';
                } else {
                        $fields= ereg_replace("[[:space:]]+",'',$fields);
                        $fields = explode(',', $fields);

                        for ($i=0; $i < count($fields);$i++) {
                                $fields[$i] = $this->table.'.'.$fields[$i];
                        }
                }

                if (is_string($values) && $values == '') {
                        $this->_setError('miguel_Data:Update: no values selected');
                        return '';
                } else {
                        if(!is_array($values) ){
                                $values= ereg_replace("[[:space:]]+",'',$values);
                                $values = explode(',', $values);
                        }
                }

                if (count($fields) != count($values)) {
                        $this->_setError('miguel_Data:Update: inconsistence fields-values');
                        return '';
                }

                for ($i=0; $i < count($fields);$i++) {
                        //if(is_numeric($values[$i])){
                        //        $update_cond[$i] = $fields[$i].' = '.$values[$i];
                        //} else {
                                $update_cond[$i] = $fields[$i].' = '."'".$values[$i]."'";
                        //}
                }

                return implode(', ', $update_cond);

        }

        /**
         * Ejecuta contra la base de datos la sentencia SQL generada.
         * @access private
     */
        function _exec($sql_query)
        {
                $ret = '';

                if (!$this->hasError()) {
                        $this->ado_con->SetFetchMode(ADODB_FETCH_NUM);

                        //Check if app is cacheable
                        if(MIGUELBASE_CACHEABLE){
                                $this->ado_con->cacheSecs = MIGUELBASE_CACHE_TIME * 10;
                                $rs = $this->ado_con->CacheExecute($sql_query);
                        } else {
                                $rs = $this->ado_con->Execute($sql_query);
                        }

                        if ($this->ado_con->ErrorMsg() != '') {
                                $this->_setError($this->ado_con->ErrorMsg().'::'.$this->query);
                        } else {
                                while (!$rs->EOF) {
                                        $ret[] = $rs->fields;
                                        $rs->MoveNext();
                                }
                        }
                }
                return $ret;
          }

          /**
         * Ejecuta contra la base de datos la sentencia SQL generada.
         * @access private
     */
        function _getLastInserted()
        {
                return $this->ado_con->Insert_ID();
          }
}
?>
