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
class miguel_VTodo extends miguel_VMenu
{

	/**
	 * This is the constructor.
	 *
	 * @param string $title  El t√åtulo para la p¬∑gina
	 * @param array $arr_commarea Datos para que utilice la vista (y no son parte de la sesi√õn).
     *
	 */
    function miguel_VTodo($title, $arr_commarea)
    {
        //Ejecuta el constructor de la superclase de la Vista
        $this->miguel_VMenu($title, $arr_commarea);
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
        $div = html_div('ul-big');

        //Añade una imagen del tema
        $div->add(Theme::getThemeImage("menu/idea.png"));

        //Incluimos texto en negrita
        $div->add(html_b('Sugerencias'));

        //Ahora dos retornos de carro
        $div->add(html_br(2));

        $ret_val->add($div);
		
        $div = html_div('medium-text');
        if($this->getViewVariable('bol_cuestion')){
            //Incluye en el Div un texto. Usa la funciÛn agt('etiqueta') para internacionalizar
            $div->add(agt('miguelTodoText'));
    		    $div->add(html_br(2));
    		    $ret_val->add($div);
                    
            //Añadimos al contenedor principal el formulario de entrada de datos
            $ret_val->add($this->addForm('todo', 'miguel_todoForm'));
        } else {
            //Muestra en el Div el texto con los datos insertados
            $div->add(agt('miguelInsertTodo'));
            $div->add(html_br(2));
            $ret_val->add($div);

            //getContextValue obtiene un par·metro de config.xml
            $table = &html_table(Session::getContextValue("mainInterfaceWidth"),0,2,2);

            //add_row aÒade una fila a la tabla, html_td crea un contenedor celda de la fila
            $table->add_row(html_td("", "", container(html_b(agt('miguelTodoNombre')), $this->getViewVariable('sug_nombre'))));
            $table->add_row(html_td("", "", container(html_b(agt('miguelTodoMail')), $this->getViewVariable('sug_email'))));
            $table->add_row(html_td("", "", container(html_b(agt('miguelTodoComment')), html_br(), $this->getViewVariable('sug_comentario'))));
            $ret_val->add($table);

            //AÒade al contenedor principal un formulario
            $ret_val->add($this->addForm('common', 'miguel_navForm'));
        }

        //EnvÌa el contenedor del bloque right para que sea renderizado por el sistema
        return $ret_val;
    }
 
}

?>
