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
	$nombredepage = ceil($count / $photos_per_page);
	// echo $nombredepage;
	if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>0 && $_GET['page']<= $nombredepage)
	{
		$page=intval($_GET['page']);
	}
	else
	{
		$page=1;
	}
	// echo "<br/>".$page;

	// $req->execute();
	$i = 0;
	foreach ($result as $elem)
	{
		echo '<img src="'.$elem.'" height="200px" />';

		// echo "<img src='images/heart-4.png' width='23px' onClick='toggle(this, ".$elem.");'>";
		// echo "<a href='like.php'><img src='images/heart-4.png' width='23px'></a>";
		echo "<a href='comment.php?pic=" . $elem . "'><img src='images/comment.png' width='50px'></a>";

		echo "<form  method='post' action='comment.php'>
		<input type='text' name='commentaire'>
		</form>";

		// $i++;
	}

	echo '</div>';
	echo '<script type="text/javascript" src="set-gallery.js"></script>';
	require 'inc/footer.php';
	?>
