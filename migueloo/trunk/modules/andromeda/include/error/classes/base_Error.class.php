<?php

/*
    +----------------------------------------------------------------------+
    | base_Error.class.php    1.3                                         |
    +----------------------------------------------------------------------+
    | This software is part of miguel    version 0.1.1 $Revision: 1.4 $    |
    +----------------------------------------------------------------------+
    | Copyright (c) 2003, Asociacion Hispalinux                            |
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
    | Authors:                                                             |
    |         Jesus Martinez <jamarcer at inicia dot es>                   |
    |         Eduardo R. Elvira <edulix AT iespana DOT es>                 |
    +----------------------------------------------------------------------+
    | Email bugs/suggestions to the authors                                |
    +----------------------------------------------------------------------+

    20/10/2003 19:09 - Added support of a a page that show the errors happened and new error symtem based on error codes
*/


/**
  * This class implements miguel's error system.
  *
  * @author     Jesus Martinez
  * @author     Eduardo R. Elvira
  * @package    miguel
  * @subpackage utils
  * @version    1.4.1
  * 
  */
class base_Error
{
	/**
	 *
	 */
	var $bError		= false;

	/**
	 * this array contains all the errors that have happened and have been stored
	 *
	 */
	var $ArrayErrors	= array();

	/**
	 * this array contains all the argumments that will be passed
	 *
	 */
	var $ArrayErrorsArgs 	= array();

	/** Methods: public*/

	/**
  	  * @desc Constructor.
          * There we set some
  	  *
  	  * @public
  	  */
	function base_Error ()
	{
		/*
		$GLOBALS['locale'] = miguel_getBrowserLang();
		@setlocale(LC_ALL, $GLOBALS['locale']);
	
		$gettext_domain = "errors";
		bindtextdomain($gettext_domain, miguel_webDir().'/miguel/gettext');
		textdomain($gettext_domain);
		*/
	}
	
	/**
  	  * @returns     boolean
  	  * @desc        Returns if an error has ocurred
  	  * @public
  	  */

	function hasError ()
	{
		return $this->bError;
	}

	/**
          * @author    Eduardo R. Elvira
          * @return    1.- exists        (return 1)
          *            2.- doesn't exist (return 0)
  	  * @desc      This method checks whether an error code name exist or not
          *            even exist
  	  * @public
	  */
	function validError ($error)
	{
		if (agt($error) != $error && !in_array($error, $this->ArrayErrors)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	  * @returns     string
  	  * @desc        Returns an array of the errors code from the errors happeneded
  	  * @public
	  */
	function getErrors ()
	{
		return $this->ArrayErrors;
	}

	/**
	  * @desc     Redirect to the errors page if one or more errors have been held (and if the actual page
          *           isn't already the errors page)
	  *
          * @author   Eduardo R. Elvira
	  * @public
	  */
	function showErrors ()
	{
		if ($this->hasError() && !strstr(substr($_SERVER["PHP_SELF"], -33), "miguel/messages/error_message.php")) {
			$_SESSION["errors"] = $this->ArrayErrors;
			$_SESSION["errors_args"] = $this->ArrayErrorsArgs;
			header("Location: ".$GLOBALS['urlServer']."miguel/messages/error_message.php");
		}
	}

  	/** Methods: private*/

	/**
  	  * @param     integer     $error       Error code name
  	  * @param     array       $error_array Error args
  	  * @desc      This method let's add an error code name to the array that store all the errors happended
          *            Note that you must give an array containing the arguments to give to the error if it needs
          *            so: for example, an error could be: "the page %s couldn't be saved from user %s", and the
          *            Array args given to this function should be similar to array("page.php", "myuser");
  	  * @private
	  */
	function _addError ($error, $args_array="")
	{
        	if ($this->validError($error)) {
                        if (!is_array($args_array) && empty($args_array))
                        {
			        $this->ArrayErrors[]     = $error;
			        $this->bError            = TRUE;
                        } elseif (count($args_array) == substr_count(agt($error), "%")) {
                                $this->ArrayErrorsArgs[$error] = $args_array;
			        $this->ArrayErrors[]     = $error;
			        $this->bError            = TRUE;
                        } else {
                                return FALSE;
                        }
                } else {
			return FALSE;
                }
	}

	/**
          * @author   Eduardo R. Elvira
          * @desc     Empty the errors array
	  * @private
	  */
	function _clearErrors ()
	{
		$this->ArrayErrors  = array();
		$this->bError       = FALSE;
	}

}

?>
