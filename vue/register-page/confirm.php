<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require_once dirname(__FILE__) . '/../../inc/db.php';
$req = $pdo->prepare('SELECT * from User WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();
if ($user && $user->confirmation_token == $token)
{
	$req = $pdo->prepare('UPDATE User SET confirmation_token = NULL, confirmation_at = NOW() WHERE id = ?');
	$req->execute([$user_id]);
	$_SESSION['success'] = "Le compte a bien été validé. Tu peux désormaix te connecter!";
	// $_SESSION['auth'] = $user;
}
else {
	$_SESSION['danger'] = "Désolé, ce lien n'est plus valide";
}
header('Location: /camagru/vue/home-page/login-page.php');
exit();
?>
