<?php
require 'inc/functions.php';
check_session();
logged_only();

require 'inc/header.php';
?>
<h1>Les photos des autres utilisateurs</h1>
<div class="wrapper-user-photo">
	<?php
	require './inc/db.php';
	$photos_per_page = 4;
	$req = $pdo->prepare('SELECT * FROM photos ORDER BY date_photo');
	$req->execute();
	$result = $req->fetchAll();
	// $result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	$i = 0;
	$user_id = $_SESSION['auth']->id;
	$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
	$req->execute(['userlikeid' => $user_id]);
	$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);
/*
$user_id = $_SESSION['auth']->id;
$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
$req->execute(['userlikeid' => $user_id]);
$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);
*/
	 foreach ($result as $elem)
	 {
	// 	$liked = 0;
	 	echo '<img src="'.$elem->photo_path.'" height="200px" />';
		echo $elem->photo_id."<br/>";

		$liked = false;
		foreach ($allphotoliked as $photo) {
			if ($photo === $elem->photo_id) {
				$liked = true;
				break;
			}
		}

		if ($liked == true)
			echo "<img class='liked' src='images/heart-3.png' width='23px' onClick='toggle(this,\"$elem->photo_id\");'>";
		else
			echo "<img class='unliked' src='images/heart-4.png' width='23px' onClick='toggle(this,\"$elem->photo_id\");'>";

// onClick='toggle(\"$elem\", \"$photo\", \"$liked\");'>";
		// foreach ($allphotoliked as $photo) {
			// var_dump($photo);
		// }


	// 	$req = $pdo->prepare('SELECT photo_id FROM photos WHERE photo_path = :photopath');
	// 	$req->execute(['photopath' => $elem]);
	// 	$res = $req->fetch();


		/*
		foreach ($allphotoliked as $photo)
		{
			if ($photo === $res->photo_id)
			{
				$liked = 1;
				echo "<img id='heart-liked' src='images/heart-3.png' width='23px' onClick='toggle(\"$elem\", \"$photo\", \"$liked\");'>

				<script>console.log(\"meuuuh\");</script>";
				break;
			}
		}
		if ($liked == 0)
			echo "<img id='heart-unliked' src='images/heart-4.png' width='23px' onClick='toggle(\"$elem\", \"$res->photo_id\", \"$liked\");'>";
		*/
		// require 'inc/footer.php';
	 }
	?>
</div>
<script type="text/javascript" src="set-gallery.js"></script>

