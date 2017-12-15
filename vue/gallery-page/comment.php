
<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
require_once dirname(__FILE__) . '/../../inc/db.php';
?>
<div class="baba">
<div class="wrapper-picture-commented">
	<center style="position:relative;">
		<img class="logo" src="/Camagru-Grafik-Art/images/logo.png" style="width:90px;margin-bottom:30px;"/>
		<center style="position:absolute; top: -41px; left: 57%;">
			<img src="/Camagru-Grafik-Art/images/comment-page.png" style="width: auto;height: 70px;">
		</center>
	</center>
<?php
if (!empty($_GET) && isset($_GET['url']) && isset($_GET['photoid']))
{
	echo '<img src= "'. $_GET["url"] .'">';
}
if (!empty($_POST) && isset($_POST['commentaire']) && $_POST['commentaire'] != "")
{
	$userid = $_SESSION['auth']->id;
	$username = $_SESSION['auth']->username;
	$req = $pdo->prepare('INSERT INTO comments SET usercomment_id = :userid, usercomment_username = :username, photo_id = :photoid,
		date_comment = NOW() , comment = :commentaire');
		$req->execute([
			'userid' => $userid,
			'username' => $username,
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
		<img src="/Camagru-Grafik-Art/images/comment-page.png" width="40px;"/>
		<div class="wrapper-form-comment">
		<textarea class="comment" name="commentaire" id="commentaire" rows="4" cols="50"></textarea>
		<input class="comment-submit" type="submit" value="Envoyer" />
	</div>
	</form>
</div>
	<div class="all-comments">
		<img class="wrapper-title-comment"src="/Camagru-Grafik-Art/images/others-comments.jpg" style="width: 400px;">
		<div class="pol">
	<?php
	$req = $pdo->prepare('SELECT * FROM comments WHERE photo_id = :photoid');
	$req->execute(['photoid' => $_GET['photoid']]);
	$allComments = $req->fetchAll();
	// var_dump($allComments);
	foreach($allComments as $Comments)
	{
		echo '<div class="each-comment">';
		echo "\"" . $Comments->comment . "\"";
		echo '</div>';
		echo '<div class="each-comment-info">';
		echo $Comments->usercomment_username . " le " . $Comments->date_comment;
		// if ($Comments->usercomment_id === $_SESSION['auth']->id)
		// 	echo "<img class='delete-comment' src='/Camagru-Grafik-Art/images/delete-comment.png' width='18px' onClick='deleteComment(\"$Comments->comment_id\");'>";
		echo '</div>';
	}
	?>
</div>
</div>
</div>
<script type="text/javascript" src="delete-comment.js"></script>
	<?php require_once dirname(__FILE__) . '/../footer/footer.php';?>
