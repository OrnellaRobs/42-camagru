<?php
require_once dirname(__FILE__) . '/../../inc/functions.php';
check_session();
logged_only();
require_once dirname(__FILE__) . '/../header/header.php';
require_once dirname(__FILE__) . '/../navbar/navbar.php';
echo "HELLO";
if (!empty($_POST) && isset($_POST['commentID']) && $_POST['commentID'] != "")
{
	echo "SALUT";
}
?>