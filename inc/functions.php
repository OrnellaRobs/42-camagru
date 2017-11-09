<?php
function debug($variable){
 	echo '<pre>'.print_r($variable, true).'</pre>';
}

function str_random($length){
	$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only() {
	if (!isset($_SESSION['auth'])) {
		$_SESSION['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
		header('Location: login.php');
		exit();
	}
}

function check_session() {
	if (session_status() == PHP_SESSION_NONE && !isset($_SESSION['danger'])) {
		session_start();
	}
}