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
# $Id: sendform.php,v 1.6 2003/02/26 13:19:11 masato Exp $
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

if (empty($auth->auth["uname"]))
  {
   $be->box_full($t->translate("Not logged in"), $t->translate("Please login first"));
  }
else
  {
         $bx->box_begin();
         $bx->box_title($t->translate("contact developer"));
         $bx->box_body_begin();
         mail($pmessto,"[$sys_name] $pmesssubject",$pmessmessage,"From: $s_email\nReply-To: $s_email\nX-Mailer: PHP");
	 echo $t->translate("Message sent");
	 //echo "<BR><BR>";
	 //echo  "(from $s_email)<BR>(to $pmessto)";
         $bx->box_body_end();
         $bx->box_end();


  }
   echo " ";
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
