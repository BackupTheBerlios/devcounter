<?php

######################################################################
# Widi - Who Is Doing It?
# ================================================
#
# Copyright (c) 2001 by
#                Gregorio Robles (grex@scouts-es.org)
#
# Widi: http://widi.berlios.de
#
# This page inserts the data into the database
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,
              $th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->

<?php


  $query = "INSERT developers SET username = '$username', nationality='$nationality', actual_country='$actual_country', year_of_birth='$year_of_birth', gender='$gender', mother_tongue='$mother_tongue', other_lang_1='$other_lang_1', other_lang_2='$other_lang_2', profession='$profession', qualification='$qualification', number_of_projects='$number_of_projects'";
  $db->query($query);
//  echo "Fehler-Nr: $db->Errno \nFehlertxt: $db->Error \n";

  if ($db->affected_rows() == 0) 
  {
    $bx->box_full($t->translate("Error"),$t->translate("Database Access failed"));
  }
  
  $counter=0;
  $query = "INSERT prog_ability_values SET  username = '$username'";
  while ($counter<$ability_amount)
    {
     $counter++;
     $db2->query("SELECT colname FROM prog_abilities WHERE code='$counter'");
     $db2->next_record();
     //$query = "INSERT prog_abilities_values SET  username = '$username', code = '$counter', value = '$ability[$counter]'";
     $query = $query.", ".$db2->f("colname")."='$ability[$counter]'";
    }
  $db->query($query);

  $counter=0;
  $query = "INSERT prog_language_values SET  username = '$username'";
  while ($counter<$lang_amount)
    {
     $counter++;
     $db2->query("SELECT colname FROM prog_languages WHERE code='$counter'");
     $db2->next_record();
     //$query = "INSERT prog_languages_values SET  username = '$username', code = '$counter', value = '$plang[$counter]'";
     $query = $query.", ".$db2->f("colname")."='$plang[$counter]'";
    }
   $db->query($query);




  if ($db->affected_rows() == 0) 
    {
     $bx->box_full($t->translate("Error"),$t->translate("Database Access failed"));
    } 
  else 
    {

    if ($number_of_projects>0)
      {
       $counter=0;
       htmlp_form_action("insert.php3","","GET");
       htmlp_form_hidden("number_of_projects", $number_of_projects);
       
       //$bs->box_strip($msg);
       $bx->box_begin();
       $bx->box_title($t->translate("Please enter Project Data"));
       $bx->box_body_begin();
	  
       $bx->box_columns_begin(4);
       $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Projectname")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ProjectURL")."</b>");
       $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Comment")."</b>");
       $bx->box_next_row_of_columns();
       $bgcolor = "#FFFFFF";
       
       while ($counter!=$number_of_projects)
         {
          $counter++;
	  $bx->box_column("right","",$bgcolor,$counter);
	  $bx->box_column("center","",$bgcolor,html_input_text("projectname[]", 25, 64, ""));
	  $bx->box_column("center","",$bgcolor,html_input_text("projecturl[]", 35, 255, ""));
	  $bx->box_column("center","",$bgcolor,html_input_text("comment[]", 42, 400, ""));
	  $bx->box_next_row_of_columns();

	 }
       $bx->box_columns_end();
       $bx->box_body_end();
       $bx->box_end();
      }
    else
      {

       $bx->box_begin();
       $bx->box_title($t->translate("Thank you"));
       $bx->box_body_begin();
       echo "\n<P>";
       echo $t->translate("Give another time thanx for filling it out");
       echo "\n<BR>";
       htmlp_link("./index.php3", "", $t->translate("please proceed to the main page"));
       echo "\n<P>";
       $bx->box_body_end();
       $bx->box_end();

       echo "</td></tr>\n";
       echo "</table>\n";
       $bx->box_body_end();
       $bx->box_end();
   
       $bx->box_body_end();
       $bx->box_end();
      }
    } 

?>

<!-- end content -->

<?php
require("footer.inc");
@page_close();
?>
