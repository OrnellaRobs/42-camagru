<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
require 'inc/db.php';
$user_id = $_SESSION['auth']->id;

function update_user($user_id) {
	require 'inc/db.php';
	$request = $pdo->prepare('SELECT * FROM User WHERE id = :id');
	$request->execute(['id' => $user_id]);
	$user = $request->fetch();
	$_SESSION['auth'] = $user;
}
$name = 0;
$email = 0;
$password = 0;
$errors = array();
if (!empty($_POST))
{
	if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['confirm-name']) && $_POST['confirm-name'] != "")
	{
		if ($_POST['name'] != $_POST['confirm-name'])
			$errors['name'] = "Les noms ne correspondent pas";
		else
			$name = 1;
	}
	if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['confirm-email']) && $_POST['confirm-email'] != "")
	{
		$req = $pdo->prepare('SELECT id FROM User WHERE email = ?');
		$req->execute([$_POST['email']]);
		$user = $req->fetch();
		if ($user)
			$errors['email-exist'] = "Cet email est déjà pris";
		else if ($_POST['email'] != $_POST['confirm-email'])
			$errors['email'] = "Les emails ne correspondent pas";
		else
			$email = 1;
	}
	if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['confirm-password']) && $_POST['confirm-password'] != "")
	{
		if ($_POST['password'] != $_POST['confirm-password'])
			$errors['password'] = "Les mots de passe ne correspondent pas";
		else
			$password = 1;
	}
	if (empty($errors) && ($name || $email || $password))
	{
		if ($name) {
			$req1 = $pdo->prepare('UPDATE User SET name = :name WHERE id = :id');
			$req1->execute([
				'name' => $_POST['name'],
				'id' => $user_id
			]);
		}
		if ($email) {
			$req2 = $pdo->prepare('UPDATE User SET email = :email WHERE id = :id');
			$req2->execute([
				'email' => $_POST['email'],
				'id' => $user_id
			]);
		}
		if ($password) {
			$new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$req3 = $pdo->prepare('UPDATE User SET password = :password WHERE id = :id');
			$req3->execute([
				'password' => $new_password,
				'id' => $user_id
			]);
		}
		update_user($user_id);
		$_SESSION['success'] = "Vos informations ont bien été mis à jour";
		header('Location: account.php');
		exit();
	}
}
?>
<?php if (!empty($errors)): ?>
	<div class="danger">
		<p>Le formulaire n'est pas rempli correctement</p>
		<?php foreach($errors as $error):?>
			<li><?=$error;?></li>
		<?php endforeach;?>
	</div>
<?php 	endif; ?>

<h1>Informations</h1>
Nom: <?= $_SESSION['auth']->name; ?><br/>
Username: <?= $_SESSION['auth']->username; ?><br/>
Email: <?= $_SESSION['auth']->email; ?><br/>
<h1>Modifier mon nom</h1>
<form action="" method="post">
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