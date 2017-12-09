<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../../inc/db.php';

if (!empty($_GET) && isset($_GET['url']) && isset($_GET['photoid']))
{
	echo '<img src= "'. $_GET["url"] .'">';
}
if (!empty($_POST))
{
	$userid = $_SESSION['auth']->id;
	$username = $_SESSION['auth']->username;
	$req = $pdo->prepare('INSERT INTO comments SET usercomment_id = :userid, photo_id = :photoid,
		date_comment = NOW() , comment = :commentaire');
		$req->execute([
			'userid' => $userid,
			'photoid' => $_GET['photoid'],
			'commentaire' => $_POST['commentaire']
		]);
		// //FIRST REQUEST TO KNOW THE OWNER OF THE PHOTO COMMENTED
		$requser = $pdo->prepare('SELECT * FROM photos WHERE photo_id = :photoid');
		$requser->execute([
			'photoid' => $_GET['photoid']
		]);
		$reqanswer = $requser->fetchAll();

		// $getownerphoto = $requser->fetch();
		// //SECOND REQUEST TO SEND A MAIL TO THE OWNER OF THE PHOTO COMMENTED
		$userInfo = $pdo->prepare('SELECT * FROM user WHERE id = :userid');
		$userInfo->execute([
			'userid' => $reqanswer[0]->user_id
		]);
		$getInfo = $userInfo->fetchAll();

		if ($getInfo[0]->mail_comments == 1)
		{
			$commentaire = $_POST['commentaire'];
			$entetes =
			'Content-type: text/html; charset=utf-8' . "\r\n" .
			'From: no-reply@camagru.fr' . "\r\n" .
			'Reply-To: no-reply@camagru.fr' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			$url_without_dot = str_replace('.', '', $_GET['url']);
			$urlphoto = "localhost:8080/Camagru-Grafik-Art".$url_without_dot;
			$objet = "Nouveau Commentaire sous votre photo";
			$content = "$username a commenté votre photo: « $commentaire »";
			mail($getInfo[0]->email, $objet, $content, $entetes);
		}
		$_SESSION['success'] = "Commentaire envoyé!";
		header('Location: comment.php?url='.$reqanswer[0]->photo_path.'&photoid='.$reqanswer[0]->photo_id.'');
		exit();
	}
	?>
	<form method="post" action="">

		<p>
			Votre commentaire :
		</p>
		<label for="commentaire">Message</label> : <input type="text" name="commentaire" id="commentaire" /><br />
		<input type="submit" value="Envoyer" />
	</form>
	<h1>Autres commentaires sur cette photo: </h1>
	<?php
	$req = $pdo->prepare('SELECT comment FROM comments WHERE photo_id = :photoid');
	$req->execute(['photoid' => $_GET['photoid']]);
	$allComments = $req->fetchAll(PDO::FETCH_COLUMN, 0);
	foreach($allComments as $Comments)
	{
		echo '<div class="">';
		echo $Comments . "<br/>";
		echo '</div>';
	}
	?>
	<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
