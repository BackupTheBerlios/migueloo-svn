# phpMyAdmin MySQL-Dump
# version 2.5.1
# http://www.phpmyadmin.net/ (download page)
#
# Servidor: localhost
# Tiempo de generación: 04-08-2004 a las 22:19:39
# Versión del servidor: 4.0.18
# Versión de PHP: 4.3.4
# Base de datos : `miguel`
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `area`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `AREA_ID` int(11) NOT NULL auto_increment,
  `DEPARTMENT_ID` int(11) NOT NULL default '0',
  `FACULTY_ID` int(11) NOT NULL default '0',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `AREA_NAME` char(70) NOT NULL default '',
  `AREA_DESCRIPTION` char(100) NOT NULL default '',
  `AREA_RESPONSABLE` char(80) NOT NULL default '',
  `AREA_ADDRESS` char(100) NOT NULL default '',
  `AREA_URL` char(30) NOT NULL default '',
  `AREA_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`AREA_ID`,`DEPARTMENT_ID`,`FACULTY_ID`,`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `area`
#

INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (1, 1, 1, 1, 'Específica Electrónica', 'Continua', '', '', '', '');
INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (2, 2, 2, 1, 'Fisioterapia', 'Mantenimiento físico', '', '', '', '');
INSERT INTO `area` (`AREA_ID`, `DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `AREA_NAME`, `AREA_DESCRIPTION`, `AREA_RESPONSABLE`, `AREA_ADDRESS`, `AREA_URL`, `AREA_MAIL`) VALUES (3, 3, 0, 2, 'Programación', 'Cursines de Programación', 'El dire', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `area_course`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `area_course`;
CREATE TABLE `area_course` (
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FACULTY_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_ID` int(11) NOT NULL default '0',
  `AREA_ID` int(11) NOT NULL default '0',
  `COURSE_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`INSTITUTION_ID`,`FACULTY_ID`,`DEPARTMENT_ID`,`AREA_ID`,`COURSE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `area_course`
#

INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (1, 1, 1, 1, 4);
INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (1, 2, 2, 2, 6);
INSERT INTO `area_course` (`INSTITUTION_ID`, `FACULTY_ID`, `DEPARTMENT_ID`, `AREA_ID`, `COURSE_ID`) VALUES (2, 0, 3, 3, 5);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `book`
#
# Creación: 04-08-2004 a las 18:53:53
# Última actualización: 04-08-2004 a las 18:53:53
#

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `BOOK_ID` int(11) NOT NULL auto_increment,
  `AUTHOR` varchar(100) NOT NULL default '',
  `TITLE` varchar(100) NOT NULL default '',
  `PUBLISHDATE` varchar(4) default '0000',
  `EDITORIAL` varchar(100) default '',
  `PUBLISHPLACE` varchar(100) default '',
  `DESCRIPTION` text NOT NULL,
  `CONTENT` text,
  `ISBN_COD` varchar(20) NOT NULL default '',
  `COMMENT_NUM` smallint(6) NOT NULL default '0',
  `COMMENT_MEDIA` double NOT NULL default '0',
  `IMAGE` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`BOOK_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `book`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `book_comment`
#
# Creación: 04-08-2004 a las 18:53:59
# Última actualización: 04-08-2004 a las 18:53:59
#

DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE `book_comment` (
  `BOOKCOMMENT_ID` int(11) NOT NULL auto_increment,
  `BOOK_ID` int(11) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `DESCRIPTION` text NOT NULL,
  `VALUE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`BOOKCOMMENT_ID`,`BOOK_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `book_comment`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `business`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `business`;
CREATE TABLE `business` (
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`INSTITUTION_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `business`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `calendar`
#
# Creación: 04-08-2004 a las 18:54:06
# Última actualización: 04-08-2004 a las 18:54:06
#

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `CALENDAR_ID` int(11) NOT NULL auto_increment,
  `COURSE_ID` int(11) NOT NULL default '0',
  `EVENT_TYPE_ID` int(11) NOT NULL default '0',
  `TITLE` char(60) NOT NULL default '',
  `DESCRIPTION` char(255) NOT NULL default '',
  `DATE_START` datetime NOT NULL default '0000-00-00 00:00:00',
  `DATE_END` datetime NOT NULL default '0000-00-00 00:00:00',
  `ALL_DAY` tinyint(1) NOT NULL default '0',
  `AUD_TIME` datetime default NULL,
  `AUD_USER_ID` int(11) unsigned default NULL,
  PRIMARY KEY  (`CALENDAR_ID`),
  KEY `CALENDAR_ID` (`CALENDAR_ID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `calendar`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `candidate`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `candidate`;
CREATE TABLE `candidate` (
  `PERSON_ID` int(11) NOT NULL auto_increment,
  `PERSON_DNI` varchar(20) NOT NULL default '',
  `PERSON_NAME` varchar(50) NOT NULL default '',
  `PERSON_SURNAME` varchar(80) NOT NULL default '',
  `PERSON_SURNAME2` varchar(80) NOT NULL default '',
  `TREATMENT_ID` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`PERSON_ID`),
  KEY `TREATMENT_ID` (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `candidate`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `candidate_data`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `candidate_data`;
CREATE TABLE `candidate_data` (
  `person_id` int(11) NOT NULL default '0',
  `street` varchar(150) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `council` varchar(50) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `postalcode` varchar(5) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `phone2` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `email2` varchar(100) NOT NULL default '',
  `email3` varchar(100) NOT NULL default '',
  `jabber` varchar(50) NOT NULL default '',
  `web` varchar(100) NOT NULL default '',
  `notes` text NOT NULL,
  `image` varchar(5) NOT NULL default '',
  `cv` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`person_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `candidate_data`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `contact`
#
# Creación: 04-08-2004 a las 18:54:25
# Última actualización: 04-08-2004 a las 18:54:25
#

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `CONTACT_ID` int(11) NOT NULL auto_increment,
  `USER_ID` int(11) NOT NULL default '0',
  `CONTACT_NAME` char(30) NOT NULL default '',
  `CONTACT_SURNAME` char(50) NOT NULL default '',
  `CONTACT_USER_ID` int(11) NOT NULL default '0',
  `CONTACT_MAIL` char(60) NOT NULL default '',
  `CONTACT_JABBER` char(20) NOT NULL default '',
  `CONTACT_COMMENTS` char(255) NOT NULL default '',
  `IS_FROM_MIGUEL` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`CONTACT_ID`,`USER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `contact`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 01-08-2004 a las 10:50:22
#

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `COURSE_ID` int(11) NOT NULL auto_increment,
  `COURSE_NAME` char(70) NOT NULL default '',
  `COURSE_DESCRIPTION` char(100) NOT NULL default '',
  `COURSE_LANGUAGE` char(5) NOT NULL default '',
  `COURSE_ACCESS` tinyint(4) NOT NULL default '0',
  `COURSE_ACTIVE` tinyint(1) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;

#
# Volcar la base de datos para la tabla `course`
#

INSERT INTO `course` (`COURSE_ID`, `COURSE_NAME`, `COURSE_DESCRIPTION`, `COURSE_LANGUAGE`, `COURSE_ACCESS`, `COURSE_ACTIVE`, `USER_ID`) VALUES (7, 'Curso de prueba', 'Prueba del visor de cursos', 'es_ES', 1, 1, 8);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_activity`
#
# Creación: 04-08-2004 a las 18:54:43
# Última actualización: 04-08-2004 a las 19:26:19
#

DROP TABLE IF EXISTS `course_activity`;
CREATE TABLE `course_activity` (
  `course_activity_id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`course_activity_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `course_activity`
#

INSERT INTO `course_activity` (`course_activity_id`, `course_id`, `title`, `body`) VALUES (1, 7, 'Comunicarse en la plataforma', 'Blah, Blah, ....');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_card`
#
# Creación: 04-08-2004 a las 18:54:49
# Última actualización: 04-08-2004 a las 19:22:12
#

DROP TABLE IF EXISTS `course_card`;
CREATE TABLE `course_card` (
  `course_card_id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `objectives` longtext NOT NULL,
  `description` longtext NOT NULL,
  `contents` longtext NOT NULL,
  PRIMARY KEY  (`course_card_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `course_card`
#

INSERT INTO `course_card` (`course_card_id`, `course_id`, `objectives`, `description`, `contents`) VALUES (1, 7, 'Aprender a usar MIGUEL', 'Para sacar el máximo partido a la herramienta', '1.- Qué es MIGUEL\r\n2.- Cómo se accede\r\n3.- ....');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_evaluation`
#
# Creación: 04-08-2004 a las 18:55:26
# Última actualización: 04-08-2004 a las 19:25:32
#

DROP TABLE IF EXISTS `course_evaluation`;
CREATE TABLE `course_evaluation` (
  `course_evaluation_id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`course_evaluation_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `course_evaluation`
#

INSERT INTO `course_evaluation` (`course_evaluation_id`, `course_id`, `title`, `body`) VALUES (1, 7, 'Mandar un mensaje', 'Blah, Blah, blah, ...');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_forum`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `course_forum`;
CREATE TABLE `course_forum` (
  `COURSE_ID` int(11) NOT NULL default '0',
  `FORUM_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`,`FORUM_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `course_forum`
#

INSERT INTO `course_forum` (`COURSE_ID`, `FORUM_ID`) VALUES (7, 1);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_idea`
#
# Creación: 04-08-2004 a las 18:55:38
# Última actualización: 04-08-2004 a las 19:24:37
#

DROP TABLE IF EXISTS `course_idea`;
CREATE TABLE `course_idea` (
  `course_idea_id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  PRIMARY KEY  (`course_idea_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `course_idea`
#

INSERT INTO `course_idea` (`course_idea_id`, `course_id`, `title`, `body`) VALUES (1, 7, 'Qué es MIGUEL', 'Blah, blah, blah, ...');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_module`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 01-08-2004 a las 10:51:36
#

DROP TABLE IF EXISTS `course_module`;
CREATE TABLE `course_module` (
  `COURSE_ID` int(11) NOT NULL default '0',
  `MODULE_ID` int(11) NOT NULL default '0',
  `MODULE_ORDER` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`,`MODULE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `course_module`
#

INSERT INTO `course_module` (`COURSE_ID`, `MODULE_ID`, `MODULE_ORDER`) VALUES (7, 1, 1);
INSERT INTO `course_module` (`COURSE_ID`, `MODULE_ID`, `MODULE_ORDER`) VALUES (7, 2, 2);
INSERT INTO `course_module` (`COURSE_ID`, `MODULE_ID`, `MODULE_ORDER`) VALUES (7, 3, 3);
INSERT INTO `course_module` (`COURSE_ID`, `MODULE_ID`, `MODULE_ORDER`) VALUES (7, 4, 4);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_visual`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `course_visual`;
CREATE TABLE `course_visual` (
  `course_id` int(11) NOT NULL default '0',
  `item_id` int(11) NOT NULL default '0',
  `visible` char(1) NOT NULL default '',
  `admin` char(1) NOT NULL default '',
  PRIMARY KEY  (`course_id`,`item_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `course_visual`
#

INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 1, '0', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 2, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 3, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 4, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 5, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 6, '0', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 7, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 8, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 9, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 10, '1', '0');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 11, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 12, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 13, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 14, '0', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 15, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 16, '1', '1');
INSERT INTO `course_visual` (`course_id`, `item_id`, `visible`, `admin`) VALUES (4, 17, '1', '1');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `course_visual_item`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `course_visual_item`;
CREATE TABLE `course_visual_item` (
  `item_id` int(11) NOT NULL auto_increment,
  `label` varchar(20) NOT NULL default '',
  `link` varchar(45) NOT NULL default '',
  `param` varchar(45) NOT NULL default '',
  `image` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`item_id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

#
# Volcar la base de datos para la tabla `course_visual_item`
#

INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (1, 'miguel_courseAE', 'calendar', 'status=list', 'agenda');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (2, 'miguel_courseER', 'links', '', 'links');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (3, 'miguel_courseDoc', '', '', 'coursedocuments');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (4, 'miguel_courseTU', '', '', 'works');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (5, 'miguel_courseTA', 'notice', 'status=list', 'announces');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (6, 'miguel_courseMC', '', '', 'listusers');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (7, 'miguel_courseFC', '', '', 'forum');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (8, 'miguel_courseEjer', '', '', 'tests');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (9, 'miguel_courseGT', '', '', 'group');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (10, 'miguel_courseDesc', '', '', 'info');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (11, 'miguel_courseEstat', '', '', 'stats');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (12, 'miguel_courseNP', '', '', 'addmodule');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (13, 'miguel_courseNE', '', '', 'addpage');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (14, 'miguel_courseModInfo', '', '', 'editinfocourse');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (15, 'miguel_courseDelC', '', '', 'delcourse');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (16, 'miguel_courseNTA', 'notice', 'status=new', 'announces');
INSERT INTO `course_visual_item` (`item_id`, `label`, `link`, `param`, `image`) VALUES (17, 'miguel_courseNAE', 'calendar', 'status=new', 'agenda');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `department`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `DEPARTMENT_ID` int(11) NOT NULL auto_increment,
  `FACULTY_ID` int(11) NOT NULL default '0',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_PARENT_ID` int(11) NOT NULL default '0',
  `DEPARTMENT_NAME` char(70) NOT NULL default '',
  `DEPARTMENT_DESCRIPTION` char(100) NOT NULL default '',
  `DEPARTMENT_RESPONSABLE` char(80) NOT NULL default '',
  `DEPARTMENT_ADDRESS` char(100) NOT NULL default '',
  `DEPARMENT_URL` char(30) NOT NULL default '',
  `DEPARTMENT_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`DEPARTMENT_ID`,`INSTITUTION_ID`,`FACULTY_ID`),
  KEY `DEPARTMENT_PARENT_ID` (`DEPARTMENT_PARENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Volcar la base de datos para la tabla `department`
#

INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (1, 1, 1, 0, 'Departamento Electrónica', 'Ingeniería Electrónica', 'El elestricista', '', '', '');
INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (2, 2, 1, 0, 'Enfermería', 'Enfermería elemental', 'Sta. Desconocida', '', '', '');
INSERT INTO `department` (`DEPARTMENT_ID`, `FACULTY_ID`, `INSTITUTION_ID`, `DEPARTMENT_PARENT_ID`, `DEPARTMENT_NAME`, `DEPARTMENT_DESCRIPTION`, `DEPARTMENT_RESPONSABLE`, `DEPARTMENT_ADDRESS`, `DEPARMENT_URL`, `DEPARTMENT_MAIL`) VALUES (3, 0, 2, 0, 'Pruebas', 'Probando', '', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `document`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 01-08-2004 a las 10:48:58
#

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `DOCUMENT_ID` int(11) NOT NULL auto_increment,
  `DOCUMENT_COMMENT` char(255) NOT NULL default '',
  `DOCUMENT_VISIBILITY4ALL` tinyint(1) NOT NULL default '0',
  `DOCUMENT_ACCEPTED` tinyint(1) NOT NULL default '0',
  `DOCUMENT_MIME` char(30) NOT NULL default '',
  `DATE_PUBLISH` date NOT NULL default '0000-00-00',
  `DOCUMENT_ACTIVE` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`DOCUMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=34 ;

#
# Volcar la base de datos para la tabla `document`
#

INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (1, 'Curso de prueba HTML', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (2, 'Módulo1::Página1', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (3, 'Módulo1::Página2', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (4, 'Módulo1::Página3', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (5, 'Módulo2::Página1', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (6, 'Módulo3::Página1', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (7, 'Módulo3::Página2', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (8, 'Módulo4::Página1', 1, 1, 'HTML', '2004-06-17', 0);
INSERT INTO `document` (`DOCUMENT_ID`, `DOCUMENT_COMMENT`, `DOCUMENT_VISIBILITY4ALL`, `DOCUMENT_ACCEPTED`, `DOCUMENT_MIME`, `DATE_PUBLISH`, `DOCUMENT_ACTIVE`) VALUES (9, 'Módulo4::Página2', 1, 1, 'HTML', '2004-06-17', 0);
# --------------------------------------------------------


#
# Estructura de tabla para la tabla `event_type`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE `event_type` (
  `EVENT_TYPE_ID` int(11) NOT NULL auto_increment,
  `EVENT_TYPE_DESCRIPTION` char(30) NOT NULL default '',
  PRIMARY KEY  (`EVENT_TYPE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Volcar la base de datos para la tabla `event_type`
#

INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (1, 'Inicio Curso');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (2, 'Clase presencial');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (3, 'Fin de curso');
INSERT INTO `event_type` (`EVENT_TYPE_ID`, `EVENT_TYPE_DESCRIPTION`) VALUES (4, 'Otros');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `exercise_question`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `exercise_question`;
CREATE TABLE `exercise_question` (
  `EXERCICE_ID` int(11) NOT NULL default '0',
  `QUESTION_ID` int(11) NOT NULL default '0',
  `EQ_POSITION` tinyint(4) NOT NULL default '0',
  `EQ_WEIGHT` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`QUESTION_ID`,`EXERCICE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `exercise_question`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `faculty`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `FACULTY_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FACULTY_NAME` char(70) NOT NULL default '',
  `FACULTY_DESCRIPTION` char(100) NOT NULL default '',
  `FACULTY_RESPONSABLE` char(80) NOT NULL default '',
  `FACULTY_ADDRESS` char(100) NOT NULL default '',
  `FACULTY_URL` char(30) NOT NULL default '',
  `FACULTY_MAIL` char(30) NOT NULL default '',
  PRIMARY KEY  (`FACULTY_ID`,`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `faculty`
#

INSERT INTO `faculty` (`FACULTY_ID`, `INSTITUTION_ID`, `FACULTY_NAME`, `FACULTY_DESCRIPTION`, `FACULTY_RESPONSABLE`, `FACULTY_ADDRESS`, `FACULTY_URL`, `FACULTY_MAIL`) VALUES (1, 1, 'Facultad de Ciencias', 'Puteamos a los estudiantes', 'Catedrático chungo', 'EPS', 'http://www.eps.ujaen.es', 'eps@ujaen.es');
INSERT INTO `faculty` (`FACULTY_ID`, `INSTITUTION_ID`, `FACULTY_NAME`, `FACULTY_DESCRIPTION`, `FACULTY_RESPONSABLE`, `FACULTY_ADDRESS`, `FACULTY_URL`, `FACULTY_MAIL`) VALUES (2, 1, 'Facultad de Medicina', 'Mata sanos y enfermeras', 'Catedrático muy malo', 'Hopital Salvese quien pueda', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `fm_course_document_folder`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `fm_course_document_folder`;
CREATE TABLE `fm_course_document_folder` (
  `COURSE_ID` int(11) NOT NULL default '0',
  `DOCUMENT_ID` int(11) NOT NULL default '0',
  `FOLDER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`,`DOCUMENT_ID`,`FOLDER_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `fm_course_document_folder`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `fm_document`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `fm_document`;
CREATE TABLE `fm_document` (
  `DOCUMENT_ID` int(11) NOT NULL auto_increment,
  `DOCUMENT_COMMENT` char(255) NOT NULL default '',
  `DOCUMENT_VISIBILITY` tinyint(1) NOT NULL default '0',
  `DOCUMENT_ACCEPTED` tinyint(1) NOT NULL default '0',
  `DOCUMENT_MIME` char(30) NOT NULL default '',
  `DATE_PUBLISH` date NOT NULL default '0000-00-00',
  `DOCUMENT_ACTIVE` tinyint(1) NOT NULL default '0',
  `DOCUMENT_SHARE` tinyint(4) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `DOCUMENT_NAME` char(100) NOT NULL default '',
  `DOCUMENT_SIZE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`DOCUMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `fm_document`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `fm_folder`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 04-08-2004 a las 18:57:51
#

DROP TABLE IF EXISTS `fm_folder`;
CREATE TABLE `fm_folder` (
  `FOLDER_ID` int(11) NOT NULL auto_increment,
  `FOLDER_PARENT_ID` int(11) NOT NULL default '0',
  `FOLDER_NAME` char(100) NOT NULL default '',
  `FOLDER_COMMENT` char(255) NOT NULL default '',
  `FOLDER_VISIBILITY` tinyint(11) NOT NULL default '0',
  `FOLDER_DATE` date NOT NULL default '0000-00-00',
  `COURSE_ID` int(11) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FOLDER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Volcar la base de datos para la tabla `fm_folder`
#

INSERT INTO `fm_folder` (`FOLDER_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`, `COURSE_ID`, `USER_ID`) VALUES (1, 0, 'course_7', '', 0, '2004-07-16', 7, 0);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `folder`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 04-08-2004 a las 18:58:52
#

DROP TABLE IF EXISTS `folder`;
CREATE TABLE `folder` (
  `FOLDER_ID` int(11) NOT NULL auto_increment,
  `DOCUMENT_ID` int(11) NOT NULL default '0',
  `FOLDER_PARENT_ID` int(11) NOT NULL default '0',
  `FOLDER_NAME` char(100) NOT NULL default '',
  `FOLDER_COMMENT` char(255) NOT NULL default '',
  `FOLDER_VISIBILITY` tinyint(11) NOT NULL default '0',
  `FOLDER_DATE` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`FOLDER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=34 ;

#
# Volcar la base de datos para la tabla `folder`
#

INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (1, 1, 0, 'Página 1', 'Ninguno', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (2, 2, 0, 'page_1.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (3, 3, 2, 'page_2.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (4, 4, 3, 'page_3.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (5, 5, 4, 'page_4.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (6, 6, 5, 'page_5.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (7, 7, 6, 'page_6.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (8, 8, 7, 'page_7.html', '', 1, '2004-06-17');
INSERT INTO `folder` (`FOLDER_ID`, `DOCUMENT_ID`, `FOLDER_PARENT_ID`, `FOLDER_NAME`, `FOLDER_COMMENT`, `FOLDER_VISIBILITY`, `FOLDER_DATE`) VALUES (9, 9, 8, 'page_8.html', '', 1, '2004-06-17');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 04-08-2004 a las 19:04:11
#

DROP TABLE IF EXISTS `forum`;
CREATE TABLE `forum` (
  `FORUM_ID` int(11) NOT NULL auto_increment,
  `FORUM_NAME` varchar(100) NOT NULL default '',
  `FORUM_DESCRIPTION` text NOT NULL,
  `FORUM_MODERATOR` int(1) NOT NULL default '0',
  `FORUM_ACCESS` tinyint(4) NOT NULL default '0',
  `FORUM_CAT_ID` int(11) NOT NULL default '0',
  `FORUM_DATE` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`FORUM_ID`),
  KEY `FORUM_CAT_ID` (`FORUM_CAT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `forum`
#

INSERT INTO `forum` (`FORUM_ID`, `FORUM_NAME`, `FORUM_DESCRIPTION`, `FORUM_MODERATOR`, `FORUM_ACCESS`, `FORUM_CAT_ID`, `FORUM_DATE`) VALUES (1, 'Uso y disfrute de MIGUEL', 'MIGUEL es una herramienta de e-Learning ...', 0, 0, 0, '2004-08-03');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_category`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `forum_category`;
CREATE TABLE `forum_category` (
  `FORUM_CATEGORY_ID` int(11) NOT NULL auto_increment,
  `FORUM_CATEGORY_DESCRIPTION` char(255) NOT NULL default '',
  `COURSE_ID` int(11) NOT NULL default '0',
  `GROUP_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FORUM_CATEGORY_ID`),
  KEY `COURSE_ID` (`COURSE_ID`),
  KEY `GROUP_ID` (`GROUP_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `forum_category`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_post`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 04-08-2004 a las 19:06:18
#

DROP TABLE IF EXISTS `forum_post`;
CREATE TABLE `forum_post` (
  `FORUM_POST_ID` int(11) NOT NULL auto_increment,
  `FORUM_TOPIC_ID` int(11) NOT NULL default '0',
  `FORUM_ID` int(11) NOT NULL default '0',
  `FORUM_POST_TEXT` varchar(255) NOT NULL default '',
  `FORUM_POST_POSTER` int(11) NOT NULL default '0',
  `FORUM_POST_TIME` date NOT NULL default '0000-00-00',
  `FORUM_POST_IP` varchar(15) NOT NULL default '',
  `FORUM_POST_PARENT` int(11) NOT NULL default '-1',
  `FORUM_POST_TITLE` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`FORUM_POST_ID`),
  KEY `FORUM_TOPIC_ID` (`FORUM_TOPIC_ID`),
  KEY `FORUM_ID` (`FORUM_ID`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

#
# Volcar la base de datos para la tabla `forum_post`
#

INSERT INTO `forum_post` (`FORUM_POST_ID`, `FORUM_TOPIC_ID`, `FORUM_ID`, `FORUM_POST_TEXT`, `FORUM_POST_POSTER`, `FORUM_POST_TIME`, `FORUM_POST_IP`, `FORUM_POST_PARENT`, `FORUM_POST_TITLE`) VALUES (10, 1, 1, 'Hola a todos,\r\n\r\nUn saludo', 10, '2004-08-04', '127.0.0.1', 10, 'Uso y disfrute de MIGUEL');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `forum_topic`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 04-08-2004 a las 19:18:29
#

DROP TABLE IF EXISTS `forum_topic`;
CREATE TABLE `forum_topic` (
  `FORUM_TOPIC_ID` int(11) NOT NULL auto_increment,
  `FORUM_TOPIC_TITLE` varchar(60) NOT NULL default '',
  `FORUM_TOPIC_NUMVIEW` int(11) NOT NULL default '0',
  `FORUM_TOPIC_REPLIES` int(11) NOT NULL default '0',
  `FORUM_TOPIC_NOTIFY` tinyint(1) NOT NULL default '0',
  `FORUM_TOPIC_STATUS` tinyint(4) NOT NULL default '0',
  `FORUM_TOPIC_POSTER` int(11) NOT NULL default '0',
  `FORUM_TOPIC_DATE` date NOT NULL default '0000-00-00',
  `FORUM_ID` int(11) NOT NULL default '0',
  `NUMBER_OF_VISITS` int(11) NOT NULL default '0',
  `NUMBER_OF_POSTS` tinyint(4) NOT NULL default '0',
  `LAST_POST_ID` int(11) NOT NULL default '0',
  `FORUM_TOPIC_DESCRIPTION` text NOT NULL,
  `FORUM_TOPIC_NORMATIVE` text NOT NULL,
  PRIMARY KEY  (`FORUM_TOPIC_ID`,`FORUM_ID`),
  KEY `LAST_POST_ID` (`LAST_POST_ID`)
) TYPE=MyISAM AUTO_INCREMENT=11 ;

#
# Volcar la base de datos para la tabla `forum_topic`
#

INSERT INTO `forum_topic` (`FORUM_TOPIC_ID`, `FORUM_TOPIC_TITLE`, `FORUM_TOPIC_NUMVIEW`, `FORUM_TOPIC_REPLIES`, `FORUM_TOPIC_NOTIFY`, `FORUM_TOPIC_STATUS`, `FORUM_TOPIC_POSTER`, `FORUM_TOPIC_DATE`, `FORUM_ID`, `NUMBER_OF_VISITS`, `NUMBER_OF_POSTS`, `LAST_POST_ID`, `FORUM_TOPIC_DESCRIPTION`, `FORUM_TOPIC_NORMATIVE`) VALUES (1, 'Uso y disfrute de MIGUEL', 0, 0, 0, 0, 8, '2004-08-03', 1, 0, 0, 10, 'Texto y más texto\r\n\r\n;)\r\n\r\n\r\nSaludos', 'El objetivo del debate es que ...\r\n\r\n\r\n>>AQUÍ las normas de cada debate <<\r\n\r\nEstá en la BBDD');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `glossary`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `glossary`;
CREATE TABLE `glossary` (
  `COURSE_ID` int(11) NOT NULL default '0',
  `GLOSSARY_ID` int(11) NOT NULL default '0',
  `GLOSSARY_NAME` char(30) NOT NULL default '',
  `GLOSSARY_DESCRIPTION` char(255) NOT NULL default '',
  PRIMARY KEY  (`COURSE_ID`,`GLOSSARY_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `glossary`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `institution`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `institution`;
CREATE TABLE `institution` (
  `INSTITUTION_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_NAME` char(70) NOT NULL default '',
  `INSTITUTION_DESCRIPTION` char(100) NOT NULL default '',
  `INSTITUTION_IDENTIFY` char(80) NOT NULL default '',
  PRIMARY KEY  (`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `institution`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `institution_contact`
#
# Creación: 31-07-2004 a las 23:48:42
# Última actualización: 31-07-2004 a las 23:48:42
#

DROP TABLE IF EXISTS `institution_contact`;
CREATE TABLE `institution_contact` (
  `INSTITUTION_CONTACT_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `INSTITUTION_CONTACT_NAME` char(100) NOT NULL default '',
  `INSTITUTION_CONTACT_EMAIL` char(100) NOT NULL default '',
  `INSTITUTION_CONTACT_PHONE` char(80) NOT NULL default '',
  PRIMARY KEY  (`INSTITUTION_CONTACT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `institution_contact`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `institution_data`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `institution_data`;
CREATE TABLE `institution_data` (
  `INSTITUTION_DATA_ID` int(11) NOT NULL auto_increment,
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `INSTITUTION_DATA_CODE` varchar(20) default '',
  `INSTITUTION_DATA_ADDRESS` varchar(150) default '',
  `INSTITUTION_DATA_CITY` varchar(50) default '',
  `INSTITUTION_DATA_COUNCIL` varchar(50) default '',
  `INSTITUTION_DATA_COUNTRY` varchar(50) default '',
  `INSTITUTION_DATA_POSTALCODE` varchar(5) default '',
  `INSTITUTION_DATA_PHONE` int(20) default '0',
  `INSTITUTION_DATA_PHONE2` int(20) default '0',
  `INSTITUTION_DATA_PHONE3` int(20) default '0',
  `INSTITUTION_DATA_FAX` int(20) default '0',
  `INSTITUTION_DATA_EMAIL` varchar(100) default '',
  `INSTITUTION_DATA_EMAIL2` varchar(100) default '',
  `INSTITUTION_DATA_EMAIL3` varchar(100) default '',
  `INSTITUTION_DATA_WEB` varchar(100) default '',
  `INSTITUTION_DATA_LOGO` varchar(100) default '',
  `INSTITUTION_DATA_OBSERVATIONS` text,
  PRIMARY KEY  (`INSTITUTION_DATA_ID`),
  KEY `INSTITUTION_ID` (`INSTITUTION_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `institution_data`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `link`
#
# Creación: 04-08-2004 a las 19:08:59
# Última actualización: 04-08-2004 a las 19:08:59
#

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `LINK_ID` int(11) NOT NULL auto_increment,
  `LINK_CATEGORY_ID` int(11) NOT NULL default '0',
  `LINK_NAME` char(30) NOT NULL default '',
  `LINK_DESCRIPTION` char(255) NOT NULL default '',
  `LINK_URL` char(100) NOT NULL default '',
  `LINK_BROKEN` tinyint(1) NOT NULL default '0',
  `LINK_PUNTUACION` double NOT NULL default '0',
  PRIMARY KEY  (`LINK_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `link`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `link_category`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `link_category`;
CREATE TABLE `link_category` (
  `LINK_CATEGORY_ID` int(11) NOT NULL default '0',
  `LINK_CATEGORY_DESCRIPTION` char(100) NOT NULL default '',
  PRIMARY KEY  (`LINK_CATEGORY_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `link_category`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `link_comment`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `link_comment`;
CREATE TABLE `link_comment` (
  `LINK_COMMENT_ID` int(11) NOT NULL default '0',
  `LINK_COMMENT_DESCRIPTION` char(255) NOT NULL default '',
  `LINK_COMMENT_PUNTUACION` tinyint(4) NOT NULL default '0',
  `LINK_COMMENT_USER_ID` int(11) NOT NULL default '0',
  `LINK_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`LINK_COMMENT_ID`,`LINK_ID`),
  KEY `LINK_COMMETS_USER_ID` (`LINK_COMMENT_USER_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `link_comment`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `loginout`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 20:42:06
#

DROP TABLE IF EXISTS `loginout`;
CREATE TABLE `loginout` (
  `idLog` mediumint(9) unsigned NOT NULL auto_increment,
  `id_user` mediumint(9) unsigned NOT NULL default '0',
  `ip` char(16) NOT NULL default '0.0.0.0',
  `log_when` datetime NOT NULL default '0000-00-00 00:00:00',
  `log_action` enum('LOGIN','LOGOUT') NOT NULL default 'LOGIN',
  PRIMARY KEY  (`idLog`)
) TYPE=MyISAM AUTO_INCREMENT=60 ;

#
# Volcar la base de datos para la tabla `loginout`
#


# --------------------------------------------------------

#
# Estructura de tabla para la tabla `message`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 03-08-2004 a las 23:01:19
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `sender` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `body` mediumtext NOT NULL,
  `subject` text NOT NULL,
  `date` datetime NOT NULL default '2000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Volcar la base de datos para la tabla `message`
#

INSERT INTO `message` (`sender`, `id`, `body`, `subject`, `date`) VALUES (1, 1, 'Le recordamos la necesidad de salirse de forma adecuada de la plataforma.\r\n\r\nPor favor, salga pulsando en los lugares indicados a tal efecto en el manual de usuario.\r\n\r\nGracias.', 'Aviso del sistema', '2004-07-31 19:25:27');
INSERT INTO `message` (`sender`, `id`, `body`, `subject`, `date`) VALUES (8, 2, 'Holas apañero', 'Bienvenido Eduardo', '2004-08-03 23:01:19');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `module`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 19:10:28
#

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `MODULE_ID` int(11) NOT NULL auto_increment,
  `MODULE_NAME` varchar(100) NOT NULL default '',
  `MODULE_DESCRIPTION` text NOT NULL,
  PRIMARY KEY  (`MODULE_ID`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;

#
# Volcar la base de datos para la tabla `module`
#

INSERT INTO `module` (`MODULE_ID`, `MODULE_NAME`, `MODULE_DESCRIPTION`) VALUES (1, 'Introducción a miguel', 'Descripción de los objetivos y características de miguel');
INSERT INTO `module` (`MODULE_ID`, `MODULE_NAME`, `MODULE_DESCRIPTION`) VALUES (2, 'Ayuda básica', 'Elementos de apoyo en miguel');
INSERT INTO `module` (`MODULE_ID`, `MODULE_NAME`, `MODULE_DESCRIPTION`) VALUES (3, 'Acceso a miguel', 'Cómo se accede y características de la sesión abierta.');
INSERT INTO `module` (`MODULE_ID`, `MODULE_NAME`, `MODULE_DESCRIPTION`) VALUES (4, 'Salida de miguel', 'Cómo salir de miguel y por qué así.');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `module_document`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 19:11:40
#

DROP TABLE IF EXISTS `module_document`;
CREATE TABLE `module_document` (
  `MODULE_ID` int(11) NOT NULL default '0',
  `DOCUMENT_ID` int(11) NOT NULL default '0',
  `MD_ORDER` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`MODULE_ID`,`DOCUMENT_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `module_document`
#

INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (1, 2, 1);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (1, 3, 2);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (1, 4, 3);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (2, 5, 1);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (3, 6, 1);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (3, 7, 2);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (4, 8, 1);
INSERT INTO `module_document` (`MODULE_ID`, `DOCUMENT_ID`, `MD_ORDER`) VALUES (4, 9, 2);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `notice`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL auto_increment,
  `author` varchar(50) NOT NULL default '',
  `subject` varchar(50) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `time` datetime default NULL,
  PRIMARY KEY  (`notice_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Volcar la base de datos para la tabla `notice`
#

INSERT INTO `notice` (`notice_id`, `author`, `subject`, `text`, `time`) VALUES (1, 'admin', 'Bienvenida al Campus', 'Bienvenido al campus virtual de pruebas de miguelOO', '2004-07-31 19:21:33');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `person`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 19:50:59
#

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `PERSON_ID` int(11) NOT NULL auto_increment,
  `PERSON_DNI` varchar(20) NOT NULL default '',
  `PERSON_NAME` varchar(50) NOT NULL default '',
  `PERSON_SURNAME` varchar(80) NOT NULL default '',
  `PERSON_SURNAME2` varchar(80) NOT NULL default '',
  `TREATMENT_ID` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`PERSON_ID`),
  KEY `TREATMENT_ID` (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;

#
# Volcar la base de datos para la tabla `person`
#

INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (1, '', 'Invitado', '', '', 1);
INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (3, '', 'Juan', 'Español', '', 2);
INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (8, 'none', 'Profe', 'Sor', 'Normal', 4);
INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (9, 'none', 'Profe', 'Sor', 'Tutor', 4);
INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (10, '10000000000Ñ', 'Alumno', 'Primer', 'Curso', 5);
INSERT INTO `person` (`PERSON_ID`, `PERSON_DNI`, `PERSON_NAME`, `PERSON_SURNAME`, `PERSON_SURNAME2`, `TREATMENT_ID`) VALUES (11, '', 'Secre', 'Taria', 'Presente', 5);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `person_data`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 19:40:19
#

DROP TABLE IF EXISTS `person_data`;
CREATE TABLE `person_data` (
  `person_id` int(11) NOT NULL default '0',
  `street` varchar(150) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `council` varchar(50) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `postalcode` varchar(5) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `phone2` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `email2` varchar(100) NOT NULL default '',
  `email3` varchar(100) NOT NULL default '',
  `jabber` varchar(50) NOT NULL default '',
  `web` varchar(100) NOT NULL default '',
  `notes` text NOT NULL,
  `image` varchar(5) NOT NULL default '',
  `cv` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`person_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `person_data`
#

INSERT INTO `person_data` (`person_id`, `street`, `city`, `council`, `country`, `postalcode`, `phone`, `phone2`, `fax`, `email`, `email2`, `email3`, `jabber`, `web`, `notes`, `image`, `cv`) VALUES (10, '', '', '', '', '', '999999999', '', '', '', '', '', '........@jabber.org', '', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `person_profile`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 04-08-2004 a las 19:46:39
#

DROP TABLE IF EXISTS `person_profile`;
CREATE TABLE `person_profile` (
  `person_id` int(11) NOT NULL default '0',
  `last_modify` date default NULL,
  `who` text NOT NULL,
  `what_offer` text NOT NULL,
  `what_learn` text NOT NULL,
  `web_interest` text NOT NULL,
  `mention_favorite` text NOT NULL,
  PRIMARY KEY  (`person_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `person_profile`
#

INSERT INTO `person_profile` (`person_id`, `last_modify`, `who`, `what_offer`, `what_learn`, `web_interest`, `mention_favorite`) VALUES (10, '2004-08-04', 'Me llamo Fulanito de Tal ....', '', '', '', '');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `profile`
#
# Creación: 02-08-2004 a las 20:23:53
# Última actualización: 02-08-2004 a las 20:23:53
#

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `ID_PROFILE` tinyint(4) NOT NULL auto_increment,
  `PROFILE_DESCRIPTION` varchar(20) NOT NULL default '',
  `PROFILE_NOTES` varchar(100) default NULL,
  `PROFILE_PRIORITY` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID_PROFILE`),
  KEY `PROFILE_PRIORITY` (`PROFILE_PRIORITY`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Volcar la base de datos para la tabla `profile`
#

INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (2, 'Tutor', 'Tutor', 9);
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (3, 'Profesor', 'Profesor', 3);
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (4, 'Alumno', 'Alumno', 11);
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (6, 'Visitante', 'Visitante', 12);
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (1, 'Administrador', 'Administrador', 2);
INSERT INTO `profile` (`ID_PROFILE`, `PROFILE_DESCRIPTION`, `PROFILE_NOTES`, `PROFILE_PRIORITY`) VALUES (5, 'Secretaria', 'Secretaria', 1);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `receiver_message`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 03-08-2004 a las 23:02:11
#

DROP TABLE IF EXISTS `receiver_message`;
CREATE TABLE `receiver_message` (
  `id_receiver` int(11) NOT NULL default '0',
  `id_message` int(11) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id_receiver`,`id_message`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `receiver_message`
#

INSERT INTO `receiver_message` (`id_receiver`, `id_message`, `status`) VALUES (10, 1, 1);
INSERT INTO `receiver_message` (`id_receiver`, `id_message`, `status`) VALUES (10, 2, 1);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `suggestion`
#
# Creación: 04-08-2004 a las 19:12:31
# Última actualización: 04-08-2004 a las 19:12:31
#

DROP TABLE IF EXISTS `suggestion`;
CREATE TABLE `suggestion` (
  `SUGGESTION_ID` int(11) NOT NULL auto_increment,
  `SUGGESTION_DESCRIPTION` char(255) NOT NULL default '',
  `SUGGESTION_READ` tinyint(1) NOT NULL default '0',
  `SUGGESTION_DATE_SENT` date NOT NULL default '0000-00-00',
  `SUGGESTION_PRIORITY` tinyint(4) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `SUGGESTION_NAME` char(255) NOT NULL default '',
  `SUGGESTION_EMAIL` char(255) NOT NULL default '',
  PRIMARY KEY  (`SUGGESTION_ID`),
  KEY `USER_ID` (`USER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `suggestion`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `todo`
#
# Creación: 04-08-2004 a las 19:12:42
# Última actualización: 04-08-2004 a las 19:12:42
#

DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `id` mediumint(9) NOT NULL auto_increment,
  `contenu` text,
  `temps` datetime default '0000-00-00 00:00:00',
  `auteur` varchar(80) default NULL,
  `email` varchar(80) default NULL,
  `priority` tinyint(4) default '0',
  `type` varchar(8) default NULL,
  `cible` varchar(30) default NULL,
  `statut` varchar(8) default NULL,
  `assignTo` mediumint(9) default NULL,
  `showToUsers` enum('YES','NO') NOT NULL default 'YES',
  PRIMARY KEY  (`id`),
  KEY `temps` (`temps`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `todo`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `treatment`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `treatment`;
CREATE TABLE `treatment` (
  `TREATMENT_ID` tinyint(4) NOT NULL auto_increment,
  `TREATMENT_DESCRIPTION` char(20) NOT NULL default '',
  PRIMARY KEY  (`TREATMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# Volcar la base de datos para la tabla `treatment`
#

INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (1, '');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (2, 'Don');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (3, 'Doña');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (4, 'Señor');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (5, 'Señora');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (6, 'Doctor');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (7, 'Doctora');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (8, 'Catedrático');
INSERT INTO `treatment` (`TREATMENT_ID`, `TREATMENT_DESCRIPTION`) VALUES (9, 'Catedrática');
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `user`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL auto_increment,
  `USER_ALIAS` char(10) NOT NULL default '',
  `THEME` char(20) NOT NULL default '',
  `LANGUAGE` char(5) NOT NULL default '',
  `USER_PASSWORD` char(255) NOT NULL default '',
  `ACTIVE` char(1) NOT NULL default '',
  `ACTIVATE_HASH` char(16) NOT NULL default '',
  `INSTITUTION_ID` int(11) NOT NULL default '0',
  `FORUM_TYPE_BB` tinyint(1) NOT NULL default '0',
  `MAIN_PAGE_ID` int(11) NOT NULL default '0',
  `PERSON_ID` int(11) NOT NULL default '0',
  `ID_PROFILE` tinyint(4) NOT NULL default '0',
  `TREATMENT_ID` tinyint(4) NOT NULL default '1',
  `EMAIL` char(100) NOT NULL default '',
  `USER_NOTIFY_EMAIL` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`USER_ID`),
  KEY `INSTITUTION_ID` (`INSTITUTION_ID`),
  KEY `PERSON_ID` (`PERSON_ID`),
  KEY `ID_PROFILE` (`ID_PROFILE`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;

#
# Volcar la base de datos para la tabla `user`
#

INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (2, 'guest', 'shs', 'es_ES', 'guest', '1', '', 0, 0, 0, 1, 6, 1, '', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (1, 'admin', 'miguel', 'es_ES', 'admin', '1', '', 0, 0, 0, 3, 1, 2, '', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (8, 'profesor', 'ups', 'es_ES', 'profesor', '1', '', 0, 0, 0, 8, 3, 4, 'ningun@correo.aun', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (9, 'tutor', 'ups', 'es_ES', 'tutor', '1', '', 0, 0, 0, 9, 2, 4, 'sincorreo@en.isp', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (10, 'alumno', 'ups', 'es_ES', 'alumno', '1', '', 0, 0, 0, 10, 4, 4, 'alumno', 0);
INSERT INTO `user` (`USER_ID`, `USER_ALIAS`, `THEME`, `LANGUAGE`, `USER_PASSWORD`, `ACTIVE`, `ACTIVATE_HASH`, `INSTITUTION_ID`, `FORUM_TYPE_BB`, `MAIN_PAGE_ID`, `PERSON_ID`, `ID_PROFILE`, `TREATMENT_ID`, `EMAIL`, `USER_NOTIFY_EMAIL`) VALUES (11, 'secretaria', 'shs', 'es_ES', 'secretaria', '1', '', 0, 0, 0, 11, 5, 5, 'desco@sin.ip', 0);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `user_course`
#
# Creación: 04-08-2004 a las 19:13:16
# Última actualización: 04-08-2004 a las 19:13:16
#

DROP TABLE IF EXISTS `user_course`;
CREATE TABLE `user_course` (
  `USER_ID` int(11) NOT NULL default '0',
  `COURSE_ID` int(11) NOT NULL default '0',
  `UD_DATE` date NOT NULL default '0000-00-00',
  `UC_UID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`USER_ID`,`COURSE_ID`),
  KEY `UC_UID` (`UC_UID`),
  KEY `COURSE_ID` (`COURSE_ID`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `user_course`
#

# --------------------------------------------------------

#
# Estructura de tabla para la tabla `user_logged`
#
# Creación: 04-08-2004 a las 19:13:26
# Última actualización: 04-08-2004 a las 20:27:21
#

DROP TABLE IF EXISTS `user_logged`;
CREATE TABLE `user_logged` (
  `user_id` int(11) NOT NULL default '0',
  `is_logged` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM;

#
# Volcar la base de datos para la tabla `user_logged`
#

INSERT INTO `user_logged` (`user_id`, `is_logged`) VALUES (10, 1);
# --------------------------------------------------------

#
# Estructura de tabla para la tabla `work`
#
# Creación: 31-07-2004 a las 23:48:43
# Última actualización: 31-07-2004 a las 23:48:43
#

DROP TABLE IF EXISTS `work`;
CREATE TABLE `work` (
  `id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL default '0',
  `path` varchar(200) default NULL,
  `titre` varchar(200) default NULL,
  `comment` varchar(250) default NULL,
  `auteurs` varchar(200) default NULL,
  `visibility` char(1) default NULL,
  `accepted` tinyint(1) default NULL,
  `gid` int(11) default NULL,
  `uid` int(11) default NULL,
  `dc` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Volcar la base de datos para la tabla `work`
#


