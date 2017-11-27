function deletePhoto(photo) {
	if (confirm("Es-tu sûr de vouloir supprimer cette photo?"))
	{
		var xml = new XMLHttpRequest();
		xml.open('POST', 'deletePhoto.php', true);
		xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xml.send("photo_path=" + photo);
		window.location.reload();
	}
}