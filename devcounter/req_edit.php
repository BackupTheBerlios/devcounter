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
# $Id: req_edit.php,v 1.3 2004/03/02 09:22:58 helix Exp $
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
   $username= $auth->auth["uname"];
   $db->query("SELECT * FROM requests WHERE reqid='$reqid' AND username='$username'");
   if ($db->num_rows()==1)
     {
      $db->next_record();
      $bx->box_begin();
      $bx->box_title($t->translate("edit request"));
      $bx->box_body_begin();
      htmlp_form_action("req_manage.php", "", "POST");
      htmlp_form_hidden("option", "edit" );
      htmlp_form_hidden("reqid", $reqid );
      echo $t->translate("Subject").":<BR>";
      $reqsubject=$db->f("reqsubject");
      htmlp_input_text("reqsubject", 50, 75, $reqsubject);
      htmlp_form_submit($t->translate("Send"),"");
      echo "<BR>\n";
      echo $t->translate("Related to which Project").":<BR>";
      htmlp_select("projectname"); 
      $devprojectname=$db->f("projectname");
      $db2->query("SELECT * FROM os_projects WHERE username='$username'");
      while ($db2->next_record()) 
        {
         if ($devprojectname==$db2->f("projectname"))
	   { htmlp_select_option($db2->f("projectname"),1,$db2->f("projectname")); }
	 else
	   { htmlp_select_option($db2->f("projectname"),0,$db2->f("projectname")); }
        }
      if ($devprojectname=="none")
        { htmlp_select_option("none",1,$t->translate("none")); }
      else
        { htmlp_select_option("none",0,$t->translate("none")); }
      htmlp_select_end();
      echo "<BR>\n";

      echo $t->translate("Which type").":<BR>";
      htmlp_select("category"); 
      $category=$db->f("category");
      switch($category) 
        {
         case "member":
         htmlp_select_option("member",1,$t->translate("new project member"));
         htmlp_select_option("task",0,$t->translate("specific task"));
         htmlp_select_option("help",0,$t->translate("help/assistance"));
         htmlp_select_option("test",0,$t->translate("testing/debugging"));
         break;
         case "task":
         htmlp_select_option("member",0,$t->translate("new project member"));
         htmlp_select_option("task",1,$t->translate("specific task"));
         htmlp_select_option("help",0,$t->translate("help/assistance"));
         htmlp_select_option("test",0,$t->translate("testing/debugging"));
         break;
         case "help":
         htmlp_select_option("member",0,$t->translate("new project member"));
         htmlp_select_option("task",0,$t->translate("specific task"));
         htmlp_select_option("help",1,$t->translate("help/assistance"));
         htmlp_select_option("test",0,$t->translate("testing/debugging"));
         break;
         case "member":
         htmlp_select_option("member",0,$t->translate("new project member"));
         htmlp_select_option("task",0,$t->translate("specific task"));
         htmlp_select_option("help",0,$t->translate("help/assistance"));
         htmlp_select_option("test",1,$t->translate("testing/debugging"));
         break;
        }
      htmlp_select_end();
      echo "<BR>\n";
      
      $tasktype=$db->f("tasktype");
      echo $t->translate("What kind of task").":<BR>";
      htmlp_select("tasktype"); 
      $db2->query("SELECT * FROM prog_abilities WHERE translation='$la'");
      while ($db2->next_record()) 
        {
         if ($tasktype==$db2->f("code"))
	   { htmlp_select_option($db2->f("code"),1,$db2->f("ability")); }
         else
	   { htmlp_select_option($db2->f("code"),0,$db2->f("ability")); }
        }
      if ($tasktype=="other")
        { htmlp_select_option("other",1,$t->translate("other")); }
      else
        { htmlp_select_option("other",0,$t->translate("other")); }
      htmlp_select_end();

      htmlp_select_end();
      echo "<BR>\n";

      echo $t->translate("Request-Language").":<BR>";
      htmlp_select("reqlang"); echo "\n";
      $reqlang=$db->f("language");
      select_lang($reqlang);
      htmlp_select_end();   
      echo "<BR>\n";
      
      echo "<BR>\n";

      $reqmessage=$db->f("reqmessage");
      echo$t->translate("Content").":<BR>";
      htmlp_textarea("reqmessage",60,30,"nowrap",2000,$reqmessage);
      htmlp_form_end();
      $bx->box_body_end();
      $bx->box_end();
     }
   else
     {
      $be->box_full($t->translate("Error"), $t->translate("No such Request"));
      
     }
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
