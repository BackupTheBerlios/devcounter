<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Stefan Heinze (heinze@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Search for developers
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: searchdev.php,v 1.5 2002/08/27 14:11:10 helix Exp $
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

$bx = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
$bx->box_begin();
$bx->box_title($t->translate("$sys_name Search by Category"));
$bx->box_body_begin();

echo "<table border=0 width=100% cellspacing=5>\n";
echo "<tr><td><center><a href=\"".$sess->url("searchdev.php?option=abilities")."\">".$t->translate("Programming &amp; Computer Abilities")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("searchdev.php?option=projects")."\">".$t->translate("Projects")."</a></center></td></tr>\n";
echo "<tr><td><center><a href=\"".$sess->url("searchdev.php?option=country")."\">".$t->translate("Countries")."</a></center></td>\n";
echo "<td><center><a href=\"".$sess->url("searchdev.php?option=lang")."\">".$t->translate("Spoken Languages")."</a></center></td></tr>\n";
echo "<tr><td colspan=2><center><a href=\"".$sess->url("searchdev.php?option=allinone")."\">".$t->translate("All in one")."</a></center></td></tr>\n";
echo "</table>\n";

$bx->box_body_end();
$bx->box_end();

  switch($option) {

// Abilities
    case "allinone":

      $bx->box_begin();
      $bx->box_title($t->translate("Search for All in one"));
      $bx->box_body_begin();
      htmlp_form_action("devresults.php",NULL,"POST");
      echo $t->translate("Enter Name of <B>one</B> Project")."\n";
      htmlp_input_text("projname", "30", "30", "");
      htmlp_form_hidden("option", $option);
      $bx->box_body_end();
      $bx->box_body_begin();

      echo $t->translate("Please select desired Language")."\n";

      htmlp_select("dev_lang"); echo "\n";
      select_lang(999);
      htmlp_select_end();
      
      $bx->box_body_end();
      $bx->box_body_begin();
      
      echo $t->translate("Please select desired Country")."\n";

      htmlp_select("dev_country"); echo "\n";
      select_country(999);
      htmlp_select_end();
     
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
         echo "<tr><td width=33%>\n";
      else
         echo "<td width=33%>\n";

      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("ability")."\n";
      echo "</td><td width=20%>";
      htmlp_select("ability[".$db->f("code")."]"); 
      $db2->query("SELECT * FROM weightings");
      while ($db2->next_record()) {
         $selected = 0;
         if ($db2->f("weightid") == 0) $selected = 1;
         htmlp_select_option($db2->f("weightid"),$selected,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 3)==0)
      echo "</tr>\n\n";

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
         echo "<tr><td width=33%>\n";
      else
        echo "<td width=33%>\n";

      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("language")."\n";
      echo "</td><td width=20%>";
      htmlp_select("plang[".$db->f("code")."]"); 
      $db2->seek(0);
      while ($db2->next_record()) {
         $selected = 0;
         if ($db2->f("weightid") == 0) $selected = 1;
         htmlp_select_option($db2->f("weightid"),$selected,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 3)==0)
      echo "</tr>\n\n";

   htmlp_form_hidden("lang_amount", $lang_amount);

   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
      
   $bx->box_body_end();
   $bx->box_end();
      
   echo"<CENTER><TABLE BORDER=0 width=89%><TR><TD>\n";

   echo "<CENTER>";
   htmlp_form_submit($t->translate("Submit"),"");
   echo "</CENTER>";

   htmlp_form_hidden("option", $option);
   htmlp_form_end();
   echo "</td></tr>\n";
   echo "</table>\n";
    break;

    case "abilities":

   htmlp_form_action("devresults.php",array(),"POST");
   //htmlp_form_hidden("lang", $lang);
   $bx->box_begin();
   $bx->box_title($t->translate("Computer experience"));
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
         echo "<tr><td width=33%>\n";
      else
         echo "<td width=33%>\n";

      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("ability")."\n";
      echo "</td><td width=20%>";
      htmlp_select("ability[".$db->f("code")."]"); 
      $db2->query("SELECT * FROM weightings");
      while ($db2->next_record()) {
         htmlp_select_option($db2->f("weightid"),0,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 3)==0)
      echo "</tr>\n\n";

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
         echo "<tr><td width=33%>\n";
      else
        echo "<td width=33%>\n";

      echo "<table border=0 width=100% cellpadding=3><tr><td align=right>";
      echo $db->f("language")."\n";
      echo "</td><td width=20%>";
      htmlp_select("plang[".$db->f("code")."]"); 
      $db2->seek(0);
      while ($db2->next_record()) {
         htmlp_select_option($db2->f("weightid"),0,$t->translate($db2->f("weighting")));
      }
      htmlp_select_end();
      echo"</td></tr></table>";
     
      if (($counter % 3)==0)
         echo "</td></tr>\n\n";
      else
         echo "</td>\n";
     }
     
   if (($counter % 3)==0)
      echo "</tr>\n\n";

   htmlp_form_hidden("lang_amount", $lang_amount);

   echo "</table></center>\n";
   echo "</td></tr>\n";
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();

   echo"<CENTER><TABLE BORDER=0 width=89%><TR><TD>\n";

   echo "<CENTER>";
   htmlp_form_submit($t->translate("Submit"),"");
   echo "</CENTER>";

   htmlp_form_hidden("option", $option);
   htmlp_form_end();
   echo "</td></tr>\n";
   echo "</table>\n";
      break;

    case "projects":

      $bx->box_begin();
      $bx->box_title($t->translate("Search for Projects"));
      $bx->box_body_begin();
      htmlp_form_action("devresults.php",NULL,"POST");
      echo $t->translate("Enter Name of <B>one</B> Project")."\n";
      htmlp_input_text("projname", "30", "30", "");
      htmlp_form_hidden("option", $option);
      htmlp_form_submit($t->translate("Submit"),"");
      $bx->box_body_end();
      $bx->box_end();
      
      htmlp_form_end();

      break;

    case "lang":

      $bx->box_begin();
      $bx->box_title($t->translate("Search for Languages spoken"));
      $bx->box_body_begin();
      htmlp_form_action("devresults.php",NULL,"POST");
      echo $t->translate("Please select desired Language")."\n";

      htmlp_select("dev_lang"); echo "\n";
      select_lang(999);
      htmlp_select_end();

      htmlp_form_hidden("option", $option);
      htmlp_form_submit($t->translate("Submit"),"");
      $bx->box_body_end();
      $bx->box_end();

      break;

    case "country":

      $bx->box_begin();
      $bx->box_title($t->translate("Search for Countries"));
      $bx->box_body_begin();

      htmlp_form_action("devresults.php",NULL,"POST");
      echo $t->translate("Please select desired Country")."\n";

      htmlp_select("dev_country"); echo "\n";
      select_country(999);
      htmlp_select_end();

      htmlp_form_hidden("option", $option);
      htmlp_form_submit($t->translate("Submit"),"");

      $bx->box_body_end();
      $bx->box_end();
      break;
   }
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
