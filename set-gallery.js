var elem;

// console.log("OK");
// elem = document.getElementById('like');
// elem.addEventListener("click", like_photo);
function toggle(img, tabphoto) {
	console.log("HELLO");
	console.log(tabphoto);
	var newsrc = (img.src == 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-4.png') ? 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-3.png' : 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-4.png';
	img.src = newsrc;
	// console.log(img);
	// var xml = new XMLHttpRequest();
	// xml.open('POST', 'like.php', true);
	// xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// xml.send("imgsrc=" + newsrc + "&tabphoto=" + tabphoto);
	console.log("APRES");
}
