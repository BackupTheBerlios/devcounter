<?php

######################################################################
# DevCounter:
# ===================================================================
#
# Copyright (c) 2001 by
#                Gregorio Robles (grex@scouts-es.org) and
#                Lutz Henckel (lutz.henckel@fokus.gmd.de)
#
# BerliOS DevCounter: http://sourceagency.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# Main Library file.
# You'll find in DevCounter's documentation a good explanation of the
# functions that are coded in this file.
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################

#
# Returns time in timestamp format 
#

function mktimestamp($time) {
    $timestamp = mktime(substr($time,8,2),substr($time,10,2),substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4));
    return $timestamp;
}

#
#
#

function timestr($timestamp) {
    global $t;
    $time = strftime("%A, %e. %B %Y, %H:%M:%S %Z", $timestamp);
    return $time;
}

function timestr_middle($timestamp) {
    global $t;
    $time = strftime("%e. %B %Y", $timestamp);
    return $time;
}

function timestr_short($timestamp){
    global $t;
    $time = strftime("%a,%e.%b,%H:%M:%S", $timestamp);
    return $time;
}

function timestr_comment($timestamp){
    global $t;
    $time = strftime("%e. %b %Y, %H:%M", $timestamp);
    return $time;
}

function timestr_shortest($timestamp){
    global $t;
    $time = strftime("%e. %b", $timestamp);
    return $time;
}

// 
//  license ($selected)
//  Displays the different licenses as a select form 
//  $selected ist the SELECTED license
// 

function license($selected) {

  $return = html_select("license");
  $db_local = new DB_DevCounter;
  $db_local->query("SELECT * FROM licenses ORDER BY license ASC");
  while ($db_local->next_record()) {
	if (!strcmp($db_local->f("license"),$selected)) $return .= html_select_option($db_local->f("license"),"selected",$db_local->f("license"));
	else $return .= html_select_option($db_local->f("license"),"",$db_local->f("license"));
  }
  $return .= html_select_end();

  return $return;
}

// 
//  licensep ($selected)
//  Prints the different licenses as a select form 
//  $selected ist the SELECTED license
// 

function licensep($selected) {

  htmlp_select("license");
  $db_local = new DB_DevCounter;
  $db_local->query("SELECT * FROM licenses ORDER BY license ASC");
  while ($db_local->next_record()) {
	if (!strcmp($db_local->f("license"),$selected)) htmlp_select_option($db_local->f("license"),"selected",$db_local->f("license"));
	else htmlp_select_option($db_local->f("license"),"",$db_local->f("license"));
  }
  htmlp_select_end();
}


## show_more($iter,$maxiter,$url,$urlquery)
##
## shows 10 apps of the current iteraction $iter
## until it reaches the maximum number of iteractions $maxiter
## $url is the name of the page (*.php3)
## $urlquery contains an array with the paramaters for the new page
##            (everything after the ?)

function show_more($iter,$maxiter,$url,$urlquery) {
  global $sess;

  $iter /=10;
  echo "<table border=0 width=600><tr>";
  echo "<td>&nbsp;</td>\n";
  echo "<td align=right>";

  $maxiter= Floor($maxiter);

  if ($iter > 3) {
    echo "<a href=\"".$sess->url($url).$sess->add_query($urlquery).$sess->add_query(array("iter" => 0))."\">&lt;&lt;</a>\n";
  }

  $number = $iter - 3;
  if ($number < 0) $number = 0;
  if ($iter > 2) {
    echo "<a href=\"".$sess->url($url).$sess->add_query($urlquery).$sess->add_query(array("iter" => $number))."\">&lt;</a>\n";
  }

  switch ($iter) {
    case 0: $bias=0; break;
    case 1: $bias=1; break;
    case ($maxiter-1): if ($iter>3) {$bias=3;} else {$bias=2;} break;
    case ($maxiter): if ($iter>4) {$bias=4;} else {$bias=2;} break;
    default: $bias=2; break;
  }

  for($i=$iter-$bias;$i<$maxiter+1 && $i<($iter+5-$bias);$i++) {
    $number1 = $i*10 +1;
    $number2 = $number1 + 9;
    $number = strval($number1)."-".strval($number2);
    if ($i != $iter) {
      echo "<a href=\"".$sess->url($url).$sess->add_query($urlquery).$sess->add_query(array("iter" => $i))."\">&nbsp;$number</a>\n";
    }
    else echo "<B>&nbsp;$number</B>\n"; 
   }

  $number = $iter + 5 - $bias;
  if ($number > $maxiter+$bias) $number =$maxiter+$bias;
  if ($iter < $maxiter-4+$bias) {
    echo "<a href=\"".$sess->url($url).$sess->add_query($urlquery).$sess->add_query(array("iter" => $number))."\"> &gt;</a>\n";
  }

  $number = $iter + 10 - $bias;
  if ($number > $maxiter) $number = $maxiter;
  if ($iter < $maxiter-5 +$bias) {
    echo "<a href=\"".$sess->url($url).$sess->add_query($urlquery).$sess->add_query(array("iter" => $number))."\"> &gt;&gt;</a>\n";
  }

   echo "</td>\n";
   echo "</tr></table><BR>";
}

