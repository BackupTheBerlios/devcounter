   
   # --------------------------------------------------------
#
# Table structure for table 'developers'
#

DROP TABLE IF EXISTS developers;
CREATE TABLE developers (
   develid bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   username varchar(24),
   nationality varchar(24),
   actual_country varchar(24),
   year_of_birth int(4),
   gender char(8),
#   email_domain char(3),
   mother_tongue varchar(16),
   other_lang_1 varchar(16),
   other_lang_2 varchar(16),
#   other_lang_3 varchar(16),
#   other_lang_4 varchar(16),
# Professional data
   profession varchar(48),
   qualification varchar(48),
   os_as_professional char(3),
#   profit varchar(48),
#   boss varchar(48),
#   job varchar(24),
#   income varchar(24),
#   hours_per_week varchar(24),
# Computer experience
   number_of_projects int(2),
   name_of_projects varchar(255),
# Operation Systems / Distributions
#   distro varchar(16),
# Desktop
#   favorite_desktop varchar(8),
# Editor
#   favorite_editor varchar(8),
#   why_favorite_editor varchar(16),
# Open Source or Free Software
#   os_or_freesoft varchar(16),
# Else
#   language_form varchar(16),
   nonprog varchar(255),
   creation timestamp(14),
   UNIQUE develid (develid)   

);

DROP TABLE IF EXISTS extra_perms;
CREATE TABLE extra_perms (
   username varchar(24) NOT NULL,
   showname varchar(3) NOT NULL,
   showemail varchar(3) NOT NULL,
   search varchar(3) NOT NULL,
   contact varchar(3) NOT NULL
);

DROP TABLE IF EXISTS os_projects;
CREATE TABLE os_projects (
   username varchar(24) NOT NULL,
   projectname varchar(64) NOT NULL,
   url varchar(255) NOT NULL,
   comment text NOT NULL,
   PRIMARY KEY (username,projectname)
);
