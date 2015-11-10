<?php include "ircddblocal.php"; ?>
<?php include "tools.php"; ?>
			<tbody>
				<tr>
					<th class="calls">Date &amp; Time (UTC)</th>
					<th class="calls">Call</th>
					<th class="calls">Frames (s)</th>
					<th class="calls">Silence (%)</th>
					<th class="calls">BER (%)</th>
				</tr>
<?php // Headers.log sample:
// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2015-10-06 07:33:41: AMBE for DG9VH     Frames: 5.3s, Silence: 0.0%, BER: 0.0%

//sort -u -k6,6|
	exec('(grep -v " /TIME" '.DSTARREPEATERLOGPATH.'/'.DSTARREPEATERLOGFILENAME.'$(date --utc +%Y-%m-%d).log|grep AMBE|sort -r -k3,9 |sort -r|head -5 >'.TMPPATH.'/localtraffic.log) 2>&1 &');
	$ci = 0;
	if ($localTrafficLog = fopen(TMPPATH."/localtraffic.log",'r')) {
		while ($linkLine = fgets($localTrafficLog)) {
			if(preg_match_all('/^(.{22}).*AMBE for (.*).*Frames: (.*).*s, Silence: (.*).*%, BER:(.*)/',$linkLine,$linx) > 0){
				$QSODate = substr($linx[1][0],3,21);
				$MyCall = getAnonymizedValue(substr($linx[2][0],0,8));
				$Frames = $linx[3][0];
				$Silence = $linx[4][0];
				$BER = $linx[4][0];
				$UTC = new DateTimeZone("UTC");
				$d1 = new DateTime($QSODate, $UTC);
				$d2 = new DateTime();
				$diff = $d2->diff($d1);
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
						<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $Silence; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $Silence; ?>%;"><?php echo $Silence; ?></div></div>
<?php
				} else {
					echo $Silence;
				}
				print "</td>";
				print "<td>";

				if (SHOWPROGRESSBARS) {
?>
						<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $BER; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $BER; ?>%;"><?php echo $BER; ?></div></div>
<?php
				} else {
					echo $BER;
				}
				print "</td>";
				print "</tr>";
		}
	}
	fclose($localTrafficLog);
}
?>
			</tbody>
