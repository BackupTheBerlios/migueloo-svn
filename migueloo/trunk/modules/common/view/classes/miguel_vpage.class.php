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
 * Define la clase base para las pantallas de miguel.
 *
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
//include_once(Util::base_Path('include/classes/nls.class.php'));

class miguel_VPage extends base_LayoutPage
{
	/**
	 * @access private
	 * @var string
	 */
	var $str_title = '';
	
	/**
	 * @access private
	 * @var string
	 */
	var $bol_normal = true;

	function miguel_VPage($str_title, $arr_commarea)
	{
		$this->str_title = $str_title;
		$this->base_LayoutPage($str_title, $arr_commarea);
        $this->str_type = Session::getContextValue("mainInterfaceType");

	
		/*if(isset($arr_commarea)){
			foreach($this->arr_form as $key => $value){
				$this->setViewVariable($key, $value);
			}
		}*/
	
		if(isset($arr_commarea['wm'])){
			$this->_setMessageWindow();
		}
	}
		
	function initialize()
	{
		//Preparamos valores para los header de la página
		$this->add_head_content("<meta name=\"keywords\" content=\"miguel,hispalinux,indetec,campus,ecampus,e-campus,classroom,elearning,learning,pedagogy,platform,teach,teaching,teacher,prof,professor,student,study,open,source,gpl,mysql,php,e-learning, apprentissage,ecole,universite,university,contenu,classe, universidad, enseñanza, virtual, distribuida, sl, gpl, software, libre, clases, aprendizaje, proceso\">");
		$this->add_head_content("<link rel=\"icon\" href=\"".Theme::getThemeImagePath('favicon.png')."\" type=\"image/png\">");
	
		//Hojas de estilo CSS
		$this->add_css_link(Theme::getThemeCSSPath('common.css'));
		$this->add_css_link(Theme::getThemeCSSPath('estilo.css'));
	
		//$this->add_css_link(Theme::getThemeCSSPath('headers.css'));
		//$this->add_css_link(Theme::getThemeCSSPath('index.inc.css'));
		
		//JavaScript File
		$this->add_js_link(Theme::getThemeJSPath('miguel.js'));
		//$this->add_css_link(Theme::getThemeCSSPath('menu.css'));
		//$this->add_js_link(Theme::getThemeJSPath('menu.js'));
		$this->add_js_link(Theme::getThemeJSPath('curso.js'));
		$this->add_css_link(Theme::getThemeCSSPath('menu.css'));
		$this->add_js_link(Theme::getThemeJSPath('fechaespanol.js'));
		$this->add_js_link(Theme::getThemeJSPath('menu.js'));
		$this->add_js_link($this->getViewVariable('menufile'));
		$this->add_js_link(Theme::getThemeJSPath('menu_tpl.js'));
	}
	
	
	function body_content()
	{
		if($this->bol_normal){
			//add the header area
			$this->add( $this->header_block() );
		}
			
		//add the header area
		if(MIGUELBASE_USR_BROWSER_AGENT == 'IE') {
			$params = array('leftmargin'=>'0', 'topmargin'=>'0', 'marginwidth'=>'0', 'marginheight'=>'0');
			$this->set_body_attributes($params);
		}
		
		
		if($this->bol_normal){
			//add the navigation bar
			$this->add( $this->navigationBar() );
		}
		
		
		//if($this->issetViewVariable('wm')){
		/*
			$iframe_div = html_div('fondopagina');
			$div_style = 'position:relative;z-index:1;visibility: hidden';
			$iframe_div->set_tag_attribute('id', 'div_i');
			$iframe_div->set_tag_attribute('style', $div_style);
						
			if($this->issetViewVariable('wm')){
				$link = Util::format_URLPath('calendar/index.php');
			} else {
				$link = '';
			}
			
			$iframe = html_iframe($link, '100%', '100%', 'no');
			//$iframe = html_iframe();
			$iframe->set_tag_attribute('name', 'myFrame');
			//$iframe->set_tag_attribute('style', 'width:0px; height:0px; border: 0px');
			//$iframe->set_tag_attribute('AllowTransparency');
			
			$iframe_div->add($iframe);
			
			$this->add($iframe_div);
			*/
		
			//$params = array('onUnLoad'=>'window.close();');
			//$this->set_body_attributes($params);
		//}
		/*
		$params = array('onLoad'=>'winpopup.close();');
		$this->set_body_attributes($params);
		*/
		
		//add it to the page
		$main = html_div();
		$main->set_id('content');

		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,0);
		$table->set_class('simple');
		
		
        //Barra Herramientas
		if ($this->str_type == 'toolbar') {
			$elem1 = html_td('color3-bg', '', $this->left_block());
			//$elem1->set_id("anonymous");
			$elem1->set_tag_attribute('width', 40);
			$elem1->set_tag_attribute('valign', 'top');
		}
		//Principal
		$elem2 = html_td('color1-bg', '',$this->right_block());
		$elem2->set_tag_attribute('valign', 'top');
		//$elem2->set_id("identification");
        
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);

		$table->add_row($row);
        
        $main->add( $table );

		$this->add( $main);

		//add the footer area.
		if($this->bol_normal){
			//if ($this->str_type == 'menu') {
				$this->add( $this->footer_block() );
			//}
		}
		
		if($this->bol_normal){
			$this->add(html_script(Theme::getThemeJSPath('menu_exec.js'), 'text/javascript'));
		}
		
	}

	function header_block()
	{
		$this->registry->pushApp('common');
	
		include_once(Util::app_Path('common/view/classes/miguel_header.class.php'));
		$header = html_div();
		$table = new miguel_Header($this->getViewVariable("str_help"), $this->getViewVariable("str_message"));
	
		$header->add($table->getContent());
		unset($table);
		
		$this->registry->popApp('common');
	
		return $header;
	}
    
	function main_block()
    {
                return;
    }

    function left_block()
    {
                $div = html_div();
                $div->set_style("padding-left: 6px;");

                $div->add( "LEFT BLOCK" );
        return $div;
    }

    function right_block()
    {
                $div = html_div();
                $div->set_style("padding-left: 6px;");

                $div->add( "RIGHT BLOCK" );
        return $div;
    }

    function footer_block()
    {
		$this->registry->pushApp('common');

		$footer_div = html_div('pie');
		
		$hr = html_hr();
		$hr->set_tag_attribute("noshade");
		$hr->set_tag_attribute("size", 2);
		$footer_div ->add($hr);
		
		include_once(Util::app_Path('common/view/classes/miguel_footer.class.php'));
		$table = new miguel_Footer();
		$footer_div->add($table->getContent());
		unset($table);
		
		$this->registry->popApp('common');

		return $footer_div;
    }

	function navigationBar()
	{
		$div = html_div();
		$div->set_tag_attribute('valign','top');

		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		$table->set_class('fondopagina');
		$row = html_tr();
		$space = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif")));
		//$space->set_tag_attribute('align', 'right');
		$space->set_tag_attribute('width', '3%');

		$image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif")/*, 20, 14, null*/));
		$image->set_tag_attribute('align', 'right');
		//$image->set_tag_attribute('width', '5%');

		//$row->add(html_td('menubar', '',  $this->_navBar()));
		//$table->add_row($this->_getServicesBar());
		$state = html_td('banner', '', $this->_navBar());
		$state->set_tag_attribute('width', '90%');
		$state->set_tag_attribute('height', '20');
		$state->set_tag_attribute('align', 'left');

		$inicio = html_a(Util::format_URLPath("main/index.php"), "Inicio", null, "_top");
		$inicio->set_tag_attribute('class', 'bannera');

		$progress = html_td('banner', '', $inicio);
		$progress->set_tag_attribute('width', '5%');

		//$row->add($space);
		//$row->add($image);
		$row->add($state);
		$row->add($progress);

		$table->add_row($row);

		$div->add($table);

		return $div;
	}

	function _navBar()
	{
		$ret_val = '';
	
		/*
		$menu[]= array ("url" => Util::format_URLPath("lib/index.php"), "name" => Session::getContextValue("siteName"));
		//$menu = array_merge ($menu, $this->getViewVariable("menubar"));
		$menu = array_merge ($menu, $this->getSessionElement('bar_array'));
		*/
	
		$menu = Session::getValue('bar_array');
		if (is_array($menu) && !empty($menu)) {
			$ret_val = container();
			for($i=0; $i < count($menu) -1; $i++) {
				$link= html_a($menu[$i]["url"], $menu[$i]["name"]);
				//$link->set_tag_attribute('class', 'bannera');
				$ret_val->add($link);
				$ret_val->add(">");
			}
			$link = html_a($menu[count($menu) - 1]["url"], $menu[count($menu) - 1]["name"]);
			//$link->set_tag_attribute('class', 'bannera');
			$ret_val->add($link);
		}
		return $ret_val;
	
	}

	function _getServicesBar()
	{
		$registry = Registry::start();
		$table = html_table(Session::getContextValue("mainInterfaceWidth"),0,1);
		//$table->set_tag_attribute('bgcolor', '#CECECE');
		//$table->set_class("mainInterfaceWidth");
		//$table->set_id("header");
		$row = html_tr();

		$arr_elem = $registry->listServices();
		//$arr_elem = $this->_getBarrElementsbyFile();

		$profile = Session::getValue("userinfo_profile_id");
		//Debug::oneVar($profile, __FILE__, __LINE__);

		foreach ($arr_elem as $app => $params) {
			if($registry->checkServiceAccess($params[0], $profile)){
				if(strncmp($params[1], 'http://', 7) != 0) {
					$row->add($this->_getBarElement(Util::format_URLPath($params[1], $params[2]),
													$params[4]));
				} else {
					$row->add($this->_getBarElement($params[1], $params[4]));
				}
			}
		}

		$table->add_row($row);
		
		return $table;
	}

	function _getBarElement($url, $literal, $accesskey = '', $tabindex = 0)
	{
		$link = html_a($url, $literal);
		//$link->set_tag_attribute('accesskey',$accesskey);
		//$link->set_tag_attribute('tabindex', $tabindex);
		//$elem = html_td("", "", $link);
		$elem = html_td('', "", $link);
		//$elem->set_id("cell-sitename");
		//$elem->set_tag_attribute("target","_blank");
	
		return $elem;
	}

	function _getShowElement($literal, $accesskey = '', $tabindex = 0)
	{
		//$link = html_a($url, $literal);
		$link = $literal;
		//$link->set_tag_attribute('accesskey',$accesskey);
		//$link->set_tag_attribute('tabindex', $tabindex);
		$elem = html_td("", "", $link);
		$elem = html_td("colorMedium-bg", "", $link);
		$elem->set_id("cell-sitename");
		$elem->set_tag_attribute("target","_blank");

		return $elem;
	}

	function imag_ref($path_action, $path_img, $text, $width = 0, $height = 0, $border = 0)
	{
		$table = html_table("100%",0,1,0,"left");
		$row = html_tr();
		$row->set_tag_attribute("align","center");
		$col = html_td("","left");
		$col->set_tag_attribute("width","20%");
		$elem = html_a($path_action,"");
		$elem->add(html_img($path_img, $width, $height, $border));
		$col->add($elem);
		$row->add($col);
		$col = html_td("","left");
			$col->set_tag_attribute("width","80%");
		$col->add(html_a($path_action,$text));
		$row->add($col);
		$table->add($row);
	
		return $table;
	}

    function icon_link($path_action, $path_img, $text, $class, $width = null, $height = null, $border= null)
    {
            $container = new container(); //html_div();
                //$container->set_tag_attribute('valign', 'center');

            $icon_link = html_a($path_action,"");
                $icon_link->add(html_img($path_img, $width, $height, $border));

        $container->add($icon_link);
        $container->add(html_a($path_action,$text, $class));

        return $container;
    }

    function help_img($path_action, $path_img, $text)
    {
            $table = html_table("100%",0,1,0);
            $row = html_tr();

            if($text == ''){
                    $col = html_td("","center");
                    $elem = html_a("#","");
                $elem->add(html_img($path_img, 0, 0, 0, ""));
                $elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=500,height=600,left=300,top=40'); return false;");
                $col->add($elem);
                $row->add($col);
            } else {
                    $table->set_tag_attribute("align","left");
                    $row->set_tag_attribute("align","left");
                    $col = html_td("","left");
                    $col->set_tag_attribute("width","20%");
                    $elem = html_a("#","");
                $elem->add(html_img($path_img, 0, 0, 0, ""));
                $elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
                $col->add($elem);
                $row->add($col);

                $col = html_td("","left");
                    $col->set_tag_attribute("width","80%");
                    $elem = html_a("#",$text);
                    $elem->set_tag_attribute("onClick", "MyWindow=window.open('".$path_action."','MyWindow','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=400,height=500,left=300,top=10'); return false;");
                $col->add($elem);
                $row->add($col);

        }
        $table->add($row);

        return $table;
    }

    function imag_alone($path_action, $path_img, $text, $width = null, $height = null, $border = null)
    {
            $elem = html_a($path_action,"",null,null,$text);
        $elem->add(html_img($path_img, $width, $height, $border, $text));

        return $elem;
    }

    function _ShowMailURL($email, $name, $text = '')
        {
                if ( isset($email)  && ($email != '') ) {
                        $a_ref = Util::format_URLPath("lib/app/messages/sendmail.php", "&sendTo=$email");
                        $a_text = $name;
         } else {
                 $a_ref = "mailto:$email";
                        $a_text = $name;
        }

        return $this->_tdBlock($text, $a_ref, $a_text);
        }

    function _tdBlock($text, $a_ref, $a_text, $br_num = 1)
    {
            $container = container( $text, html_a($a_ref, $a_text), html_br($br_num));
                return $container;
    }

    function _menuBar()
    {
            $ret_val = '';

            /*
        $menu[]= array ("url" => Util::format_URLPath("lib/index.php"), "name" => Session::getContextValue("siteName"));
            //$menu = array_merge ($menu, $this->getViewVariable("menubar"));
            $menu = array_merge ($menu, $this->getSessionElement('bar_array'));
            */

            $menu = $this->getSessionElement('bar_array');
            if (is_array($menu)) {
                        $ret_val = container();
                for($i=0; $i < count($menu) -1; $i++) {
                        $ret_val->add(html_a($menu[$i]["url"], $menu[$i]["name"], null, "_top"));
                        $ret_val->add(">");
                }
                $ret_val->add(html_a($menu[count($menu) - 1]["url"], $menu[count($menu) - 1]["name"], null, "_top"));
        }
        return $ret_val;

    }

        function addMessagePopup($_to_alias)
        {
                return $this->addPopup('email/index.php',
                                                        'sobre_cerrado.gif',
                                                        'wm&status=new&to='.$_to_alias,
                                                        agt('Correo para'),
                                                        850, 350, 25, 100);
        }

        function addCardPopup($_id)
        {
                return $this->addPopup('userProfile/index.php',
                                                        'icono04.gif',
                                                        'wm&personid='.$_id,
                                                        agt('Perfil'),
                                                        950, 600, 25, 100);
        }

        function _setMessageWindow()
        {
                $this->bol_normal = false;
				//$this->str_type = 'toolbar';

                /*

                if(Session::issetValue('wm')){
                        //$exec = html_script('javascript:cerrar();', 'text/javascript');
                        $exec = html_script('javascript:newWinClose();', 'text/javascript');
                         $this->add($exec);
                        Session::unsetValue('wm');
                } else {
                        Session::setValue('wm', true);
                }
                */
        }
	
	function setDefaultType()
	{
		$this->str_type = 'toolbar';
	}
}
?>
