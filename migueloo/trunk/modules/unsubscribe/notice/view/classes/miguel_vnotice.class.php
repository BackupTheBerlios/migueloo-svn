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
 * Define la clase para la pantalla principal de miguel.
 *
 * Se define una plantilla comÀôn para todas las pantallas de miguel:
 *  + Bloque de cabecera en la parte superior.
 *  + Bloque central, donde se presentar¬∑ la informaci√õn
 *  + Bloque de pie en la parte inferior
 *
 * --------------------------------
 * |         header block         |
 * --------------------------------	
 * |                              |	
 * |         data block           |
 * |                              |
 * --------------------------------	
 * |         footer block         |
 * --------------------------------
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
class miguel_VNotice extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El t√åtulo para la p¬∑gina
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesi√õn).
     *
	 */
    function miguel_VNotice($title, $arr_commarea)
    {
        //Ejecuta el constructor de la superclase de la Vista
        $this->miguel_VMenu($title, $arr_commarea);
     }

		/**
		* Devuelve una table con la noticia $i del array de noticias $notice_array
		*
		*/
		function add_notice($author, $subject, $time, $notice_id)
		{
        $table = &html_table(Session::getContextValue("mainInterfaceWidth"),0,2,2);
				$nombre = html_td('', '', html_a(Util::format_URLPath('notice/index.php',"status=show&id=$notice_id"),$author));
			  $nombre->set_tag_attribute('bgcolor','#808000');
			  $nombre->set_tag_attribute('width','80%');
				$tiempo = html_td('', '', html_a(Util::format_URLPath('notice/index.php',"status=show&id=$notice_id"),$time));
			  $tiempo->set_tag_attribute('bgcolor','#99CE99');
			  $tiempo->set_tag_attribute('align','right');
				$subject = html_td('', '', html_a(Util::format_URLPath('notice/index.php',"status=show&id=$notice_id"),$subject));
			  $subject->set_tag_attribute('bgcolor','#99CE99');
			  $subject->set_tag_attribute('colspan',2);
 			 	$table->add_row($nombre, $tiempo); 		 	
			 	$table->add_row($subject); 
 			 	return $table;
		}
    
    /*=========================================================
			Muestra la lectura de un mensaje
		===========================================================*/
		function add_noticeDetails()
		{
				$table = &html_table(Session::getContextValue('mainInterfaceWidth'),0,2,2);
				if ($this->issetViewVariable('author'))
				{
					$table->add(html_b('From: '));
					$table->add($this->getViewVariable('author'));
					$table->add(html_br(2));
					$table->add(html_b('Time: '));
					$table->add($this->getViewVariable('time'));
					$table->add(html_br(2));
					$table->add(html_b('Subject: '));
					$table->add($this->getViewVariable('subject'));
					$table->add(html_br(2));
					$table->add(html_b('Text: '));
					$table->add($this->getViewVariable('text'));	
				}
				else
				{
					$table->add('No se ha encontrado el mensaje especificado.');
				}
				return $table;
		}
    
    /**
     * this function returns the contents
     * of the right block.  It is already wrapped
     * in a TD
     * Solo se define right_block porque heredamos de VMenu y el left_block se encuentra ya definido por defecto con el men˙ del sistema.
     * Si heredara de miguel_VPage entonces habrÌa que definir de igual forma right_block y main_block. Esta ˙ltima es un contenedor de left_block y right_block
     * @return HTMLTag object
     */
    function right_block() 
    {
        //Crea el contenedor del right_block
        $ret_val = container();
		
        //Vamos a ir creando los distintos elementos (Estos a su vez son tambiÈn contenedores) del contenedor principal.
        //hr es una linea horizontal de HTML.
        $hr = html_hr();
        $hr->set_tag_attribute('noshade');
        $hr->set_tag_attribute('size', 2);

        //Añade la linea horizontal al contenedor principal
        $ret_val->add($hr);
		
        //Crea un bloque div y le asigna la clase ul-big del CSS
        $div = html_div();

        //Añade una imagen del tema
        $div->add(Theme::getThemeImage('modules/announces.png'));

        //Incluimos texto en negrita
        $div->add(html_b('Tabl�n de anuncios'));

        //Ahora dos retornos de carro
        $div->add(html_br(2));

        //$ret_val->add($div);
		
        //$div = html_div('medium-text');
        
        $status = $this->getViewVariable('status');
        switch($status)
        {
        	case 'menu':
        	default:  		    		 			
        				 $div->add($this->icon_link(Util::format_URLPath('notice/index.php', 'status=new'), 
								 					Theme::getThemeImagePath('modules/announces.png'), /*agt('miguel_Module') . */'Nuevo Mensaje'));
								 $div->add(html_br(2));
        				 $div->add($this->icon_link(Util::format_URLPath('notice/index.php', 'status=list'), 
								 					Theme::getThemeImagePath('modules/announces.png'), /*agt('miguel_Module') .*/'Ver Mensajes'));
								 $div->add(html_br(2));
 				         $ret_val->add($div);
        				break;
        	
        	case 'new':      
           			//Incluye en el Div un texto. Usa la funciÛn agt('etiqueta') para internacionalizar
           			//$div->add(agt('miguelNoticeText'));
   		    			//$div->add(html_br(2));
   		    			$ret_val->add($div);
                   
           			//Añadimos al contenedor principal el formulario de entrada de datos
           			$ret_val->add($this->addForm('notice', 'miguel_noticeForm'));
								break;
        	case 'list':
									$notice_array=($this->getViewVariable('notice_array'));
									for ($i=0; $i < count($notice_array); $i++) 
									{
										$div->add($this->add_notice($notice_array[$i]['notice.author'],
																								$notice_array[$i]['notice.subject'],
																								//$notice_array[$i]['notice.text'],
																								$notice_array[$i]['notice.time'],
																								$notice_array[$i]['notice.notice_id'])
																								);
										$div->add(html_br(2));
		 							}
					        $ret_val->add($div);
		 						break;
        	case 'show':
        					$ret_val->add($this->add_noticeDetails());
        				break;
        					

        }			
            
        
        //EnvÌa el contenedor del bloque right para que sea renderizado por el sistema
        return $ret_val;
    }
 
}

?>
