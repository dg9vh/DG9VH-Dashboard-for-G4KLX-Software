<?php
// enter exact path to your log files.
// If your Linux is a MARYLAND-DSTAR-Image, this paths would work.

// Adjust to suit, uncomment correct line, if no line is uncommented, customize
// else-path to suitable paths.

define("DISTRIBUTION","MARYLAND");
//define("DISTRIBUTION","WESTERN");
//define("DISTRIBUTION","DL5DI_DEBIAN");
//define("DISTRIBUTION","DL5DI_CENTOS");
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
	case "DL5DI_CENTOS":
// Configuration for DL5DI-Installation-packages on CENTOS
		define("LOGPATH", "/var/log/dstar");
		define("CONFIGPATH", "/etc");
	        define("DSTARREPEATERLOGPATH", LOGPATH. "/");
	        define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
	        define("LINKLOGPATH", LOGPATH . "/Links.log");
	        define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI_DEBIAN":
// Configuration for DL5DI-Installation-packages on DEBIAN
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

// set to true, if GPS-position of gateway should be shown on google maps, 
// false else
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

// set to true, if you want to anonymize all personal data of others than you
define("ANONYMIZE", false);

// set the anonymizer-salt if ANONYMIZE is true
define("ANONSALT", "X");

// set the path for the tempfiles, if you are using a ramdisk (recommended), put
// in here the path to it, else use /tmp
// to create a ramdisk of 1 Megabyte (would be enougth), use for example:
// sudo mkdir /mnt/ramdisk
// mount -t tmpfs -o size=1m tmpfs /mnt/ramdisk
// vi /etc/fstab
// add following line:
// tmpfs       /mnt/ramdisk tmpfs   nodev,nosuid,noexec,nodiratime,size=1M   0 0

// Edit this value
$temppath = "/mnt/ramdisk";

if (file_exists($temppath))
	define("TMPPATH", $temppath);
else
	define("TMPPATH", "/tmp");

// set to true, if CPU-Tempwarnings should be alerted
define("TEMPERATUREALERT",true);

// set the temperature to alert above
define("TEMPERATUREHIGHLEVEL", 60);
?>
