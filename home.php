<?php
require 'inc/functions.php';
check_session();
logged_only();

?>
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<div class="wrapper-filter-webcam">
	<label for="" class="choose-filter">
		<input type="radio" name="filter" value="1">
		<img src="images/donut.png" title="donut.png" width="60px"/>
		<input type="radio" name="filter" value="2">
		<img src="images/pizza.png" title="pizza.png" width="80px"/>
		<input type="radio" name="filter" value="3">
		<img src="images/pow.png" title="pow.png" width="60px"/>
	</label>
	<video id="video" class="webcam-live"></video>
	<button id="startbutton">Prendre une photo</button>
</div>
<canvas id="canvas" style="display:none;"></canvas>
<img src="http://placekitten.com/g/320/261" id="photo" alt="photo">
<script type="text/javascript" src="./webcam.js"></script>
<?php require 'inc/footer.php'; ?>
