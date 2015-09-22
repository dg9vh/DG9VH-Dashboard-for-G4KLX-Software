<?php include "ircddblocal.php"; ?>
<?php
$progname = "DG9VH - Dashboard for G4KLX ircddb-Gateway";
$MYCALL;
$configs = array();

function format_time($seconds) {
	$secs = intval($seconds % 60);
	$mins = intval($seconds / 60 % 60);
	$hours = intval($seconds / 3600 % 24);
	$days = intval($seconds / 86400);
	$uptimeString = "";

	if ($days > 0) {
		$uptimeString .= $days;
		$uptimeString .= (($days == 1) ? "&nbsp;day" : "&nbsp;days");
	}
	if ($hours > 0) {
		$uptimeString .= (($days > 0) ? ", " : "") . $hours;
		$uptimeString .= (($hours == 1) ? "&nbsp;hour" : "&nbsp;hours");
	}
	if ($mins > 0) {
		$uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
		$uptimeString .= (($mins == 1) ? "&nbsp;minute" : "&nbsp;minutes");
	}
	if ($secs > 0) {
		$uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
		$uptimeString .= (($secs == 1) ? "&nbsp;second" : "&nbsp;seconds");
	}
	return $uptimeString;
}

function initialize() {
	global $configs;
	if ($configfile = fopen(GATEWAYCONFIGPATH,'r')) {
		while ($line = fgets($configfile)) {
			list($key,$value) = split("=",$line);
			$value = trim(str_replace('"','',$value));
			if ($key != 'ircddbPassword' && strlen($value) > 0)
				$configs[$key] = $value;
		}
	}
	global $MYCALL;
	$MYCALL=strtoupper($configs['gatewayCallsign']);
}

function head() {
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="index">
		<meta name="robots" content="follow">
		<meta name="language" content="English">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
	global $progname;
	echo "		<meta name=\"GENERATOR\" content=\"$progname\">\n";
?>
		<meta name="Author" content="Origin: Hans-J. Barthen (DL5DI), Changed/adapted for non ircddb registered Gateways by Hans Hommes (PE1AGO), modified by Kim Huebel (DG9VH)">
		<meta name="Description" content="ircDDBGateway Dashboard">
		<meta name="KeyWords" content="Hamradio,ircDDBGateway,D-Star,ircDDB,DL5DI,DG9VH">
		<title>Gateway/Hotspot <?php
	global $MYCALL;
	echo "$MYCALL" ?></title>
		<!-- Das neueste kompilierte und minimierte CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- Optionales Theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<!-- Das neueste kompilierte und minimierte JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="ircddb.css">
		<meta http-equiv="refresh" content="60">
	</head>
	<body>
	<div class="container-fluid">
<?php
}

function headline() {
	global $MYCALL;
?>
		<h1>Status-Dashboard <?php echo "$MYCALL" ?></h1>
<?php
	if (SHOWEMAILADDRESS) {
?>
		<p>
			<b>Contact-E-Mail:</b> <a href="mailto:<?php echo EMAILADDRESS?>"><?php echo EMAILADDRESS?></a>
		</p>
<?php
	}
}

