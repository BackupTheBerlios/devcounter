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
# $Id: projects.php,v 1.7 2004/03/02 09:22:58 helix Exp $
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

if (empty($auth->auth["uname"]))
  {
   $be->box_full($t->translate("Not logged in"), $t->translate("Please login first"));
  }
else
  {
   $username=$auth->auth["uname"];
   //echo " - $projectname - $projecturl - $pcomment - $username";
   switch($option) {
    case "change":
    $pcomment = htmlentities($pcomment);
    $query = "UPDATE os_projects SET  projectname = '$projectname', url = '$projecturl', comment='$pcomment'  WHERE (username='$username' and projectname='$oldpname')";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $bx->box_full($t->translate("Success"), $t->translate("Project updated"));
     }
    break;

    case "delete":
    $db->query("delete from os_projects where username='$username' AND projectname='$oldpname'");
    if ($db->affected_rows() == 1 )
     {
      $bx->box_full($t->translate("Success"), $t->translate("Project deleted"));
     }
   $db->query("SELECT * from os_projects where username='$username'");
   $number_of_projects=$db->num_rows();
   $db->query("UPDATE developers SET number_of_projects='$number_of_projects' WHERE username='$username'");
    break;

    case "add":
    if (!empty($projectname))
      {
       $pcomment = htmlentities($pcomment);
       $db->query("INSERT os_projects SET  username = '$username', projectname = '$projectname', url = '$projecturl', comment='$pcomment'");
       if ($db->affected_rows() == 1 )
        {
         $bx->box_full($t->translate("Success"), $t->translate("Project added"));
        }
      }
    else
      {
       $be->box_full($t->translate("Error"), $t->translate("Empty Project"));
      }
   $db->query("SELECT * from os_projects where username='$username'");
   $number_of_projects=$db->num_rows();
   $db->query("UPDATE developers SET number_of_projects='$number_of_projects' WHERE username='$username'");
    break;

   }
   $db->query("SELECT * FROM developers WHERE username='$username'");
   $db->next_record();
   $number_of_projects = $db->f("number_of_projects");
   $db->query("SELECT COUNT(*) FROM os_projects WHERE username='$username'");
   $db->next_record();
   $projects_entered = $db->f("COUNT(*)");

   if ($number_of_projects <= $projects_entered)
     {
      $db->query("SELECT * from os_projects WHERE username='$username'");
      $bx->box_columns_begin(6);
      $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Projectname")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ProjectURL")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Comment")."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
      while ($counter!=$number_of_projects)
        {
         $db->next_record();
         $counter++;
	 if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
  	 else {$bgcolor = "#E0E0E0";}
	 htmlp_form_action("projects.php",array(),"POST");
	 htmlp_form_hidden("oldpname", $db->f("projectname") );
	 htmlp_form_hidden("option", "change" );
	 $bx->box_column("right","",$bgcolor,$counter);
	 $bx->box_column("center","",$bgcolor,html_input_text("projectname", 25, 64, $db->f("projectname")));
	 $bx->box_column("center","",$bgcolor,html_input_text("projecturl", 35, 255, $db->f("url")));
	 $bx->box_column("center","",$bgcolor,html_input_text("pcomment", 35, 400, $db->f("comment")));
         $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Change"),""));
	 htmlp_form_end();
	 htmlp_form_action("projects.php",array(),"POST");
	 htmlp_form_hidden("oldpname", $db->f("projectname") );
	 htmlp_form_hidden("option", "delete" );
	 $bgcolor = "gold";
	 $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete"),""));
	 htmlp_form_end();
	 $bx->box_next_row_of_columns();
	 $bgcolor = "#FFFFFF";
         
	}
       $bgcolor = "gold";
       htmlp_form_action("projects.php",array(),"POST");
       htmlp_form_hidden("option", "add" );
       $bx->box_column("right","",$bgcolor,"--");
       $bx->box_column("center","",$bgcolor,html_input_text("projectname", 25, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("projecturl", 35, 255, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("pcomment", 35, 400, ""));
       $bx->box_colspan(2,"center",$bgcolor,html_form_submit($t->translate("Add Project"),""));
       $bx->box_columns_end();
       htmlp_form_end();
     }
   else
     {
      $be->box_begin();
      $be->box_title($t->translate("Error"));
      $be->box_body_begin();
      htmlp_link("addproj.php","",$t->translate("Enter your projects here"));
      $be->box_body_end();
      $be->box_end();
     }
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
