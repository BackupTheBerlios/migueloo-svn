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
 * Tratamiento de información en formato XML
 * Esta clase implementa las funcionalidades para la construcción, validación,
 * y manejo de información en formato XML
 * Esta clase implementa las funcionalidades necesarias para manipular datos XML,
 * utilizando la librería PEAR XML o miniXML.
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */
include_once('XML-PEAR/Tree.php');

class base_XMLData extends XML_Tree
{
	/**
	 * Constructor.
	 */
	function base_XMLData()
	{		
        $this->XML_Tree();
	}
	
	/**
	 * Obtiene la sentencia SQL procesada.
	 * @param string $file Nombre (path) del fichero.
	 * 
	 */
	function setFileName($file)
	{
		if(!empty($file)){
		  $this->file = $file;
		}
	}
	
	/**
	 * Añade el elemento principal (root)
	 * @param string $name Nombre del elemento principal
     * @param string $content Contenido del nodo hijo.
     * @param array $attributes Atributos del nodo.
     * @return object Referencia al nodo principal
	 *
	 */
	function rootElement($name, $content = '', $attributes = array())
    {
        $this->namespace[$name] = array();
        return $this->addRoot($name, $content = '', $attributes = array());
    }
	
	/**
	 * Añade un nuevo nodo hijo a un nodo
	 * @param object $node Nodo padre.
	 * @param object $child Nodo hijo.
     * @param string $content Contenido del nodo hijo.
     * @param array $attributes Atributos del nodo.
     * @return object Referencia al nodo hijo
	 *
	 */
	function &addChild($node, $child, $content = '', $attributes = array())
    {
        //Buscamos $node en el namespace
        $this->namespace[$child] = $this->namespace[$node];
        $this->namespace[$child][] = $child;
        //$parent = $this->getName($this->namespace[$node]);
        //$node->addChild($child, $content, $attributes);
    }

}
?>
