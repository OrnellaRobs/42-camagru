<?php
require 'inc/functions.php';
check_session();
logged_only();

if (!empty($_POST))
{
	// $directory = "/photos";
	// if (!file_exists($directory))
	// 	mkdir($directory, 0777, true);
	$img = $_POST['data'];
	$get_img_data = explode(',', $img);
	$get_img_type_without_base64 = explode(';', $get_img_data[0]);
	$get_img_type = explode('/', $get_img_type_without_base64[0]);
	$type = $get_img_type[1];
	$img = $get_img_data[1];
	$img = str_replace(' ', '+', $img);
	$filedata = base64_decode($img);
	$filepath = "./photos/";
	$filename = $filepath . $_SESSION['auth']->username ."-". time() . '.' . $type;
	file_put_contents($filename, $filedata);
}
?>
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<div class="wrapper-filter-webcam">
	<label for="" class="choose-filter">
		<input type="radio" name="filtre" value="1">
		<img src="images/donut.png" title="donut.png" width="60px"/>
		<input type="radio" name="filtre" value="2">
		<img src="images/pizza.png" title="pizza.png" width="80px"/>
		<input type="radio" name="filtre" value="3">
		<img src="images/pow.png" title="pow.png" width="60px"/>
	</label>
	<video id="video" class="webcam-live"></video>
	<button id="startbutton"> Prendre une photo</button>
</div>
<canvas id="canvas"></canvas>
<img src="http://placekitten.com/g/320/261" id="photo" alt="photo">
<script type="text/javascript" src="./webcam.js"></script>
<?php require 'inc/footer.php'; ?>
