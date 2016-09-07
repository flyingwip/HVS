//jQuery( document ).on( 'click', '.love-button', function() {
jQuery( document ).on( 'click', '.kies-je-hint', function() {

	var hint = jQuery('input[name="hint"]:checked').val();
	jQuery.ajax({
		url : hvsFeScript.ajax_url,
		data : {
			action : 'hvs_kies_je_hint',
			hint : hint
		},
		success : function( response ) {
			//console.log(response);
			location.href = response;
			//jQuery('#love-count').html( response );
		}
	});

	return false;
})


jQuery( document ).on( 'click', '.ga-naar-form', function() {
	

	jQuery.ajax({
		url : hvsFeScript.ajax_url,
		data : {
			action : 'hvs_ontvanger',
			ontvanger : jQuery('#ontvanger').val(),
			email_ontvanger: jQuery('#email_ontvanger').val()
		},
		success : function( response ) {
			//console.log(response);
			location.href = response;
			
		}
	});

	return false;
})


jQuery( document ).on( 'click', '.sluit-af', function() {
	
	var geslacht = jQuery('input[name="geslacht"]:checked').val();
	var voornaam = jQuery('#voornaam').val();
	var tussenv = jQuery('#tussenv').val();
	var email = jQuery('#email').val();
	var achternaam = jQuery('#achternaam').val();
	var land = jQuery('input[name="land"]:checked').val();
	var aanbiedingen = jQuery('#nieuwsbrief').is(':checked');
	((aanbiedingen == true) ? aanbiedingen = 1 : aanbiedingen = 0);
	var voorwaarden = jQuery('#actievoorwaarden').is(':checked');
	((voorwaarden == true) ? voorwaarden = 1 : voorwaarden = 0);

	//console.log( geslacht, voornaam, tussenv, achternaam, land,  aanbiedingen, voorwaarden );			
	
	jQuery.ajax({
		url : hvsFeScript.ajax_url,
		data : {
			action : 'hvs_close_goodbye',
			geslacht : geslacht,
			voornaam : voornaam,
			tussenv : tussenv,
			achternaam : achternaam,
			email : email,
			land : land,
			aanbiedingen : aanbiedingen,
			voorwaarden : voorwaarden,
		},
		success : function( response ) {
			console.log(response);
			//location.href = '/ontvanger';
			//jQuery('#love-count').html( response );
		}
	});

	return false;
})

