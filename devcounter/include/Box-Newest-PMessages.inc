<?php

if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) 
  {
   $username = $auth->auth["uname"];
   $bx->box_begin();
   $bx->box_title(html_link("pmess_manage.php","","<B>".$t->translate("My Latest Personal Messages")."</B>"));
   $bx->box_body_begin();

   $db->query("SELECT * FROM pmessages WHERE pmessto='$username' ORDER BY pmesstime DESC LIMIT 0,10");
   if ($db->num_rows()==0)
     {
      echo $t->translate("no personal messages");
     }
   else
   {


      while ($db->next_record()) 
        {
         $pmesssubject = $db->f("pmesssubject");
         $pmessid = $db->f("pmessid");
         echo "<div class=newsind>&#149;&nbsp;";
         $pquery["pmessid"] = $pmessid ;
         htmlp_link("pmess_show.php",$pquery,$pmesssubject);
         echo " (".ereg_replace ("mailto:","", $db->f("pmessfrom")).")";
         $timestamp = mktimestamp($db->f("pmesstime"));
         echo "\n<br>[".timestr_short($timestamp)."]</div>\n";
        }   
      $bx->box_body_end();
     }

   $bx->box_end();

  }


?>
