<?php
require 'inc/functions.php';
check_session();
logged_only();
if (!empty($_POST))
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
?>
<!--precedemment a mettre dans home.php-->
<?php
require 'inc/functions.php';
check_session();
logged_only();
?>
<?php require 'inc/header.php'; ?>
<h1>Réinitialisation de votre mot de passe</h1>
<form action="home.php" method="post">
	<div class="form-group">
		<input type="password" name="password" placeholder="Changer de mot de passe"/>
	</div>
	<div class="form-group">
		<input type="password" name="confirm-password" placeholder="Confirmation du nouveau mot de passe"/>
	</div>
	<input class="login-submit" type="submit" value="Changer mon mot de passe"><br/>
</form>
<?php require 'inc/footer.php'; ?>