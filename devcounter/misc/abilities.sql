# --------------------------------------------------------
#
# Table structure for table 'prog_abilities'
#

DROP TABLE IF EXISTS prog_abilities;
CREATE TABLE languages (
   code int(11) NOT NULL,
   ability varchar(64) NOT NULL,
   translation varchar(64) NOT NULL
);


#
# Dumping data for table 'prog_abilities'
#


INSERT INTO prog_abilities VALUES ('1', 'network programming', 'English');
INSERT INTO prog_abilities VALUES ('1', 'Netzwerkprogrammierung', 'German');
INSERT INTO prog_abilities VALUES ('2', 'system programming', 'English');
INSERT INTO prog_abilities VALUES ('2', 'Systemprogrammierung', 'German');
INSERT INTO prog_abilities VALUES ('3', 'kernel programming', 'English');
INSERT INTO prog_abilities VALUES ('3', 'Kernelprogrammierung', 'German');
INSERT INTO prog_abilities VALUES ('4', 'Qt', 'English');
INSERT INTO prog_abilities VALUES ('4', 'Qt', 'German');
INSERT INTO prog_abilities VALUES ('5', 'KDE', 'English');
INSERT INTO prog_abilities VALUES ('5', 'KDE', 'German');
INSERT INTO prog_abilities VALUES ('6', 'GTK', 'English');
INSERT INTO prog_abilities VALUES ('6', 'GTK', 'German');
INSERT INTO prog_abilities VALUES ('7', 'Gnome', 'English');
INSERT INTO prog_abilities VALUES ('7', 'Gnome', 'German');
INSERT INTO prog_abilities VALUES ('8', 'libSDL', 'English');
INSERT INTO prog_abilities VALUES ('8', 'libSDL', 'German');
INSERT INTO prog_abilities VALUES ('9', 'administration', 'English');
INSERT INTO prog_abilities VALUES ('9', 'Administration', 'German');
INSERT INTO prog_abilities VALUES ('10', 'data bases', 'English');
INSERT INTO prog_abilities VALUES ('10', 'Datenbanken', 'German');
INSERT INTO prog_abilities VALUES ('11', 'documentation writing', 'English');
INSERT INTO prog_abilities VALUES ('11', 'Schreiben von Dokumentationen', 'German');


# --------------------------------------------------------
#
# Table structure for table 'prog_abilities_values'
#

DROP TABLE IF EXISTS prog_abilities;
CREATE TABLE languages (
   username varchar(64) NOT NULL,
   code int(11) NOT NULL,
   value int(11) NOT NULL
   );



# --------------------------------------------------------
#
# Table structure for table 'prog_languages_values'
#

DROP TABLE IF EXISTS prog_alanguages_values;
CREATE TABLE languages (
   username varchar(64) NOT NULL,
   code int(11) NOT NULL,
   value int(11) NOT NULL
   );





 # Programming Languages and other type of languages



# --------------------------------------------------------
#
# Table structure for table 'prog_languages'
#

DROP TABLE IF EXISTS prog_languages;
CREATE TABLE languages (
   code int(11) NOT NULL,
   ability varchar(64) NOT NULL
);


#
# Dumping data for table 'prog_languages'
#



INSERT INTO prog_languages VALUES ( '1', 'C');
INSERT INTO prog_languages VALUES ( '2', 'C++');
INSERT INTO prog_languages VALUES ( '3', 'Objective C');
INSERT INTO prog_languages VALUES ( '4', 'Java');
INSERT INTO prog_languages VALUES ( '5', 'Python');
INSERT INTO prog_languages VALUES ( '6', 'Perl');
INSERT INTO prog_languages VALUES ( '7', 'PHP');
INSERT INTO prog_languages VALUES ( '8', 'Shell Script');
INSERT INTO prog_languages VALUES ( '9', 'HTML');
INSERT INTO prog_languages VALUES ( '10', 'Lisp');
INSERT INTO prog_languages VALUES ( '11', 'Latex');
INSERT INTO prog_languages VALUES ( '12', 'Pascal');
INSERT INTO prog_languages VALUES ( '13', 'Fortran');
INSERT INTO prog_languages VALUES ( '14', 'Basic');
INSERT INTO prog_languages VALUES ( '15', 'Visual Basic');
INSERT INTO prog_languages VALUES ( '16', 'Java Script');
INSERT INTO prog_languages VALUES ( '17', 'SQL');
INSERT INTO prog_languages VALUES ( '18', 'Ada');
INSERT INTO prog_languages VALUES ( '19', 'Modula');
INSERT INTO prog_languages VALUES ( '20', 'Eiffel');
INSERT INTO prog_languages VALUES ( '21', 'Prolog');
INSERT INTO prog_languages VALUES ( '22', 'XML');
INSERT INTO prog_languages VALUES ( '23', 'Smalltalk');
INSERT INTO prog_languages VALUES ( '24', 'TCL');
INSERT INTO prog_languages VALUES ( '25', 'Scheme');
INSERT INTO prog_languages VALUES ( '26', 'Make');
INSERT INTO prog_languages VALUES ( '27', 'CVS');


