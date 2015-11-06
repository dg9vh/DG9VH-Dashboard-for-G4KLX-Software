<?php include "ircddblocal.php"; ?>
<?php include "tools.php"; ?>
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">Frames (s)</th>
					<th class="calls">Loss (%)/BER (%)</th>
				</tr>
<?php // Headers.log sample:
// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-08-18 19:23:48: Transmitting to - My: DL1ESZ	/5100	Your: CQCQCQ		Rpt1: DG9VH	G	Rpt2: DG9VH	B	Flags: 00 00 00
// M: 2015-08-18 19:24:40: Stats for DL1ESZ		Frames: 17.8s, Loss: 1.2%, Packets: 11/890
// M: 2015-10-06 07:33:41: AMBE for DG9VH     Frames: 5.3s, Silence: 0.0%, BER: 0.0%
	exec('(grep -v " /TIME" '.DSTARREPEATERLOGPATH.'/'.DSTARREPEATERLOGFILENAME.'$(date --utc +%Y-%m-%d).log|egrep -h "Stats|AMBE"|sort -r|head -15 >/tmp/last.log) 2>&1 &');
	$ci = 0;
	if ($LastLog = fopen("/tmp/last.log",'r')) {
		while ($linkLine = fgets($LastLog)) {
			if(preg_match_all('/^(.{22}).*Stats for (.*).*Frames: (.*).*s, Loss: (.*).*%, Packets:(.*)/',$linkLine,$linx) > 0){
				$QSODate = substr($linx[1][0],3,21);
				$MyCall = getAnonymizedValue(substr($linx[2][0],0,8));
				$Frames = $linx[3][0];
				$Loss = $linx[4][0];				
				$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				print "<td>$QSODate</td>";

				if (SHOWQRZ AND !ANONYMIZE)
					print "<td><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">".trim($MyCall)."</a></td>";
				else
					print "<td>$MyCall</td>";

				print "<td>$Frames</td>";
				print "<td>";

				if (SHOWPROGRESSBARS) {
?>
						<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $Loss; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $Loss; ?>%;">&nbsp;Loss:&nbsp;<?php echo $Loss; ?></div></div>
<?php
				} else {
					echo "Loss: ".$Loss;
				}
				print "</td>";
				print "</tr>";
				


			}
			if(preg_match_all('/^(.{22}).*AMBE for (.*).*Frames: (.*).*s, Silence: (.*).*%, BER:(.*)/',$linkLine,$linx) > 0){
				$QSODate = substr($linx[1][0],3,21);
				$MyCall = getAnonymizedValue(substr($linx[2][0],0,8));
				$Frames = $linx[3][0];
				$BER = $linx[4][0];
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
						<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $BER; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $BER; ?>%;">&nbsp;BER:&nbsp;<?php echo $BER; ?></div></div>
<?php
				} else {
					echo "BER: ".$BER;
				}
				print "</td>";
				print "</tr>";
			}
		}

		fclose($QSOInfoLog);
	}
?>
			</tbody>

