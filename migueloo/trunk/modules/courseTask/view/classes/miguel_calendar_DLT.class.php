<?php

;$path_fs = substr($_SERVER['PATH_TRANSLATED'], 0, strrpos($_SERVER['PATH_TRANSLATED'],"/"));
$path_fs = 'C:\php5xampp-dev\htdocs';
$phphtmllib = $path_fs . "/phphtmllib";
include_once("$phphtmllib/includes.inc");
//require_once($phphtmllib."/widgets/Calendar.inc");
require_once(Util::app_Path("andromeda/view/classes/base_calendar.class.php"));
//create the page object
$page = new HTMLPageClass("phpHtmlLib Widgets - Calendar Example",  XHTML_TRANSITIONAL);

$page->add_head_css(".PHP_calendarHeader {font-size: 12px;color: #db1c1c;}");
$page->add_head_css(".PHP_calendarToday {font-size: 12px;background-color: #fffa00;}");
$page->add_head_css(".PHP_calendar {font-size: 12px;color: #3363b7;}");
$page->add_head_css(".PHP_calendarlink {color: #3363b7;text-decoration:none;}");
$page->add_head_css(".PHP_calendarHeaderWeekdays {font-size: 12px;color: #3363b7;font-weight:bold;}");
$page->add_head_css(".PHP_calendarTodayEvent {font-size: 12px;background-color: #fffa00;font-weight:bold;}");
$page->add_head_css(".PHP_calendarEvent {font-size: 12px;color: #3363b7;font-weight:bold;}");

// build the calendar
class MyCalendar extends Calendar {
	function GetLink($date) {
		return "http://www.mik3.com/?date=$date";
	}

	function DayIsEvent($day) {
		// you could query a database here, instead we only return the 15 every month as a day that should be marked different
		$date = getdate($day);
		if ($date['mday'] == 15) return true;
		return false;
	}
}

if ($_REQUEST['year'] == false) {
	$page->add(new MyCalendar(150, mktime(), array("es","es_ES")),html_br(2),html_a("calendartest.php?year=true","Year view"));

} else {
	$thing = new MyCalendar("160", mktime(), array("es","es_ES"));
	$thing->ShowYear(True);
	$page->add($thing, html_br(2),html_a("calendartest.php","Month view"));
}

print $page->render();
?>
