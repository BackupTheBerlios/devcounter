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
# Show search results
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: devresults.php,v 1.11 2006/01/09 16:26:37 helix Exp $
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

$bx = new box("100%",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);
$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
$db2 = new DB_DevCounter;
?>

<!-- content -->
<?php
// echo "<p>$option\n";

switch($option) {

// All in one

case "allinone":
	$request_amount = 0;
	$hit_amount =0;

	$query = "SELECT DISTINCT developers.username,auth_user.realname,auth_user.email_usr,extra_perms.showname,extra_perms.showemail";
	$query .= " FROM developers,auth_user,os_projects,prog_language_values,prog_ability_values,extra_perms";
	$query .= " WHERE developers.username=auth_user.username AND developers.username=extra_perms.username AND os_projects.username=extra_perms.username AND prog_language_values.username=prog_ability_values.username AND extra_perms.username=prog_ability_values.username AND extra_perms.search='yes'";
	if ($projname != "") $query .= " AND os_projects.projectname LIKE '%$projname%'";
	if ($dev_lang != "" && $dev_lang != "999") $query .= " AND (developers.mother_tongue='$dev_lang' OR developers.other_lang_1='$dev_lang' OR developers.other_lang_2='$dev_lang')";
	if ($dev_country != "" && $dev_country != "999") $query .= " AND (developers.nationality='$dev_country' OR developers.actual_country='$dev_country')";

	for ($i=1; $i<=$lang_amount; $i++) {
		if ($plang[$i] > 1) {
			$db2->query("SELECT colname FROM prog_languages WHERE code='$i'");
			$db2->next_record();
			// echo "-".$i."-";
			$query .= " AND prog_language_values.".$db2->f("colname").">='$plang[$i]'";
		}
	}
	for ($i=1; $i<=$ability_amount; $i++) {
		if ($ability[$i] > 1) {
			$db2->query("SELECT colname FROM prog_abilities WHERE code='$i'");
			$db2->next_record();
			// echo "-".$i."-";
			$query = $query." AND prog_ability_values.".$db2->f("colname").">='$ability[$i]'";
		}
	}
	$query=$query." ORDER BY extra_perms.username ASC";

	// echo "<p>".$query."\n";

	$db->query($query);

	$bx->box_begin();
	$bx->box_title($t->translate("Search Results"));
	$bx->box_body_begin();

	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username") ;
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname")=="yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;  
		}
    	$bx->box_columns_end();
	}
	$bx->box_body_end();
	$bx->box_end();
    
break;

// Abilities

case "abilities":

	$request_amount = 0;
	$hit_amount =0;

	$query = "SELECT * FROM prog_language_values,prog_ability_values,auth_user,extra_perms WHERE prog_language_values.username=prog_ability_values.username AND prog_language_values.username=auth_user.username AND extra_perms.username=prog_ability_values.username AND extra_perms.search='yes'";
	for ($i=1; $i<=$lang_amount; $i++) {
		if ($plang[$i] > 1) {
			$db2->query("SELECT colname FROM prog_languages WHERE code='$i'");
			$db2->next_record();
			// echo "-".$i."-";
			$query .= " AND prog_language_values.".$db2->f("colname").">='$plang[$i]'";
		}
	}
	for ($i=1; $i<=$ability_amount; $i++) {
		if ($ability[$i] > 1) {
			$db2->query("SELECT colname FROM prog_abilities WHERE code='$i'");
			$db2->next_record();
			// echo "-".$i."-";
			$query .= " AND prog_ability_values.".$db2->f("colname").">='$ability[$i]'";
		}
	}
	$query .= " ORDER BY extra_perms.username ASC";
	// echo "<p>$query\n";
	$db->query($query);

	$bx->box_begin();
	$bx->box_title($t->translate("Search Results"));
	$bx->box_body_begin();

	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username");
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname") == "yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;
	   
		}
        $bx->box_columns_end();
	}

	$bx->box_body_end();
	$bx->box_end();

break;

// Projects

