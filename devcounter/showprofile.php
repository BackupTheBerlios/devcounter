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
# Show developers profile data
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: showprofile.php,v 1.8 2004/03/02 09:22:58 helix Exp $
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
?>

<!-- content -->
<?php
$db->query("SELECT * from auth_user,developers,extra_perms WHERE auth_user.username = developers.username AND developers.username='$devname' AND extra_perms.username='$devname'");
if ($db->num_rows() == 0)
  {
      
   $be->box_full($t->translate("Error"), $t->translate("Developer did not specify a Profile yet"));
   
   
   
   echo "<CENTER><TABLE BORDER=\"0\" WIDTH=\"60%\">";
   echo "<TR><TD VALIGN=\"top\">";

   switch ($la) {
   case "English":
   	require("./include/English-intro.inc");
   	break;
   case "German":
   	require("./include/German-intro.inc");
   	break;
   /*
   case "Spanish":
   	require("./include/Spanish-lang.inc");
   	break;
   case "French":
   	require("./include/French-lang.inc");
   	break;
   */
   default:
   	require("./include/English-intro.inc");
   	break;
   }
   echo " ";

   echo "</TD></TR></TABLE></CENTER>";

   
   
   
  }
else
  {
   $db->next_record();
   $develid = $db->f("develid");
   increasecnt($develid);
   $username = $devname;
   
   echo "<CENTER><FONT SIZE=\"+3\"><B>&nbsp;&nbsp;$devname&nbsp;&nbsp;</B></FONT></CENTER><BR><BR>";

   $bx->box_begin();
   $bx->box_title($t->translate("Personal Data"));
   $bx->box_body_begin();

   echo "<table border=0 width=100% align=center cellspacing=3 cellpadding=3>\n";
   //echo "<tr><td align=right width=30%>".$t->translate("Username").":</td><td width=70%> $username\n";
  
   if ($db->f("showname") == "yes") {
      echo "<tr><td align=right width=30%>".$t->translate("Realname").":</td><td width=70%>".$db->f("realname")."\n";
   }
  
   $year_of_birth = $db->f("year_of_birth");
   if ($year_of_birth == "0") {
      $year_of_birth = $t->translate("No Entry");
   } else {
      $year_of_birth = "19".$year_of_birth;
   }
   echo "<tr><td align=right width=30%>".$t->translate("Year of Birth").":</td><td width=70%>$year_of_birth\n";

   $gendid = $db->f("gender");
   $gender = get_gender($gendid);
   echo "<tr><td align=right width=30%>".$t->translate("Gender").":</td><td width=70%>".$t->translate("$gender")."\n";

   $nationality = $db->f("nationality");
   echo "<tr><td align=right width=30%>".$t->translate("Nationality").":</td><td width=70%>\n";
   print_country($nationality);

   $actual_country = $db->f("actual_country");
   echo "<tr><td align=right width=30%>".$t->translate("Currently lives in").":</td><td width=70%>\n";
   print_country($actual_country);

   echo "<tr><td align=right valign=top width=30%>".$t->translate("Mother tongue").":</td><td width=70%>\n";
   
   $mother_tongue = $db->f("mother_tongue");
   print_lang($mother_tongue);

   echo "<tr><td align=right valign=top width=30%>".$t->translate("Other languages").":</td><td width=70%>\n";
   
   $other_lang_1 = $db->f("other_lang_1");
   echo "1. ";
   print_lang($other_lang_1);

   $other_lang_2 = $db->f("other_lang_2");
   echo "<BR>2. ";
   print_lang($other_lang_2);
   echo "</td></tr>\n";

   if ($db->f("contact")!="no") {
      echo "<tr><td align=right width=30%>".$t->translate("Contact").":</td><td width=70%>";
      $pquery["devname"] = $db->f("username") ;
      htmlp_link("pmess_compose.php",$pquery,$t->translate("write Developer"));
   }

   if ($db->f("showemail") == "yes") {
      echo "<tr><td align=right width=30%>".$t->translate("E-Mail").":</td><td width=70%><a href=\"mailto:".$db->f("email_usr")."\">".ereg_replace("@"," at ",htmlentities($db->f("email_usr")))."</a>\n";
   }
  
   echo "<tr><td align=right width=30%>".$t->translate("Developer last modified").":</td><td width=70%>\n";
   $timestamp = mktimestamp($db->f("modification_usr"));
   echo timestr($timestamp)."</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Developer created").":</td><td width=70%>\n";
   $timestamp = mktimestamp($db->f("creation_usr"));
   echo timestr($timestamp)."</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Profile last modified").":</td><td width=70%>\n";
   $timestamp = mktimestamp($db->f("creation"));
   echo timestr($timestamp)."</td></tr>\n";

   $db2->query("SELECT devel_cnt FROM counter WHERE develid='$develid'");
   $db2->next_record();
   echo "<tr><td align=right width=30%>".$t->translate("# of Visits").":</td><td width=70%>\n";
   echo $db2->f("devel_cnt")."</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Registration Number").":</td><td width=70%>\n";
   echo printf("#%09d",$develid)."</td></tr>\n";

   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();
   
   $bx->box_begin();
   $bx->box_title($t->translate("Professional Data"));
   $bx->box_body_begin();

   echo "<table border=0 width=100% align=center cellspacing=3 cellpadding=3>\n";
  
   $profid = $db->f("profession");
   $prof = get_profession($profid);
   echo "<tr><td align=right width=30%>".$t->translate("Profession").":</td><td width=70%>".$t->translate($prof)."\n";

   $qualid = $db->f("qualification");
   $qual = get_qualification($qualid);
   echo "<tr><td align=right width=30%>".$t->translate("Qualification").":</td><td width=70%>".$t->translate($qual)."\n";

   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();
   
   $bx->box_begin();
   $bx->box_title($t->translate("Computer Experience"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   $number_of_projects = $db->f("number_of_projects");
   echo "<tr><td align=left>".$t->translate("Number of Free Software/Open Source Projects").": $number_of_projects\n";
   echo "<P>";
   $db2->query("SELECT * FROM os_projects WHERE username='$username'");
   $number_of_projects=$db2->num_rows();
   if ($number_of_projects > 0)
   {
   $counter=0;
   $db->query("SELECT * from os_projects ");
   $bx->box_begin();
   $bx->box_body_begin();
   $bx->box_columns_begin(3);
   $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
   $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Project")."</b>");
   $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Comment")."</b>");
   $bx->box_next_row_of_columns();
   $bgcolor = "#FFFFFF";
   while ($counter!=$number_of_projects)
     {
      $db2->next_record();
      $counter++;
      if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
      else {$bgcolor = "#E0E0E0";}
      $bx->box_column("right","",$bgcolor,$counter);
      if (ereg("://",$db2->f("url")))
      { $bx->box_column("center","",$bgcolor,"<A HREF=\"".$db2->f("url")."\">".$db2->f("projectname")."</A>"); } 
      else
      { $bx->box_column("center","",$bgcolor,"<A HREF=\"http://".$db2->f("url")."\">".$db2->f("projectname")."</A>"); }
      $bx->box_column("center","",$bgcolor,$db2->f("comment"));
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
     
     }
    $bx->box_columns_end();
    $bx->box_body_end();
    $bx->box_end();
    }

   echo "</td></tr>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><B>".$t->translate("Programming Experience")."</B></td></tr><tr><td>\n";
   echo "<center><table width=100% border=0 cellspacing=6>\n";

   $db2->query("select * from prog_ability_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");
   $ability_amount=$db->num_rows();
   $counter=0; $counter2=0;
   
   while ($counter < $ability_amount)
     {
      $counter++;
      $db->next_record();
      $ability_value = 0;
      $ability_code = $db->f("code");
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      if ($ability_value > 1)
        {
         $counter2++;
         if (($counter2 % 3) == 1)
            echo "<tr><td width=18% align=right>\n";
         else
            echo "<td width=18% align=right>\n";
         echo $db->f("ability")."\n";
         echo "</td><td width=90>";
      
         $printstars = 1;
         while ($printstars != $ability_value)
           {
            htmlp_image("13.gif", 0, 17, 16 , "*");
            $printstars++;
      	   }
      
         if (($counter2 % 3) == 0)
            echo "</td></tr>\n\n";
         else
            echo "</td>\n";
        }
     }
     
   if (($counter2 % 3) == 0)
      echo "</tr>\n\n"; 
   htmlp_form_hidden("ability_amount", $ability_amount);
  
   echo "</table></center>\n";

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B>".$t->translate("Languages/Tools Experience")."</B></td></tr><tr><td>\n";
   echo "<center><table border=0 width=100% cellspacing=6>\n";

   $db2->query("select * from prog_language_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_languages");
   $lang_amount=$db->num_rows();
   $counter=0;$counter2=0;
   while ($counter < $lang_amount)
     {
      $counter++;
      $db->next_record();
      $ability_value = 0;
      $ability_code = $db->f("code");
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      if ($ability_value > 1)
        {
         $counter2++;
         if (($counter2 % 3) == 1)
            echo "<tr><td width=18% align=right>\n";
         else
           echo "<td width=18% align=right>\n";
         echo $db->f("language")."\n";
         echo "</td><td width=90>";

         $printstars = 1;
         while ($printstars != $ability_value)
           {
            htmlp_image("13.gif", 0, 17, 16 , "*");
            $printstars++;
           }

         if (($counter2 % 3) == 0)
            echo "</td></tr>\n\n";
         else
            echo "</td>\n";
        }
     }
     
   if (($counter2 % 3) == 0)
      echo "</tr>\n\n";
   htmlp_form_hidden("lang_amount", $lang_amount);

   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();
  }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
