<?php
/*
      +----------------------------------------------------------------------+
      |email                                                        |
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
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage view
 * @version 1.0.0
 *
 */ 

/**
 * Include classes library
 */
include_once (Util::app_Path("common/view/classes/miguel_vmenu.class.php"));
class miguel_VEmail extends miguel_VMenu
{
    function miguel_VEmail($title, $arr_commarea)
    {
        $this->miguel_VMenu($title, $arr_commarea);
     }

	function add_head($from_to, $bStatus)
	{
		$row = html_tr();
		$row->set_class('ptabla01');
		
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		
		if ($bStatus) {
			$row->add(html_td('ptabla01', "", _HTML_SPACE));
		}
		
		$row->add(html_td('ptabla01', "", html_b($from_to)));
		$row->add(html_td('ptabla01', "", html_b('Asunto')));
		$row->add(html_td('ptabla01', "", html_b('Fecha')));
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		$row->add(html_td('ptabla01', "", html_b('Conectado')));
			
		return $row;
	}
	
	function add_botom($bStatus)
	{
		$row = html_tr();
		$row->set_class('ptabla01');
		
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		
		if ($bStatus) {
			$row->add(html_td('ptabla01', "", _HTML_SPACE));
		}
		
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
		$row->add(html_td('ptabla01', "", _HTML_SPACE));
			
		return $row;
	}

