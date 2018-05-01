<?php

/*

	@package sunsettheme

    =========================
        ADMIN ENQUEUE FUNCTIONS
    =========================
*/

function sunset_add_admin_page() {

	// Generate Sunset Admin Page
	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'alecadd_sunset', 'sunset_theme_create_page', '
dashicons-admin-customizer', 110 );

	// Generate Sunset Admin Sub Pages
	add_submenu_page( 'alecadd_sunset', 'Sunset Theme Options', 'General', 'manage_options', 'alecadd_sunset', 'sunset_theme_create_page' );
	add_submenu_page( 'alecadd_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'alecadd_sunset_css', 'sunset_theme_settings_page' );

	// Activate custom settings
	add_action( 'admin_init', 'sunset_custom_settings' );

}

add_action( 'admin_menu', 'sunset_add_admin_page' );


function register_settings( $group, $options = array() ) {
	foreach ( $options as $option ) {
		register_setting( $group, $option );
	}
}

function sunset_custom_settings() {
	$group   = 'sunset-settings-group';
	$options = [ 'first_name', 'last_name', 'user_description', 'facebook_handler', 'gplus_handler' ];

	register_settings( $group, $options );

	// To avoid multiple IF's, repeat register_setting with extra option

	register_setting( 'sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler' );
	add_settings_section( 'sunset-sidebar-options', 'Sidebar Options', 'sunset_sidebar_options', 'alecadd_sunset' );

	$args = format_myArgs( 'first_name', 'text', 'First Name' );

	add_settings_field( 'sidebar-name', 'First Name', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );

	$args = format_myArgs( 'last_name', 'text', 'Last Name' );

	add_settings_field( 'sidebar-lastname', 'Last Name', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );

	$args = format_myArgs( 'user_description', 'text', 'Short Description', 'Write something smart.' );

	add_settings_field( 'sidebar-description', 'Short description', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );

	$args = format_myArgs( 'twitter_handler', 'text', 'Twitter handler', 'Input your Twitter username without the @ character.' );

	add_settings_field( 'sidebar-twitter', 'Twitter handler', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );

	$args = format_myArgs( 'facebook_handler', 'text', 'Facebook handler' );

	add_settings_field( 'sidebar-facebook', 'Facebook handler', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );

	$args = format_myArgs( 'gplus_handler', 'text', 'Google+ handler' );

	add_settings_field( 'sidebar-gplus', 'Google+ handler', 'sunset_sidebar_addField', 'alecadd_sunset', 'sunset-sidebar-options', $args );
}


function sunset_sidebar_options() {
	echo 'Customize your Sidebar Information';
}


function format_myArgs( $name, $type, $placeholder, $desc = false ) {
	return array(
		'name'        => $name,
		'type'        => $type,
		'placeholder' => $placeholder,
		'desc'        => $desc
	);
}

function sunset_sidebar_addField( $args ) {
	$value = esc_attr( get_option( $args['name'] ) );
	echo '<input type="' . $args['type'] . '" name="' . $args['name'] . '" value="' . $value . '" placeholder="' . $args['placeholder'] . '" />
	<p class="description">' . $args['desc'] . '</p> ';
}


// Sanitization settings

function sunset_sanitize_twitter_handler( $input ) {
	$output = sanitize_text_field( $input );
	$output = str_replace( '@', '', $output );

	return $output;
}

function sunset_theme_create_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_settings_page() {
	//generation of our admin page
}