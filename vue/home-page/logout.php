<?php
	session_start();
	unset($_SESSION['auth']);
	$_SESSION['success'] = "Vous êtes maintenant déconnecté";
	header('Location: /camagru/vue/home-page/login-page.php');
?>
