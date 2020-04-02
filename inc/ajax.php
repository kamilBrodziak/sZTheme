<?php
add_action('wp_ajax_nopriv_sendUserEmail', 'sendUserEmail');
add_action('wp_ajax_sendUserEmail', 'sendUserEmail');

function sendUserEmail() {
	$name = wp_strip_all_tags($_POST['name']);
	$email = wp_strip_all_tags($_POST['email']);
	$message = wp_strip_all_tags($_POST['message']);

//	echo $name . ',' . $email . ',' . $message;
	$to = get_bloginfo('admin_email');
	$subject = "Szczęśliwy związek formularz kontaktowy - $name";
	$headers[] = "From: " . get_bloginfo('name') . " <$to>";
	$headers[] = "Reply-To: $name <$email>";
	$headers[] = 'Content-Type: text/html: charset=UTF-8';
	wp_mail($to, $subject, $message, $headers);
	die();
}

//function mailtrap($phpmailer) {
//	$phpmailer->isSMTP();
//	$phpmailer->Host = 'smtp.mailtrap.io';
//	$phpmailer->SMTPAuth = true;
//	$phpmailer->Port = 2525;
//	$phpmailer->Username = '8270f6cf69c91b';
//	$phpmailer->Password = 'e542610cedb223';
//}
//
//add_action('phpmailer_init', 'mailtrap');