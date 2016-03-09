<?php 
error_reporting( E_ALL & ~E_NOTICE);
//load the function file
include_once ( 'functions.php' );
//parse the form if the user submitted it
if ( $_POST['did_send'] ) {
	//extract user submitted content
	$name 		= filter_var( $_POST['name'] , FILTER_SANITIZE_STRING );
	$email 		= filter_var( $_POST['email'] , FILTER_SANITIZE_EMAIL );
	$phone 		= filter_var( $_POST['phone'] , FILTER_SANITIZE_NUMBER_INT );
	$reason 	= filter_var( $_POST['reason'] , FILTER_SANITIZE_STRING );
	$message 	= filter_var( $_POST['message'] , FILTER_SANITIZE_STRING );
	$newsletter = filter_var( $_POST['newsletter'] , FILTER_SANITIZE_STRING );	

	//TODO: sanitize and validate all the data
	if( $newsletter == ''){
		$newsletter = 'Heck nah.';
	}

	//validate!
	$valid = true;

	//test if name is blank
	if( $name == '' ){
		$valid = false;
		$errors['name'] = 'Please fill in your name.';
	}

	//test if email is invalid (or blank)
	if ( !  filter_var( $email, FILTER_SANITIZE_EMAIL ) ){
		$valid = false; 
		$errors['email'] = 'Please provide a valid email, like bob@mail.com.';		
	}

	//test if the reason is not on the list
	$allowed_reasons = array( 'help' , 'hi' , 'bug' );
	if ( ! in_array( $reason, $allowed_reasons) ){
		$valid = false;
		$errors['reason'] = 'Please choose a reason for dis message.';		
	}

if($valid){
	//set up the parts of mail() function
	$to = 'joemulgado0110@platt.edu';
	$subject = "$name just reached out to you via your website.";

	$body = "Email: $email \n";
	$body .= "Name: $name \n";
	$body .= "Phone: $phone \n";
	$body .= "Reason for contacting you: $reason \n\n";	

	$body .= "Subscribe? $newsletter \n\n";

	$body .= "Message: $message \n\n";

	$header	= 'From: Joe <contact@joeizaak.com> \r\n';
	$header .= "Reply-to: $email";

	//send the mail
	$did_mail = mail( $to, $subject, $body, $header );
}//end if valid

	//user feedback message
	if ($did_mail) {
		$feedback = "Thank you for contacting us, $name.";
		$status = 'success';
	}else{
		//error
		$feedback = "Sorry, your message could not be sent. Try again.";
		$status = 'error';
	}
} //end of parser
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utrf-8">
	<title>Contact Us</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="<?php echo $staus; ?>">
<h1>Contact Us!</h1>
<p>Please take a moment to get in touch. We will get to you shortly.</p>

<?php //display user feedback if it exists
if( isset($feedback) ){
	echo '<div class="message">';
	echo $feedback;

	//if there are error messages, show them in a list
	if( ! empty($errors) ){
		echo '<ul>';
		foreach ($errors as $item ) {
			echo '<li>' . $item . '</li>';
		}
		echo '</ul>';
	}

	echo '</div>';
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
	<label for="the_name">Your Name:</label>
	<input type="text" name="name" id="the_name" placeholder="John Hoe" required value="<?php echo $name; ?>"
	<?php field_error( $errors['name'] ); ?>
	>

	<label for="the_email">Your Email:</label>
	<input type="email" name="email" id="the_email" required value="<?php echo $email; ?>"
	<?php field_error( $errors['email'] ); ?>
	>

	<label for="the_phone">Your Phone:</label>
	<input type="phone" name="phone" id="the_phone" value="<?php echo $phone; ?>">

	<label for="the_reason">How Can I help you?</label>	
	<select name="reason" id="the_reason" required
	<?php field_error( $errors['reason'] ); ?>
	>
		<option value="">Choose one:</option>
		<option value="help" <?php if( $reason == 'help'){ echo 'selected'; } ?>>I need customer service</option>
		<option value="hi" <?php if( $reason == 'hi'){ echo 'selected'; } ?>>I just want to say "Hi!"</option>
		<option value="bug" <?php if( $reason == 'bug'){ echo 'selected'; } ?>>I found a bug in yo stuff</option>				
	</select>

	<label for="the_message">Your Message:</label>
	<textarea name="message" id="the_message"><?php echo $message ?></textarea>

	<label>
		<input type="checkbox" name="newsletter" value="yes" 
		<?php  if( $newsletter != 'Heck nah.'){ echo 'checked'; } ?>>
		Subscribe to our Newsletter
	</label>

	<input type="submit" value="Send Message">
	<input type="hidden" name="did_send" value="true">

</form>

<!-- just for testing how the email will look. delete this later -->
<pre><?php echo $body; ?></pre>


</body>
</html>