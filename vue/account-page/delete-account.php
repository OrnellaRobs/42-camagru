<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
?>
<div class="title">
	<center><img id="img-login" src="/camagru/images/logo.png" width="90px;"/></center>
	<center><img id="img-login" src="/camagru/images/collage-1.jpg" width="160px;"/></center>
</div>
<form class="delete-account" action="" method="post">
	<div class="msg-delete-account">
		Afin de supprimer définitivement votre compte, veuillez entrer votre mot de passe.
	</div>
	<input class="input-password" type="password" name="password" placeholder="Entrer le mot de passe"/>
	<input class="input-password" type="password" name="confirm-password" placeholder="Entrer à nouveau le mot de passe"/>
	<input class="submit-delete-account" type="submit" value="Supprimer mon compte"><br/>

</form>
<?php require dirname(__FILE__) . '/../footer/footer.php'?>
