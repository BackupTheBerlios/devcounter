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
# Security and Access control library
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
######################################################################


		// allowed_actions is a function used
		// in the summary page

function allowed_actions ($project_status, $action_number, $proid) {

  $db_allowed = new DB_DevCounter;

  switch($action_number) {
	case 1: 	$link = "step1.php3?proid=".$proid;
			$text = "Consultancy";
			$db_allowed->query("SELECT COUNT(*) FROM consultants WHERE proid='$proid'");
			$db_allowed->next_record();
			$statistics = "( <B>".$db_allowed->f("COUNT(*)")."</B> consultant offerings)";
			$explanation = "Help for sponsors on making a propper project submission.";
			break;
	case 2: 	$link = "step2.php3?proid=".$proid;
			$text = "Technical Specifications";
					// Sponsor Involvement
			$db_allowed->query("SELECT COUNT(*) FROM tech_content WHERE proid='$proid'");
			$db_allowed->next_record();
			$statistics = "( <B>".$db_allowed->f("COUNT(*)")."</B> suggested project contents";
			$db_allowed->query("SELECT COUNT(*) FROM developing WHERE proid='$proid'");
			$db_allowed->next_record();
			$statistics .= ", <B>".$db_allowed->f("COUNT(*)")."</B> developing proposals )";
			$explanation = "This project may have different specifications. Developers can make their developing proposals to that specifications.";
			break;
	case 3:	 	$link = "step3.php3?proid=".$proid;
			$text = "Milestones";
			$db_allowed->query("SELECT COUNT(*) FROM milestones WHERE proid='$proid'");
			$db_allowed->next_record();
			$statistics = "( <B>".$db_allowed->f("COUNT(*)")."</B> suggested milestones )";
			$db_allowed->query("SELECT COUNT(*) FROM milestones WHERE proid='$proid'");
			$explanation = "Project milestones proposed by developers.";
			break;
	case 4: 	$link = "step4.php3?proid=".$proid;
			$text = "Referees";
			$db_allowed->query("SELECT COUNT(*) FROM referees WHERE proid='$proid'");
			$db_allowed->next_record();
			$statistics = "( <B>".$db_allowed->f("COUNT(*)")."</B> referees offered )";
			$explanation = "Developers can propose themselves as referees. Sponsors and developers will elect one of them.";
			break;
	case 5: 	$link = "step5.php3?proid=".$proid;
			$text = "Project Follow-up";
			$statistics = "( <B>x</B> milestones of <b>x</b> total milestones fulfilled )";
			$explanation = "Milestone delivery and other tasks related to the project follow-up.";
			break;
	case 6: 	$link = "step6.php3?proid=".$proid;
			$text = "Rating";
			$statistics = "";
			$explanation = "Final rating between sponsors and developers.";
			break;
  }


  if ($action_number > 1) print "<hr>\n";
  if ($project_status >= $action_number) print "<a href=\"$link\">";
  else print "<font color=\"#CCCCCC\">";
  print "<IMG src=\"images/ic/".$action_number;
  if ($project_status < $action_number) print "grey";
  print ".png\" border=0 width=\"48\" height=\"48\" alt=\"1\">";
  print "&nbsp;".$text;
  if ($project_status >= $action_number) print "</a>";
  else print "</font>";
  if ($project_status >= $action_number) print " ".$statistics;
  print "<br>";
  print "<i>".$explanation."</i>";
  print "\n";
}

function check_proid ($proid) {

  $db_check = new DB_DevCounter;

  $db_check->query("SELECT * FROM description WHERE proid='$proid'"); 
  $db_check->next_record();
  if ($db_check->num_rows() == 0 || empty($proid) || $db_check->f("status") == 0) {
	// FIXME - FIXME - FIXME
	require("config.inc");
	$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
	$be->box_full("Error", "No project id or project pending");
	return 0;
  } else {
    return 1;
  }
}