function wrap($string,$width=75,$break=" ") {
	$out = "";
	$lin = "";
	$tok = strtok($string,$break);
	while ($tok) {
		if ((strlen($lin) + strlen($tok)) > $width) {
			$out .= $lin."\n";
			$lin = "";
		}
		if (strlen($lin) > 0)
			$lin .= " ";
		$lin .= $tok;
		$tok = strtok (" ");
	}
	$out .= $lin;
	return $out;
}

function typestr($type) {
	global $t;
	if ($type == "A")
		$str = $t->translate("Adaption");
	if ($type == "E")
		$str = $t->translate("Expansion");
	if ($type == "C")
		$str = $t->translate("Documentation");
	if ($type == "D")
		$str = $t->translate("Development");
	if ($type == "O")
		$str = $t->translate("Other");
	return $str;
}

function increasecnt($id, $type) {
  global $db;

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT * FROM counter WHERE proid='$id'");

           // If application in table and first access today update counters
  $first = checkcnt($id, $GLOBALS[REMOTE_ADDR], $type);

  $db_local->next_record();
  if ($first == 1) {
    $counter = $db_local->f($type) + 1;
    $db->query("UPDATE counter SET $type='$counter' WHERE proid='$id'");
  }
}

function checkcnt($id, $ipaddr, $type) {
  global $db;

  $ret = 1;

			// Delete all entries from yesterday
  $today = date("Y-m-d");
  $tables = "counter_check";
  $where = "DATE_FORMAT(creation_cnt,'%Y-%m-%d') != '$today'";
  $db->query("DELETE FROM $tables WHERE $where");

  $columns = "*";
  $where = "proid='$id' AND cnt_type='$type' AND ipaddr='$ipaddr'";
  $db->query("SELECT $columns FROM $tables WHERE $where");

  if ($db->num_rows() > 0) {
			// If remote host already accessed the apps link,
			// don´t increase corresponding counter
    $ret = 0;
  } else {
  			  // Include entry for remote host
    $set = "proid='$id',cnt_type='$type',ipaddr='$ipaddr'";
    $db->query("INSERT $tables SET $set");
  }
  return $ret;
}

function top_bar($proid, $page) {
  global $sess;

  $db_top = new DB_DevCounter;
  $db_top->query("SELECT * FROM description WHERE proid='$proid'");
  $db_top->next_record();

$btop = new box("100%",$th_box_frame_color,1,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_body_font_color,$th_box_body_align);

  $db_top = new DB_DevCounter;
  $db_top->query("SELECT * FROM description WHERE proid='$proid'");
  $db_top->next_record();

  $btop->box_begin();
  $btop->box_body_begin();
  $btop->box_columns_begin(2);
		// 1st column (left one)
  $btop->box_column("left","","","<FONT size=\"+2\"><B> ".$db_top->f("project_title")." - $page</B></FONT>");
		// 2nd column (right one)
  $btop->box_column_start("right","","");

					// Actions listed and linked
					// The current page has border = 1

  htmlp_link("summary.php3",array("proid" => $proid),html_image("ic/a.png",abs(!strcmp("summary",$page)),36,36,"Summary"));
  htmlp_link("news.php3",array("proid" => $proid),html_image("ic/b.png",abs(!strcmp("news",$page)),36,36,"News"));
  htmlp_link("comments.php3",array("proid" => $proid),html_image("ic/c.png",abs(!strcmp("comments",$page)),36,36,"General Comments"));
  htmlp_link("sponsoring.php3",array("proid" => $proid),html_image("ic/d.png",abs(!strcmp("sponsoring",$page)),36,36,"Sponsor Collaboration"));
  htmlp_link("history.php3",array("proid" => $proid),html_image("ic/e.png",abs(!strcmp("history",$page)),36,36,"Project History"));

					// Blank space that
					// limits actions from states

  htmlp_image("blank.gif",0,36,36,"");


					// Project steps
					// In grey future steps

  for($i=1;$i<7;$i++) {
	if ($i <= $db_top->f("status")) {
		htmlp_link("step$i.php3",array("proid" => $proid),html_image("ic/$i.png",abs(!strcmp($i,$page)),36,36,"Step $i"));
	} else {
		htmlp_image("ic/".$i."grey.png",abs(!strcmp($i,$page)),24,24,"Step $i");
	}
  }

  $btop->box_next_row_of_columns();

  $btop->box_colspan (2,"","#000000",html_image("",0,1,1,""));
  $btop->box_columns_end();
  $btop->box_body_end();
  $btop->box_end();

  print "<br><p>\n";

}


