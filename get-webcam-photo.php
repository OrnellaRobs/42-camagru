<?php
session_start();
if (!empty($_POST) && isset($_POST['data']))
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
	$img_fusion = "photos/new.png";
	imagepng($destination, $img_fusion);

	imagedestroy($source);
	imagedestroy($destination);
	require_once './inc/db.php';
	$req = $pdo->prepare("INSERT INTO `photos` SET username = :username, photo_type = :photo_type");
	$req->execute([
		'username' => $_SESSION['auth']->username,
		'photo_type'=> $type
	]);
	// try
	// {
	// 	require_once './inc/db.php';
	// 	$req = $pdo->prepare('INSERT INTO photos (username, date_photo, photo_type) VALUES (:username, NOW(), :phototype)');
	// 	$req->execute(array(
	// 		':username' => $_SESSION['auth']->username,
	// 		':phototype' => $type
	// 	));
	// }
	// catch (                                                PDOException $e)
	// {
	// 	echo "Couldn't write in Database: " . $e->getMessage();
	// }
	//METTRE DANS TABLEAU PHOTOS DANS LA DB
	// exit();
}
?>
<!--  -->