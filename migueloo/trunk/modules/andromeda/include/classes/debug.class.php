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

/*
     Modo de uso
     
     Debug::msg("Hola", __FILE__, __LINE__);
*/
include_once(Util::base_Path('include/classes/lensdebug.class.php'));

class Debug
{
	function msg($a, $file, $line)
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->msg($a, $file, $line);
		}	
	}

	function oneVar($a, $file, $line)
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->v($a, $file, $line);
		}
	}

	function allVars($file, $line)
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->v($GLOBALS, $file, $line);
		}
	}
	
	function sessionVars($file, $line)
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->v($_SESSION, $file, $line);
		}
	}

	function allClasses($file, $line)
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->v(get_declared_classes(), $file, $line);
		}
	}

	/* No funciona, apache abenda
	function allConstants()
	{
		if(MIGUELBASE_DEBUG){
			$D = new LensDebug();
	        $D->v(get_defined_constants(), $file, $line);
		}
	}
	*/
}
?>
