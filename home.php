<?php
require 'inc/functions.php';
check_session();
logged_only();

?>
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<form class="container" action="" method="POST">
	<div class="wrapper-filter-webcam">
		<label><input id="1" type="radio" name="filter" value="1" checked onClick="getFilter(1);"></label>
		<img src="images/donut.png" title="donut.png" width="60px"/>
		<label><input id="2" type="radio" name="filter" value="2" onClick="getFilter(2);"></label>
		<img src="images/pizza.png" title="pizza.png" width="80px"/>
		<label><input id="3" type="radio" name="filter" value="3" onClick="getFilter(3);"/></label>
		<img src="images/pow.png" title="pow.png" width="60px"/>
		<video id="video" class="webcam-live"></video>
		<button id="startbutton">Prendre une photo</button>
	</div>
	<div class="wrapper-user-photo">
		<?php
		require './inc/db.php';
		try
		{
			$userid = $_SESSION['auth']->id;
			$req = $pdo->prepare('SELECT photo_path FROM photos WHERE user_id = ?');
			$req->execute([$userid]);

			$result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
			foreach ($result as $elem)
			{
				echo '<div class="photo-user">';
				echo '<img src="'.$elem.'" height="200px" />';
				echo "<input type='button' value='Supprimer' onClick='deletePhoto(\"$elem\", \"$userid\");'>";
				echo '</div>';
			}
		}
		catch (PDOException $e)
		{
			echo "fail";
		}
		?>
	</div>
</form>
<canvas id="canvas" style="display:none;"></canvas>
<!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->
<script type="text/javascript" src="./webcam.js"></script>
<script type="text/javascript" src="./deletePhoto.js"></script>
<?php require 'inc/footer.php'; ?>
