<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
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
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MInstall extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MInstall()
    {
		$this->base_Model(false);
    }
    
    function getAllLang()
    {
        include_once(Util::base_Path('include/classes/nls.class.php'));
        $langlist = array();
        $dir = opendir(MIGUELGETTEXT_DIR);

        while ($item = readdir ($dir)){
            if($item != '.' && $item != '..' && $item != 'CVS' && !is_file($item)){
                $langlist[NLS::getLangLabel($item)] = $item;
            }
        }
        closedir($dir);

        return $langlist;
    }
    
    function getAllSGBD()
    {
        $sgbdlist = array();
        $dir_path = MIGUELBASE_ADODB.'/drivers/';
        $dir = opendir($dir_path);

        while ($item = readdir ($dir)){
            if($item != '.' && $item != '..' && $item != 'CVS'){
                if(is_file($dir_path.$item)){
                    $elem = substr($item, 6,-8);
                    $sgblist[$elem] = $elem;
                }
            }
        }
        closedir($dir);

        return $sgblist;
    }

	/**
   	 *
   	 */
  	function makeXMLData()
    {
        require_once (MIGUELBASE_MINIXML.'/minixml.inc.php');

		$dump_buffer ='';

      	$xml = new MiniXMLDoc();

      	$xmlRoot =& $xml->getRoot();

		$config =& $xmlRoot->createChild('config');

      	$child =& $config->createChild('ddbbSgbd');
      	$child->text(Session::getValue('host_sgbd'));
      	$child =& $config->createChild('ddbbMainDb');
      	$child->text( Session::getValue('ddbb_name'));
      	$child =& $config->createChild('ddbbServer');
      	$child->text(Session::getValue('host_name'));
      	$child =& $config->createChild('ddbbUser');
      	$child->text(Session::getValue('ddbb_user'));
      	$child =& $config->createChild('ddbbPassword');
      	$child->text(Session::getValue('ddbb_passwd'));

      	$child =& $config->createChild('siteName');
      	$child->text(Session::getValue('campus_name'));
      	$child =& $config->createChild('Institution');
      	$child->text(Session::getValue('inst_name'));
      	$child =& $config->createChild('InstitutionUrl');
      	$child->text(Session::getValue('inst_url'));
      	$child =& $config->createChild('language');
      	$child->text(Session::getValue('campus_lang'));
      	$child =& $config->createChild('emailAdministrator');
      	$child->text(Session::getValue('director_email'));
      	$child =& $config->createChild('administratorName');
      	$child->text(Session::getValue('admin_name'));
      	$child =& $config->createChild('administratorSurname');
      	$child->text(Session::getValue('admin_surname'));
      	$child =& $config->createChild('educationManager');
      	$child->text(Session::getValue('director_name'));
      	$child =& $config->createChild('telephone');
      	$child->text(Session::getValue('inst_phone'));
      	$child =& $config->createChild('maxFilledSpaceUser');
      	$child->text('100000');
      	$child =& $config->createChild('maxFilledSpaceAdmin');
      	$child->text('1000000');
      	$child =& $config->createChild('mainInterfaceWidth');
      	$child->text('100%');
      	$child =& $config->createChild('miguelVersion');
      	$child->text(MIGUEL_VERSION);
      	$child =& $config->createChild('versionDb');
      	$child->text(MIGUEL_DDBB_VERSION);
      	$child =& $config->createChild('userMailCanBeEmpty');
      	$child->text('true');
      	$child =& $config->createChild('userPasswordCrypted');
      	$child->text(Session::getValue('cript_passwd'));

      	//Write data in tmp subfolder
      	File::Write(CONFIG_FILE, $xml->toString());
    }
}
?>
