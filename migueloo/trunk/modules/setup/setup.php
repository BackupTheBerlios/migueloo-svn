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
error_reporting(0);

if (!extension_loaded('gettext')) {
    echo "\nYou need the gettext PHP extension to run setup.\n\n";
    exit(0);
}

/** 
 * Encapsula el uso de gettext. Si no existe la traducción, presenta un valor por defecto
 * @param string $char Cadena a traducir
 */
function agt($char)
{
   	if(gettext($char) == $char) {
   		return gettext("Sin traducir:: ").$char;
   	} else {
   		return gettext($char);
   	}
}

function printHelp()
{
	$help  = '';
	$help .= "\n\n";
	$help .= "Sistema de configuración de miguel";
	$help .= "\n\n";
	$help .= "   Uso:\n";
	$help .= "   setup <idioma>\n\n";
	$help .= "   <idioma> para Español 'es', para English 'en'.\n";
	$help .= "   Con las opciones --help, -help, -h, o -? \n";
	$help .= "   se obtiene esta ayuda.\n\n\n";
	echo $help;
	exit(0);
}

function printStep($step, $message)
{
	echo "\n";
	echo "\n--------------------------------------------------------------------------------";
	echo "$step";
	echo "\n";
	echo "$message";
	echo "\n--------------------------------------------------------------------------------";
	echo "\n";
}
/*echo getcwd();
echo "Número: $argc\n";
echo "Params: $argv\n";*/
if ($argc != 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
	printHelp();
} 

//Directorio principal
$path = getcwd();

echo getcwd();

//Instanciamos clase base
require_once ('setup_cli.class.php');

$setup = &Setup::init();

//Configuración del idioma
$setup->setLanguage($argv[1], $path);

//Presentaciones inicio
echo "\n\n";
echo $setup->log(agt('setupIntro'), 'label');
echo "\n\n";
echo $setup->log(agt('setupDet'), 'label');
echo "\n\n";
$setup->intro();

// Controlamos la existencia de los elementos necesarios para el setup
// Comprobamos las extesiones necesarias, tanto para el setup como para miguel
printStep(agt('step1'), agt('step1Des'));

$exts = array('standard', 'gettext', 'session', 'zlib', 'pcre');
for($i=0; $i < count($exts); $i++) {
	if (!$setup->check($exts[$i])) {
	    $setup->log(agt('step1Err1')." $exts[$i] ".agt('step1Err2'), 'error');
	} else {
	    $setup->log(" $exts[$i]: ".agt('step1Ok'), 'message');
	}
}
$setup->intro();
// Obtenemos el path a miguel
printStep(agt('step2'), agt('step2Des'));

$ret = $setup->getServerRoot($path);
if(!$ret){
	$setup->fatalError('setupRoot');
}
$setup->intro();

// Obtenemos el path a adodb y phphtmllib
printStep(agt('step3'), agt('step3Des'));

$ret= $setup->getExternalLibs();
if(!$ret){
	$setup->fatalError('setupLibs');
}
$setup->intro();
/*
// Sistema de ficheros original
printStep(agt('step3b'), agt('step3bDes'));

$setup->fsChoice();
$setup->intro();

// Configuracion del sistema de cache
printStep(agt('step4'), agt('step4Des'));

$setup->setupCache();
$setup->intro();

// Configuracion del sistema de Log
printStep(agt('step5'), agt('step5Des'));

$setup->setupLog();
$setup->intro();

// Configuracion del sistema de sesion
printStep(agt('step6'), agt('step6Des'));

$setup->setupSession();
$setup->intro();

// Generación de ficheros de configuracion base
printStep(agt('step7'), agt('step7Des'));

// Comprobamos los ficheros
if (!$setup->check('registry')) {
    $setup->log(agt('step7Err'), 'error');

} else {
	$setup->makeRegistry();
    $setup->log(agt('step7Ok'), 'message');
}
*/
// Configuracion de la base de datos
printStep(agt('step8'), agt('step8Des'));

$ret = $setup->setupDDBB();
if(!$ret){
	$setup->fatalError('step8Err');
} else {
	$setup->log(agt('step8Ok'), 'success');
}
$setup->intro();

$setup->log(agt('finalMsg'), 'success');

exit(0);
?>
