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
		header('Location: /camagru/index.php');
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
		header('Location: /camagru/vue/home-page/home.php');
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

function check_username($username, $errors) {
	require dirname(__FILE__) . '/db.php';
	if (empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($username) < 6) {
		$str = (strlen($username) < 6) ? "L'identifiant doit avoir au moins 6 caractères" : "L'identifiant n'est pas valide";
		$errors['username'] = $str;
	}
	else {
		$req = $pdo->prepare('SELECT id FROM User WHERE username = ?');
		$req->execute([$username]);
		$user = $req->fetch();
		if ($user)
		{
			$errors['username'] = 'Cet identifiant est déjà pris';
		}
	}
	return ($errors);
}

function check_password($password, $password_confirm, $errors) {
	require dirname(__FILE__) . '/db.php';
	if (empty($password) || $password != $password_confirm || strlen($password) < 4 || !password_check_alphanum($password)) {
		$str = (strlen($password) < 4) ? "Le mot de passe doit avoir au moins 4 caractères dont des chiffres et des lettres" : "Le mot de passe n'est pas valide";
		$str = (!password_check_alphanum($password)) ? "Le mot de passe doit contenir des lettres ainsi que des chiffres" : $str;
		$errors['password'] = $str;
	}
	return ($errors);
}

function check_email($email, $email_confirm, $errors)
{
	require dirname(__FILE__) . '/db.php';
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
		$errors['email'] = "L'e-mail n'est pas valide";
	else if ($email != $email_confirm)
		$errors['email'] = "Les emails ne correspondent pas";
	else {
		$req = $pdo->prepare('SELECT id FROM User WHERE email = ?');
		$req->execute([$email]);
		$user = $req->fetch();
		if ($user)
		{
			$errors['email'] = 'Cet e-mail est déjà pris';
		}
	}
	return ($errors);
}