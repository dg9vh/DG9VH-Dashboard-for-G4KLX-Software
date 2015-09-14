<?php include "ircddblocal.php"; ?>
<?php
$repeater = $_POST['REPEATER'];
$target = $_POST['TARGET'];
$passwd = $_POST['PASSWD'];
if ($passwd == REMOTECONTROLPASSWD) {
	if (isset($target)) {
		$output = shell_exec('sudo -u pi /usr/local/bin/remotecontrold "'.$repeater.'" link "30" "'.$target.'"');
	} else {
		$output = shell_exec('sudo -u pi /usr/local/bin/remotecontrold "'.$repeater.'" link never unlink');
	}
	echo $output;
} else {
	echo "Wrong Password!";
}
?>
