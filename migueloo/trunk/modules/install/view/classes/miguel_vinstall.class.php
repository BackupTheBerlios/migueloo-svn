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
 * Define la pantalla del paso 1 de la instalación.
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel base
 * @subpackage view
 * @version 1.0.0
 *
 */

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vpage.class.php"));

class miguel_VInstall extends miguel_VPage
{
	/**
	 * This is the constructor.
	 *
	 * @param string - $title - the title for the page and the
	 *                 titlebar object.
	 * @param - string - The render type (HTML, XHTML, etc. )
	 *                   default value = HTML
     *
	 */
    function miguel_VInstall($title, $arr_commarea)
    {
        $this->miguel_VPage($title, $arr_commarea);
		//Debug::oneVar($arr_commarea, __FILE__, __LINE__);
    }



    /**
     * We override this method to automatically
     * break up the main block into a
     * left block and a right block
     *
     * @param TABLEtag object.
     */
    function main_block()
	{
		$main = html_div();
		$main->set_id("content");

		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1,0);
		$table->set_class("simple");

		//Centros
        $elem1 = html_td("color1-bg", "", $this->left_block());

		$table->add_row($elem1);
        $main->add( $table );

		return $main;
    }


    /**
     * this function returns the contents
     * of the left block.  It is already wrapped
     * in a TD
     *
     * @return HTMLTag object
     */
    function left_block()
	{
		switch (intval($this->getViewVariable('install_step'))) {
			case 0:
				$ret_val = $this->_installQuit();
				break;
			case 1:
				$ret_val = $this->_installStep1();
				break;
			case 2:
				$ret_val = $this->_installStep2();
				break;
			case 3:
				$ret_val = $this->_installStep3();
				break;
			case 4:
				$ret_val = $this->_installStep4();
				break;
			case 5:
				$ret_val = $this->_installStep5();
				break;
			case 6:
				$ret_val = $this->_installStep6();
				break;
			case 7:
				$ret_val = $this->_installStep7();
				break;	
			default:
				$ret_val = $this->_installStep1();
		}

		return $ret_val;
	}
	
	function _installQuit()
	{
		$ret_val = container();
		
		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Salida")));
		
		$div->add(agt("Ha decidido cancelar la instalación"));
		$div->add(html_br(2));
		$div->add(html_a(Util::main_URLPath('index.php'), 'Volver'));
		$div->add(html_br(2));

		$ret_val->add($div);
            	
        return $ret_val;
    }
	
	function _installStep1()
	{
		$ret_val = container();
		
		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 1")));
		
		$div->add(agt("Seleccione el idioma para este Asistente de instalación"));
		$div->add(html_br(2));
		$div->add($this->addForm('install', 'miguel_selectLangForm'));
			
		$ret_val->add($div);
            	
        return $ret_val;
    }
	
	function _installStep2()
	{
		$ret_val = container();
				
		$div = html_div("ul-big");
		
		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 2")));
		//$div->add(html_br());
		
		$div->add(agt("Este asistente le ayudara a configurar miguel paso a paso."));
		$div->add(html_br(2));
		
		$div->add(agt("Para que miguel funcione adecuadamente, se necesita:"));
		$div->add(html_br(2));
		
		$div->add("1.- ".agt("Servidor Web con PHP 4.x (dispone de: "));
		$div->add(html_em($_SERVER['SERVER_SOFTWARE']));
		$div->add(")");
		$div->add(html_br(2));
		
		$div->add("2.- ".agt("Las siguientes módulos del servidor apache instalados: "));
		$div->add($this->_processRequireArray($this->getViewVariable("install_require")));
		$div->add(html_br(2));
		
		//$div->add(agt("miguel utiliza phpMyAdmin (administrador web para MySQL), pero puede usar cualquier otro."));
		//$div->add(html_br());
		//$div->add(agt("Para instalar miguel en un ordenador bajo Windows, solamente necesita instalar previamente "));
		//$div->add(html_a("http://www.easyphp.org", "easyphp"));
		//$div->add(".");
		//$div->add(html_br(2));
		$div->add($this->addForm('install', 'miguel_quitNavForm'));
			
		$ret_val->add($div);
            	
        return $ret_val;
    }

    function _installStep3()
	{
		$ret_val = container();
		
		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 3")));
		
		$div->add(agt("miguel es software libre, distribuido bajo la GNU General Public License (GPL)."));
        $div->add(html_br());
		$div->add(agt("Por favor lea la licencia y haga clic sobre 'Acepto'."));
		$div->add(html_br(2));
		$div->add(agt("Lea cuidadosamente lo siguiente: "));

		$div->add($this->addForm('install', 'miguel_licenceForm'));

		$ret_val->add($div);

        return $ret_val;
    }

    function _installStep4()
	{
		$ret_val = container();

		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 4")));


		$div->add(html_h3(agt("Configuración del acceso a la Base de Datos")));
		$div->add(html_br(2));
		$div->add(agt("Este paso le ayudará a configurar el acceso a la Base de Datos de miguel."));

		$div->add($this->addForm('install', 'miguel_ddbbForm'));

		$ret_val->add($div);

        return $ret_val;
    }

	function _installStep5()
	{
		$ret_val = container();

		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 5")));


		$div->add(html_h3(agt("Personalización del Campus Virtual")));
		$div->add(html_br(2));
		$div->add(agt("Este paso le ayudará a personalizar su instalación de miguel."));

		$div->add($this->addForm('install', 'miguel_prefsForm'));

		$ret_val->add($div);

        return $ret_val;
    }

    function _installStep6()
	{
		$ret_val = container();

		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 6")));


		$div->add(html_h3(agt("Personalización del Campus Virtual")));
		$div->add(html_br(2));
		$div->add(agt("Estos son los parámetros de personalización de su Campus en miguel."));
		$div->add(html_br(2));

		$div2 = html_div('warncolor');
		$div2->add(agt('Imprima esta página para conservar su configuración'));
		$div->add($div2);
		$div->add(html_br(2));

		$table = &html_table($this->_width,0,3);
        $table->set_class("mainInterfaceWidth");
        //$table->set_style("border: 1px solid");
		$table->add($this->_addFinalRow('Sistema Gestor de la Base de Datos', Session::getValue('host_sgbd')));
		$table->add($this->_addFinalRow('Alojamiento de la Base de Datos', Session::getValue('host_name')));
		$table->add($this->_addFinalRow('Nombre de la Base de Datos', Session::getValue('ddbb_name')));
		$table->add($this->_addFinalRow('Usuario de acceso a la Base de Datos', Session::getValue('ddbb_user')));
		$table->add($this->_addFinalRow('Clave de acceso a la Base de Datos', '____________________ (*)'));
		$table->add($this->_addFinalRow('Nombre del Campus Virtual', Session::getValue('campus_name')));
		$table->add($this->_addFinalRow('Nombre de la Institución', Session::getValue('inst_name')));
		$table->add($this->_addFinalRow('URL de la Institución', Session::getValue('inst_url')));
		$table->add($this->_addFinalRow('Jefe de estudios', Session::getValue('director_name')));
		$table->add($this->_addFinalRow('Correo de contacto', Session::getValue('director_email')));
		$table->add($this->_addFinalRow('Teléfono de contacto', Session::getValue('inst_phone')));
		$table->add($this->_addFinalRow('Idioma del Campus', Session::getValue('campus_lang')));
		$table->add($this->_addFinalRow('Nombre del Administrador', Session::getValue('admin_name')));
		$table->add($this->_addFinalRow('Apellidos del administrador', Session::getValue('admin_surname')));
		$table->add($this->_addFinalRow('Usuario del administrador', Session::getValue('admin_user')));
		$table->add($this->_addFinalRow('Clave del administrador', '____________________ (*)'));
		$table->add($this->_addFinalRow('Tema visual del administrador', Session::getValue('admin_theme')));
		$table->add($this->_addFinalRow('Claves encriptadas en la base de datos', Session::getValue('cript_passwd')));

		$div->add($table);
        $div->add(html_br(2));

		$div3 = html_div('warncolor');
		$div3->add(agt('(*) Por motivos de seguridad la clave le será enviada via correo electrónico.'));
		$div->add($div3);

		$div->add($this->addForm('install', 'miguel_installNavForm'));

		$ret_val->add($div);

        return $ret_val;
    }

    function _installStep7()
	{
		$ret_val = container();

		$div = html_div("ul-big");

		//Add install image
		$div->add($this->_addImage());

		$div->add(html_h2(agt("Instalación de miguel - Paso 7")));


		$div->add(html_h3(agt("Personalización del Campus Virtual")));
		$div->add(html_br(2));
		$div->add(agt("Ahora ya puede empezar a disfrutar de miguel, su plataforma e-Learning GPL."));
        $div->add(html_br(2));
		$div->add(html_a(Util::main_URLPath('index.php'), 'Acceder a miguel'));
		$div->add(html_br(2));

		$ret_val->add($div);

        return $ret_val;
    }

	function _addImage()
	{
		//Choose image
		switch (PHP_OS) {
			case "WIN32" :
			case "WINNT" :
				$wizardImage = "install/windowsWizard.png";
				break;
			case "Linux" :
				$wizardImage = "install/linuxWizard.png";
				break;
			default :
				$wizardImage = "install/defaultWizard.png";
		}
		$wizImage = html_img(Theme::getThemeImagePath($wizardImage), 0, 0, 0, "Wizzard Image");
		$wizImage->set_tag_attribute("align", "right");
		return $wizImage;
	}
	
	function _processRequireArray($a)
	{
		$retval = '';
		
		if ( is_array($a) && $a != array()) {
			$retval = html_ul();
			foreach ( $a as $key => $value ) {
				if($value == 1) {
					$elem = $key." - ".agt("Instalado");
				} else {
					$elem = container();
					
					$elem->add(html_strong($key));
					$elem->add(" - ");
					$elem->add(agt("No instalado. Para obtenerlo, ir a "));
					$elem->add(html_a("http://www.php.net/$key",$key));
				}
				$retval->add(html_li($elem));
			}
		}
		
		return $retval;
	}

	function _addFinalRow($lit, $val)
	{
		$row = html_tr("");
		$col1 = html_td("");
		$col1->set_tag_attribute("align", "left");
		$col1->add(html_b(agt($lit)));
		$col2 = html_td("");
		$col2->set_tag_attribute("align", "left");
		$col2->add($val);
		$row->add($col1, $col2);

		return $row;
	}
}

?>
