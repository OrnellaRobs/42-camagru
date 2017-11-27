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

	$user_id = $_SESSION['auth']->id;
	$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
	$req->execute(['userlikeid' => $user_id]);
	$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);

	foreach ($result as $elem)
	{
	 	echo '<img src="'.$elem->photo_path.'" height="200px" />';
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
		echo "<a href='comment.php?url=$elem->photo_path&photoid=$elem->photo_id'><img src='images/comment.png' width='40px'></a>";
	}
	?>
</div>
<script type="text/javascript" src="set-gallery.js"></script>
<?php require 'inc/footer.php'; ?>
