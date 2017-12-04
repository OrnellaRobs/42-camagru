<?php
require 'inc/functions.php';
check_session();
logged_only();
?>
<?php require 'inc/header.php'; ?>

<!-- if (!empty($_POST))
{
if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm-password']) {
$_SESSION['danger'] = "Les mots de passes ne correspondent pas";
}
else {
$user_id = $_SESSION['auth']->id;
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
require_once 'inc/db.php';
$req = $pdo->prepare('UPDATE User SET password = ?');
$req->execute([$password]);
$_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
}
}
?> -->
<!--precedemment a mettre dans home.php-->
<h1>Modifier mon nom</h1>
<form action="account.php" method="post">
	<div class="form-group">
		<input type="text" name="name" placeholder="Nouveau nom"/>
	</div>
	<div class="form-group">
		<input type="text" name="confirm-name" placeholder="Confirmation du nouveau nom"/>
	</div>
	<h1>Modifier mon email</h1>
	<div class="form-group">
		<input type="email" name="email" placeholder="Changer mon email"/>
	</div>
	<div class="form-group">
		<input type="email" name="confirm-email" placeholder="Confirmation du nouveau email"/>
	</div>
	<h1>Changer mon mot de passe</h1>
	<div class="form-group">
		<input type="password" name="password" placeholder="Changer de mot de passe"/>
	</div>
	<div class="form-group">
		<input type="password" name="confirm-password" placeholder="Confirmation du nouveau mot de passe"/>
	</div>
	<input class="login-submit" type="submit" value="Sauvergarder les modifications"><br/>
</form>
<?php require 'inc/footer.php'; ?>