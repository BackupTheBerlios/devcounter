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


$bx->box_begin();
$bx->box_title($t->translate("$sys_name Search"));
$bx->box_body_begin();

echo "<table border=0 width=100% cellspacing=5>\n";
echo "<tr><td><center><a href=\"".$sess->url("searchdev.php3?option=abilities")."\">".$t->translate("Programming &amp; Computer Abilities")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("searchdev.php3?option=lang")."\">".$t->translate("Spoken Languages")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("searchdev.php3?option=country")."\">".$t->translate("Country")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("searchdev.php3?option=projects")."\">".$t->translate("Projects")."</a></center></td></tr>\n";
echo "</table>\n";

$bx->box_body_end();
$bx->box_end();


  switch($option) {

// Abilities
    case "abilities":

   htmlp_form_action("devresults.php3","POST");
   $bx->box_begin();
   $bx->box_title($t->translate("Computer experience"));
   $bx->box_body_begin();
 
/*
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=left>".$t->translate("Number of Free Software/Open Source Projects you are involved in").": <input type=\"TEXT\" name=\"number_of_projects\" size=3 maxlength=2>\n";
   echo "<BR>".$t->translate("Which Free Software/Open Source Projects you are involved in").": <input type=\"TEXT\" name=\"name_of_projects\" size=30 maxlength=200></td></tr>\n";
  

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
*/
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
      htmlp_select_option("0",1,$t->translate("No Experience"));
      htmlp_select_option("1",0,$t->translate("Novice"));
      htmlp_select_option("2",0,$t->translate("Beginner")); 
      htmlp_select_option("3",0,$t->translate("Advanced"));
      htmlp_select_option("4",0,$t->translate("Expert"));
      htmlp_select_option("5",0,$t->translate("Guru"));
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
      htmlp_select_option("0",1,$t->translate("No Experience"));
      htmlp_select_option("1",0,$t->translate("Novice"));
      htmlp_select_option("2",0,$t->translate("Beginner")); 
      htmlp_select_option("3",0,$t->translate("Advanced"));
      htmlp_select_option("4",0,$t->translate("Expert"));
      htmlp_select_option("5",0,$t->translate("Guru"));
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
   htmlp_form_hidden("option", $option);
   htmlp_form_end();
   echo "</td></tr>\n";
   echo "</table>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();


      break;

    case "projects":

      $bx->box_begin();
      $bx->box_title($t->translate("Under Construction"));
      $bx->box_body_begin();
      echo $t->translate("Not yet implemented")."\n";
      $bx->box_body_end();
      $bx->box_end();

      break;

    case "lang":

      $bx->box_begin();
      $bx->box_title($t->translate("Under Construction"));
      $bx->box_body_begin();
      echo $t->translate("Not yet implemented")."\n";
      $bx->box_body_end();
      $bx->box_end();

      break;

    case "country":

      $bx->box_begin();
      $bx->box_title($t->translate("Under Construction"));
      $bx->box_body_begin();
      echo $t->translate("Not yet implemented")."\n";
      $bx->box_body_end();
      $bx->box_end();

      break;

   }
   

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
