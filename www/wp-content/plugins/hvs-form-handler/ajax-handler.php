<?php
/**
 * Plugin Name: HVS Form Handler
 * Plugin URI: http://martijnwip.nl
 * Description: Handles backend for hintshofvansaksen.nl
 * Version: 1.0.0
 * Author: Martijn Wip
 * Author URI: http://martijnwip.nl
 * License: GPL2
 */
//require_once __DIR__ . '/vendor/autoload.php';
include('MailChimp.php');
use \DrewM\MailChimp\MailChimp;



add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

add_action( 'wp_enqueue_scripts', 'ajax_test_enqueue_scripts' );
function ajax_test_enqueue_scripts() {

	wp_enqueue_script( 'hvs-form', plugins_url( '/form-handler.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'hvs-form', 'hvsFeScript', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));

}

add_action( 'wp_ajax_nopriv_hvs_kies_je_hint', 'hvs_kies_je_hint' );
add_action( 'wp_ajax_hvs_kies_je_hint', 'hvs_kies_je_hint' );

function hvs_kies_je_hint() {
	//$love = get_post_meta( $_REQUEST['post_id'], 'post_love', true );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX &&  $_REQUEST['hint']) { 
		//wp_redirect( '/ontvanger');

		//save the hint to a session
		$_SESSION['hint'] = $_REQUEST['hint'];
		echo '/ontvanger';
		die();
	}
	else {
		//wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
		exit();
	}
}

add_action( 'wp_ajax_nopriv_hvs_ontvanger', 'hvs_ontvanger' );
add_action( 'wp_ajax_hvs_ontvanger', 'hvs_ontvanger' );

function hvs_ontvanger() {
	//$love = get_post_meta( $_REQUEST['post_id'], 'post_love', true );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && $_REQUEST['ontvanger'] && $_REQUEST['voornaam'] ) { 
		//wp_redirect( '/ontvanger');
		
		$_SESSION['ontvanger'] = ucfirst ( $_REQUEST['ontvanger']);
		$_SESSION['voornaam'] = ucfirst ( $_REQUEST['voornaam']);
		echo '/email' ;
		die();
	}
	else {
		echo '/foute boel' ;
		die();
	}
}

add_action( 'wp_ajax_nopriv_hvs_email', 'hvs_email' );
add_action( 'wp_ajax_hvs_email', 'hvs_email' );

function hvs_email() {
	//$love = get_post_meta( $_REQUEST['post_id'], 'post_love', true );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && $_REQUEST['email_ontvanger']) { 
		
		$_SESSION['email_ontvanger'] = ucfirst ( $_REQUEST['email_ontvanger']);

		$deelnemer = array(
		    "geslacht" => '',
		    "voornaam" => '',
		    "voornaam_kaart" => $_SESSION['voornaam'],
		    "tussenv" => '',
		    "achternaam" => '',
		    "email" => '',
		    "land" => '',
		    "aanbiedingen" => '',
		    "voorwaarden" => '',
		    "ontvanger" => $_SESSION['ontvanger'],
		    "email_ontvanger" => $_SESSION['email_ontvanger'],
		    "hint" => $_SESSION['hint'],

		);

		//we got all the data so we can create the image and send the mail
		//create image for email	
		$image_file_name = hvs_create_image($deelnemer);
		$_SESSION['image_file_name'] = $image_file_name;
		$deelnemer['image_file_name'] = $_SESSION['image_file_name'];

		//hvs_save_deelnemer($deelnemer);
		$result = hvs_send_email($deelnemer);
		//echo json_encode($result);
		echo '/form' ;
		die();
	}
	else {
		echo '/foute boel' ;
		die();
	}
}

add_action( 'wp_ajax_nopriv_hvs_close_goodbye', 'hvs_close_goodbye' );
add_action( 'wp_ajax_hvs_close_goodbye', 'hvs_close_goodbye' );

