<?php include "ircddblocal.php"; ?>
<?php
$repeater = $_POST['REPEATER'];
$target = $_POST['TARGET'];
$passwd = $_POST['PASSWD'];
$reconnect = "30";
if (isset($_POST['RECONNECT']))
	$reconnect = $_POST['RECONNECT'];


if ($passwd == REMOTECONTROLPASSWD) {
	if (isset($target)) {
		if (DISTRIBUTION == "DL5DI_DEBIAN" )
			$output = shell_exec('sudo -u pi /usr/bin/remotecontrold "'.$repeater.'" link "'.$reconnect.'" "'.$target.'"');
		else
			$output = shell_exec('sudo -u pi /usr/local/bin/remotecontrold "'.$repeater.'" link "'.$reconnect.'" "'.$target.'"');
	} else {
		if (DISTRIBUTION == "DL5DI_DEBIAN" )
			$output = shell_exec('sudo -u pi /usr/bin/remotecontrold "'.$repeater.'" link "'.$reconnect.'" unlink');
		else
			$output = shell_exec('sudo -u pi /usr/local/bin/remotecontrold "'.$repeater.'" link "'.$reconnect.'" unlink');
	}
	echo $output;
} else {
	echo "Wrong Password!";
}
?>
