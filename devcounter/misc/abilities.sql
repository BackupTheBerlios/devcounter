# --------------------------------------------------------
#
# Table structure for table 'prog_abilities'
#

DROP TABLE IF EXISTS prog_abilities;
CREATE TABLE prog_abilities (
   code int(11) NOT NULL,
   ability varchar(64) NOT NULL,
   translation varchar(64) NOT NULL,
   colname varchar(64) NOT NULL
);


#
# Dumping data for table 'prog_abilities'
#


INSERT INTO prog_abilities VALUES ('1', 'network programming', 'English','network');
INSERT INTO prog_abilities VALUES ('1', 'Netzwerkprogrammierung', 'German','network');
INSERT INTO prog_abilities VALUES ('2', 'system programming', 'English','system');
INSERT INTO prog_abilities VALUES ('2', 'Systemprogrammierung', 'German','system');
INSERT INTO prog_abilities VALUES ('3', 'kernel programming', 'English','kernel');
INSERT INTO prog_abilities VALUES ('3', 'Kernelprogrammierung', 'German','kernel');
INSERT INTO prog_abilities VALUES ('4', 'Qt', 'English','qt');
INSERT INTO prog_abilities VALUES ('4', 'Qt', 'German','qt');
INSERT INTO prog_abilities VALUES ('5', 'KDE', 'English','kde');
INSERT INTO prog_abilities VALUES ('5', 'KDE', 'German','kde');
INSERT INTO prog_abilities VALUES ('6', 'GTK', 'English','gtk');
INSERT INTO prog_abilities VALUES ('6', 'GTK', 'German','gtk');
INSERT INTO prog_abilities VALUES ('7', 'Gnome', 'English','gnome');
INSERT INTO prog_abilities VALUES ('7', 'Gnome', 'German','gnome');
INSERT INTO prog_abilities VALUES ('8', 'libSDL', 'English','sdl');
INSERT INTO prog_abilities VALUES ('8', 'libSDL', 'German','sdl');
INSERT INTO prog_abilities VALUES ('9', 'administration', 'English','admin');
INSERT INTO prog_abilities VALUES ('9', 'Administration', 'German','admin');
INSERT INTO prog_abilities VALUES ('10', 'data bases', 'English','data_bases');
INSERT INTO prog_abilities VALUES ('10', 'Datenbanken', 'German','data_bases');
INSERT INTO prog_abilities VALUES ('11', 'documentation writing', 'English','docs');
INSERT INTO prog_abilities VALUES ('11', 'Schreiben von Dokumentationen', 'German','docs');


# --------------------------------------------------------
#
# Table structure for table 'prog_ability_values'
#

DROP TABLE IF EXISTS prog_ability_values;
CREATE TABLE prog_ability_values (
   username varchar(64) NOT NULL,
   network int(11),
   system int(11),
   kernel int(11),
   qt int(11),
   kde int(11),
   gtk int(11),
   gnome int(11),
   sdl int(11),
   admin int(11),
   data_bases int(11),
   docs int(11),


   PRIMARY KEY (username)
   );



# --------------------------------------------------------
#
# Table structure for table 'prog_language_values'
#

DROP TABLE IF EXISTS prog_language_values;
CREATE TABLE prog_language_values (
   username varchar(64) NOT NULL,
   c int(11),
   cpp int(11),
   objective_c int(11),
   java int(11),
   python int(11),
   perl int(11),
   php int(11),
   shell_script int(11),
   html int(11),
   lisp int(11),
   latex int(11),
   pascal int(11),
   fortran int(11),
   basic int(11),
   visual_basic int(11),
   java_script int(11),
   sql int(11),
   ada int(11),
   modula int(11),
   eiffel int(11),
   prolog int(11),
   xml int(11),
   smalltalk int(11),
   tcl int(11),
   scheme int(11),
   make int(11),
   cvs int(11),

   PRIMARY KEY (username)
   );





 # Programming Languages and other type of languages



# --------------------------------------------------------
#
# Table structure for table 'prog_languages'
#

DROP TABLE IF EXISTS prog_languages;
CREATE TABLE prog_languages (
   code int(11) NOT NULL,
   language varchar(64) NOT NULL,
   colname varchar(64) NOT NULL
);


#
# Dumping data for table 'prog_languages'
#



INSERT INTO prog_languages VALUES ( '1', 'C', 'c');
INSERT INTO prog_languages VALUES ( '2', 'C++', 'cpp');
INSERT INTO prog_languages VALUES ( '3', 'Objective C', 'objective_c');
INSERT INTO prog_languages VALUES ( '4', 'Java', 'java');
INSERT INTO prog_languages VALUES ( '5', 'Python', 'python');
INSERT INTO prog_languages VALUES ( '6', 'Perl', 'perl');
INSERT INTO prog_languages VALUES ( '7', 'PHP', 'php');
INSERT INTO prog_languages VALUES ( '8', 'Shell Script', 'shell_script');
INSERT INTO prog_languages VALUES ( '9', 'HTML', 'html');
INSERT INTO prog_languages VALUES ( '10', 'Lisp', 'lisp');
INSERT INTO prog_languages VALUES ( '11', 'Latex', 'latex');
INSERT INTO prog_languages VALUES ( '12', 'Pascal', 'pascal');
INSERT INTO prog_languages VALUES ( '13', 'Fortran', 'fortran');
INSERT INTO prog_languages VALUES ( '14', 'Basic', 'basic');
INSERT INTO prog_languages VALUES ( '15', 'Visual Basic', 'visual_basic');
INSERT INTO prog_languages VALUES ( '16', 'Java Script', 'java_script');
INSERT INTO prog_languages VALUES ( '17', 'SQL', 'sql');
INSERT INTO prog_languages VALUES ( '18', 'Ada', 'ada');
INSERT INTO prog_languages VALUES ( '19', 'Modula', 'modula');
INSERT INTO prog_languages VALUES ( '20', 'Eiffel', 'eiffel');
INSERT INTO prog_languages VALUES ( '21', 'Prolog', 'prolog');
INSERT INTO prog_languages VALUES ( '22', 'XML', 'xml');
INSERT INTO prog_languages VALUES ( '23', 'Smalltalk', 'smalltalk');
INSERT INTO prog_languages VALUES ( '24', 'TCL', 'tcl');
INSERT INTO prog_languages VALUES ( '25', 'Scheme', 'scheme');
INSERT INTO prog_languages VALUES ( '26', 'Make', 'make');
INSERT INTO prog_languages VALUES ( '27', 'CVS', 'cvs');


