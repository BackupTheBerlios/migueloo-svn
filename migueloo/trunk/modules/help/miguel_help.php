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
//ELIMINAR este if: Se cambia por un control en el proceso de carga de librerías.
if (!extension_loaded("gettext")) {
	function gettext($str)
	{
		return $str;
	}
}

$str_name = session_name();

if ($str_name != "MIGUEL_BASE") {
	session_name("MIGUEL_BASE");
}
session_start();

$str_gettextdir =  $_SESSION["CONTEXT"]["MIGUEL_URLSERVER"].'gettext/';

$str_lang =  $_SESSION["CONTEXT"]["MIGUEL_LANGUAGE"];
if($str_lang == '' || $str_lang == null){
   $str_lang =  $HTTP_SESSION_VARS["CONTEXT"]["MIGUEL_LANGUAGE"];
}
if (extension_loaded("gettext")) {
	putenv("LANG=".$str_lang);
	setlocale(LC_ALL, $str_lang);

	bindtextdomain("help", $str_gettextdir);
	textdomain("help");
}

// Help_user.php
switch ($_GET["help"]) {
   case 'EducContent':
       $str_title   = "Ayuda usuario";
       $str_file    = $_GET["help"];
       break;
   default:
       $str_title   = "Ayuda usuario";
       $str_file    = $_GET["help"];
}
/*
$langHGroup = "Ayuda Grupos de Trabajo";
$langHReg = "Ayuda inscripci&oacute;n";
$langHCreateCourse = "Ayuda crear cursos";
$langHAgenda = "Ayuda Agenda";
$langHAnuncios = "Ayuda Anuncios";
$langHDescription = "Ayuda Descripci&oacute;n del Curso";
$langHEjercicios = "Ayuda Ejercicios";
$langHEnlaces = "Ayuda Enlaces";
$langHWork = "Ayuda Trabajos";
$langHFor   = "Ayuda foros";
$langHDoc        = "Ayuda documentos";
*/
?>
<html>
<head>
<title><?php echo _("miguel help").' '.$str_title; ?> </title>
</head>
<body bgcolor="#E2EDCC"><font face="arial, helvetica" size="2">
<img src="../image/logo.png" border="0" alt="miguel Home">
<hr>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr valign="center">
<td align="left" valign="top"><font size="2" face="arial, helvetica"><h4><?php echo $str_title; ?></h4></td>
<td align="right" valign="top"><font size="2" face="arial, helvetica"><a href=javascript:window.close();><?php echo _("Cerrar"); ?></a></td>
</tr>
</table>
<?php
include ('lang/'.$str_lang.'/help_html/'.$_GET["help"].'.html');
?>
<hr>
<center><a href=javascript:window.close();><?php echo _("Cerrar"); ?></a></center>
</body>
</html>
