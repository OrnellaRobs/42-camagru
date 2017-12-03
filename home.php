<?php
require 'inc/functions.php';
check_session();
logged_only();

?>
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<form class="container" action="" method="POST" enctype="multipart/form-data">
	<div class="wrapper-filter-webcam">
		<label><input id="1" type="radio" name="filter" value="1" checked onClick="getFilter(1);"></label>
		<img src="images/donut.png" title="donut.png" width="60px"/>
		<label><input id="2" type="radio" name="filter" value="2" onClick="getFilter(2);"></label>
		<img src="images/pizza.png" title="pizza.png" width="80px"/>
		<label><input id="3" type="radio" name="filter" value="3" onClick="getFilter(3);"/></label>
		<img src="images/pow.png" title="pow.png" width="60px"/>
		<video id="video" class="webcam-live"></video>
		<label><input type="file" name="img" onchange="get_img_upload(this)"/></label>
		<button id="sendbutton">Envoyer la photo</button>
		<button id="startbutton">Prendre une photo</button>
	</div>
	<div class="wrapper-user-photo">
		<?php
		require './inc/db.php';
		try
		{
			$userid = $_SESSION['auth']->id;
			//PAGINATION
			$photo_per_page = 9;
			$request = $pdo->prepare('SELECT * FROM photos WHERE user_id = ?');
			$request->execute([$userid]);
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
			echo $count_pages;            //

			$req = $pdo->prepare('SELECT photo_path FROM photos WHERE user_id = ? ORDER BY date_photo DESC LIMIT '.$start.','.$photo_per_page.'');
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
		for ($i=1; $i<=$count_pages; $i++) {
			echo '<a href="home.php?page='.$i.'">'.$i.'</a> ';
			if ($i < $count_pages)
				echo "-";
		}
		?>
	</div>
</form>
<canvas id="canvas" style="display:none;"></canvas>
<!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->
<script type="text/javascript" src="./webcam.js"></script>
<script type="text/javascript" src="./deletePhoto.js"></script>
<?php require 'inc/footer.php'; ?>
