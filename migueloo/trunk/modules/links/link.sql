-- MySQL dump 9.10
--
-- Host: localhost    Database: migueloo
-- ------------------------------------------------------
-- Server version       4.0.18-log

--
-- Table structure for table `link`
--

CREATE TABLE link (
  COURSE_ID int(11) NOT NULL default '0',
  LINK_NAME char(70) NOT NULL default '',
  LINK_DESCRIPTION char(100) default '',
  LINK_ID int(11) NOT NULL auto_increment,
  LINK_VALID int(1) NOT NULL default '0',
  LINK_URL char(50) default NULL,
  PRIMARY KEY  (LINK_ID)
) TYPE=MyISAM;

--
-- Dumping data for table `link`
--

INSERT INTO link VALUES (2,'Yahoo','Página del portal Yahoo',7,0,'http://www.yahoo.es');
INSERT INTO link VALUES (1,'Google','Página de búsqueda de Google',8,0,'http://www.google.es');
INSERT INTO link VALUES (1,'terra','dkjfañjkdf',10,0,'http://www.terra.es');
