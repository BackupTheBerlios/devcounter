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
# This page inserts the data into the database
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: addproj.php,v 1.3 2002/08/27 09:59:41 helix Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,
              $th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->

<?php

if (empty($auth->auth["uname"]))
  {
   $bx->box_begin();
   $bx->box_title($t->translate("Not logged in"));
   $bx->box_body_begin();
   echo $t->translate("Please login first")."\n";
   $bx->box_body_end();
   $bx->box_end();
  }
else
  {
   $username=$auth->auth["uname"];
   $db->query("SELECT * from developers WHERE username='$username'");
   $db->next_record();
   $number_of_projects = $db->f("number_of_projects");
   if ($number_of_projects <= 0)
      $number_of_projects = 6;
   
       $counter=0;
       htmlp_form_action("addproj2db.php","","POST");
       htmlp_form_hidden("number_of_projects", $number_of_projects);
       
       //$bs->box_strip($msg);
       $bx->box_begin();
       $bx->box_title($t->translate("Please enter your Project Data"));
       $bx->box_body_begin();
	  
       $bx->box_columns_begin(4);
       $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Projectname")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ProjectURL")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Comment")."</b>");
       $bx->box_next_row_of_columns();
       $bgcolor = "#FFFFFF";
       
       while ($counter!=$number_of_projects)
         {
          $counter++;

	  $bx->box_column("right","",$bgcolor,$counter);
	  $bx->box_column("center","",$bgcolor,html_input_text("projectname[$counter]", 25, 64, ""));
	  $bx->box_column("center","",$bgcolor,html_input_text("projecturl[$counter]", 35, 255, ""));
	  $bx->box_column("center","",$bgcolor,html_input_text("pcomment[$counter]", 42, 400, ""));
	  $bx->box_next_row_of_columns();

	 }
       $bx->box_column("right","",$bgcolor,html_form_submit($t->translate("Send"),""));
       $bx->box_next_row_of_columns();
       $bx->box_columns_end();
       $bx->box_body_end();
       $bx->box_end();
  }
?>

<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
