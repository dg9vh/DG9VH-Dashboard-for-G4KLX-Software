<?php include "ircddblocal.php"; ?>
<?php include "tools.php"; ?>
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

	exec('(grep -v " /TIME" '.HRDLOGPATH.'|sort -r -k7,7|sort -u -k7,8|sort -r|head -15 >'.TMPPATH.'/lastheard.log) 2>&1 &');
	$ci = 0;
	if ($LastHeardLog = fopen(TMPPATH."/lastheard.log",'r')) {
		while ($linkLine = fgets($LastHeardLog)) {
			if(preg_match_all('/^(.{19}).*My: (.*).*Your: (.*).*Rpt1: (.*).*Rpt2: (.*).*Flags: (.*)$/',$linkLine,$linx) > 0){
				$ci++;
				if($ci > 1) { $ci = 0; }
				print "<tr class=\"row".$ci."\">";
				$QSODate = $linx[1][0];
				$MyCall = getAnonymizedValue(str_replace("	"," ", substr($linx[2][0],0,8)));
				$MyId = getAnonymizedValue(substr($linx[2][0],9,4));
				$YourCall = $linx[3][0];
				$Rpt1 = getAnonymizedValue(str_replace("	", " ", $linx[4][0]));
				$Rpt2 = $linx[5][0];
				print "<td>$QSODate</td>";

				if (SHOWQRZ AND !ANONYMIZE)
					print "<td><a title=\"Ask QRZ.com about $MyCall\" href=\"http://qrz.com/db/$MyCall\">".trim($MyCall)."</a>";
				else
					print "<td>$MyCall";

				if (SHOWAPRS AND !ANONYMIZE)
					print " <a title=\"Show location of $MyCall on aprs.fi\" href=\"http://aprs.fi/#!call=".str_replace(" ", "%20", $MyCall)."\"><img alt=\"APRS-Position\" src=\"images/position16x16.gif\"></a></td>";
				else
					print "</td>";

				print "<td>$MyId</td>";
				print "<td>$YourCall</td>";

				if (SHOWAPRS AND !ANONYMIZE)
					print "<td>$Rpt1 <a title=\"Show location of $Rpt1 on aprs.fi\" href=\"http://aprs.fi/#!call=".str_replace(" ", "%20", $Rpt1)."\"><img alt=\"APRS-Position\" src=\"images/position16x16.gif\"></a></td>";
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

