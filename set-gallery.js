var elem;

// console.log("OK");
// elem = document.getElementById('like');
// elem.addEventListener("click", like_photo);
function toggle(tabphoto) {
	// console.log("HELLO");
	// console.log(tabphoto);
	// var newsrc = (img.src == 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-4.png') ? 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-3.png' : 'http://127.0.0.1:8080/Camagru-Grafik-Art/images/heart-4.png';
	// img.src = newsrc;
	// console.log(tabphoto);
	var photo = document.getElementById("heart");
	// console.log(photo);
	var tab = photo.src.split('/').reverse();
	var like;
	var current_src = "images/"+tab[0];
	if (current_src == "images/heart-4.png")
	{
		like = 1;
		newsrc = "images/heart-3.png";
	}
	else {
		like = 0;
		newsrc = "images/heart-4.png";
	}
	photo.src = newsrc;
	console.log(photo.src);
	// photo.src =
	// var xml = new XMLHttpRequest();
	// xml.open('POST', 'like.php', true);
	// xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	// xml.send("imgsrc=" + newsrc + "&tabphoto=" + tabphoto);
	// console.log("APRES");
}
