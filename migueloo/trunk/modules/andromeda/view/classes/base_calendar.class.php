<?php

/**
 * This contains the Calendar widget
 *
 * $Id: base_calendar.class.php,v 1.1 2004/08/06 10:23:10 chet Exp $
 *
 * @author Mike Bos <info@mik3.com>
 * @package phpHtmlLib
 * 
 */

/**
 * must have the BaseWidget
 */
require_once( $phphtmllib."/widgets/BaseWidget.inc");
/**
 * This class builds a calendar.
 * @author Mike Bos <info@mik3.com>
 * @package phpHtmlLib
*/
class Calendar extends BaseWidget {

	/**
	 * Holds the date which the
	 * calendar should show.
	 *
	 * @access private
	 * @var date
	 */
	var $_date;


	/**
	 * Holds the locale daynames.
	 *
	 * @access private
	 * @var array
	 */
	var $_DayNames;


	/**
	 * To show a year or a month
	 *
	 * @access private
	 * @var bool
	 */
	var $_ShowYear = FALSE;


	/**
	 * Start of the week 0 is sunday
	 *
	 * @var int
	 */
 	var $StartDay = 1;


	/**
	 * Holds the days in a month.
	 *
	 * @access private
	 * @var array
	 */
	var $_daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);


	/**
	* Constructor for this class
	* It just sets the date for the
	* widget.
	*
	* @param int $width - The width of the widget
	* @param int $date - The date for the widget (unixtimestamp)
	* @param array $locale - The language in which the calendar should be showed
	*/
	function Calendar( $width = "150", $date, $locale = array("English","En")) {
		if (isset($_REQUEST['CalendarDate'])) {
			$this->_date = $_REQUEST['CalendarDate'];
		} else {
			$this->_date = $date;
		}
		 $this->set_width( $width );
		setlocale (LC_TIME, $locale);
		// First one is known sunday etc.
		$this->_DayNames = array(ucfirst(strftime("%a",mktime(0,0,0,11,2,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,3,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,4,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,5,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,6,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,7,2003))),ucfirst(strftime("%a",mktime(0,0,0,11,8,2003))));
	}


	/**
	* You can set the day link with this function if you subclass,
	*
	* @param int $date - Unix timestamp
	*
	* @return string URL.
	*/
	function GetLink($date) {
		return null;
	}

	/**
	* Function to display days different, subclass it to use it.
	*
	* @param int $day - Unix timestamp representing a day
	*
	* @return bool.
	*/
	function DayIsEvent($day) {
		return false;
	}

	/**
	* To display an entire Year Calendar
	*
	* @param bool $Show - TRUE ot show a complete year
	*
	*/
	function ShowYear($Show) {
		$this->_ShowYear = $Show;
	}


	/**
	* You can set the startday with this function
	*
	* @param int $day - 0 is sunday
	*
	*/
	function SetStartDay($day) {
		$this->StartDay = $day;
	}

	/**
	* function that will render the widget.
	*
	*
	* @return string the raw html output.
	*/
	function render() {
		// Checking if we should do a month or a year
		if (!$this->_ShowYear) {
			$month = $this->_DoMonth();
			return $month->render( NULL, 0 );
		} else {
			// Get year
			$year = date("Y",$this->_date);
			$data_table = html_table("",1,1,5);

			// Setting the previous & next year
			$prev = mktime(0,0,0,1,1, $year-1);
			$next = mktime(0,0,0,1,1, $year+1);
			// Extracting query string
			if (isset($_SERVER['QUERY_STRING'])) {
				if (substr($_SERVER['QUERY_STRING'],0,12) == "CalendarDate") {
					$query_string = substr($_SERVER['QUERY_STRING'],23);
				} else {
					if ($_SERVER['QUERY_STRING'] != "") $query_string = "&" . $_SERVER['QUERY_STRING'];
				}
			}
			// Setting up link
			$prevYear = $_SERVER['PHP_SELF'] . "?CalendarDate=$prev" .  $query_string;
			$nextYear = $_SERVER['PHP_SELF'] . "?CalendarDate=$next" . $query_string;

			// Add header
			$data_table->set_class("PHP_calendar");
			$data_table->set_default_col_attributes(array('align' => 'center','valign' => 'baseline'));
			$t_td = html_td('PHP_calendarHeader', 'center', $year);
			$t_td->set_tag_attributes(array('colspan' => 2));
			$data_table->add_row(html_td('PHP_calendarHeader', 'center', html_a($prevYear, "&lt;&lt;")), $t_td,html_td('PHP_calendarHeader', 'center', html_a($nextYear, "&gt;&gt;")));

			// adding months
			$month = 1;
			// three rows of four months each
			for ($i = 0; $i < 3; $i++) {
				$Row = html_tr();
				for ($j = 0; $j < 4; $j++) {
					$this->_date = mktime(0,0,0,$month++,1, $year);
					$Cell = html_td(NULL, 'center', $this->_DoMonth());
					$Cell->set_tag_attribute("valign","top");
					$Row->add($Cell);
				}
				$data_table->add_row($Row);
			}
			return $data_table->render( NULL, 0 );
		}
	}


	/**
	* function to output a month
	*
	* @access private
	* @return table object
	*
	*/
	function _DoMonth() {
		$data_table = html_table($this->width);

		// Get month and year
		$month = date("m",$this->_date);
		$year = date("Y",$this->_date);

		$daysInMonth = $this->_getDaysInMonth($month, $year);
		$first = date("w",mktime(12, 0, 0, $month, 1, $year));

		$monthName = strftime("%b",$this->_date);

		if (!$this->_ShowYear) {
			$header = ucfirst("$monthName $year");
		} else {
			$header = ucfirst("$monthName");
		}

		// Setting the previous & next month
		$prev = mktime(0,0,0,$month-1, 1, $year);
		$next = mktime(0,0,0,$month+1, 1, $year);
		// Extracting query string
		if (isset($_SERVER['QUERY_STRING'])) {
			if (substr($_SERVER['QUERY_STRING'],0,12) == "CalendarDate") {
				$query_string = substr($_SERVER['QUERY_STRING'],23);
			} else {
				if ($_SERVER['QUERY_STRING'] != "") $query_string = "&" . $_SERVER['QUERY_STRING'];
			}
		}
		// Setting up link
		$prevMonth = $_SERVER['PHP_SELF'] . "?CalendarDate=$prev" .  $query_string;
		$nextMonth = $_SERVER['PHP_SELF'] . "?CalendarDate=$next" . $query_string;

		// Add header
		$data_table->set_class("PHP_calendar");
		$data_table->set_default_col_attributes(array('align' => 'center'));
		$t_td = html_td('PHP_calendarHeader', 'center', $header);
		if (!$this->_ShowYear) {
			$t_td->set_tag_attributes(array('colspan' => 5));
			$data_table->add_row(html_td('PHP_calendarHeader', NULL, html_a($prevMonth, "&lt;&lt;")), $t_td,html_td('PHP_calendarHeader', NULL, html_a($nextMonth, "&gt;&gt;")));
		} else {
			$t_td->set_tag_attributes(array('colspan' => 7));
			$data_table->add_row($t_td);
		}
		$t_tr = html_tr("PHP_calendarHeaderWeekdays",html_td(NULL, "center",  $this->_DayNames[($this->StartDay)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+1)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+2)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+3)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+4)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+5)%7]),html_td(NULL, "center", $this->_DayNames[($this->StartDay+6)%7]));
		$data_table->add_row($t_tr);

		// We need to work out what date to start at so that the first appears in the correct column
		$d = $this->StartDay + 1 - $first;
		while ($d > 1) $d -= 7;

		// Make sure we know when today is, so that we can use a different CSS style
		$today = getdate(mktime());

		while ($d <= $daysInMonth) {
			$t_row = html_tr();

			for ($i = 0; $i < 7; $i++) {
				if ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"]) {
					$class = "PHP_calendarToday";
				} else {
					$class = "PHP_calendar";
				}
				if ($d > 0 && $d <= $daysInMonth) {
					//$link = $this->GetLink(mktime(0,0,0,$month,$d,$year));
					$link = $this->GetLink($d,$month,$year);
					// checking if event
					if ($this->DayIsEvent(mktime(0,0,0,$month,$d,$year))) $class .= "Event";


					if ($link != NULL) {
						$objLink = html_a($link, $d);
						$objLink->set_tag_attribute('target', 'parent_popup');
						//$objLink->set_tag_attribute('onMouseUp', 'window.close()');
						$t_row->add(html_td("$class","center",$objLink));
					} else {
						$t_row->add(html_td("$class","center",$d));
					}
				} else {
					$t_row->add("&nbsp;");
				}
				$d++;
			}
			$data_table->add_row($t_row);
		}
		return $data_table;
	}

	/**
	* function to calculate the days in month.
	*
	* @access private
	* @return int
	*
	*/
	function _getDaysInMonth($month, $year) {
		if ($month < 1 || $month > 12) {
			return 0;
        	}

		$d = $this->_daysInMonth[$month - 1];

		if ($month == 2) {
		// Check for leap year
		// Forget the 4000 rule, I doubt I'll be around then...
			if ($year%4 == 0) {
				if ($year%100 == 0) {
					if ($year%400 == 0) {
						$d = 29;
					}
				} else {
					$d = 29;
				}
			}
		}
		return $d;
	}
}


/**
 * This class defines the css used by the
 * Calendar Object.
 *
 * @author Mike Bos <info@mik3.com>
 * @package phpHtmlLib 
 */
class CalendarCSS extends CSSBuilder {

	function user_setup() {

		$this->add_entry(".PHP_calendarHeader", "",
						 array("font-size" => "12px",
							 "color" => "#db1c1c") );

		$this->add_entry(".PHP_calendarHeaderWeekdays", "",
						 array("font-size" => "12px",
							 "color" => "#db1c1c") );

		$this->add_entry(".PHP_calendar", "",
						 array("font-size" => "12px",
							 "color" => "#3363b7") );

		$this->add_entry(".PHP_calendarToday", "",
						 array("font-size" => "12px",
							 "background-color" => "#fffa00") );

		$this->add_entry(".PHP_calendarEvent", "",
						 array("font-size" => "12px",
							 "color" => "#3363b7",
							 "font-weight" => "bold") );

		$this->add_entry(".PHP_calendarTodayEvent", "",
						 array("font-size" => "12px",
							 "background-color" => "#fffa00",
							  "font-weight" => "bold") );

		$this->add_entry(".PHP_calendarlink", "",
						 array("font-size" => "12px",
							 "color" => "#db1c1c") );
	}
}
?>
