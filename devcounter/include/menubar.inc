<!-- BerliOS menu -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH="100%">
<tr BGCOLOR="<?php echo $th_navstrip_bgcolor;?>">
<td ALIGN=CENTER>
<span class="titlebar"><font color="<?php echo $th_navstrip_font_color;?>"><?php echo $sys_name?></font></span></td>
</tr>

<tr ALIGN=RIGHT BGCOLOR="<?php echo $th_nav_bgcolor;?>">
<td><a href="<?php $sess->purl("index.php3") ?>" class="menus"><?php echo $t->translate("Index"); ?></a>
<br><a href="<?php $sess->purl("faq.php3") ?>" class="menus"><?php echo $t->translate("Q&amp;A"); ?></a>

<br>
<?php
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout) ) 
  {
   if ($perm->have_perm("pending") || $perm->have_perm("user") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
     {
      ?>
      <br><a href="<?php $sess->purl("logout.php3") ?>" class="menus"><?php echo $t->translate("Logout"); ?></a>
      <?php
     }
  } 
else 
  {
   ?>
   <br><a href="<?php $sess->purl("login.php3") ?>" class="menus"><?php echo $t->translate("Login"); ?></a>
   <?php
  }
?>
<br><a href="<?php $sess->purl("register.php3") ?>" class="menus"><?php echo $t->translate("New Developer"); ?></a>
<br><a href="<?php $sess->purl("remind.php3") ?>" class="menus"><?php echo $t->translate("Forgot Password"); ?></a>
<?php
if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) 
  {
   if ($perm->have_perm("user") || $perm->have_perm("user_pending") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
     {
      ?>
      <br><a href="<?php $sess->purl("chguser.php3") ?>" class="menus"><?php echo $t->translate("Change Developer"); ?></a>
      <?php
     }
  }

if (($config_perm_users == "all") || (isset($perm) && $perm->have_perm($config_perm_users)) && !($logout)) 
  {
   ?>
   <br><a href="<?php $sess->purl("users.php3") ?>" class="menus"><?php echo $t->translate("Developers"); ?></a>

   <br>
   <?php
   if (isset($auth) && !empty($auth->auth["perm"]) && !($logout)) 
     {
      if ($perm->have_perm("user") || $perm->have_perm("user_pending") || $perm->have_perm("editor") || $perm->have_perm("admin")) 
        {
         ?>
         <!--<br><a href="<?php $sess->purl("insform.php3") ?>" class="menus"><?php echo $t->translate("New Profile"); ?></a>
         <br><a href="<?php $sess->purl("devbyuser.php3") ?>" class="menus"><?php echo $t->translate("Update Profile"); ?></a>
         <br><a href="<?php $sess->purl("newsletter.php3"); ?>" class="menus"><?php echo $t->translate("Newsletter"); ?></a>-->
         <?php
	 $username = $auth->auth["uname"];
   
         $db->query("SELECT * from developers WHERE username='$username'");
         if ($db->num_rows() ==0)
           {
            echo "<BR>\n";
	    htmlp_link("questionaire.php3","",$t->translate("Enter your Profile"));	    
           }
         else
	   {
            echo "<BR>\n";
	    htmlp_link("update.php3","",$t->translate("Update your Profile"));	    
	    
	   }
        }
     }
   ?>
   <!--<br><a href="<?php $sess->purl("backend.php3"); ?>" class="menus"><?php echo $t->translate("Backend"); ?></a>-->
   <br><a href="<?php $sess->purl("stats.php3?option=general"); ?>" class="menus"><?php echo $t->translate("Statistics"); ?></a>
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
       ($config_perm_admfaq == "all"))
  || (isset($perm) &&
       (($perm->have_perm($config_perm_admuser)) ||
        ($perm->have_perm($config_perm_admlicens)) ||
        ($perm->have_perm($config_perm_admcomment)) ||
        ($perm->have_perm($config_perm_admsec)) ||
        ($perm->have_perm($config_perm_admcat)) ||
        ($perm->have_perm($config_perm_nladm)) ||
        ($perm->have_perm($config_perm_admfaq)) ))
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
      echo "<a href=\"".$sess->url("admuser.php3")."\" class=\"menus\">".$t->translate("Developers")." [".$db->f("COUNT(*)")."]</a>\n";
      echo "<BR><a href=\"".$sess->url("adm_langs_tools.php3")."\" class=\"menus\">".$t->translate("Modify ProgLanguages &amp; ProgTools")."</a>\n";
     }

   if (($config_perm_admfaq == "all") || (isset($perm) && $perm->have_perm($config_perm_admfaq))  && !($logout)) 
     {
      $db->query("SELECT COUNT(*) FROM faq WHERE language='$la'");
      $db->next_record();
      echo "<br><a href=\"".$sess->url("admfaq.php3")."\" class=\"menus\">".$t->translate("Q&amp;A")." [".$db->f("COUNT(*)")."]</a>\n";
     }

   if (($config_perm_nladm == "all") || (isset($perm) && $perm->have_perm($config_perm_nladm))  && !($logout)) 
     {
 				// Daily Newsletter
      /*$where = "DATE_FORMAT(developers.creation,'%Y-%m-%d')=\"".date("Y-m-d")."\"";
      echo "<br><a href=\"".$sess->url("nladm.php3?period=daily")."\" class=\"menus\">".$t->translate("Daily Newsletter")." [".$db->f("COUNT(*)")."]</a>\n";
  				// Weekly Newsletter
      $lastday = time() - 7 * 24 * 60 * 60;
      $where = "DATE_FORMAT(developers.creation,'%Y-%m-%d')<=\"".date("Y-m-d")."\" AND DATE_FORMAT(developerss.creation,'%Y-%m-%d')>\"".date("Y-m-d",$lastday)."\"";
      echo "<br><a href=\"".$sess->url("nladm.php3?period=weekly")."\" class=\"menus\">".$t->translate("Weekly Newsletter")." [".$db->f("COUNT(*)")."]</a>\n";*/
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
htmlp_form_action("devresults.php3",array(),"POST");
htmlp_form_hidden("option", "name");
?>
<input TYPE="text" SIZE="10" NAME="search_text" VALUE="">
<?php
echo "<P><input TYPE=\"submit\" VALUE=\"".$t->translate('Search')."\">";
?>
</form>
<p><a href="<?php $sess->purl("searchdev.php3") ?>" class="menus"><?php echo $t->translate("Advanced Search"); ?></a>
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
<!-- end Language menu -->

