<?php 
//open or resume the current session
session_start();

//hide notices
error_reporting( E_ALL & ~E_NOTICE );

//parse the form if they submitted it
if( $_POST['did_login'] ){
	//extract the submitted data
	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);

	//validate! check for the correct patterns
	//username must be at least 5 characters
	//username mustnot exceed 20 characters
	if (strlen( $username ) >= 5 
		AND strlen( $username ) <= 20
		AND strlen( $password ) >= 6 ){

	//TEMPORARY! fake correct credentials. these will be replaced with DB stuff later
	$correct_username = 'joestuhh';
	$correct_password = 'Babygoats1!';

	//check to see if their credentals are correct. if so, log them in
	if( $username === $correct_username AND $password === $correct_password ){
		//success
		//remembers that the user is logged in for 1 week
		setcookie('loggedin', true, time() + 60 * 60 * 24 * 7 );
		$_SESSION['loggedin'] = true;
		//redirect to the secret page
		header("Location:secret-page.php");
		$message = 'You are now logged in hunty!';
	}else{
		//error\
		$message = 'Your username and password combo is incorrect.';
	}

	}else{
		//minimum requirementsnot met
		$message = 'Your username and password combo are incorrect';
	}//end of validation
} //end of form parser

//if the user returns with a valid cookie, re-create the session
if( $_COOKIE['loggedin'] ){
		$_SESSION['loggedin'] = true;
}

//ifthe user is trying to log out, get rid of the cookies ans session
if( $_GET['action'] == 'logout' ){
	//close the open session
	session_destroy();
	//erase all session variables (blank array)
	$_SESSION = array();

	//set any cookies to null, and make them expire in the past
	setcookie( 'loggedin', '', time() -99999);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login to access da stuff</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php  //let the user know if they are logged in 
	if( $_SESSION['loggedin'] ){
		echo '<h1>You are logged in with a session and cookie</h1>';
	}else{}
	?>


	<h1>Log in to your account</h1>
	<?php //show the message if it exists
	if( isset($message) ){
		echo $message;
	}
	 
	 ?>

	<form action="login.php" method="post">
		<label for="the_username">Username</label>
		<input type="text" name="username" id="the_username"> 

		<label for="the_password">Password</label>
		<input type="password" name="password" id="the_password"> 
		
		<input type="submit" value="Log In">
		<input type="hidden" name="did_login" value="true"> 
	</form>

</body>
</html>