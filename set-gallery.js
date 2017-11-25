// var elem;

// console.log("OK");
// elem = document.getElementById('like');
// elem.addEventListener("click", like_photo);
function toggle(obj, photoid) {
	console.log(obj.className);
	console.log(photoid);
	var like;
	if (obj.className == "liked") {
		obj.className = "unliked";
		obj.src = "images/heart-4.png";
		like = 0;
	}
	else {
		obj.className = "liked";
		obj.src = "images/heart-3.png";
		like = 1;
	}
	// if (flag == 1)
	// 	var photo = document.getElementById("heart-liked");
	// else
	// 	var photo = document.getElementById("heart-unliked");
	// var tab = photo.src.split('/').reverse();
	// var like;
	// var current_src = "images/"+tab[0];
	// if (current_src == "images/heart-4.png")
	// {
	// 	like = 1;
	// 	newsrc = "images/heart-3.png";
	// }
	// else {
	// 	like = 0;
	// 	newsrc = "images/heart-4.png";
	// }
	// photo.src = newsrc;
	// console.log(photo.src);
	var xml = new XMLHttpRequest();
	xml.open('POST', 'like.php', true);
	xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xml.send("photoid=" + photoid + "&like=" + like);
	console.log("APRES");
}

function display(obj, photoid)
{

}
