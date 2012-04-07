<?php


function lbx_install()
{

	add_option("xyz_lbx_html", 'Hello world.');
	add_option("xyz_lbx_top", '25');
	add_option("xyz_lbx_width", '50');
	add_option("xyz_lbx_height", '50');
	add_option("xyz_lbx_left", '25');
	add_option("xyz_lbx_delay", '2');
	add_option("xyz_lbx_page_count", '1');
	add_option("xyz_lbx_mode", 'delay_only'); //page_count_only,both are other options
	add_option("xyz_lbx_repeat_interval", '1');//hrs
	add_option("xyz_lbx_z_index",'10000');
	add_option("xyz_lbx_color",'#000000');	
	add_option("xyz_lbx_corner_radius",'5');
	add_option("xyz_lbx_width_dim",'%');
	add_option("xyz_lbx_height_dim",'%');
	add_option("xyz_lbx_left_dim",'%');
	add_option("xyz_lbx_top_dim",'%');
	add_option("xyz_lbx_border_color",'#cccccc');
	add_option("xyz_lbx_bg_color",'#ffffff');
	add_option("xyz_lbx_opacity",'60');
	add_option("xyz_lbx_border_width",'10');
	
}
























?>