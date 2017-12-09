<div class="page">
	<div class="header">
		<?php if (($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/index.php" || (($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/forgetPassword-page/forget.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/gallery-page/gallery.php") && !isset($_SESSION['auth'])))):?>
			<a class="user-input" href="../register-page/register.php">S'Inscrire</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth'])): ?>
			<a class="user-input" href="../home-page/logout.php">Se Déconnecter</a>
			<a class="user-input" href="../account-page/account.php">Compte</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] != "/Camagru-Grafik-Art/component/gallery-page/gallery.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/gallery-page/gallery.php"):?>
			<a class="user-input" href="../gallery-page/gallery.php">Galerie</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/gallery-page/gallery.php"):?>
			<a class="user-input" href="../home-page/home.php">Accueil</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art"): ?>
			<a class="user-input" href="/Camagru-Grafik-Art/component/register-page/register.php">S'Inscrire</a>
		<?php endif;?>
		<!-- <?php echo $_SERVER['REQUEST_URI']?> -->
		<?php if ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/register-page/register.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/forgetPassword/forget.php" || ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/gallery-page/gallery.php" && !isset($_SESSION['auth']))):  ?>
			<a class="user-input" href="../../index.php">Se Connecter</a>
		<?php endif;?>
		<!-- <?php if (isset($_SESSION['auth']) && ($_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/home-page/home.php" || $_SERVER['REQUEST_URI'] == "/Camagru-Grafik-Art/component/gallery-page/gallery.php")): ?>

		<?php endif;?> -->
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
