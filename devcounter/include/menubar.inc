<!-- BerliOS menu -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
<tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
<td ALIGN=CENTER>
<span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo $sys_name?></font></span></td>
</tr>

<tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">

<td>
<?php
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout) ) 
  {
   if ($perm->have_perm("pending") || $perm->have_perm("user") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
     {
      ?>
      <a href="<?php $sess->purl("logout.php") ?>" class="menus"><?php echo $t->translate("Logout"); ?></a>
      <?php
     }
  }
else 
  {
   ?>
   <a href="<?php $sess->purl("login.php") ?>" class="menus"><?php echo $t->translate("Login"); ?></a>
   <?php
  }
?>
<br>
<br><a href="<?php $sess->purl("index.php") ?>" class="menus"><?php echo $t->translate("Index"); ?></a>

<br><a href="<?php $sess->purl("faq.php") ?>" class="menus"><?php echo $t->translate("Q&amp;A"); ?></a>


<br><a href="<?php $sess->purl("register.php") ?>" class="menus"><?php echo $t->translate("New Developer"); ?></a>
<br><a href="<?php $sess->purl("remind.php") ?>" class="menus"><?php echo $t->translate("Forgot Password"); ?></a>
<br><a href="<?php $sess->purl("users.php") ?>" class="menus"><?php echo $t->translate("Developers List"); ?></a>
<br><a href="<?php $sess->purl("req_show.php") ?>" class="menus"><?php echo $t->translate("Show Requests"); ?></a>
<br><a href="<?php $sess->purl("newsletter.php"); ?>" class="menus"><?php echo $t->translate("Newsletter"); ?></a>
<br><a href="<?php $sess->purl("backend.php"); ?>" class="menus"><?php echo $t->translate("Backend"); ?></a>
<br><a href="<?php $sess->purl("stats.php?option=general"); ?>" class="menus"><?php echo $t->translate("Statistics"); ?></a>
</td>
</tr>
</table>
<!-- end BerliOS menu -->

<!-- Personal menu -->
   <table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
   
<?php
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) 
  {
   if ($perm->have_perm("user") || $perm->have_perm("user_pending") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
     {
      ?>
   <tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
   <td ALIGN=CENTER>
   <span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo  $t->translate("Personal Menu");?></font></span></td>
   </tr> 

   <tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">
   <td>

      <a href="<?php $sess->purl("chguser.php") ?>" class="menus"><?php echo $t->translate("My Settings"); ?></a>
      <?php
     }
  }

if (($config_perm_users == "all") || (isset($perm) && $perm->have_perm($config_perm_users)) && !($logout)) 
  {
   ?>
   <?php
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout) ) 
  {
   if ($perm->have_perm("pending") || $perm->have_perm("user") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
     {
      ?>
      <br><a href="<?php $sess->purl("req_manage.php") ?>" class="menus"><?php echo $t->translate("My Requests"); ?></a>
      <br><a href="<?php $sess->purl("req_compose.php") ?>" class="menus"><?php echo $t->translate("Create a new Request"); ?></a>
      <br><a href="<?php $sess->purl("pmess_manage.php") ?>" class="menus"><?php echo $t->translate("personal Messages"); ?></a>
      
     <?php 
     }
  } 
     
     
      ?>
   <br>
   <?php
   if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) 
     {
      if ($perm->have_perm("user") || $perm->have_perm("user_pending") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
        {
	  
	  $uname = $auth->auth["uname"];
   
         $db->query("SELECT * from developers WHERE username='$uname'");
         if ($db->num_rows()==0)
           {
           ?>
           <br><a href="<?php $sess->purl("questionaire.php") ?>" class="menus"><?php echo $t->translate("Enter your Profile"); ?></a>
           <?php   
           }
         else
	       {
           ?>
           <br><a href="<?php $sess->purl("update.php") ?>" class="menus"><?php echo $t->translate("Update your Profile"); ?></a>
           <?php
	       }
        }
        ?>
        <br><a href="<?php $sess->purl("watch.php") ?>" class="menus"><?php echo $t->translate("Developers Watch"); ?></a>
        <?php
     }
?>
   <?php
  }
?>
</td>
</tr>
</table>
<!-- end BerliOS menu -->

