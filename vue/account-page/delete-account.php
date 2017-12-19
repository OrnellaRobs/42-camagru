<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
if (!empty($_POST) && isset($_POST['password']) && isset($_POST['confirm-password']))
{
	$errors = array();
	if ($_POST['password'] == "" || $_POST['confirm-password'] == "")
		$errors['empty'] = "Le champ mot de passe est vide";
	else if ($_POST['password'] != $_POST['confirm-password'])
		$errors['dontmatch'] = "Les mots de passe ne correspondent pas";
	else {
		$req = $pdo->prepare('SELECT * from User WHERE username = :username AND confirmation_at IS NOT NULL');
		$req->execute([
			'username' => $_SESSION['auth']->username
		]);
		$user = $req->fetch();
		if ($user && password_verify($_POST['password'], $user->password))
		{
			$req = $pdo->prepare('DELETE from User WHERE username = :username');
			$req->execute([
				'username' => $_SESSION['auth']->username
			]);
			// $_SESSION['success'] = "Votre compte a bien été supprimé";
			session_start();
			unset($_SESSION['auth']);
			session_destroy();
			$_SESSION['success'] = "Votre compte a bien été supprimé";
			header('Location: /camagru/vue/home-page/login-page.php');
			exit();
		}
		else {
			$errors['no-match'] = "Mot de passe incorrect";
		}
	}
}
?>
<div class="title">
	<center><img id="img-login" src="/camagru/images/logo.png" width="90px;"/></center>
	<center><img id="img-login" src="/camagru/images/collage-1.jpg" width="160px;"/></center>
</div>
<form class="delete-account" action="" method="post">
	<?php if (!empty($errors)): ?>
		<div class="danger">
			<?php foreach($errors as $error):?>
				<li><?=$error;?></li>
			<?php endforeach;?>
		</div>
	<?php 	endif; ?>
	<div class="msg-delete-account">
		Afin de supprimer définitivement votre compte, veuillez entrer votre mot de passe.
	</div>
	<input class="input-password" type="password" name="password" placeholder="Entrer le mot de passe"/>
	<input class="input-password" type="password" name="confirm-password" placeholder="Entrer à nouveau le mot de passe"/>
	<input class="submit-delete-account" type="submit" value="Supprimer mon compte"><br/>

</form>
<?php require dirname(__FILE__) . '/../footer/footer.php'?>
