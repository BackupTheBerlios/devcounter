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
# This file contains the verification procedure when registering
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: req_manage.php,v 1.1 2002/10/08 18:12:54 Masato Exp $
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
$blist = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php

if (empty($auth->auth["uname"]))
  {
   $be->box_full($t->translate("Not logged in"), $t->translate("Please login first"));
  }
else
  {
   $username= $auth->auth["uname"];
   switch($option) 
     {
      case "delete":
      $db->query("DELETE from requests WHERE username='$username' AND reqid='$reqid'");
      if ($db->affected_rows() == 1 )
        {
         $bx->box_full($t->translate("Success"), $t->translate("Request deleted"));
        }
      
      break;
      
      case "edit":
      $reqtime = "NOW()";
      $db->query("UPDATE requests SET language = '$reqlang', reqtime = $reqtime, projectname = '$projectname', tasktype='$tasktype', category='$category', reqsubject='$reqsubject', reqmessage='$reqmessage' WHERE username='$username' AND reqid='$reqid'");
      if ($db->affected_rows() == 1 )
        {
         $bx->box_full($t->translate("Success"), $t->translate("Request changed"));
        }
      else
        {
         $bx->box_full($t->translate("Error"), $t->translate("Request hasn't changed"));
	}
      
      break;
      
      case "send":
      $reqtime = "NOW()";
      $reqsubject = htmlentities($reqsubject);
      $reqmessage = htmlentities($reqmessage);
      $db->query("INSERT requests SET  username = '$username', language = '$reqlang', reqtime = $reqtime, projectname = '$projectname', tasktype='$tasktype', category='$category', reqsubject='$reqsubject', reqmessage='$reqmessage'");

       if ($db->affected_rows() == 1 )
        {
         $bx->box_full($t->translate("Success"), $t->translate("Request posted"));
        }
      
   
      
      break;
     }
   
   
   
   
   $db->query("SELECT * FROM requests WHERE username='$username' ORDER BY reqtime DESC");
   $number_of_requests=$db->num_rows();
   $counter=0;
   $blist->box_begin();
   $blist->box_body_begin();
   $blist->box_columns_begin(5);
   $blist->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Subject")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Time")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Task")."</b>");
   $blist->box_column("center","15%", $th_strip_title_bgcolor,"<b>".$t->translate("Language")."</b>");
   $blist->box_column("center","10%", $th_strip_title_bgcolor,"<b>".$t->translate("-")."</b>");
   $blist->box_column("center","10%", $th_strip_title_bgcolor,"<b>".$t->translate("-")."</b>");
   $blist->box_next_row_of_columns();
   $bgcolor = "#FFFFFF";
   while ($counter!=$number_of_requests)
     {
      $db->next_record();
      $counter++;
      if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
      else {$bgcolor = "#E0E0E0";}
      $blist->box_column("right","",$bgcolor,$db->f("reqid"));
      $pquery["reqid"] =  $db->f("reqid");
      $blist->box_column("center","",$bgcolor,html_link("req_show.php",$pquery,$db->f("reqsubject")));
      $timestamp = mktimestamp($db->f("reqtime"));
      
      $blist->box_column("center","",$bgcolor,timestr_short($timestamp));
      $tasktype=$db->f("tasktype");
      if ($tasktype != "other") 
        {
         $db2->query("SELECT * FROM prog_abilities WHERE translation='$la' AND code='$tasktype'");
         $db2->next_record();
         $tasktype = $db2->f("ability");
        }
      $blist->box_column("center","",$bgcolor,$tasktype);
      $reqlang=$db->f("language");
      $blist->box_column("center","",$bgcolor,get_lang($reqlang));
      htmlp_form_action("req_edit.php",array(),"POST");
      htmlp_form_hidden("reqid", $db->f("reqid") );
      $blist->box_column("center","",$bgcolor,html_form_submit($t->translate("Edit"),""));
      htmlp_form_end();
      htmlp_form_action("req_manage.php",array(),"POST");
      htmlp_form_hidden("reqid", $db->f("reqid") );
      htmlp_form_hidden("option", "delete" );
      $bgcolor = "gold";
      $blist->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete"),""));
      htmlp_form_end();
      $blist->box_next_row_of_columns();
      $bgcolor = "gold";
     
     }
    $blist->box_colspan(7,"center",$bgcolor,html_link("req_compose.php","",$t->translate("Create a new Request"),""));
    $blist->box_columns_end();
    $blist->box_body_end();
    $blist->box_end();
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
