<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Statistics of the System
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: stats.php,v 1.10 2002/09/03 10:44:24 helix Exp $
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

require("./include/header.inc");
require("./include/statslib.inc");

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
echo "<tr>";
echo "<td><a href=\"".$sess->url("stats.php?option=general")."\">".$t->translate("General $sys_name Statistics")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=birth")."\">".$t->translate("Developers by Year of Birth")."</a></td>\n";
echo "</tr><tr>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=visits")."\">".$t->translate("Developer by Visits")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=profession")."\">".$t->translate("Developers by Profession")."</a></td>\n";
echo "</tr><tr>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=gender")."\">".$t->translate("Developers by Gender")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=qualification")."\">".$t->translate("Developers by Qualification")."</a></td>\n";
echo "</tr><tr>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=email")."\">".$t->translate("Developers by Email Domains")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=prog_abilities")."\">".$t->translate("Developers by Programming Abilities")."</a></td>\n";
echo "</tr><tr>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=prog_languages")."\">".$t->translate("Developers by Programming Languages/Tools")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=nationality")."\">".$t->translate("Developers by Nationality")."</a></td>\n";
echo "</tr><tr>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=lives_in")."\">".$t->translate("Developers by Countries currently lives in")."</a></td>\n";
echo "<td><a href=\"".$sess->url("stats.php?option=mother_tonque")."\">".$t->translate("Developers by Mother Tonque")."</a></td>\n";
echo "</tr>\n";
echo "</table>\n";

$bx->box_body_end();
$bx->box_end();

