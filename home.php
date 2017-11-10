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
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<?php require 'inc/footer.php'; ?>
