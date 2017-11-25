<?php

require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';

if (!empty($_POST) && isset($_POST['photoid']) && isset($_POST['like']))
{
	require_once './inc/db.php';
	$user_id = $_SESSION['auth']->id;
	if ($_POST['like'] == 1)
	{
		$req = $pdo->prepare("INSERT INTO likephoto SET userlike_id = :userwholiked, date_like = NOW() ,	photo_id = :photoid");
		$req->execute([
			'userwholiked' => $user_id,
			'photoid' => $_POST['photoid']
		]);
		echo "insert";
	}
	else if ($_POST['like'] == 0)
	{
		$req = $pdo->prepare('DELETE FROM likephoto where photo_id = :photoid AND userlike_id = :userwholiked');
		$req->execute([
			'photoid' => $_POST['photoid'],
			'userwholiked' => $user_id
		]);
		echo "delete";
	}
}
?>
	<?php require 'inc/footer.php'; ?>