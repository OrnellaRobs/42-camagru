<?php
	session_start();
	unset($_SESSION['auth']);
	$_SESSION['success'] = "Vous êtes maintenant déconnecté";
	header('Location: /Camagru-Grafik-Art/index.php');
?>
