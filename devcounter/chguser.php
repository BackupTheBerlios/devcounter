<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Gregorio Robles (grex@scouts-es.org)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Enables (authenticated) developers to change their parameters
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: chguser.php,v 1.3 2002/08/26 19:46:59 helix Exp $
#
######################################################################

page_open(array("sess" => "DevCounter_Session",
                "auth" => "DevCounter_Auth",
                "perm" => "DevCounter_Perm"));

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bi = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php

// Check if there was a submission
while (is_array($HTTP_POST_VARS) 
		  && list($key, $val) = each($HTTP_POST_VARS)) {
    switch ($key) {
    case "u_edit": // Change user parameters
        if($auth->auth["uid"] == $u_id) { // user changes his own account
			$password = trim($password);
			$cpassword = trim($cpassword);
			$realname = trim($realname);
			$email_usr = trim($email_usr);
        	if (strcmp($password,$cpassword)) { // password are identical?
            	$be->box_full($t->translate("Error"), $t->translate("The passwords are not identical").". ".$t->translate("Please try again")."!");
            	break;
        	}
	    	if ($showname == "on") {$showname = "yes";} else {$showname = "no";}
	    	if ($showemail == "on") {$showemail = "yes";} else {$showemail = "no";}
	    	if ($search == "on") {$search = "yes";} else {$search = "no";}
	    	if ($contact == "on") {$contact = "yes";} else {$contact = "no";}
	    
	    	$query = "UPDATE auth_user SET password='$password', realname='$realname', email_usr='$email_usr', modification_usr=NOW() WHERE user_id='$u_id'";
            $db->query($query);
            if ($db->affected_rows() == 0) {
                $be->box_full($t->translate("Error"), $t->translate("Change User Parameters failed").":<br>$query");
                break;
            }
            $bi->box_full($t->translate("Change Developer Parameters"), $t->translate("Password and/or E-Mail Address of")." <b>". $auth->auth["uname"] ."</b> ".$t->translate("is changed").".");
			$query = "UPDATE extra_perms SET showname='$showname', showemail='$showemail', search='$search' , contact='$contact' WHERE username='".$auth->auth["uname"]."'";
            $db->query($query);
			if ($ml_notify) {
				$message  = "Username: ".$auth->auth["uname"]."\n";
				$message .= "Realname: $realname\n";
				$message .= "E-Mail:   $email_usr\n";
				mailuser("admin", "User parameters has changed", $message);
			}
        } else {
            $be->box_full($t->translate("Error"), $t->translate("Access denied"));
        }
        break;
    default:
        break;
    }
}

$bx->box_begin();
$bx->box_title($t->translate("Change Developer Parameters"));
$bx->box_body_begin();
echo "<table border=0 align=\"center\" cellspacing=0 cellpadding=3>\n";
$db->query("select * from auth_user,extra_perms where auth_user.username='".$auth->auth["uname"]."' and extra_perms.username='".$auth->auth["uname"]."'");
while ($db->next_record()) {
?>
<form method="post" action="<?php $sess->pself_url() ?>">
<tr valign=middle align=left>
<td align=right><?php echo $t->translate("Username") ?>:</td><td><?php $db->p("username") ?></td></tr>
<tr>
<td align=right><?php echo $t->translate("Password") ?>:</td><td><input type="password" name="password" size=20 maxlength=32 value="<?php $db->p("password") ?>"></td></tr>
<tr>
<td align=right><?php echo $t->translate("Confirm Password") ?>:</td><td><input type="password" name="cpassword" size=20 maxlength=32 value="<?php $db->p("password") ?>"></td></tr>
<tr>
<td align=right><?php echo $t->translate("Realname") ?>:</td><td><input type="text" name="realname" size=20 maxlength=64 value="<?php $db->p("realname") ?>"></td></tr>

<tr valign=middle align=left>
<td align=right>
<?php 
if ($db->f("showname")=="yes")
  {
   echo"<input type=\"checkbox\" name=\"showname\" checked></td><td>";
  }
else
  {
  echo"<input type=\"checkbox\" name=\"showname\"></td><td>";
  }
echo $t->translate("allow to show realname") ?></td>
</tr>
<tr>
<td align=right><?php echo $t->translate("E-Mail") ?>:</td><td><input type="text" name="email_usr" size=20 maxlength=128 value="<?php $db->p("email_usr") ?>"></td></tr>
<tr>
<tr valign=middle align=left>
<td align=right>
<?php 
if ($db->f("showemail")=="yes")
  {
   echo"<input type=\"checkbox\" name=\"showemail\" checked></td><td>";
  }
else
  {
  echo"<input type=\"checkbox\" name=\"showemail\"></td><td>";
  }
echo $t->translate("allow to show E-Mail") ?></td>
</tr>
<tr valign=middle align=left>
<td align=right>
<?php 
if ($db->f("search")=="yes")
  {
   echo"<input type=\"checkbox\" name=\"search\" checked></td><td>";
  }
else
  {
  echo"<input type=\"checkbox\" name=\"search\"></td><td>";
  }
echo $t->translate("allow to be searched") ?></td>
</tr>
<tr valign=middle align=left>
<td align=right>
<?php 
if ($db->f("contact")=="yes")
  {
   echo"<input type=\"checkbox\" name=\"contact\" checked></td><td>";
  }
else
  {
  echo"<input type=\"checkbox\" name=\"contact\"></td><td>";
  }
echo $t->translate("allow to be contacted by DevCounter") ?></td>
</tr>
<?php
	$time = mktimestamp($db->f("modification_usr"));
?>
<td align=right><?php echo $t->translate("Modification") ?>:</td><td><?php echo timestr($time); ?></td></tr>
<tr>
<?php
	$time = mktimestamp($db->f("creation_usr"));
?>
<td align=right><?php echo $t->translate("Creation") ?>:</td><td><?php echo timestr($time); ?></td></tr>
<tr>
<td align=right><?php echo $t->translate("Permission") ?>:</td><td><?php $db->p("perms") ?></td></tr>
<tr>
<td></td>
<td><input type="hidden" name="u_id"   value="<?php $db->p("user_id") ?>">
<?php
	echo "<input type=\"submit\" name=\"u_edit\" value=\"".$t->translate("Change")."\">";
?>
</td></tr>
</form>
<?php
}
?>
</table>
<?php
$bx->box_body_end();
$bx->box_end();
?>
<!-- end content -->

<?php
require("footer.inc");
@page_close();
?>
