<?php

######################################################################
# DevCounter
# ================================================
#
# Copyright (c) 2001 by
#                Gregorio Robles (grex@scouts-es.org)
#
# BerliOS DevCounter: http://sourceagency.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This is the index file
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
?>

<!-- content -->

<?php


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
      $bx->box_title($username);
      $bx->box_body_begin();
      htmlp_link("questionaire.php3","",$t->translate("please enter your profile"));
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
	 $bx->box_title($username);
	 $bx->box_body_begin();
	 htmlp_link("addproj.php3","",$t->translate("please enter your project data"));
	 $bx->box_body_end();
	 $bx->box_end();
	}
     }
   echo " ";
  }

?>
<!-- end content -->

<?php
require("footer.inc");
@page_close();
?>
