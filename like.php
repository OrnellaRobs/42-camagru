<?php

require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
// echo "PAS OK";
// if (!empty($_POST) && isset($_POST['imgsrc']))
// {
var_dump($_GET);
	// var_dump($_POST);
	// try {
	// 	require_once './inc/db.php';
	// 	$req = $pdo->prepare("INSERT INTO photos SET user_id = :user_id, date_photo = NOW() , photo_type = :phototype, photo_path = :photopath");
	// 	$req->execute([
	// 		'user_id' => $_SESSION['auth']->id,
	// 		':phototype' => $type,
	// 		':photopath' => $filename
	// 	]);
	// }
// }
?>


<?php require 'inc/footer.php'; ?>