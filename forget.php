<?php
require 'inc/functions.php';
// check_session();
check_already_login();
if (!empty($_POST) && !empty($_POST['email']))
{
	require_once 'inc/db.php';
	require_once 'inc/functions.php';
	$req = $pdo->prepare('SELECT * from User WHERE email = ? AND confirmation_at IS NOT NULL');
	$req->execute([$_POST['email']]);
	$user = $req->fetch();
	if ($user)
	{
		session_start();
		$reset_token = str_random(60);
		$req = $pdo->prepare('UPDATE User SET reset_token = ?, reset_at = NOW() WHERE id = ?');
		$req->execute([$reset_token, $user->id]);
		$_SESSION['success'] = "Pour changer votre mot de passe, un mail vous a été envoyé";
		$user_id = $user->id;
		$entetes =
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'From: no-reply@camagru.fr' . "\r\n" .
		'Reply-To: no-reply@camagru.fr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$objet = "Réinitialisation de votre mot de passe";
		$content = "Afin de réinitialiser votre mot de passe, il te suffit de cliquer sur ce lien:\n\nhttp://localhost:8080/Camagru-Grafik-Art/reset.php?id=$user_id&token=$reset_token";
		if (mail($_POST['email'], $objet, $content, $entetes))
		{
			$_SESSION['success'] = "Un email de confirmation a été envoyé pour valider le compte";
		}
		else {
			echo '<script>alert(" Email PAS envoyé")</script>';
		}
	}
	else {
		$_SESSION['danger'] = "Aucun compte ne correspond à cette adresse mail";
	}
}
?>


<?php require 'inc/header.php'; ?>

<h1>Mot de passe oublié</h1>

<form class="form-login" action="" method="post">
	<input class="input-login" type="email" name="email" placeholder="Email"/><br/>
	<input class="login-submit" type="submit" value="Valider"><br/>
</form>
<?php require 'inc/footer.php'; ?>