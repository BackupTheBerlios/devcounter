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
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php




  switch($option) {

// Abilities
    case "abilities":




$request_amount = 0;
$hit_amount =0;

$query = "SELECT * from prog_language_values, prog_ability_values, extra_perms WHERE prog_language_values.username=prog_ability_values.username AND extra_perms.username=prog_ability_values.username AND extra_perms.search='yes' ";
for ($i=0;$i<$lang_amount;$i++)
  {
   if ($plang[$i] != 0)
     {
      $db2->query("SELECT colname FROM prog_languages WHERE code='$i'");
      $db2->next_record();//echo "-".$i."-";
      $query = $query." AND prog_language_values.".$db2->f("colname").">='$plang[$i]'";
     }
   
  }
for ($i=0;$i<$ability_amount;$i++)
  {
   if ($ability[$i] != 0)
     {
      $db2->query("SELECT colname FROM prog_abilities WHERE code='$i'");
      $db2->next_record();//echo "-".$i."-";
      $query = $query." AND prog_ability_values.".$db2->f("colname").">='$plang[$i]'";
     }
  }
$query=$query." ORDER BY extra_perms.username ASC";
$db->query($query);


$bx->box_begin();
$bx->box_title($t->translate("Search Results"));
$bx->box_body_begin();


     if ($db->num_rows() == 0)
       {
        echo $t->translate("No Results")."\n";
       }
     else
       {
        while ($db->next_record())
	  {
	   $pquery["devname"] = $db->f("username") ;
	   htmlp_link("showprofile.php3",$pquery,$db->f("username"));
	   echo "<BR>\n";
	   //echo $db->f("username")."<BR>\n";
	  }
       }



$bx->box_body_end();
$bx->box_end();



     break;

    case "projects":

/*
      $bx->box_begin();
      $bx->box_title($t->translate("Under Construction"));
      $bx->box_body_begin();
      echo $t->translate("Not yet implemented")."\n";
      $bx->box_body_end();
      $bx->box_end();
*/
      $db->query("SELECT developers.username FROM developers, extra_perms WHERE developers.username=extra_perms.username AND extra_perms.search='yes' AND developers.name_of_projects LIKE '%$projname%' ORDER BY developers.username ASC");
      $bx->box_begin();
      $bx->box_title($t->translate("Results"));
      $bx->box_body_begin();
      
     if ($db->num_rows() == 0)
       {
        echo $t->translate("No Results")."\n";
       }
     else
       {
        while ($db->next_record())
	  {
	   $pquery["devname"] = $db->f("username") ;
	   htmlp_link("showprofile.php3",$pquery,$db->f("username"));
	   echo "<BR>\n";
	   //echo $db->f("username")."<BR>\n";
	  }
       }
        $bx->box_body_end();
        $bx->box_end();
      break;

    case "lang":


      $db->query("SELECT developers.username FROM developers, extra_perms WHERE developers.username=extra_perms.username AND extra_perms.search='yes' AND (developers.mother_tongue='$dev_lang' OR developers.other_lang_1='$dev_lang' OR developers.other_lang_2='$dev_lang') ORDER BY developers.username ASC");
      $bx->box_begin();
      $bx->box_title($t->translate("Results"));
      $bx->box_body_begin();
      
//      mother_tongue   other_lang_1   other_lang_2
      
      
     if ($db->num_rows() == 0)
       {
        echo $t->translate("No Results")."\n";
       }
     else
       {
        while ($db->next_record())
	  {
	   $pquery["devname"] = $db->f("username") ;
	   htmlp_link("showprofile.php3",$pquery,$db->f("username"));
	   echo "<BR>\n";
	   //echo $db->f("username")."<BR>\n";
	  }
       }
      $bx->box_body_end();
      $bx->box_end();

      break;

    case "country":

      $db->query("SELECT developers.username FROM developers, extra_perms  WHERE developers.username=extra_perms.username AND extra_perms.search='yes' AND (developers.nationality='$dev_country' OR developers.actual_country='$dev_country') ORDER BY developers.username ASC");
      $bx->box_begin();
      $bx->box_title($t->translate("Results"));
      $bx->box_body_begin();

     if ($db->num_rows() == 0)
       {
        echo $t->translate("No Results")."\n";
       }
     else
       {
        while ($db->next_record())
	  {
	   $pquery["devname"] = $db->f("username") ;
	   htmlp_link("showprofile.php3",$pquery,$db->f("username"));
	   echo "<BR>\n";
	   //echo $db->f("username")."<BR>\n";
	  }
       }

      $bx->box_body_end();
      $bx->box_end();

      break;

    case "name":


      $db->query("SELECT developers.username FROM developers, extra_perms WHERE developers.username LIKE '%$search_text%' AND developers.username=extra_perms.username AND extra_perms.search='yes' ORDER BY developers.username ASC");
      $bx->box_begin();
      $bx->box_title($t->translate("Results"));
      $bx->box_body_begin();
      
      
      
     if ($db->num_rows() == 0)
       {
        echo $t->translate("No Results")."\n";
       }
     else
       {
        while ($db->next_record())
	  {
	   $pquery["devname"] = $db->f("username") ;
	   htmlp_link("showprofile.php3",$pquery,$db->f("username"));
	   echo " <BR>\n";
	   //echo $db->f("username")."<BR>\n";
	  }
       }
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
