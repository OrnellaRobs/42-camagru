<?php
require 'inc/functions.php';
check_session();
logged_only();
require 'inc/header.php';
if (!empty($_GET) && isset($_GET['pic']))
{
	$img = $_GET['pic'];
	echo '<img src="'.$img.'" height="500px" />';
}
?>
<form method="post" action="">

<p>
    On insèrera ici les éléments de notre formulaire.
</p>
<input type="text" value="OK">

</form>
<?php require 'inc/footer.php'; ?>