<?php
/*
      +----------------------------------------------------------------------+
      | alumnPage/index.php                                                  |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, SHS Polar Sistemas Inform�ticos, S.L.            |
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
      | Authors: SHS Polar Sistemas Inform�ticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/

//Carga el c�digo de Andromeda
include_once ("../common/miguel_base.inc.php");

//Carga el c�digo del controlador
include_once (Util::app_Path("alumnPage/control/classes/miguel_calumnpage.class.php"));


//Instancia un Controlador en memoria. Esto al mismo tiempo inicializa el modelo y la vista
$miguel = new miguel_CAlumnPage();


//Ejecuta el controlador
$miguel->Exec();

?>
