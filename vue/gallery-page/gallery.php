<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';

$photo_per_page = 5;
$request = $pdo->prepare('SELECT * FROM photos ORDER BY date_photo');
$request->execute();
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
?>
<div class="title">
	<center><img id="img-login" src="/camagru/images/logo.png" width="90px;"/></center>
	<center><img id="img-login" src="/camagru/images/gallery.jpg" width="160px;"/></center>
</div>
<div class="display-filter">
<!-- <div class="head-msg"> -->
	<!-- <h1>Afficher selon les filtres :</h1> -->
<!-- </div> -->
<div class="filter">
<a href="filter.php?filter=1"><img src="../../images/DONUT.png" width="200px"></a>
<a href="filter.php?filter=2"><img src="../../images/pizza.png" width="200px"></a>
<a href="filter.php?filter=3"><img src="../../images/POW.png" width="200px"></a><br/>
</div>
</div>
	<!-- <h1><center>Les photos des autres utilisateurs</center></h1> -->
		<?php
		$req = $pdo->prepare('SELECT * FROM photos ORDER BY date_photo DESC LIMIT '.$start.','.$photo_per_page.'');
		$req->execute();
		$result = $req->fetchAll();
		echo '<div class="allPhotos">';
		foreach ($result as $elem)
		{
			echo '<div class="wrapper-photo">';
			echo '<img class="each-photo" src="'.$elem->photo_path.'" height="200px" />';
			$liked = false;
			if (isset($_SESSION['auth']))
			{
				foreach ($allphotoliked as $photo) {
					if ($photo === $elem->photo_id) {
						$liked = true;
						break;
					}
				}
				echo '<div class="like-and-comment">';
				if ($liked == true)
					echo "<img class='liked' src='/camagru/images/heart-3.png' width='23px' onClick='toggle(this,\"$elem->photo_id\");'>";
				else
					echo "<img class='unliked' src='/camagru/images/heart-4.png' width='23px' onClick='toggle(this,\"$elem->photo_id\");'>";
				echo "<a href='comment.php?url=$elem->photo_path&photoid=$elem->photo_id'><img src='/camagru/images/comment.png' width='40px'></a>";
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div>';
		echo '<div class="pagination">';
		for ($i=1; $i<=$count_pages; $i++) {
			echo '<a href="gallery.php?page='.$i.'">'.$i.'</a>';
			if ($i < $count_pages)
				echo "-";
		}
		echo '</div>';
		?>
<script type="text/javascript" src="./set-gallery.js"></script>
<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
