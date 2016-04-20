<?php include "functions.php"; ?>
<?php initialize(); ?>
<?php head(); ?>
<?php headline(); ?>
<!-- Start your personal editing here and below -->
<?php gatewayInfo(); ?>
<?php systemInfo(); // only working on Linux-systems ?>
<?php repeaterInfo(); ?>
<?php //linksInfo(); //uncomment this or ... ?>
<?php //linksInfo("both"); //... uncomment this for both directions in one table ?>
<?php linksInfo("in"); // uncomment this for incomming links in own table ?>
<?php linksInfo("out"); // uncomment this for outgoing links in own table ?>
<?php remoteControl(); // see comment in ircddblocal.php ?>
<?php //txingInfo(); ?>
<?php //txingInfoAjax(); ?>
<?php //MMDVMTxingInfo(); ?>
<?php MMDVMTxingInfoAjax(); ?>
<?php inQSOInfo(); ?>
<?php lastTransmissionsInfo(); ?>
<?php localTrafficInfo(); ?>
<?php lastHeardInfo(); ?>
<?php lastUsedInfo(); ?>
<?php footer(); ?>
