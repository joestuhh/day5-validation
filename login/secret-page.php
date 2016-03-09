<?php
session_start();
//password protect this page. redirect to login if not logged in
$logged_in = $_SESSION['loggedin'];
if(! $_SESSION['loggedin'] = true) {
	header('Location:secret-page.php?itworks=yes');
}else{
	$message = 'You looged in!';
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Top Secret Page</title>
	<style type="text/css" href="style.css">
	body {
		background-image: url('images/uni.gif');
		text-align: center;
	}
	h1 {
		background: rbga
		;
	}
	</style>
</head>
<body>
	<h1>You logged!</h1>
	<a href="login.php?action=logout">Log Out</a>
</body>
</html>