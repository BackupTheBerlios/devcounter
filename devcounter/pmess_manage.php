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
# $Id: pmess_manage.php,v 1.1 2003/02/26 13:21:40 masato Exp $
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
      $db->query("DELETE from pmessages WHERE pmessto='$username' AND pmessid='$pmessid'");
      if ($db->affected_rows() == 1 )
        {
         $bx->box_full($t->translate("Success"), $t->translate("Request deleted"));
        }
      else
        {
         $bx->box_full($t->translate("Error"), $t->translate("Request wasn't deleted"));
	}
      
      break;
      
     
      case "send":
      $db->query("SELECT * from extra_perms,auth_user WHERE auth_user.username='$pmessto' AND extra_perms.username='$pmessto'");
      if ($db->num_rows() ==0)
        {
         $be->box_full($t->translate("Error"), $t->translate("Unknown Developer"));
        }
      else
        {
         $db->next_record();
         if ($db->f("contact")!="no")
           {
         
            $pmesstime = "NOW()";
            $pmesssubject = htmlentities($pmesssubject);
            $pmessmessage = htmlentities($pmessmessage);
            if ($sender=="-")
              { $pmessfrom = "mailto:".$email; }
            else
              { $pmessfrom = $sender; }
            //$pmessto = $devname;
            
            $db2->query("INSERT pmessages SET pmesstime = $pmesstime, pmessto = '$pmessto', pmessstatus = 'new', pmessfrom = '$username', pmesssubject='$pmesssubject', pmessmessage='$pmessmessage'");
      
             if ($db2->affected_rows() == 1 )
              {
               $bx->box_full($t->translate("Success"), $t->translate("Request posted"));
	       if ($db->f("contact")=="yes")
	         {
		  mail($db->f("email_usr"),"[$sys_name] $pmesssubject","$pmessmessage\n---\n \nRead your personal messages at http://devcounter.berlios.de/","From: noreply@berlios.de\nReply-To: noreply@berlios.de\nX-Mailer: PHP");
		 }
              }
            else
              {
               $bx->box_full($t->translate("Error"), $t->translate("Request wasn't posted"));
      	      } 
            
           }
         else
           {
            $be->box_full($t->translate("Error"), $t->translate("Developer does not allow to contact him"));
      	   }
        }
      
      
      break;
     }
   
   
   
   
   $db->query("SELECT * FROM pmessages WHERE pmessto='$username' ORDER BY pmesstime DESC");
   $number_of_pmessages=$db->num_rows();
   $counter=0;
   $blist->box_begin();
   $blist->box_body_begin();
   $blist->box_columns_begin(5);
   $blist->box_column("center","5%", $th_strip_title_bgcolor,"<b>".$t->translate("Status")."</b>");
   $blist->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Subject")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Sender")."</b>");
   $blist->box_column("center","20%", $th_strip_title_bgcolor,"<b>".$t->translate("Time")."</b>");
   $blist->box_column("center","10%", $th_strip_title_bgcolor,"<b>".$t->translate("-")."</b>");
   $blist->box_column("center","10%", $th_strip_title_bgcolor,"<b>".$t->translate("-")."</b>");
   $blist->box_next_row_of_columns();
   $bgcolor = "#FFFFFF";
   while ($counter!=$number_of_pmessages)
     {
      $db->next_record();
      $counter++;
      $pmessstatus = $db->f("pmessstatus");
      switch($pmessstatus)
        {
	 case "new":
	 $bgcolor = "blue";
	 $blist->box_column("center","",$bgcolor,"<B>".$t->translate($pmessstatus)."</B>");
	 break;
	 case "unread":
	 $bgcolor = "lightblue";
	 $blist->box_column("center","",$bgcolor,"<B>".$t->translate($pmessstatus)."</B>");
	 break;
	 case "read":
	 $bgcolor = "white";
	 $blist->box_column("center","",$bgcolor,$t->translate($pmessstatus));
	 break;
	 
	}
      
      //$blist->box_column("center","",$bgcolor,$pmessstatus);
      if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
      else {$bgcolor = "#E0E0E0";}
      $blist->box_column("right","",$bgcolor,$db->f("pmessid"));

      $pquery["pmessid"] =  $db->f("pmessid");
      $blist->box_column("center","",$bgcolor,html_link("pmess_show.php",$pquery,$db->f("pmesssubject")));

      $pmessfrom = $db->f("pmessfrom");
      $pmessfrom = ereg_replace ("mailto:","", $pmessfrom);
      $blist->box_column("center","",$bgcolor,$pmessfrom);

      $timestamp = mktimestamp($db->f("pmesstime"));
      $blist->box_column("center","",$bgcolor,timestr_short($timestamp));


      htmlp_form_action("pmess_edit.php",array(),"POST");
      htmlp_form_hidden("pmessid", $db->f("pmessid") );
      $blist->box_column("center","",$bgcolor,html_form_submit($t->translate("Reply"),""));

      $bgcolor = "gold";
      htmlp_form_end();
      htmlp_form_action("pmess_manage.php",array(),"POST");
      htmlp_form_hidden("pmessid", $db->f("pmessid") );
      htmlp_form_hidden("option", "delete" );
      $blist->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete"),""));
      htmlp_form_end();
      $blist->box_next_row_of_columns();
      $bgcolor = "gold";
     
     }
    $blist->box_columns_end();
    $blist->box_body_end();
    $blist->box_end();
    $db->query("UPDATE pmessages SET pmessstatus='unread' WHERE pmessstatus='new' AND pmessto='$username'");
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