function summary($proid) {
  global $bx,$sess,$t;

  $db_summary = new DB_DevCounter;
  $db_summary->query("SELECT * FROM description WHERE proid='$proid'");
  $db_summary->next_record();
  $status = $db_summary->f("status");

  $bx->box_begin();
  $bx->box_body_begin();
  $bx->box_columns_begin(2);

  $bx->box_column_start("right","65%","");

  $bx->box_begin();
  $bx->box_title($t->translate("General Actions (anytime and anywhere)"));
  $bx->box_body_begin();


				// Actions listed, linked and explained

					// News

  $db_summary->query("SELECT COUNT(*) FROM news WHERE proid='$proid'");
  $db_summary->next_record();
  htmlp_link("news.php3",array("proid" => $proid),html_image("ic/b.png",0,48,48,"News")."&nbsp;News");
  print "( <B>".$db_summary->f("COUNT(*)")."</B> news for this project )<hr>\n";

					// Commments

  htmlp_link("comments.php3",array("proid" => $proid),html_image("ic/c.png",0,48,48,"Comments")."&nbsp;General Comments");
  $db_summary->query("SELECT COUNT(*) FROM comments WHERE proid='$proid' AND type='general'");
  $db_summary->next_record();
  print "( <B>".$db_summary->f("COUNT(*)")."</B> general comments";
  $db_summary->query("SELECT COUNT(*) FROM comments WHERE proid='$proid' AND type!='general'");
  $db_summary->next_record();
  print ", <B>".$db_summary->f("COUNT(*)")."</B> other comments on this project )<hr>\n";

					// Sponsor Involvement

  htmlp_link("sponsoring.php3",array("proid" => $proid),html_image("ic/d.png",0,48,48,"News")."&nbsp;Sponsoring collaboration");
  $db_summary->query("SELECT COUNT(*) FROM sponsoring WHERE proid='$proid' AND status='A'");
  $db_summary->next_record();
  print "( <B>".$db_summary->f("COUNT(*)")."</B> accepted sponsoring collaborations, ";

  $db_summary->query("SELECT COUNT(*) FROM sponsoring WHERE proid='$proid' AND status='P'");
  $db_summary->next_record();
  print " <B>".$db_summary->f("COUNT(*)")."</B> non-accepted sponsoring proposals for this project )<BR><I>This is interesting if you are a sponsor and you are interested in joining this project.</I><hr>\n";

					// Project History

  htmlp_link("history.php3",array("proid" => $proid),html_image("ic/e.png",0,48,48,"News")."&nbsp;Project History");
  print "<BR><i>You'll find here all what has been posted to the project (news, comments, content suggestions, etc.) in chronological order</i>.<br>&nbsp;\n";

  $bx->box_body_end();

  $bx->box_title($t->translate("Step specific actions (only at its time)"));
  $bx->box_body_begin();

					// Project steps linked and explained
					// In grey future steps and unlinked

  for ($i=1; $i<7; $i++) {
	allowed_actions ($status, $i, $proid);
  }
  $bx->box_body_end();
  $bx->box_end();

  $bx->box_column_finish();
  $bx->box_column_start("right","35%","");

  $db_look = new DB_DevCounter;
  $db_look->query("SELECT * FROM description,auth_user WHERE proid='$proid' AND description_user = username");
  $db_look->next_record();
  if ($db_look->f("perms") == "sponsor") $background_color = "#FFFFCC";
  else $background_color = "#f9dfc0";

  $bx->box_begin();
  $bx->box_title($t->translate("Step information"));
  $bx->box_body_begin();
  step_information ($status);

  print html_link("decisions.php3",array("proid" => $proid),html_image("ic/check.png",0,16,15,"ic/check.png")." Decisions on this step")." Sponsors can make the current decision following this link.\n&nbsp;<p>";

  print html_link("configure_edit.php3",array("proid" => $proid),html_image("ic/check.png",0,16,15,"ic/check.png")." Project configurations")." Configure the project parameters.\n&nbsp;<p>";

  print html_link("views.php3",array("proid" => $proid),html_image("ic/check.png",0,16,15,"ic/check.png")." Information access configuration")." Configure the information access to the project's data.\n&nbsp;<p>";

  print html_link("monitor_edit.php3",array("proid" => $proid),html_image("ic/check.png",0,16,15,"ic/check.png")." Monitor This Project")." Receive an email update when something happens in this project.<p><br>\n";
  $bx->box_body_end();

  $bx->box_title($t->translate("Project Information"));
  $bx->box_body_begin();
  calendar_box($proid);
  $bx->box_body_end();

  $bx->box_title($t->translate("Latest News"));
  $bx->box_body_begin();
  summary_news($proid);
  $bx->box_body_end();
  $bx->box_end();

  $bx->box_column_finish();
  $bx->box_columns_end();
  $bx->box_body_end();
  $bx->box_end();
}

