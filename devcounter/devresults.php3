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
$plang_amount = 0;
$db->query("SELECT username from developers");
while ($db->next_record())
  {
   $un_query[$db->f("username")]=0;
  }

for ($i=0;$i<$lang_amount;$i++)
  {
   if ($lang[$i] != 0)
     {
      $db->query("SELECT username FROM prog_languages_values WHERE code='$i' AND value>='$lang[$i]'");
      $plang_amount++;
      while ($db->next_record())
        {
	 $un_query[$db->f("username")]++;
	}
     }
  }

for ($i=0;$i<$ability_amount;$i++)
  {
   if ($ability[$i] != 0)
     {
      $db->query("SELECT username FROM prog_abilities_values WHERE code='$i' AND value>='$lang[$i]'");
      $plang_amount++;
      while ($db->next_record())
        {
	 $un_query[$db->f("username")]++;
	}
     }
  }
$bx->box_begin();
$bx->box_title($t->translate("Results"));
$bx->box_body_begin();


for($x=0;$x<sizeof($un_query);$x++) 
  {
   if (current($un_query) == $plang_amount)
   echo key($un_query)." : ".current($un_query)."<br>";   
   next($un_query);
  }

$bx->box_body_end();
$bx->box_end();

?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
