<?php

######################################################################
# DevCounter: Open Source Developer Counter
# ================================================
#
# Copyright (c) 2001-2002 by
#       Gregorio Robles (grex@scouts-es.org)
#       Lutz Henckel (lutz.henckel@fokus.fraunhofer.de)
#       Stefan Heinze (heinze@fokus.fraunhofer.de)
#
# BerliOS DevCounter: http://devcounter.berlios.de
# BerliOS - The OpenSource Mediator: http://www.berlios.de
#
# The DocsWell page for developers
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 or later of the GPL.
#
# $Id: development.php,v 1.3 2003/11/12 14:18:09 helix Exp $
#
######################################################################  

require("./include/header.inc");
?>

<!-- content -->

<P><H2>For developers</H2>

<P>DevCounter is Open Source, so you're invited to contribute to it.

<P>DevCounter queries open source developers for their knowledge and experiences as well as their cooperation in open source projects, but maybe you're interested in adapting DevCounter for querying other kind of people. Or maybe you want to improve DevCounter adding features or correcting errors. If one of these is your case, keeping on reading will be of interest for you.

<P>Note: For developing or modifying DevCounter, <A HREF="http://www.php.net">PHP</A> knowledge is needed. You should also have certain SQL experience if you want to handle with databases.

<P>Please report to the <A HREF="authors.php">authors</A> any adaptions and/or modifications. This could help us knowing what DevCounter should implement in the future and making other DevCounter users benefit from your work.

<P>For advanced uses, <A HREF="http://sourceforge.net/projects/phplib/">PHPLib</A> should also be known. You can read about PHPLib's API in PHPLib's manual. At this moment, PHPLib is used only for sessions and authentication. If you aren't going to work with them, you don't need to have a look at PHPLib.

<P>&nbsp;

<!-- end content -->

<?php
require("./include/footer.inc");
?>
