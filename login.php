<?php
require 'inc/functions.php';
check_session();
if (isset($_SESSION['auth']))
{
	$_SESSION['danger'] = "Vous êtes déjà connecté";
	header('Location: account.php');
	exit();
}
if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password']))
{
	require_once 'inc/db.php';
	require_once 'inc/functions.php';
	$req = $pdo->prepare('SELECT * from User WHERE username = :username AND confirmation_at IS NOT NULL');
	$req->execute([
		'username' => $_POST['username']
	]);
	$user = $req->fetch();
	if ($user && password_verify($_POST['password'], $user->password))
	{
		session_start();
		$_SESSION['auth'] = $user;
		$_SESSION['success'] = "Vous êtes maintenant connecté";
		header('Location: account.php');
		exit();
	}
	else
		$_SESSION['danger'] = "Les informations saisies sont incorrectes";
}

?>

<?php require 'inc/header.php'; ?>

<h1>SE CONNECTER</h1>

<form class="form-login" action="" method="post">
	<input class="input-login" type="text" name="username" title="identifiant" placeholder="Identifiant"/><br/>
	<input class="input-login" type="password" name="password" title="password" placeholder="Mot de Passe"/><br/>
	<input class="login-submit" type="submit" value="Se Connecter"><br/>
	<a href="forget.php">(J'ai oublié mon mot de passe)</>
</form>
<?php require 'inc/footer.php'; ?>