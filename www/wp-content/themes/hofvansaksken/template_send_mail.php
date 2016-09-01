<?php
/**
 * Template Name: SendMail
 */
//Set the Content Type
//header('Content-type: image/jpeg');

$images = ['dinner.png','onbijt.png','uitwaaien','treatment'];

//Er word een plaatje gegenereerd met de volgende parameters
// 1. Type plaatje , [ontbijt, uitwaaien, treatment, diner]
// 2 naam van ontvanger en afzender in de afbeelding
$dist_path = get_template_directory() . '/dist/';


// Create Image From Existing File
$png_image = imagecreatefrompng( $dist_path. 'images/dinner.png');


// // Allocate A Color For The Text
$white = imagecolorallocate($png_image, 255, 255, 255);

// Set Path to Font File
$font_jenna_path = $dist_path .  'fonts/JennaSue.ttf';


// Set Text to Be Printed On Image
$to = "Hallo Henk";

// Print Text On Image
imagettftext($png_image, 25, 0, 175, 50, $white, $font_jenna_path, $to);


//second text
$from = "Liefs Ingrid";

// Print Text On Image
imagettftext($png_image, 25, 0, 175, 150, $white, $font_jenna_path, $from);

//generate unique code
//printf("uniqid('', true): %s\r\n", uniqid('', true));
$filename = uniqid('', true);

// Send Image to Browser
imagepng($png_image, get_template_directory() . "/mail_images/".$filename.".png");

// Clear Memory
imagedestroy($png_image);


?>

