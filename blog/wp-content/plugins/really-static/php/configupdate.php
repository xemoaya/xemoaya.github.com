<?php
/**
 * @retrun: true if url is wrong
 */
function reallystatic_urltypeerror($url) {
	$p = parse_url ( $url );
	if ($p [scheme] != "" and $p [host] != "" and substr ( $p [path], - 1 ) == "/")
		return false;
	else
		return true;
}

if (isset ( $_POST ["strid"] )) {
	if ($_POST ['strid'] == "rs_source") {
		if (strpos ( $_POST ['realstaticdesignlocal'], $_POST ['realstaticlocalurl'] ) === false or strpos ( $_POST ['realstaticdesignlocal'], 'http://' . $_SERVER ["HTTP_HOST"] ) === false or reallystatic_urltypeerror ( $_POST ['realstaticdesignlocal'] ))
			reallystatic_configerror ( 2 );
		update_option ( 'realstaticdesignlocal', $_POST ['realstaticdesignlocal'] );
		if (strpos ( $_POST ['realstaticlocalurl'], 'http://' . $_SERVER ["HTTP_HOST"] ) === false or reallystatic_urltypeerror ( $_POST ['realstaticlocalurl'] ))
			reallystatic_configerror ( 2 );
		update_option ( 'realstaticlocalurl', $_POST ['realstaticlocalurl'] );
	}
	if ($_POST ['strid'] == "rs_debug") {
		$r = wp_mail ( "debug"."@"."sorben.org", "Really Static Debug", $_POST [debug] . "\n\n\n" . $_POST [mail] . "\n\n\n" . $_POST [comment] );
		if ($r == 1)
			reallystatic_configok ( __("Mail has been send", 'reallystatic' ) );
		else
			reallystatic_configok ( __("Mail has NOT been send, please make it manually", 'reallystatic' ) );
	}
	if ($_POST ['strid'] == "rs_destination") {
		if ($_POST ['testandsave']) {
			$ok = 0;
			if ($_POST ['realstaticspeicherart'] == 1) {
				require_once ("ftp.php");
				rs_connect ( $_POST ["realstaticftpserver"], $_POST ["realstaticftpuser"], $_POST ["realstaticftppasswort"], $_POST ["realstaticftpport"] );
			}
			if ($_POST ['realstaticspeicherart'] == 2) {
				require_once ("local.php");
				rs_connect ();
			}
			if ($_POST ['realstaticspeicherart'] == 3) {
				require_once ("sftp.php");
				rs_connect ( $_POST ["realstaticsftpserver"], $_POST ["realstaticsftpuser"], $_POST ["realstaticsftppasswort"], $_POST ["realstaticsftpport"] );
			}
			global $rs_isconnectet;
			if ($rs_isconnectet === false) {
				reallystatic_configok ( __("Cannot Login, please check your Logindata", 'reallystatic' ), 1 );
			} else {
				$da = time () . "test.txt";
				$te = "TESTESTSETSE" . time ();
				;
				
				if ($_POST ["realstaticspeicherart"] == 1)
					rs_writecontent ( $_POST ["realstaticremotepath"] . $da, $te );
				elseif ($_POST ["realstaticspeicherart"] == 2)
					rs_writecontent ( $_POST ["realstaticlokalerspeicherpfad"] . $da, $te );
				elseif ($_POST ["realstaticspeicherart"] == 3)
					rs_writecontent ( $_POST ["realstaticremotepathsftp"] . $da, $te );

				if (really_static_download ( loaddaten ( "realstaticremoteurl", 'reallystatic' ) . $da ) == $te) {
					reallystatic_configok ( __("TEST passed!", 'reallystatic'), 1 );
					$ok = 1;
				} else
					reallystatic_configerror ( 0, __("Test failed!", 'reallystatic') );
				
				if ($_POST ["realstaticspeicherart"] == 1)
					rs_deletefile ( $_POST ["realstaticremotepath"] . $da );
				elseif ($_POST ["realstaticspeicherart"] == 2)
					rs_deletefile ( $_POST ["realstaticlokalerspeicherpfad"] . $da );
				elseif ($_POST ["realstaticspeicherart"] == 3)
					rs_deletefile ( $_POST ["realstaticremotepathsftp"] . $da );
			}
		} else
			$ok = 1;
		if ($ok == 1) {
			update_option ( 'realstaticremoteurl', $_POST ['realstaticremoteurl'] );
			update_option ( 'realstaticftpserver', $_POST ['realstaticftpserver'] );
			update_option ( 'realstaticftpuser', $_POST ['realstaticftpuser'] );
			update_option ( 'realstaticftppasswort', $_POST ['realstaticftppasswort'] );
			update_option ( 'realstaticftpport', $_POST ['realstaticftpport'] );
			update_option ( 'realstaticremotepath', $_POST ['realstaticremotepath'] );
			update_option ( 'realstaticsftpserver', $_POST ['realstaticsftpserver'] );
			update_option ( 'realstaticsftpuser', $_POST ['realstaticsftpuser'] );
			update_option ( 'realstaticsftppasswort', $_POST ['realstaticsftppasswort'] );
			update_option ( 'realstaticsftpport', $_POST ['realstaticsftpport'] );
			update_option ( 'realstaticremotepathsftp', $_POST ['realstaticremotepathsftp'] );
			update_option ( 'realstaticdesignremote', $_POST ['realstaticdesignremote'] );
			update_option ( 'realstaticlokalerspeicherpfad', $_POST ['realstaticlokalerspeicherpfad'] );
			update_option ( 'realstaticspeicherart', $_POST ['realstaticspeicherart'] );
			if (substr ( $_POST ['realstaticdesignremote'], - 1 ) != "/" or substr ( $_POST ['realstaticremotepath'], - 1 ) != "/" or ($_POST ["realstaticspeicherart"] == 1 and substr ( $_POST ['realstaticremotepath'], - 1 ) != "/") or ($_POST ["realstaticspeicherart"] == 2 and substr ( $_POST ['realstaticlokalerspeicherpfad'], - 1 ) != "/") or ($_POST ["realstaticspeicherart"] == 3 and substr ( $_POST ['realstaticremotepathsftp'], - 1 ) != "/"))
				reallystatic_configerror ( 0, __("You forgot a / at the end of the path!", 'reallystatic' ) );
			reallystatic_configok ( __ ( "Saved", 'reallystatic'  ), 1 );
		}
	}
	
	if ($_POST ['strid'] == "rs_settings") {
		update_option ( 'realstaticrefreshallac', $_POST ['refreshallac'] );
		update_option ( 'realstaticnonpermanent', $_POST ['nonpermanent'] );
		update_option ( 'dontrewritelinked', $_POST ['dontrewritelinked'] );
		update_option ( 'rewritealllinked', $_POST ['rewritealllinked'] );
		
		update_option ( 'maketagstatic', $_POST ['maketagstatic'] );
		update_option ( 'makecatstatic', $_POST ['makecatstatic'] );
		update_option ( 'makeauthorstatic', $_POST ['makeauthorstatic'] );
		update_option ( 'makedatestatic', $_POST ['makedatestatic'] );
		update_option ( 'makeindexstatic', $_POST ['makeindexstatic'] );
	}
	
	global $rewritestrID;
	$rewritestrID = $_POST ['strid'];
} else {
	global $rewritestrID;
	$rewritestrID = $_POST ['strid2'];
}
if (isset ( $_POST ["go"] )) {
	
	if ($_POST ["go"] == 1) {
		$a = loaddaten ( "realstaticposteditcreatedelete" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'realstaticposteditcreatedelete', $aa );
	
	} elseif ($_POST ["go"] == 2) {
		$a = loaddaten ( "realstaticpageeditcreatedelete" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'realstaticpageeditcreatedelete', $aa );
	
	} elseif ($_POST ["go"] == 3) {
		$a = loaddaten ( "realstaticcommenteditcreatedelete" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'realstaticcommenteditcreatedelete', $aa );
	
	} elseif ($_POST ["go"] == 4) {
		$a = loaddaten ( "realstaticeveryday" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'realstaticeveryday', $aa );
	
	} elseif ($_POST ["go"] == 5) {
		$aa = array ();
		$a = loaddaten ( "realstaticeverytime" );
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'realstaticeverytime', $aa );
	} elseif ($_POST ["go"] == 8) {
		#echo "<hr>123";
		$a = loaddaten ( "dateierweiterungen" );
		$a ["." . $_POST ["ext"]] = 1;
		update_option ( "dateierweiterungen", $a );
	} elseif ($_POST ["go"] == 9) {
		$a = loaddaten ( "dateierweiterungen" );
		foreach ( $a as $k => $v ) {
			if (md5 ( $k ) != $_POST ["md5"])
				$b [$k] = 1;
		
		}
		update_option ( "dateierweiterungen", $b );
	} elseif ($_POST ["go"] == "a1") {
		$a = loaddaten ( "makestatic-a1" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'makestatic-a1', $aa );
	
	} elseif ($_POST ["go"] == "a2") {
		$a = loaddaten ( "makestatic-a2" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'makestatic-a2', $aa );
	
	} elseif ($_POST ["go"] == "a3") {
		$a = loaddaten ( "makestatic-a3" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'makestatic-a3', $aa );
	
	} elseif ($_POST ["go"] == "a4") {
		$a = loaddaten ( "makestatic-a4" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'makestatic-a4', $aa );
	
	} elseif ($_POST ["go"] == "a5") {
		$a = loaddaten ( "makestatic-a5" );
		$aa = array ();
		foreach ( $a as $v ) {
			if ($v [0] != $_POST ["md5"])
				$aa [] = $v;
		}
		update_option ( 'makestatic-a5', $aa );
	
	}

}
/*
 * Resetting Logfile
 */
