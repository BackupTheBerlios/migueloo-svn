<?php
/*
      +----------------------------------------------------------------------+
      | miguel error file                                                    |
      +----------------------------------------------------------------------+
      | This software is part of miguel    version 0.1.0 $Revision: 1.4 $    |
      +----------------------------------------------------------------------+
      |    $Id: base_verror.orig.php,v 1.4 2004/08/21 19:05:00 luisllorente Exp $    |
      +----------------------------------------------------------------------+
      |    This program is free software; you can redistribute it and/or     |
      |    modify it under the terms of the GNU General Public License       |
      |    as published by the Free Software Foundation; either version 2    |
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
      |   02111-1307, USA. The GPL license is also available through the     |
      |   world-wide-web at http://www.gnu.org/copyleft/gpl.html             |
      +----------------------------------------------------------------------+
      |   GOAL: To be an error page where safely and elegantly errors are    |
      |   displayed                                                          |
      +----------------------------------------------------------------------+
      | Authors: Eduardo R. Elvira <edulix AT iespana DOT es>                |
      +----------------------------------------------------------------------+
ltimo cambio:
 - crear este fichero
last change:
 - create this file
*/

/**
  * load needed miguel headers
  */

// NOTE: This is an error page and dependences with db neither configuration file must be deleted, so like
// in the install script, we set the vars ussually setted in the config file.
$GLOBALS['webDir']           = realpath('../..').'/';
$GLOBALS['urlAppend']        = str_replace ('/miguel/messages/error_message.php', '', $PHP_SELF);
$GLOBALS['urlServer']        = 'http://'.$SERVER_NAME.$GLOBALS['urlAppend'].'/';
$GLOBALS['language']         = -1;
$GLOBALS['config_readed']    = TRUE;
$GLOBALS['educationManager'] = 'Juan Espaol';
$GLOBALS['siteName']         = 'miguel';
$GLOBALS['Institution']      = 'Hispalinux';
$GLOBALS['InstitutionUrl']   = 'http://www.hispalinux.es/';

// Now -as always- we set the vars needed by the header files
//$GLOBALS['langFile']    = 'index';
$GLOBALS['headerTitle'] = 'Miguel Error';

@include_once ('../include/miguel_require.php');
@include_once (miguel_webDir().'miguel/include/miguel_functions.php');

/**
  * Now we get the error code.
  * We need:
  * 1.- include the miguel_error class and create an instance
  * 2.- Ensure that we have an error code
  */
@include_once (miguel_webDir().'miguel/include/miguel_Error.class.php');

/**
  * There' some cases clasified by the error code:
  * 1.- No error code was given!
  * 2.- An error code was given
  *    2.1.- It was a correct one so that it existed and was a positive number
  *          ->  Then go ahead!
  *    2.2.- It was incorrect:
  *    It existed but it was a negative one and that are reserved for errors giving the error code or
  *    simply, it didn't exist (who knows: it wasn't integer, or it was number 446565...)
  *          ->  Then we assign the error code '-2'
  *       Then we assign the error code '-1'
  */

// It might have happened more than one error. If that's the case, we provide the errors separated with a comma

$ErrorsArray       = $_SESSION['errors'];
$Errors_args_Array = $_SESSION['errors_args'];

// 1:
if (!is_array($ErrorsArray))
{
         $GLOBALS['miguel_Error']->_addError('no error code was given');
// 2:
}
else
{
        for ($i = 0; $ErrorsArray[$i]; $i++)
        {
                // 2.1:
                if ($GLOBALS['miguel_Error']->validError($ErrorsArray[$i]))
                {
                        if ($Errors_args_Array[$ErrorsArray[$i]])
                                $GLOBALS['miguel_Error']->_addError($ErrorsArray[$i], $Errors_args_Array[$ErrorsArray[$i]]);
                        else
                                $GLOBALS['miguel_Error']->_addError($ErrorsArray[$i]);
                // 2.2:
                }
                else
                {
                        $GLOBALS['miguel_Error']->_addError("given error code wasn't recognized");
                }
        }
}

/**
  * include the page header, the title of the page will be "miguel"
  */

//miguelIncludeHeader('miguel');
@include_once (miguel_webDir().'miguel/include/miguel_topheader.php');

?>

<table class="mainInterfaceWidth" id="install" cellspacing="0">
        <tr>
                <td class="bgcolor main-info-cell">
                                <?=$GLOBALS['headerTitle']?>
                </td>
        </tr>
        <tr>
                <td class="warncolor">
                <br>
                <?
                /**
                  * Now, the $ErrorsArray is re-used so that it will contain the array with the errors recognized
                  */
                $ErrorsArray = $GLOBALS['miguel_Error']->getErrors();

                for ($i = 0; $ErrorsArray[$i]; $i++)
                {
                        if ($Errors_args_Array[$ErrorsArray[$i]])
                        {
                                $printf = 'sprintf ("<p>".agt($ErrorsArray[$i])."</p>\n"';
                                for ($j = 0; $Errors_args_Array[$ErrorsArray[$j]]; $j++)
                                {
                                        $printf .= ", \"".$Errors_args_Array[$ErrorsArray[$j]]."\"";
                                }
                                $printf  .= ");";
                                eval($printf);
                        }
                        else
                        {
                                echo "<p>".agt($ErrorsArray[$i])."</p>\n";
                        }
                }
                ?>
                </td>
        </tr>
</table>

<?
/**
  * we include the footer of the page
  */
//miguelIncludeFooter();
@include_once (miguel_webDir().'miguel/include/miguel_footer.php');


/*
// This var defines the language with max priority for msgid
// and msgstr
$main_lang_name = "english";

// This is the var to traduce the language directory names
// into their language codes, and the priorities between languages
$locale = array (
        spanish         => "es_ES",
        english         => "en_US",
        french          => "fr_FR",
        italian         => "it_IT",
        german          => "ge_GE",
        finnish         => "fi_FI",
        arabic          => "ar_AE",
        brazilian       => "pt_BR",
        japanese        => "ja_JP",
        polish          => "pl_PL",
        simpl_chinese   => "zh_CN",
        swedish         => "sv_FI",
            );

*/
?>
