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
      | Authors: Miguel Majuelos Mudarra <www.polar.es> 				     |
      |          Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Esta clase se encarga de gestionar el formulario para accesos
 * de usuarios a la plataforma miguel
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author  Antonio F. Cano Damas <antoniofcano@telefonica.net>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package miguel main
 * @version 1.0.0
 */
include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));
 
class miguel_calendarForm extends miguel_FormContent
{
    /**
     * Este metodo se llama cada vez que se instancia la clase.
     * Se utiliza para crear los objetos del formulario
     */
    function form_init_elements() 
    {
        //we want an confirmation page for this form.
        //$this->set_confirm();
		//Crea una caja de texto llamada nombre y longitud 50
/*        $elemD = new FEDate("Fecha del evento", FALSE,"","","dmy");
        //$elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemD->set_attribute("class",'ptabla03');
        $elemD->set_attribute("id","fecha");
        $elemD->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemD);
*/
      //Crea una caja de texto llamada nombre y longitud 50
        $elemDI = new FEText('Fecha Inicial', FALSE, 10);
        //$elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemDI->set_attribute("class",'ptabla03');
        $elemDI->set_attribute("id","fecha_inicial");
        $elemDI->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemDI);

         $elemDF = new FEText('Fecha Final', FALSE, 10);
        //$elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemDF->set_attribute("class",'ptabla03');
        $elemDF->set_attribute("id","fecha_final");
        $elemDF->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemDF);

		
        //Crea una caja de texto llamada nombre y longitud 50
        $elemT = new FEText("Asunto", FALSE, 50);
        //$elemT->set_style_attribute('align', 'right');
        //Le asignamos el id nombre y la tecla de acceso n (ctrl+n)
        $elemT->set_attribute("class",'ptabla03');
        $elemT->set_attribute("id","asunto");
        $elemT->set_attribute("accesskey","n");         
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemT);
        	
		//Creamos un Area de Texto llamada comentario
		$elemLE = new FEListBox("Tipo de Evento", FALSE, "200px", NULL, $this->getViewVariable('events'));
        $elemLE->set_attribute('wrap', 'physical');
        //Le asignamos el id email y la tecla de acceso c (ctrl+c)        
        $elemLE->set_attribute("class",'');
        $elemLE->set_attribute("id","eventos");
        $elemLE->set_attribute("accesskey","d");
        //Añade en el contenedor formulario el elemento creado e inicializado
        $this->add_element($elemLE);
			
        //Añade un campo oculto llamado id. En ocasiones este campo se utiliza para indicar ciertas operaciones.
        //OJO!! es un punto sensible porque el usuario podría cambiar su valor de forma inexperada para el código.
//        $this->add_hidden_element("id");

        //Añade un boton con la acción submit
        $submit = $this->_formatElem("base_SubmitButton", "Aceptar", "submit", 'A�adir');
        //$submit->set_attribute('id',''); 
        $submit->set_attribute('class','p');
        $submit->set_attribute('accesskey','e');               
        $this->add_element($submit);    
				
		$this->add_hidden_element('status');
    	$this->set_hidden_element_value('status', 'new');
    }

    /**
     * Este metodo asigna valores a los diferentes objetos creados para el formulario.
     * Es necesario dar un valor inicial de tipo explicativo, para que sirva de guía al usuario al completar el formulario
     * Solo se llama una vez, al instanciar esta clase
     */
    function form_init_data() 
    {
		$this->set_element_value("Asunto", agt("miguel_calendarSubject"));
	   $this->set_element_value('Fecha Inicial', $this->getViewVariable('fini'));
	   $this->set_element_value('Fecha Final', $this->getViewVariable('ffin'));
    }


    /**
     * Este metodo construye el formulario que se va a mostrar en la Vista.
     * Formatea la forma en que se va a mostrar al usuario los distintos elementos del formulario.
     */
    function form() 
    {
    	  //El formateo va a ser realizado sobre una tabla en la que cada fila es un campo del formulario
        $table = &html_table($this->_width,0,2,2);
		//titulo
		$table->add_row($this->add_head());		


	    $fechaIni = $this->_showElement('Fecha Inicial', '5', 'dia_inicial', '(dd-mm-yyyy)', 'Fecha Inicial', "left" );
	    $fechaFin = $this->_showElement('Fecha Final', '6', 'dia_final', '(dd-mm-yyyy)', 'Fecha Final', "left" );
		$tipo = $this->_showElement("Tipo de Evento", '7', "event", 'Tipo de Evento', "Tipo de Evento", "left" );
		$asunto = $this->_showElement("Asunto", '8', "asunto_de_usuario", 'Asunto del Evento', "Asunto", "left" );

		$fechaIni->set_class('ptabla03');
		$fechaFin->set_class('ptabla03');
		$tipo->set_class('ptabla03');
		$asunto->set_class('ptabla03');
		
		$tableIni = &html_table(($this->_width)/4,0,2,2);
		$tableIni->set_class('ptabla03');
		$tableIni->add_row($fechaIni, $this->get_img_cal(true));

		//Fecha Fin
		$tableFin = &html_table(($this->_width)/4,0,2,2);
		$tableFin->set_class('ptabla03');
		$tableFin->add_row($fechaFin, $this->get_img_cal(false));

		$table->add_row($tableIni, $tableFin, $tipo, $asunto);		

		
	    $this->set_form_tabindex("Aceptar", '10'); 
        $label = html_label( "submit" );
        $label->add($this->element_form("Aceptar"));
        $table->add_row(html_td("", "left",  $label));
        
        return $table; 
    }

	//Devuelve el enlace de calendario 
	//Si bInicio=true devuelve el de inicio, si no el de final
	function get_img_cal($bInicio)
	{
		if ($bInicio) {
			$varRead = 'ffin';
			$varWrite = 'fini';
		} else {
			$varRead = 'fini';
			$varWrite = 'ffin';
		}

		$strLink = Util::format_URLPath('courseTask/index.php');
		$dateR = $this->getViewVariable($varRead);
		if (isset($dateR)) {
			$strAddParam = '&' . $varRead . '=' . $dateR;
		} 

		$link =  $this->addPopup('dateSelect/index.php',
										 'calendario.gif', 
										 "wm&link=$strLink&param=$varWrite$strAddParam", 
										'calendario', 
										200, 200, 100, 100);
	
/*		$link =  $this->addPopup('email/index.php',
										 'calendario.gif', 
										 'status=new&arrto=10', 
										'calendario', 
										400, 400, 100, 100);
*/	

		$img_cal = html_td('ptabla03', '', $link);
		return($img_cal);
	}

	function add_head()
	{
		$row = html_tr();

		//Fecha Inicial
		$diaIni = html_td('ptabla02', '', 'Fecha Inicial');
		$diaIni->set_tag_attribute('width','15%');	
		$row->add($diaIni);

		//Fecha Inicial
		$diaFin = html_td('ptabla02', '', 'Fecha Final');
		$diaFin->set_tag_attribute('width','15%');	
		$row->add($diaIni);

		//Tipo		
		$type = html_td('ptabla02', '', 'Tipo');
		$type->set_tag_attribute('width','15%');	
		$row->add($type);
		
		$row->add(html_td('ptabla02', '', 'Tarea'));
		
		return $row;
	}
}

?>