function step_information ($status) {
  global $bx;

  $bx->box_begin();
  $bx->box_body_begin();
  $bx->box_columns_begin(2);
  
  $bx->box_column("","","","<b>Step information</b>: Step $status<br>\nWhat can be done in step $status? We've got to explain this!\n");
  $bx->box_column("","","",html_image("ic/".$status.".png",0,48,48,$status));

  $bx->box_columns_end();
  $bx->box_body_end();
  $bx->box_end();
}

	// this function is used in the summary page

function calendar_box($proid) {
  global $bx;

  $db_general = new DB_DevCounter;
  $db_general->query("SELECT * FROM description,auth_user WHERE proid='$proid' AND description_user = username");
  $db_general->next_record();

  print "<br>\n";

  $bx->box_columns_begin(2);

  $bx->box_column ("left","55%","","<b>Project Owner(s):</b>");
  $bx->box_column ("left","45%","","&nbsp;".$db_general->f("description_user"));

  $bx->box_next_row_of_columns();
  $bx->box_colspan (2,"","","");
  $bx->box_next_row_of_columns();

  $bx->box_column ("left","","","<b>Project Type:</b>");
  $bx->box_column ("left","","","&nbsp;".$db_general->f("type"));

  $bx->box_next_row_of_columns();

  $bx->box_column ("left","","","<b>Project Volume:</b>");
  $bx->box_column ("left","","","&nbsp;".$db_general->f("volume"));

  $bx->box_next_row_of_columns();
  $bx->box_colspan (2,"","","");
  $bx->box_next_row_of_columns();

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT SUM(budget) FROM sponsoring WHERE proid='$proid' AND status='A'");
  $db_local->next_record();
  if ($db_local->num_rows() == 0) $budget = 0;
  $budget = $db_local->f("SUM(budget)");

  $bx->box_column ("left","","","<b>Current project budget:</b>");
  $bx->box_column ("left","","","$budget euro");

  $bx->box_next_row_of_columns();
  $bx->box_colspan (2,"","","");
  $bx->box_next_row_of_columns();

  $bx->box_column ("left","","","<b>Creation:</b>");
  $bx->box_column ("left","","","&nbsp;".timestr_middle(mktimestamp($db_general->f("description_creation"))));

  $bx->box_next_row_of_columns();

  $bx->box_column ("left","","","<b>Propossed Calendars</b>");
  $bx->box_column ("left","","","&nbsp;");

  $bx->box_columns_end();

  print "<br>\n";
}

