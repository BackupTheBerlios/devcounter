<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Lutz Henckel (lutz.henckel@fokus.fhg.de)
#       Gregorio Robles (grex@scouts-es.org)
#       Stefan Heinze (heinze@fokus.fhg.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Administrate list of Programming Languages/Abilities
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: adm_langs_tools.php,v 1.5 2002/08/31 14:51:33 helix Exp $
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
$bs = new box("100%",$th_strip_frame_color,$th_strip_frame_width,$th_strip_title_bgcolor,$th_strip_title_font_color,$th_strip_title_align,$th_strip_body_bgcolor,$th_strip_body_font_color,$th_strip_body_align);
?>

<!-- content -->
<?php

if (($config_perm_admfaq != "all") && (!isset($perm) || !$perm->have_perm($config_perm_admfaq))) {
  $be->box_full($t->translate("Error"), $t->translate("Access denied"));
} else {
      
    switch($option) {
    case "lang_change":

    $query = "UPDATE prog_languages SET  language = '$language'  WHERE code='$code'";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("ProgLanguage updated")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;

    case "lang_add":

    $query = "SELECT DISTINCT code from prog_languages";
    $db->query($query);
    $counter=1;
    $newcode=0;
    while ($db->next_record() && $counter==$db->f("code"))
      {
        $counter++;	
      }
    $code=$counter;
    $query = "INSERT prog_languages SET  language = '$language', code='$code', colname='$colname'";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $query = "ALTER TABLE prog_language_values ADD $colname int(11)  NOT NULL DEFAULT 0";
      $db->query($query);
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("ProgLanguage added")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;

    case "lang_delete":

    $query = "DELETE FROM prog_languages WHERE code='$code'";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $query = "ALTER TABLE prog_language_values DROP COLUMN $colname";
      $db->query($query);
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("ProgLanguage removed")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;

    case "abil_change":

    $query = "UPDATE prog_abilities SET  ability = '$ability', translation='$translation'  WHERE (code='$code' AND translation='$old_trans')";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("Ability updated")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;


    case "abil_add":

    $query = "SELECT DISTINCT code from prog_abilities";
    $db->query($query);
    $counter=1;
    $newcode=0;
    while ($db->next_record() && $counter==$db->f("code"))
      {
        $counter++;	
      }
    $newcode=$counter;
    $query = "INSERT prog_abilities SET  ability = '$ability', code='$newcode', colname='$colname', translation='$translation'";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $db->query("SELECT * FROM prog_abilities WHERE colname='$colname' ORDER BY code ASC");
      if ($db->num_rows() == 1)
        {
	 $query = "ALTER TABLE prog_ability_values ADD $colname int(11)  NOT NULL DEFAULT 0";
         $db->query($query);
	}
      else
        {
         $db->next_record();
	 $code = $db->f("code");
         $query = "UPDATE prog_abilities SET  code = '$code'  WHERE (code='$newcode')";
         $db->query($query);
	 
	}
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("Abiliy added")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;

    case "abil_delete":

    $query = "DELETE FROM prog_abilities WHERE (code='$code' AND translation='$old_trans')";
    $db->query($query);
    if ($db->affected_rows() == 1 )
     {
      $db->query("SELECT * FROM prog_abilities WHERE colname='$colname'");
      if ($db->num_rows() == 0)
        {
         $query = "ALTER TABLE prog_ability_values DROP COLUMN $colname";
         $db->query($query);
	}
      $bx->box_begin();
      $bx->box_title($t->translate("Success"));
      $bx->box_body_begin();
      echo $t->translate("ProgLanguage removed")."\n";
      $bx->box_body_end();
      $bx->box_end();
     }
    break;


  }
      

      $db->query("SELECT COUNT(*) FROM prog_languages");
      $db->next_record();
      $lang_num = $db->f("COUNT(*)");
      $db->query("SELECT * from prog_languages");
      
      $bx->box_begin();
      $bx->box_title($t->translate("Programming Languages"));
      $bx->box_body_begin();
      $counter=0;
      
      $bx->box_columns_begin(5);
      $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("Code")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ProgLanguageName")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ColumnName")."</b>");
      //$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Language")."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
      while ($counter!=$lang_num)
        {
         $db->next_record();
         $counter++;
	 if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
  	 else {$bgcolor = "#E0E0E0";}
	 htmlp_form_action("adm_langs_tools.php",array(),"POST");
	 htmlp_form_hidden("code", $db->f("code") );
	 htmlp_form_hidden("option", "lang_change" );
	 $bx->box_column("right","",$bgcolor,$db->f("code"));
	 $bx->box_column("center","",$bgcolor,html_input_text("language", 30, 64, $db->f("language")));
	 $bx->box_column("center","",$bgcolor,$db->f("colname"));
	 //$bx->box_column("center","",$bgcolor,html_input_text("comment", 35, 400, $db->f("comment")));
         $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Change"),""));
	 htmlp_form_end();
	 htmlp_form_action("adm_langs_tools.php",array(),"POST");
	 htmlp_form_hidden("code", $db->f("code") );
	 htmlp_form_hidden("colname", $db->f("colname") );
	 htmlp_form_hidden("option", "lang_delete" );
	 $bgcolor = "gold";
	 $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete"),""));
	 htmlp_form_end();
	 $bx->box_next_row_of_columns();
	 $bgcolor = "#FFFFFF";
         
	}
       $bgcolor = "gold";
       htmlp_form_action("adm_langs_tools.php",array(),"POST");
       htmlp_form_hidden("option", "lang_add" );
       $bx->box_column("right","",$bgcolor,"--");
       //$bx->box_column("right","",$bgcolor,html_input_text("code", 5, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("language", 30, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("colname", 25, 64, ""));
       $bx->box_colspan(2,"center",$bgcolor,html_form_submit($t->translate("Add ProgLanguage"),""));
       $bx->box_columns_end();
       htmlp_form_end();
      
       $bx->box_body_end();
       $bx->box_end();

      $counter=0;
      
      $db->query("SELECT COUNT(*) FROM prog_abilities");
      $db->next_record();
      $abil_num = $db->f("COUNT(*)");
      $db->query("SELECT * from prog_abilities");
      
      $bx->box_begin();
      $bx->box_title($t->translate("Programming Abilities"));
      $bx->box_body_begin();
      
      
      $bx->box_columns_begin(5);
      $bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("Code")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ProgAbilityName")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("ColumnName")."</b>");
      $bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Language")."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_column("center","10%", $th_strip_title_bgcolor,"<b>"."&nbsp;"."</b>");
      $bx->box_next_row_of_columns();
      $bgcolor = "#FFFFFF";
      while ($counter!=$abil_num)
        {
         $db->next_record();
         $counter++;
	 if ($counter%2 != 0) {$bgcolor = "#FFFFFF";}
  	 else {$bgcolor = "#E0E0E0";}
	 htmlp_form_action("adm_langs_tools.php",array(),"POST");
	 htmlp_form_hidden("code", $db->f("code") );
	 htmlp_form_hidden("old_trans", $db->f("translation") );
	 htmlp_form_hidden("option", "abil_change" );
	 $bx->box_column("right","",$bgcolor,$db->f("code"));
	 $bx->box_column("center","",$bgcolor,html_input_text("ability", 30, 64, $db->f("ability")));
	 $bx->box_column("center","",$bgcolor, $db->f("colname"));
	 $bx->box_column("center","",$bgcolor,html_input_text("translation", 15, 64, $db->f("translation")));
         $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Change"),""));
	 htmlp_form_end();
	 htmlp_form_action("adm_langs_tools.php",array(),"POST");
	 htmlp_form_hidden("code", $db->f("code") );
	 htmlp_form_hidden("old_trans", $db->f("translation") );
	 htmlp_form_hidden("colname", $db->f("colname") );
	 htmlp_form_hidden("option", "abil_delete" );
	 $bgcolor = "gold";
	 $bx->box_column("center","",$bgcolor,html_form_submit($t->translate("Delete"),""));
	 htmlp_form_end();
	 $bx->box_next_row_of_columns();
	 $bgcolor = "#FFFFFF";
         
	}
       $bgcolor = "gold";
       htmlp_form_action("adm_langs_tools.php",array(),"POST");
       htmlp_form_hidden("option", "abil_add" );
       //$bx->box_column("right","",$bgcolor,html_input_text("code", 5, 64, ""));
       $bx->box_column("right","",$bgcolor,"--");
       $bx->box_column("center","",$bgcolor,html_input_text("ability", 30, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("colname", 25, 64, ""));
       $bx->box_column("center","",$bgcolor,html_input_text("translation", 15, 64, ""));
       $bx->box_colspan(2,"center",$bgcolor,html_form_submit($t->translate("Add Ability"),""));
       $bx->box_columns_end();
       htmlp_form_end();
      
       $bx->box_body_end();
       $bx->box_end();

}


?>
<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
