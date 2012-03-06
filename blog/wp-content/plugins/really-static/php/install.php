<?php
 
	 
	 
global $wpdb;
 
	if (get_option ( "realstaticisinstalled2" ) === false) {
		add_option ( 'realstaticisinstalled2', "2", '', 'yes' );
		$querystr = "CREATE TABLE `" . $wpdb->prefix . "realstatic` (
		`url` CHAR( 32 ) NOT NULL ,
		`content` CHAR( 32 ) NOT NULL,
		`datum` INT(11) NOT NULL ) ;";
		$wpdb->get_results ( $querystr, OBJECT );


		/*		include("autoinstall.php");
		 // autoinstall
		 if($autoinstall==true){
			add_option ( 'realstaticlocalpath', $realstaticlocalpath, '', 'yes' );
			add_option ( 'realstaticsubpfad', $realstaticsubpfad, '', 'yes' );
			add_option ( 'realstaticlocalurl', $realstaticlocalurl, '', 'yes' );

			add_option ( 'realstaticremotepath', $realstaticremotepath, '', 'yes' );
			add_option ( 'realstaticremoteurl', $realstaticremoteurl, '', 'yes' );

			add_option ( 'realstaticftpserver', $realstaticftpserver, '', 'yes' );
			add_option ( 'realstaticftpuser', $realstaticftpuser, '', 'yes' );
			add_option ( 'realstaticftppasswort', $realstaticftppasswort, '', 'yes' );
			add_option ( 'realstaticdesignlocal', $realstaticdesignlocal, '', 'yes' );
			add_option ( 'realstaticdesignremote', $realstaticdesignremote, '', 'yes' );
			add_option('realstaticposteditcreatedelete',$realstaticposteditcreatedelete,'','');
			add_option('realstaticpageeditcreatedelete',$realstaticpageeditcreatedelete,'','');
			add_option('realstaticcommenteditcreatedelete',$realstaticcommenteditcreatedelete,'','');
			add_option('realstaticeveryday',$realstaticeveryday,'','');
			add_option('realstaticeverytime',$realstaticeverytime,'','');
			}*/
	}elseif (get_option ( "realstaticisinstalled2" ) == 1) {
		$querystr = "ALTER TABLE `" . $wpdb->prefix . "realstatic` ADD `content` CHAR( 32 ) NOT NULL AFTER `url` ;";
		$wpdb->get_results ( $querystr, OBJECT );
		update_option ( 'realstaticisinstalled2', "2" );
	}
	?>