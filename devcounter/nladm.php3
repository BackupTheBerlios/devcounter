<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001 by
#       Lutz Henckel (lutz.henckel@fokus.gmd.de) and
#       Gregorio Robles (grex@scouts-es.org)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This file is usefull for administrating the daily/weekly newsletter
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
if (($config_perm_nladm != "all") && (!isset($perm) || !$perm->have_perm($config_perm_nladm)) || (!$ml_list)) {
  if (!$ml_list) {
    $be->box_full($t->translate("Error"), $t->translate("The Mailing Lists are not enabled").".");
  } else {
    $be->box_full($t->translate("Error"), $t->translate("Access denied"));
  }
} else {

  if (!isset($period)) $period = "daily";
  if ($msg = nlmsg($period)) {
	$title = "$sys_name ".$t->translate("$period newsletter for");
    $subj = $title." ".date("l dS of F Y");
    $title .= " ".strftime("%A, %e %b %Y, %T %Z",time());
    if (isset($send)) { // Send newsletter
      switch ($period) {
	case "weekly":
	  mail($ml_weeklynewstoaddr, $subj, $msg,
	  "From: $ml_newsfromaddr\nReply-To: $ml_newsreplyaddr\nX-Mailer: PHP");
	  $bx->box_full($t->translate("Weekly Newsletter"), $t->translate("Newsletter was sent at ").timestr(time()));
	  break;
        case "daily":
	default:
	  mail($ml_newstoaddr, $subj, $msg,
	  "From: $ml_newsfromaddr\nReply-To: $ml_newsreplyaddr\nX-Mailer: PHP");
	  $bx->box_full($t->translate("Daily Newsletter"), $t->translate("Newsletter was sent at ").timestr(time()));
	  break;
      }
    }
    $bx->box_full($title, "<pre>\n".htmlentities($msg)."\n</pre>\n");
?>
<form method="get" action="<?php $sess->pself_url() ?>">
<?php
    echo "<input type=\"hidden\" name=\"period\" value=\"$period\">\n";
    echo "<center><p><input type=\"submit\" name=\"send\" value=\"".$t->translate("Send newsletter")."\"></center>\n";
    echo "</form>\n";
  } else {
    $be->box_full($t->translate("Error"), $t->translate("No Developer found").".");
  }
}
?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
