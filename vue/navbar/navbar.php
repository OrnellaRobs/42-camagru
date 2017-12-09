<?php
	require_once '../../constant.php';
?>
<div class="page">
	<div class="header">
		<?php if (($_SERVER['REQUEST_URI'] == "/camagru-grafik-art/" || $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/index.php" || (($_SERVER['REQUEST_URI'] == "/camagru-grafik-art/forget.php" || $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/gallery.php") && !isset($_SESSION['auth'])))):?>
			<a class="user-input" href="<?php echo ROOT . 'register-page/register.php'?>">S'Inscrire</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth'])): ?>
			<a class="user-input" href="./logout.php">Se Déconnecter</a>
			<a class="user-input" href="account.php">Compte</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] != "/camagru-grafik-art/gallery.php" || $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/gallery.php"):?>
			<a class="user-input" href="./gallery.php">Galerie</a>
		<?php endif;?>
		<?php if (isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/gallery.php"):?>
			<a class="user-input" href="./home.php">Accueil</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] == "/camagru-grafik-art"): ?>
			<a class="user-input" href="../register-page/register.php">S'Inscrire</a>
		<?php endif;?>
		<?php if ($_SERVER['REQUEST_URI'] == ROOT . "register-page/register.php" || $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/forget.php" || ($_SERVER['REQUEST_URI'] == "/camagru-grafik-art/gallery.php" && !isset($_SESSION['auth']))):  ?>
			<a class="user-input" href="./index.php">Se Connecter</a>
		<?php endif;?>
		<!-- <?php if (isset($_SESSION['auth']) && ($_SERVER['REQUEST_URI'] == "/camagru-grafik-art/home.php" || $_SERVER['REQUEST_URI'] == "/camagru-grafik-art/gallery.php")): ?>

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
