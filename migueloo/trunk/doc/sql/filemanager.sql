-- phpMyAdmin SQL Dump
-- version 2.6.0-beta1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 12-08-2004 a las 13:35:40
-- Versión del servidor: 4.0.13
-- Versión de PHP: 4.3.4
-- 
-- Base de datos: `migueloo_desa`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fm_course_document_folder`
-- 

DROP TABLE IF EXISTS `fm_course_document_folder`;
CREATE TABLE `fm_course_document_folder` (
  `COURSE_ID` int(11) NOT NULL default '0',
  `DOCUMENT_ID` int(11) NOT NULL default '0',
  `FOLDER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`COURSE_ID`,`DOCUMENT_ID`,`FOLDER_ID`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fm_document`
-- 

DROP TABLE IF EXISTS `fm_document`;
CREATE TABLE `fm_document` (
  `DOCUMENT_ID` int(11) NOT NULL auto_increment,
  `DOCUMENT_COMMENT` char(255) NOT NULL default '',
  `DOCUMENT_VISIBLE` tinyint(1) NOT NULL default '0',
  `DOCUMENT_MIME` char(30) NOT NULL default '',
  `DATE_PUBLISH` date NOT NULL default '0000-00-00',
  `DOCUMENT_LOCK` tinyint(1) NOT NULL default '0',
  `DOCUMENT_SHARE` tinyint(4) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  `DOCUMENT_NAME` char(100) NOT NULL default '',
  `DOCUMENT_SIZE` int(11) NOT NULL default '0',
  PRIMARY KEY  (`DOCUMENT_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fm_folder`
-- 

DROP TABLE IF EXISTS `fm_folder`;
CREATE TABLE `fm_folder` (
  `FOLDER_ID` int(11) NOT NULL auto_increment,
  `FOLDER_PARENT_ID` int(11) NOT NULL default '0',
  `FOLDER_NAME` char(100) NOT NULL default '',
  `FOLDER_COMMENT` char(255) NOT NULL default '',
  `FOLDER_VISIBLE` tinyint(11) NOT NULL default '0',
  `FOLDER_DATE` date NOT NULL default '0000-00-00',
  `COURSE_ID` int(11) NOT NULL default '0',
  `USER_ID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`FOLDER_ID`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