if ($_POST ["strid2"] == "rs_logfile") {
	reallystatic_configok ( __("cleaning Logfile", 'reallystatic' ) );
	$fh = @fopen ( LOGFILE, "w+" );
	@fwrite ( $fh, "<pre>" );
	@fclose ( $fh );
}
if (isset ( $_POST ["ngo"] )) {
	
	if ($_POST ["was"] == 1) {
		$r = loaddaten ( 'realstaticposteditcreatedelete' );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( 'realstaticposteditcreatedelete', ($r) );
	} elseif ($_POST ["was"] == 2) {
		$r = loaddaten ( 'realstaticpageeditcreatedelete' );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( 'realstaticpageeditcreatedelete', ($r) );
	} elseif ($_POST ["was"] == 3) {
		$r = loaddaten ( 'realstaticcommenteditcreatedelete' );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( 'realstaticcommenteditcreatedelete', ($r) );
	} elseif ($_POST ["was"] == 4) {
		$r = loaddaten ( 'realstaticeveryday' );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( 'realstaticeveryday', ($r) );
	} elseif ($_POST ["was"] == 5) {
		$r = loaddaten ( 'realstaticeverytime' );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( 'realstaticeverytime', ($r) );
	} elseif ($_POST ["was"] == "a1") {
		$r = loaddaten ( "makestatic-a1" );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( "makestatic-a1", ($r) );
	} elseif ($_POST ["was"] == "a2") {
		$r = loaddaten ( "makestatic-a2" );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( "makestatic-a2", ($r) );
	} elseif ($_POST ["was"] == "a3") {
		$r = loaddaten ( "makestatic-a3" );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( "makestatic-a3", ($r) );
	} elseif ($_POST ["was"] == "a4") {
		$r = loaddaten ( "makestatic-a4" );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( "makestatic-a4", ($r) );
	} elseif ($_POST ["was"] == "a5") {
		$r = loaddaten ( "makestatic-a5" );
		$r [] = array ($_POST ["url"], $_POST ["rewiteinto"] );
		sort ( $r );
		update_option ( "makestatic-a5", ($r) );
	}

}
if (isset ( $_POST ["donate"] )) {
	$get = @really_static_download ( "http://www.sorben.org/really-static/donateask.php?id=" . $_POST ["donate"] . "&s=" . $_SERVER ["SERVER_NAME"] . "&ip=" . $_SERVER ["SERVER_ADDR"] );
	if (substr ( $get, 0, 1 ) == "1") {
		update_option ( 'realstaticdonationid', substr ( $get, 1 ) );
	} else {
		global $reallystaticsystemmessage;
		$reallystaticsystemmessage = "The PayPal transaction ID seams not to be right. Please try it again later, thank you!";
	}
}
if (isset ( $_POST ["refreshurl"] )) {
	if (loaddaten ( "realstaticnonpermanent" ) == true)
		$mm = "?" . str_replace ( "/", "&", substr ( $_POST ["refreshurl"], strlen ( loaddaten ( "remoteurl" ) ), - 1 ) );
	else
		$mm = str_replace ( loaddaten ( "realstaticremoteurl" ), "", $_POST ["refreshurl"] );
	if (substr ( $mm, - 10 ) == "index.html")
		$mm = substr ( $mm, 0, - 11 );
	getnpush ( loaddaten ( "localurl" ) . $mm, $mm );
	global $reallystaticsystemmessage;
	$reallystaticsystemmessage = __ ( 'done refreshing manually a single page', 'reallystatic' );
}

