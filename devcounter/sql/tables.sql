# phpMyAdmin MySQL-Dump
# version 2.2.7-pl1
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: db.berlios.de
# Generation Time: Sep 02, 2002 at 04:42 PM
# Server version: 3.23.37
# PHP Version: 4.0.6
# Database : `devcounter`
# --------------------------------------------------------

USE devcounter;

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
  domaine varchar(20) NOT NULL default '',
  description varchar(50) NOT NULL default '',
  language varchar(16) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `developers`
#

CREATE TABLE developers (
  develid bigint(20) unsigned NOT NULL auto_increment,
  username varchar(24) NOT NULL default '',
  nationality int(11) NOT NULL default '999',
  actual_country int(11) NOT NULL default '999',
  year_of_birth int(4) NOT NULL default '0',
  gender int(11) NOT NULL default '1',
  mother_tongue int(11) NOT NULL default '999',
  other_lang_1 int(11) NOT NULL default '999',
  other_lang_2 int(11) NOT NULL default '999',
  profession int(11) NOT NULL default '1',
  qualification int(11) NOT NULL default '1',
  number_of_projects int(4) default NULL,
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
  showname char(3) default 'no',
  showemail char(3) default 'no',
  search char(3) default 'no',
  contact char(3) default 'no'
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
# Table structure for table `gender`
#

CREATE TABLE gender (
  gendid int(11) NOT NULL auto_increment,
  gender varchar(128) NOT NULL default 'No Entry',
  KEY weightid (gendid)
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
# Table structure for table `profession`
#

CREATE TABLE profession (
  profid int(11) NOT NULL auto_increment,
  profession varchar(128) NOT NULL default 'No Entry',
  KEY weightid (profid)
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
  network int(11) NOT NULL default '1',
  system int(11) NOT NULL default '1',
  kernel int(11) NOT NULL default '1',
  qt int(11) NOT NULL default '1',
  kde int(11) NOT NULL default '1',
  gtk int(11) NOT NULL default '1',
  gnome int(11) NOT NULL default '1',
  sdl int(11) NOT NULL default '1',
  admin int(11) NOT NULL default '1',
  data_bases int(11) NOT NULL default '1',
  docs int(11) NOT NULL default '1',
  translate int(11) NOT NULL default '1',
  opengl int(11) NOT NULL default '1',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_ability_watch`
#

CREATE TABLE prog_ability_watch (
  username varchar(64) NOT NULL default '',
  network int(11) NOT NULL default '1',
  system int(11) NOT NULL default '1',
  kernel int(11) NOT NULL default '1',
  qt int(11) NOT NULL default '1',
  kde int(11) NOT NULL default '1',
  gtk int(11) NOT NULL default '1',
  gnome int(11) NOT NULL default '1',
  sdl int(11) NOT NULL default '1',
  admin int(11) NOT NULL default '1',
  data_bases int(11) NOT NULL default '1',
  docs int(11) NOT NULL default '1',
  translate int(11) NOT NULL default '1',
  opengl int(11) NOT NULL default '1',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_language_values`
#

CREATE TABLE prog_language_values (
  username varchar(64) NOT NULL default '',
  c int(11) NOT NULL default '1',
  cpp int(11) NOT NULL default '1',
  objective_c int(11) NOT NULL default '1',
  java int(11) NOT NULL default '1',
  python int(11) NOT NULL default '1',
  perl int(11) NOT NULL default '1',
  php int(11) NOT NULL default '1',
  shell_script int(11) NOT NULL default '1',
  html int(11) NOT NULL default '1',
  lisp int(11) NOT NULL default '1',
  latex int(11) NOT NULL default '1',
  pascal int(11) NOT NULL default '1',
  fortran int(11) NOT NULL default '1',
  basic int(11) NOT NULL default '1',
  visual_basic int(11) NOT NULL default '1',
  java_script int(11) NOT NULL default '1',
  sql int(11) NOT NULL default '1',
  ada int(11) NOT NULL default '1',
  modula int(11) NOT NULL default '1',
  eiffel int(11) NOT NULL default '1',
  prolog int(11) NOT NULL default '1',
  xml int(11) NOT NULL default '1',
  smalltalk int(11) NOT NULL default '1',
  tcl int(11) NOT NULL default '1',
  scheme int(11) NOT NULL default '1',
  make int(11) NOT NULL default '1',
  cvs int(11) NOT NULL default '1',
  ruby int(11) NOT NULL default '1',
  yacc int(11) NOT NULL default '1',
  flex int(11) NOT NULL default '1',
  PRIMARY KEY  (username)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `prog_language_watch`
#

CREATE TABLE prog_language_watch (
  username varchar(64) NOT NULL default '',
  c int(11) NOT NULL default '1',
  cpp int(11) NOT NULL default '1',
  objective_c int(11) NOT NULL default '1',
  java int(11) NOT NULL default '1',
  python int(11) NOT NULL default '1',
  perl int(11) NOT NULL default '1',
  php int(11) NOT NULL default '1',
  shell_script int(11) NOT NULL default '1',
  html int(11) NOT NULL default '1',
  lisp int(11) NOT NULL default '1',
  latex int(11) NOT NULL default '1',
  pascal int(11) NOT NULL default '1',
  fortran int(11) NOT NULL default '1',
  basic int(11) NOT NULL default '1',
  visual_basic int(11) NOT NULL default '1',
  java_script int(11) NOT NULL default '1',
  sql int(11) NOT NULL default '1',
  ada int(11) NOT NULL default '1',
  modula int(11) NOT NULL default '1',
  eiffel int(11) NOT NULL default '1',
  prolog int(11) NOT NULL default '1',
  xml int(11) NOT NULL default '1',
  smalltalk int(11) NOT NULL default '1',
  tcl int(11) NOT NULL default '1',
  scheme int(11) NOT NULL default '1',
  make int(11) NOT NULL default '1',
  cvs int(11) NOT NULL default '1',
  ruby int(11) NOT NULL default '1',
  yacc int(11) NOT NULL default '1',
  flex int(11) NOT NULL default '1',
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
  PRIMARY KEY  (code),
  UNIQUE KEY colname (colname),
  UNIQUE KEY code (code),
  UNIQUE KEY language (language)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `qualification`
#

CREATE TABLE qualification (
  qualid int(11) NOT NULL auto_increment,
  qualification varchar(128) NOT NULL default 'No Entry',
  KEY weightid (qualid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `weightings`
#

CREATE TABLE weightings (
  weightid int(11) NOT NULL auto_increment,
  weighting varchar(128) NOT NULL default 'No Experience',
  KEY weightid (weightid)
) TYPE=MyISAM;

CREATE TABLE requests (
  reqid bigint(20) unsigned NOT NULL auto_increment,
  reqtime timestamp(14) NOT NULL,
  username varchar(24) NOT NULL default '',
  category varchar(64) NOT NULL default '',
  tasktype varchar(64) NOT NULL default '',
  language int(11) NOT NULL default '999',
  projectname varchar(64) NOT NULL default '',
  reqsubject varchar(64) NOT NULL default '',
  reqmessage text NOT NULL,
  PRIMARY KEY  (reqid)
) TYPE=MyISAM;











    
