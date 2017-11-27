var streaming = false,
	video = document.querySelector('#video'),
	cover        = document.querySelector('#cover'),
	canvas       = document.querySelector('#canvas'),
	photo        = document.querySelector('#photo'),
	startbutton  = document.querySelector('#startbutton'),
	filter       = 1,
	width = 520,
	height = 0;
	function getFilter(num)
	{
		filter = num;
	}
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
			// photo.setAttribute('src', data);
			sendData(data);
		}
		function sendData(data)
		{
			var xml = new XMLHttpRequest();
			xml.open('POST', 'get-webcam-photo.php', true);
			xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xml.send("data=" + data + "&filter=" + filter);
			xml.onload = function () {
				window.location.reload();
			};
		}
		// 	xml.onload = function()
		// {
		// 	var response = xml.responseText;
		// 	photo.src = response;
		// 	console.log(response);
		// }
