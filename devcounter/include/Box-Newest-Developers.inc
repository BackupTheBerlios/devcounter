<?php

$bx->box_begin();
$bx->box_title(html_link("users.php","","<B>".$t->translate("Newest Developers")."</B>"));
$bx->box_body_begin();

$db->query("SELECT * FROM auth_user,developers,extra_perms where auth_user.username=developers.username AND auth_user.username=extra_perms.username ORDER BY developers.creation DESC LIMIT 0,10");

while ($db->next_record()) 
  {
   $user_name = $db->f("username");
   echo "<div class=newsind>&#149;&nbsp;";
   $rquery["devname"] = $user_name ;
   htmlp_link("showprofile.php",$rquery,$user_name);
   if ($db->f("showname") == "yes")
      echo " (".$db->f("realname").")";
   $timestamp = mktimestamp($db->f("creation"));
   echo "\n<br>[".timestr_short($timestamp)."]</div>\n";
  }

$bx->box_body_end();
$bx->box_end();


?>
