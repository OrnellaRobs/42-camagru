<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
if (!empty($_GET) && isset($_GET['url']))
{
	echo '<img src= "'. $_GET["url"] .'">';
}
?>
<form method="post" action="">

<p>
    Votre commentaire :
</p>
<input type="text">
<input type="submit" value="Envoyer">
</form>
<?php require 'inc/footer.php'; ?>