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
      |          Antonio F. Cano Damas <antoniofcano@telefonica.net>         |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
class FETime extends FEBoxElement 
{
	/**
     * A printf style format string used to add punctuation to the confirmation
     * display.  Defaults to space separated.  The placeholders are filled
     * according to the order set in $_format
     *
     * @var string
     */
    var $_text_format = '%s:%s';

    /**
     * The hour form element
     *
     * @var FEYears
     */
    var $_hour;

    /**
     * The minutes form element
     *
     * @var FEMonths
     */
    var $_minute;

    /**
     * The constructor
     *
     * @param string text label for the element
     * @param boolean is this a required element?
     * @param int element width in characters, pixels (px), percentage (%) or elements (em)
     * @param int element height in px
	 * @param int minute step value for minute drop down list
	 * @param int min value for hour drop down list
     * @param int max value for hour drop down list
     *
     */

    function FETime($label, $required = TRUE, $width = NULL, $height = NULL, $minute_step, $min_hour = 8, $max_hour = 20) 
	{
		$list = range($min_hour, $max_hour);
        foreach ($list as $hour) {
            $hours[sprintf('%02d', $hour)] = $hour;
        }
        $this->_hour = new FEListBox($label . '_hours', $required, $width, $height, $hours);
		
		$minutes[sprintf('%02d', 0)] = 0;
		for($i=1;$i<60/$minute_step;$i++){
			$minute = $i * $minute_step;
			$minutes[sprintf('%02d', $minute)] = $minute;
		}

		$this->_minute = new FEListBox($label . '_minutes', $required, $width, $height, $minutes);

        $this->FEBoxElement($label, $required, $width, $height);
    }

    /**
     * This function builds and returns the
     * form element object
     *
     * @return object
     */
    function get_element() {

        $container = new Container();

        $container->add($this->_hour->get_element());
        $container->add($this->_minute->get_element());

        return $container;
    }

    /**
     * This function will return the elements value as an array or month, day
     * and year
     *
     * @return array
    */
    function get_value() {

        return $this->_value;

    }

    /**
     * This function sets the default values for the date element  The
     * parameter should be a string representation of the date in ISO 8601
     * format.
     *
     * @param string
    */
    function set_value($value) {

        $date_parts = explode(':', $value);
        $this->_hour->set_value($date_parts[0]);
        $this->_minute->set_value($date_parts[1]);

    }

    /**
     * This returns a formatted string used for the confirmation display (and
     * possibly elsewhere)
     * 
     * @return string
     */
    function get_value_text() {

       $value1 = $this->_hour->get_value_text();
	   $value2 = $this->_minute->get_value_text();
       
       return sprintf($this->_text_format, $value1, $value2);
    }

    /**
     *
     * This function is responsible for performing complete
     * validation and setting the appropriate error message
     * in case of a failed validation
     *
     * @param FormValidation object
     */
    function validate(&$_FormValidation) {
        $value = $this->get_value();

//         we make sure that the date is valid
        if ($value["hour"] < 0 || $value["hour"] > 23 ||$value["minute"] < 0 || $value["minute"] > 59) {
            $this->set_error_message("Invalid date");
            return FALSE;
        }
        return TRUE;
    }

    /**
     * this method sets the display order for the elements in the widget
     *
     * @param string
     * @return bool success or failure
     */
    function _set_format($format) {

        $this->_format = $format;
        return TRUE;

    }

    /**
     * this method sets the format string used in get_value_text().  Use this
     * method to set special punctuation for the confirmation display.
     *
     * @param string
     *
     */
    function set_text_format($format) {

        $this->_text_format = $format;
    }

    /**
     * This method returns the hidden version of this
     * element for a confirmation page.  
     * 
     * NOTE: This is called by the FormProcessor only.  
     * It shouldn't be called manually.
     * 
     * @return container 
     */
    function get_confirm_element() {
        $element_name = $this->get_element_name();

        $c = container();
        $c->add(form_hidden("{$element_name}[hour]", $this->_hour->get_value()));
        $c->add(form_hidden("{$element_name}[minute]", $this->_minute->get_value()));
        return $c;
    }
}
?>