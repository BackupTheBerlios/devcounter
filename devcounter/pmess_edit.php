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
# $Id: pmess_edit.php,v 1.2 2004/03/02 09:22:58 helix Exp $
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
   $db->query("SELECT * FROM auth_user WHERE username='$username'"); 
   $db->next_record();
   $user_email = $db->f("email_usr");
  
   $db->query("SELECT * FROM pmessages WHERE pmessid='$pmessid' AND pmessto='$username'"); 
   if ($db->num_rows()==1)
     {
      $db->next_record();
      $bx->box_begin();
      $bx->box_title($t->translate("edit request"));
      $bx->box_body_begin();
      $old_pmessfrom = $db->f("pmessfrom");
      if (ereg("^mailto:",$old_pmessfrom))
        {
	 htmlp_form_action("sendform.php", "", "POST");
	 htmlp_form_hidden("pmessto", ereg_replace ("mailto:","", $old_pmessfrom) );
	 htmlp_form_hidden("s_email", $user_email );
	 echo "<B><FONT SIZE=+1 COLOR=red>".$t->translate("Your E-Mail-Address will be shown to the recipient")."</FONT></B><P>";
	}
      else
        {
	 htmlp_form_action("pmess_manage.php", "", "POST");
	 htmlp_form_hidden("option", "send" );
	 htmlp_form_hidden("pmessto", $old_pmessfrom );
	 //echo "<B><FONT SIZE=+1 COLOR=red>".$t->translate("recipient")."</FONT></B><P>";

	}
      echo $t->translate("Subject").":<BR>";
      $pmesssubject=$db->f("pmesssubject");
      if (!ereg("^Re:",$pmesssubject))
        { $pmesssubject = "Re:".$pmesssubject; }
      htmlp_input_text("pmesssubject", 50, 75, $pmesssubject);
      htmlp_form_submit($t->translate("Send"),"");
      echo "<BR>\n";

      
      echo "<BR>\n";

      $pmessmessage=$db->f("pmessmessage");
      $sendername = ereg_replace ("mailto:","", $old_pmessfrom);
      $pmessmessage=$sendername." wrotes:\n\n".$pmessmessage;
      $pmessmessage=ereg_replace("\n","\n> ",$pmessmessage);
      echo$t->translate("Content").":<BR>";
      htmlp_textarea("pmessmessage",60,30,"nowrap",2000,$pmessmessage);
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
