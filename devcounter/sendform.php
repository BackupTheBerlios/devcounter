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
# Form to contact developer
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: sendform.php,v 1.5 2002/08/27 11:16:59 helix Exp $
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

$bx = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
$db->query("SELECT * from extra_perms,auth_user WHERE auth_user.username='$devname' AND extra_perms.username='$devname'");
   if ($db->num_rows() ==0)
     {
      $be->box_full($t->translate("Error"), $t->translate("Unknown Developer"));
     }
   else
     {
      $db->next_record();
      //echo ".- ".$db->f("username").$db->num_rows()." -.";
      if ($db->f("contact")=="yes")
        {
         $bx->box_begin();
         $bx->box_title($t->translate("contact developer"));
         $bx->box_body_begin();
         mail($db->f("email_usr"),"[$sys_name] $subject",$body,"From: $s_email\nReply-To: $s_email\nX-Mailer: PHP");
	 echo $t->translate("Message sent");
         $bx->box_body_end();
         $bx->box_end();
        }
      else
        {
         $be->box_full($t->translate("Error"), $t->translate("Developer does not allow to contact him"));
	}
     }
   echo " ";
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
