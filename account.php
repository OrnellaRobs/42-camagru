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