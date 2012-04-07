<?php

if ( is_admin() )
{

	add_action('admin_menu', 'lbx_menu');
	

}

function lbx_menu()
{
	add_menu_page('Lightbox Pop- Manage settings', 'Lightbox-Pop', 'manage_options', 'lightbox-popup-settings', 'lbx_settings');

	// Add a submenu to the Dashboard:
	$page=add_submenu_page('lightbox-popup-settings', 'Lightbox Pop- Manage settings', 'Settings', 'manage_options', 'lightbox-popup-settings' ,'lbx_settings'); // 8 for admin
	add_submenu_page('lightbox-popup-settings', 'Lightbox Pop- About', 'About', 'manage_options', 'lightbox-popup-about' ,'lbx_about'); // 8 for admin
	//add_options_page('Lightbox - Manage settings',  'Lightbox Settings', 'administrator', 'my-first', 'lbx_settings');
	add_action( "admin_print_scripts-$page", 'lbx_farbtastic_script' );
	add_action( "admin_print_styles-$page", 'lbx_farbtastic_style' );
}


function lbx_settings()
{
	require( dirname( __FILE__ ) . '/lightbox-settings.php' );
}


function lbx_about()
{
	require( dirname( __FILE__ ) . '/about.php' );
}

function lbx_farbtastic_script() 
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('farbtastic');

}

function lbx_farbtastic_style() 
{
	wp_enqueue_style('farbtastic');
}

?>