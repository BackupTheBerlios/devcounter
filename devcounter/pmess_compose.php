<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fraunhofer.de)
#       Stefan Heinze (heinze@fokus.fraunhofer.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This file contains the verification procedure when registering
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: pmess_compose.php,v 1.2 2004/03/02 09:22:58 helix Exp $
#
######################################################################

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) 
{
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("./include/header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
$counter=0;
$db->query("SELECT * from extra_perms WHERE username='$devname'");
if ($db->num_rows() ==0)
  {
   $be->box_full($t->translate("Error"), $t->translate("Unknown Developer"));
  }
else
  {
   $bx->box_begin();
   $bx->box_title($t->translate("Compose private message"));
   $bx->box_body_begin();
   htmlp_form_action("pmess_send.php", "", "POST");
   htmlp_form_hidden("option", "send" );
   htmlp_form_hidden("devname", $devname );

   if (empty($auth->auth["uname"]))
     {
      $sender = "-";
      htmlp_form_hidden("sender", $sender );
      echo $t->translate("Your E-Mail").":<BR>";
      htmlp_form_hidden("pmessto", $devname );
      htmlp_input_text("email", 50, 75, "");
      echo "<BR>\n";
     }
   else
     {
      $sender = $auth->auth["uname"];
      $email = "-";
      htmlp_form_hidden("sender", $sender );
      htmlp_form_hidden("email", $email );
     }
   
   echo $t->translate("Subject").":<BR>";
   htmlp_input_text("pmesssubject", 50, 75, "");
   htmlp_form_submit($t->translate("send"),"");
   echo "<BR>\n";
   
   echo "<BR>\n";
   echo$t->translate("Content").":<BR>";
   htmlp_textarea("pmessmessage",60,30,"nowrap",2000,"");
   htmlp_form_end();
   $bx->box_body_end();
   $bx->box_end();
   
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
