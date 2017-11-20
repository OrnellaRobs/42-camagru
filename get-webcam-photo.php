<?php
session_start();
if (!empty($_POST))
{
	// $directory = "/photos";
	// if (!file_exists($directory))
	// 	mkdir($directory, 0777, true);
	$img = $_POST['data'];
	$get_img_data = explode(',', $img);
	$get_img_type_without_base64 = explode(';', $get_img_data[0]);
	$get_img_type = explode('/', $get_img_type_without_base64[0]);
	$type = $get_img_type[1];
	$img = $get_img_data[1];
	$img = str_replace(' ', '+', $img);
	$filedata = base64_decode($img);
	$filepath = "./photos/";
	$filter = $_POST["filter"];
	$date_photo = time();
	$filename = $filepath . $filter . "-" . $_SESSION['auth']->username ."-". $date_photo . '.' . $type;
	file_put_contents($filename, $filedata);
	//SUPERPOSER DEUX IMAGES
	header ("Content-type: image/png");
	if ($filter == "1")
		$source = imagecreatefrompng("./images/DONUT.png");
	else if ($filter == "2")
		$source = imagecreatefrompng("./images/pizza.png");
	else if ($filter == "3")
		$source = imagecreatefrompng("./images/POW.png");
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	imagealphablending($source, true);
	imagesavealpha($source, true);

	$destination = imagecreatefrompng("$filename");
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);

	$destination_x = ($largeur_destination - $largeur_source)/2;
	$destination_y = ($hauteur_destination - $hauteur_source)/2;

	imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);

	imagepng($destination, "photos/new.png");

	imagedestroy($source);
	imagedestroy($destination);
	require_once 'inc/db.php';
	$req = $pdo->prepare("INSERT INTO Photos SET UserOwnerID = :userOwner, Date_Photo = :date_photo, Photo_info = :photo_info");
	$req->execute([
		'userOwner' => $_SESSION['auth']->username,
		'date_photo' => $date_photo,
		'photo_info' => //sendIMAGEblob a rechercher sur GOOGLE,
	]);
	// imagedestroy($source);
	//METTRE DANS TABLEAU PHOTOS DANS LA DB
	exit();
}
?>
