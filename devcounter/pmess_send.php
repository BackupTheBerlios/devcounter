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
# $Id: pmess_send.php,v 1.2 2004/03/02 09:22:58 helix Exp $
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
$db2 = new DB_DevCounter;


$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$blist = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php

   switch($option) 
     {
      case "send":
      $db->query("SELECT * from extra_perms,auth_user WHERE auth_user.username='$pmessto' AND extra_perms.username='$pmessto'");
      if ($db->num_rows() ==0)
        {
         $be->box_full($t->translate("Error"), $t->translate("Unknown Developer $pmessto"));
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
            $pmessto = $devname;
      
            $db2->query("INSERT pmessages SET  pmesstime = $pmesstime, pmessstatus = 'new', pmessto = '$pmessto', pmessfrom = '$pmessfrom', pmesssubject='$pmesssubject', pmessmessage='$pmessmessage'");

            if ($db2->affected_rows() == 1 )
              {
               $bx->box_full($t->translate("Success"), $t->translate("Request posted"));
	      if ($db->f("contact")=="yes")
	        {
	         mail($db->f("email_usr"),"[$sys_name] $pmesssubject","$pmessmessage\n---\n \nRead your personal messages at http://devcounter.berlios.de/","From: noreply@berlios.de\nReply-To: noreply@berlios.de\nX-Mailer: PHP");
	         echo "-".$db->f("email_usr")."-";
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
   
   
   
   
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
