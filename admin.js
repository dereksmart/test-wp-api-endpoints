/* global testStuff, console, wp */

(function( $ ) {

	// Get protect count
	$( '#wp-api-endpoint-do-it' ).click( function() {
		var endpoint = document.getElementById( 'wp-api-endpoint' ).value;
		var methodType = document.getElementById( 'wp-api-endpoint-type' ).value;
		$.ajax({
			method: methodType,
			beforeSend : function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', testStuff.nonce );
			},
			url: testStuff.root + endpoint,
			success: function( response ){
				$( '#display-wp-api-endpoint-response' ).html( '<pre>' + JSON.stringify( response, null, 4 ) + '</pre>' );
			},
			error: function( response ) {
				$( '#display-wp-api-endpoint-response' ).html( response.responseText );
			}
		});
	} );
})( jQuery );