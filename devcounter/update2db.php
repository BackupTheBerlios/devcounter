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
# Updates developers profile data in database
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: update2db.php,v 1.5 2002/08/27 11:16:59 helix Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
  $query = "UPDATE developers SET nationality='$nationality', actual_country='$actual_country', year_of_birth='$year_of_birth', gender='$gender', mother_tongue='$mother_tongue', other_lang_1='$other_lang_1', other_lang_2='$other_lang_2', profession='$profession', qualification='$qualification' WHERE username='$username'";
  $db->query($query);
//  echo "Fehler-Nr: $db->Errno \nFehlertxt: $db->Error \n";

/*  if ($db->affected_rows() == 0) 
  {
    $be->box_full($t->translate("Error"),$t->translate("Database Access failed"));
  }
*/
  
  $counter=0;
  $query = "UPDATE prog_ability_values SET username = '$username'";
  while ($counter<$ability_amount)
    {
     $counter++;
     $db2->query("SELECT colname FROM prog_abilities WHERE code='$counter'");
     $db2->next_record();
     //$query = "UPDATE prog_abilities_values SET  value = '$ability[$counter]' WHERE (username = '$username' AND code = '$counter')";
     $query = $query.", ".$db2->f("colname")."='$ability[$counter]'";
    }
  $query = $query."WHERE (username = '$username')";
  $db->query($query);

  $counter=0;
  $query = "UPDATE prog_language_values SET username = '$username'";
  while ($counter<$lang_amount)
    {
     $counter++;
     $db2->query("SELECT colname FROM prog_languages WHERE code='$counter'");
     $db2->next_record();
     //$query = "UPDATE prog_languages_values SET  value = '$plang[$counter]' WHERE (username = '$username' AND code = '$counter')";
     $query = $query.", ".$db2->f("colname")."='$plang[$counter]'";
    }
  $query = $query."WHERE (username = '$username')";
  $db->query($query);

 $bx->box_begin();
 $bx->box_title($t->translate("Done"));
 $bx->box_body_begin();
 echo "\n<P>";
 echo $t->translate("Your Profile has been succesfully changed");
 echo "\n<BR>";
 htmlp_link("./index.php", "", $t->translate("Please proceed with the main page"));
 echo "\n<P>";
 $bx->box_body_end();
 $bx->box_end();
?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
