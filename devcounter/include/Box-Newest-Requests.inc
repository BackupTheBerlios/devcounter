<?php

$bx->box_begin();
$bx->box_title(html_link("req_show.php","","<B>".$t->translate("Newest Requests")."</B>"));
$bx->box_body_begin();

$db->query("SELECT * FROM requests ORDER BY reqtime DESC LIMIT 0,10");

while ($db->next_record()) {
	$reqsubject = $db->f("reqsubject");
	$reqid = $db->f("reqid");
	echo "<div class=newsind>&#149;&nbsp;";
	$pquery["reqid"] = $reqid ;
	htmlp_link("req_show.php",$pquery,$reqsubject);
	echo " (".$db->f("username").")";
	$timestamp = mktimestamp($db->f("reqtime"));
	echo "\n<br>[".timestr_short($timestamp)."]</div>\n";
}

$bx->box_body_end();
$bx->box_end();


?>
