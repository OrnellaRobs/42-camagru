<?php
//verifie qu'une session n'est pas deja en cours
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
// session_start();
?>
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
			<a class="user-input" href="./register.php">S'Inscrire</a>
		</div>
		<?php if (isset($_SESSION['flash'])): ?>
			<?php foreach ($_SESSION['flash'] as $type => $message): ?>
			<div class="alert alert-<?= $type;?>">
				<?= $message; ?>
			</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>