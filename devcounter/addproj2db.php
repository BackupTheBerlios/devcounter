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
# This page inserts the data into the database
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: addproj2db.php,v 1.4 2002/08/27 11:16:59 helix Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,
              $th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
$counter=0;
if (empty($auth->auth["uname"]))
  {
   $bx->box_full($t->translate("Not logged in"), $t->translate("Please login first"));
  }
else
  {
   $username=$auth->auth["uname"];
   $db->query("SELECT * from developers WHERE username='$username'");
   $db->next_record();
   $number_of_projects = $db->f("number_of_projects");
   if ($number_of_projects <= 0)
      $number_of_projects = 6;
   $counter2=0;
   while ($counter!=$number_of_projects)
     {
      $counter++;
      if (!empty($projectname[$counter]))
        {
         $pcomment[$counter] = htmlentities($pcomment[$counter]);
         $db->query("INSERT os_projects SET  username = '$username', projectname = '$projectname[$counter]', url = '$projecturl[$counter]', comment='$pcomment[$counter]'");
         if ($db->affected_rows() != 0)
            $counter2++;
        }
     }
   $db->query("UPDATE developers SET number_of_projects='$counter2' WHERE username='$username'");
   $bx->box_full($t->translate("Success"), $t->translate("Your Project Data were included successfully"));
  }
?>

<!-- end content -->

<?php
require("./include/footer.inc");
@page_close();
?>
