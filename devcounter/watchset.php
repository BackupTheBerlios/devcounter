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
# $Id: watchset.php,v 1.8 2002/09/17 10:23:33 helix Exp $
#
######################################################################

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

require("./include/header.inc");

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
    $db->query("SELECT * FROM prog_ability_watch WHERE username='$username'");
    if ($db->next_record()) {
		$query = "UPDATE ";
		$update = 1;
	} else {
		$query = "INSERT INTO ";
		$update = 0;
	}

	if (isset($action) && $action == "set") {

	$counter=0;
	$query1 = $query."prog_ability_watch SET username='$username'";
	while ($counter < count($ability)) {
		$counter++;
		$db2->query("SELECT colname FROM prog_abilities WHERE code='$counter'");
		$db2->next_record();
		$query1 .= ", ".$db2->f("colname")."='$ability[$counter]'";
	}
	if ($update) $query1 .= " WHERE username='$username'";
	$db->query($query1);

	$counter=0;
	$query2 = $query."prog_language_watch SET username='$username'";
	while ($counter < count($plang)) {
		$counter++;
		$db2->query("SELECT colname FROM prog_languages WHERE code='$counter'");
		$db2->next_record();
		$query2 .= ", ".$db2->f("colname")."='$plang[$counter]'";
	}
	if ($update) $query2 .= " WHERE username='$username'";
	$db->query($query2);
	$bx->box_full($t->translate("Done"),
		$t->translate("Your Developers Watch has been set succesfully")
		.".<br>"
		.$t->translate("You will be informed by email, if developers with corresponding abilities and expriences becomes available")
		.".");

	} elseif (isset($action) && $action == "delete") {
		$db->query("DELETE FROM prog_ability_watch WHERE username='$username'");
		$db->query("DELETE FROM prog_language_watch WHERE username='$username'");
		$bx->box_full($t->translate("Done"), $t->translate("Your Developers Watch has been deleted succesfully"));
	} else {
		$be->box_full($t->translate("Error"), $t->translate("Invalid action specified"));
	}
}
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
