<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
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
 * Proceso de instalación de miguel
 * @package install
 * @subpackage setup
 */

/**
 * Define la clase setup de miguel.
 * Mediante este script se puede preparar la instalación de miquel
 *
 * Basada en la clase Setup.php del proyecto Horde.
 * Copyright 2003-2004 Marko Djukic <marko@oblo.com>
 *       http://www.horde.org/horde/
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @copyright GPL - Ver LICENCE
 * @package install
 * @subpackage setup
 * @version 1.0.0
 *
 */ 

class Setup 
{
    /**
     * Constructor
     */
    function Setup()
    {
    }
    
    function &factory($interface)
    {
        $class = 'Setup_' . $interface;
        if (class_exists($class)) {
            return $ret = &new $class();
        } else {
            exit(agt('noClassAvail').sprintf(" %s.", $interface));
        }
    }

    function &init()
    {
        static $instance;

        if (!isset($instance)) {
            require_once ('base_CLI.class.php');
            if (base_CLI::runningFromCLI()) {
                $interface = 'cli';
            } else {
                $interface = 'web';
            }
            $instance = &Setup::factory($interface);
        }
        
        return $instance;
    }
}

?>