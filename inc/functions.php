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
		header('Location: index.php');
		exit();
	}
}

function check_session() {
	if (session_status() == PHP_SESSION_NONE && !isset($_SESSION['danger'])) {
		session_start();
	}
}

function check_already_login() {
	if (isset($_SESSION['auth']))
	{
		$_SESSION['danger'] = "Vous êtes déjà connecté";
		header('Location: home.php');
		exit();
	}
}

function password_check_alphanum($str)
{
	$size = strlen($str);
	$i = 0;
	$num = 0;
	$alpha = 0;
	while ($i < $size)
	{
		if ($str[$i] >= '0' && $str[$i] <= '9')
			$num = 1;
		else if ($str[$i] >= 'A' && $str[$i] <= 'Z' || $str[$i] >= 'a' && $str[$i] <= 'z')
			$alpha = 1;
		$i++;
	}
	return $alpha == 1 && $num == 1 ? true : false;
}