function summary_news($proid) {
  global $sess;

  $db_summ_news = new DB_DevCounter;
  $db_summ_news->query("SELECT * FROM news,auth_user WHERE proid='$proid' AND user_news=username ORDER BY creation_news DESC LIMIT 3");


  print "<br>\n";

  while ($db_summ_news->next_record()) {
  	$db_comments_on_news = new DB_DevCounter;
	$db_comments_on_news->query("SELECT * FROM comments WHERE proid='$proid' AND type='News' AND number='".$db_summ_news->f("creation_news")."'");

	print "&nbsp;";
	htmlp_link("news.php3",array("proid" => $proid),"<b>".$db_summ_news->f("subject_news")."</b><br>").
	$timestamp = mktimestamp($db_summ_news->f("creation_news"));
        print "<b><font size=\"-1\">&nbsp;<a href=\"mailto:".$db_summ_news->f("email_usr")."\">".$db_summ_news->f("user_news")."</a> - ".timestr_comment($timestamp)."</b></font><br>\n";
	if ($db_comments_on_news->num_rows() > 0) {
		print "&nbsp;<font size=-1>[ ".$db_comments_on_news->num_rows()." ";
		htmlp_link("comments.php3",array("proid" => $proid, "type" => "News", "number" => $db_summ_news->f("creation_news"), "ref" => "0"),"comments");
		print "on it ]</font>\n";
	}
	print "<p>\n";
  }

  if ($db_summ_news->num_rows() == 0) {
	print "&nbsp;There have not been posted any news by the project owner(s).\n";
  }

  print "<p align=right><a href=\"".$sess->url("news_edit.php3").$sess->add_query(array("proid" => $proid))."\"><FONT SIZE=\"-1\">[Submit News]</FONT></a>&nbsp;&nbsp;<br>&nbsp;\n";

}

function lib_show_description($query) {
  global $bx, $t, $sess, $db;

  $db->query($query);
  $db->next_record();

  $bx->box_begin();
  $bx->box_title($db->f("project_title")." (".$db->f("type").")");
  $bx->box_body_begin();
  echo "<b>".$t->translate("by")." ";
  htmlp_link("mailto:".$db->f("email_usr"),"",$db->f("description_user"));
  echo " - ".timestr(mktimestamp($db->f("description_creation")));
  echo "<p><b>".$t->translate("Description")."</b>: ".$db->f("description")."\n";
  echo "<p><b>".$t->translate("Volume")."</b>: ".$db->f("volume")."\n";
  $bx->box_body_end();
  $bx->box_end();
}

function select_from_config($name,$array_name,$selected) {
        $array_value="";
	
	/* FIXME - FIXME - FIXME */
	/* I don't know why this doesn't work with arrays */

	include("config.inc");
	switch ($array_name) {
		case "project_types": $array = $project_types; break;
		case "project_volume": $array = $project_volume; break;
		case "platform_array": $array = $platform_array; break;
		case "architecture_array": $array = $architecture_array; break;
		case "environment_array": $array = $environment_array; break;
		case "milestone_product_array": $array = $milestone_product_array; break;
		case "comments_type_array": $array = $comments_type_array; break;
	}
	
	$output = html_select($name)."\n";
	while (list(, $array_value) = each($array)) {
		if (!strcmp($array_value,$selected)) $select = "selected";
		else $select="";
		$output .= html_select_option($array_value,$select,$array_value)."\n";
	}
	$output .= html_select_end()."\n";

	return($output);
}

function followment($proid) {
  global $bx,$sess,$t,$auth;

  $db_followment = new DB_DevCounter;

  $bx->box_begin();
  $bx->box_body_begin();
  $bx->box_columns_begin(2);

  $bx->box_column_start("right","65%","");

  $query  = "SELECT * FROM description,auth_user WHERE description.proid='$proid' AND description.description_user=auth_user.username GROUP BY description.proid";
  lib_show_description($query);

  include("contentlib.inc");
  show_selected_content($proid);

  include("developinglib.inc");
  show_selected_developing($proid);

  $bx->box_column_finish();
  $bx->box_column_start("right","35%","");

  show_project_participants($proid,"sponsor");
  show_project_participants($proid,"developer");
  show_project_participants($proid,"referee");

  $bx->box_column_finish();
  $bx->box_columns_end();

  include("milestoneslib.inc");
  show_milestones($proid,'devel',$auth->auth["uname"]);

  $bx->box_body_end();
  $bx->box_end();

}

