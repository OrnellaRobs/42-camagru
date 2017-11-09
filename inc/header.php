<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="./css/header.css">
	</head>
	<body>
		<div class="all-page">
		<div class="header">
			<?php if (isset($_SESSION['auth'])): ?>
				<a class="user-input" href="./logout.php">Se Déconnecter</a>
				<a class="user-input" href="">Galerie</a>
			<?php else: ?>
				<a class="user-input" href="./register.php">S'Inscrire</a>
		<?php endif;?>
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