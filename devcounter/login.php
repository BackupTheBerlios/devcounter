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
# This is the login file: here authenticated sessions start
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: login.php,v 1.4 2002/08/27 09:59:41 helix Exp $
#
######################################################################  

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

require("./include/header.inc");

$bx = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
if ($perm->have_perm("user_pending")) {
  $be->box_full($t->translate("Error"), $t->translate("Access denied"));
  $auth->logout();
} else {
  $msg = $t->translate("You are logged in as")." <b>".$auth->auth["uname"]."</b> ".$t->translate("with")." "
  ."<b>".$auth->auth["perm"]."</b> ".$t->translate("permission")."."
  ."<br>".$t->translate("Your authentication is valid until")." <b>".timestr($auth->auth["exp"])."</b>";
  $bx->box_full($t->translate("Welcome to $sys_name"), $msg);

if (empty($auth->auth["uname"]))
  {
    echo " ";
  }
else
  {
   $username = $auth->auth["uname"];
   
   $db->query("SELECT * from developers WHERE username='$username'");
   if ($db->num_rows() ==0)
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Developer").": ".$username);
      $bx->box_body_begin();
      htmlp_link("questionaire.php","",$t->translate("Please enter your Profile"));
      $bx->box_body_end();
      $bx->box_end();
     }
   else
     {
      
      $db->next_record();
      $number_of_projects = $db->f("number_of_projects");
      
      $db->query("SELECT * from os_projects WHERE username='$username'");
      if ($db->num_rows() ==0 && $number_of_projects>0)
        {
	 $bx->box_begin();
         $bx->box_title($t->translate("Developer").": ".$username);
	 $bx->box_body_begin();
	 htmlp_link("addproj.php","",$t->translate("Please enter your Project Data"));
	 $bx->box_body_end();
	 $bx->box_end();
	}
     }
   echo " ";
  }
}
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