function hvs_close_goodbye() {
	//$love = get_post_meta( $_REQUEST['post_id'], 'post_love', true );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 

		$deelnemer = array(
		    "geslacht" => $_REQUEST['geslacht'],
		    "voornaam" => $_REQUEST['voornaam'],
		    "voornaam_kaart" => $_SESSION['voornaam'],
		    "tussenv" => $_REQUEST['tussenv'],
		    "achternaam" => ucfirst ($_REQUEST['achternaam']),
		    "email" => $_REQUEST['email'],
		    "land" => $_REQUEST['land'],
		    "aanbiedingen" => $_REQUEST['aanbiedingen'],
		    "voorwaarden" => $_REQUEST['voorwaarden'],
		    "ontvanger" => $_SESSION['ontvanger'],
		    "email_ontvanger" => $_SESSION['email_ontvanger'],
		    "image_file_name" => $_SESSION['image_file_name'],
		    "hint" => $_SESSION['hint'],

		);

		
		hvs_save_deelnemer($deelnemer);
		//$result = hvs_send_email($deelnemer);

		if($_REQUEST['aanbiedingen']){
			//A
			$result = '/bedankt';	
		} else {
			//B
			$result = '/bedank' ;	
		}

		//remove all session variables
  		session_unset();
  		session_destroy();
		//wp_redirect( '/ontvanger');
		//
		echo $result;
		die();
	}
	else {
		echo 'fout';
		die();
	}
}

function hvs_save_deelnemer($deelnemer){

			// //save all data in the database
		$defaults = array(
        	'post_type' => 'deelnemer',
        	'post_title'	=> $deelnemer['voornaam'] . ' '. $deelnemer['achternaam'] ,
        	'post_status'	=> 'private'
        );

		$post_id = wp_insert_post( $defaults );

		$field_key = "field_57ce8e9ba92b3";
		$value = $deelnemer['geslacht'];
		update_field( $field_key, $value, $post_id );

		//voornaam
		$field_key = "field_57ce9356a92b4";
		$value = $deelnemer['voornaam'];
		update_field( $field_key, $value, $post_id );

		//voornaam op de kaart
		$field_key = "field_57d938fb9c799";
		$value = $deelnemer['voornaam_kaart'];
		update_field( $field_key, $value, $post_id );

		//tussenv
		$field_key = "field_57ce9363a92b5";
		$value = $deelnemer['tussenv'];
		update_field( $field_key, $value, $post_id );

		//achternaam
		$field_key = "field_57ce9378a92b6";
		$value = $deelnemer['achternaam'];
		update_field( $field_key, $value, $post_id );

		//email
		$field_key = "field_57ce9386a92b7";
		$value = $deelnemer['email'];
		update_field( $field_key, $value, $post_id );

		//land
		$field_key = "field_57ce9392a92b8";
		$value = $deelnemer['land'];
		update_field( $field_key, $value, $post_id );


		//aanbiedingen
		$field_key = "field_57ce939da92b9";
		$value = $deelnemer['aanbiedingen'];
		update_field( $field_key, $value, $post_id );


		//voorwaarden
		$field_key = "field_57ce93a7a92ba";
		$value = $deelnemer['voorwaarden'];
		update_field( $field_key, $value, $post_id );


		//ontvanger
		$field_key = "field_57ce93b8a92bb";
		$value = $deelnemer['ontvanger'];
		update_field( $field_key, $value, $post_id );


		//email_ontvanger
		$field_key = "field_57ce93c3a92bc";
		$value = $deelnemer['email_ontvanger'];
		update_field( $field_key, $value, $post_id );


		//image_file_name
		$field_key = "field_57ce93d4a92bd";
		$value = $deelnemer['image_file_name'];
		update_field( $field_key, $value, $post_id );

		//hint
		$field_key = "field_57ce93dca92be";
		$value = $deelnemer['hint'];
		update_field( $field_key, $value, $post_id );




}

function hvs_create_image($deelnemer){


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

function hvs_send_email($deelnemer){

	$MailChimp = new MailChimp('0cd12bbb4fb3001ec9d5058e0d1e4ea3-us2');

	$list_id = '761e8922d0';

	//$image = "http://www.hintshofvansaksen.nl/wp-content/uploads/generated/". $deelnemer['image_file_name'];
	$image = "http://www.hintshofvansaksen.nl/wp-content/uploads/generated/rsz_1dummy.png";

	$data = array(
	    "FNAME" => $deelnemer['ontvanger'],
	    "SENDER" => $deelnemer['voornaam_kaart'],
	    "IMAGE" => "http://www.hintshofvansaksen.nl/wp-content/uploads/generated/". $deelnemer['image_file_name']
	);

	//"IMAGE" => "http://www.hintshofvansaksen.nl/wp-content/uploads/2016/09/generated/". $deelnemer['afbeelding']

	 return $MailChimp->post("lists/$list_id/members", [
	 	'email_address' => $deelnemer['email_ontvanger'],
	     'status'        => 'subscribed',
	     'merge_fields' 	=>  $data,
	]);

}

