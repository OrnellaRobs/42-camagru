<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
check_already_login();
if (!empty($_POST))
{
	$errors = array();
	require dirname(__FILE__) . '/../../inc/db.php';
	$errors = check_username($_POST['username'], $errors);
	$errors = check_email($_POST['email'], $_POST['email-confirm'], $errors);
	$errors = check_password($_POST['password'], $_POST['password-confirm'], $errors);
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO User SET name = :name, username = :username, password = :password, email = :email, confirmation_token = :token, mail_comments = :mail_comments");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$req->execute([
			'name' => $_POST['name'],
			'username' => $_POST['username'],
			'password'=> $password,
			'email' => $_POST['email'],
			'token' => $token,
			'mail_comments' => 1
		]);
		$user_id = $pdo->lastInsertId();
		$entetes =
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'From: no-reply@camagru.fr' . "\r\n" .
		'Reply-To: no-reply@camagru.fr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		$objet = "Confirmation d'Inscription";
		$content = "Afin de finaliser ton inscription, il te suffit de cliquer sur ce lien:\n\nhttp://localhost:8080/Camagru-Grafik-Art/vue/register-page/confirm.php?id=$user_id&token=$token";
		if (mail($_POST['email'], $objet, $content, $entetes))
		{
			$_SESSION['success'] = "Un email de confirmation a été envoyé pour valider le compte";
			header('Location: ../../index.php');
			exit();
		}
		else {
			echo '<script>alert(" Email PAS envoyé")</script>';
		}
	}
}
?>
<?php
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
?>
<div class="title-msg">
	<center>Rejoins-Nous et Inscris-Toi!</center>
	<center><img src="/Camagru-Grafik-Art/images/arrow2.png" width="80px"/></center>
</div>

<div class="register-page-background">
	<div class="register-form">
		<?php	if (!empty($errors)): ?>
			<div class="danger">
				<p>Le formulaire n'est pas rempli correctement</p>
				<?php foreach($errors as $error):?>
					<li><?=$error;?></li>
				<?php endforeach;?>
			</div>
		<?php 	endif; ?>
		<div class="hashtag-msg">
			#JoinCamagru
		</div>
	<form method="post">
		<input class="input-register" type="text" name="name" placeholder="Nom Complet"/><br/>
		<input class="input-register" type="text" name="username" placeholder="Identifiant"/><br/>
		<input class="input-register" type="password" name="password" placeholder="Mot de Passe" /><br/>
		<input class="input-register" type="password" name="password-confirm" placeholder="Confirmation du mot de passe"/><br/>
		<input class="input-register" type="email" name="email" placeholder="Email"/><br/>
		<input class="input-register" type="email" name="email-confirm" placeholder="Confirmation de l'email"/><br/>
		<input class="register-submit" type="submit" name="submit" value="S'Inscrire!">
	</form>
</div>
</div>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
