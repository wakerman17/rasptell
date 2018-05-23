<?php
	$deviceOn = $_GET["id"];
	$output1 = system('telldusd');
	$output2 = exec("tdtool --on $deviceOn");
	header("HTTP/1.1 200 OK");
	exec('pkill telldusd');
?>
