<?php
/*
Plugin Name: Test WP API Endpoints
Description: Test authenticated registered endpoint routes without having to worry about nonce and all that.
Version: 1.0
*/

add_action( 'admin_menu', 'test_wp_api_endpoints_register_admin_page', 1 );
function test_wp_api_endpoints_register_admin_page() {
	add_menu_page( 'Test WP API', 'Test WP API Endpoints', 'manage_options', 'test-wp-api-endpoints', 'test_wp_api_endpoints_render_main_page' );
}

function test_wp_api_endpoints_render_main_page() {
	wp_enqueue_script( 'test-wp-api-endpoint', plugin_dir_url( __FILE__ ) . 'admin.js', array(), true );
	wp_localize_script( 'test-wp-api-endpoint', 'testStuff', array(
		'root'       => esc_url_raw( rest_url() ),
		'nonce'      => wp_create_nonce( 'wp_rest' ),
	) );

	// Get all registered endpoints
	$registered_endpoints = json_decode( file_get_contents( get_home_url() . '/wp-json' ) );
	?>
	<h2>Copy/paste one of these registered endpoints to test.</h2>
	<strong>Currently registered:</strong><br>
	<?php
		foreach ( $registered_endpoints->routes as $route => $route_details ) {
			// Only show jetpack ones
			if ( ! strpos( $route, 'jetpack' ) ) {
				continue;
			}
			echo '<strong>' . $route_details->methods[0] . '</strong>  -- ' . substr( $route, 1 ) . '<br>';
		}
	?>
	<select name="wp-api-endpoint-type" id="wp-api-endpoint-type">
		<option value="GET">GET</option>
		<option value="POST">POST</option>
	</select>
	<input type="text" id="wp-api-endpoint">
	<button id="wp-api-endpoint-do-it">Do it!</button>
	<div id="display-wp-api-endpoint-response"></div>
<?php }