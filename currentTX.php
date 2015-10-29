<?php include "ircddblocal.php"; ?>
<?php include "tools.php"; ?>
<?php
function txingInfo() {
	global $col;
?>
<?php // Headers.log sample:
// 0000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-08-18 19:23:48: Transmitting to - My: DL1ESZ  /5100  Your: CQCQCQ    Rpt1: DG9VH  G  Rpt2: DG9VH  B  Flags: 00 00 00
// M: 2015-08-18 19:24:40: Stats for DL1ESZ    Frames: 17.8s, Loss: 1.2%, Packets: 11/890

	exec('(grep -v "  /TIME" '.DSTARREPEATERLOGPATH.'/'.DSTARREPEATERLOGFILENAME.'$(date --utc +%Y-%m-%d).log|sort -r -k7,7|sort -u -k7,8|sort -r|head -1 >/tmp/lasttxing.log) 2>&1 &');

	$ci = 0;

	if ($LastTXLog = fopen("/tmp/lasttxing.log",'r')) {
		while ($linkLine = fgets($LastTXLog)) {
			if(preg_match_all('/^(.{22}).*My: (.*).*Your: (.*).*Rpt1: (.*).*Rpt2: (.*).*Flags: (.*)$/',$linkLine,$linx) > 0){
				$ci++;

				if($ci > 1) { $ci = 0; }

				$QSODate = substr($linx[1][0],3,21);
				$MyCall = getAnonymizedValue(substr($linx[2][0],0,8));
				$MyId = getAnonymizedValue(substr($linx[2][0],9,4));
				$YourCall = $linx[3][0];
				$Rpt1 = getAnonymizedValue($linx[4][0]);
				$Rpt2 = $linx[5][0];
				$Flags = $linx[6][0];

				// Here we get rid of this confirming-packets by the hotspot
				if ($Flags != "01 00 00" ) {
					if ($QSOInfoLog = fopen("/tmp/qsoinfo.log",'r')) {
						$QSOLine = fgets($QSOInfoLog);
						if(preg_match_all('/^(.{22}).*Stats for (.*).*Frames: (.*).*s, Loss: (.*).*%, Packets:(.*)/',$QSOLine,$QSO) > 0){
							$LastQSODate = substr($QSO[1][0],3,21);
							$LastMyCall = getAnonymizedValue(substr($QSO[2][0],0,8));
							if ($LastQSODate != $QSODate) {
								print "<td>$QSODate</td>";
								if (SHOWQRZ AND !ANONYMOUS)
									print "<td id=\"txcall\"><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">$MyCall</a></td>";
								else
									print "<td id=\"txcall\">$MyCall</td>";
								print "<td>$MyId</td>";
								print "<td>$YourCall</td>";
								print "<td>$Rpt1</td>";
								print "<td>$Rpt2</td>";
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
					}
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
