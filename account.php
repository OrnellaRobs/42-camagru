<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
	if (!empty($_POST))
	{
		if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['confirm-name']) && $_POST['confirm-name'] != "")
		{
			if ($_POST['name'] != $_POST['confirm-name'])
			{
				$_SESSION['danger'] = "Les nouveaux noms ne correspondent pas";
				header('Location: account.php');
				exit();
			}
			require_once 'inc/db.php';
			$user_id = $_SESSION['auth']->id;
			$req = $pdo->prepare('UPDATE User SET name = :name WHERE id = :id');
			$req->execute([
				'name' => $_POST['name'],
				'id' => $user_id
			]);
			$request = $pdo->prepare('SELECT * FROM User WHERE id = :id');
			$request->execute(['id' => $user_id]);
			$user = $request->fetch();
			$_SESSION['auth'] = $user;
			$_SESSION['success'] = "Votre nom a bien été mis à jour";
			header('Location: account.php');
			exit();
		}
		if (isset($_POST['email']) && $_POST['email'] != "")
		{
			if ($_POST['email'] != $_POST['confirm-email'])
			{
				$_SESSION['danger'] = "Les nouveaux emails ne correspondent pas";
				// header('Location: account.php');
				// exit();
			}
		}
		if (isset($_POST['password']) && $_POST['password'] != "")
			echo "PASSWORD<br/>";
	}
?>

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
<!-- <?php var_dump($_SESSION['auth']);?> -->
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