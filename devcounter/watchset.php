<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Set Developers watch for users.
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: watchset.php,v 1.3 2002/08/26 19:46:59 helix Exp $
#
######################################################################

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
if (($config_perm_watch != "all") && (!isset($perm) || !$perm->have_perm($config_perm_watch))) {
	$be->box_full($t->translate("Error"), $t->translate("Access denied"));
} else {
	$username = $auth->auth["uname"];
	$counter=0;
	$query = "UPDATE prog_ability_watch SET username = '$username'";
	while ($counter < count($ability)) {
		$counter++;
		$db2->query("SELECT colname FROM prog_abilities WHERE code='$counter'");
		$db2->next_record();
		$query .= ", ".$db2->f("colname")."='$ability[$counter]'";
	}
	$query .= " WHERE username='$username'";
	$db->query($query);
echo "<p>query: $query\n";

	$counter=0;
	$query = "UPDATE prog_language_watch SET username = '$username'";
	while ($counter < count($plang)) {
		$counter++;
		$db2->query("SELECT colname FROM prog_languages WHERE code='$counter'");
		$db2->next_record();
		$query .= ", ".$db2->f("colname")."='$plang[$counter]'";
	}
	$query .= " WHERE username='$username'";
	$db->query($query);
echo "<p>query: $query\n";

	$bx->box_begin();
	$bx->box_title($t->translate("Done"));
	$bx->box_body_begin();
	echo "\n<P>";
	echo $t->translate("Your Developers Watch has been succesfully set");
	echo "\n<BR>";
	htmlp_link("./index.php", "", $t->translate("Please proceed with the main page"));
	echo "\n<P>";
	$bx->box_body_end();
	$bx->box_end();
}
?>
<!-- end content -->

<?php
require("footer.inc");
@page_close();
?>
