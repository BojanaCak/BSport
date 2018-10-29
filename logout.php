<?php 
	session_start();
	require 'konekcija.php';
	setcookie(session_name(), '', 100);
	session_unset();
	session_destroy();
	$_SESSION = array();
	header("Location: http://localhost:8080/Bsport/index.php");
 ?>