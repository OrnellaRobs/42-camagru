<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
require './inc/db.php';

if (!empty($_GET) && isset($_GET['url']) && isset($_GET['photoid']))
{
	var_dump($_GET);
	echo '<img src= "'. $_GET["url"] .'">';
}
if (!empty($_POST))
{
	var_dump($_POST);
	$userid = $_SESSION['auth']->id;
	$req = $pdo->prepare('INSERT INTO comments SET usercomment_id = :userid, photo_id = :photoid,
	date_comment = NOW() , comment = :commentaire');
	$req->execute([
		'userid' => $userid,
		'photoid' => $_GET['photoid'],
		'commentaire' => $_POST['commentaire']
	]);
	//FIRST REQUEST TO KNOW THE OWNER OF THE PHOTO COMMENTED
	$requser = $pdo->prepare('SELECT user_id FROM photos WHERE photo_id = :photoid');
	$requser->execute([
		'photoid' => $_GET['photoid']
	]);
	$getownerphoto = $requser->fetch();
	//SECOND REQUEST TO SEND A MAIL TO THE OWNER OF THE PHOTO COMMENTED
	$reqmail = $pdo->prepare('SELECT email FROM user WHERE id = :userid');
	$reqmail->execute([
		'userid' => $getownerphoto->user_id
	]);
	$getmail = $reqmail->fetch();
	// $getmail->email;
	$entetes =
	'Content-type: text/html; charset=utf-8' . "\r\n" .
	'From: no-reply@camagru.fr' . "\r\n" .
	'Reply-To: no-reply@camagru.fr' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	$objet = "Nouveau Commentaire sous votre photo";
	$content = "$";
	if (mail($_POST['email'], $objet, $content, $entetes))
	{
		$_SESSION['success'] = "Un email de confirmation a été envoyé pour valider le compte";
		header('Location: index.php');
		exit();
	}
}
?>
<form method="post" action="">

	<p>
		Votre commentaire :
	</p>
	<label for="commentaire">Message</label> : <input type="text" name="commentaire" id="commentaire" /><br />
	<input type="submit" value="Envoyer" />
	<!-- <input type="text">
	<input type="submit" value="Envoyer"> -->
</form>

<?php
	$req = $pdo->prepare('SELECT comment FROM comments');
	$req->execute();
	$allComments = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	var_dump($allComments);
	foreach($allComments as $Comments)
	{
		echo '<div class="">';
		echo $Comments . "<br/>";
		echo '</div>';
	}
?>
<?php require 'inc/footer.php'; ?>
