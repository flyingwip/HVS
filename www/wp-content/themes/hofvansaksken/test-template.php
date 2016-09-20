<?php
/**
 * Template Name: Template test
 */
//require("vendor/autoload.php");
include('MailChimp.php');
use \DrewM\MailChimp\MailChimp;



function dev_hvs_create_image($deelnemer){
	
	$images['breakfast'] = 'mail_onbijt.png';
	$images['fiets'] = 'mail_fiets.png' ;
	$images['treatment'] = 'mail_treatment.png' ;
	$images['dinner'] = 'mail_dinner.png' ;

	$opmaak = array(
		'een' => "in een" , 
		'twee' => 'gezond ontbijt' , 
		'drie' => 'op bed...' , 
	);

	$text['breakfast'] = $opmaak ;

	$opmaak = array(
		'een' => "om lekker" , 
		'twee' => 'uit te waaien' , 
		'drie' => 'op de fiets...' , 
	);

	$text['fiets'] =  $opmaak ;	

	$opmaak = array(
		'een' => "in een" , 
		'twee' => 'ontspannende facial' , 
		'drie' => 'treatment...' , 
	);
	
	$text['treatment'] = $opmaak ;

	$opmaak = array(
		'een' => "in zo'n" , 
		'twee' => 'romantisch' , 
		'drie' => 'diner voor 2...' , 
	);	

	$text['dinner'] =  $opmaak ;
	
	//Er word een plaatje gegenereerd met de volgende parameters
	// 1. Type plaatje , [ontbijt, uitwaaien, treatment, diner]
	// 2 naam van ontvanger en afzender in de afbeelding
	$dist_path = get_template_directory() . '/dist/';

	// Create Image From Existing File
	//$png_image = imagecreatefrompng( $dist_path. 'images/mail_test.png');
	$png_image = imagecreatefrompng( $dist_path. 'images/'. $images[$deelnemer['hint']]);

	// Allocate A Color For The Text
	$white = imagecolorallocate($png_image, 255, 255, 255);

	// Set Path to Font File
	$font_jenna_path = $dist_path .  'fonts/JennaSue.ttf';
	$font_myriad_path = $dist_path .  'fonts/MyriadPro-Regular.ttf';

	// Set Text to Be Printed On Image
	$to = "Hallo " . $deelnemer['ontvanger'] . ',';

	$x_val = 577;
	$y_val = 135;

	// Print Text On Image
	imagettftext($png_image, 25, 0, $x_val, $y_val , $white, $font_jenna_path, $to);


	$copy = $text[$deelnemer['hint']];
	
	$increment = 30;
	$y_val += 40;
	$font_size = 18;
	$description = "Ik heb wel zin";
	imagettftext($png_image, $font_size, 0, $x_val, $y_val, $white, $font_myriad_path, $description);
	$y_val += $increment;
	imagettftext($png_image, $font_size, 0, $x_val, $y_val, $white, $font_myriad_path, $copy['een']);
	$y_val += $increment;
	imagettftext($png_image, $font_size, 0, $x_val, $y_val, $white, $font_myriad_path, $copy['twee']);
	$y_val += $increment;
	imagettftext($png_image, $font_size, 0, $x_val, $y_val, $white, $font_myriad_path, $copy['drie']);
	$description .= $text[ $deelnemer['hint'] ];

	


	//second text
	$from = "Liefs " . $deelnemer['voornaam_kaart'];
	// Print Text On Image
	imagettftext($png_image, 25, 0, $x_val+75, 320, $white, $font_jenna_path, $from);

	//generate unique code
	//printf("uniqid('', true): %s\r\n", uniqid('', true));
	$filename = uniqid('', true) . '.png';
	$uploads = wp_upload_dir();

	$image_url = $uploads['basedir'].  "/generated/".$filename;
	
	imagepng($png_image,$image_url );
	//imagepng($png_image, get_template_directory() . "/mail_images/".$filename.".png");

	// Clear Memory
	imagedestroy($png_image);

	return $filename ;

}

$deelnemer = array(
	"geslacht" => '',
	"voornaam" => 'Afzender',
	"voornaam_kaart" => 'Afzender',
	"tussenv" => '',
	"achternaam" => '',
	"email" => '',
	"land" => '',
	"aanbiedingen" => '',
	"voorwaarden" => '',
	"ontvanger" => 'Ontvanger',
	 "email_ontvanger" => 'info@ontvanger.nl',
	"hint" => 'breakfast'
	);

//fiets treatment dinner breakfast


function dev_hvs_send_email($deelnemer){

	$MailChimp = new MailChimp('0cd12bbb4fb3001ec9d5058e0d1e4ea3-us2');

	$list_id = '761e8922d0';

	$data = array(
	    "FNAME" => $deelnemer['ontvanger'],
	    "SENDER" => $deelnemer['voornaam_kaart'],
	    "IMAGE" => "http://www.hintshofvansaksen.nl/wp-content/uploads/generated/57e13351b6dc80.58151790.png"
	);

	 return $MailChimp->post("lists/$list_id/members", [
	                'email_address' => 'onno@martijnwip.nl',
	                'status'        => 'subscribed',
	                'merge_fields' 	=>  $data,
	            ]);


}


$deelnemer['afbeelding'] = $image_file_name = dev_hvs_create_image($deelnemer);

//$result = dev_hvs_send_email($deelnemer);



echo "<pre>";
print_r($deelnemer);
echo "</pre>";


