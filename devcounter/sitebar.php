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
# This is the Netscape 6 sitebar of the system
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: sitebar.php,v 1.7 2004/03/02 09:22:58 helix Exp $
#
######################################################################  

require("./include/prepend.php3");

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}
// Disabling cache
header("Cache-Control: no-cache, must-revalidate");     // HTTP/1.1
header("Pragma: no-cache"); 				// HTTP/1.0

require("./include/config.inc");
require("./include/lib.inc");
require("./include/translation.inc");
require("./include/lang.inc");
require("./include/box.inc");
$t = new translation($la);
$db = new DB_DevCounter;

$bx = new box("95%",$th_box_frame_color,0,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta http-equiv="expires" content="0">
   <meta http-equiv="Refresh" content="1200; URL=<?php echo $sys_url."sitebar.php"?>">
   <title><?php echo $sys_name;?> - <?php echo $t->translate($sys_title);?></title>
<link rel="stylesheet" type="text/css" href="style.php">
</head>
<body bgcolor="<?php echo $th_body_bgcolor;?>" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0" marginwidth="0">

<!-- content -->
<p>&nbsp;
<?php
$bx->box_begin();
$bx->box_body_begin();
echo "<a href=\"$sys_url_title\" target=\"_content\"><img src=\"$sys_logo_small_image\" border=\"0\" height=\"$sys_logo_small_heigth\" width=\"$sys_logo_small_width\" ALT=\"$sys_logo_small_alt\"></a>";
$bx->box_body_end();
$bx->box_end();

$bx->box_begin();
$bx->box_title("<font size=\"1\">".$t->translate("Newest Requests")."</font>");
$db->query("SELECT * FROM requests ORDER BY reqtime DESC limit 10");
$i=0;
$bx->box_body_begin();
while($db->next_record()) {
  echo "<div class=newsind>&#149;&nbsp;";
  echo "<a href=\"".$sys_url."req_show.php?reqid=".$db->f("reqid")."\" target=\"_content\">".$db->f("reqsubject")."</a>";
  $timestamp = mktimestamp($db->f("reqtime"));
  echo "<br>[".timestr_short($timestamp)."]</div>\n";
  $i++;
}
echo "<p><b><font size=\"1\"><a href=\"".$sys_url."req_show.php\" target=\"_content\">more...</a></font></b>\n";
$bx->box_body_end();
$bx->box_end();

$bx->box_begin();
$bx->box_title("<font size=\"1\">".$t->translate("Newest Developers")."</font>");
$db->query("SELECT * FROM developers,auth_user,extra_perms WHERE developers.username=auth_user.username AND developers.username=extra_perms.username ORDER BY developers.creation DESC limit 10");
$i=0;
$bx->box_body_begin();
while($db->next_record()) {
  echo "<div class=newsind>&#149;&nbsp;";
  echo "<a href=\"".$sys_url."showprofile.php?devname=".$db->f("username")."\" target=\"_content\">".$db->f("username")."</a>";
  if ($db->f("showname") == "yes")
    echo "<br>(".$db->f("realname").")";
  $timestamp = mktimestamp($db->f("creation"));
  echo "<br>[".timestr_short($timestamp)."]</div>\n";
  $i++;
}
echo "<p><b><font size=\"1\"><a href=\"".$sys_url."\" target=\"_content\">more...</a></font></b>\n";
$bx->box_body_end();
$bx->box_end();

@page_close();
?>
