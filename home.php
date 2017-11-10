<?php
require 'inc/functions.php';
check_session();
logged_only();
if (!empty($_POST))
{
	if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm-password']) {
		$_SESSION['danger'] = "Les mots de passes ne correspondent pas";
	}
	else {
		$user_id = $_SESSION['auth']->id;
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		require_once 'inc/db.php';
		$req = $pdo->prepare('UPDATE User SET password = ?');
		$req->execute([$password]);
		$_SESSION['success'] = "Votre mot de passe a bien été mis à jour";
	}
}
?>
<?php require 'inc/header.php'; ?>
<h1>Bonjour <?= $_SESSION['auth']->name; ?></h1>
<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<canvas id="canvas"></canvas>
<!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->
<label for="">
	<INPUT type="radio" name="choix" value="1">donut.png
	<INPUT type="radio" name="choix" value="2">best-choice.png
	<INPUT type="radio" name="choix" value="3">pow.png
</label>
<script>
(function() {
	var streaming = false,
	video = document.querySelector('#video'),
	cover        = document.querySelector('#cover'),
	canvas       = document.querySelector('#canvas'),
	photo        = document.querySelector('#photo'),
	startbutton  = document.querySelector('#startbutton'),
	width = 520,
	height = 0;

	navigator.getMedia = ( navigator.getUserMedia ||
		navigator.webkitGetUserMedia ||
		navigator.mozGetUserMedia ||
		navigator.msGetUserMedia);
		navigator.getMedia(
			{
				video: true,
				audio: false
			},
			function(stream) {
				if (navigator.mozGetUserMedia) {
					video.mozSrcObject = stream;
				} else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
			},
			function(err) {
				console.log("An error occured! " + err);
			}
		);
		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);
		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);
		function takepicture() {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			photo.setAttribute('src', data);
		}
		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);
	})();
	</script>
	<?php require 'inc/footer.php'; ?>
