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
# How to translate
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: translating.php,v 1.3 2002/09/16 18:39:27 helix Exp $
#
######################################################################  

require("./include/header.inc");
?>

<!-- content -->

<A NAME="international"></A>
<P><H2>International support</H2>

<P>DevCounter can be easily translated into different languages. If you see that DevCounter does not have support in your language, you're invited to help us with the internationalization of DevCounter by sending us your translation.

<P>You don't need to have any computer or programming experience to do a translation. Keep on reading and you'll find out how easy it is.

<A NAME="normal_outputs"></A>
<P><H3>1. Main outputs</H3>

<P>Download the <A HREF="../include/German-lang.inc">German-lang.inc</A> file (it also comes in DevCounter's tarball). If you edit it, you'll find lines like this:

<PRE>
     case "Home": $tmp = ""; break;
</PRE>

<P>We will explain it briefly: after the <I>case</I> you will see the English text to translate written in quotes (in our example, the English text is "Home"). Then you'll find a sort of equation. The content of your translation from English into your language should be placed in between these second quotes. For example, in the case you were making a translation into German, this would be the result for this line:

<PRE>
     case "Home": $tmp = "Heim"; break;
</PRE>

<P>Ok, now that you're an expert, you'll notice that "Home" is translated into German as "Heim" ;-). The procedure just explained should be repeated with all the lines in this file. 

<P>Once you're finished, save it as <I>YourLanguage-lang.inc</I> and please send it to the authors. We will include it in the next releases so that everybody can benefit of your work.

<A NAME="contributors"></A>
<P><H3>2. Contributors</H3>

<P>Here's a list of all the people that have contributed to the translation of DevCounter.

<P>Main files:

<CENTER>
<TABLE width=95%>
<TR><TD>Language</TD><TD>Translator</TD><TD>Version</TD><TD>Last Modified</TD></TR>
<TR><TD>German</TD><TD>Lutz Henckel &lt;<A
HREF="mailto:lutz.henckel@fokus.gmd.de">lutz.henckel@fokus.fhg.de</A>&gt;</TD><TD>0.1</TD><TD>3
April 2002</TD></TR>
</TABLE></CENTER>

<P>&nbsp;

<!-- end content -->

<?php
require("./include/footer.inc");
?>
