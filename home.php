<?php
require 'inc/functions.php';
check_session();
logged_only();

if (!empty($_POST))
{
	$directory = './photos';
	if (!file_exists($directory))
	mkdir($directory, 0777, true);
	$get_data = explode(',', $_POST['data']);
	$img_details = $get_data[0];
	$img_encoded = $get_data[1];

	$img_details_without_base64 = explode(';', $img_details);
	$img_type = explode('/', $img_details_without_base64[0]);

	$today = new DateTime();
	$date = $today->getTimestamp();

	$user = $_SESSION['auth']->username;
	$output_file_with_type = $user."-".$date.".".$img_type[1];
	$img_decoded = base64_decode($img_encoded);
	$filename = "$directory/$output_file_with_type";
	file_put_contents($filename, $img_decoded);
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
