<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Stefan Heinze (heinze@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This is the index file
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: index.php,v 1.9 2002/10/19 12:13:24 Masato Exp $
#
######################################################################  


require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
	page_close();
	page_open(array("sess" => "DevCounter_Session",
					"auth" => "DevCounter_Auth",
					"perm" => "DevCounter_Perm"));
}

require("./include/header.inc");

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
?>

<!-- content -->

<?php

echo "<TABLE BORDER=\"0\" WIDTH=\"100%\">";
echo "<TR><TD VALIGN=\"top\">";

switch ($la) {
case "English":
	require("./include/English-intro.inc");
	break;
case "German":
	require("./include/German-intro.inc");
	break;
/*
case "Spanish":
	require("./include/Spanish-lang.inc");
	break;
case "French":
	require("./include/French-lang.inc");
	break;
*/
default:
	require("./include/English-intro.inc");
	break;
}
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) {
	$username = $auth->auth["uname"];

	$db->query("SELECT * from developers WHERE username='$username'");
	if ($db->num_rows() ==0) {
		$bx->box_begin();
		$bx->box_title($t->translate("Developer").": ".$username);
		$bx->box_body_begin();
		htmlp_link("questionaire.php","",$t->translate("Please enter your Profile"));
		$bx->box_body_end();
		$bx->box_end();
	} else {
		$db->next_record();
		$number_of_projects = $db->f("number_of_projects");
		$db->query("SELECT * from os_projects WHERE username='$username'");
		if ($db->num_rows() ==0 && $number_of_projects>0) {
			$bx->box_begin();
			$bx->box_title($t->translate("Developer").": ".$username);
			$bx->box_body_begin();
			htmlp_link("addproj.php","",$t->translate("Please enter your Project Data"));
			$bx->box_body_end();
			$bx->box_end();
		}
	}
}
echo " ";

echo "</TD><TD WIDTH=\"250\" VALIGN=\"top\">";

$bx->box_begin();
$bx->box_title($t->translate("Newest Requests"));
$bx->box_body_begin();

$db->query("SELECT * FROM requests ORDER BY reqtime DESC LIMIT 0,10");

while ($db->next_record()) {
	$reqsubject = $db->f("reqsubject");
	$reqid = $db->f("reqid");
	echo "<li>";
	$pquery["reqid"] = $reqid ;
	htmlp_link("req_show.php",$pquery,$reqsubject);
	echo " (".$db->f("username").")";
	$timestamp = mktimestamp($db->f("reqtime"));
	echo "\n<br>&nbsp;&nbsp;&nbsp;<span class=\"small\">[".timestr_short($timestamp)."]</span>\n";
}

$bx->box_body_end();
$bx->box_end();

$bx->box_begin();
$bx->box_title($t->translate("Newest Developers"));
$bx->box_body_begin();

$db->query("SELECT * FROM auth_user,developers,extra_perms where auth_user.username=developers.username AND auth_user.username=extra_perms.username ORDER BY developers.creation DESC LIMIT 0,10");

while ($db->next_record()) {
	$user_name = $db->f("username");
	echo "<li>";
	$rquery["devname"] = $user_name ;
	htmlp_link("showprofile.php",$rquery,$user_name);
	if ($db->f("showname") == "yes")
		echo " (".$db->f("realname").")";
	$timestamp = mktimestamp($db->f("creation"));
	echo "\n<br>&nbsp;&nbsp;&nbsp;<span class=\"small\">[".timestr_short($timestamp)."]</span>\n";
}

$bx->box_body_end();
$bx->box_end();

echo "</TD></TR>\n";
echo "</TABLE>\n";
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
