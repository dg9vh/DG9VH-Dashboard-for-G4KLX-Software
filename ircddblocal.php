<?php
// enter exact path to your log files.
// If your Linux is a MARYLAND-DSTAR-Image, this paths would work.

// Adjust to suit, uncomment correct line, if no line is uncommented, customize
// else-path to suitable paths.

define("DISTRIBUTION","MARYLAND");
//define("DISTRIBUTION","WESTERN");

define("LOGPATH", "/var/log");

if (DISTRIBUTION == "MARYLAND") {
// Configuration for Maryland-Dstar-Image
	define("CONFIGPATH", "/etc/gateway");
	define("DSTARREPEATERLOGPATH", LOGPATH. "/dstarrepeater_1");
	define("DSTARREPEATERLOGFILENAME", "DStarRepeater_Repeater-1-");
	define("LINKLOGPATH", LOGPATH . "/gateway/Links.log");
	define("HRDLOGPATH", LOGPATH . "/gateway/Headers.log");
} else {
// Configuration for Western-Dstar-Image or all others, please customize
// if necessary
	define("CONFIGPATH", "/etc");
	define("DSTARREPEATERLOGPATH", LOGPATH. "/");
	define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
	define("LINKLOGPATH", LOGPATH . "/Links.log");
	define("HRDLOGPATH", LOGPATH . "/Headers.log");
}

define("CONFIGFILENAME","ircddbgateway");
define("GATEWAYCONFIGPATH", CONFIGPATH."/".CONFIGFILENAME);

// enter your Contact-E-Mail-Address to be shown at page
define("EMAILADDRESS", "dg9vh@darc.de");

// set to true, if E-Mail-Address should be shown, false else
define("SHOWEMAILADDRESS", true);

// set to true, if E-Mail-Address should be shown, false else
define("SHOWGATEWAYPOSITION", true);

// set to true, if APRS.fi-links should be shown, false else
define("SHOWAPRS", true);

// set to true, if QRZ.com-links should be shown, false else
define("SHOWQRZ", true);

// set to your individual refesh-time of "current-TX-infobox"
// time is given in ms - so 1 second = 1000 ms, default: 1000
define("RELOADTIMEINMS","1000");
?>
