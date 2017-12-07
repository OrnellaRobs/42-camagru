<?php
require 'inc/functions.php';
check_session();

require 'inc/header.php';
require './inc/db.php';
?>
<h1>Afficher selon les filtres :</h1>
<a href="filter.php?filter=1"><img src="./images/DONUT.png" width="100px"></a>
<a href="filter.php?filter=2"><img src="./images/pizza.png" width="100px"></a>
<a href="filter.php?filter=3"><img src="./images/POW.png" width="100px"></a><br/>
<?php
if (!empty($_GET) && isset($_GET['filter']))
{
	$photo_per_page = 6;
	$request = $pdo->prepare('SELECT * FROM photos WHERE filter = :filter ORDER BY date_photo DESC');
	$request->execute(['filter' => $_GET['filter']]);
	$get_all = $request->fetchAll();
	$count_photos = count($get_all);
	$count_pages = ceil($count_photos / $photo_per_page);
	if (isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']))
	{
		if ($_GET['page'] > $count_pages)
			$current = $count_pages;
		else
			$current = $_GET['page'];
	}
	else
		$current = 1;
	$start = ($current - 1) * $photo_per_page;
	if (isset($_SESSION['auth']))
	{
		$user_id = $_SESSION['auth']->id;
		$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
		$req->execute(['userlikeid' => $user_id]);
		$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	$req = $pdo->prepare('SELECT * FROM photos WHERE filter = :filter ORDER BY date_photo DESC LIMIT '.$start.','.$photo_per_page.'');
	$req->execute(['filter' => $_GET['filter']]);
	$allPhotoWithFilter = $req->fetchAll();
	foreach($allPhotoWithFilter as $filter) {
		// echo '<div class="">';
		echo '<img src="'.$filter->photo_path.'" height="200px" />';
		$liked = false;
		if (isset($_SESSION['auth']))
		{
			foreach ($allphotoliked as $photo) {
				if ($photo === $filter->photo_id) {
					$liked = true;
					break;
				}
			}
			if ($liked == true)
			echo "<img class='liked' src='images/heart-3.png' width='23px' onClick='toggle(this,\"$filter->photo_id\");'>";
			else
			echo "<img class='unliked' src='images/heart-4.png' width='23px' onClick='toggle(this,\"$filter->photo_id\");'>";
			echo "<a href='comment.php?url=$filter->photo_path&photoid=$filter->photo_id'><img src='images/comment.png' width='40px'></a>";
			// echo '</div>';
		}
	}
	for ($i=1; $i<=$count_pages; $i++) {
		echo '<a href="filter.php?filter='.$_GET['filter'].'&page='.$i.'">'.$i.'</a> ';
		if ($i < $count_pages)
			echo "-";
	}
}
?>
<script type="text/javascript" src="set-gallery.js"></script>
<?php require 'inc/footer.php'; ?>
