<?php

######################################################################
# DevCounter - Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Gregorio Robles (grex@scouts-es.org)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This is the XML backend (RDF-type document) of the system
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: backend.php,v 1.6 2003/02/26 13:19:11 masato Exp $
#
###################################################################### 

require "./include/prepend.php3";

header("Content-Type: text/xml");

// Disabling cache
header("Cache-Control: no-cache, must-revalidate");     // HTTP/1.1
header("Pragma: no-cache");                             // HTTP/1.0

require "./include/config.inc";
require "./include/lib.inc";

$db = new DB_DevCounter;

echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
echo "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n";
echo "           \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n";
echo "<rss version=\"0.91\">\n";

echo "  <channel>\n";
echo "    <title>".$sys_name."</title>\n";
echo "    <link>".$sys_url."</link>\n";
echo "    <description>".$sys_name." - ".$sys_title."</description>\n";
echo "    <language>en-us</language>\n";

echo "  <image>\n";
echo "    <title>".$sys_name."</title>\n";
echo "    <url>".$sys_url.$sys_logo_image."</url>\n";
echo "    <link>".$sys_url."</link>\n";
echo "    <description>".$sys_name." - ".$sys_title."</description>\n";
echo "    <width>66</width>\n";
echo "    <height>73</height>\n";
echo "  </image>\n";

echo "  <item>\n";
echo "    <title><b>Developers:</b></title>\n";
echo "    <link>http://devcounter.berlios.de/</link>\n";
echo "  </item>\n";

$db->query("SELECT * FROM developers,auth_user,extra_perms WHERE developers.username=auth_user.username AND developers.username=extra_perms.username ORDER BY developers.creation DESC limit 5");
$i=0;
while($db->next_record()) {
  echo "  <item>\n";
  echo "    <title>".$db->f("username");
  if ($db->f("showname") == "yes")
    echo " (".$db->f("realname").")";
  $timestamp = mktimestamp($db->f("creation"));
  echo " [".timestr_short($timestamp)."]";
  echo "</title>\n";
  echo "    <link>".$sys_url."showprofile.php?devname=".$db->f("username")."</link>\n";
  echo "  </item>\n";
  $i++;
} 

echo "  <item>\n";
echo "    <title><b>Requests:</b></title>\n";
echo "    <link>http://devcounter.berlios.de/req_show.php</link>\n";
echo "  </item>\n";

$db->query("SELECT * FROM requests ORDER BY reqtime DESC LIMIT 0,5");

while ($db->next_record()) {
  echo "  <item>\n";
  echo "    <title>".$db->f("reqsubject");
  $timestamp = mktimestamp($db->f("reqtime"));
  echo " [".timestr_short($timestamp)."]";
  echo "</title>\n";
  echo "    <link>".$sys_url."req_show.php?reqid=".$db->f("reqid")."</link>\n";
  echo "  </item>\n";
}

echo "  </channel>\n";
echo "</rss>\n";
?>
