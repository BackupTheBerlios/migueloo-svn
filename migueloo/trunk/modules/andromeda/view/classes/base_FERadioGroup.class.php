<?php
/**
 * This file contains the Text FormElement class.
 *
 * $Id: base_FERadioGroup.class.php,v 1.1 2004/08/06 10:23:10 chet Exp $
 *
 * @author Walter A. Boring IV <waboring@buildabetterweb.com>
 * @author Suren Markosyan <suren@bcsweb.com>
 * @package phpHtmlLib
 * @subpackage FormProcessing
 *
 * @copyright LGPL - See LICENCE
 *
 */

/**
 * This is the Radio Button Group FormElement which builds a
 * List of Radio buttons that can be used in any
 * style of layout.
 *
 * It has no validation method.
 *
 *
 * @author Walter A. Boring IV <waboring@buildabetterweb.com>
 * @author Suren Markossian <suren@bcsweb.com>
 * @package phpHtmlLib
 * @subpackage FormProcessing
 *
 * @copyright LGPL - See LICENCE
 */
class base_FERadioGroup extends FormElement {

    /**
     * Holds the list of available
     * data elements
     *
     */
    var $_data_list = array();

    /**
     * The constructor
     *
     * @param label string - text label for the element
     * @param array - the name => value pairs of the radio
     *                buttons text => value
     */
    function base_FERadioGroup($label, $data_list=array()) {
        $this->FormElement($label, true);
        foreach ($data_list as $name=>$value) {
            $this->_data_list[] = array($name=>$value);
        }
    }

    /**
     * This provides a method
     * for the FormContent
     * to get access to the
     * text associated with a
     * field.  This is only available
     * on FormElements that have text
     * associated with a field.
     * It is used during Confirmation
     *
     * @param mixed - the value to look up
     * @return string - the text associated
     */
    function get_value_text() {
        $value = $this->get_value();
        foreach( $this->_data_list as $arr) {
            $flip = array_flip($arr);
            if (isset($flip[$value])) {
                return $flip[$value];
            }
        }
        return NULL;
    }


    /**
     * This function builds and returns the
     * form element object
     *
     * @return object
     */
    function get_element($index=-1, $br_flag=FALSE, $img) {
        $container = container();

        if ($index == -1) {
            $count = count( $this->_data_list );
            for ($x=0;$x<=$count-1;$x++) {
                if ($br_flag) {
                    $container->add( $this->_get_index_element($x, $img),
                                     html_br());
                } else {
                    $container->add( $this->_get_index_element($x, $img));
                }

            }
        } else {
            $container->add( $this->_get_index_element($index, $img), $br );
        }

        return $container;
    }


    /**
     * This method builds an individual Radio button
     * with its associated text
     *
     * @param int - the index
     * @return INPUTtag of type radio
     */
    function _get_index_element($index, $img) {
        $attributes = $this->_build_element_attributes();
        $attributes["type"] = "radio";

        list($name, $value) = each($this->_data_list[$index]);
        $attributes["value"] = $value;


        if (($value == $this->get_value()))
            $attributes[] = "checked";

        $tag = new INPUTtag($attributes);

        //now build the href so we can click on it.
        $attr["class"] ="form_link";
        $attr["href"] = "javascript:void(0)";
        $js = "javascript: function check(item){item.click();} ".
              //"check(".$this->get_element_name().".item($index));";
			 "check(".$this->get_element_name().".item($index));";
        $attr["onclick"] = $js;

        $href = new Atag($attr, $name);
		$himg = html_img($img);
        $c = container($tag, $himg, $href);
        $c->set_collapse();
        return $c;
    }
}

?>
