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
# Statistics of the System
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: stats.php,v 1.3 2002/08/26 19:46:59 helix Exp $
#
######################################################################

page_open(array("sess" => "DevCounter_Session"));
if (isset($auth) && !empty($auth->auth["perm"])) {
  page_close();
  page_open(array("sess" => "DevCounter_Session",
                  "auth" => "DevCounter_Auth",
                  "perm" => "DevCounter_Perm"));
}

require("header.inc");
require("statslib.inc");

$bx = new box("95%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("80%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
?>

<!-- content -->
<?php
$bar_lenght = 250;
// $iter is a variable for printing the Top Statistics in steps of 10 apps
if (!isset($iter)) $iter=0;
$iter*=10;



if (isset($option)) {

  $db->query("SELECT COUNT(*) FROM developers");
  $db->next_record();
  $total_number_devs = $db->f("COUNT(*)");
//  $numiter = ($db->f("COUNT(*)")/10);


  switch($option) {

// General stats
    case "general":

      $bx->box_begin();
      $bx->box_title($t->translate("General $sys_name Statistics"));
      $bx->box_body_begin();
      echo "<TABLE CELLSPACING=2 CELLPADDING=2><TR>";
      
      echo "<TD>";
      echo $t->translate("Total number of developers")." : ";
      echo "</TD><TD>";
      echo $total_number_devs."\n";
      echo "</TD>";
      
      echo "</TR><TR>";
      
      echo "<TD>";
      $db->query("SELECT COUNT(*) FROM developers where gender='Male'");
      $db->next_record();
      $male = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where gender='Female'");
      $db->next_record();
      $female = $db->f("COUNT(*)");
      $other = $total_number_devs - $male - $female;
      echo $t->translate("Gender")." : ";
      echo "</TD><TD>";
      echo "<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD>";
      htmlp_image("bar_bl_l.gif", 0, 7, 11, "-");
      echo "</TD><TD>";
      htmlp_image("bar_bl_m.gif", 0, $male/$total_number_devs*$bar_lenght, 11, $t->translate("Male")." ".sprintf( "%01.2f",($male/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_rd_m.gif", 0, $female/$total_number_devs*$bar_lenght, 11, $t->translate("Female"." ".sprintf( "%01.2f",($female/$total_number_devs)*100) ."%"));
      echo "</TD><TD>";
      htmlp_image("bar_bk_m.gif", 0, $other/$total_number_devs*$bar_lenght, 11, $t->translate("No Entry"." ".sprintf( "%01.2f",($other/$total_number_devs)*100) ."%"));
      echo "</TD><TD>";
      htmlp_image("bar_bk_r.gif", 0, 7, 11, "-");
      echo "</TD></TR></TABLE>";
      echo "</TD><TD>";
      htmlp_image("bar_bl_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Male")."&nbsp;&nbsp; ";
      htmlp_image("bar_rd_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Female")."&nbsp;&nbsp; ";
      htmlp_image("bar_bk_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("No Entry")."&nbsp;&nbsp; ";
      
      //echo "<FONT COLOR=\"blue\">Male</FONT> <FONT COLOR=\"red\">Female</FONT> <FONT COLOR=\"black\">No Entry</FONT>";
      echo "</TD>";
      
      echo "</TR><TR>";
      
      echo "<TD>";
      $db->query("SELECT COUNT(*) FROM developers where qualification='Elementary School'");
      $db->next_record();
      $e_school = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='High School'");
      $db->next_record();
      $h_school = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='A-Level'");
      $db->next_record();
      $a_level = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='Apprenticeship'");
      $db->next_record();
      $appren = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='College Graduate'");
      $db->next_record();
      $college = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='University Graduate'");
      $db->next_record();
      $unive = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='Master'");
      $db->next_record();
      $master = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where qualification='PhD'");
      $db->next_record();
      $phd = $db->f("COUNT(*)");
      $other = $total_number_devs - $e_school - $h_school - $a_level - $appren - $college - $unive - $master - $phd;

      echo $t->translate("Qualification")." : ";
      echo "</TD><TD>";
      echo "<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD>";
      htmlp_image("bar_bl_l.gif", 0, 7, 11, "-");
      echo "</TD><TD>";
      htmlp_image("bar_bl_m.gif", 0, $e_school/$total_number_devs*$bar_lenght, 11, $t->translate("Elementary School")." ".sprintf( "%01.2f",($e_school/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_rd_m.gif", 0, $h_school/$total_number_devs*$bar_lenght, 11, $t->translate("High School")." ".sprintf( "%01.2f",($h_school/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_cy_m.gif", 0, $a_level/$total_number_devs*$bar_lenght, 11, $t->translate("A-Level")." ".sprintf( "%01.2f",($a_level/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_gr_m.gif", 0, $appren/$total_number_devs*$bar_lenght, 11, $t->translate("Apprenticeship")." ".sprintf( "%01.2f",($appren/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_or_m.gif", 0, $college/$total_number_devs*$bar_lenght, 11, $t->translate("College Graduate")." ".sprintf( "%01.2f",($college/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_pr_m.gif", 0, $unive/$total_number_devs*$bar_lenght, 11, $t->translate("University Graduate")." ".sprintf( "%01.2f",($unive/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_wh_m.gif", 0, $master/$total_number_devs*$bar_lenght, 11, $t->translate("Master")." ".sprintf( "%01.2f",($master/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_yl_m.gif", 0, $phd/$total_number_devs*$bar_lenght, 11, $t->translate("PhD")." ".sprintf( "%01.2f",($phd/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_m.gif", 0, $other/$total_number_devs*$bar_lenght, 11, $t->translate("No Entry")." ".sprintf( "%01.2f",($other/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_r.gif", 0, 7, 11, "-");
      echo "</TD></TR></TABLE>";
      echo "</TD><TD>";

      htmlp_image("bar_bl_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Elementary School")."&nbsp;&nbsp; ";
      htmlp_image("bar_rd_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("High School")."&nbsp;&nbsp; ";
      htmlp_image("bar_cy_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("A-Level")."&nbsp;&nbsp; ";
      htmlp_image("bar_gr_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Apprenticeship")."&nbsp;&nbsp; ";
      htmlp_image("bar_or_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("College Graduate")."&nbsp;&nbsp; ";
      htmlp_image("bar_pr_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("University Graduate")."&nbsp;&nbsp; ";
      htmlp_image("bar_wh_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Master")."&nbsp;&nbsp; ";
      htmlp_image("bar_yl_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("PhD")."&nbsp;&nbsp; ";
      htmlp_image("bar_bk_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("No Entry")."&nbsp;&nbsp; ";
      
      
      echo "</TD>";
      
      echo "</TR><TR>";
      
      echo "<TD>";
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE 'Student%'");
      $db->next_record();
      $student = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession='Programmer'");
      $db->next_record();
      $programmer = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE '%Engineer%'");
      $db->next_record();
      $engineer = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE '%professor%'");
      $db->next_record();
      $prof = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE 'Executive%'");
      $db->next_record();
      $executive = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE 'Consultant%'");
      $db->next_record();
      $consultant = $db->f("COUNT(*)");
      $other = $total_number_devs - $student - $programmer - $engineer - $prof - $executive - $consultant;

      echo $t->translate("Profession")." : ";
      echo "</TD><TD>";
      echo "<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD>";
      htmlp_image("bar_bl_l.gif", 0, 7, 11, "-");
      echo "</TD><TD>";
      htmlp_image("bar_bl_m.gif", 0, $student/$total_number_devs*$bar_lenght, 11, $t->translate("Student")." ".sprintf( "%01.2f",($student/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_rd_m.gif", 0, $programmer/$total_number_devs*$bar_lenght, 11, $t->translate("Programmer")." ".sprintf( "%01.2f",($programmer/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_cy_m.gif", 0, $engineer/$total_number_devs*$bar_lenght, 11, $t->translate("Engineer")." ".sprintf( "%01.2f",($engineer/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_gr_m.gif", 0, $prof/$total_number_devs*$bar_lenght, 11, $t->translate("University professor/assistant")." ".sprintf( "%01.2f",($prof/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_or_m.gif", 0, $executive/$total_number_devs*$bar_lenght, 11, $t->translate("Executive")." ".sprintf( "%01.2f",($executive/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_pr_m.gif", 0, $consultant/$total_number_devs*$bar_lenght, 11, $t->translate("Consultant")." ".sprintf( "%01.2f",($consultant/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_m.gif", 0, $other/$total_number_devs*$bar_lenght, 11, $t->translate("No Entry")." ".sprintf( "%01.2f",($other/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_r.gif", 0, 7, 11, "-");
      echo "</TD></TR></TABLE>";
      echo "</TD><TD>";

      htmlp_image("bar_bl_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Student")."&nbsp;&nbsp; ";
      htmlp_image("bar_rd_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Programmer")."&nbsp;&nbsp; ";
      htmlp_image("bar_cy_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Engineer")."&nbsp;&nbsp; ";
      htmlp_image("bar_gr_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("University professor/assistant")."&nbsp;&nbsp; ";
      htmlp_image("bar_or_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Executive")."&nbsp;&nbsp; ";
      htmlp_image("bar_pr_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Consultant")."&nbsp;&nbsp; ";
      htmlp_image("bar_bk_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("No Entry")."&nbsp;&nbsp; ";
      
      
      echo "</TD>";
      
      echo "</TR><TR>";
      
      echo "<TD>";
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE '%(IT)%'");
      $db->next_record();
      $it_yes = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession LIKE '%(other)%'");
      $db->next_record();
      $it_no = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession='Software Engineer'");
      $db->next_record();
      $s_engineer = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession='Other type of Engineering'");
      $db->next_record();
      $o_engineer = $db->f("COUNT(*)");
      $db->query("SELECT COUNT(*) FROM developers where profession='Nothing to do with the software industry'");
      $db->next_record();
      $ntd_it = $db->f("COUNT(*)");
      
      $it_yes = $it_yes + $programmer + $s_engineer;
      $it_no = $it_no + $o_engineer + $ntd_it;
      $other = $total_number_devs - $it_yes - $it_no;

      echo $t->translate("IT or not IT")." : ";
      echo "</TD><TD>";
      echo "<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD>";
      htmlp_image("bar_bl_l.gif", 0, 7, 11, "-");
      echo "</TD><TD>";
      htmlp_image("bar_bl_m.gif", 0, $it_yes/$total_number_devs*$bar_lenght, 11, $t->translate("IT")." ".sprintf( "%01.2f",($it_yes/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_rd_m.gif", 0, $it_no/$total_number_devs*$bar_lenght, 11, $t->translate("Not IT")." ".sprintf( "%01.2f",($it_no/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_m.gif", 0, $other/$total_number_devs*$bar_lenght, 11, $t->translate("No Entry")." ".sprintf( "%01.2f",($other/$total_number_devs)*100) ."%");
      echo "</TD><TD>";
      htmlp_image("bar_bk_r.gif", 0, 7, 11, "-");
      echo "</TD></TR></TABLE>";
      echo "</TD><TD>";

      htmlp_image("bar_bl_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("IT")."&nbsp;&nbsp; ";
      htmlp_image("bar_rd_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("Not IT")."&nbsp;&nbsp; ";
      htmlp_image("bar_bk_m.gif", 0, 7, 11, "-"); echo "&nbsp;".$t->translate("No Entry")."&nbsp;&nbsp; ";
      
      
      echo "</TD>";
      
      echo "</TR></TABLE>";
      $bx->box_body_end();
      $bx->box_end();
      
      break;
   }
}

?>
<!-- end content -->

<?php
require("footer.inc");
@page_close();
?>
