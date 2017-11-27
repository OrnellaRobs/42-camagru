<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
if (!empty($_POST) && isset($_POST['photo_path']))
{
	var_dump($_POST);
	require './inc/db.php';
	$req = $pdo->prepare('DELETE FROM photos where photo_path = :photopath');
	$req->execute(['photopath' => $_POST['photo_path']]);
	// header('Location: home.php');
}
?>
<?php require 'inc/footer.php'; ?>
?>