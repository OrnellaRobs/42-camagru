<?php
	session_start();
	unset($_SESSION['auth']);
	$_SESSION['success'] = "Vous êtes maintenant déconnecté";
	header('Location: index.php');
?>