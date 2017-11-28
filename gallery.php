<?php
require 'inc/functions.php';
check_session();
// logged_only();

require 'inc/header.php';
require './inc/db.php';
if (isset($_SESSION['auth']))
{
	$user_id = $_SESSION['auth']->id;
	$req = $pdo->prepare('SELECT photo_id FROM likephoto WHERE userlike_id = :userlikeid');
	$req->execute(['userlikeid' => $user_id]);
	$allphotoliked = $req->fetchAll(PDO::FETCH_COLUMN, 0);
}
?>
<h1>Afficher selon les filtres :</h1>
<a href="gallery.php?filter=1"><img src="./images/DONUT.png" width="100px"></a>
<a href="gallery.php?filter=2"><img src="./images/pizza.png" width="100px"></a>
<a href="gallery.php?filter=3"><img src="./images/POW.png" width="100px"></a><br/>
<?php if (!empty($_GET))
{
	$request = $pdo->prepare('SELECT * FROM photos WHERE filter = :filter');
	$request->execute(['filter' => $_GET['filter']]);
	$allPhotoWithFilter = $request->fetchAll();
	foreach($allPhotoWithFilter as $filter) {
		echo '<div class="">';
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
			echo '</div>';
		}
	}
}
?>
<?php if (empty($_GET)):?>
	<h1>Les photos des autres utilisateurs</h1>
	<div class="wrapper-user-photo">
		<?php
		$req = $pdo->prepare('SELECT * FROM photos ORDER BY date_photo');
		$req->execute();
		$result = $req->fetchAll();

		foreach ($result as $elem)
		{
			echo '<div class="">';
			echo '<img src="'.$elem->photo_path.'" height="200px" />';
			$liked = false;
			if (isset($_SESSION['auth']))
			{
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
				echo '</div>';
			}
		}
		?>
	</div>
<?php endif; ?>
<script type="text/javascript" src="set-gallery.js"></script>
<?php require 'inc/footer.php'; ?>
