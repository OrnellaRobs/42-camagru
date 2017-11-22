<?php
require 'inc/functions.php';
check_session();
logged_only();

require 'inc/header.php';
?>
<h1>Les photos des autres utilisateurs</h1>
<div class="wrapper-filter-webcam">
	<?php
	require_once './inc/db.php';
	$req = $pdo->prepare('SELECT photo_path FROM photos');
	$req->execute();
	$result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	// var_dump($result);
	foreach ($result as $elem)
	{
		echo '<img src="'.$elem.'" height="200px" />';
		echo '<img src="images/like.png" width="30px" onClick="like();"/>';
		echo '<img src="images/comment.png" width="50px" onClick="comment();"/>';
	}
	?>
</div>
<script type="text/javascript" src="./set-gallery.js"></script>
<?php require 'inc/footer.php'; ?>