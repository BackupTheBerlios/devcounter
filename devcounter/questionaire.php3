<?php
######################################################################
# DevCounter
# ================================================
#
# Copyright (c) 2001 by
#                Gregorio Robles (grex@scouts-es.org),
#		 Susanne Gruenbaum (gruenbaum@fokus.gmd.de) and
#                Lutz Henckel (lutz.henckel@fokus.gmd.de)
#
# BerliOS DevCounter: http://sourceagency.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# This file contains the verification procedure when registering
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################


page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) 
{
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("header.inc");

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
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
   htmlp_form_action("insert.php3","POST");
   echo "\n";
/*
   $db->query("SELECT * from auth_user WHERE user_id='$user__id'");
   $db->next_record();

   $username=$db->f("username");
*/
   $username=$auth->auth["uname"];

   htmlp_form_hidden("username", $username);
   echo "<tr><td align=right width=30%>".$t->translate("Username")."</td><td width=70%> $username\n";
  

   echo "<tr><td align=right width=30%>".$t->translate("Nationality").":</td><td width=70%>\n";
   htmlp_select("nationality"); echo "\n";
   select_country("no entry");
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Country you actually live in").":</td><td width=70%>\n";
   htmlp_select("actual_country"); echo "\n";
   select_country("no entry");
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Year of Birth").":</td><td width=70%>19<input type=\"TEXT\" name=\"year_of_birth\" size=3 maxlength=2></td></tr>\n";


   echo "<tr><td align=right width=30%>".$t->translate("Gender").":</td><td width=70%>\n";
   echo "<center><table width=80% border=0>\n";
   echo "<tr><td width=26%>";
   htmlp_radio("gender","no entry",0); echo "&nbsp; ".$t->translate("no entry")."\n";
   echo "</td>\n<td width=26%>";
   htmlp_radio("gender","Male",0); echo "&nbsp; ".$t->translate("Male")."\n";
   echo "</td>\n<td width=26%>";
   htmlp_radio("gender","Female",0); echo "&nbsp; ".$t->translate("Female")."\n";
   echo "</td></tr></table></center>\n";
   echo "</td></tr>\n";
   echo "<tr><td align=right width=30%>".$t->translate("Mother tongue").":</td><td width=70%>\n";
   htmlp_select("mother_tongue"); echo "\n";
   select_lang("no entry");
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right valign=top width=30%><BR>".$t->translate("Other languages").":</td><td width=70%>\n";
   echo "<table width=90% border=0>\n";
   echo "<tr>";
   echo "<td width=25% valign=top>2. ";
   htmlp_select("other_lang_1"); echo "\n";
   select_lang("no entry");
   htmlp_select_end(); echo "</td>\n";
   echo "<td width=25% valign=top>3. ";
   htmlp_select("other_lang_2"); echo "\n";
   select_lang("no entry");
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

   echo "<tr><td align=right width=30%>".$t->translate("Profession").":</td><td width=70%>\n";
   htmlp_select("profession"); echo "\n";
   htmlp_select_option("no entry",1,$t->translate("no entry")); echo "\n";
   htmlp_select_option("Student (IT)",0,$t->translate("Student (IT)")); echo "\n";
   htmlp_select_option("Student (other)",0,$t->translate("Student (other)")); echo "\n";
   htmlp_select_option("Programmer",0,$t->translate("Programmer")); echo "\n";
   htmlp_select_option("Software Engineer",0,$t->translate("Software Engineer")); echo "\n";
   htmlp_select_option("Other type of Engineering",0,$t->translate("Other type of Engineering")); echo "\n";
   htmlp_select_option("University professor/assistant (IT)",0,$t->translate("University professor/assistant (IT)")); echo "\n";
   htmlp_select_option("University professor/assistant (other)",0,$t->translate("University professor/assistant (other)")); echo "\n";
   htmlp_select_option("Executive (IT)",0,$t->translate("Executive (IT)")); echo "\n";
   htmlp_select_option("Executive (other)",0,$t->translate("Executive (other)")); echo "\n";
   htmlp_select_option("Consultant (IT)",0,$t->translate("Consultant (IT)")); echo "\n";
   htmlp_select_option("Consultant (other)",0,$t->translate("Consultant (other)")); echo "\n";
   htmlp_select_option("Nothing to do with the software industry",0,$t->translate("Nothing to do with the software industry")); echo "\n";
   htmlp_select_end(); echo "</td></tr>\n";

   echo "<tr><td align=right width=30%>".$t->translate("Qualification").":</td><td width=70%>\n";
   htmlp_select("qualification"); echo "\n";
   htmlp_select_option("no entry",1,$t->translate("no entry")); echo "\n";
   htmlp_select_option("Elementary School",0,$t->translate("Elementary School")); echo "\n";
   htmlp_select_option("High School",0,$t->translate("High School")); echo "\n";
   htmlp_select_option("A-Level",0,$t->translate("A-Level")); echo "\n";
   htmlp_select_option("Apprenticeship",0,$t->translate("Apprenticeship")); echo "\n";
   htmlp_select_option("College Graduate",0,$t->translate("College Graduate")); echo "\n";
   htmlp_select_option("University Graduate",0,$t->translate("University Graduate")); echo "\n";
   htmlp_select_option("Master",0,$t->translate("Master")); echo "\n";
   htmlp_select_option("PhD",0,$t->translate("PhD")); echo "\n";
   htmlp_select_end(); echo "</td></tr>\n";

   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();


   $bx->box_begin();
   $bx->box_title($t->translate("Computer experience"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=left>".$t->translate("Number of Free Software/Open Source Projects you are involved in").": <input type=\"TEXT\" name=\"number_of_projects\" size=3 maxlength=2>\n";
   echo "<BR>".$t->translate("Which Free Software/Open Source Projects you are involved in").": <input type=\"TEXT\" name=\"name_of_projects\" size=30 maxlength=200></td></tr>\n";
  

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><B><FONT SIZE=+1>".$t->translate("Which of these programming expirience do you have?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table width=90% border=0>\n";

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");
   $ability_amount=$db->num_rows();
   $counter=0;
   while ($counter<$ability_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 3)==1)
        {
         echo "<tr><td width=33%>\n"; 
        }
      else
        {
         echo "<td width=33%>\n";
        }
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("ability")."\n";
      echo "</td><td width=20%>";
      htmlp_select("ability[".$db->f("code")."]"); 
      htmlp_select_option("0",1,$t->translate("no experiences"));
      htmlp_select_option("1",0,$t->translate("very little experience"));
      htmlp_select_option("2",0,$t->translate("some experience")); 
      htmlp_select_option("3",0,$t->translate("Done this some times"));
      htmlp_select_option("4",0,$t->translate("No problem"));
      htmlp_select_option("5",0,$t->translate("Is my second nature"));
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
        {
         echo "</td></tr>\n\n"; 
        }
      else
        {
         echo "</td>\n";
        }
     }
     
   if (($counter % 3)==0)
     {
      echo "</tr>\n\n"; 
     }
   htmlp_form_hidden("ability_amount", $ability_amount);
  
   echo "</table></center>\n";


   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><FONT SIZE=+1>".$t->translate("Which of these languages/tools are you experienced with?")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";

   $db->query("SELECT * from prog_languages");
   $lang_amount=$db->num_rows();
   $counter=0;
   while ($counter<$lang_amount)
     {
      $counter++;
      $db->next_record();
      if (($counter % 3)==1)
        {
         echo "<tr><td width=33%>\n"; 
        }
      else
        {
        echo "<td width=33%>\n";
        }
      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("language")."\n";
      echo "</td><td width=20%>";
      htmlp_select("lang[".$db->f("code")."]"); 
      htmlp_select_option("0",1,$t->translate("no experiences"));
      htmlp_select_option("1",0,$t->translate("very little experience"));
      htmlp_select_option("2",0,$t->translate("some experience")); 
      htmlp_select_option("3",0,$t->translate("Done this some times"));
      htmlp_select_option("4",0,$t->translate("No problem"));
      htmlp_select_option("5",0,$t->translate("Is my second nature"));
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
        {
         echo "</td></tr>\n\n"; 
        }
      else
        {
         echo "</td>\n";
        }
     }
     
   if (($counter % 3)==0)
     {
      echo "</tr>\n\n"; 
     }
   htmlp_form_hidden("lang_amount", $lang_amount);

  
/*  
  echo "<tr><td align=right width=30%>".$t->translate("Username")."</td><td width=70%> $username\n";

 
 */

   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();


   echo"<CENTER><TABLE BORDER=0 width=89%><TR><TD width=65%>\n";
   $bx->box_begin();
   $bx->box_title($t->translate("Submit"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=0>\n";
   echo "<tr><td align=right width=15%>&nbsp;</td><td width=85%>\n";
   htmlp_form_submit($t->translate("Submit Your Form"),"");

   echo "</td>\n";
   echo "<td>";
//  echo "<img src=\"images/blank.gif\" width=\"118\" height=\"52\" border=\"0\"></td></tr>";
   echo "\n";
   htmlp_form_end();
   echo "</td></tr>\n";
   echo "</table>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();
   echo"</TD><TD width=5%>&nbsp;\n";
   echo"</TD><TD width=30%>\n";
  }

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
