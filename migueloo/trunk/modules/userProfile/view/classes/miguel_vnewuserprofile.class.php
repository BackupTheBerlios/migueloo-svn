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
	  | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
	  |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
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
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VNewUserProfile extends miguel_VMenu
{
	function miguel_VNewUserProfile($title, $arr_commarea)
	{
		$this->miguel_VMenu($title, $arr_commarea);
	}

    function add_mainMenu()
    {
            $div = html_div('');
            $div->add(html_br());

            $table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
            $row = html_tr();
            $blank = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
            //$blank->set_tag_attribute('colspan','4');

            $image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
            $image->set_tag_attribute('align', 'right');
            $image->set_tag_attribute('width', '40%');

            $link = html_a(Util::format_URLPath("bibliography/index.php"), agt('Catálogo'), null, "_top");
            $link->set_tag_attribute('class', '');
            $item1 = html_td('', '', $link);
            $item1->set_tag_attribute('width', '20%');

            $link = html_a(Util::format_URLPath("bibliography/index.php",'status=ref'), agt('Referencias bibliográficas'), null, "_top");
            $link->set_tag_attribute('class', '');
            $item2 = html_td('', '', $link);
            $item2->set_tag_attribute('width', '20%');

            $link = html_a(Util::format_URLPath("bibliography/index.php", 'status=link'), agt('Enlaces de interés'), null, "_top");
            $link->set_tag_attribute('class', '');
            $item3 = html_td('', '', $link);
            $item3->set_tag_attribute('width', '20%');

            $row->add($blank);
            $row->add($image);
            $row->add($item1);
            $row->add($item2);
            $row->add($item3);

            $table->add_row($row);

            $div->add($table);

            return $div;
    }


	function right_block()
	{
		$content = container();

		//$content->add($this->add_mainMenu());

		$content->add(html_br());

		$content->add($this->content_section());
		
		return $content;
	}
	
	function content_section()
    {
        
        $content = container();
        
		if ($this->issetViewVariable('strError')) {
			$strError=$this->getViewVariable('strError');
			$content->add(html_b(agt('Falta de informar los siguientes campos obligatorios: ').$strError));
			$content->add(html_br(2));			
		}
		
		if ($this->issetViewVariable('userProfileSave') && $this->getViewVariable('userProfileSave') == 'noid') {
			$content->add(html_h2(agt('Usuario no existe.')));
			//$content->add(html_a(Util::format_URLPath('main/index.php'), agt('Volver')));	
		}else if ($this->issetViewVariable('userProfileSave') && $this->getViewVariable('userProfileSave') == 'ok') {	
			$content->add(html_h2(agt('Perfil usuario actualizado.')));
			$content->add($this->addForm('userProfile', 'miguel_userprofileForm'));
			//$content->add(html_a(Util::format_URLPath('userProfile/index.php'), agt('Volver')));
		}else{
			$content->add($this->addForm('userProfile', 'miguel_userprofileForm'));
		}        
        
        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

		$title = 'Perfil';

        $table->add_row(html_td('ptabla01', '', $title));
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla03', '', $content));
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla01pie', '', $title));

        return $table;
    }
    
    function detail_section()
    {
        $table = html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);

		$title = 'Perfil';

        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla01', '', $title));
        
 /*       $table->add_row(html_td('ptabla03', '', $content));
        $table->add_row(html_td('ptabla03', '', _HTML_SPACE));
        $table->add_row(html_td('ptabla01pie', '', $title));
*/
        return $table;
    }
}

?>
