<?php
######################################################################
# DevCounter
# ================================================
#
# Copyright (c) 2001 by
#                Gregorio Robles (grex@scouts-es.org),
#		 Susanne Gruenbaum (gruenbaum@fokus.gmd.de) and
#                Lutz Henckel (lutz.henckel@fokus.gmd.de)
#
# BerliOS DevCounter: http://sourceagency.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This file contains the verification procedure when registering
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################


page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) 
{
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php


$counter=0;

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
   //echo " - $projectname - $projecturl - $comment - $username";
   switch($option) {
    case "change":
    $query = "UPDATE os_projects SET  projectname = '$projectname', url = '$projecturl', comment='$comment'  WHERE (username='$username' and projectname='$oldpname')";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("Project updated")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    
    
    break;

    case "delete":
    $db->query("delete from os_projects where username='$username' AND projectname='$oldpname'");
    if ($db->affected_rows() == 1 )
     {
      $db->query("SELECT number_of_projects from developers where username='$username'");
      $db->next_record("");
      $number_of_projects=$db->f("number_of_projects");
      $number_of_projects--;
      $db->query("UPDATE developers SET number_of_projects='$number_of_projects' WHERE username='$username'");
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("Project deleted")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    
    break;

    case "add":
    $db->query("INSERT os_projects SET  username = '$username', projectname = '$projectname', url = '$projecturl', comment='$comment'");
    if ($db->affected_rows() == 1 )
     {
      $db->query("SELECT number_of_projects from developers where username='$username'");
      $db->next_record("");
      $number_of_projects=$db->f("number_of_projects");
      $number_of_projects++;
      $db->query("UPDATE developers SET number_of_projects='$number_of_projects' WHERE username='$username'");
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("Project added")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    
    
    break;

   }
   $db->query("SELECT * from developers WHERE username='$username'");
   $db->next_record();
   $number_of_projects = $db->f("number_of_projects");
   if ($number_of_projects>0)
     {
      $db->query("SELECT * from os_projects ");
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
	 htmlp_form_action("projects.php3",array(),"POST");
	 htmlp_form_hidden("oldpname", $db->f("projectname") );
	 htmlp_form_hidden("option", "change" );
	 $bx->box_column("right","",$bgcolor,$counter);
	 $bx->box_column("center","",$bgcolor,html_input_text("projectname", 25, 64, $db->f("projectname")));
	 $bx->box_column("center","",$bgcolor,html_input_text("projecturl", 35, 255, $db->f("url")));
	 $bx->box_column("center","",$bgcolor,html_input_text("comment", 35, 400, $db->f("comment")));
         $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Change")));
	 htmlp_form_end();
	 htmlp_form_action("projects.php3",array(),"POST");
	 htmlp_form_hidden("oldpname", $db->f("projectname") );
	 htmlp_form_hidden("option", "delete" );
	 $bgcolor = "gold";
	 $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete")));
	 htmlp_form_end();
	 $bx->box_next_row_of_columns();
	 $bgcolor = "#FFFFFF";
         
	}
       $bgcolor = "gold";
       htmlp_form_action("projects.php3",array(),"POST");
       htmlp_form_hidden("option", "add" );
       $bx->box_column("right","",$bgcolor,"--");
       $bx->box_column("center","",$bgcolor,html_input_text("projectname", 25, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("projecturl", 35, 255, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("comment", 35, 400, ""));
       $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Add Project")));
       $bx->box_column("center","",$bgcolor,"--");
       $bx->box_columns_end();
       htmlp_form_end();
       $bx->box_body_end();
       $bx->box_end();
      
      
     }
   else
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Error"));
      $bx->box_body_begin();
      echo $t->translate("No Projects")."\n";
      $bx->box_body_end();
      $bx->box_end();

     }
  }

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
