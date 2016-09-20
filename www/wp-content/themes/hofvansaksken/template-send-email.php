<?php
/**
 * Template Name: Send Email Template
 */
//require_once __DIR__ . '/vendor/autoload.php';


//echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";

//Create a new SMTP instance
// $smtp = new SMTP;

// echo '1';

// //Enable connection-level debug output
// $smtp->do_debug = SMTP::DEBUG_CONNECTION;
// try {
//     //Connect to an SMTP server
//     if (!$smtp->connect('mail.hintshofvansaksen.nl', 25)) {
//     	echo 'Connect failed';
//         throw new Exception('Connect failed');
//     }
//     //Say hello
//     if (!$smtp->hello(gethostname())) {
       
//        	echo '<pre> EHLO failed: ';
//        	print_r($smtp->getError()['error']);
//        	echo '</pre>'; 	

//         throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
//     }
//     //Get the list of ESMTP services the server offers
//     $e = $smtp->getServerExtList();
//     //If server can do TLS encryption, use it
//     if (is_array($e) && array_key_exists('STARTTLS', $e)) {
//         $tlsok = $smtp->startTLS();
//         if (!$tlsok) {
// 	       	echo 'Failed to start encryption:   <pre> ';
// 	       	print_r($smtp->getError());
// 	       	echo '</pre>'; 	

//             throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
//         }
//         //Repeat EHLO after STARTTLS
//         if (!$smtp->hello(gethostname())) {
//         	echo '<pre> EHLO (2) failed: ';
// 	       	print_r($smtp->getError()['error']);
// 	       	echo '</pre>'; 	

//             throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
//         }
//         //Get new capabilities list, which will usually now include AUTH if it didn't before
//         $e = $smtp->getServerExtList();
//     }
//     //If server supports authentication, do it (even if no encryption)
//     if (is_array($e) && array_key_exists('AUTH', $e)) {
//         if ($smtp->authenticate('username', 'password')) {
//             echo "Connected ok!";
//         } else {
//         	echo '<pre> Authentication failed: ';
// 	       	print_r($smtp->getError()['error']);
// 	       	echo '</pre>'; 	

//             throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
//         }
//     }
// } catch (Exception $e) {
//     echo 'SMTP error: ' . $e->getMessage(), "\n";
// }
// //Whatever happened, close the connection.
// $smtp->quit(true);





// $mail = new PHPMailer;
// $mail->SMTPDebug = 3;                               // Enable verbose debug output
// $mail->isSMTP();
// $mail->SMTPOptions = array(
//     'ssl' => array(
//         'verify_peer' => false,
//         'verify_peer_name' => false,
//         'allow_self_signed' => true
//     )
// );                                      // Set mailer to use SMTP
// //$mail->Host = 'mail.hintshofvansaksen.nl';  // Specify main and backup SMTP servers
// $mail->Host = 'tls://mail.hintshofvansaksen.nl:587';
// $mail->SMTPAuth = true;                               // Enable SMTP authentication
// $mail->Username = 'verwenmoment@hintshofvansaksen.nl';
// $mail->Password = '815RfgwnGdSb9gTgf';
// //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
// //$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
// //$mail->Port = 587;  //587                                  // TCP port to connect to

// $mail->setFrom('no-reply@hintshofvansaksen.nl');
// $mail->addAddress('martijnwip@gmail.com');               // Name is optional
// $mail->addAddress('flyingwip@gmail.com');               // Name is optional
// $mail->addAddress('info@martijnwip.nl');     
// //$mail->addReplyTo('info@example.com', 'Information');
// //$mail->addCC('cc@example.com');
// //$mail->addBCC('bcc@example.com');

// //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/dist/images/email_header.png', 'new.jpg');    // Optional name
// $mail->isHTML(true);                                  // Set email format to HTML

// $mail->Subject = 'Here is the subject';
// //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->msgHTML(file_get_contents(get_template_directory().  '/mail_template_static.html'), dirname(__FILE__));
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

// if(!$mail->send()) {
//     //echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message has been sent';
// }


// //Create a new PHPMailer instance
// $mail = new PHPMailer;
// // Set PHPMailer to use the sendmail transport
// $mail->isSendmail();
// //Set who the message is to be sent from
// $mail->setFrom('noreply@hintshofvansaksen.nl', 'Hof van Saksen');

// //Set who the message is to be sent to
// //$mail->addAddress('martijnwip@gmail.com', 'Martijn Wip');
// $mail->addAddress('info@martijnwip.nl', 'Martijn Wip');
// //Set the subject line
// $mail->Subject = 'PHPMailer sendmail test';
// //Read an HTML message body from an external file, convert referenced images to embedded,
// //convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents(get_template_directory().  '/mail_template.html'), dirname(__FILE__));

// //Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';
// //Attach an image file
// $mail->addAttachment('http://www.hintshofvansaksen.nl/wp-content/uploads/2016/09/email_header.png');
// //send the message, check for errors
// if (!$mail->send()) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
//     echo "Message sent!";
// }


//Create a new PHPMailer instance
// $mail = new PHPMailer;
// // Set PHPMailer to use the sendmail transport
// $mail->isSendmail();
// //Set who the message is to be sent from
// $mail->setFrom('noreply@hintshofvansaksen.nl', 'Hof van Saksen');

// //Set who the message is to be sent to
// $mail->addAddress('martijnwip@gmail.com', 'Martijn Wip');
// //$mail->addAddress('info@martijnwip.nl', 'Martijn Wip');
// //Set the subject line
// $mail->Subject = 'PHPMailer sendmail test';
// //Read an HTML message body from an external file, convert referenced images to embedded,
// //convert HTML into a basic plain-text alternative body
// //$mail->msgHTML(file_get_contents(get_template_directory().  '/mail_template.html'), dirname(__FILE__));

// $mail->msgHTML('This is an html <b>text</b>');

// //Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';
// //Attach an image file
// $mail->addAttachment('http://www.hintshofvansaksen.nl/wp-content/uploads/2016/09/email_header.png');
// //send the message, check for errors
// if (!$mail->send()) {
//     echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
//     echo "Message sent!";
// }


// $to      = 'martijnwip@gmail.com';
// //$to      = 'flyingwip@gmail.com';
// $subject = 'the subject';
// $message = 'hello xam. Hier een test van martijn';
// $headers = 'From: noreply@hintshofvansaksen.nl' . "\r\n" .
//     'Reply-To: info@martijnwip.nl' . "\r\n" .
//     'X-Mailer: PHP/' . phpversion();

// mail($to, $subject, $message, $headers);

// echo 'done';


?>