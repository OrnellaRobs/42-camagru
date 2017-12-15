function deleteComment(comment_id) {
	console.log("OK JAVA");
	if (confirm("Es-tu sûr de vouloir supprimer ce commentaire?")) {
		console.log("OK SURE");
		var xml = new XMLHttpRequest();
		xml.open('POST', 'deleteComment.php', true);
		xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xml.send("commentID=" + comment_id);
		xml.onload = function () {
			window.location.reload();
		}
	}
}