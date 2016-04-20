<?php include "ircddblocal.php"; ?>
<?php include "tools.php"; ?>
<?php
function txingInfo() {
	global $col;
	global $mmdvmconfigs;
	if (USEMMDVMHOST) {
		if ($configfile = fopen(MMDVMINIPATH."MMDVM.ini", 'r')) {
			while ($line = fgets($configfile)) {
				list($key,$value) = split("=",$line);
				$value = trim(str_replace('"','',$value));
				$mmdvmconfigs[$key] = $value;
			}
		}
	}
?>
<?php // Headers.log sample: |egrep -h "Radio|Network|Stats|AMBE"
// 0000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-08-18 19:23:48: Transmitting to - My: DL1ESZ  /5100  Your: CQCQCQ    Rpt1: DG9VH  G  Rpt2: DG9VH  B  Flags: 00 00 00
// M: 2015-08-18 19:24:40: Stats for DL1ESZ    Frames: 17.8s, Loss: 1.2%, Packets: 11/890
	$filepath = $mmdvmconfigs['FilePath'];
	$fileroot = $mmdvmconfigs['FileRoot'];
	exec('(grep -v "  /TIME" '.$filepath.$fileroot.'-$(date --utc +%Y-%m-%d).log|tail -n1 >'.TMPPATH.'/lasttxing.log) 2>&1 &');
	
	$ci = 0;

	if ($LastTXLog = fopen(TMPPATH."/lasttxing.log",'r')) {
		while ($linkLine = fgets($LastTXLog)) {
			if(preg_match_all('/^(.{22}).*from (.*).*to (.*)$/',$linkLine,$linx) > 0){
				$ci++;

				if($ci > 1) { $ci = 0; }

				$QSODate = substr($linx[1][0],2,21);
				$MyCall = getAnonymizedValue(substr($linx[2][0],0,8));
				$MyId = getAnonymizedValue(substr($linx[2][0],9,4));
				$YourCall = $linx[3][0];

				print "<td>$QSODate</td>";
				if (SHOWQRZ AND !ANONYMIZE)
					print "<td id=\"txcall\"><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">$MyCall</a></td>";
				else
					print "<td id=\"txcall\">$MyCall</td>";
				print "<td>$MyId</td>";
				print "<td>$YourCall</td>";
				if (SHOWPROGRESSBARS) {
					$UTC = new DateTimeZone("UTC");
					$d1 = new DateTime($QSODate, $UTC);
					$d2 = new DateTime('now', $UTC);
					$diff = $d2->getTimestamp() - $d1->getTimestamp();
?>
					<td>
<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $diff; ?>" aria-valuemin="0" aria-valuemax="180" style="width: <?php echo ($diff/1.8); ?>%;"><?php echo $diff; ?>s</div></div></td>
<?php
				}
				
			}
		}
		fclose($LastTXLog);
	}
?>
<?php
}
txingInfo();
?>