function show_status($char) {
  switch ($char) {
    case 'P':
      return "Proposed";
      break;
    case 'N':
      return "Negotiating";
      break;
    case 'A':
      return "Accepted";
      break;
    case 'R':
      return "Rejected";
      break;
    case 'D':
      return "Deleted";
      break;
    case 'M':
      return "Modified";
      break;
    default:
      return "Proposed";
      break;
  }
}

function show_project_participants($proid,$participant_type) {
  global $t, $bx, $db;

  $bx->box_begin();
  $bx->box_title($t->translate($participant_type));
  $bx->box_body_begin();

  if ($participant_type == "sponsor") {
  	$query = "SELECT * FROM description,auth_user WHERE proid='$proid' AND description_user=username";
  	$db->query($query);
  	$db->next_record();
  	if ($db->f("perms") == "sponsor") echo "<p><b>Sponsor:</b> ".$db->f("description_user")."\n";
  }

  switch ($participant_type) {
	case "sponsor": $table = "sponsoring"; break;
	case "developer": $table = "developing"; break;
	case "referee": $table = "referees"; break;
  }

  $query = "SELECT $participant_type FROM $table WHERE proid='$proid' AND status='A'";
  $db->query($query);
  while($db->next_record()) {
  echo "<p><b>$participant_type:</b> ".$db->f($participant_type)."\n";
  }

  echo "<br>&nbsp;\n";
  $bx->box_body_end();
  $bx->box_end();
}

function lib_comment_it($proid,$type,$number,$ref,$subject,$text) {
  global $sess;

  print "<FONT SIZE=-1>[ ";
  htmlp_link("comments_edit.php3",array("proid" => $proid, "type" => $type, "number" => $number, "ref" => $ref, "subject" => $subject),$text);
  print " ]</FONT>\n";

}

function lib_previous_comment($proid,$type,$number,$ref,$text) {
  global $sess;

  print "<FONT SIZE=-1>[ ";
  htmlp_link("comments.php3",array("proid" => $proid, "type" => $type, "number" => $number, "ref" => $ref),$text);
  print " ]</FONT>\n";

}

function lib_show_comments_on_it($proid,$type_cmt,$number,$cmt_id) {

  if (isset($number) && !empty($number)) $number_selection = "AND number='$number'";
  else $number_selection = "AND number='0'";

  $db = new DB_DevCounter;
  $db->query("SELECT * FROM comments,auth_user WHERE proid='$proid' AND type='".$type_cmt."' ".$number_selection." AND ref='$cmt_id' AND user_cmt=username ORDER BY creation_cmt ASC");
  if ($db->num_rows() > 0) {
	echo "<ul>\n";
  	while($db->next_record()) {
		echo "<li>".html_link("comments.php3",array("proid" => $proid, "type" => $type_cmt, "number" => $number, "ref" => $cmt_id),$db->f("subject_cmt"))." by <b>".$db->f("user_cmt")."</b> on <b>".timestr_comment(mktimestamp($db->f("creation_cmt")))."</b>\n";
		lib_show_comments_on_it($proid,$type_cmt,$number,$db->f("id"));
  	}
  	echo "</ul>\n";
  }
  echo "<p>\n";
}

function select_date($selection_name,$selected_day,$selected_month,$selected_year) {

  $return = html_select($selection_name."_day");

  for ($i=1; $i <= 31; $i++) {
 	if ($i == $selected_day) $select="selected";
	else $select="";
	$return .= html_select_option($i,$select,$i);
  }

  $return .= html_select_end();

  $return .= html_select($selection_name."_month");

  for ($i=1; $i <= 12; $i++) {
 	if ($i == $selected_month) $select="selected";
	else $select="";
	$return .= html_select_option($i,$select,month($i));
  }
  $return .= html_select_end();

  $return .= html_select($selection_name."_year");

  for ($i=2001; $i <= 2004; $i++) {
 	if ($i == $selected_year) $select="selected";
	else $select="";
	$return .= html_select_option($i,$select,$i);
  }
  $return .= html_select_end();

  return($return);

}

function month($number) {
  global $t;

  switch ($number) {
	case '1':	return($t->translate("January"));
	case 2:		return($t->translate("February"));
	case 3:		return($t->translate("March"));
	case 4:		return($t->translate("April"));
	case 5:		return($t->translate("May"));
	case 6:		return($t->translate("June"));
	case 7:		return($t->translate("July"));
	case 8:		return($t->translate("August"));
	case 9:		return($t->translate("September"));
	case 10:	return($t->translate("October"));
	case 11:	return($t->translate("November"));
	case 12:	return($t->translate("December"));
  }
}

