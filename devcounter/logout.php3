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
# This file contains the logout: session and authentications finish
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################  

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

$logout = 1; // Special status for the logout page (menubar, etc.)

require("header.inc");

$bx = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
$msg = $t->translate("You have been logged in as")." <b>".$auth->auth["uname"]."</b> ".$t->translate("with")." "
      ."<b>".$auth->auth["perm"]."</b> ".$t->translate("permission")."."
      ."<br>".$t->translate("Your authentication was valid until")." <b>"
      .timestr($auth->auth["exp"])
      ."</b>."
      ."<p>".$t->translate("This is all over now. You have been logged out").".";
$bx->box_full($t->translate("Logout"), $msg);
?>
<!-- end content -->

<?php
require("footer.inc");
$auth->logout();
page_close();
?>