case "projects":

	$db->query("SELECT DISTINCT os_projects.username,auth_user.realname,auth_user.email_usr,extra_perms.showname,extra_perms.showemail FROM os_projects,auth_user,extra_perms WHERE (os_projects.username=auth_user.username AND os_projects.username=extra_perms.username AND extra_perms.search='yes') AND os_projects.projectname LIKE '%$projname%' ORDER BY os_projects.username ASC");
	$bx->box_begin();
	$bx->box_title($t->translate("Results"));
	$bx->box_body_begin();
      
	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username") ;
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname") == "yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;
		}
		$bx->box_columns_end();
	}
	$bx->box_body_end();
	$bx->box_end();
break;

// Language

case "lang":

	$db->query("SELECT DISTINCT developers.username,auth_user.realname,auth_user.email_usr,extra_perms.showname,extra_perms.showemail FROM developers,auth_user,extra_perms WHERE developers.username=auth_user.username AND developers.username=extra_perms.username AND extra_perms.search='yes' AND (developers.mother_tongue='$dev_lang' OR developers.other_lang_1='$dev_lang' OR developers.other_lang_2='$dev_lang') ORDER BY developers.username ASC");
	$bx->box_begin();
	$bx->box_title($t->translate("Results"));
	$bx->box_body_begin();
      
// mother_tongue  other_lang_1  other_lang_2
      
	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username") ;
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname") == "yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;
		}
		$bx->box_columns_end();
	}

	$bx->box_body_end();
	$bx->box_end();

break;

// Country

case "country":

	$db->query("SELECT developers.username,auth_user.realname,auth_user.email_usr,extra_perms.showname,extra_perms.showemail FROM developers,auth_user,extra_perms WHERE developers.username=auth_user.username AND developers.username=extra_perms.username AND extra_perms.search='yes' AND (developers.nationality='$dev_country' OR developers.actual_country='$dev_country') ORDER BY developers.username ASC");
	$bx->box_begin();
	$bx->box_title($t->translate("Results"));
	$bx->box_body_begin();

	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username") ;
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname") == "yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;
		}
		$bx->box_columns_end();
	}

	$bx->box_body_end();
    $bx->box_end();

break;

// Username

case "name":

	$db->query("SELECT developers.username,auth_user.realname,auth_user.email_usr,extra_perms.showname,extra_perms.showemail FROM auth_user,developers,extra_perms WHERE developers.username=extra_perms.username AND developers.username=auth_user.username AND extra_perms.search='yes' AND (developers.username LIKE '%$search_text%' OR (extra_perms.showname='yes' AND auth_user.realname LIKE '%$search_text%')) ORDER BY developers.username ASC");
	$bx->box_begin();
	$bx->box_title($t->translate("Results"));
	$bx->box_body_begin();

	if ($db->num_rows() == 0) {
		echo $t->translate("No Results")."\n";
	} else {
		$bx->box_columns_begin(4);
		$bx->box_column("right","5%", $th_strip_title_bgcolor,"<b>".$t->translate("No.")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Username")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("Realname")."</b>");
		$bx->box_column("center","25%", $th_strip_title_bgcolor,"<b>".$t->translate("E-Mail")."</b>");
		$bx->box_next_row_of_columns();

		$i=1;
		while ($db->next_record()) {
			if ($counter%2 != 1) $bgcolor = $th_box_body_bgcolor;
			else $bgcolor = $th_box_body_bgcolor2;
			$counter++;

			$bx->box_column("right","",$bgcolor,$i);
			$pquery["devname"] = $db->f("username") ;
			$bx->box_column("center","",$bgcolor,html_link("showprofile.php",$pquery,$db->f("username")));
			if ($db->f("showname") == "yes") {
				$bx->box_column("center","",$bgcolor,$db->f("realname"));
			} else {
				$bx->box_column("center","",$bgcolor,"-- % ---");
			}
			if ($db->f("showemail") == "yes") {
				$bx->box_column("center","",$bgcolor,html_link("mailto:".mailtoencode($db->f("email_usr")),"",ereg_replace("\."," dot ",ereg_replace("@"," at ",htmlentities($db->f("email_usr"))))));
			} else {
				$bx->box_column("center","",$bgcolor,"--- % ---");
			}
			$bx->box_next_row_of_columns();
			$i++;
		}
		$bx->box_columns_end();
	}

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
