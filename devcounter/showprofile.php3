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


$db->query("SELECT * from developers,extra_perms WHERE developers.username='$devname' AND extra_perms.username='$devname'");
if ($db->num_rows() == 0)
  {
      
   $bx->box_begin();
   $bx->box_title($t->translate("Error"));
   $bx->box_body_begin();

   echo $t->translate("no profile given");

   $bx->box_body_end();
   $bx->box_end();
  }
else
  {
   $db->next_record();
   $username = $devname;
   
   $bx->box_begin();
   $bx->box_title($t->translate("Developer"));
   $bx->box_body_begin();

   echo "<CENTER><FONT SIZE=\"+3\"><B>&nbsp;&nbsp;$devname&nbsp;&nbsp;</B></FONT></CENTER>";

   $bx->box_body_end();
   $bx->box_end();
   
   $bx->box_begin();
   $bx->box_title($t->translate("Personal Data"));
   $bx->box_body_begin();

   echo "<table border=0 width=100% align=center cellspacing=3 cellpadding=3>\n";
   echo "<tr><td align=right width=30%>".$t->translate("Username").":</td><td width=70%> $username\n";
  
   $nationality = $db->f("nationality");
   echo "<tr><td align=right width=30%>".$t->translate("Nationality").":</td><td width=70%>\n";
   print_country($nationality);


   $actual_country = $db->f("actual_country");
   echo "<tr><td align=right width=30%>".$t->translate("actually live in").":</td><td width=70%>\n";
   print_country($actual_country);

   echo "<tr><td align=right valign=top width=30%>".$t->translate("Languages spoken").":</td><td width=70%>\n";
   
   
   $mother_tongue = $db->f("mother_tongue");
   echo "1. ";
   print_lang($mother_tongue);

   $other_lang_1 = $db->f("other_lang_1");
   echo "<BR>2. ";
   print_lang($other_lang_1);

   $other_lang_2 = $db->f("other_lang_2");
   echo "<BR>3. ";
   print_lang($other_lang_2);
   
   echo "<BR><BR>";
   if ($db->f("contact")=="yes")
     {
      $pquery["devname"] = $db->f("username") ;
      htmlp_link("mailform.php3",$pquery,$t->translate("Contact Developer"));
     }
   echo "</td></tr>\n";
   echo "</table>\n";
   $bx->box_body_end();
   $bx->box_end();
   
   $bx->box_begin();
   $bx->box_title($t->translate("Computer experience"));
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   $number_of_projects = $db->f("number_of_projects");
   echo "<tr><td align=left>".$t->translate("Number of Free Software/Open Source Projects").": $number_of_projects\n";
   $name_of_projects = $db->f("name_of_projects");
   echo "<BR>".$t->translate("The Free Software/Open Source Projects are").": $name_of_projects</td></tr>\n";
  

   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><B><FONT SIZE=+1>".$t->translate("programming expirience")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table width=90% border=0>\n";


   $db2->query("select * from prog_ability_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_abilities WHERE translation='$la'");
   $ability_amount=$db->num_rows();
   $counter=0;$counter2=0;
   
   while ($counter<$ability_amount)
     {
      $counter++;
      $db->next_record();
      $ability_value = 0;
      $ability_code = $db->f("code");
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      if ($ability_value !=0)
        {
         $counter2++;
         if (($counter2 % 3)==1)
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
      
            $printstars = 0;
	 while ($printstars !=$ability_value)
           {
      	    echo "*";
   	    $printstars++;
      	   }
      
         echo"</td></tr></table>";
     
         if (($counter2 % 3)==0)
           {
            echo "</td></tr>\n\n"; 
           }
         else
           {
            echo "</td>\n";
           }
        }
     }
     
   if (($counter2 % 3)==0)
     {
      echo "</tr>\n\n"; 
     }
   htmlp_form_hidden("ability_amount", $ability_amount);
  
   echo "</table></center>\n";


   echo "</TABLE>";
   $bx->box_body_end();
   $bx->box_body_begin();
   echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=3>\n";

   echo "<tr><td align=center><B><FONT SIZE=+1>".$t->translate("languages/tool experience")."</FONT></B></td></tr><tr><td>\n";
   echo "<center><table border=0>\n";



   $db2->query("select * from prog_language_values WHERE username='$username'");
   $db2->next_record();

   $db->query("SELECT * from prog_languages");
   $lang_amount=$db->num_rows();
   $counter=0;$counter2=0;
   while ($counter<$lang_amount)
     {
      $counter++;
      $db->next_record();
      $ability_value = 0;
      $ability_code = $db->f("code");
      $colname = $db->f("colname");
      $ability_value = $db2->f($colname);
      if ($ability_value !=0)
        {
         $counter2++;
	 if (($counter2 % 3)==1)
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

     
         $printstars = 0;
         while ($printstars !=$ability_value)
           {
	    echo "*";
	    $printstars++;
	   }
      
 

         echo"</td></tr></table>";
     
         if (($counter2 % 3)==0)
           {
            echo "</td></tr>\n\n"; 
           }
         else
           {
            echo "</td>\n";
           }
	}
     }
     
   if (($counter2 % 3)==0)
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
  }








?>
<!-- end content -->

<?php
require("footer.inc");
page_close();
?>
