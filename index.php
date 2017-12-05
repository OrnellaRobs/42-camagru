<?php
require 'inc/functions.php';
check_session();
check_already_login();
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
		header('Location: home.php');
		exit();
	}
	else
	$_SESSION['danger'] = "Identifiant/Email ou mot de passe inccorects";
}

?>

<?php require 'inc/header.php'; ?>
<div class="all-page-login">
	<div class="connect-msg">
		Connecte-Toi
		<center><img src="images/arrow2.png" width="80px"/></center>
	</div>
	<div class="background-login">
		<form class="form-login" action="" method="post">
			<img id="img-login" src="images/logo.png" width="90px;"/>
			<input class="input-login" type="text" name="username" title="identifiant" placeholder="Identifiant"/><br/>
			<input class="input-login" type="password" name="password" title="password" placeholder="Mot de Passe"/><br/>
			<input class="login-submit" type="submit" value="Se Connecter"><br/>
		</form>
	</div>
	<a class="forget-password" href="forget.php">J'ai oublié mon mot de passe ?</>

	</div>
	<?php require 'inc/footer.php'; ?>