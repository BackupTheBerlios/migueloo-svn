<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 *
 *
 * @author  Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>
 * @package miguel main
 * @version 1.0.0
 */

include_once (Util::app_Path("common/view/classes/miguel_formcontent.class.php"));

class miguel_externalForm extends miguel_FormContent
{
        var $file_path = '';

    function form_init_elements()
    {
                $arrElem = $this->getViewVariable('view_elem');
                $indexRadio = 0;

                if ($arrElem[0]['name']!=null)  { //Si no está vacío
                        for ($i=0; $i<count($arrElem); $i++){
                                switch($arrElem[$i]['type']) {
                                        case 1: //Text
                                                $arrObj[$i] = $this->_formatElem("FEText",
                                                                                        $arrElem[$i]['name'],
                                                                                        $arrElem[$i]['variable'],
                                                                                        FALSE,
                                                                                        50);
                                                $arrObj[$i]->set_attribute('class','ptabla03');
                                                break;
                                        case 2: //TextArea
                                                $arrObj[$i] = $this->_formatElem("FETextArea",
                                                                                        $arrElem[$i]['name'],
                                                                                        $arrElem[$i]['variable'],
                                                                                        FALSE,
                                                                                        10,
                                                                                        60,
                                                                                        '500px',
                                                                                        '100px');
                                                $arrObj[$i]->set_attribute('class','ptabla03');
                                                break;
                                        case 3: //ListBox
                                                //Componer la lista de valores
                                                $arrIndex=explode (";", $arrElem[$i]['default']);
                                                /*for ($i=0; $i<count($arrIndex);$i++)
                                                {
                                                        $arrValues["$arrIndex[$i]"]="$arrIndex[$i]";
                                                }

                                                Debug::oneVar($arrValues);
                                                */

                                                $arrOrden['Por fecha']='fecha';
                                                $arrOrden['Por autor']='autor';
                                                $arrOrden['Por tema']='tema';

                                                $arrObj[$i] = $this->_formatElem("FEListBox",
                                                                                        $arrElem[$i]['name'],
                                                                                        $arrElem[$i]['variable'],
                                                                                        FALSE,
                                                                                        '100px',
                                                                                        NULL,
                                                                                        $arrOrden);
                                                                                        //$arrValues);
                                                $arrObj[$i]->set_attribute('class','ptabla03');
                                                break;
                                        case 4: //CheckBox
                                                $arrObj[$i] = $this->_formatElem("FECheckBox",
                                                                                        $arrElem[$i]['name'],
                                                                                        $arrElem[$i]['variable']);
                                                $arrObj[$i]->set_attribute('class','tex');
                                                break;
                                        case 5: //Boton de accion
                                                $arrObj[$i] = $this->_addButton($arrElem[$i]['name'], $arrElem[$i]['label'], $arrElem[$i]['variable'], '');
                                                break;
                                        case 6: //Label
                                                $arrObj[$i] = $this->_formatElem("FECheckBox",
                                                                                        $arrElem[$i]['name'],
                                                                                        $arrElem[$i]['variable']);
                                                $arrObj[$i]->set_attribute('class','tex');
                                                //$arrObj[$i]->set_attribute('width','1%');
                                                break;
                                        case 7: //Radio Group
                                                $arrObj[$i] = null;
                                                $grElemName = $arrElem[$i]['label'];
                                                $arrGroupElement[$grElemName]=$indexRadio;
                                                $indexRadio++;
                                                $strGroupVariable = $arrElem[$i]['variable'];
                                                break;
                                }
                        }
                }
                //Debug::oneVar($arrGroupElement, __FILE__, __LINE__);
                //Debug::oneVar($strGroupVariable, __FILE__, __LINE__);
                if (isset($arrGroupElement))        {
                                                $groupElem = new base_FERadioGroup( $strGroupVariable,
                                                                                                                                                                        $arrGroupElement);

                                                //Debug::oneVar($groupElem, __FILE__, __LINE__);
                                                $groupElem->set_attribute('class','tex');
                                                $this->add_element($groupElem);
                }

                //Añadimos la lista de objetos
                for ($i=0; $i<count($arrObj);$i++) {
                        if ($arrObj[$i] != null) {
                                $this->add_element($arrObj[$i]);
                        }
                }
                //$this->add_element($this->_addButton('Aceptar', ''));

        //lets add a hidden form field
        $this->add_hidden_element("orig");
    }

   function form_initialize_data()
    {
                $arrElem = $this->getViewVariable('view_elem');

                if ($arrElem[0]['name']!=null)  { //Si no está vacío
                                  for ($i=0; $i<count($arrElem); $i++){
//                                        Debug::oneVar($arrElem[$i]['name'], __FILE__, __LINE__);
//                                        Debug::oneVar($arrElem[$i]['type'], __FILE__, __LINE__);
                                        if ($arrElem[$i]['type'] ==4 || $arrElem[$i]['type'] ==6) { //Por ahora sólo para los checkboxs
                                                 $this->set_element_value($arrElem[$i]['name'],
                                                                                                                                         $arrElem[$i]['default']);
                                        } //if
                                } //for
                }//if


                $this->set_hidden_element_value("orig", "external");

                return;
    }

    function form_init_data()
    {
                return;
    }

