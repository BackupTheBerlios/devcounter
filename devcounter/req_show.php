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
# $Id: req_show.php,v 1.1 2002/10/08 18:12:54 Masato Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,$th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php

if (!isset($reqid) || empty($reqid))
  {
   if (!isset($offset) || empty($offset)|| $offset<1 ) 
     {
      $offset = 0;
     }
   if (!isset($limit) || empty($limit)|| $limit<1) 
     {
      $limit = 25;
     }
   
   $msg = "[ ";
   if ($offset>0)
     {
      $new_offset=$offset-$limit;
      if ($new_offset<0)
        { $new_offset=0; }
      $nquery["offset"] =  $new_offset;
      $nquery["limit"] =  $limit;
      $msg .= " ".html_link("req_show.php",$nquery,"&lt; ".$t->translate("previous page"))." | ";
     }
   else
     {
      $msg .= "&lt; ".$t->translate("previous page")." | ";
     }

   $new_offset = $offset+$limit;
   $db->query("SELECT * FROM requests ORDER BY reqtime DESC LIMIT $new_offset,$limit");
   if ($db->num_rows()>0)
     {
      $nquery["offset"] =  $new_offset;
      $nquery["limit"] =  $limit;
      $msg .= " ".html_link("req_show.php",$nquery," ".$t->translate("next page"))." &gt; ";
      
     }   
   else
     {
      $msg .= " ".$t->translate("next page")." &gt; ";
     }
   $msg .= "]";
   
   $bs->box_strip($msg);
   $db->query("SELECT * FROM requests ORDER BY reqtime DESC LIMIT $offset,$limit");
   $number_of_requests=$db->num_rows();
   $counter=0;
   $bx->box_begin();
   $bx->box_body_begin();
   $bx->box_columns_begin(5);
   $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Subject")."</b>");
   $bx->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Developer")."</b>");
   $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Time")."</b>");
   $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Task")."</b>");
   $bx->box_column("center","15%", $th_strip_title_bgcolor,"<b>".$t->translate("Language")."</b>");
   $bx->box_next_row_of_columns();
   $bgcolor = "#FFFFFF";
   while ($counter!=$number_of_requests)
     {
      $db->next_record();
      $counter++;
      if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
      else {$bgcolor = "#E0E0E0";}
      $bx->box_column("right","",$bgcolor,$db->f("reqid"));
      $pquery["reqid"] =  $db->f("reqid");
      $bx->box_column("center","",$bgcolor,html_link("req_show.php",$pquery,$db->f("reqsubject")));
      $bx->box_column("center","",$bgcolor,$db->f("username"));
      $timestamp = mktimestamp($db->f("reqtime"));
      
      $bx->box_column("center","",$bgcolor,timestr_short($timestamp));
      $tasktype=$db->f("tasktype");
      if ($tasktype != "other") 
        {
         $db2->query("SELECT * FROM prog_abilities WHERE translation='$la' AND code='$tasktype'");
         $db2->next_record();
         $tasktype = $db2->f("ability");
        }
      $bx->box_column("center","",$bgcolor,$tasktype);
      $reqlang=$db->f("language");
      $bx->box_column("center","",$bgcolor,get_lang($reqlang));
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
     
     }
    $bx->box_columns_end();
    $bx->box_body_end();
    $bx->box_end();
    $bs->box_strip($msg);

  }
else
  {
   $db->query("SELECT * FROM requests WHERE reqid='$reqid'");
   $username= $auth->auth["uname"];
   if ($db->num_rows()==0)
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Error"));
      $bx->box_body_begin();
      echo $t->translate("No such request");
      $bx->box_body_end();
      $bx->box_end();

     }
   else
     {
      $db->next_record();
      $reqsubject=$db->f("reqsubject");
      $bx->box_begin();
      $bx->box_title($t->translate("Show request"));
      $bx->box_body_begin();
      //echo $t->translate("Subject:")."<BR>";
      echo "<FONT SIZE=+1>".$reqsubject."</FONT>";
      echo "<BR>\n";
      echo "<B>".$t->translate("Devloper").":</B> &nbsp; ";
      $reqdev=$db->f("username");
      $pquery["devname"] = $db->f("username") ;
      htmlp_link("showprofile.php",$pquery,$reqdev);
      echo "<BR>\n";
      $projectname=$db->f("projectname");
      if ($projectname != "none") 
        {
         echo "<B>".$t->translate("Project").":</B> &nbsp; ";
         $db2->query("SELECT * FROM os_projects WHERE username='$reqdev' AND projectname='$projectname'");
         $db2->next_record(); 
         if (ereg("://",$db2->f("url")))
         { echo "<A HREF=\"".$db2->f("url")."\">".$db2->f("projectname")."</A>"; } 
         else
         { echo "<A HREF=\"http://".$db2->f("url")."\">".$db2->f("projectname")."</A>"; }
	 
        }
      echo "<BR>\n";

      echo "<B>".$t->translate("Type").":</B> &nbsp; ";
      $category=$db->f("category");
      switch($category) 
        {
         case "member":
         echo $t->translate("new project member");
         break;
         case "task":
         echo $t->translate("specific task");
         break;
         case "help":
         echo $t->translate("help/assistance");
         break;
        }
      echo "<BR>\n";
      
      $tasktype=$db->f("tasktype");
      if ($tasktype != "other") 
        {
         echo "<B>".$t->translate("Kind of task").":</B> &nbsp; ";
         $db2->query("SELECT * FROM prog_abilities WHERE translation='$la' AND code='$tasktype'");
         $db2->next_record();
         echo $db2->f("ability");
        }
      else
        {
	 echo $t->translate("other");
	}
      echo "<BR>\n";
      
      $reqlang=$db->f("language");
      echo "<B>".$t->translate("Request-Language").":</B> &nbsp; ";
      print_lang($reqlang);
      echo "<BR>\n";
      

      echo "<BR>\n";
      $reqmessage=$db->f("reqmessage");
      echo "<B>".$t->translate("Content").":</B> &nbsp;<BR>";
      
      echo "<PRE>".$reqmessage."</PRE>";
      $bx->box_body_end();
      $bx->box_end();
     }
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
