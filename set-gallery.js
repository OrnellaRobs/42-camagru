var elem;

// console.log("OK");
// elem = document.getElementById('like');
// elem.addEventListener("click", like_photo);
function toggle(tabphoto, $photo_id) {
	var photo = document.getElementById("heart");
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
	var xml = new XMLHttpRequest();
	xml.open('POST', 'like.php', true);
	xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xml.send("photoliked=" + tabphoto + "&like=" + like);
	console.log("APRES");
}
