<?php

######################################################################
# DevCounter: Software Announcement & Retrieval System
# ================================================
#
# Copyright (c) 2001 by
#                Lutz Henckel (lutz.henckel@fokus.gmd.de) and
#                Gregorio Robles (grex@scouts-es.org)
#
# BerliOS DevCounter: http://sourcewell.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Statistics of the System
# some code (or some idea) has been taken from PHP-Nuke (http://php-nuke.org)
# which also lies under the GPL
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("header.inc");
require("statslib.inc");

$bx = new box("95%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php

// $iter is a variable for printing the Top Statistics in steps of 10 apps
if (!isset($iter)) $iter=0;
$iter*=10;
/*
$bx->box_begin();
$bx->box_title($t->translate("$sys_name Statistics"));
$bx->box_body_begin();

echo "<table border=0 width=100% cellspacing=0>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=general")."\">".$t->translate("General $sys_name Statistics")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=apps")."\">".$t->translate("Apps by Importance")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=hits")."\">".$t->translate("Apps by Hits")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=homepage")."\">".$t->translate("Apps by Homepage Visits")."<tr></a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=download")."\">".$t->translate("Apps by Downloads")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=rpm")."\">".$t->translate("Top downloaded RPM Packages")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=deb")."\">".$t->translate("Top downloaded Debian Packages")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=tgz")."\">".$t->translate("Top downloaded Slackware Packages")."</a></center></td></tr>\n";
echo "</td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=urgency")."\">".$t->translate("Apps and Downloads by Urgency")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=version_type")."\">".$t->translate("Apps and Downloads by Version Types")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=sections")."\">".$t->translate("Apps and Importance by Sections")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=categories")."\">".$t->translate("Apps by Categories")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=version_number")."\">".$t->translate("Apps by Version Numbers")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=format")."\">".$t->translate("Apps and Downloads by Package Formats")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=importance_license")."\">".$t->translate("Importance by Licenses")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=importance_email")."\">".$t->translate("Importance by Email Domains")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=email")."\">".$t->translate("Apps by Email Domains")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=email_section")."\">".$t->translate("Apps by Sections and Email Domains")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("stats.php3?option=licenses")."\">".$t->translate("Apps by Licenses")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("stats.php3?option=email_license")."\">".$t->translate("Apps by Licenses and Email Domains")."</a></center></td><tr>\n";
echo "</table>\n";

$bx->box_body_end();
$bx->box_end();
*/



if (isset($option)) {
// We need to know the total number of apps for certain stats

  $db->query("SELECT COUNT(*) FROM developers");
  $db->next_record();
  $total_number_devs = $db->f("COUNT(*)");
  $numiter = ($db->f("COUNT(*)")/10);


  switch($option) {

// General stats
    case "general":

      $bx->box_begin();
      $bx->box_title($t->translate("General $sys_name Statistics"));
      $bx->box_body_begin();
      echo $t->translate("Total nuber of developers")." : ".$total_number_devs."\n";
      $bx->box_body_end();
      $bx->box_end();

      break;
/*


      $bx->box_begin();
      $bx->box_title($t->translate("General $sys_name Statistics"));
      $bx->box_body_begin();

      echo "<CENTER><table border=0 width=90% align=center cellspacing=0>\n";

    // Total number of apps
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Applications in $sys_name")."</td>\n";
      echo "<td width=20% align=right>".$total_number_apps."</td></tr>\n";

    // Total number of insertions or modifications
      echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
      $db->query("SELECT COUNT(*) FROM history");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Total Number of Insertions and Modifications")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Number of inserted or modified Apps during the last week
      $day=7;
      $db->query("SELECT COUNT(*) FROM software WHERE DATE_FORMAT(software.modification,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY) AND software.status='A'");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Insertions and Modifications during the last week")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Number of inserted or modified Apps today
      $day=1;
      $db->query("SELECT COUNT(*) FROM software WHERE DATE_FORMAT(software.modification,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY) AND software.status='A'");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Insertions and Modifications in the last day")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Number of today's visitors
      $db->query("SELECT DISTINCT ipaddr FROM counter_check");
      $db->next_record();
      $count = $db->affected_rows();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of today's visitors")."</td>\n";
      echo "<td width=20% align=right>$count</td></tr>\n";

    // Total number of pending apps 
      $db->query("SELECT COUNT(*) FROM software WHERE status='P'");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of pending Applications")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Number of authorised users
      echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
      $db->query("SELECT COUNT(*) FROM auth_user");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of $sys_name authorised Users")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of comments
      $db->query("SELECT COUNT(*) FROM comments");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Comments on Applications")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Licenses
      $db->query("SELECT COUNT(*) FROM licenses");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Licenses listed in $sys_name")."</td>\n";
      echo "<td width=20% align=right>".($db->f("COUNT(*)")-1)."</td></tr>\n";
				// We don't add the license type "Other"

    // Total number of DevCounter sections
      $db->query("SELECT DISTINCT section,COUNT(*) FROM categories GROUP BY section");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of $sys_name Sections")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of DevCounter categories
      $db->query("SELECT COUNT(*) FROM categories");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of $sys_name Categories")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Hits
      echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";

      echo "<tr><td colspan=2><table width=100% border=0 cellspacing=0 cellpadding=0>";
       echo "<tr><td width=70%>&nbsp;</td>\n";
       echo "<td width=15% align=right>".$t->translate("Today").":</td>\n";
       echo "<td width=15% align=right>".$t->translate("Total").":</td></tr>\n";

       echo "<tr><td width=70%>&nbsp;".$t->translate("Number of Hits on Applications")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='app_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(app_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(app_cnt)")."</td></tr>\n";

    // Total number of redirected Homepages
       echo "<tr><td width=70%>&nbsp;".$t->translate("Number of redirected Homepages")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='homepage_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(homepage_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(homepage_cnt)")."</td></tr>\n";

    // Total number of Downloads
      echo "<tr><td width=70%>&nbsp;".$t->translate("Number of Downloads")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='download_cnt' OR cnt_type='rpm_cnt' OR cnt_type='deb_cnt' OR cnt_type='tgz_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("sum_cnt")."</td></tr>\n";

    // Total number of redirected Changelogs
      echo "<tr><td width=70%>&nbsp;".$t->translate("Number of redirected Changelogs")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='changelog_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(changelog_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(changelog_cnt)")."</td></tr>\n";

    // Total number of redirected CVSs
      echo "<tr><td width=70%>&nbsp;".$t->translate("Number of redirected CVSs")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='cvs_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(cvs_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(cvs_cnt)")."</td></tr>\n";

    // Total number of redirected ScreenShots
      echo "<tr><td width=70%>&nbsp;".$t->translate("Number of redirected Screenshots")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='screenshots_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(screenshots_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(screenshots_cnt)")."</td></tr>\n";

    // Total number of redirected Mailing List Archives
      echo "<tr><td width=70%>&nbsp;".$t->translate("Number of redirected Mailing Lists Archives")."</td>\n";
      $db->query("SELECT COUNT(cnt_type) FROM counter_check WHERE cnt_type='mailarch_cnt'");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(cnt_type)")."</td>\n";
      $db->query("SELECT SUM(mailarch_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(mailarch_cnt)")."</td></tr>\n";

      echo "</table></td></tr>";

     // DevCounter Version
      echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
      echo "<tr><td width=85%>&nbsp;".$t->translate("$sys_name Version")."</td>\n";
      echo "<td width=20% align=right>".$DevCounter_Version."</td></tr>\n";

      echo "</td></tr>\n";
      echo "</table></CENTER>\n";
      $bx->box_body_end();
      $bx->box_end();

      break;

*/

    break;
   }
}

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
