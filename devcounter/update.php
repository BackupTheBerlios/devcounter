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
# Form to update developers profile
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: update.php,v 1.7 2004/03/02 09:22:58 helix Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

$db2 = new DB_DevCounter;
$db3 = new DB_DevCounter;
?>

<!-- content -->
<?php
if (empty($auth->auth["uname"]))
  {
   $bx->box_begin();
   $bx->box_title($t->translate("Not logged in"));
   $bx->box_body_begin();
   echo $t->translate("Please login first")."\n";
   $bx->box_body_end();
   $bx->box_end();
  }
else
  {
   $bx->box_begin();
   $bx->box_title($t->translate("Personal Data"));
   $bx->box_body_begin();
  
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";
   htmlp_form_action("update2db.php",array(),"POST");
   echo "\n";

   $username=$auth->auth["uname"];
   $db->query("SELECT * from developers WHERE username='$username'");
   $db->next_record();

   htmlp_form_hidden("username", $username);
   echo "<tr><td align=right width=30%>".$t->translate("Username").":</td><td width=70%> $username\n";
  
   $nationality = $db->f("nationality");
   echo "<tr><td align=right width=30%>".$t->translate("Nationality").":</td><td width=70%>\n";
   htmlp_select("nationality"); echo "\n";
   select_country($nationality);
   htmlp_select_end(); echo "</td></tr>\n";

   $actual_country = $db->f("actual_country");
   echo "<tr><td align=right width=30%>".$t->translate("Country you currently live in").":</td><td width=70%>\n";
   htmlp_select("actual_country"); echo "\n";
   select_country($actual_country);
   htmlp_select_end(); echo "</td></tr>\n";
   $year_of_birth = $db->f("year_of_birth");
   echo "<tr><td align=right width=30%>".$t->translate("Year of Birth").":</td><td width=70%>19<input type=\"TEXT\" name=\"year_of_birth\" size=3 maxlength=2 value=\"$year_of_birth\"></td></tr>\n";

   $gender = $db->f("gender");
   echo "<tr><td align=right width=30%>".$t->translate("Gender").":</td><td width=70%>\n";
   echo "<center><table width=80% border=0>\n";
   echo "<tr>";

   $db3->query("SELECT * FROM gender");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("gendid") == $gender) $selected = 1;
      echo "<td width=26%>";
      htmlp_radio("gender",$db3->f("gendid"),$selected);
      echo "&nbsp; ".$t->translate($db3->f("gender"))."\n";
      echo "</td>\n";
   }

   echo "</tr></table></center>\n";
   echo "</td></tr>\n";

   $mother_tongue = $db->f("mother_tongue");
   echo "<tr><td align=right width=30%>".$t->translate("Mother tongue").":</td><td width=70%>\n";
   htmlp_select("mother_tongue"); echo "\n";
   select_lang($mother_tongue);
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right valign=top width=30%><BR>".$t->translate("Other languages").":</td><td width=70%>\n";
   echo "<table width=90% border=0>\n";
   echo "<tr>";
   echo "<td width=25% valign=top>2. ";
   $other_lang_1 = $db->f("other_lang_1");
   htmlp_select("other_lang_1"); echo "\n";
   select_lang($other_lang_1);
   $other_lang_2 = $db->f("other_lang_2");
   htmlp_select_end(); echo "</td>\n";
   echo "<td width=25% valign=top>3. ";
   htmlp_select("other_lang_2"); echo "\n";
   select_lang($other_lang_2);
   htmlp_select_end(); echo "</td>\n";

   echo "</td></tr>\n";
   echo "</table>\n";
   echo "</td></tr>\n";
   echo "</table>\n";

   $bx->box_body_end();
   $bx->box_end();

   $bx->box_begin();
   $bx->box_title($t->translate("Professional Data"));
   $bx->box_body_begin();
 
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   $profession = $db->f("profession");
   echo "<tr><td align=right width=30%>".$t->translate("Profession").":</td><td width=70%>\n";
   htmlp_select("profession");

   $db3->query("SELECT * FROM profession");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("profid") == $profession) $selected = 1;
      htmlp_select_option($db3->f("profid"),$selected,$t->translate($db3->f("profession")));
   }
   htmlp_select_end();
   echo "</td></tr>\n";

   $qualification = $db->f("qualification");
   echo "<tr><td align=right width=30%>".$t->translate("Qualification").":</td><td width=70%>\n";
   htmlp_select("qualification");

   $db3->query("SELECT * FROM qualification");
   while ($db3->next_record()) {
      $selected = 0;
      if ($db3->f("qualid") == $qualification) $selected = 1;
      htmlp_select_option($db3->f("qualid"),$selected,$t->translate($db3->f("qualification")));
   }
   htmlp_select_end();
   echo "</td></tr>\n";

   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();

   $bx->box_begin();
   $bx->box_title($t->translate("Computer Experience"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   //$number_of_projects = $db->f("number_of_projects");
   echo "<tr><td align=center>";
   echo "<B><FONT SIZE=+1>".$t->translate("Projects")."</FONT></B><BR>";
   $db->query("SELECT * from os_projects WHERE username='$username'");
   if ($db->num_rows() ==0)
      htmlp_link("addproj.php","",$t->translate("Manage your Project List"));
   else
      htmlp_link("projects.php","",$t->translate("Manage your Project List"));
   
   echo "</td></tr>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><B><FONT SIZE=+1>".$t->translate("Which of these programming expirience do you have?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table width=90% border=0>\n";

   $db2->query("select * from prog_ability_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");
   $ability_amount=$db->num_rows();
   $counter=0;
   while ($counter<$ability_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 2)==1)
         echo "<tr><td width=33%>\n";
      else
         echo "<td width=33%>\n";
      $ability_value = 0;
      $ability_code = $db->f("code");
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("ability")."\n";
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      echo "</td><td width=20% align=right>";
      htmlp_select("ability[".$ability_code."]");      
      $db3->query("SELECT * FROM weightings");
      while ($db3->next_record()) {
         $selected = 0;
         if ($db3->f("weightid") == $ability_value) $selected = 1;
         htmlp_select_option($db3->f("weightid"),$selected,$t->translate($db3->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 2)==0)
         echo "</td></tr>\n\n"; 
      else
         echo "</td>\n";
     }
     
   if (($counter % 2)==0)
      echo "</tr>\n\n";
   htmlp_form_hidden("ability_amount", $ability_amount);
  
   echo "</table></center>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><FONT SIZE=+1>".$t->translate("Which of these languages/tools are you experienced with?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";

   $db2->query("select * from prog_language_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_languages");
   $lang_amount=$db->num_rows();
   $counter=0;
   while ($counter<$lang_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 2)==1)
         echo "<tr><td width=33%>\n";
      else
        echo "<td width=33%>\n";
      $ability_value = 0;
      $ability_code = $db->f("code");
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("language")."\n";
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      echo "</td><td width=20% align=right>";
      htmlp_select("plang[".$ability_code."]"); 
      $db3->seek(0);
      while ($db3->next_record()) {
         $selected = 0;
         if ($db3->f("weightid") == $ability_value) $selected = 1;
         htmlp_select_option($db3->f("weightid"),$selected,$t->translate($db3->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 2)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 2)==0)
      echo "</tr>\n\n";
   htmlp_form_hidden("lang_amount", $lang_amount);
  
   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();

   echo"<CENTER><TABLE BORDER=0 width=89%><TR><TD width=65%>\n";
 
   echo "<CENTER>";
   htmlp_form_submit($t->translate("Submit"),"");
   echo "</CENTER>";

   echo "</td></tr>\n";
   echo "</table>\n";

   echo"</TD><TD width=5%>&nbsp;\n";
   echo"</TD><TD width=30%>\n";
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
