<?php
/*
      +----------------------------------------------------------------------+
      | miguelOO base                                                        |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 *
 */
include_once ("setup.class.php"); 
/**
 * Define la clase setup de miguel.
 * Mediante este script se puede preparar la instalación de miquel
 *
 * Basada en la clase Setup_cli.php del proyecto Horde.
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

class Setup_cli extends Setup {

    var $cli = null;
	var $frameworkName		= 'andromeda';
    var $phphtmllib_path 	= null;
	var $adodb_path 		= null;
	var $miguel_path 		= null;  
	var $miguel_name 		= null;
	var $cacheable  		= null;
	var $cachetime	 		= null;
	var $cachepath	 		= null; 
	var $log     	 		= null;    
	var $logtype	 		= null; 
	var $logpath	 		= null;
	var $logtable	 		= null; 
	var $loglevel	 		= null; 
	var $sessiontime 		= null;
	var $sessionpath 		= null;
	var $errorpath	 		= null;

    /**
     * Constructs a new Setup object using the CLI interface.
     */
    function Setup_cli()
    {
        parent::Setup();

        require_once ('base_CLI.class.php');
        $this->cli = &new base_CLI();

    }

    function check($target)
    {
        switch ($target) {
			case 'registry':
            	return file_exists($this->miguel_path.'/'.$this->miguel_name.'/modules/andromeda/auto_framework.inc.php');
            	break;
        	case 'standard':
        	case 'gettext':
        	case 'session':
        	case 'zlib':
        	case 'pcre':
        	//case 'mysql':
        	    return extension_loaded($target);
        	    break;
        }

    }

    function log($message, $type = 'message')
    {
        /* Wrap the messages with an indent, neater screen display. */
        $message = wordwrap($message, 69, "\n           ");
        $this->cli->message($message, 'cli.' . $type);
    }

    function intro()
    {
        /* Wrap the messages with an indent, neater screen display. */
        $message = wordwrap($message, 69, "\n           ");
        $this->cli->prompt(agt('intro'));
    }

    function setLanguage($code, $path)
    {
    	switch($code){
    		case 'es':
    			$lang = 'es_ES';
    			$name = "Español";
    			break;
    		case 'en';
    			$lang = 'en_US';
    			$name = "English";
    			break;
    	}

    	putenv("LANG=".$lang);
    	setlocale(LC_ALL, $lang);

    	bindtextdomain("setup", $path."/modules/gettext/");
    	textdomain("setup");

    	echo "\n\n";
        $this->log(agt('langLang')." $name ".agt('langConf'), 'success');

    }

    function getServerRoot($miguel_path)
    {
        $ret_val = false;

		$this->miguel_path = dirname($miguel_path);
    	$this->miguel_name = basename($miguel_path);

        $this->cli->message("\n\nPath >> ".$miguel_path."\n", 'label');
    	$ok_name = $this->cli->prompt(agt('rootAsk'), array(agt('opcY') => agt('opcSi'), agt('opcN') => agt('opcNo')));
    	if ($ok_name == agt('opcN')) {
			$int = 1;
			do {
				$miguel_path = $this->cli->prompt(agt('rootInput').': ');

				if (file_exists($miguel_path)) {
					$this->miguel_path = dirname($new_path);
    				$this->miguel_name = basename($new_path);

					$this->log(agt('rootOk'), 'success');
					$ret_val = true;
					break;
				} else {
					$this->log(agt('rootErr'), 'error');
				}
				$int++;
			} while ($int < 4);
    	} else {
			$ret_val = true;
		}

		return $ret_val;
    }

    function getExternalLibs()
    {
        $ret_val = false;
		$int = 1;
		do {
			$this->adodb_path = $this->cli->prompt(agt('adoPath').': ');
			if (file_exists($this->adodb_path.'/adodb.inc.php')) {
				$this->log(agt('adoOk'), 'success');
				$ret_val = true;
				break;
			} else {
                $this->log(agt('adoErr'), 'error');
			}
			$int++;
		} while ($int < 4);

		if($ret_val){
			$ret_val = false;
			$int = 1;
			do {
				$this->phphtmllib_path = $this->cli->prompt(agt('phlPath').': ');
				if (file_exists($this->phphtmllib_path.'/version.inc')) {
					$this->log(agt('phlOk'), 'success');
					$ret_val = true;
					break;
				} else {
					$this->log(agt('phlErr'), 'error');
				}
				$int++;
			} while ($int < 4);
		}

		return $ret_val;
    }

	function fsChoice()
    {
    	$fs_ok = $this->cli->prompt(agt('fsAsk'), array(agt('opcY') => agt('opcSi'), agt('opcN') => agt('opcNo')));
        $var_path = $this->miguel_path.'/'.$this->miguel_name.'/var/temp/';
		//Error log por defecto siempre bajo FS original
		$this->errorpath = $var_path.'log/error.log';

		if ($fs_ok == agt('opcN')) {
    		$this->fsOrig = '0';
    	} else {
    		$this->fsOrig = '1';
            $this->cachepath = $var_path.'cache/';
			$this->logpath = $var_path.'log/miguel.log';
			$this->sessionpath = $var_path.'session';

			if (file_exists($var_path)) {
        	   $this->log(agt('fsOk'), 'success');
        	} else {
        	    $this->cli->fatal(agt('fsErr'));
        	}
        }
    }

    function setupCache()
    {
    	$cache_ok = $this->cli->prompt(agt('cacheAsk'), array(agt('opcY') => agt('opcSi'), agt('opcN') => agt('opcNo')));
    	if ($cache_ok == agt('opcN')) {
    		$this->cacheable = '0';
    	} else {
    		$this->cacheable = '1';
    		$this->cachetime = $this->cli->prompt(agt('cacheInt').': ');
			if($this->fsOrig == '0'){
				$this->cachepath = $this->cli->prompt(agt('cachePath').': ');
				if (file_exists($this->cachepath)) {
				$this->log(agt('cacheOk'), 'success');
				} else {
					$this->cli->fatal(agt('cacheErr'));
				}
			}

        }
    }

    function setupLog()
    {
    	$log_ok = $this->cli->prompt(agt('logAsk'), array(agt('opcY') => agt('opcSi'), agt('opcN') => agt('opcNo')));
     	if ($log_ok == agt('opcN')) {
    		$this->log = '0';
    	} else {
    		$this->log = '1';
    		$type = $this->cli->prompt(agt('logType'), array('1' => agt('logTFile'),
    															  '2' => agt('logTtable'),
    															  '3' => agt('logTPHP')));
    		switch($type){
    			case '1':
    				$this->logtype = 'file';
					if($this->fsOrig == '0'){
						$this->logpath = $this->cli->prompt(agt('logPath').': ');
						if (file_exists($this->logpath)) {
							$this->log(agt('logOk'), 'success');
						} else {
							$this->cli->fatal(agt('logErr'));
						}
					}

    				break;
    			case '2';
    				$this->logtype = 'adodb';
    				$this->logtable = $this->cli->prompt(agt('logTable').': ');
    				break;
    			case '3';
    				$this->logtype = 'error_log';
    				break;
    		}

    		$type = $this->cli->prompt(agt('logCrit').': ',
    								   array('1' => agt('logD1'),
    								   		 '2' => agt('logD2'),
    								   		 '3' => agt('logD3'),
    								   		 '4' => agt('logD4'),
    								   		 '5' => agt('logD5'),
    								   		 '6' => agt('logD6'),
    								   		 '7' => agt('logD7'),
    								   		 '8' => agt('logD8'),
    								   		 '9' => agt('logD9'),
    								   		 '0' => agt('logD0')));
    		switch($type){
    			case '1':
    				$this->loglevel = 'EMERG';
     				break;
    			case '2';
    				$this->loglevel = 'ALERT';
    				break;
    			case '3';
    				$this->loglevel = 'CRITIC';
    				break;
    			case '4';
    				$this->loglevel = 'ERROR';
    				break;
    			case '5';
    				$this->loglevel = 'WARNING';
    				break;
    			case '6';
    				$this->loglevel = 'NOTICE';
    				break;
    			case '7';
    				$this->loglevel = 'INFO';
    				break;
    			case '8';
    				$this->loglevel = 'DEBUG';
    				break;
    			case '9';
    				$this->loglevel = 'ALL';
    				break;
    			case '0';
    				$this->loglevel = 'NONE';
    				break;
    		}
        }
    }

    function setupSession()
    {
        $this->sessiontime = $this->cli->prompt(agt('sessInt').': ');

		if($this->fsOrig == '0'){
			$this->sessionpath = $this->cli->prompt(agt('sessPath').': ');
			if (file_exists($this->sessionpath)) {
			$this->log(agt('sessOk'), 'success');
			} else {
				$this->cli->fatal(agt('sessErr'));
			}
		}
    }

    function makeRegistry()
    {
    	$file_path = $this->miguel_path.'/'.$this->miguel_name.'/modules/';

        include_once ($file_path.'andromeda/auto_framework.inc.php');
        $file_cont = '';
        $file_cont .= $config_base;
        $file_cont .= $config_cache;
        $file_cont .= $config_log;
        $file_cont .= $config_session;
        $file_cont .= $config_defines;

        include_once ($file_path.'common/auto_miguel_base.inc.php');
        $miguel_cont = '';
        $miguel_cont .= $miguel_base;

        $base_name  = $file_path.'andromeda/framework.inc.php';
        $miguel_name  = $file_path.'common/miguel_base.inc.php';
        $create_registry = $this->cli->prompt(agt('createAsk'), array(agt('opcY') => agt('opcSi'), agt('opcN') => agt('opcNo')));

        if ($create_registry == agt('opcY')) {
        	$this->writeFile($base_name, $file_cont);
            if (!file_exists($base_name)) {
                $this->cli->fatal(agt('createErr'));
            }
            $this->writeFile($miguel_name, $miguel_cont);
            if (!file_exists($miguel_name)) {
                $this->cli->fatal(agt('createErr'));
            }
            $this->log(agt('createOk'), 'success');
        } else {
            $this->cli->fatal(agt('createInfo'));
        }
    }

	function setupDDBB()
    {
        require_once($this->adodb_path.'/adodb.inc.php');
		require_once($this->adodb_path.'/adodb-xmlschema.inc.php');

		$bol_error = true;

		$int = 1;
		do {
			$SGBDs = $this->getAllSGBD();

			$select = $this->cli->prompt(agt('ddbbSGBD'), $SGBDs);
			$platform = $SGBDs[$select];
			$dbHost = $this->cli->prompt(agt('ddbbHost').': ');
			$dbUser = $this->cli->prompt(agt('ddbbUser').': ');
			$dbPassword = $this->cli->prompt(agt('ddbbPasswd').': ');
			$dbName = $this->cli->prompt(agt('ddbbName').': ');

			$db = ADONewConnection( $platform );
			$db->Connect( $dbHost, $dbUser, $dbPassword, $dbName );

			if (is_resource($db->_connectionID)) {
				$this->log(agt('ddbbConnOk'), 'success');
				$bol_error = false;
				break;
			} else {
				$this->log(agt('ddbbConnErr'), 'error');
			}

			$int++;
		} while ($int < 4);

		if($bol_error){
			return false;
		}

		$allDDBB = $db->MetaDatabases();

		if(!empty($allDDBB)){
			if (in_array($dbName, $allDDBB)){
				$this->log(agt('ddbbNameOk'), 'success');
			} else {
                $this->log(agt('ddbbNameErr'), 'warning');
				$this->log(agt('ddbbCreate'), 'warning');

				if (!$db->Execute("create database $dbName") ) {
					$this->cli->fatal(agt('ddbbCreateErr'));
				} else {
					$this->log(agt('ddbbCreateOk'), 'success');

					//Reconectamos
					$db->Connect( $dbHost, $dbUser, $dbPassword, $dbName );
				}
			}
		}

		$schemaFile = $this->miguel_path.'/'.$this->miguel_name.'/modules/common/include/miguel_schema.xml';

		if(file_exists($schemaFile)) {
			//Preparamos el proceso de creación de la BBDD
			$schema = new adoSchema( $db );

			$sql = $schema->ParseSchema( $schemaFile );
			$result = $schema->ExecuteSchema($sql, true);

			if ($result != 2) {
  				$this->cli->fatal(agt('ddbbTableErr'));
			}

			$this->log(agt('ddbbTableOk'), 'success');
		} else {
			$this->cli->fatal(agt('fsErr'));
		}

		return true;
    }

    function writeFile($file_name, $file_content)
    {
    	// abrir en modo escritura el fichero cache
    	$file = fopen($file_name,'w');

    	// escribir el contenido de $html en el fichero cache
    	fwrite($file, $file_content);

    	// cerrar fichero
    	fclose($file);
    }

	function fatalError($error)
	{
		$this->cli->fatal(agt($error));
	}

	function getAllSGBD()
    {
        $sgbdlist = array();
        $dir_path = $this->adodb_path.'/drivers/';
        $dir = opendir($dir_path);

		$ind = 1;

        while ($item = readdir ($dir)){
            if($item != '.' && $item != '..' && $item != 'CVS'){
                if(is_file($dir_path.$item)){
                    $elem = substr($item, 6,-8);
                    $sgblist[$ind] = $elem;
					$ind++;
                }
            }
        }
        closedir($dir);
		sort($sgblist);

        return $sgblist;
    }
}
