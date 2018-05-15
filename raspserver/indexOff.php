<?php
	$deviceOff = $_GET["id"];
	$output1 = system('telldusd');
	$output2 = exec("tdtool --off $deviceOff" );
	header("HTTP/1.1 200 OK");
	exec('pkill telldusd');
?>