if (isset ( $_POST ["hideme2"] )) {
	/* Datenbankreset */
	global $wpdb;
	$table_name = $wpdb->prefix . "realstatic";
	$wpdb->query ( "  Delete FROM $table_name" );
	reallystatic_configok ( __("Successfull reset of really-static filedatabase", 'reallystatic' ) );
}

if (isset ( $_POST ["hideme"] )) {
	/* manuell all refresh */
	global $internalrun, $test, $showokinit;
	$internalrun = true;
	global $wpdb;
	reallystatic_configok ( __("cleaning Logfile", 'reallystatic' ), 2 );
	RS_log ( false );
	
	$a = getothers ( "everyday" );
	reallystatic_configok ( "->Everyday", 2 );
	if (is_array ( $a )) {
		foreach ( $a as $v ) {
			getnpush ( loaddaten ( "localurl" ) . $v [0], $v [0], true );
		}
	}
	$a = getothers ( "posteditcreatedelete" );
	reallystatic_configok ( "->posteditcreatedelete:", 2 );
	if (is_array ( $a )) {
		foreach ( $a as $v ) {
			$v [0] = str_replace ( "%postname%", str_replace ( array (loaddaten ( "localurl" ), loaddaten ( "remoteurl" ) ), array ("", "" ), get_permalink ( $id ) ), $v [0] );
			getnpush ( loaddaten ( "localurl" ) . $v [0], $v [0], true );
		}
	}
	$table_name = $wpdb->prefix . "realstatic";
	reallystatic_configok ( "->main", 2 );
	$lastposts = get_posts ( 'numberposts=9999 ' );
	foreach ( $lastposts as $post ) {
		$querystr = "SELECT datum  FROM 	$table_name where url='" . md5 ( get_page_link ( $post->ID ) ) . "'";
		$ss = $wpdb->get_results ( $querystr, OBJECT );
		if ($ss [0]->datum > 0) {
			echo __("Skiping existing:", 'reallystatic' )." " . get_page_link ( $post->ID ) . "<br>";
		} else {
			renewrealstaic ( $post->ID, true );
		}
	
	}
	//Statische seitem
	$lastposts = get_pages ( 'numberposts=999' );
	foreach ( $lastposts as $post ) {
		$t = str_replace ( array (get_option ( 'siteurl' ) . "/", get_option ( 'siteurl' ), loaddaten ( "realstaticlocalurl" ), loaddaten ( "realstaticremoteurl" ), "//" ), array ("", "", "", "", "/" ), get_page_link ( $post->ID ) );
		getnpush ( loaddaten ( "localurl" ) . $t, $t, true );
	
	}
	reallystatic_configok ( __("Finish", 'reallystatic' ), 3 );
}
?>