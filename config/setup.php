<?php
// require 'header.php'
include './database.php';

// function create_database() {
//----> CREATE_DATABASE <----
if (isset($_POST['create'])) {
	try {
		$dbh = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);
		//set the PDO error mode to exception
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//User exec() and not query because no results are returned
		//Creating connection for MySql
		// $val = $dbh->query('SELECT 1 FROM camagru');
		// echo "'test'";
		// echo $val . '<br/>';
		// if ($val === FALSE)
		// {

		$sql = "CREATE DATABASE camagru";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Database Created Successfully');</script>";
		// }
		// else {
		// 	echo "Database already exists<br/>";
		// }

	}
	catch (PDOException $e)
	{
		echo "Error Creation Database:\t".$e->getMessage()."\n";
	}
	//----> CREATE_TABLE USER <----
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE User (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL,
			username VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			email VARCHAR(255) NOT NULL,
			confirmation_token varchar(60) NULL,
			confirmation_at DateTime NULL,
			reset_token VARCHAR(60) NULL,
			reset_at DateTime NULL
		)";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Table User Created Successfully');</script>";
	}
	catch (PDOException $e)
	{
		echo "Error Creation Table User!:\t".$e->getMessage()."\n";
	}
	//----> CREATE_TABLE PHOTOS<----
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE Photos (
			UserOwnerID INT NOT NULL,
		 	PhotoID INT NOT NULL,
			Date_Photo DateTime DEFAULT CURRENT_TIMESTAMP,
			Photo_info blob NOT NULL
		)";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Table Photos Created Successfully');</script>";
	}
	catch (PDOException $e)
	{
		echo "Error Creation Table Photos!:\t".$e->getMessage()."\n";
	}
	//----> CREATE_TABLE COMMENTS<----
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE Comments (
			UserCommentID INT NOT NULL,
			PhotoID INT NOT NULL,
			Date_Comment DateTime DEFAULT CURRENT_TIMESTAMP,
			Comment varchar(255) NOT NULL
		)";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Table Comments Created Successfully');</script>";
	}
	catch (PDOException $e)
	{
		echo "Error Creation Table Comments!:\t".$e->getMessage()."\n";
	}
	//----> CREATE_TABLE LIKE<----
	try {
		$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE LikePhoto (
			UserLikeID INT NOT NULL,
			Date_Like DateTime DEFAULT CURRENT_TIMESTAMP,
			PhotoID INT NOT NULL
		)";
		$dbh->exec($sql);
		echo "<script type= 'text/javascript'>alert('Table Like Created Successfully');</script>";
	}
	catch (PDOException $e)
	{
		echo "Error Creation Like Comments!:\t".$e->getMessage()."\n";
	}
}
// if (isset($_POST['re-create'])) {
//
// }
//
// if (isset($_POST['delete'])) {
// 	try {
// 		$dbhost = 'localhost';
// 		$connect = mysql_connect($dbhost, $DB_USER, $DB_PASSWORD);
// 		$mysql = 'DROP DATABASE camagru';
// 		if (mysql_query($sql, $connect))
// 		echo "Database deleted successfully";
// 	}
// 	catch (PDOException $e)
// 	{
// 		echo "Error Deleting Database".$e->getMessage()."\n";
// 	}
// }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../Camagru/Config/setup.css">
</head>
<body>
		<form method="post">
			<input type="submit" name="create" value="Create" />
			<input type="submit" name="re-create" value="Re-Create" />
			<input type="submit" name="delete" value="Delete" />
		</form>
</body>
</html>
