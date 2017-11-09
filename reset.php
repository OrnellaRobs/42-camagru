<?php
if (isset($_GET['id']) && isset($_GET['token']))
{
	require 'inc/db.php';
	require 'inc/functions.php';
	$req = $pdo->prepare('SELECT * FROM User WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
	$req->execute([$_GET['id'], $_GET['token']]);
	$user = $req->fetch();
	if ($user) {
		if (!empty($_POST['password']) && $_POST['password'] == $_POST['confirm-password'])
		{
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$req = $pdo->prepare('UPDATE User SET password = ?, reset_at = NULL, reset_token = NULL');
			$req->execute([$password]);
			session_start();
			$_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
			$_SESSION['auth'] = $user;
			header('Location: account.php');
			exit();
		}

	}
	else {
		session_start();
		$_SESSION['danger'] = "Ce token n'est pas valide";
		header('Location: login.php');
	}
}
?>

<?php require 'inc/header.php'; ?>

<h1>REINITIALISER MON MOT DE PASSE</h1>

<form action="" method="post">
	<div class="form-group">
		<input type="password" name="password" placeholder="Changer de mot de passe"/>
	</div>
	<div class="form-group">
		<input type="password" name="confirm-password" placeholder="Confirmation du nouveau mot de passe"/>
	</div>
	<input class="login-submit" type="submit" value="Changer mon mot de passe"><br/>
</form>
<?php require 'inc/footer.php'; ?>