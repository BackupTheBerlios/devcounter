# phpMyAdmin MySQL-Dump
# version 2.2.7-pl1
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: db.berlios.de
# Generation Time: Aug 26, 2002 at 01:13 PM
# Server version: 3.23.37
# PHP Version: 3.0.18
# Database : `devcounter`
# --------------------------------------------------------

#
# Table structure for table `active_sessions`
#

CREATE TABLE active_sessions (
  sid varchar(32) NOT NULL default '',
  name varchar(32) NOT NULL default '',
  val text,
  changed varchar(14) NOT NULL default '',
  PRIMARY KEY  (name,sid),
  KEY changed (changed)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `auth_user`
#

CREATE TABLE auth_user (
  user_id varchar(32) NOT NULL default '',
  username varchar(32) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  realname varchar(64) NOT NULL default '',
  email_usr varchar(128) NOT NULL default '',
  modification_usr timestamp(14) NOT NULL,
  creation_usr timestamp(14) NOT NULL,
  perms varchar(255) default NULL,
  PRIMARY KEY  (user_id),
  UNIQUE KEY k_username (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `counter`
#

CREATE TABLE counter (
  develid bigint(20) unsigned NOT NULL default '0',
  devel_cnt int(11) NOT NULL default '0',
  PRIMARY KEY  (develid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `counter_check`
#

CREATE TABLE counter_check (
  develid bigint(20) unsigned NOT NULL default '0',
  ipaddr varchar(15) NOT NULL default '127.000.000.001',
  creation_cnt timestamp(14) NOT NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `countries`
#

CREATE TABLE countries (
  code int(11) NOT NULL default '0',
  domaine char(20) NOT NULL default '',
  description char(50) NOT NULL default '',
  language char(16) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `developers`
#

CREATE TABLE developers (
  develid bigint(20) unsigned NOT NULL auto_increment,
  username varchar(24) NOT NULL default '',
  nationality varchar(24) default NULL,
  actual_country varchar(24) default NULL,
  year_of_birth int(4) default NULL,
  gender varchar(8) default NULL,
  mother_tongue varchar(16) default NULL,
  other_lang_1 varchar(16) default NULL,
  other_lang_2 varchar(16) default NULL,
  profession varchar(48) default NULL,
  qualification varchar(48) default NULL,
  os_as_professional char(3) default NULL,
  number_of_projects int(2) default NULL,
  name_of_projects varchar(255) default NULL,
  nonprog varchar(255) default NULL,
  creation timestamp(14) NOT NULL,
  PRIMARY KEY  (username),
  UNIQUE KEY develid (develid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `extra_perms`
#

CREATE TABLE extra_perms (
  username varchar(24) NOT NULL default '',
  showname char(3) NOT NULL default '',
  showemail char(3) NOT NULL default '',
  search char(3) NOT NULL default '',
  contact char(3) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `faq`
#

CREATE TABLE faq (
  faqid int(8) unsigned NOT NULL auto_increment,
  language varchar(24) NOT NULL default '',
  question blob NOT NULL,
  answer blob NOT NULL,
  PRIMARY KEY  (faqid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `languages`
#

CREATE TABLE languages (
  code int(11) NOT NULL default '0',
  language varchar(64) NOT NULL default '',
  translation varchar(64) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `os_projects`
#

CREATE TABLE os_projects (
  username varchar(24) NOT NULL default '',
  projectname varchar(64) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  comment text NOT NULL,
  PRIMARY KEY  (username,projectname)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_abilities`
#

CREATE TABLE prog_abilities (
  code int(11) NOT NULL default '0',
  ability varchar(64) NOT NULL default '',
  translation varchar(64) NOT NULL default '',
  colname varchar(64) NOT NULL default '',
  PRIMARY KEY  (code,translation)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_ability_values`
#

CREATE TABLE prog_ability_values (
  username varchar(64) NOT NULL default '',
  network int(11) default NULL,
  system int(11) default NULL,
  kernel int(11) default NULL,
  qt int(11) default NULL,
  kde int(11) default NULL,
  gtk int(11) default NULL,
  gnome int(11) default NULL,
  sdl int(11) default NULL,
  admin int(11) default NULL,
  data_bases int(11) default NULL,
  docs int(11) default NULL,
  translate int(11) NOT NULL default '0',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_ability_watch`
#

CREATE TABLE prog_ability_watch (
  username varchar(64) NOT NULL default '',
  network int(11) default NULL,
  system int(11) default NULL,
  kernel int(11) default NULL,
  qt int(11) default NULL,
  kde int(11) default NULL,
  gtk int(11) default NULL,
  gnome int(11) default NULL,
  sdl int(11) default NULL,
  admin int(11) default NULL,
  data_bases int(11) default NULL,
  docs int(11) default NULL,
  translate int(11) NOT NULL default '0',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_language_values`
#

CREATE TABLE prog_language_values (
  username varchar(64) NOT NULL default '',
  c int(11) default NULL,
  cpp int(11) default NULL,
  objective_c int(11) default NULL,
  java int(11) default NULL,
  python int(11) default NULL,
  perl int(11) default NULL,
  php int(11) default NULL,
  shell_script int(11) default NULL,
  html int(11) default NULL,
  lisp int(11) default NULL,
  latex int(11) default NULL,
  pascal int(11) default NULL,
  fortran int(11) default NULL,
  basic int(11) default NULL,
  visual_basic int(11) default NULL,
  java_script int(11) default NULL,
  sql int(11) default NULL,
  ada int(11) default NULL,
  modula int(11) default NULL,
  eiffel int(11) default NULL,
  prolog int(11) default NULL,
  xml int(11) default NULL,
  smalltalk int(11) default NULL,
  tcl int(11) default NULL,
  scheme int(11) default NULL,
  make int(11) default NULL,
  cvs int(11) default NULL,
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_language_watch`
#

CREATE TABLE prog_language_watch (
  username varchar(64) NOT NULL default '',
  c int(11) default NULL,
  cpp int(11) default NULL,
  objective_c int(11) default NULL,
  java int(11) default NULL,
  python int(11) default NULL,
  perl int(11) default NULL,
  php int(11) default NULL,
  shell_script int(11) default NULL,
  html int(11) default NULL,
  lisp int(11) default NULL,
  latex int(11) default NULL,
  pascal int(11) default NULL,
  fortran int(11) default NULL,
  basic int(11) default NULL,
  visual_basic int(11) default NULL,
  java_script int(11) default NULL,
  sql int(11) default NULL,
  ada int(11) default NULL,
  modula int(11) default NULL,
  eiffel int(11) default NULL,
  prolog int(11) default NULL,
  xml int(11) default NULL,
  smalltalk int(11) default NULL,
  tcl int(11) default NULL,
  scheme int(11) default NULL,
  make int(11) default NULL,
  cvs int(11) default NULL,
  ruby int(11) NOT NULL default '0',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_languages`
#

CREATE TABLE prog_languages (
  code int(11) NOT NULL default '0',
  language varchar(64) NOT NULL default '',
  colname varchar(64) NOT NULL default '',
  PRIMARY KEY  (code)
) TYPE=MyISAM;

