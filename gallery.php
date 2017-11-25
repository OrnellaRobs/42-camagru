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
	$req = $pdo->prepare('SELECT photo_path FROM photos ORDER BY date_photo');
	$req->execute();
	$result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	$count = count($result);
	// echo $count;
	// $req = $pdo->prepare('SELECT photo_path(*) AS photo from photos');
	// $req->execute();
	// $articles = $req->fetch(PDO::FETCH_ASSOC);
	// $total_articles = $articles['photo'];
	// $nombredepage = ceil($total_articles/$photos_per_page);
	// $nombredepage = ceil($count / $photos_per_page);
	// echo $nombredepage;
	// if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>0 && $_GET['page']<= $nombredepage)
	// 	$page=intval($_GET['page']);
	// else
	// 	$page=1;
	$i = 0;
	$user_id = $_SESSION['auth']->id;
	$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
	$req->execute(['userlikeid' => $user_id]);
	$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	// var_dump($allphotoliked);

	foreach ($result as $elem)
	{
		$liked = 0;
		echo '<img src="'.$elem.'" height="200px" />';
		$req = $pdo->prepare('SELECT photo_id FROM photos WHERE photo_path = :photopath');
		$req->execute(['photopath' => $elem]);
		$res = $req->fetch();
		foreach ($allphotoliked as $photo)
		{
			if ($photo === $res->photo_id)
			{
				$liked = 1;
				echo "<img id='heart' src='images/heart-3.png' width='23px' onClick='toggle(\"$elem\", \"$photo\");'>";
				break;
			}
		}
		if ($liked == 0)
			echo "<img id='heart' src='images/heart-4.png' width='23px' onClick='toggle(\"$elem\", \"$photo\");'>";
		echo '</div>';
		echo '<script type="text/javascript" src="set-gallery.js"></script>';
		require 'inc/footer.php';
	}
	?>
</div>
