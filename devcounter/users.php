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
# Lists the developers registered in system
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: users.php,v 1.2 2002/08/26 10:15:04 helix Exp $
#
######################################################################

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require "header.inc";

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,$th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
if (($config_perm_users != "all") && (!isset($perm) || !$perm->have_perm($config_perm_users))) {
  $be->box_full($t->translate("Error"), $t->translate("Access denied"));
} else {

  if (!isset($by) || empty($by)) {
    $by = "%";
  }

  $alphabet = array ("A","B","C","D","E","F","G","H","I","J","K","L",
		"M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
  $msg = "[ ";

  while (list(, $ltr) = each($alphabet)) {
    $msg .= "<a href=\"".$sess->self_url().$sess->add_query(array("by" => $ltr."%"))."\">$ltr</a> | ";
  }

  $msg .= "<a href=\"".$sess->self_url().$sess->add_query(array("by" => "%"))."\">".$t->translate("All")."</a> ]";

  $where = "auth_user.username LIKE '$by'";

  $bs->box_strip($msg);
  $db->query("SELECT * FROM auth_user, extra_perms WHERE $where AND auth_user.username=extra_perms.username ORDER BY auth_user.username ASC");
  $bx->box_begin();
  $bx->box_title($t->translate("Developers")." : ".ereg_replace("%","",$by));
  $bx->box_body_begin();

  $bx->box_columns_begin(4);
  $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
  $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
  $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
  $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
  $bx->box_next_row_of_columns();

  $i = 1;
  while($db->next_record()) {
  	if ($i%2 != 0) $bgcolor = "gold";
  	else $bgcolor = "#FFFFFF";
 
	$username = $db->f("username");
	$bx->box_column("right","",$bgcolor,$i);
	$pquery["devname"] = $db->f("username") ;
	$db2->query("SELECT * from developers,extra_perms WHERE developers.username='$username'");
	if ($db2->num_rows() == 0)
	{ $bx->box_column("center","",$bgcolor,$username); }
	else
	{ $bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$username)); }
	if ($db->f("showname")=="yes")
	  {
	   $bx->box_column("center","",$bgcolor,$db->f("realname"));
	  }
	else
	  {
	   $bx->box_column("center","",$bgcolor,"-- % ---");
	  }
	if ($db->f("showemail")=="yes")
	  {
	   $bx->box_column("center","",$bgcolor,html_link("mailto:".$db->f("email_usr"),"",ereg_replace("@"," at ",htmlentities($db->f("email_usr")))));
	  }
	else
	  {
	   $bx->box_column("center","",$bgcolor,"--- % ---");
	  }
	$bx->box_next_row_of_columns();
	$i++;
  }
  $bx->box_columns_end();
  $bx->box_body_end();
  $bx->box_end();
}
?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
