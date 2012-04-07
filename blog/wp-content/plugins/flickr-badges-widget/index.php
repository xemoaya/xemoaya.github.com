<?php
 /*
	Plugin Name: Flickr Badges Widget
	Plugin URI: http://zourbuth.com/plugins/flickr-badges-widget
	Description: Display your Flickr latest photostream in widget area.
	Version: 1.0
	Author: zourbuth
	Author URI: http://zourbuth.com
	License: Under GPL2
*/
 
/*  
	Copyright 2011 zourbuth (email : zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Launch the plugin. */
add_action( 'plugins_loaded', 'flickr_badges_widget_plugins_loaded' );

/* Initializes the plugin and it's features. */
function flickr_badges_widget_plugins_loaded() {

	/* Set constant path to the members plugin directory. */
	define( 'FLICKR_BADGES_WIDGET_DIR', plugin_dir_path( __FILE__ ) );

	/* Set constant path to the members plugin directory. */
	define( 'FLICKR_BADGES_WIDGET_URL', plugin_dir_url( __FILE__ ) );

	/* Loads and registers the new widgets. */
	add_action( 'widgets_init', 'flickr_badges_widget_init' );
	
	/* Create additional links to plugin list */
	add_filter( 'plugin_row_meta', '_fbw_my_portfolio', 10, 2 );
}

/* Register the extra widgets. Each widget is meant to replace or extend the current default  */
function flickr_badges_widget_init() {

	/* Load widget file. */
	require_once( FLICKR_BADGES_WIDGET_DIR . 'flickr-badges-widget.php' );

	/* Register widget. */
	register_widget( 'flickr_badges_widget' );
}

function _fbw_my_portfolio($links, $file) {
	$plugin = plugin_basename(__FILE__);

	if ($file == $plugin) // create link
		return array_merge( $links, array( sprintf( '<a href="http://codecanyon.net/user/zourbuth/portfolio?ref=zourbuth">Portfolios</a>', $plugin, __('Portfolios') ) ));
	return $links;
}

?>