function date_to_timestamp($day,$month,$year) {

  if ($day < 10) $day = "0".$day;
  if ($month < 10) $month = "0".$month;

  return($year.$month.$day."120000");

}

function timestamp_to_date($timestamp) {

  $array["year"] = substr($timestamp,0,4);
  $array["month"] = substr($timestamp,4,2);
  $array["day"] = substr($timestamp,6,2);

  return($array);

}

function lib_select_yes_or_no($name,$selected) {

  $return = html_select($name);
  if($selected=="Yes") $select="selected";
  else $select="";
  $return .= html_select_option("Yes",$select,"Yes");
  if($selected=="No") $select="selected";
  else $select="";
  $return .= html_select_option("No",$select,"No");
  $return .=htmlp_select_end();

  return($return);
}

function nlmsg($period) {
  global $db;

  switch ($period) {
    case "weekly":
      $lastday = time() - 7 * 24 * 60 * 60;
      $where = "DATE_FORMAT(software.modification,'%Y-%m-%d')<=\"".date("Y-m-d")."\" AND DATE_FORMAT(software.modification,'%Y-%m-%d')>\"".date("Y-m-d",$lastday)."\"";
      break;
    case "daily":
    default:
      $where = "DATE_FORMAT(software.modification,'%Y-%m-%d')=\"".date("Y-m-d")."\"";
      break;
  }

  $db->query("SELECT *,SUM(app_cnt+homepage_cnt+download_cnt+changelog_cnt+rpm_cnt+deb_cnt+tgz_cnt+cvs_cnt+screenshots_cnt+mailarch_cnt) AS sum_cnt FROM software, counter, auth_user WHERE $where AND software.appid=counter.appid AND software.user=auth_user.username AND software.status='A' GROUP BY software.appid ORDER BY software.modification DESC"); 

  if ($db->num_rows() <= 0) return 0;

  $msg = $GLOBALS["sys_name"]." $period newsletter for ".date("l, dS of F Y, H:i:s T")."\n";
  $msg .= "Number of announcements: ".$db->num_rows()."\n";
  $msg .= "\n               -----------------------------\n";
  $msg .= "                   Annoucements Headlines\n";
  $msg .= "               -----------------------------\n\n";
	
  $i = 1;
  while($db->next_record()) {
    $msg .= "$i: ".$db->f("name")." ".$db->f("version")." ";
    if ($db->f("type") == 'S') $msg .= "(Stable)\n";
    if ($db->f("type") == 'D') $msg .= "(Development)\n";
    $i++;
  }

  $msg .= "\n               -----------------------------\n";
  $msg .= "                   Annoucements Details\n";
  $msg .= "               -----------------------------\n";

//  @mysql_data_seek($result, 0);
  $db->seek(0);

  $i = 1;
  while ($db->next_record()) {
    $timestamp = mktimestamp($db->f("modification"));
    $msg .= "\nAnnouncement : $i\n";
    $msg .= "Name         : ".$db->f("name")."\n";
    $msg .= "Date         : ".date("l, dS of F Y, H:i:s T", $timestamp)."\n";
    $msg .= "Type         : ";
    if ($db->f("type") == 'S') $msg .= "Stable\n";
    if ($db->f("type") == 'D') $msg .= "Development\n";
    $msg .= "Version      : ".$db->f("version")."\n";
    if ($period == "daily") {
      $msg .= "License      : ".$db->f("license")."\n";
      $msg .= "Section      : ".$db->f("section")."\n";
      $msg .= "Category     : ".$db->f("category")."\n";
      $msg .= "Importance   : ".$db->f("sum_cnt")."\n";
      $msg .= "Urgency      : ".urgency($db->f("urgency"))."\n";
      $db_homepage = $db->f("homepage");
      $db_download = $db->f("download");
      $db_changelog = $db->f("changelog");
      $db_rpm = $db->f("rpm");
      $db_deb = $db->f("deb");
      $db_tgz = $db->f("tgz");
      $db_cvs = $db->f("cvs");
      $db_screenshots = $db->f("screenshots");
      $db_mailarch = $db->f("mailarch");
      $db_email = $db->f("email");
      $db_depend = $db->f("depend");
      if (!empty($db_homepage))
	$msg .= "\nHomepage     : ".$db->f("homepage")."\n";
      if (!empty($db_download))
	$msg .= "Download     : ".$db->f("download")."\n";
      if (!empty($db_changelog))
	$msg .= "Changelog    : ".$db->f("changelog")."\n";
      if (!empty($db_rpm))
	$msg .= "RPM Package  : ".$db->f("rpm")."\n";
      if (!empty($db_deb))
	$msg .= "Deb Package  : ".$db->f("deb")."\n";
      if (!empty($db_tgz))
	$msg .= "tgz Package  : ".$db->f("tgz")."\n";
      if (!empty($db_cvs))
	$msg .= "CVS Tree     : ".$db->f("cvs")."\n";
      if (!empty($db_screenshots))
	$msg .= "Screenshots  : ".$db->f("screenshots")."\n";
      if (!empty($db_mailarch))
	$msg .= "Mailing List Archive : ".$db->f("mailarch")."\n";
      $msg .= "\nDescription : \n".wrap($db->f("description"))."\n";
      $msg .= "\nAuthor       : ".$db->f("developer")."\n";
      if (!empty($db_email))
	$msg .= "Email        : ".$db->f("email")."\n";
      if (!empty($db_depend))
	$msg .= "Depens on    : ".$db->f("depend")."\n";
      $msg .= "\n";
    }
    $msg .= $GLOBALS["sys_name"]."   : ".$GLOBALS["sys_url"]."appbyid.php3?id=".$db->f("appid")."\n";
    $msg .= "\n               -----------------------------\n";
    $i++;
  }
  $msg .= "\nYou get this ".$GLOBALS["sys_name"]." $period newsletter,"
  ."\nbecause you have subscribed to the mailing list ";

  switch ($period) {
    case "weekly":
      $msg .= "\n".$GLOBALS["ml_weeklynewstoaddr"]."."
      ."\nTo unsubscribe from this mailing list,"
      ."\nsend a message by email to"
      ."\n".$GLOBALS["ml_weeklynewsreqaddr"]
      ."\nwith \"unsubscribe <password>\" as subject or visit"
      ."\n".$GLOBALS["ml_weeklylisturl"];
      break;
    case "daily":
    default:
      $msg .= "\n".$GLOBALS["ml_newstoaddr"]."."
      ."\nTo unsubscribe from this mailing list,"
      ."\nsend a message by email to"
      ."\n".$GLOBALS["ml_newsreqaddr"]
      ."\nwith \"unsubscribe <password>\" as subject or visit"
      ."\n".$GLOBALS["ml_listurl"];
      break;
  }
  $msg .= "\nand follow the instructions there."
  ."\n\n - ".$GLOBALS["sys_name"]." crew";

  return $msg;
}

