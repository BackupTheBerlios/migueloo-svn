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
 * Define la clase base para las pantallas especiales de miguel.
 *
 * Utiliza la libreria phphtmllib.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @copyright GPL - Ver LICENCE
 * @package framework
 * @subpackage view
 * @version 1.0.0
 *
 */
include_once (Util::base_Path("view/classes/base_layoutpage.class.php"));

class miguel_VBase extends base_LayoutPage
{
	var $str_title = '';
	
	function miguel_VBase($str_title, $arr_commarea)
	{
		$this->str_title = $str_title;
		$this->base_LayoutPage($this->str_title, $arr_commarea);
	}

	function initialize()
	{
		//Preparamos valores para los header de la página
		// <META HTTP-EQUIV="refresh" content="5; URL=http://">
		//  html_meta  (string $content, [string $http_equiv = ""], [string $name = ""])
		//$this->add_head_content("<meta http-equiv=\"refresh\" content=\"5\" url=\"".Util::main_URLPath('index.php')."\">");
		$this->add_head_content("<meta name=\"keywords\" content=\"miguel,hispalinux,indetec,campus,ecampus,e-campus,classroom,elearning,learning,pedagogy,platform,teach,teaching,teacher,prof,professor,student,study,open,source,gpl,mysql,php,e-learning, apprentissage,ecole,universite,university,contenu,classe, universidad, enseñanza, virtual, distribuida, sl, gpl, software, libre, clases, aprendizaje, proceso\">");
		$this->add_head_content("<link rel=\"icon\" href=\"".Theme::getThemeImagePath('favicon.png')."\" type=\"image/png\">");
	
		//Hojas de estilo CSS
		$this->add_css_link(Theme::getThemeCSSPath('common.css'));
		//$this->add_js_link(Theme::getThemeJSPath('miguel.js'));
	}

	function body_content()
	{
		//add the header area
		if(MIGUELBASE_USR_BROWSER_AGENT == 'IE') {
			$params = array('leftmargin'=>'0', 'topmargin'=>'0', 'marginwidth'=>'0', 'marginheight'=>'0');
			$this->set_body_attributes($params);
		}
	
		//add the header area
		$this->add( $this->header_block() );
	
		//add it to the page
		$wrapper_div = html_div();
		$wrapper_div->add( $this->main_block() );
		$this->add( $wrapper_div );
	
		//add the footer area
		$this->add( $this->footer_block() );
	}

	function header_block()
	{
		
		$this->registry->pushApp('common');
		//include_once(Util::base_Path('include/classes/nls.class.php'));
		//NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());

		include_once(Util::app_Path('common/view/classes/miguel_header.class.php'));
		$header = html_div();
		$table = new miguel_Header();
		$header->add($table->getContent());
		unset($table);
		
		$this->registry->popApp('common');
	
		return $header;
	}
	
	function footer_block()
	{
		$this->registry->pushApp('common');
		//include_once(Util::base_Path('include/classes/nls.class.php'));
		//NLS::setTextdomain('common', Util::formatPath(MIGUELGETTEXT_DIR), NLS::getCharset());

		$footer_div = html_div('pie');

		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$footer_div ->add($hr);

		include_once(Util::app_Path('common/view/classes/miguel_footer.class.php'));
		$footer = new miguel_Footer();
		$footer_div->add($footer->getContent());
		
		$this->registry->popApp('common');

		return $footer_div;
	}
}
?>