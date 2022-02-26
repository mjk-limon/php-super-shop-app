<?php
	define("_DS_SNAME", '');
	define("_DS_USER", 'root');
	define("_DS_PASS", 'adminlimon');
	define("_DS_DB", 'storemanagement');
	
	$conn = new mysqli(_DS_SNAME, _DS_USER, _DS_PASS, _DS_DB);
	if($conn->connect_error) die("connection failed !" .  $conn->connect_error);