    function form()
    {
                $this->form_initialize_data() ;
                $this->file_path = $this->getViewVariable('path');

        $table = &html_table('100%',0,3);
        //$table->set_tag_attribute('nowrap');
        $table->set_tag_attribute('align', 'center');
                $table->add_row(html_td('', '', $this->_getFileContent($this->getViewVariable('actual'))));
        //$table->set_class('ptabla02');

                $arrElem = $this->getViewVariable('view_elem');
                //Debug::oneVar($arrElem, __FILE__, __LINE__);

                //Indice para controlar el número de Check
                $indexCheck=0;

                if ($arrElem[0]['name']!=null) { //Si no está vacío
                        for ($i=0; $i<count($arrElem); $i++) {
                                switch($arrElem[$i]['type']){
                                        case 2:
                                                $label = html_td('ptabla02', '', $arrElem[$i]['label']);
                                                $label->set_tag_attribute('colspan', '3');
                                                $table->add_row($label);
                                                $elem = $this->element_form($arrElem[$i]['name']);
                                                $table->add_row($elem);
                                                break;
                                        case 4:
                                                $j = $i + 1;
                                                if ($j < count($arrElem) && $arrElem[$j]['type'] == 6) {//si el siguiente elemento es una explicación
                                                        $status = $arrElem[$j]['default'];
                                                } else {
                                                        $status = '';
                                                }
                                                $row = $this->formatCheckBox($arrElem[$i]['name'], '0',
                                                                                $arrElem[$i]['label'], $status);
                                                $table->add_row($row);
                                                break;
                                        case 5: //Los botones van a ir siempre al final y alineados. Se van metiendo en un array y se ponen al final
                                                $elem = html_td('', '', $this->element_form($arrElem[$i]['name']));
                                                $elem->set_tag_attribute('colspan', '3');
                                                $arrButtons[]=$elem;
                                                break;
                                        case 6:
                                                $label = html_td('ptabla03', '', $arrElem[$i]['label']);
                                                $label->set_tag_attribute('colspan', '3');
                                                $table->add_row($label);
                                                break;
                                        case 7:
                                                $j = $i + 1;
                                                if ($j < count($arrElem) && $arrElem[$j]['type'] == 6) {//si el siguiente elemento es una explicación
                                                        $status = $arrElem[$j]['default'];
                                                } else {
                                                        $status = '';
                                                }
                                                $variable = $arrElem[$i]['variable'];
                                                $table->add_row($this->addRadioButton($indexCheck, $variable, $status));
                                                $indexCheck++;
                                                break;
                                        default:
                                                $elem = html_td('', '', $this->element_form($arrElem[$i]['name']));
                                                $table->add_row($elem);
                                                break;
                                }
                        } //for
                }//if

/*                if (isset($arrGroupVariable)) {
                                                $element =& $this->get_element($arrGroupVariable);
                                                $table->add_row($this->element_label($arrGroupVariable),
                                                                                                         $element->get_element(null, true));
                }
*/

                for ($i=0; $i<count($arrButtons); $i++) {
                        $table->add($arrButtons[$i]);
                }

        return $table;
    }

        function _getFileContent($filename)
    {
        $data = 'Fichero vacio o no existe';

        if(file_exists($filename) && is_file($filename)) {
            ob_start();
            include_once($filename);
            $data = ob_get_contents();
            ob_end_clean();
        }

        return $data;
    }

        function formatCheckBox($element, $tab_index, $text, $status = '')
    {
           $this->set_form_tabindex($element, $tab_index);
                $row = html_tr();

                $check = html_td('ptabla02', '', $this->element_form($element));
                $check->set_tag_attribute('width', '1%');
                switch($status){
                        case 'ok':
                                $img = Theme::getThemeImagePath('rcorrecta.gif');
                                break;
                        case 'ko':
                                $img = Theme::getThemeImagePath('rincorrecta.gif');
                                break;
                        default:
                                $img = Theme::getThemeImagePath('invisible.gif');
                }
                $image = html_td('', '', html_img($img));

                $label = html_td('ptabla01', '', agt($text));

                $row->add($check);
                $row->add($image);
                $row->add($label);

            return $row;
    }

        function addRadioButton($indexCheck, $variable, $status = '')
    {
           // $this->set_form_tabindex($element, $tab_index);
                $row = html_tr();

                //$check = html_td('ptabla02', '', $this->element_form($element));

                switch($status){
                        case 'ok':
                                $img = Theme::getThemeImagePath('rcorrecta.gif');
                                break;
                        case 'ko':
                                $img = Theme::getThemeImagePath('rincorrecta.gif');
                                break;
                        default:
                                $img = Theme::getThemeImagePath('invisible.gif');
                }

                $element =& $this->get_element($variable);
                $td_radio = html_td('ptabla02', '', $element->get_element($indexCheck, true, $img));
                $row->add($td_radio);
            return $row;
    }

        function _addButton($name, $label, $variable, $class)
    {
            $boton = $this->_formatElem("base_SubmitButton", $name, $variable, $label);
                   $boton->set_attribute('class', $class);

                   return $boton;
    }

        function _coursePath($file)
        {
                return Util::main_URLPath($this->file_path.$file);
        }
}
?>
