var streaming = false,
video = document.querySelector('#video'),
cover        = document.querySelector('#cover'),
canvas       = document.querySelector('#canvas'),
photo        = document.querySelector('#photo'),
startbutton  = document.querySelector('#startbutton'),
sendbutton   = document.querySelector('#sendbutton'),
filter       = 1,
img_upload,
upload = 0,
width = 520,
height = 0;
function getFilter(num)
{
	filter = num;
}
function get_img_upload(img)
{
	if(img.length != 0)
	{

		upload = 1;
		img_upload = img;
	}
	else
	upload = 0;
}
function check_img_extension(img)
{
	var length = img.length;
	var start = length - 4;
	var end = length;
}
if (upload == 0)
{
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
		sendbutton.addEventListener('click', function(ev){
			sendData(img_upload, upload);
			ev.preventDefault();
		},false);
		function takepicture() {
			canvas.width = width;
			canvas.height = height;
			canvas.getContext('2d').drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			// photo.setAttribute('src', data);
			sendData(data, upload);
		}
	}
	function sendData(data, upload)
	{
		var img_data;
		console.log("OK");
		if (upload == 1)
		{
			const reader = new FileReader();
			const file = data.files[0];
			reader.onload = function(upload) {
				img_data = upload.target.result;
				var xml = new XMLHttpRequest()
				xml.open('POST', 'get-webcam-photo.php', true);
				xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xml.send("data=" + img_data + "&filter=" + filter);
				xml.onload = function () {
					window.location.reload();
				}
			};
			reader.readAsDataURL(file);
		}
		else {
			var xml = new XMLHttpRequest()
			xml.open('POST', 'get-webcam-photo.php', true);
			xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xml.send("data=" + data + "&filter=" + filter);
			xml.onload = function () {
				window.location.reload();
			}
		}
	}