function mailuser($perms, $subj, $message) {
  global $t, $db;
  $db->query("SELECT email_usr FROM auth_user WHERE perms LIKE '%$perms%'");
  while($db->next_record()) {
    mail($db->f("email_usr"),"[".$GLOBALS["sys_name"]."] ".$subj,$message,"From: ".$GLOBALS["ml_fromaddr"]."\nReply-To: ".$GLOBALS["ml_replyaddr"]."\nX-Mailer: PHP");
  }
}






#
#  select_lang($selected)
#  Displays the different languages as a select form 
#  $selected ist the SELECTED language
# 

function select_lang($selected) {
  global $db, $la;

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT code,language FROM languages WHERE translation='$la'");
  while($db_local->next_record()) {
    $db_code = $db_local->f("code");
    echo "<option value=\"".$db_code."\"";
    $db_language = $db_local->f("language");
    if ($db_code == $selected) echo " selected";
    echo ">". $db_local->f("language")."\n";
  }
}

#  select_country($selected)
#  Displays the different countries as a select form 
#  $selected ist the SELECTED language
# 

function select_country($selected) {
  global $db, $la;

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT code,description FROM countries WHERE language='$la'");
  while($db_local->next_record()) {
    $db_code = $db_local->f("code");
    echo "<option value=\"".$db_code."\"";
    $db_country = $db_local->f("description");
    if ($db_code == $selected) echo " selected";
    echo ">". $db_local->f("description")."\n";
  }
}



?>
