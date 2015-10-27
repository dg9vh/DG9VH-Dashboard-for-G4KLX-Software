<?php
// enter exact path to your log files.
// If your Linux is a MARYLAND-DSTAR-Image, this paths would work.

// Adjust to suit, uncomment correct line, if no line is uncommented, customize
// else-path to suitable paths.

define("DISTRIBUTION","MARYLAND");
//define("DISTRIBUTION","WESTERN");
//define("DISTRIBUTION","DL5DI");
//define("DISTRIBUTION","OTHER");

switch (DISTRIBUTION) {
	case "MARYLAND":
// Configuration for Maryland-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc/gateway");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/dstarrepeater_1");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater_Repeater-1-");
		define("LINKLOGPATH", LOGPATH . "/gateway/Links.log");
		define("HRDLOGPATH", LOGPATH . "/gateway/Headers.log");
		break;
	case "WESTERN":
// Configuration for Western-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI":
// Configuration for DL5DI-Installation-packages
		define("LOGPATH", "/var/log/opendv");
		define("CONFIGPATH", "/home/opendv/ircddbgateway");
	        define("DSTARREPEATERLOGPATH", LOGPATH. "/");
	        define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
	        define("LINKLOGPATH", LOGPATH . "/Links.log");
	        define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "OTHER":
// Configuration for all others, please customize
// if necessary
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
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

// set to true, if progress-bars should be shown, false else
define("SHOWPROGRESSBARS", true);

// set to your individual refesh-time of "current-TX-infobox"
// time is given in ms - so 1 second = 1000 ms, default: 1000
define("RELOADTIMEINMS","1000");

// set to true if you want to reload page after txing, false else
// only works with AJAX-Version of current-TX
define("RELOADAFTERTX", true);

// set to your remote-password
// if you want to use this feature, you have also to add following line
// into /etc/sudoers:
// www-data ALL=(ALL) NOPASSWD: ALL
define("REMOTECONTROLPASSWD","mypass");

// edit your preset-link-targets, first value = name, second value = URCALL
// feel free to add as many targets as you like
$presettargets = array(
	"Deutschland"=>"DCS001 C",
	"Deutschland REF"=>"REF006 C",
	"USA REF"=>"REF001 C",
	"Saarland"=>"DCS002 S",
	"XRF262"=>"XRF262 A",
	"Echo"=>"DCS001 Z",
);
?>
