<?php
require 'inc/functions.php';
check_session();
logged_only();

require 'inc/header.php';
?>
<h1>Les photos des autres utilisateurs <?= 	$_SESSION['auth']->name; ?></h1>
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
	}
	?>
</div>
<?php require 'inc/footer.php'; ?>