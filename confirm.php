<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require './inc/db.php';
$req = $pdo->prepare('SELECT * from User WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();
if ($user && $user->confirmation_token == $token)
{
	$req = $pdo->prepare('UPDATE User SET confirmation_token = NULL, confirmation_at = NOW() WHERE id = ?');
	$req->execute([$user_id]);
	$_SESSION['success'] = "Votre compte a bien été validé";
	$_SESSION['auth'] = $user;
	header('Location: account.php');
}
else {
	$_SESSION['danger'] = "Ce token n'est plus valide";
	header('Location: index.php');
}
?>