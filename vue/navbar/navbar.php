<div class="page">
	<div class="wrapper-navbar">
	<div class="header">
		<?php if (isset($_SESSION['auth'])): ?>
		<a class="user-input" href="/Camagru-Grafik-Art/vue/home-page/logout.php">Se Déconnecter</a>
		<a class="user-input" href="/Camagru-Grafik-Art/vue/account-page/account.php">Compte</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/vue/gallery-page/gallery.php"):?>
		<a class="user-input" href="/Camagru-Grafik-Art/vue/gallery-page/gallery.php">Galerie</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/vue/home-page/home.php"):?>
		<a class="user-input" href="/Camagru-Grafik-Art/vue/home-page/home.php">Accueil</a>
		<?php endif;?>
		<?php if (!isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/vue/register-page/register.php"): ?>
		<a class="user-input" href="/Camagru-Grafik-Art/vue/register-page/register.php">S'Inscrire</a>
		<?php endif;?>
		<?php if (!isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/index.php" && $_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/vue/home-page/login-page.php"):  ?>
		<a class="user-input" href="/Camagru-Grafik-Art/index.php">Se Connecter</a>
		<?php endif;?>
	</div>
	<?php if (isset($_SESSION['success'])):?>
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
	</div>
