<?php
/*
      +----------------------------------------------------------------------+
      |notice/view                                                           |
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
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));

class miguel_VNotice extends miguel_VMenu
{
	function miguel_VNotice($title, $arr_commarea)
	{
		$this->miguel_VMenu($title, $arr_commarea);
	}

	function add_notice($author, $subject, $time, $notice_id)
	{
		$row = html_tr();
		
		$nombre = html_td('ptabla03', '', $author);
		$subject = html_td('ptabla03', '', html_a(Util::format_URLPath('notice/index.php',"status=show&id=$notice_id"),$subject, 'titulo03a'));
		$tiempo = html_td('ptabla03', '', $time);
		
		$row->add($nombre);
		$row->add($subject);
		$row->add($tiempo);
		
		return $row;
	}
	
	function add_noticeHead()
	{
		$row = html_tr();

		$from = html_td('ptabla01', '', agt('De'));
		$subject = html_td('ptabla01', '', agt('Aviso'));
		$date = html_td('ptabla01', '', agt('Fecha'));

		$from->set_tag_attribute('width','20%');
		$subject->set_tag_attribute('width','60%');
		$date->set_tag_attribute('width','20%');

		$row->add($from);
		$row->add($subject);
		$row->add($date);

		return $row;
	}

	function add_noticeDetails()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		if ($this->issetViewVariable('author')) {
			$table->add_row(html_td('ptabla02','','De: ' . $this->getViewVariable('author')));
			$table->add_row(html_td('ptabla02','','Hora: ' . $this->getViewVariable('time')));
			$table->add_row(html_td('ptabla02','','Asunto: ' . $this->getViewVariable('subject')));
			$table->add_row(html_td('ptabla03','',nl2br($this->getViewVariable('text'))));
		} else {
			$table->add('No se ha encontrado el mensaje especificado.');
		}
		
		return $table;
	}

    function right_block()
    {
		$ret_val = container();
	
		$div = html_div();
		$div->add(html_br());
	
		$titulo = html_p('Tablón de anuncios');
		$titulo->set_class('ptabla01');
		$div->add($titulo);
	
		$status = $this->getViewVariable('status');
		switch($status)
		{
			case 'menu':
			default:
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$table->add_row(html_td('ptabla02', '', $this->icon_link(Util::format_URLPath('notice/index.php', 'status=new'),
							Theme::getThemeImagePath('boton_siguiente.gif'), 'Nuevo Mensaje')));
				$table->add_row(html_td('ptabla02','', $this->icon_link(Util::format_URLPath('notice/index.php', 'status=list'),
							Theme::getThemeImagePath('boton_siguiente.gif'), 'Ver Mensajes')));
				$div->add($table);
				$ret_val->add($div);
				break;

			case 'new':
				$ret_val->add($div);

				$ret_val->add($this->addForm('notice', 'miguel_noticeForm'));
				break;
			case 'list':
				$notice_array=($this->getViewVariable('notice_array'));
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				$table->add($this->add_noticeHead());
				
				for ($i=0; $i < count($notice_array); $i++)
				{
						$table->add($this->add_notice($notice_array[$i]['notice.author'],
							$notice_array[$i]['notice.subject'],
							//$notice_array[$i]['notice.text'],
							$notice_array[$i]['notice.time'],
							$notice_array[$i]['notice.notice_id'])
							);
					
				}
				$div->add($table);
				$ret_val->add($div);
				break;
			case 'show':
				$ret_val->add($this->add_noticeDetails());
				break;
		}
        
		return $ret_val;
    }
}
?>