function gatewayInfo() {
	global $configs;
?>
		<H4>Gateway:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th>Location</th>
					<th>Longtitude/Latitude</th>
					<th>ircDDBGateway Server</th>
					<th>APRS-Host</th>
				</tr>
				<tr class="gatewayinfo">
	<?php print "					<td>$configs[description1]\n$configs[description2]</td>\n";
		if (SHOWGATEWAYPOSITION)
			print "					<td><a href=\"https://www.google.de/maps/place/$configs[latitude]N+$configs[longitude]E/@$configs[latitude],$configs[longitude],17z\">$configs[latitude]\n$configs[longitude]</a></td>\n";
		else
			print "					<td>$configs[latitude]\n$configs[longitude]</td>\n";
		print "					<td>$configs[ircddbHostname]</td>\n";
		if($configs['aprsEnabled'] == 1){ print "<td>$configs[aprsHostname]</td>"; } else { print "<td><img src=\"images/20red.png\"></td>";}
?>
				</tr>
			</tbody>
		</table>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="gatewayinfo">ircddb</th>
					<th class="gatewayinfo">DCS</th>
					<th class="gatewayinfo">DExtra</th>
					<th class="gatewayinfo">DPlus</th>
					<th class="gatewayinfo">D-Rats</th>
					<th class="gatewayinfo">Info</th>
					<th class="gatewayinfo">Echo</th>
					<th class="gatewayinfo">Log</th>
				</tr>
				<tr class="gatewayinfo">
<?php 

		if($configs['ircddbEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['dcsEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['dextraEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['dplusEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['dratsEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['infoEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['echoEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
		if($configs['logEnabled'] == 1){print "<td><img alt=\"green\" width=\"20\" src=\"images/20green.png\"></td>"; } else { print "<td><img alt=\"red\" width=\"20\" src=\"images/20red.png\"></td>"; }
?>
				</tr>
			</tbody>
		</table>
<?php
}

function systemInfo() {
	exec("cat /sys/class/thermal/thermal_zone0/temp", $cputemp);
	exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq", $cpufreq);
	$cputemp = $cputemp[0] / 1000;
	$cpufreq = $cpufreq[0] / 1000;

	$output = shell_exec('cat /proc/loadavg');
	$sysload = substr($output,0,strpos($output," "))*100; 

	$output = shell_exec("grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage}'");
	$cpuusage = round($output, 2); 

	$output = shell_exec('cat /proc/uptime');
	$uptime = format_time(substr($output,0,strpos($output," ")));
	$idletime = format_time(substr($output,strpos($output," ")));

?>
		<h4>System Info:</h4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th>CPU-Temperature</th>
					<th>CPU-Frequency</th>
					<th>System-Load</th>
					<th>CPU-Usage</th>
					<th>Uptime</th>
					<th>Idle</th>
				</tr>
				<tr class="gatewayinfo">
					<td><?php echo $cputemp; ?> &deg;C</td>
					<td><?php echo $cpufreq; ?> MHz</td>
					<td><?php echo $sysload; ?> %</td>
					<!--<td><?php echo $cpuusage; ?> %</td>-->
					<td>
<?php
	if (SHOWPROGRESSBARS) {
?>
						<div class="progress"><div class="progress-bar <?php
		if ($cpuusage < 30)
			echo "progress-bar-success";
		if ($cpuusage >= 30 and $cpuusage < 60)
			echo "progress-bar-warning";
		if ($cpuusage >= 60)
			echo "progress-bar-danger";
?>" role="progressbar" aria-valuenow="<?php echo $cpuusage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cpuusage; ?>%;"><?php echo $cpuusage; ?>%</div></div>
<?php
	} else {
		echo $cpuusage." %";
	}
?>
					</td>
					<td><?php echo $uptime; ?></td>
					<td><?php echo $idletime; ?></td>
				</tr>
			</tbody>
		</table>
<?php
}

function repeaterInfo() {
	global $configs;
?>
		<H4>Repeaters:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th>Repeater</th>
					<th>Module</th>
					<th>Frequency<br>Shift</th>
					<th>Antenna Height.<br>Range</th>
					<th>Latitude<br>Longitude</th>
					<th>Default reflector</th>
					<th>@Startup<br>Reconnect</th>
				</tr>
<?php 
	$tot = array(0=>"Never",1=>"Fixed",2=>"5 min",3=>"10 min",4=>"15 min",5=>"20 min",6=>"25 min",7=>"30 min",8=>"60 min",9=>"90 min",10=>"120 min",11=>"180 min",12=>"&nbsp;");
	$ci = 0;
	for($i = 1;$i < 5; $i++){
		$param="repeaterBand" . $i;
		if(isset($configs[$param])) {
			$ci++;
			if($ci > 1) { $ci = 0; }
			print "<tr class=\"row".$ci."\">";
			print "<td>$i</td>";
			$module = $configs[$param];
			print "<td>$module</td>";
			$param="frequency" . $i;
			$frequency = $configs[$param];
			$param="offset" . $i;
			$offset = $configs[$param];
			print "<td>$frequency<br>$offset Mhz</td>";
			$param="agl" . $i;
			$agl = $configs[$param];
			$param="rangeKms" . $i;
			$rangeKms = $configs[$param];
			print "<td>$agl m a.g.<br>$rangeKms Km</td>";
			$param="latitude" . $i;
			$latitude = $configs[$param];
			$param="longitude" . $i;
			$longitude = $configs[$param];
			print "<td>$latitude<br>$longitude</td>";
			$param="reflector" . $i;
			$reflector = $configs[$param];
			print "<td>$reflector</td>";
			$param="atStartup" . $i;
			if($configs[$param] == 1){print "<td>Yes<br>"; } else { print "<td>No <br>"; }
			$param="reconnect" . $i;
			$reconnect = $configs[$param];
			$t = $configs[$param]; print "$tot[$t]";
		}
	}
?>
			</tbody>
		</table>
<?php
}
function linksInfo($direction = "both") {
	global $configs;
	$repeaters = array();
	for($i = 1;$i < 5; $i++){
		$param="repeaterBand" . $i;
		if(isset($configs[$param])) {
			array_push($repeaters, $configs[$param]);
		}
	}
	switch ($direction) {
		case "both":
			echo "<H4>Links:</H4>"; 
			break;
		case "in":
			echo "<H4>Links (incoming):</H4>"; 
			break;
		case "out":
			echo "<H4>Links (outgoing):</H4>"; 
			break;
	}
?>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th>Repeater</th>
					<th>Linked to</th>
					<th>Link Type</th>
					<th>Protocol</th>
<?php
	if ($direction == "both") {
?>
					<th>Direction</th>
<?php
	}
?>
					<th>Last Change (UTC)</th>
				</tr>
<?php 
	$ci = 0;
	$tr = 0;
	if ($linkLog = fopen(LINKLOGPATH,'r')) {
		while ($linkLine = fgets($linkLog)) {
			 $linkDate = "&nbsp;";
			 $protocol = "&nbsp;";
			 $linkType = "&nbsp;";
			 $linkSource = "&nbsp;";
			 $linkDest = "&nbsp;";
			 $linkDir = "&nbsp;";
// Reflector-Link, sample:
// 2011-09-22 02:15:06: DExtra link - Type: Repeater Rptr: DB0LJ	B Refl: XRF023 A Dir: Outgoing
// 2012-04-03 08:40:07: DPlus link - Type: Dongle Rptr: DB0ERK B Refl: REF006 D Dir: Outgoing
// 2012-04-03 08:40:07: DCS link - Type: Repeater Rptr: DB0ERK C Refl: DCS001 C Dir: Outgoing
			 if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*Rptr: (.{8}).*Refl: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
				 $linkDate = $linx[1][0];
				 $protocol = $linx[2][0];
				 $linkType = $linx[3][0];
				 $linkSource = $linx[4][0];
				 $linkDest = $linx[5][0];
				 $linkDir = $linx[6][0];
			 }
// CCS-Link, sample:
// 2013-03-30 23:21:53: CCS link - Rptr: PE1AGO C Remote: PE1KZU	 Dir: Incoming
			 if(preg_match_all('/^(.{19}).*(CC[A-Za-z]*).*Rptr: (.{8}).*Remote: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
				 $linkDate = $linx[1][0];
				 $protocol = $linx[2][0];
				 $linkType = $linx[2][0];
				 $linkSource = $linx[3][0];
				 $linkDest = $linx[4][0];
				 $linkDir = $linx[5][0];
			}
// Dongle-Link, sample: 
// 2011-09-24 07:26:59: DPlus link - Type: Dongle User: DC1PIA	 Dir: Incoming
// 2012-03-14 21:32:18: DPlus link - Type: Dongle User: DC1PIA Dir: Incoming
			 if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*User: (.{6,8}).*Dir: (.*)$/',$linkLine,$linx) > 0){
				 $linkDate = $linx[1][0];
				 $protocol = $linx[2][0];
				 $linkType = $linx[3][0];
				 $linkSource = "&nbsp;";
				 $linkDest = $linx[4][0];
				 $linkDir = $linx[5][0];
			 }
			 if ($direction == "in" && $linkDir == "Incoming" || $direction == "out" && $linkDir == "Outgoing" || $direction == "both" ) {
				$position = array_search(substr($linkSource, -1), $repeaters);
				unset($repeaters[$position]);
				$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				$tr++;
 				print "<td>$linkSource</td>";
				print "<td>$linkDest</td>";
				print "<td>$linkType</td>";
				print "<td>$protocol</td>";
				if ($direction == "both")
					print "<td>$linkDir</td>";
				print "<td>$linkDate</td>";
				print "</tr>";
			}
		}
		fclose($linkLog);
		foreach ($repeaters AS $repeater) {
			$ci++;
			if($ci > 1) { $ci = 0; }
			print "<tr class=\"row".$ci."\">";
			$tr++;
 			print "<td>".$configs['gatewayCallsign']." ".$repeater."</td>";
			$colspan = 4;
			if ($direction == "both")
				$colspan = 5;
			print "<td colspan = ".$colspan.">not connected</td>";
			print "</tr>";
		}
	}
	if($tr == 0){
		print "<tr class=\"row1\">";
		print "<td>&nbsp;</td>";
		print "<td>&nbsp;</td>";
		print "<td>&nbsp;</td>";
		print "<td>&nbsp;</td>";
		print "<td>&nbsp;</td>";
		if ($direction == "both")
			print "<td>&nbsp;</td>";
		print "</tr>";
	}
?>
			</tbody>
		</table>
<?php
}

function txingInfo() {
?>
		<H4>Currently transmitting:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">ID</th>
					<th class="calls">Yourcall</th>
					<th class="calls">Repeater1</th>
					<th class="calls">Repeater2</th>
				</tr>
<?php // Headers.log sample:
// 0000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-08-18 19:23:48: Transmitting to - My: DL1ESZ	/5100	Your: CQCQCQ		Rpt1: DG9VH	G	Rpt2: DG9VH	B	Flags: 00 00 00
// M: 2015-08-18 19:24:40: Stats for DL1ESZ		Frames: 17.8s, Loss: 1.2%, Packets: 11/890

	exec('(grep -v " /TIME" '.DSTARREPEATERLOGPATH.'/'.DSTARREPEATERLOGFILENAME.'$(date --utc +%Y-%m-%d).log|sort -r -k7,7|sort -u -k7,8|sort -r|head -1 >/tmp/lasttxing.log) 2>&1 &');
	$ci = 0;
	if ($LastTXLog = fopen("/tmp/lasttxing.log",'r')) {
		while ($linkLine = fgets($LastTXLog)) {
			if(preg_match_all('/^(.{22}).*My: (.*).*Your: (.*).*Rpt1: (.*).*Rpt2: (.*).*Flags: (.*)$/',$linkLine,$linx) > 0){
			$ci++;
			if($ci > 1) { $ci = 0; }
			print "<tr class=\"row".$ci."\">";
			$QSODate = substr($linx[1][0],2,21);
			$MyCall = substr($linx[2][0],0,8);
			$MyId = substr($linx[2][0],9,4);
			$YourCall = $linx[3][0];
			$Rpt1 = $linx[4][0];
			$Rpt2 = $linx[5][0];
			print "<Td>$QSODate</td>";

			if (SHOWQRZ)
				print "<td><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">".trim($MyCall)."</a></td>";
			else
				print "<td>$MyCall</td>";

			print "<td>$MyId</td>";
			print "<td>$YourCall</td>";
			print "<td>$Rpt1</td>";
			print "<td>$Rpt2</td>";
			print "</tr>";
		}
	}
	fclose($LastTXLog);
}
?>
			</tbody>
		</table>
<?php
}
function inQSOInfo() {
?>
		<H4>Currently maybe in QSO:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">Frames (s)</th>
					<th class="calls">Loss (%)</th>
				</tr>
<?php // Headers.log sample:
// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-08-18 19:23:48: Transmitting to - My: DL1ESZ	/5100	Your: CQCQCQ		Rpt1: DG9VH	G	Rpt2: DG9VH	B	Flags: 00 00 00
// M: 2015-08-18 19:24:40: Stats for DL1ESZ		Frames: 17.8s, Loss: 1.2%, Packets: 11/890
//sort -u -k6,7|
	exec('(grep -v " /TIME" '.DSTARREPEATERLOGPATH.'/'.DSTARREPEATERLOGFILENAME.'$(date --utc +%Y-%m-%d).log|grep Stats|sort -r -k3,9 |sort -u -k6,6|sort -r|head -10 >/tmp/qsoinfo.log) 2>&1 &');
	$ci = 0;
	if ($QSOInfoLog = fopen("/tmp/qsoinfo.log",'r')) {
		while ($linkLine = fgets($QSOInfoLog)) {
			if(preg_match_all('/^(.{22}).*Stats for (.*).*Frames: (.*).*s, Loss: (.*).*%, Packets:(.*)/',$linkLine,$linx) > 0){
				$QSODate = substr($linx[1][0],3,21);
				$MyCall = substr($linx[2][0],0,8);
				$Frames = $linx[3][0];
				$Loss = $linx[4][0];
				$UTC = new DateTimeZone("UTC");
				$d1 = new DateTime($QSODate, $UTC);
				$d2 = new DateTime();
				$diff = $d2->diff($d1);
				if ($Frames>3 && $diff->y==0 && $diff->m==0 && $diff->d==0 && $diff->h==0 && $diff->i<10 ) {
					$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				print "<td>$QSODate</td>";

				if (SHOWQRZ)
					print "<td><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">".trim($MyCall)."</a></td>";
				else
					print "<td>$MyCall</td>";

				print "<td>$Frames</td>";
				print "<td>";

				if (SHOWPROGRESSBARS) {
?>
						<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $Loss; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $Loss; ?>%;"><?php echo $Loss; ?></div></div>
<?php
				} else {
					echo $Loss;
				}
				print "</td>";
				print "</tr>";
			}
		}
	}
	fclose($QSOInfoLog);
}
?>
			</tbody>
		</table>
<?php
}

function txingInfoAjax() {
?>
		<H4>Currently transmitting:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th>Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">ID</th>
					<th>Yourcall</th>
					<th>Repeater1</th>
					<th>Repeater2</th>
<?php
	if (SHOWPROGRESSBARS) {
?>
					<th>TX-Seconds</th>
<?php
}
?>
				</tr>
				<tr class="row1" id="txline">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<script>
			function loadXMLDoc() {
				var xmlhttp;
				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("txline").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","currentTX.php",true);
				xmlhttp.send();
				var timeout = window.setTimeout("loadXMLDoc()", <?php echo RELOADTIMEINMS; ?>);
			}

			loadXMLDoc();
		</script>
<?php
}

function lastHeardInfo() {
	global $MYCALL;
?>
		<H4>Last 15 calls heard on <?php echo "$MYCALL" ?>:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">ID</th>
					<th class="calls">Yourcall</th>
					<th class="calls">Repeater1</th>
					<th class="calls">Repeater2</th>
				</tr>
<?php // Headers.log sample:
// 0000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// 2012-06-05 12:18:41: DCS header - My: PU2ZHZ	/T		 Your: CQCQCQ		Rpt1: PU2ZHZ B	Rpt2: DCS007 B	Flags: 00 00 00
// 2012-05-29 21:33:56: DPlus header - My: PD1RB	 /IC92	Your: CQCQCQ		Rpt1: PE1RJV B	Rpt2: REF017 A	Flags: 00 00 00
// 2013-02-09 13:49:57: DExtra header - My: DO7MT	 /			Your: CQCQCQ		Rpt1: XRF001 G	Rpt2: XRF001 C	Flags: 00 00 00
//

	exec('(grep -v " /TIME" '.HRDLOGPATH.'|sort -r -k7,7|sort -u -k7,8|sort -r|head -15 >/tmp/lastheard.log) 2>&1 &');
	$ci = 0;
	if ($LastHeardLog = fopen("/tmp/lastheard.log",'r')) {
		while ($linkLine = fgets($LastHeardLog)) {
			if(preg_match_all('/^(.{19}).*My: (.*).*Your: (.*).*Rpt1: (.*).*Rpt2: (.*).*Flags: (.*)$/',$linkLine,$linx) > 0){
				$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				$QSODate = $linx[1][0];
				$MyCall = str_replace("	"," ", substr($linx[2][0],0,8));
				$MyId = substr($linx[2][0],9,4);
				$YourCall = $linx[3][0];
				$Rpt1 = str_replace("	", " ", $linx[4][0]);
				$Rpt2 = $linx[5][0];
				print "<td>$QSODate</td>";

				if (SHOWQRZ)
					print "<td><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">".trim($MyCall)."</a>";
				else
					print "<td>$MyCall";

				if (SHOWAPRS)
					print " <a title=\"Show location of $MyCall on aprs.fi\" href=\"http://aprs.fi/#!call=i%2F".str_replace(" ", "%20", $MyCall)."\"><img alt=\"APRS-Position\" src=\"images/position16x16.gif\"></a></td>";
				else
					print "</td>";

				print "<td>$MyId</td>";
				print "<td>$YourCall</td>";

				if (SHOWAPRS)
					print "<td>$Rpt1 <a title=\"Show location of $Rpt1 on aprs.fi\" href=\"http://aprs.fi/#!call=i%2F".str_replace(" ", "%20", $Rpt1)."\"><img alt=\"APRS-Position\" src=\"images/position16x16.gif\"></a></td>";
				else
					print "<td>$Rpt1</td>";

				print "<td>$Rpt2</td>";
				print "</tr>";
			}
		}
		fclose($LastHeardLog);
	}
?>
			</tbody>
		</table>
<?php
}

function lastUsedInfo() {
	global $MYCALL;
?>
		<H4>Last calls that used <?php echo "$MYCALL" ?>:</H4>
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">ID</th>
					<th class="calls">Yourcall</th>
					<th class="calls">Repeater1</th>
					<th class="calls">Repeater2</th>
				</tr>
<?php // Headers.log sample:
// 0000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// 2012-05-29 20:31:53: Repeater header - My: PE1AGO	/HANS	Your: CQCQCQ		Rpt1: PI1DEC B	Rpt2: PI1DEC G	Flags: 00 00 00
//

	exec('(grep "Repeater header" '.HRDLOGPATH.'|sort -r -k7,7|sort -u -k7,8|sort -r >/tmp/worked.log) 2>&1 &');
	$ci = 0;
	if ($WorkedLog = fopen("/tmp/worked.log",'r')) {
		while ($linkLine = fgets($WorkedLog)) {
			if(preg_match_all('/^(.{19}).*My: (.*).*Your: (.*).*Rpt1: (.*).*Rpt2: (.*).*Flags: (.*)$/',$linkLine,$linx) > 0){
				$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				$QSODate = $linx[1][0];
				$MyCall = substr($linx[2][0],0,8);
				$MyId = substr($linx[2][0],9,4);
				$YourCall = $linx[3][0];
				$Rpt1 = $linx[4][0];
				$Rpt2 = $linx[5][0];
				print "<td>$QSODate</td>";
				print "<td>$MyCall</td>";
				print "<td>$MyId</td>";
				print "<td>$YourCall</td>";
				print "<td>$Rpt1</td>";
				print "<td>$Rpt2</td>";
				print "</tr>";
			}
		}
		fclose($WorkedLog);
	}
?>
			</tbody>
		</table>
<?php
}

function remoteControl() {
	global $configs, $presettargets;
	$repeaters = array();
	for($i = 1;$i < 5; $i++){
		$param="repeaterBand" . $i;
		if(isset($configs[$param])) {
			array_push($repeaters, $configs[$param]);
		}
	}
?>
		<h4>Remote Control:</h4>
		<form action="javascript:loadRemoteControlXMLDoc()">
		<table class="table-bordered">
			<tbody>
				<tr>
					<th class="calls">Repeater:</th>
					<td><select id="repeater" style="width: 150px">

<?php
	foreach ($repeaters AS $repeater) {
		 $repeatercallsign = $configs['gatewayCallsign'];
		 $callsignlength = strlen($repeatercallsign);
		 for ($i = $callsignlength; $i < 7 ; $i++) 
			 $repeatercallsign .=" ";
		 $repeatercallsign = $repeatercallsign.$repeater;
		 print "<option value=\"".$repeatercallsign."\">".$repeatercallsign."</option>";
	}

?>
					</select></td>
				</tr>
				<tr>
					<th class="calls">Link-Target:</th>
					<td><input type="text" id="target" style="width: 150px"></td>
				</tr>
				<tr>
					<th class="calls">Preset-Target:</th>
					<td><select id="presettarget" style="width: 150px">
						<option value="">please choose</option>
<?php
		foreach($presettargets as $pretgt => $x_value) {
			echo "<option value=\"".$x_value."\">".$pretgt."</option>";
		}
?>
					</select></td>
				</tr>
				<tr>
					<th class="calls">Reconnect after:</th>
					<td>
						<select id="reconnect" style="width: 150px">
							<option value="5">5 minutes</option>
							<option value="10">10 minutes</option>
							<option value="15">15 minutes</option>
							<option value="20">20 minutes</option>
							<option value="25">25 minutes</option>
							<option value="30">30 minutes</option>
							<option value="NEVER">never</option>
						</select>
					</td>
				</tr>
				<tr>
					<th class="calls">Password:</th>
					<td><input type="password" id="passwd" style="width: 150px"></td>
				</tr>
				<tr>
					<td colspan ="2"><input type="submit"></td>
				</tr>
			</tbody>
		</table>
		</form>
		<div class="alert alert-success" role="alert" id="target_alert"></div>
		<script>
			function loadRemoteControlXMLDoc() {
				var xmlhttp;
				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("target_alert").innerHTML=xmlhttp.responseText;
					}
				}

				xmlhttp.open("POST","remotewrapper.php",true);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				var parameters;
				if (document.getElementById("presettarget").value == "") 
					parameters = "REPEATER="+document.getElementById("repeater").value+"&TARGET="+document.getElementById("target").value+"&PASSWD="+document.getElementById("passwd").value+"&RECONNECT="+document.getElementById("reconnect").value;
				else
					parameters = "REPEATER="+document.getElementById("repeater").value+"&TARGET="+document.getElementById("presettarget").value+"&PASSWD="+document.getElementById("passwd").value+"&RECONNECT="+document.getElementById("reconnect").value;

				xmlhttp.send(parameters);
				var timeout = window.setTimeout("loadXMLDoc()", <?php echo RELOADTIMEINMS; ?>);
			}

			loadXMLDoc();
		</script>

<?php
}

function footer() {
?>
		<p>
<?php
	date_default_timezone_set("UTC");
	$datum = date("d.m.Y");
	$uhrzeit = date("H:i:s");
	echo "Last Update $datum, $uhrzeit";
?>
		</p>
	</div>
	</body>
</html>
<?php
}
?>
