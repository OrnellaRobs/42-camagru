<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CAMAGRU</title>
	<link rel="stylesheet" type="text/css" href="./css/header.css">
	<link rel="stylesheet" type="text/css" href="./css/home.css">
</head>
<body>
	<div class="header">
		<?php if (($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/index.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/forget.php") && !isset($_SESSION['auth'])):?>
			<a class="user-input" href="./register.php">S'Inscrire</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth'])): ?>
			<a class="user-input" href="./logout.php">Se Déconnecter</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/gallery.php"):?>
			<a class="user-input" href="./gallery.php">Galerie</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/gallery.php"):?>
			<a class="user-input" href="./home.php">Accueil</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art"): ?>
			<a class="user-input" href="./register.php">S'Inscrire</a>
		<?php endif;?>
		<!-- <?php echo $_SERVER['REQUEST_URI']?> -->
		<?php if ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/register.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/forget.php"): ?>
			<a class="user-input" href="./index.php">Se Connecter</a>
		<?php endif;?>
		<!--BONUS-->
		<!-- <?php if ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/home.php"): ?>
		<a class="user-input" href="account.php">Compte</a>
	<?php endif;?> -->
</div>
<?php
if (isset($_SESSION['success'])):?>
<div class="success">
	<?= $_SESSION['success'] ?>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php
if (isset($_SESSION['danger'])):?>
<div class="danger">
	<?= $_SESSION['danger']?>
</div>
<?php unset($_SESSION['danger']); ?>
<?php endif; ?>
