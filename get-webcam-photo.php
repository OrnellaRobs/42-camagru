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
	$filename = $filepath . $_SESSION['auth']->username ."-". time() . '.' . $type;
	file_put_contents($filename, $filedata);
	exit();
}
?>