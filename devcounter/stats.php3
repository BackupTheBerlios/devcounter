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

if (isset($option)) {
// We need to know the total number of apps for certain stats

  $db->query("SELECT COUNT(*) FROM software");
  $db->next_record();
  $total_number_apps = $db->f("COUNT(*)");
  $numiter = ($db->f("COUNT(*)")/10);

  switch($option) {

// General stats
    case "general":

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

    // Top Apps
    case "apps":
      $message = "Applications listed by their Importance";
      $query_partial = "SELECT *,SUM(app_cnt+homepage_cnt+download_cnt+changelog_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM software,counter WHERE software.appid=counter.appid AND software.status='A' GROUP BY software.name ORDER BY sum_cnt DESC";
      $query = $query_partial." LIMIT ".$iter.",10";
      $var = "sum_cnt";
      statslib_top($query,$var,$message,$iter);

      $db->query($query_partial);
      $numiter = $db->num_rows()/10;
      $url = "stats.php3";
      $urlquery = array("option" => "apps");
      show_more ($iter,$numiter,$url,$urlquery);
      break;

// Top Downloaded Apps
    case "download":
      $message = "Applications listed by Number of Tarball-Downloads";
      $query_partial = "SELECT *,SUM(download_cnt) AS download_count FROM software,counter WHERE software.appid=counter.appid AND software.status='A' GROUP BY software.name ORDER BY download_count DESC";
      $query = $query_partial." LIMIT ".$iter.",10";
      $var = "download_count";
      statslib_top($query,$var,$message,$iter);

      $db->query($query_partial);
      $numiter = $db->num_rows()/10;
      $url = "stats.php3";
      $urlquery = array("option" => "download");
      show_more ($iter,$numiter,$url,$urlquery);
      break;

// Top Apps by Hits
    case "hits":
      $message = "Applications listed by Number of Hits";
      $query_partial = "SELECT *,SUM(app_cnt) AS app_count FROM software,counter WHERE software.appid=counter.appid AND software.status='A' GROUP BY software.name ORDER BY app_count DESC";
      $query = $query_partial." LIMIT ".$iter.",10";
      $var = "app_count";
      statslib_top($query,$var,$message,$iter);

      $db->query($query_partial);
      $numiter = $db->num_rows()/10;
      $url = "stats.php3";
      $urlquery = array("option" => "apps");
      show_more ($iter,$numiter,$url,$urlquery);
      break;

// Top App Homepages visited
    case "homepage":
      $message = "Applications listed by Homepage Visits";
      $query_partial = "SELECT *,SUM(homepage_cnt) AS homepage_count FROM software,counter WHERE software.appid=counter.appid AND software.status='A' GROUP BY software.name ORDER BY homepage_count DESC";
      $query = $query_partial." LIMIT ".$iter.",10";
      $var = "homepage_count";
      statslib_top($query,$var,$message,$iter);

      $db->query($query_partial);
      $numiter = $db->num_rows()/10;
      $url = "stats.php3";
      $urlquery = array("option" => "apps");
      show_more ($iter,$numiter,$url,$urlquery);
      break;

// Top Downloaded RPMs / DEBs / SLCs
// The same (with its parameters) could be done for DEBs, TGZs, etc
    case "rpm":
    case "deb":
    case "tgz":

     $query_partial = "SELECT *,SUM(".$option."_cnt) AS ".$option."_count FROM software,counter WHERE software.appid=counter.appid AND software.status='A' AND $option !='' AND counter.".$option."_cnt>0 GROUP BY software.name ORDER BY ".$option."_count DESC";
     $query = $query_partial." LIMIT ".$iter.",10";

     $option_save = $option;
     $var = $option."_count";
     switch ($option) {
       case "rpm": $option="Red Hat Packages"; break;
       case "deb": $option="Debian Packages"; break;
       case "tgz": $option="Slackware Packages"; break;
     }
     $message = "Top downloaded ".$option;
     statslib_top($query,$var,$message,$iter);

        			// to have only the needed iteractions
     $db->query($query_partial);
     $numiter = $db->num_rows()/10;

     $url = "stats.php3";
     $urlquery = array("option" => $option_save);
     show_more ($iter,$numiter,$url,$urlquery);
     break;

// Sections
    case "sections":

      stats_title($t->translate("Applications listed by Sections"));
      $db->query("SELECT DISTINCT section, COUNT(*) AS cnt_sec FROM software GROUP BY section ORDER BY cnt_sec DESC");
      while($db->next_record()) {
        $url = "categories.php3";
	$urlquery = array("section" => $db->f("section"));
        stats_display($db->f("section"),$db->f("cnt_sec"),$url,$urlquery,$total_number_apps);
      }
      stats_end();

    // Total number of importance
      $db->query("SELECT SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");

      stats_title($t->translate("Application Importance listed by Sections"));
      $db->query("SELECT DISTINCT section, SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM software,counter WHERE software.appid = counter.appid GROUP BY section ORDER BY sum_cnt DESC");
      while($db->next_record()) {
        $url = "categories.php3";
	$urlquery = array("section" => $db->f("section"));
        stats_display($db->f("section"),$db->f("sum_cnt"),$url,$urlquery,$total);
      }
      stats_end();
      break;

// Categories
    case "categories":

      stats_title($t->translate("Applications listed by Categories"));
      $db->query("SELECT DISTINCT section,COUNT(*) FROM categories GROUP BY section");
      while($db->next_record()) {
        $section = $db->f("section");
        if ($db->f("COUNT(*)") != 0) {
          stats_subtitle($t->translate("Section")." ".$section);
          $db2 = new DB_DevCounter;
          $db2->query("SELECT category,COUNT(*) AS cat_cnt FROM software WHERE section='$section' GROUP BY category");
          while ($db2->next_record()) {
            if ($db2->f("cat_cnt") != 0) { 
              $url = "appbycat.php3";
	      $urlquery = array("section" => $section, "category" => $db2->f("category"));
              stats_display($db2->f("category"),$db2->f("cat_cnt"),$url,$urlquery,$total_number_apps);
            }
          }
        }
      }
      stats_end();
      break;

// Licenses
    case "licenses":

    // Total number of apps
      $db->query("SELECT COUNT(*) FROM software");
      $db->next_record();
      $total = $db->f("COUNT(*)");

     stats_title($t->translate("Applications listed by Licenses"));
     $db->query("SELECT licenses.license, licenses.url, COUNT(*) AS lic_cnt FROM software,licenses WHERE software.license = licenses.license GROUP BY licenses.license ORDER BY lic_cnt DESC");
     while($db->next_record()) {
       $urlquery = "0";   // no additional query needed!
       stats_display($db->f("license"),$db->f("lic_cnt"),$db->f("url"),$urlquery,$total);
     }
     stats_end();
     break;

// Format (tarball / rpm / deb / tgz)
    case "format":

    // Total number of apps
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Availability of downloadable Packet Formats"));
      for($i=0;$i<4;$i++) {
        switch($i) {
          case 0: $message=$t->translate("Tarballs"); $type="download"; break;
          case 1: $message=$t->translate("Red Hat Packages")." (rpm)"; $type="rpm"; break;
          case 2: $message=$t->translate("Debian Packages")." (deb)"; $type="deb"; break;
          case 3: $message=$t->translate("Slackware Packages")." (tgz)"; $type="tgz"; break;
        } 
        $db->query("SELECT COUNT(*) FROM software WHERE software.$type !='' AND software.status='A'");
        $db->next_record();
        stats_display($message,$db->f("COUNT(*)"),$url,$urlquery,$total_number_apps * 1.001);
      }
      stats_end();

    // More stats by Format

    // Total number of downloads
      $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Downloads listed by Packet Formats"));
      for($i=0;$i<4;$i++) {
        switch($i) {
          case 0: $message=$t->translate("Tarballs"); $type="download_cnt"; break;
          case 1: $message=$t->translate("Red Hat Packages")." (rpm)"; $type="rpm_cnt"; break;
          case 2: $message=$t->translate("Debian Packages")." (deb)"; $type="deb_cnt"; break;
          case 3: $message=$t->translate("Slackware Packages")." (tgz)"; $type="tgz_cnt"; break;
        } 
        $db->query("SELECT SUM($type) FROM counter");
        $db->next_record();
        stats_display($message,$db->f("SUM($type)"),$url,$urlquery,$total);
      }
      stats_end();
      break;

// Urgency
    case "urgency":

    // Total number of apps
      $db->query("SELECT COUNT(*) FROM software");
      $db->next_record();
      $total = $db->f("COUNT(*)");
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Applications listed by Urgency"));
      for($i=0;$i<3;$i++) {
        switch($i) {
          case 0: $message=$t->translate("High Urgency"); $type="3"; break;
          case 1: $message=$t->translate("Medium Urgency"); $type="2"; break;
          case 2: $message=$t->translate("Low Urgency"); $type="1"; break;
        } 
        $db->query("SELECT COUNT(*) FROM software WHERE software.urgency = '$type' AND software.status='A'");
        $db->next_record();
        stats_display($message,$db->f("COUNT(*)"),$url,$urlquery,$total);
      }
      stats_end();

    // We look how the download of this apps looks like

    // Total number of downloads
      $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Downloads listed by Urgency"));
      for($i=0;$i<3;$i++) {
        switch($i) {
          case 0: $message=$t->translate("High Urgency"); $type="3"; break;
          case 1: $message=$t->translate("Medium Urgency"); $type="2"; break;
          case 2: $message=$t->translate("Low Urgency"); $type="1"; break;
        } 
        $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM software,counter WHERE software.urgency = '$type'  AND software.appid = counter.appid AND software.status='A'");
        $db->next_record();
        stats_display($message,$db->f("sum_cnt"),$url,$urlquery,$total);
      }
      stats_end();
      break;

// Type (Stable / Development)
    case "version_type":
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Applications listed by Version Type"));
      for($i=0;$i<2;$i++) {
        switch($i) {
          case 0: $message=$t->translate("Stable Version"); $type="S"; break;
          case 1: $message=$t->translate("Development Version"); $type="D"; break;
        } 
        $db->query("SELECT COUNT(*) FROM software WHERE software.type = '$type' AND software.status='A'");
        $db->next_record();
        stats_display($message,$db->f("COUNT(*)"),$url,$urlquery,$total_number_apps);
      }
      stats_end();

    // We look how the download of this apps looks like

    // Total number of downloads
      $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";          // No URL query in function stats_display

      stats_title($t->translate("Downloads listed by Version Type"));
      for($i=0;$i<2;$i++) {
        switch($i) {
          case 0: $message=$t->translate("Stable Version"); $type="S"; break;
          case 1: $message=$t->translate("Development Version"); $type="D"; break;
        } 
        $db->query("SELECT SUM(download_cnt+rpm_cnt+deb_cnt+tgz_cnt) AS sum_cnt FROM software,counter WHERE software.type = '$type' AND software.appid = counter.appid AND software.status='A'");
        $db->next_record();
        stats_display($message,$db->f("sum_cnt"),$url,$urlquery,$total);
      }
      stats_end();
      break;


// Version Number by Apps
    case "version_number":

    // Total number of apps
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Applications listed by Version Numbers"));
      for($i=0;$i<30;$i++) {
        $like = "'".$i.".%'";
        $db->query("SELECT COUNT(*) FROM software WHERE version LIKE $like");
        $db->next_record();
        $num = $db->f("COUNT(*)");
        if (100 * $num/$total_number_apps > 0) stats_display($t->translate("Version Number").": ".$i.".x",$num,$url,$urlquery,$total_number_apps);
      }  
      stats_end();
      break;


// Importance by License
    case "importance_license":

    // Total number of importance
      $db->query("SELECT SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");

      $urlquery = "0"; //No additional URL query needed

      stats_title($t->translate("Application Importance listed by Licenses"));
      $db->query("SELECT licenses.license, licenses.url, SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM software,counter,licenses WHERE software.appid = counter.appid AND software.license = licenses.license GROUP BY licenses.license ORDER BY sum_cnt DESC");
      while($db->next_record()) {
        stats_display($db->f("license"),$db->f("sum_cnt"),$db->f("url"),$urlquery,$total);
      }
      stats_end();
      break;


// Apps by Email from Developer
    case "importance_email":

    // Total number of importance
      $db->query("SELECT SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM counter");
      $db->next_record();
      $total = $db->f("sum_cnt");
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Application Importance listed by Developer's Email Domains"));
      for($i=1;$i<sizeof($domain_country);$i++) {
        $num = 0;
        $like = "'%.".$domain_country[$i][0]."'";
        $db->query("SELECT SUM(app_cnt+homepage_cnt+changelog_cnt+download_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt from software,counter WHERE software.status='A' AND software.appid=counter.appid AND email LIKE $like GROUP BY software.appid");
	while($db->next_record()) {
          $num = $num + $db->f("sum_cnt");
        }
        if (100 * $num/$total > $MinimumAppsByEmail) stats_display($domain_country[$i][1],$num,$url,$urlquery,$total); 
      }
      stats_end();
      break;  


// Apps by Email from Developer
    case "email":

    // Total number of apps
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Applications listed by Developer's Email Domain"));
      for($i=1;$i<sizeof($domain_country);$i++) {
        $num = 0;
        $like = "'%.".$domain_country[$i][0]."'";
        $db->query("Select COUNT(*) from software WHERE email LIKE $like");
        $db->next_record();
        $num = $db->f("COUNT(*)");
        if (100 * $num/$total_number_apps > $MinimumAppsByEmail) stats_display($domain_country[$i][1],$num,$url,$urlquery,$total_number_apps); 
      }
      stats_end();
      break; 


// Sections by Email from Developer
    case "email_section":

      stats_title($t->translate("Applications listed by Sections and Developer's Email Domain"));
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

    $db->query("SELECT DISTINCT section FROM categories");
    while($db->next_record()) {
			// We need a second database connection
      $db2 = new DB_DevCounter;
      // Total number of apps within that section
      $section = $db->f("section");
      $db2->query("SELECT COUNT(*) FROM software WHERE section='$section'");
      $db2->next_record();
      $total = $db2->f("COUNT(*)");

      if ($total > 0) {
        stats_subtitle($t->translate("Section")." ".$db->f("section"));
        for($i=1;$i<sizeof($domain_country);$i++) {
          $like = "%.".$domain_country[$i][0];
          $db2->query("SELECT COUNT(*) FROM software WHERE section='$section' AND email LIKE '$like'");
          $db2->next_record();
	  $num = $db2->f("COUNT(*)");
	  $epsilon = 0.0001;    // to avoid having division by zero       
          if (100 * $num/($total+$epsilon) > $MinimumSeccByEmail) stats_display($domain_country[$i][1],$num,$url,$urlquery,$total);
        }
      }
    }
    stats_end();
    break;


// Licenses by Email from Developer
    case "email_license":

    stats_title($t->translate("Applications listed by Licenses and Developer's Email Domain"));
    $url = "0"; 		// No URL in function stats_display
    $urlquery = "0";		// No URL query in function stats_display

    $db->query("SELECT license FROM licenses");
    while($db->next_record()) {
			// We need a second database connection
      $db2 = new DB_DevCounter;
      // Total number of apps with that License
      $license = $db->f("license");
      $db2->query("SELECT COUNT(*) FROM software WHERE license='$license'");
      $db2->next_record();
      $total = $db2->f("COUNT(*)");

      if ($total > $Minimum_apps_in_license) {
        stats_subtitle($db->f("license"));
        for($i=1;$i<sizeof($domain_country);$i++) {
          $like = "%.".$domain_country[$i][0];
          $db2->query("SELECT COUNT(*) FROM software WHERE license='$license' AND email LIKE '$like'");
          $db2->next_record();
	  $num = $db2->f("COUNT(*)");
          if (100 * $num/$total > $MinimumLicByEmail) stats_display($domain_country[$i][1],$num,$url,$urlquery,$total);
        }
      }
    }
    stats_end();
    break;
  }
}

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