if (isset($option)) {
// We need to know the total number of developers for certain stats

  $db->query("SELECT COUNT(*) FROM developers");
  $db->next_record();
  $total_number_dev = $db->f("COUNT(*)");
  $numiter = ($db->f("COUNT(*)")/10);

  switch($option) {

// General stats
    case "general":

      $bx->box_begin();
      $bx->box_title($t->translate("General $sys_name Statistics"));
      $bx->box_body_begin();

      echo "<CENTER><table border=0 width=90% align=center cellspacing=0>\n";

    // Total number of Developers
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Developers in $sys_name")."</td>\n";
      echo "<td width=20% align=right>".$total_number_dev."</td></tr>\n";

    // Number of today's visitors
      $db->query("SELECT DISTINCT ipaddr FROM counter_check");
      $db->next_record();
      $count = 4*$db->affected_rows();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of today's visitors")."</td>\n";
      echo "<td width=20% align=right>$count</td></tr>\n";

    // Total number of Projects
      $db->query("SELECT COUNT(*) FROM os_projects");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Projects")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Countries
      $db->query("SELECT COUNT(*) FROM countries WHERE language='English'");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Countries")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Languages
      $db->query("SELECT COUNT(*) FROM languages WHERE translation='English'");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Languages")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Progamming Abilities
      $db->query("SELECT COUNT(*) FROM prog_abilities");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Programming Abilities")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Total number of Progamming Languages/Tools
      $db->query("SELECT COUNT(*) FROM prog_languages");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Programming Languages/Tools")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

    // Number of Visits
      echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";

      echo "<tr><td colspan=2><table width=100% border=0 cellspacing=0 cellpadding=0>";
      echo "<tr><td width=70%>&nbsp;</td>\n";
      echo "<td width=15% align=right>".$t->translate("Today").":</td>\n";
      echo "<td width=15% align=right>&nbsp;".$t->translate("Total").":</td></tr>\n";

	// Visits on Developers
      $db->query("SELECT COUNT(*) FROM counter_check");
      $db->next_record();
      echo "<tr><td width=%85>&nbsp;".$t->translate("Number of Visits on Developers")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td>\n";
      $db->query("SELECT SUM(devel_cnt) FROM counter");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("SUM(devel_cnt)")."</td></tr>\n";

    // Number of inserted or modified Developers
      $day=1;
      $db->query("SELECT COUNT(*) FROM auth_user,developers WHERE auth_user.username=developers.username AND (DATE_FORMAT(auth_user.modification_usr,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY) OR DATE_FORMAT(developers.creation,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY))");
      $db->next_record();
      echo "<tr><td width=85%>&nbsp;".$t->translate("Number of Insertions and Modifications")."</td>\n";
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td>\n";
      $day=7;
      $db->query("SELECT COUNT(*) FROM auth_user,developers WHERE auth_user.username=developers.username AND (DATE_FORMAT(auth_user.modification_usr,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY) OR DATE_FORMAT(developers.creation,'%Y-%m-%d')>=DATE_SUB(CURRENT_DATE,INTERVAL \"$day\" DAY))");
      $db->next_record();
      echo "<td width=20% align=right>".$db->f("COUNT(*)")."</td></tr>\n";

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

// Developers by Visits
    case "visits":
      $message = "Developers listed by Number of Visits";
      $query_partial = "SELECT *,SUM(devel_cnt) AS devel_count FROM developers,counter WHERE developers.develid=counter.develid GROUP BY developers.username ORDER BY devel_count DESC";
      $query = $query_partial." LIMIT ".$iter.",10";
      $var = "devel_count";
      statslib_top($query,$var,$message,$iter);

      $db->query($query_partial);
      $numiter = $db->num_rows()/10;
      $url = "stats.php";
      $urlquery = array("option" => "visits");
      show_more ($iter,$numiter,$url,$urlquery);
      break;

// Developers by Year of Birth
    case "birth":
      stats_title($t->translate("Developers listed by Year of Birth"));
      $db->query("SELECT year_of_birth,COUNT(*) AS birth_cnt FROM developers GROUP BY year_of_birth ORDER BY year_of_birth DESC");
      while($db->next_record()) {
        stats_display("19".$db->f("year_of_birth"),$db->f("birth_cnt"),"","",$total_number_dev);
      }
      stats_end();
      break;

// Developers by Gender
    case "gender":
      stats_title($t->translate("Developers listed by Gender"));
      $db->query("SELECT *,COUNT(*) AS gend_cnt FROM developers,gender WHERE developers.gender=gender.gendid GROUP BY gender.gendid ORDER BY gend_cnt DESC");
      while($db->next_record()) {
        stats_display($t->translate($db->f("gender")),$db->f("gend_cnt"),"","",$total_number_dev);
      }
      stats_end();
      break;

// Developers by Profession
    case "profession":
      stats_title($t->translate("Developers listed by Profession"));
      $db->query("SELECT *,COUNT(*) AS prof_cnt FROM developers,profession WHERE developers.profession = profession.profid GROUP BY profession.profid ORDER BY prof_cnt DESC");
      while($db->next_record()) {
        stats_display($t->translate($db->f("profession")),$db->f("prof_cnt"),"","",$total_number_dev);
      }
      stats_end();
      break;
 
// Developers by Qualification
    case "qualification":
      stats_title($t->translate("Developers listed by Qualification"));
      $db->query("SELECT *,COUNT(*) AS qual_cnt FROM developers,qualification WHERE developers.qualification = qualification.qualid GROUP BY qualification.qualid ORDER BY qual_cnt DESC");
      while($db->next_record()) {
        stats_display($t->translate($db->f("qualification")),$db->f("qual_cnt"),"","",$total_number_dev);
      }
      stats_end();
      break;

// Developers by Email
    case "email":

    // Total number of developer
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      stats_title($t->translate("Developers listed by Email Domain"));

      for($i=1;$i<sizeof($domain_country);$i++) {
        $num = 0;
        $like = "'%.".$domain_country[$i][0]."'";
        $db->query("Select COUNT(*) from auth_user WHERE email_usr LIKE $like");
        $db->next_record();
        $num = $db->f("COUNT(*)");
        if (100 * $num/$total_number_dev > $MinimumAppsByEmail) stats_display($domain_country[$i][1],$num,$url,$urlquery,$total_number_dev); 
      }
      stats_end();
      break; 


// Developers by Programming Abilities
    case "prog_abilities":

      stats_title($t->translate("Developers listed by Programming Abilities"));
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      $db2 = new DB_DevCounter;
      $db3 = new DB_DevCounter;

      $db->query("SELECT * FROM prog_abilities WHERE translation='$la'");
      while($db->next_record()) {

        stats_subtitle($t->translate($db->f("ability")));

        $db2->query("SELECT * FROM weightings");
        while ($db2->next_record()) {
          $db3->query("SELECT COUNT(*) FROM prog_ability_values WHERE ".$db->f("colname")."='".$db2->f("weightid")."'");
          $db3->next_record();
	      $num = $db3->f("COUNT(*)");
          stats_display($t->translate($db2->f("weighting")),$num,$url,$urlquery,$total_number_dev);
        }
      }
      stats_end();
      break; 

// Developers by Programming Languages/Tools
    case "prog_languages":

      stats_title($t->translate("Developers listed by Programming Languages/Tools"));
      $url = "0"; 		// No URL in function stats_display
      $urlquery = "0";		// No URL query in function stats_display

      $db2 = new DB_DevCounter;
      $db3 = new DB_DevCounter;

      $db->query("SELECT * FROM prog_languages");
      while($db->next_record()) {

        stats_subtitle($t->translate($db->f("language")));

        $db2->query("SELECT * FROM weightings");
        while ($db2->next_record()) {
          $db3->query("SELECT COUNT(*) FROM prog_language_values WHERE ".$db->f("colname")."='".$db2->f("weightid")."'");
          $db3->next_record();
	      $num = $db3->f("COUNT(*)");
          stats_display($t->translate($db2->f("weighting")),$num,$url,$urlquery,$total_number_dev);
        }
      }
      stats_end();
      break;


// Developers by Nationality
    case "nationality":
      stats_title($t->translate("Developers listed by Nationality"));
      $db->query("SELECT *,COUNT(*) AS nat_cnt FROM developers GROUP BY developers.nationality ORDER BY nat_cnt DESC");
     while($db->next_record()) {
       stats_display(get_country($db->f("nationality")),$db->f("nat_cnt"),"","",$total_number_dev);
     }
     stats_end();
     break;


// Developers by Countries currently lives in
    case "lives_in":
      stats_title($t->translate("Developers listed by Countries currently lives in"));
      $db->query("SELECT *,COUNT(*) AS nat_cnt FROM developers GROUP BY developers.actual_country ORDER BY nat_cnt DESC");
     while($db->next_record()) {
       stats_display(get_country($db->f("actual_country")),$db->f("nat_cnt"),"","",$total_number_dev);
     }
     stats_end();
     break;


// Developers by Mother Tonque
    case "mother_tonque":
      stats_title($t->translate("Developers listed by Mother Tongue"));
      $db->query("SELECT *,COUNT(*) AS nat_cnt FROM developers GROUP BY developers.mother_tongue ORDER BY nat_cnt DESC");
     while($db->next_record()) {
       stats_display(get_lang($db->f("mother_tongue")),$db->f("nat_cnt"),"","",$total_number_dev);
     }
     stats_end();
     break;
  }
}

?>
<!-- end content -->

<?php
require("./include/footer.inc");
page_close();
?>