<!-- Admin menu -->
<?php
if (
    (($config_perm_admuser == "all") ||
       ($config_perm_admlicens == "all") ||
       ($config_perm_admcomment == "all") ||
       ($config_perm_admsec == "all") ||
       ($config_perm_admcat == "all") ||
       ($config_perm_nladm == "all") ||
       ($config_perm_admfaq == "all") ||
       ($config_perm_admwatch == "all"))
  || (isset($perm) &&
       (($perm->have_perm($config_perm_admuser)) ||
        ($perm->have_perm($config_perm_admlicens)) ||
        ($perm->have_perm($config_perm_admcomment)) ||
        ($perm->have_perm($config_perm_admsec)) ||
        ($perm->have_perm($config_perm_admcat)) ||
        ($perm->have_perm($config_perm_nladm)) ||
        ($perm->have_perm($config_perm_admfaq)) ||
        ($perm->have_perm($config_perm_admwatch))))
  && !($logout)) 
  {

   ?>
   <table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
   <tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
   <td ALIGN=CENTER><img SRC="http://www.berlios.de/images/blank.gif" height="1" width="135" border=0><br>
   <span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo $t->translate("Administration"); ?></font></span></td>
   </tr>
   
   <tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">
   <td>
   <?php

   if (($config_perm_admuser == "all") || (isset($perm) && $perm->have_perm($config_perm_admuser))  && !($logout)) 
     {
      $db->query("SELECT COUNT(*) FROM auth_user");
      $db->next_record();
      echo "<a href=\"".$sess->url("admuser.php")."\" class=\"menus\">".$t->translate("Developers")." [".$db->f("COUNT(*)")."]</a>\n";
      echo "<br><a href=\"".$sess->url("adm_langs_tools.php")."\" class=\"menus\">".$t->translate("Modify ProgLanguages &amp; ProgTools")."</a>\n";
     }

   if (($config_perm_admfaq == "all") || (isset($perm) && $perm->have_perm($config_perm_admfaq))  && !($logout)) 
     {
      $db->query("SELECT COUNT(*) FROM faq WHERE language='$la'");
      $db->next_record();
      echo "<br><a href=\"".$sess->url("admfaq.php")."\" class=\"menus\">".$t->translate("Q&amp;A")." [".$db->f("COUNT(*)")."]</a>\n";
     }

   if (($config_perm_admwatch == "all") || (isset($perm) && $perm->have_perm($config_perm_admwatch))  && !($logout))
     {
      $db->query("SELECT COUNT(*) FROM prog_ability_watch");
      $db->next_record();
      echo "<br><a href=\"".$sess->url("admwatch.php")."\" class=\"menus\">".$t->translate("Developers Watch")." [".$db->f("COUNT(*)")."]</a>\n";
     }

   if (($config_perm_nladm == "all") || (isset($perm) && $perm->have_perm($config_perm_nladm))  && !($logout)) 
     {
 				// Daily Newsletter
      $where = "DATE_FORMAT(developers.creation,'%Y-%m-%d')=\"".date("Y-m-d")."\"";
      $db->query("SELECT COUNT(*) FROM developers WHERE $where"); 
      $db->next_record();
      echo "<br><a href=\"".$sess->url("nladm.php?period=daily")."\" class=\"menus\">".$t->translate("Daily Newsletter")." [".$db->f("COUNT(*)")."]</a>\n";
  				// Weekly Newsletter
      $lastday = time() - 7 * 24 * 60 * 60;
      $where = "DATE_FORMAT(developers.creation,'%Y-%m-%d')<=\"".date("Y-m-d")."\" AND DATE_FORMAT(developers.creation,'%Y-%m-%d')>\"".date("Y-m-d",$lastday)."\"";
      $db->query("SELECT COUNT(*) FROM developers WHERE $where"); 
      $db->next_record();
      echo "<br><a href=\"".$sess->url("nladm.php?period=weekly")."\" class=\"menus\">".$t->translate("Weekly Newsletter")." [".$db->f("COUNT(*)")."]</a>\n";
     }
   ?>
   </td>
   </tr>
   </table>
   <?php
  }
?>
<!-- end Admin menu -->

<!-- Search menu -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
<tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
<td ALIGN=CENTER><img SRC="http://www.berlios.de/images/blank.gif" height="1" width="135" border=0><br>
<span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo $t->translate("Search"); ?></font></span></td>
</tr>

<tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">
<td align=center>
<p>
<?php
htmlp_form_action("devresults.php",array(),"POST");
htmlp_form_hidden("option", "name");
?>
<input TYPE="text" SIZE="10" NAME="search_text" VALUE="">
<?php
echo "<P><input TYPE=\"submit\" VALUE=\"".$t->translate('Search')."\">";
?>
</form>
<p><a href="<?php $sess->purl("searchdev.php") ?>" class="menus"><?php echo $t->translate("Advanced Search"); ?></a>
</td>
</tr>
</table>
<!-- end Search menu -->

<!-- Language menu -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
<tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
<td ALIGN=CENTER><img SRC="http://www.berlios.de/images/blank.gif" height="1" width="135" border=0><br>
<span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo $t->translate("Language");?></font></span></td>
</tr>

<tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">
<td align=center>
<p>
<form action="<?php $sess->pself_url()?>">
<?php
while (is_array($HTTP_GET_VARS) 
		&& list($key, $val) = each($HTTP_GET_VARS)) {
	if ($key != "lang" && $key != "go") {
		echo "<input TYPE=\"hidden\" NAME=\"$key\" VALUE=\"$val\">\n";
	}
}
?>
<select name="lang" size=1>
<?php
while (list(, $ln) = each($la_array)) {
	if ($la == $ln) {
		$sel = "selected";
	} else {
		$sel ="";
	}
	echo "<option value=\"$ln\" $sel>".$t->translate($ln)."\n";
}
?>
</select>
<?php
echo "<P><input TYPE=\"submit\" NAME=\"go\" VALUE=\"".$t->translate("Go")."\">";
?>
</form>
</td>
</tr>
</table>
<?php
if (ereg("Gecko", "$HTTP_USER_AGENT")) {
	echo "<p align=center><a href=\"javascript:addNetscapePanel();\"><img SRC=\"images/add-button.gif\" BORDER=0 height=45 width=100></a>\n";
}
echo "<p align=\"center\"><a href=\"http://developer.berlios.de\">
<img src=\"http://developer.berlios.de/bslogot.php?group_id=175&type=1\" width=\"124\" height=\"32\" border=\"0\" hspace=\"3\" vspace=\"3\" alt=\"BerliOS Logo\"><br>Developer</a>\n";
?>
<!-- end Language menu -->
