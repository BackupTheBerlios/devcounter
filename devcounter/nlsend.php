<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.gmd.de)
#       Gregorio Robles (grex@scouts-es.org)
#
# BerliOS devcounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This file sends the daily/weekly newsletters with the announcements
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: nlsend.php,v 1.5 2003/02/26 13:19:11 masato Exp $
#
###################################################################### 

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));

require("./include/config.inc");
require("./include/lib.inc");

$db = new DB_DevCounter;
$db2 = new DB_DevCounter;

if ($ml_list) {
  if (!isset($period)) $period = "daily";
  if ($msg = nlmsg($period)) {
    switch ($period) {
      case "weekly":
        $subj = "$sys_name weekly newsletter for ".date("l dS of F Y");
        mail($ml_weeklynewstoaddr, $subj, $msg,
        "From: $ml_newsfromaddr\nReply-To: $ml_newsreplyaddr\nX-Mailer: PHP");
        echo "$sys_name weekly newsletter sent at ".date("l dS of F Y H:i:s")."\n";
	
	
        break;
      case "daily":
      default:
        $subj = "$sys_name daily newsletter for ".date("l dS of F Y");
        mail($ml_newstoaddr, $subj, $msg,
        "From: $ml_newsfromaddr\nReply-To: $ml_newsreplyaddr\nX-Mailer: PHP");
        echo "$sys_name daily newsletter sent at ".date("l dS of F Y H:i:s")."\n";
        
	
	
	break;
    }
  } else {
    echo "No application at ".date("l dS of F Y H:i:s")."\n";
  }
}

switch ($period) 
  {
   case "daily":
   default:
   $db->query("SELECT DISTINCT extra_perms.username,auth_user.email_usr from extra_perms,auth_user where extra_perms.contact='dai' AND extra_perms.username=auth_user.username");
   while ($db->next_record())
     {
      $u_name=$db->f("username");
      $db2->query("SELECT * from extra_perms,pmessages where extra_perms.username=pmessages.pmessto AND extra_perms.username='$u_name' AND pmessages.pmessstatus='new'");
      if ($db2->num_rows())
        {
	 echo "<BR>$u_name\n";
	 $messagetext = "DevCounter Notification of new personal messages.\n";
	 $messagetext.= "At ".date("l dS of F Y H:i")." you've these new messages: \n\n\n";
	 while ($db2->next_record())
	   {
	    $pmesssubject = $db2->f("pmesssubject");
	    $pmessfrom = $db2->f("pmessfrom");
	    $pmessfrom = ereg_replace ("mailto:","", $pmessfrom);
	    $messagetext.= "$pmesssubject --- $pmessfrom\n";
	    echo "<BR> --- $pmesssubject - $pmessfrom";
	   }
	 $messagetitle = "[$sys_name] Notification of new personal messages (".date("l dS of F Y H:i").")";
         $messagetext.= "\n\nRead your personal messages at DevCounter (http://devcounter.berlios.de/)\n";
	 mail ($db->f("email_usr"),$messagetitle,$messagetext,"From: $ml_newsfromaddr\nReply-To: no-reply@berlios.de\nX-Mailer: PHP");
	 
        }
     }

   case "weekly":
   $db->query("SELECT DISTINCT extra_perms.username,auth_user.email_usr from extra_perms,auth_user where extra_perms.contact='wee' AND extra_perms.username=auth_user.username");
   while ($db->next_record())
     {
      $u_name=$db->f("username");
      $db2->query("SELECT * from extra_perms,pmessages where extra_perms.username=pmessages.pmessto AND extra_perms.username='$u_name' AND pmessages.pmessstatus='new'");
      if ($db2->num_rows())
        {
	 echo "<BR>$u_name\n";
	 $messagetext = "DevCounter Notification of new personal messages.\n";
	 $messagetext.= "At ".date("l dS of F Y H:i")." you've these new messages: \n\n\n";
	 while ($db2->next_record())
	   {
	    $pmesssubject = $db2->f("pmesssubject");
	    $pmessfrom = $db2->f("pmessfrom");
	    $pmessfrom = ereg_replace ("mailto:","", $pmessfrom);
	    $messagetext.= "$pmesssubject --- $pmessfrom\n";
	    echo "<BR> --- $pmesssubject - $pmessfrom";
	   }
	 $messagetitle = "[$sys_name] Notification of new personal messages (".date("l dS of F Y H:i").")";
         $messagetext.= "\n\nRead your personal messages at DevCounter (http://devcounter.berlios.de/)\n";
	 mail ($db->f("email_usr"),$messagetitle,$messagetext,"From: $ml_newsfromaddr\nReply-To: no-reply@berlios.de\nX-Mailer: PHP");
	 
        }
     }

  }

@page_close();
?>
