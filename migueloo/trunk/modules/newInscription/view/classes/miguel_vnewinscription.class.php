<?php
/*
      +----------------------------------------------------------------------+
      |newInscription/view                                                   |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
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
 * Define la clase para la pantalla principal de miguel.
 *
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
include_once (Util::app_Path("common/view/classes/miguel_vbase.class.php"));

class miguel_VNewInscription extends miguel_VBase
{
    function miguel_VNewInscription($title, $arr_commarea)
    {
        //Debug::oneVar($arr_commarea, __FILE__, __LINE__);
        $this->miguel_VBase($title, $arr_commarea);
		$this->add_css_link(Theme::getThemeCSSPath('estilo.css'));
     }

    function main_block()
    {
        $content = container();
		//$hr = html_hr();
		//$hr->set_tag_attribute("noshade");
		//$hr->set_tag_attribute("size", 2);
		//$ret_val->add($hr);

		$content->add(html_h4(agt('Preinscripción')));
		$content->add(html_br());
		
		if ($this->issetViewVariable('strError')) {
			$strError=$this->getViewVariable('strError');
			$ret_val->add(html_b(agt('Falta de informar los siguientes campos obligatorios: ').$strError));
			$ret_val->add(html_br(2));
		}

		if ($this->issetViewVariable('newclient') && $this->getViewVariable('newclient') == 'ok') 
		{	
            $content->add(html_h2(agt('Preinscripción de usuario correcta.')));
			$content->add(html_a(Util::format_URLPath('main/index.php'), agt('Volver')));
		} else {
			$content->add($this->addForm('newInscription', 'miguel_inscriptionForm'));
		}
		$ret_val = html_table(Session::getContextValue("mainInterfaceWidth"),0,1,0);
		
		$ret_val->add_row(html_td('','',_HTML_SPACE), html_td('','',$content), html_td('','',_HTML_SPACE));
		return $ret_val;
    }
}

?>
