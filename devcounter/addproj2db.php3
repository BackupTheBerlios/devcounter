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
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
$counter=0;
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
   $username=$auth->auth["uname"];
   $db->query("SELECT * from developers WHERE username='$username'");
   $db->next_record();
   $number_of_projects = $db->f("number_of_projects");
   $counter2=0;
   if ($number_of_projects>0)
     {
      while ($counter!=$number_of_projects)
        {
         $counter++;
	 if (!empty($projectname[$counter]))
	   {
	    $pcomment[$counter] = htmlentities($pcomment[$counter]);
	    $db->query("INSERT os_projects SET  username = '$username', projectname = '$projectname[$counter]', url = '$projecturl[$counter]', comment='$pcomment[$counter]'");
	    if ($db->affected_rows() != 0)
	      {
	       $counter2++;
	      }
	   }
	}
      $db->query("UPDATE developers SET number_of_projects='$counter2' WHERE username='$username'");
     }
   else
     {
      $bx->box_begin();
      $bx->box_title($t->translate("Error"));
      $bx->box_body_begin();
      echo $t->translate("No Projects")."\n";
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