	function add_emailInfo($_text_from, $_from, $_subject, $_date, $_id_msg, $_log, $_mailStatus=-1)
	{
		$row = html_tr();
		$row->set_class('ptabla03');
		$row->set_id('');      
		$status=$this->getViewVariable('status');
		$from = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=new&arrto=$_from&to=$_text_from"),$_text_from, 'titulo03a'));
		$subject = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_subject, 'titulo03a'));
		//$date = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=show&id=$_id_msg"),$_date, 'titulo03a'));
		$date = html_td('', '', $_date);
		//$delete = html_td('', '', html_a(Util::format_URLPath('email/index.php',"status=$status&delete_id=$_id_msg"),'Delete', 'titulo03a'));
		$delete = html_td('', '', $this->imag_alone(Util::format_URLPath('email/index.php',"status=$status&delete_id=$_id_msg"), 
								Theme::getThemeImagePath('boton_papelera.gif'), agt('Delete')));
								
		if($_log){
			$img_type =  html_img(Theme::getThemeImagePath('conectado.gif'), 23, 20, 0);
		} else {
			$img_type =  html_img(Theme::getThemeImagePath('desconectado.gif'), 23, 20, 0);
		}
		$conectado = html_td('', '', $img_type);
								
		
		//Aqui debe ir el tratamiento de adjuntos
		$row->add(_HTML_SPACE);
		
		switch ($_mailStatus) {
			case 0: //No leído
				$row->add(html_img(Theme::getThemeImagePath('sobre_cerrado.gif')));		  
				break;
			case 1: //Leído
				$row->add(html_img(Theme::getThemeImagePath('sobre_abierto.gif')));		  
				break;		  
			case 2: //Respondido
				$row->add(html_img(Theme::getThemeImagePath('sobre_reenviado.gif')));		  
				break;		  
		}

		$from->set_tag_attribute("width","20%");
		$subject->set_tag_attribute("width","50%");
		$date->set_tag_attribute("width","20%");
		$delete->set_tag_attribute("width","5%");
		//$conectado->set_tag_attribute("width","5%");

		
		$row->add($from);
		$row->add($subject);
		$row->add($date);
		$row->add($delete);
		$row->add($conectado);
		
		return $row;
	}
		
	function add_inbox()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$arrMessages = $this->getViewVariable('arrMessages');

		if ($arrMessages[0]['user.user_alias']!=null) {
			$table->add($this->add_head('De', true));
			for ($i=0; $i<count($arrMessages); $i++) {
				//Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
				$table->add($this->add_emailInfo($arrMessages[$i]['person.person_name'] . ' ' . 			 $arrMessages[$i]['person.person_surname'], 
							$arrMessages[$i]['user.user_id'],
							$arrMessages[$i]['message.subject'],
							$arrMessages[$i]['message.date'],
							$arrMessages[$i]['message.id'],
							$arrMessages[$i]['is_logged'],
							$arrMessages[$i]['receiver_message.status']));
			}
		} else {
			$table->add(html_td('ptabla02', '', 'La carpeta está vacía'));
		}
		$table->add($this->add_botom(true));
	
		return $table;
	}

	function add_outbox()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$arrMessages = $this->getViewVariable('arrMessages');

		//Si no está vacía
		if ($arrMessages[0]['user.user_alias']!=null) {
			$table->add($this->add_head('Para', false));
		
			for ($i=0; $i<count($arrMessages); $i++) {
				//Debug::oneVar($arrMessages[$i], __FILE__, __LINE__);
				$table->add($this->add_emailInfo($arrMessages[$i]['person.person_name'] . ' ' .$arrMessages[$i]['person.person_surname'],
							$arrMessages[$i]['user.user_alias'],
							$arrMessages[$i]['message.subject'],
							$arrMessages[$i]['message.date'],
							$arrMessages[$i]['message.id'],
							$arrMessages[$i]['is_logged']));
			}
		} else {
			$table->add(html_td('ptabla02', '', 'La carpeta está vacía'));
		}
		$table->add($this->add_botom(false));
	
		return $table;
	}

	function add_mailDetails()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);

		$table->add_row(html_td('ptabla02','','De: ' . $this->getViewVariable('from')));
		$table->add_row(html_td('ptabla02','','Para: ' . $this->getViewVariable('to')));
		$table->add_row(html_td('ptabla02','','Hora: ' . $this->getViewVariable('date')));
		$table->add_row(html_td('ptabla02','','Asunto: ' . $this->getViewVariable('subject')));
		$table->add_row(html_td('ptabla03','',nl2br($this->getViewVariable('body'))));	
		return $table;
	}

	function add_bin()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		$arrMessages = $this->getViewVariable('arrMessages');
		
		if ($arrMessages[0]['user.user_alias']!=null) {
			$table->add($this->add_head('De/Para',false));
			for ($i=0; $i<count($arrMessages); $i++) {
				$table->add($this->add_emailInfo($arrMessages[$i]['person.person_name'] . ' ' .$arrMessages[$i]['person.person_surname'],
								$arrMessages[$i]['user.user_alias'],
								$arrMessages[$i]['message.subject'],
								$arrMessages[$i]['message.date'],
								$arrMessages[$i]['message.id'],
								$arrMessages[$i]['is_logged']));
			}
		} else {
			$table->add(html_td('ptabla02', '', 'La carpeta está vacía'));
		}
		$table->add($this->add_botom(false));

		return $table;
	}

	function add_menu()
	{
		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
		
		if($this->issetViewVariable('countUnreaded') && $this->getViewVariable('countUnreaded') != 0){
			$strUnreaded = '('.$this->getViewVariable('countUnreaded').')';
		} else {
			$strUnreaded = '';
		}
		$table->add_row(html_td('ptabla01', '', _HTML_SPACE));
		//$table->add_row(html_td('ptabla02','', $this->icon_link(Util::format_URLPath('email/index.php', 'status=inbox'), 
		//						Theme::getThemeImagePath('bandeja_entrada.gif'),agt('Carpeta de entrada ') . $strUnreaded, 'titulo03a')));
		$table->add_row(html_td('ptabla02','', html_a(Util::format_URLPath('email/index.php',"status=inbox"),
								agt('Carpeta de entrada ') . $strUnreaded, 'titulo02a')));
		//$table->add_row(html_td('ptabla02','',$this->icon_link(Util::format_URLPath('email/index.php', 'status=outbox'), 
		//						Theme::getThemeImagePath('bandeja_salida.gif'), agt('Bandeja de salida'), 'titulo03a')));
		$table->add_row(html_td('ptabla02','', html_a(Util::format_URLPath('email/index.php',"status=outbox"),
								agt('Bandeja de salida'), 'titulo02a')));
		//$table->add_row(html_td('ptabla02','',$this->icon_link(Util::format_URLPath('email/index.php', 'status=bin'), 
		//						Theme::getThemeImagePath('elementos_eliminados.gif'), agt('Papelera'), 'titulo03a')));
		$table->add_row(html_td('ptabla02','', html_a(Util::format_URLPath('email/index.php',"status=bin"),
								agt('Papelera'), 'titulo02a')));
		$table->add_row(html_td('ptabla02','', html_a(Util::format_URLPath('pageViewer/index.php',"url=contactos_alumno.htm"),
								agt('Contactos'), 'titulo02a')));
		$table->add_row(html_td('ptabla01','', _HTML_SPACE));
		$table->add_row(html_td('', '', _HTML_SPACE));
		//$table->add_row(html_td('ptabla03','',$this->icon_link(Util::format_URLPath('email/index.php', 'status=new'), 
		//						Theme::getThemeImagePath('redactar_mensaje.gif'), agt('Redactar correo'), 'titulo03a')));
		$table->add_row(html_td('ptabla03','', html_a(Util::format_URLPath('email/index.php',"status=new"),
								agt('Enviar correo'), 'titulo03a')));
		return $table;
	}

    function right_section() 
    {
		$div = html_div();
		
		switch($this->getViewVariable('status')) {
			case 'new':
				if ($this->issetViewVariable('strResult')) {
					$container = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
					$container->add_row(html_td('ptabla03','', $this->getViewVariable('strResult')));
					$container->add_row(html_td('','', html_a(Util::format_URLPath('email/index.php', 'status=inbox'), agt('Carpeta de entrada'),'p')));
					$div->add($container);
				} else {
					$div->add($this->addForm('email', 'miguel_emailForm'));
				}
				break;
			case 'show':
				$div->add($this->add_mailDetails());
				break;
			case 'outbox':
				$div->add($this->add_outbox());
				break;
			case 'bin':
				$div->add($this->add_bin());
				break;
			case 'inbox':
			default:
				$div->add($this->add_inbox());
				break;
		}
		return $div;
    }
    
    function right_block() 
    {
		//Crea el contenedor del right_block
		$main = container();
		$main->add(html_br());
		$main->add($this->add_mainMenu());
		$main->add(html_br());
		
		$table = html_table(Session::getContextValue('mainInterfaceWidth'),0,1,3);
		//$table->set_class('simple');		
		$elem1 = html_td('', '', $this->left_section());
		$elem1->set_tag_attribute('width', '20%');
		$elem1->set_tag_attribute('valign', 'top');
		$elem2 = html_td('', '',$this->right_section());
		$elem2->set_tag_attribute('valign', 'top');
		
		$row = html_tr();
		$row->add($elem1);
		$row->add($elem2);
		
		$table->add_row($row);
		
		$main->add( $table );
		
		return $main;
    }

    function left_section()
    {
		$div = html_div();
		$div->add($this->add_menu());    
		return($div);
    }
	
	function add_mainMenu()
	{
		$div = html_div('');

		$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,0,0);
		$row = html_tr();
		$blank = html_td('', '', html_img(Theme::getThemeImagePath("invisible.gif"),10,10));
		//$blank->set_tag_attribute('colspan','4');

		$image = html_td('', '',  html_img(Theme::getThemeImagePath("invisible.gif"), 20, 14));
		$image->set_tag_attribute('align', 'right');
		$image->set_tag_attribute('width', '40%');

		$link = html_a(Util::format_URLPath('email/index.php', 'status=new'), agt('Enviar correo'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item1 = html_td('', '', $link);
		$item1->set_tag_attribute('width', '20%');

		$link = html_a(Util::format_URLPath('pageViewer/index.php',"url=contactos_alumno.htm"), agt('Contactos'), null, "_top");
		$link->set_tag_attribute('class', '');
		$item2 = html_td('', '', $link);
		$item2->set_tag_attribute('width', '20%');

		$row->add($blank);
		$row->add($image);
		$row->add($item1);
		$row->add($item2);
		$row->add($item3);

		$table->add_row($row);

		$div->add($table);

		return $div;
	}

}
?>
