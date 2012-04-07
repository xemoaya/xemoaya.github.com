<?php
/*
Plugin Name: Lightbox Pop
Plugin URI: http://xyzscripts.com/wordpress-plugins/lightbox-pop/
Description: This plugin is used to create a lightbox with custom content in your site. You can configure lightbox postion settings (height,width,top,left), display logic settings (time delay after page load, number of pages to browse, lightbox repeat interval) and style settings(z-index,overlay opacity, color, border etc).
Version: 1.0
Author: xyzscripts.com
Author URI: http://xyzscripts.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// if ( !function_exists( 'add_action' ) ) {
// 	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
// 	exit;
// }
ob_start();
require( dirname( __FILE__ ) . '/admin/install.php' );
register_activation_hook(__FILE__,'lbx_install');

require( dirname( __FILE__ ) . '/admin/menu.php' );

require( dirname( __FILE__ ) . '/create-lightbox.php' );

?>