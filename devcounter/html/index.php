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
# The DevCounter Project Page
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: index.php,v 1.3 2002/09/16 18:39:27 helix Exp $
#
######################################################################  

require("./include/header.inc");
?>

<!-- content -->

<P><H2>DevCounter</H2>

<P>DevCounter queries open source developers for their knowledge and experiences as well as their cooperation in open source projects.

<P>It is based in <A HREF="http://sourceforge.net/projects/phplib/">PHP</A> and uses <A HREF="http://www.mysql.com">MySQL</A> as its database system. DevCounter depends on
the <A HREF="http://sourceforge.net/projects/phplib/">PHPLib library</A> (version 7.2 or
later). Future versions may have database independence, but this is
not yet supported. We are still working on it. Only if you want to have
diary and weekly mailing lists with the announcements, you should also have
Mailman installed in your box.

<P>You can see a fully working example of the DevCounter system at BerliOS
DevCounter by visiting <A HREF="http://devcounter.berlios.de">http://devcounter.berlios.de</A>. A close look at it will show you what
you can do with DevCounter.

<P>BerliOS DevCounter is part of the BerliOS project at FOKUS. Please, have
a look at <A HREF="http://www.berlios.de">http://www.berlios.de</A> for further information.

<P>DevCounter can be easily translated into different
languages. If you see that DevCounter does not have support in your
language, you're invited to <A HREF="translating.php">help us with the
internationalization</A> of DevCounter by sending us your translation.

<P>You can download the latest version of DevCounter (sources and documentation) at:
<A HREF="http://developer.berlios.de/projects/devcounter">http://developer.berlios.de/projects/devcounter</A>

<P>DevCounter Features:
<UL>
<LI>Different type of users (nonauthorized users, users and
administrators) with different functions
<LI>Advanced configurability from a single file
<LI>Simple, intuitive use of the system
<LI>Session management with and without cookies
<LI>Through-the-web administration of faq, developers, programming languages/tools and abilities
<LI>"true" counter for developer hits.
<LI>Multilingual support
<LI>XML Backend (RDF-document format)
<LI>Daily and Weekly automatic Newsletters
<LI>FAQ
<LI>EMail advice for administrators when new users are registered
<LI>Graphical statistics
<LI>Web browser independence
<LI>Cache avoidance
</UL>

<P>&nbsp;

<!-- end content -->

<?php
require("./include/footer.inc");
?>