function check_permission($proid,$page) {
  global $perm, $auth;

  $db_check = new DB_DevCounter;

  $db_check->query("SELECT * FROM description WHERE proid='$proid'"); 
  $db_check->next_record();

  $project_initiator = $db_check->f("description_user");
  $current_step = $db_check->f("status");

  if ($db_check->num_rows() == 0 || empty($proid) || $db_check->f("status") == 0) {
	if (!strcmp($db_check->f("description_user"),$auth->auth["uname"])) {
		// FIXME - FIXME - FIXME
		require("config.inc");
		$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
		$be->box_full("Error", "No project id or project pending");
		return 0;
	} else {
		require("config.inc");
		$be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);
		$be->box_full("Error", "You're the project owner, but I haven't done this part yet.");
		return 0;		
	}
  } else {
	switch($page) {
		case "configure":
		case "news":
		case "news_edit":
		case "comments_edit":
		case "history":
		case "step3":
		case "step4":
		case "step5":
		case "cooperation":
		case "views":
			if (security_accept_by_view($proid,$page)) return 1;
			else return permission_denied();
		case "configure_edit":
			if (is_roject_initiator($proid)) return 1;
			else return permission_denied();
		case "views_edit":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied(); 	
		case "monitor":
			if (is_accepted_sponsor($proid) || is_accepted_developer($proid)) return 1;
			else return permission_denied();
		case "monitor_edit":
			if (is_sponsor() || is_developer()) return 1;
			else return permission_denied();
		case "summary":
			break;
		case "news_mod":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied();
			break;
		case "comments":
			break;
		case "comments_mod":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied();
			break;
		case "sponsoring":
			break;
		case "sponsoring_edit":
			if (is_sponsor()) {
				if (!already_involved_in_this_step($proid,"sponsoring_edit",$auth->auth["uname"])) return 1;
				else return already_involved_message();
			} else return permission_denied();
			break;
		case "sponsoring_mod":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied();
			break;
		case "step1":
			break;
		case "step1_edit":
			if (is_developer()) {
				if ($current_step == 1) {;
					if (!already_involved_in_this_step($proid,"step1_edit",$auth->auth["uname"])) return 1;
					else return already_involved_message();
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step2":
			break;
		case "step2_edit":
			if (is_developer() || is_project_initiator($proid)) { 
				if ($current_step == 2) return 1;
				else return step_not_open();
			} else return permission_denied();
			break;
		case "developing_edit":
			if (is_developer()) { 
				if ($current_step == 2) {
					if (!already_involved_in_this_content($proid,"developing_edit",$auth->auth["uname"],$GLOBALS["content_id"])) return 1;
					return already_involved_message();
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "developing_mod":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied();
			break;
		case "step3_edit":
			if (is_developer()) { 
				if ($current_step == 3) {
					if (is_involved_developer($proid)) return 1;
					else return permission_denied();
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step3_mod":
			if (is_project_initiator($proid)) return 1;
			else return permission_denied();
			break;
		case "step4_edit":
			if (is_developer()) { 
				if ($current_step == 4) {
					if (!already_involved_in_this_step($proid,"step4_edit",$auth->auth["uname"])) return 1;
					return already_involved_message();
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step5_devel":
			if (is_involved_developer($proid)) { 
				if ($current_step == 5) {
					if (step5_iteration($proid) == 0) return 1;
					else return step5_not_your_iteration($proid);
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step5_referee":
			if (is_accepted_referee($proid)) { 
				if ($current_step == 5) {
					if (step5_iteration($proid) == 1) return 1;
					else return step5_not_your_iteration($proid);
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step5_sponsor":
			if (is_accepted_sponsor($proid)) { 
				if ($current_step == 5) {
					if (step5_iteration($proid) > 1) return 1;
					else return step5_not_your_iteration($proid);
				} else return step_not_open();
			} else return permission_denied();
			break;
		case "step6":
			break;
		case "step6_edit":
			if (is_accepted_developer($proid) || is_accepted_sponsor($proid)) return 1;
			else return permission_denied();
			break;
		case "decisions":
			if (is_accepted_sponsor($proid)) return 1;
			else return permission_denied();
			break;
		case "personal":
			if ($username == $auth->auth["uname"]) return 1;
			else return permission_denied();
			break;
		case "sponsoring_accepted":
			if (is_accepted_sponsor($proid)) return 1;
			else return permission_denied();
			break;
		case "cooperation_edit":
			if (is_developer()) return 1;
			else return permission_denied();
			break;
	}
    	return 1;
  }
}

function permission_denied() {

  require("config.inc");

  $be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

  $be->box_full("Permission denied", "You do not have rights to enter this page.");
  return 0;	
}

function step_not_open() {

  require("config.inc");

  $be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

  $be->box_full("Permission denied", "This action can only be made at its time.");
  return 0;	
}

function is_project_initiator($proid) {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM description WHERE proid='$proid' AND description_user='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_sponsor() {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM auth_user WHERE perms='sponsor' AND username='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_accepted_sponsor($proid) {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM sponsoring WHERE proid='$proid' AND status='A' AND sponsor='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_accepted_referee($proid) {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM referees WHERE proid='$proid' AND status='A' AND referee='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_developer() {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM auth_user WHERE perms='devel' AND username='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_involved_developer($proid) {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM developing WHERE proid='$proid' AND developer='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function is_accepted_developer($proid) {
  global $auth;

  $db_local = new DB_DevCounter;

  if (isset($auth) && !empty($auth->auth["perm"])) { 
	$db_local->query("SELECT * FROM developing WHERE proid='$proid' AND status='A' AND developer='".$auth->auth["uname"]."'");
	if ($db_local->num_rows() > 0) return 1;
  }
  return 0;
}

function already_involved_in_this_step($proid,$page,$username) {

  switch ($page) {
	case "sponsoring_edit": 	$table = "sponsoring"; $who = "sponsor"; break;
	case "step1_edit": 		$table = "consultants"; $who = "consultant"; break;
	case "developing_edit": 	$table = "developing"; $who = "developer"; break;
	case "step4_edit": 		$table = "referees"; $who = "referee"; break;
  }

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT * FROM $table WHERE proid='$proid' AND $who='$username'");
  if ($db_local->num_rows() > 0) return 1;
  else return 0;
}

function already_involved_in_this_content($proid,$page,$username,$content_id) {

  	$db_local = new DB_DevCounter;
  	$db_local->query("SELECT * FROM developing WHERE proid='$proid' AND developer='$username' AND content_id='$content_id'");
  	if ($db_local->num_rows() > 0) return 1;
  	else return 0;
}

function already_involved_message() {

  require("config.inc");

  $be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

  $be->box_full("Permission denied", "You already have bla, bla, bla... If you want, you can modify it.");
  return 0;
}


function security_accept_by_view($proid,$page) {
  global $auth;

  if ($page=="news_edit" || $page=="news_mod") $page="news";

  $db_local = new DB_DevCounter;
  $db_local->query("SELECT $page FROM views WHERE proid='$proid'");
  $db_local->next_record();

  switch ($db_local->f($page)) {
	case "Everybody":
		return 1; break;
	case "Registered":
		if (isset($auth) && !empty($auth)) return 1;
	case "Developers":
		if (is_developer() || is_accepted_sponsor($proid)) return 1;
		else return 0;
	case "Sponsors":  
		if (is_sponsor() || is_involved_developer($proid)) return 1;
		else return 0;
	case "Project Participants": 
 		if (is_involved_developer($proid) || is_accepted_sponsor($proid)) return 1;
		else return 0;
	case "Project Developers":
		if (is_involved_developer($proid)) return 1;
		else return 0;
	case "Project Sponsors":
		if (is_accepted_sponsor($proid)) return 1;
		echo "hola";
	case "Project Initiator":
		if (is_project_initiator($proid)) return 1;
		else return 0;
	default:
		return 0;
  }
}

function step5_iteration($proid) {

	$db_local = new DB_DevCounter;
	$db_local->query("SELECT iteration FROM follow_up WHERE proid='$proid'");
	if ($db_local->num_rows() == 0) return 0;
	else {
		$db_local->next_record();
		return $db_local->f("iteration");
	}
}

function step5_not_your_iteration($proid) {

  require("config.inc");

  $be = new box("",$th_box_frame_color,$th_box_frame_width,$th_box_title_bgcolor,$th_box_title_font_color,$th_box_title_align,$th_box_body_bgcolor,$th_box_error_font_color,$th_box_body_align);

  switch (step5_iteration($proid)) {
	case '0':
		$message = "The milestone has not been posted by the developer";
		break;
	case '1':
		$message = "The milestone has been posted. The referee is studying whether to accept it or not.";
		break;
	case '2':
		$message = "The milestone has been posted. Sponsors are studying whether to accept it or not.";
		break;
	case '3':
		$message = "Sponsors are deciding what to do";
		break;
  }
		
  $be->box_full("Not your turn", $message);
  return 0;
}
?>
