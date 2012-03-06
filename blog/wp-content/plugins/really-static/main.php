<?php
/*
 Plugin Name: Really Static
 Plugin URI: http://www.sorben.org/really-static/index.html
 Description:  Make your Blog really static! Please study the <a href="http://www.sorben.org/really-static/">quick start instuctions</a>!
 Author: Erik Sefkow
 Version: 0.31
 Author URI: http://www.sorben.org/
 */
/**
 * Make your Blog really static!
 * @author Erik Sefkow 
 * @version 0.31
 *
 * Copyright 2008-2010 Erik Sefkow
 *
 * Really static is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Really static is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
if (! defined ( "WP_CONTENT_URL" ))
	define ( "WP_CONTENT_URL", get_option ( "siteurl" ) . "/wp-content" );
if (! defined ( "WP_CONTENT_DIR" ))
	define ( "WP_CONTENT_DIR", ABSPATH . "wp-content" );
if (! defined ( 'REALLYSTATICHOME' ))
	define ( 'REALLYSTATICHOME', dirname ( __FILE__ ) . '/' );
if (! defined ( 'REALLYSTATICURLHOME' ))
	define ( 'REALLYSTATICURLHOME', WP_CONTENT_URL . str_replace ( "\\", "/", substr ( dirname ( __FILE__ ), strpos ( dirname ( __FILE__ ), "wp-content" ) + 10 ) ) . '/' );

@set_time_limit ( 0 );

#### PLEASE Do not change anything here!
global $rs_version, $rs_rlc;
$rs_version = "0.31";
$rs_rlc = 87;
define ( 'RSVERSION',$rs_version );
define ( 'RSSUBVERSION', $rs_rlc);
if (preg_match ( '#' . basename ( __FILE__ ) . '#', $_SERVER ['PHP_SELF'] )) {
	die ( 'Get it here: <a title="really static wordpress plugin" href="http://www.sorben.org/really-static/">really static wordpress plugin</a>' );
}
$currentLocale = get_locale ();
if (! empty ( $currentLocale )) {
	$moFile = dirname ( __FILE__ ) . "/languages/reallystatic-" . $currentLocale . ".mo";
	if (@file_exists ( $moFile ) && is_readable ( $moFile ))
		load_textdomain ( 'reallystatic', $moFile );
}

define ( 'LOGFILE', REALLYSTATICHOME . 'log.html' );
if(get_option('permalink_structure')=="")define('REALSTATICNONPERMANENT',true);
else define('REALSTATICNONPERMANENT',false);
/*
* Write a text into Logfile
*/
function RS_log($line) {
	
	if ($line === false) {
		$fh = @fopen ( LOGFILE, "w+" );
		@fwrite ( $fh, "<pre>" );
		@fclose ( $fh );
		return;
	}
	$fh = @fopen ( LOGFILE, "a+" );
	@fwrite ( $fh, date ( "d M Y H:i:s", time () + (get_option ( 'gmt_offset' ) * 3600) ) . ": " . $line . "\r\n" );
	@fclose ( $fh );
}
/*
* Loadfunktion
*/
function loaddaten($name) {
	if ($name == "localpath")
		return ABSPATH;
	if ($name == "subpfad")
		$name = "realstaticsubpfad";
	if ($name == "localurl")
		$name = "realstaticlocalurl";
	if ($name == "remotepath")
		$name = "realstaticremotepath";
	if ($name == "remoteurl")
		$name = "realstaticremoteurl";
	
	if (get_option ( $name ) === false) {
		require ("php/missing.php");
	}
	
	if ($name == "realstaticposteditcreatedelete") {
		$r = get_option ( $name );
		if (count ( $r ) > 0) {
			if (! is_array ( $r [0] )) {
				foreach ( $r as $k )
					$rr [] = array ($k, "" );
				
				update_option ( $name, $rr );
				unset ( $rr );
				unset ( $r );
			}
		}
	}
	
	if ($name == "realstaticpageeditcreatedelete") {
		$r = get_option ( $name );
		if (count ( $r ) > 0) {
			if (! is_array ( $r [0] )) {
				foreach ( $r as $k )
					$rr [] = array ($k, "" );
				update_option ( $name, $rr );
				unset ( $rr );
				unset ( $r );
			}
		}
	}
	if ($name == "realstaticcommenteditcreatedelete") {
		$r = get_option ( $name );
		if (count ( $r ) > 0) {
			if (! is_array ( $r [0] )) {
				foreach ( $r as $k )
					$rr [] = array ($k, "" );
				update_option ( $name, $rr );
				unset ( $rr );
				unset ( $r );
			}
		}
	}
	
	if ($name == "realstaticeveryday") {
		$r = get_option ( $name );
		if (count ( $r ) > 0) {
			if (! is_array ( $r [0] )) {
				foreach ( $r as $k )
					$rr [] = array ($k, "" );
				update_option ( $name, $rr );
				unset ( $rr );
				unset ( $r );
			}
		}
	}
	if ($name == "realstaticeverytime") {
		$r = get_option ( $name );
		if (count ( $r ) > 0) {
			if (! is_array ( $r [0] )) {
				foreach ( $r as $k )
					$rr [] = array ($k, "" );
				update_option ( $name, $rr );
				unset ( $rr );
				unset ( $r );
			}
		}
	}
	
	return get_option ( $name );
}

/*
 * Kommentar löschen
 * @return: Id
 */
add_action ( 'delete_comment', 'komentar3', 550 );
function komentar3($id) {
	global $killcoment;
	global $wpdb;
	$querystr = "SELECT comment_post_ID  as outo FROM " . $wpdb->prefix . "comments WHERE comment_ID  = '$id'";
	$anzneueralsdieser = $wpdb->get_results ( $querystr, OBJECT );
	$killcoment = $anzneueralsdieser [0]->outo;
	return $id;
}
/*
 * stellt sicher das erstellen von kommentar nicht als seitenedit ausgelegt wird
 */
add_action ( 'wp_update_comment_count', 'lala', 550 );
function lala() {
	global $iscomment;
	$iscomment = true;

}
/*
 * wird aufgerufen wenn ein Post gelöscht wird
 */
add_action ( 'delete_post', 'delete_post' );
add_action ( 'deleted_post', 'delete_post' );
function delete_post($id) {
	global $deleteingpost;
	$deleteingpost [] = get_page_link ( $id ); #seite selber
}
/*
 * komentar wird gepostet und benutzer wird weiter geleitet
 */
add_action ( 'comment_post', 'komentar2', 550 );
function komentar2($id) {
	$pid = komentar ( $id );
	if (false === get_permalink ( $pid ))
		header ( "Location: " . nonpermanent ( loaddaten ( "remoteurl" ) . cleanupurl ( get_permalink ( intval ( $_POST [comment_post_ID] ) ) ) . "#comment-$id" ) );
	else
		header ( "Location: " . nonpermanent ( loaddaten ( "remoteurl" ) . cleanupurl ( get_permalink ( $pid ) ) . "#comment-$id" ) );
	exit;
}
/*
 * Komentar Hauptfunktion
 * $typ nur bei wp_set status, beinhaltet aprove,spam,trash,0
 */
add_action ( 'wp_set_comment_status', 'komentar', 550,2 );
add_action ( 'edit_comment', 'komentar', 550 );
function komentar($id,$typ=false) {
	RS_LOG("KK");
	global $notagain;
	if (isset ( $notagain [$id] ))
		return;
	$notagain [$id] = 1;
	global $wpdb;
	
	$anzneueralsdieser = $wpdb->get_results ( "SELECT comment_post_ID  as outo, comment_approved as wixer FROM " . $wpdb->prefix . "comments	WHERE comment_ID  = '$id'", OBJECT );
	global $killcoment;
	if ($typ==false and $anzneueralsdieser [0]->wixer != 1)
		return;
	$li = $anzneueralsdieser [0]->outo;
	if (isset ( $killcoment )) {
		$li = $killcoment;
		unset ( $killcoment );
	}
	if (loaddaten ( "realstaticrefreshallac" ) == true) {
		global $iscomment;
		$iscomment = false;
		renewrealstaic ( $li );
	} else
		nurdieseseite ( $li );
	return $li;
}
/*
function komentar4($id,$status) {

	//aprove,spam,trash,0
	global $notagain;
	if (isset ( $notagain [$id] ))
		return;
	$notagain [$id] = 1;
	
	$pid = komentar ( $id );
}*/
/*
 * wird durch komentar funktionaufgerufen
 * 
 */
function nurdieseseite($id,$allrefresh=123) {
	$a = getothers ( "posteditcreatedelete" );
	if (is_array ( $a )) {
		foreach ( $a as $v ) {
			$v [0] = str_replace ( "%postname%", str_replace ( array (loaddaten ( "localurl" ), loaddaten ( "remoteurl" ) ), array ("", "" ), get_permalink ( $id ) ), $v [0] );
			getnpush ( loaddaten ( "localurl" ) . $v [0], $v [0], $allrefresh );
		
		}
	}
}
/**
 gibt die anzahl neuerer posts vor dem eigentlichen zurück
 */
function getinnewer($erstell, $pageposts, $id, $typ, $muddicat = "") {
	global $wpdb;
	$querystr = "SELECT term_taxonomy_id as outo FROM " . $wpdb->prefix . "term_taxonomy where taxonomy='$typ' and term_id='$id'";
	$anzneueralsdieser = $wpdb->get_results ( $querystr, OBJECT );
	$id = $anzneueralsdieser [0]->outo;
	
	if (isset ( $muddicat )) {
		$addition = "(`term_taxonomy_id` = '$id' $muddicat)";
	} else
		$addition = "`term_taxonomy_id` = '$id'";
	$querystr = "SELECT count(ID) as outo FROM " . $wpdb->prefix . "posts, " . $wpdb->prefix . "term_relationships WHERE post_status = 'publish' AND object_id = ID AND $addition AND post_date>'$erstell'";
	$anzneueralsdieser = $wpdb->get_results ( $querystr, OBJECT );
	return (1 + floor ( $anzneueralsdieser [0]->outo / $pageposts ));
}
function really_static_download($url) {
	update_option("rs_counter",loaddaten("rs_counter")+1);
	if (function_exists ( 'file_get_contents' ) and ini_get ( 'allow_url_fopen' ) == 1) {
		$file = @file_get_contents ( $url );
	} else {
		$curl = curl_init ( $url );
		curl_setopt ( $curl, CURLOPT_HEADER, 0 );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		$file = curl_exec ( $curl );
		curl_close ( $curl );
	}
	if ($file === false)
		RS_log ( __ ( "Getting a error (timeout or 404 or 500 ) while loading: ", 'reallystatic' ) . $url );
		
	do_action("rs-downloaded-url",$file,$url);
	return $file;
}
/*
 * Läd Datei und bearbeitet diese
 */
function really_static_geturl($url) {
	$file = really_static_download ( $url );
	if ($file === false)
		return $file;
	$file=apply_filters ( "rs-pre-rewriting-filecontent",$file,$url);
	if ($file {0} == "\n")
		$file = substr ( $file, 1 );
	if ($file {0} == "\r")
		$file = substr ( $file, 1 );
	$file = preg_replace_callback ( array ('#<link>(.*?)</link>#', '#<wfw:commentRss>(.*?)</wfw:commentRss>#', '#<comments>(.*?)</comments>#', '# RSS-Feed" href="(.*?)" />#', '# Atom-Feed" href="(.*?)" />#' ), create_function ( '$treffer', 'return str_replace(loaddaten("localurl"),loaddaten("remoteurl"),$treffer[0]);' ), $file );
	global $rs_version;
	$file = preg_replace ( '#<generator>http://wordpress.org/?v=(.*?)</generator>#', '<generator>http://www.sorben.org/really-static/version.php?v=$1-RS' . $rs_version . '</generator>', $file );
	$file = preg_replace ( '#<link rel="EditURI"(.*?)>#', "", $file );
	$file = preg_replace ( '#<link rel="wlwmanifest"(.*?)>#', "", $file );
	$file = preg_replace ( '#<link rel="pingback"(.*?)>#', "", $file );
	$file = preg_replace ( '#<meta name="generator" content="WordPress (.*?)" />#', '<meta name="generator" content="WordPress $1 - Realstatic ' . $rs_version . '" />', $file );
	$file = str_replace ( loaddaten ( "realstaticdesignlocal" ), loaddaten ( "realstaticdesignremote" ), $file );
	if (substr ( $file, 0, 5 ) != "<?xml") {
		$file = preg_replace_callback ( '#<a(.*?)href=("|\')(.*?)("|\')(.*?)>(.*?)</a>#si', "urlrewirte", $file );
	} else {
		$file = preg_replace ( "#<wfw\:commentRss>(.*?)<\/wfw\:commentRss>#", "", $file );
		$file = preg_replace_callback ( '#<(link|comments)>(.*?)<\/(link|comments)>#si', "urlrewirte3", $file );
		
		$file = preg_replace_callback ( '#<(\?xml\-stylesheet)(.*?)(href)=("|\')(.*?)("|\')(\?)>#si', "urlrewirte4", $file );
	}
	$file = preg_replace_callback ( '#<(link|atom\:link|content)(.*?)(href|xml\:base)=("|\')(.*?)("|\')(.*?)>#si', "urlrewirte2", $file );
	$file = preg_replace_callback ( '#<img(.*?)src=("|\')(.*?)("|\')(.*?)>#si', "imgrewirte", $file );
	
	#$file = preg_replace_callback ( '#<link rel="canonical" href="(.*?)" />#si', "canonicalrewrite", $file );
	

	if (substr ( $url, - 11 ) == "sitemap.xml") {
		$file = preg_replace_callback ( '#<loc>(.*?)</loc>#si', "sitemaprewrite", $file );
	}
	
	if (loaddaten ( "rewritealllinked" ) == 1) {
		$file = str_replace ( loaddaten ( "realstaticlocalurl", 'reallystatic' ), loaddaten ( "realstaticremoteurl", 'reallystatic' ), $file );
		if (substr ( loaddaten ( "realstaticlocalurl", 'reallystatic' ), - 1 ) == "/")
			$file = str_replace ( substr ( loaddaten ( "realstaticlocalurl", 'reallystatic' ), 0, - 1 ), loaddaten ( "realstaticremoteurl", 'reallystatic' ), $file );
		$file = str_replace ( urlencode ( loaddaten ( "realstaticlocalurl", 'reallystatic' ) ), urlencode ( loaddaten ( "realstaticremoteurl", 'reallystatic' ) ), $file );
		if (substr ( loaddaten ( "realstaticlocalurl", 'reallystatic' ), - 1 ) == "/")
			$file = str_replace ( urlencode ( substr ( loaddaten ( "realstaticlocalurl", 'reallystatic' ), 0, - 1 ) ), urlencode ( loaddaten ( "realstaticremoteurl", 'reallystatic' ) ), $file );
	
	}
	$file=apply_filters ( "rs-post-rewriting-filecontent",$file,$url);
	#l&auml;uft mit <a href="http://wordpress.org/">WordPress</a>
	#$file = str_replace ( '<a href="http://wordpress.org/">WordPress</a>', '<a href="http://www.sorben.org/really-static/">Realstatic WordPress</a>', $file );
	$file = preg_replace ( '#(Powered by)(\s+)<a(.*?)href=("|\')(.*?)("|\')(.*?)>WordPress</a>#is', '$1$2<a$3href=$4http://www.sorben.org/really-static/$6$7>really static WordPress</a>', $file );
	$file = preg_replace ( '#(Powered by)(\s+)<a(.*?)href=("|\')(.*?)("|\')(.*?)>WordPress MU</a>#si', '$1$2<a$3href=$4http://www.sorben.org/really-static/$6$7>really static WordPress</a>', $file );
	return $file;

}
function stupidfilereplace($text) {
	
	global $stupidfilereplaceA, $stupidfilereplaceB;
	#stupidfilereplaceA wird in stupidfilereplaceB umgeschrieben
	

	if (! is_array ( $stupidfilereplaceA )) {
		
		$a = array_merge ( ( array ) loaddaten ( 'realstaticposteditcreatedelete' ), ( array ) loaddaten ( 'realstaticpageeditcreatedelete' ), ( array ) loaddaten ( 'realstaticcommenteditcreatedelete' ), ( array ) loaddaten ( 'realstaticeveryday' ), ( array ) loaddaten ( 'realstaticeverytime' ) );
		
		$stupidfilereplaceA = array ();
		
		foreach ( $a as $k ) {
			if ($k [1] != "") {
				$stupidfilereplaceA [] = '@^' . str_replace ( array ("?", "." ), array ("\?", "\." ), loaddaten ( "remoteurl" ) . $k [0] ) . "$@";
				$stupidfilereplaceB [] = loaddaten ( "remoteurl" ) . $k [1];
			}
		}
	
	}
	//URL felher ersetzer
	//"lala"
	$stupidfilereplaceA [] = '@\%e2\%80\%93@';
	$stupidfilereplaceB [] = "-";
	$stupidfilereplaceA [] = '@\%e2\%80\%9c@';
	$stupidfilereplaceB [] = "-";
	//´
	$stupidfilereplaceA [] = '@\%c2\%b4@';
	$stupidfilereplaceB [] = "-";
	
	return preg_replace ( $stupidfilereplaceA, $stupidfilereplaceB, $text );

}
function canonicalrewrite($array) {
	$path_parts = pathinfo ( $array [1] );
	if ($path_parts ["extension"] == "") {
		if (substr ( $$array [1], - 1 ) != "/")
			$array [1] .= "/";
	}
	return '<link rel="canonical" href="' . $array [1] . '" />';

}
function sitemaprewrite($array) {
	$path_parts = pathinfo ( $array [1] );
	if ($path_parts ["extension"] == "") {
		if (substr ( $$array [1], - 1 ) != "/")
			$array [1] .= "/";
	}
	return '<loc>' . $array [1] . '</loc>';
}
function imgrewirte($array) {
	if (loaddaten ( "dontrewritelinked" ) == 1)
		return "<img" . $array [1] . "src=" . $array [2] . $array [3] . $array [4] . $array [5] . ">";
	$array [3] = str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [3] ); //altlastenabfangen
	$a = $array [3];
	$l = strlen ( loaddaten ( "remoteurl" ) );
	$ll = strrpos ( $a, "/" );
	if (substr ( $a, 0, $l ) != loaddaten ( "remoteurl" ))
		return "<img" . $array [1] . "src=" . $array [2] . $array [3] . $array [4] . $array [5] . ">";
		#echo "!!";
	$a = str_replace ( loaddaten ( "remoteurl" ), "", $a );
	$ppp = ABSPATH;
	$l = strlen ( loaddaten ( "subpfad" ) );
	if ($l != 0 && substr ( $a, 0, $l ) == loaddaten ( "subpfad" ))
		$ppp = substr ( $ppp, 0, - $l );
	$fs = @filemtime ( $ppp . $a );
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1) {
		require_once ("php/ftp.php");
		rs_connect ( loaddaten ( "realstaticftpserver" ), loaddaten ( "realstaticftpuser" ), loaddaten ( "realstaticftppasswort" ), loaddaten ( "realstaticftpport" ) );
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2) {
		require_once ("php/local.php");
		rs_connect ();
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3) {
		require_once ("php/sftp.php");
		rs_connect ( loaddaten ( "realstaticsftpserver" ), loaddaten ( "realstaticsftpuser" ), loaddaten ( "realstaticsftppasswort" ), loaddaten ( "realstaticsftpport" ) );
	}
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "realstatic";
	$querystr = "    SELECT datum  FROM 	$table_name where url='" . md5 ( $a ) . "'";
	
	$ss = $wpdb->get_results ( $querystr, OBJECT );
	
	if ($ss [0]->datum == $fs)
		return "<img" . $array [1] . "src=" . $array [2] . str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [3] ) . $array [4] . $array [5] . ">";
	$wpdb->query ( "  Delete FROM $table_name where url='" . md5 ( $a ) . "'" );
	$wpdb->query ( "INSERT INTO `" . $wpdb->prefix . "realstatic` (`url` ,`datum`)VALUES ('" . md5 ( $a ) . "', '$fs');" );
	global $internalrun;
	if ($internalrun == true)
		reallystatic_configok ( $a, 2 );
	RS_log ( __ ( 'Writing ImageFile:', 'reallystatic' ) . " $a" );
	
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1)
		rs_writefile ( loaddaten ( "remotepath" ) . $a, $ppp . $a );
	elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2)
		rs_writefile ( loaddaten ( "realstaticlokalerspeicherpfad", 'reallystatic' ) . $a, $ppp . $a );
	elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3)
		rs_writefile ( loaddaten ( "realstaticremotepathsftp", 'reallystatic' ) . $a, $ppp . $a );
	do_action ( "rs-write-file", "img", loaddaten ( "remotepath" ) . $a, loaddaten ( "realstaticspeicherart", 'reallystatic' ));
	
	return "<img" . $array [1] . "src=" . $array [2] . str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [3] ) . $array [4] . $array [5] . ">";
}
/*
 * Links im sitemap
 */
function urlrewirte3($array) {
	$url = str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [2] );
	if (strpos ( $url, loaddaten ( "remoteurl" ) ) !== false) {
		$url = stupidfilereplace ( $url );
		
		$url = nonpermanent ( $url );
	
	}
	return "<" . $array [1] . ">" . $url . "</" . $array [3] . ">";
}
/*
 * XML-Stylesheet
 */
function urlrewirte4($array) {
	$url = str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [5] );
	if (strpos ( $url, loaddaten ( "remoteurl" ) ) !== false) {
		$url = stupidfilereplace ( $url );
		
		$url = nonpermanent ( $url );
	
	}
	
	return "<" . $array [1] . "" . $array [2] . "" . $array [3] . "=" . $array [4] . $url . $array [6] . "" . $array [7] . "" . $array [8] . ">";
}
/*
 * für metatags
 */
function urlrewirte2($array) {
	$url = str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [5] );
	if (strpos ( $url, loaddaten ( "remoteurl" ) ) !== false) {
		$url = stupidfilereplace ( $url );
		$url = nonpermanent ( $url );
	}
	return "<" . $array [1] . $array [2] . $array [3] . "=" . $array [4] . $url . $array [6] . $array [7] . ">";
}
/*
 * im Textgefundene Links
 */
function urlrewirte($array) {
	$url = str_replace ( loaddaten ( "localurl" ), loaddaten ( "remoteurl" ), $array [3] );
	if (strpos ( $url, loaddaten ( "remoteurl" ) ) !== false) {
		$exts = loaddaten ( "dateierweiterungen" );
		$ext = strrchr ( strtolower ( $url ), '.' );
		if (loaddaten ( "dontrewritelinked" ) != 1 && 1 == $exts [$ext]) {
			$l = str_replace ( loaddaten ( "remoteurl" ), "", $url );
			if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1)
				really_static_uploadfile ( loaddaten ( "localpath" ) . $l, loaddaten ( "remotepath" ) . $l );
			elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3)
				really_static_uploadfile ( loaddaten ( "localpath" ) . $l, loaddaten ( "realstaticremotepathsftp" ) . $l );
			elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2)
				really_static_uploadfile ( loaddaten ( "localpath" ) . $l, loaddaten ( "realstaticlokalerspeicherpfad" ) . $l );
		} else {
			if (loaddaten ( "dontrewritelinked" ) == 1 && 1 == $exts [$ext])
				$url = $array [3];
			$url = stupidfilereplace ( $url );
			$url = nonpermanent ( $url );
		}
	}
	return "<a" . $array [1] . "href=" . $array [2] . $url . $array [4] . $array [5] . ">" . $array [6] . "</a>";
}
/*
 * Lad eine datei auf den statischen server
*/
function really_static_uploadfile($local, $remote) {
	$fs = @filemtime ( $local );
	global $wpdb;
	$table_name = $wpdb->prefix . "realstatic";
	$ss = $wpdb->get_results ( "SELECT datum  FROM 	$table_name where url='" . md5 ( $local ) . "'", OBJECT );
	if ($ss [0]->datum == $fs)
		return false;
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1) {
		require_once ("php/ftp.php");
		rs_connect ( loaddaten ( "realstaticftpserver" ), loaddaten ( "realstaticftpuser" ), loaddaten ( "realstaticftppasswort" ), loaddaten ( "realstaticftpport" ) );
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2) {
		require_once ("php/local.php");
		rs_connect ();
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3) {
		require_once ("php/sftp.php");
		rs_connect ( loaddaten ( "realstaticsftpserver" ), loaddaten ( "realstaticsftpuser" ), loaddaten ( "realstaticsftppasswort" ), loaddaten ( "realstaticsftpport" ) );
	}
	RS_log ( __ ( 'Writing File:', 'reallystatic' ) . " $local" );
	global $internalrun;
	
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1)
		rs_writefile ( $remote, $local );
	elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2)
		rs_writefile ( $remote, $local );
	elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3)
		rs_writefile ( $remote, $local );
	do_action ( "rs-write-file","any",  $local,  loaddaten ( "realstaticspeicherart", 'reallystatic' ) ) ;
	
	$wpdb->query ( "Delete FROM $table_name where url='" . md5 ( $local ) . "'" );
	$wpdb->query ( "INSERT INTO `" . $wpdb->prefix . "realstatic` (`url` ,`datum`)VALUES ('" . md5 ( $local ) . "', '$fs');" );
	return true;
}
/*
* Erneuern einer einzelnen seite
* Hauptfunktion 2
*/
function getnpush($get, $push, $allrefresh = false) {
	global $notagain, $wpdb;
	if (loaddaten ( "dontrewritelinked" ) != 1) {
		$push = str_replace ( loaddaten ( "remoteurl" ), "", stupidfilereplace ( loaddaten ( "remoteurl" ) . $push ) );
		$push = nonpermanent ( $push );
	}
	$path_parts = pathinfo ( $push );
	
	if ($path_parts ["extension"] == "") {
		if (substr ( $push, - 1 ) != "/")
			$push .= "/index.html";
		else
			$push .= "index.html";
	}
	
	$table_name = $wpdb->prefix . "realstatic";
	if ($allrefresh !== false) {
		//timeout hile
		$querystr = "SELECT datum,content  FROM 	$table_name where url='" . md5 ( $push ) . "'";
		$ss = $wpdb->get_results ( $querystr, OBJECT );
		$contentmd5 = $ss [0]->content;
		$lastmodifieddatum =$ss [0]->datum;
		if ($allrefresh === true and $lastmodifieddatum > 0) {
			return;
		}
	}
	
	if (isset ( $notagain [$push] ))
		return;
	$notagain [$push] = 1;
	RS_log ( __ ( 'get', 'reallystatic' ) . " $get" );
	$pre_remoteserver = loaddaten ( "remotepath" );
	$pre_localserver = loaddaten ( "localpath" );
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1) {
		require_once ("php/ftp.php");
		rs_connect ( loaddaten ( "realstaticftpserver" ), loaddaten ( "realstaticftpuser" ), loaddaten ( "realstaticftppasswort" ), loaddaten ( "realstaticftpport" ) );
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2) {
		require_once ("php/local.php");
		rs_connect ();
	}
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3) {
		require_once ("php/sftp.php");
		rs_connect ( loaddaten ( "realstaticsftpserver" ), loaddaten ( "realstaticsftpuser" ), loaddaten ( "realstaticsftppasswort" ), loaddaten ( "realstaticsftpport" ) );
	}
	global $internalrun;
	
	$content = really_static_geturl ( $get );
	if ($content !== false) {
		$contentmd52 = md5 ( $content );
		
		if ($allrefresh == "123") {
			if ($contentmd5 == $contentmd52) {
				RS_log ( __ ( 'Cachehit' ) . ": " . loaddaten ( "remotepath" ) . "$push @ ".date("d.m.Y H:i:s",$lastmodifieddatum) );
				return;
			}
		}
		if ($internalrun == true)
			reallystatic_configok ( $get, 2 );
		
		RS_log ( __ ( 'writing', 'reallystatic' ) . ": " . loaddaten ( "remotepath" ) . "$push ".strlen($content)." Byte");
		
		if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1)
			rs_writecontent ( loaddaten ( "remotepath" ) . $push, $content );
		elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2)
			rs_writecontent ( loaddaten ( "realstaticlokalerspeicherpfad", 'reallystatic' ) . $push, $content );
		elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3)
			rs_writecontent ( loaddaten ( "realstaticremotepathsftp", 'reallystatic' ) . $push, $content );
		do_action ( "rs-write-file", "content",  loaddaten ( "remotepath" ) . $push,  loaddaten ( "realstaticspeicherart", 'reallystatic' ) ) ;
		
		$wpdb->query ( "Delete FROM 	$table_name where url='" . md5 ( $push ) . "'" );
		$wpdb->query ( "INSERT INTO `$table_name` (`url` ,`content`,`datum`)VALUES ('" . md5 ( $push ) . "', '" . $contentmd52 . "','" . time () . "');" );
	}

}

function writeeeverytime() {
	// immer, egal ob bei neu, edit oder grill


}
function werb() {
	if (loaddaten ( "realstaticdonationid" ) != "")
		return ("");
	return ('<script type="text/javascript">
//<![CDATA[
document.write(\'<a href="http://www.sorben.org/really-static/"><img style="width:1;height=1;margin:0px;padding: 0px;border: 0px;" src="http://www.sorben.org/really-static/nix.gif"><\/a>\');
//]]>
</script><noscript><p id="lumbo2"><a href="http://www.sorben.org/really-static/">Powered by really-static</a></p></noscript>');
}
/*
* OLD
*/
function getothers($when) {
	if ($when == "everyday") {
		return loaddaten ( 'realstaticeveryday' );
	} elseif ($when == "everytime") {
		return loaddaten ( 'realstaticeverytime' );
	} elseif ($when == "posteditcreatedelete") {
		return loaddaten ( 'realstaticposteditcreatedelete' );
	}
}
/*
* OLD .. löschen?
*/
function writenew($id) {
	
	//index seiten
	$querystr = "SELECT count(ID) as outo FROM " . $wpdb->prefix . "posts	WHERE post_status = 'publish'";
	$normaleseiten = $wpdb->get_results ( $querystr, OBJECT );
	$normaleseiten = 1 + floor ( $normaleseiten [0]->outo / $pageposts );

}
/*
* Entfernt mögliche urlvorsetze --> realer pfad wordpresspfad ohne domain davor
*/
function cleanupurl($url) {
	return str_replace ( array (get_option ( 'siteurl' ) . "/", get_option ( 'siteurl' ), loaddaten ( "localurl" ), loaddaten ( "remoteurl" ) ), array ("", "", "", "" ), $url );
}
/*
* Hauptfunktion
*/
add_action ( 'publish_post', 'renewrealstaic' );
add_action ( 'edit_post', 'renewrealstaic', 999 );
function renewrealstaic($id, $allrefresh = 123) { #
	global $iscomment;
	
	if ($iscomment === true)
		return $id;
		#echo "realystatic";
	global $wpdb, $notagain, $wp_rewrite;
	if (isset ( $notagain [$id] ))
		return;
		//test ob es ein draft ist
	$table_name = $wpdb->prefix . "posts";
	//Eintraege pro post
	$querystr = " SELECT post_status  FROM $table_name where id='" . $id . "'";
	$pageposts = $wpdb->get_results ( $querystr, OBJECT );
	$pageposts = $pageposts [0]->post_status;
	if ($pageposts == "draft" or wp_is_post_autosave ( $id ))
		return;
	$notagain [$id] = 1;
	global $publishingpost;
	if ($_POST ["originalaction"] == "post")
		$publishingpost = true;
	$table_name = $wpdb->prefix . "options";
	//Eintraege pro post
	$querystr = " SELECT option_value  FROM $table_name where option_name='posts_per_page'";
	$pageposts = $wpdb->get_results ( $querystr, OBJECT );
	$pageposts = $pageposts [0]->option_value;
	$table_name = $wpdb->prefix . "posts";
	//Eintraege pro post
	$querystr = "SELECT post_date  FROM $table_name where ID='$id'";
	$erstell = $wpdb->get_results ( $querystr, OBJECT );
	$erstell = $erstell [0]->post_date; //wann wurde post erstellt
	

	if (loaddaten ( "makeindexstatic" ) == 1 and is_array ( loaddaten ( "makestatic-a2" ) )) {
		foreach ( loaddaten ( "makestatic-a1" ) as $value ) {
			$url = $value [1];
			if ($url == "")
				$url = $value [0];
				//indexseiten
			$querystr = "SELECT count(ID) as outo FROM " . $wpdb->prefix . "posts	WHERE post_status = 'publish' AND post_date>'$erstell'";
			$normaleseiten = $wpdb->get_results ( $querystr, OBJECT );
			$normaleseiten = 1 + floor ( $normaleseiten [0]->outo / $pageposts );
			if ($normaleseiten > 1) {
				if (REALSTATICNONPERMANENT == true)
					$normaleseiten = "?paged=$normaleseiten";
				else
					$normaleseiten = "page/$normaleseiten";
			} else
				$normaleseiten = "";
			getnpush ( loaddaten ( "localurl" ) . str_replace ( array("%indexurl%","//"), array($normaleseiten,"/"), $url ), str_replace ( array("%indexurl%","//"), array($normaleseiten,"/"), $url ), $allrefresh );
		}
	}
	//Seite selber
	$a = getothers ( "posteditcreatedelete" );
	if (is_array ( $a )) {
		foreach ( $a as $v ) {
			$v [0] = str_replace ( "%postname%", cleanupurl ( get_permalink ( $id ) ), $v [0] );
			getnpush ( loaddaten ( "localurl" ) . $v [0], $v [0], $allrefresh );
		
		}
	}
	// autor seiten
	if (loaddaten ( "makeauthorstatic" ) == 1 and is_array ( loaddaten ( "makestatic-a2" ) )) {
		foreach ( loaddaten ( "makestatic-a4" ) as $value ) {
			$url = $value [1];
			if ($url == "")
				$url = $value [0];
			$querystr = "SELECT post_author as outo FROM " . $wpdb->prefix . "posts	WHERE ID='$id'";
			$authorid = $wpdb->get_results ( $querystr, OBJECT );
			$m = str_replace ( "%authorurl%", cleanupurl ( get_author_posts_url ( $authorid [0]->outo ) ), $url );
			getnpush ( loaddaten ( "localurl" ) . $m, $m, $allrefresh );
		}
	}
	
	//Kategorien
	if (loaddaten ( "makecatstatic" ) == 1 and is_array ( loaddaten ( "makestatic-a2" ) )) {
		foreach ( loaddaten ( "makestatic-a3" ) as $value ) {
			$url = $value [1];
			if ($url == "")
				$url = $value [0];
			foreach ( (wp_get_post_categories ( $id )) as $category ) {
				//cat selber
				catrefresh ( $erstell, $pageposts, $category, $allrefresh, "", $url );
				$querystr = "SELECT term_taxonomy_id as outo FROM " . $wpdb->prefix . "term_taxonomy where taxonomy='category' and term_id='$category'";
				$anzneueralsdieser = $wpdb->get_results ( $querystr, OBJECT );
				$subcat = $anzneueralsdieser [0]->outo;
				$muddicat = " or `term_taxonomy_id` = '$subcat'";
				//muddi
				do {
					$querystr = "SELECT parent as outa FROM " . $wpdb->prefix . "term_taxonomy where taxonomy = 'category' AND term_id='$category'";
					$category = $wpdb->get_results ( $querystr, OBJECT );
					$category = $category [0]->outa;
					if ($category != 0) {
						$querystr = "SELECT term_taxonomy_id as outo FROM " . $wpdb->prefix . "term_taxonomy where taxonomy='category' and parent='$category'";
						$aa = $wpdb->get_results ( $querystr, OBJECT );
						if (count ( $aa ) > 0) {
							foreach ( $aa as $lk )
								$muddicat .= " or `term_taxonomy_id` = '" . $lk->outo . "'";
						}
						catrefresh ( $erstell, $pageposts, $category, $allrefresh, $muddicat, $url );
						$querystr = "SELECT term_taxonomy_id as outo FROM " . $wpdb->prefix . "term_taxonomy where taxonomy='category' and term_id='$category'";
						$anzneueralsdieser = $wpdb->get_results ( $querystr, OBJECT );
						$subcat = $anzneueralsdieser [0]->outo;
						$muddicat .= " or `term_taxonomy_id` = '$subcat'";
					}
				} while ( $category != 0 );
			
			}
		}
	}
	
	//Tags
	if (loaddaten ( "maketagstatic" ) == 1 and is_array ( loaddaten ( "makestatic-a2" ) )) {
		foreach ( loaddaten ( "makestatic-a2" ) as $value ) {
			$url = $value [1];
			if ($url == "")
				$url = $value [0];
			foreach ( (wp_get_post_tags ( $id )) as $tagoty ) {
				
				$seite = getinnewer ( $erstell, $pageposts, $tagoty->term_id, 'post_tag' );
				if ($publishingpost !== true) {
					if ($seite > 1) {
						if (REALSTATICNONPERMANENT == true)
							$seite = "&paged=$seite";
						else
							$seite = "/page/$seite";
					} else
						$seite = "";
					$m = str_replace ( array (loaddaten ( "localurl" ), loaddaten ( "remoteurl" ) ), array ("", "" ), get_tag_link ( $tagoty ) . $seite );
					getnpush ( loaddaten ( "localurl" ) . str_replace ( "%tagurl%", $m, $url ), str_replace ( "%tagurl%", $m, $url ), $allrefresh );
				} else {
					/*
						seite=seite auf dem der post landet
						seitemax=maximalanzahl
					*/
					$seitemax = getinnewer ( 0, $pageposts, $tagoty->term_id, 'post_tag' );
					for($seiter = $seite; $seiter <= $seitemax; $seiter ++) {
						if ($seiter > 1) {
							if (REALSTATICNONPERMANENT == true)
								$seitee = "&paged=$seiter";
							else
								$seitee = "/page/$seiter";
						} else
							$seitee = "";
						getnpush ( str_replace ( "%tagurl%", cleanupurl ( get_tag_link ( $tagoty ) . $seitee ), $url ), str_replace ( "%tagurl%", cleanupurl ( get_tag_link ( $tagoty ) . $seitee ), $url ), $allrefresh );
					}
				}
			}
		}
	}
	
	//date
	if (loaddaten ( "makedatestatic" ) == 1 and is_array ( loaddaten ( "makestatic-a5" ) )) {
		
		foreach ( loaddaten ( "makestatic-a5" ) as $value ) {
			
			$url = $value [1];
			if ($url == "")
				$url = $value [0];
			$e = strtotime ( $erstell );
			//Tag
			#$unten=date("Y-m-d 00:00:00",($e));
			$oben = date ( "Y-m-d 23:59:59", ($e) );
			$unten = $erstell;
			$querystr = "SELECT count(ID) as outa FROM " . $wpdb->prefix . "posts where post_status = 'publish' AND post_date>'$unten' and post_date<='$oben'";
			$tag = $wpdb->get_results ( $querystr, OBJECT );
			$tag = 1 + floor ( $tag [0]->outa / $pageposts );
			if ($tag > 1) {
				if (REALSTATICNONPERMANENT == true)
					$tag = "&paged=$tag";
				else
					$tag = "/page/$tag";
			} else
				$tag = "";
			$daylink = $wp_rewrite->get_day_permastruct ();
			if (empty ( $daylink ))
				$daylink = "/?m=%year%%monthnum%%day%";

			$t = str_replace ( array ("%day%", "%monthnum%", "%year%" ), array (date ( "d", $e ), date ( "m", $e ), date ( "Y", $e ) ), substr ( $daylink, 1 ) );

			getnpush ( loaddaten ( "localurl" ) . str_replace ( array ( "%dateurl%","//" ), array ( $t . $tag,"/" ), $url ), str_replace ( array ( "%dateurl%","//" ), array ( $t . $tag,"/" ), $url ), $allrefresh );
			//Monat
			$t = date ( "t", $e );
			#$unten=date("Y-m-01 00:00:00",($e));
			$oben = date ( "Y-m-$t 23:59:59", ($e) );
			$querystr = "SELECT count(ID) as outa FROM " . $wpdb->prefix . "posts where post_status = 'publish' AND post_date>'$unten' and post_date<='$oben'";
			$monat = $wpdb->get_results ( $querystr, OBJECT );
			$monat = 1 + floor ( $monat [0]->outa / $pageposts );
			if ($monat > 1) {
				if (REALSTATICNONPERMANENT == true)
					$monat = "&paged=$monat";
				else
					$monat = "/page/$monat";
			} else
				$monat = "";
			$monthlink = $wp_rewrite->get_month_permastruct ();
			if (empty ( $monthlink ))
				$monthlink = "/?m=%year%%monthnum%";
			$t = str_replace ( array ("%day%", "%monthnum%", "%year%" ), array (date ( "d", $e ), date ( "m", $e ), date ( "Y", $e ) ), substr ( $monthlink, 1 ) );
			getnpush ( loaddaten ( "localurl" ) . str_replace ( array ( "%dateurl%","//" ), array ( $t . $monat,"/" ), $url ), str_replace ( array ( "%dateurl%","//" ), array ( $t . $monat,"/" ), $url ), $allrefresh );
			//Jahr
			#$unten=date("Y-01-01 00:00:00",($e));
			$oben = date ( "Y-12-31 23:59:59", ($e) );
			$querystr = "SELECT count(ID) as outa FROM " . $wpdb->prefix . "posts where post_status = 'publish' AND post_date>'$unten' and post_date<='$oben'";
			$jahr = $wpdb->get_results ( $querystr, OBJECT );
			$jahr = 1 + floor ( $jahr [0]->outa / $pageposts );
			if ($jahr > 1) {
				if (REALSTATICNONPERMANENT == true)
					$jahr = "&paged=$jahr";
				else
					$jahr = "/page/$jahr";
			} else
				$jahr = "";
			$yearlink = $wp_rewrite->get_year_permastruct ();
			if (empty ( $yearlink ))
				$yearlink = "/?m=%year%";
			$t = str_replace ( array ("%day%", "%monthnum%", "%year%" ), array (date ( "d", $e ), date ( "m", $e ), date ( "Y", $e ) ), substr ( $yearlink, 1 ) );
			getnpush ( loaddaten ( "localurl" ) . str_replace ( array ( "%dateurl%" ,"//"), array ( $t . $jahr ,"/"), $url ), str_replace ( array ("%dateurl%" ,"//"), array ( $t . $jahr,"/" ), $url ), $allrefresh );
		
		}
	
	}
	/*
	 * Von anderen Plugin registrierte Dateien die auch statisch gemacht werden sollen
	 */
	global $reallystaticsinglepage;
	if (is_array ( $reallystaticsinglepage )) {
		foreach ( $reallystaticsinglepage as $vvreallystaticsinglepage ) {
			getnpush ( loaddaten ( "localurl" ) . $vvreallystaticsinglepage, $vvreallystaticsinglepage, $allrefresh );
		
		}
	
	}

}
/*
 * weitere Statische dateien hinzu
 */
function reallystaticsinglepagehook($url) {
	
	global $reallystaticsinglepage;
	$reallystaticsinglepage [] = $url;

}
/*
 * weitere Statische dateien löschen
 */
function reallystaticsinglepagedeletehook($url) {
	
	global $reallystaticsinglepagedelete;
	$reallystaticsinglepagedelete [] = $url;

}
/*
 * Löschen durchführen
 */
function reallystaticdeletepage($url) {
	global $wpdb;
	if (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 1) {
		require_once ("php/ftp.php");
		rs_connect ( loaddaten ( "realstaticftpserver" ), loaddaten ( "realstaticftpuser" ), loaddaten ( "realstaticftppasswort" ), loaddaten ( "realstaticftpport" ) );
	
	} elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 3) {
		require_once ("php/sftp.php");
		rs_connect ( loaddaten ( "realstaticsftpserver" ), loaddaten ( "realstaticsftpuser" ), loaddaten ( "realstaticsftppasswort" ), loaddaten ( "realstaticsftpport" ) );
	
	} elseif (loaddaten ( "realstaticspeicherart", 'reallystatic' ) == 2) {
		require_once ("php/local.php");
		rs_connect ();
	}
	$table_name = $wpdb->prefix . "realstatic";
	if ($url != "")
		rs_deletefile ( loaddaten ( "remotepath" ) . $url );
	else {
		global $reallystaticsinglepagedelete;
		if (isset ( $reallystaticsinglepagedelete )) {
			foreach ( $reallystaticsinglepagedelete as $v ) {
				RS_log ( __ ( 'Deleteing File:' ) . " $v" );
				rs_deletefile ( loaddaten ( "remotepath" ) . $v );
				$muell = $wpdb->get_results ( "update $table_name set content='' where url='" . md5 ( $v ) . "'", OBJECT );
			}
		}
	
	}

}

/*
 * Für das Menü
 */
add_action ( 'admin_menu', 'really_static_mainmenu', 22 );
function really_static_mainmenu() {
	if (function_exists ( 'add_submenu_page' ))
		add_submenu_page ( 'options-general.php', 'Really Static', 'Really Static', 10, __FILE__, 'really_static_settings' );
	else
		add_options_page ( 'Really Static', 'Really Static', 8, __FILE__, 'really_static_settings' );
}
/*
 * Setingsmenü
 */
function really_static_settings() {
	$base = plugin_basename ( __FILE__ );
	if (is_array ( $_POST ))
		require ("php/configupdate.php");
	if ($_GET ["menu"] == "123")
		require_once ("php/123.php");
	else {
		$h = "";
		$reallystaticfile = filemtime ( __FILE__ );
		require_once ("php/admin.php");
	}
}

function reallystatic_configerror($id, $addinfo = "") {
	if ($id == 0) {
		echo '<div id="front-page-warning" class="updated" style="background-color:#FF9999;border-color:#990000;">
	<p>' . $addinfo . '</p>
</div>';
	} else {
		echo '<div id="front-page-warning" class="updated fade-ff0000">
	<p>';
		reallystatic_errorinfo ( $id, $addinfo );
		echo '</p>
</div>';
	}
}
function reallystatic_configok($text, $typ = 1) {
	if ($typ == 1)
		echo '<div id="message" class="updated" style="background: #FFA; border: 1px #AA3 solid;"><p>' . $text . '</p></div>';
	elseif ($typ == 3) {
		echo '<script type="text/javascript">doingout("<b>Ready</b> <a href=\'#end\'>' . __ ( "jump to end" ) . '</a>");</script><a name="end"></a>';
	} else {
		global $showokinit;
		if ($showokinit != 2) {
			if ($_POST ["pos"] == "3")
				echo "<h2>Generating Files</h2>" . __ ( "Really-Staic is now generating, static files out of your Blog. Please wait until really-static is ready." );
			echo '<form  method="post" id="my_fieldset"><input type="hidden" name="strid2" value="rs_refresh" />
<input type="hidden" name="hideme" value="hidden" />
<input type="hidden" name="pos" value="3" />
<input type="submit" value=" If this stop befor its ready (because of a timeout) Press this Button"></form>';
			$showokinit = 2;
			echo '<div id="okworking"  class="updated fade"> blabla </div><script type="text/javascript">	function doingout(text){
	document.getElementById(\'okworking\').innerHTML = text;
	}</script><b>Done:</b><br>';
		}
		echo '<script type="text/javascript">doingout("<b>Working on:</b> ' . $text . '");</script>' . $text . "<br>";
	}
	ob_flush ();
	flush ();

}
function reallystatic_errorinfo($id, $addinfo = "") {
	
	require ("php/errorid.php");
}
/**
 * a = entscheider
 * t=1 = nur true false; t=2 rest
 * dann b
 * sonst c
 */
function ison($a, $t, $b, $c = "",$d="") {
	global $ison;
	if ($t == 1) {
		if ($a === true) {
			$ison ++;
			return $b;
		} else {
			$ison --;
			return $c;
		}
	} elseif ($t == 2) {
		if ($a == true) {
			$ison ++;
			return $b;
		} else {
			$ison --;
			return $c;
		}
		} elseif ($t == 3) {
		if ($a == $d) {
			$ison ++;
			return $b;
		} else {
			$ison --;
			return $c;
		}
	}
}
/**
 * Init 
 */
add_action ( 'init', 'rs_init' );
function rs_init($type) {
	add_action ( 'admin_notices', 'rs_notices' );
}
/**
 * Zeigt hinweis beim ersten aufruf oder nach updates 
 */
function rs_notices($type) {
	global $rs_version, $rs_rlc;
	if (loaddaten ( 'rs_firstTime' ) == - 1) {
		$base = plugin_basename ( __FILE__ );
		if (! @touch ( LOGFILE ))
			reallystatic_configerror ( 0, __("Set WRITE permissions on the file log.html", 'reallystatic') );
		if (! @touch ( REALLYSTATICHOME . "static/test.txt" ))
			reallystatic_configerror ( 0, __('Set WRITE permissions on the folder "Static"', 'reallystatic') );
		reallystatic_configok (sprintf(__("You need to configure your Really-Static plugin. Use our <a href='%s'>quicksetup</a> or click <a href='%s'>here</a> to jump into the settingsmenu.", 'reallystatic'),"options-general.php?page=" . $base."&menu=123","options-general.php?page=" . $base  ));
		
		update_option ( 'rs_firstTime', $rs_version . $rs_rlc );
	} elseif ( loaddaten ( 'rs_firstTime' ) == "0.3178") {
		reallystatic_configok ( "Please support me, by donating some money :-)" );
		update_option ( 'rs_firstTime', $rs_version . $rs_rlc );
	} elseif ($rs_version . $rs_rlc !=  loaddaten ( 'rs_firstTime' )) update_option ( 'rs_firstTime', $rs_version . $rs_rlc );
}

/*
* Aktivierungsroutine
*/
register_activation_hook ( __FILE__, 'reallystatic_activation' );
function reallystatic_activation() {
	if (ini_get ( 'allow_url_fopen' ) != 1 and ! function_exists ( "curl_init" )) {
		deactivate_plugins ( $_GET ['plugin'] );
		die ( reallystatic_errorinfo ( 1 )  );
	}
	require ("php/install.php");
	//Cronjob früh um 4
	wp_schedule_event ( mktime ( 4, 0, 0, date ( "m" ), date ( "d" ), date ( "Y" ) ), 'daily', 'reallystatic_daylyevent' );
}
/*
* Cronjob: Täglich
* @since 0.3
* @param none
* @return bool everytime true
*/
add_action ( 'reallystatic_daylyevent', 'reallystatic_cronjob' );
function reallystatic_cronjob() {
	$a = getothers ( "everyday" );
	if (is_array ( $a )) {
		foreach ( $a as $v ) {
			getnpush ( loaddaten ( "localurl" ) . $v [0], $v [0], 123 );
		}
	}
	return true;
}

/*
* Deinstallation
*/
register_deactivation_hook ( __FILE__, 'reallystatic_deactivation' );
function reallystatic_deactivation() {
	update_option ( 'rs_firstTime', - 1 );
	wp_clear_scheduled_hook ( 'reallystatic_daylyevent' );
}

/*
* für Kategorien
*/
function catrefresh($erstell, $pageposts, $category, $allrefresh, $muddicat, $url) {
	global $publishingpost;
	if ($publishingpost !== true) {
		$seite = getinnewer ( $erstell, $pageposts, $category, 'category', $muddicat );
		if ($seite > 1) {
			if (REALSTATICNONPERMANENT == true)
				$seite = "&paged=$seite";
			else
				$seite = "/page/$seite";
		} else
			$seite = "";
		$m = str_replace ( array (get_option ( 'siteurl' ) . "/", get_option ( 'siteurl' ), loaddaten ( "realstaticlocalurl" ), loaddaten ( "realstaticremoteurl" ), "//" ), array ("", "", "", "", "/" ), get_category_link ( $category ) . $seite );
		
		getnpush ( loaddaten ( "localurl" ) . str_replace ( "%caturl%", $m, $url ), str_replace ( "%caturl%", $m, $url ), $allrefresh );
	} else {
		$seite = getinnewer ( $erstell, $pageposts, $category, 'category', $muddicat );
		$seitemax = getinnewer ( 0, $pageposts, $category, 'category', $muddicat );
		for($seiter = $seite; $seiter <= $seitemax; $seiter ++) {
			if ($seiter > 1) {
				if (REALSTATICNONPERMANENT == true)
					$seitee = "&paged=$seiter";
				else
					$seitee = "/page/$seiter";
			} else
				$seitee = "";
			$m = str_replace ( array (get_option ( 'siteurl' ) . "/", get_option ( 'siteurl' ), loaddaten ( "realstaticlocalurl" ), loaddaten ( "realstaticremoteurl" ), "//" ), array ("", "", "", "", "/" ), get_category_link ( $category ) . $seitee );
			getnpush ( loaddaten ( "localurl" ) . str_replace ( "%caturl%", $m, $url ), str_replace ( "%caturl%", $m, $url ), $allrefresh );
		}
	
	}
}
function testfornewversion()
{
        $fp=@fsockopen("downloads.wordpress.org", 80, $errno, $errstr, 30);
        if($fp){@fputs($fp, "HEAD plugin/really-static.zip HTTP/1.0\r\nHost: downloads.wordpress.org\r\n\r\n");return fgets($fp, 1024);}
}
/*
* Behandelt alle Links mit ? und formt sie um
*/
function nonpermanent($url) {
	if (REALSTATICNONPERMANENT != true) {
		
		if (substr ( $url, - 1 ) != "/" && strpos ( str_replace ( loaddaten ( "remoteurl" ), "", $url ), "." ) === false)
			return $url . "/";
		else
			return $url;
	}
	$url = preg_replace ( "#\&amp;cpage=(\d+)#", "", $url );
	if (strpos ( $url, "?" ) !== false) {
		$url = str_replace ( "&#038;", "/", $url );
		$url = str_replace ( "&", "/", $url );
		if (strpos ( $url, "#" ) !== false)
			$url = str_replace ( "#", "/#", str_replace ( "?", "", $url ) );
		else
			$url = str_replace ( "?", "", $url ) . "/";
	}
	$url = preg_replace ( "#" . loaddaten ( "remoteurl" ) . "wp-trackback.phpp\=(\d+)#", loaddaten ( "localurl" ) . "wp-trackback.php?p=$1", $url );
	if (substr ( $url, - 2 ) == "//")
		$url = substr ( $url, 0, - 1 );
	return $url;
}

/**
 * Fuegt weitere Links ins Pluginmenue
 *
 */
add_filter ( 'plugin_row_meta', 'otherpluginlinks', 10, 2 );
function otherpluginlinks($links, $file) {
	
	$base = plugin_basename ( __FILE__ );
	if ($file == $base) {
		$links [] = '<a href="options-general.php?page=' . $base . '">' . __ ( 'Settings' ) . '</a>';
		$links [] = '<a href="http://blog.phpwelt.net/tag/really-static/">' . __ ( 'Support' ) . '</a>';
		$links [] = '<a href="http://www.sorben.org/really-static/index.html#donate">' . __ ( 'Donate' ) . '</a>';
	}
	return $links;
}


add_action( 'wp_default_scripts', 'wp_default_scripts2' );
function wp_default_scripts2($scripts){
if(loaddaten("realstaticdonationid")=="" and loaddaten("rs_counter")>1000){
	$scripts->add( 'word-count', "/wp-admin/js/word-count$suffix.js", array( 'jquery' ), '20090422' );
		$scripts->add_data( 'word-count', 'group', 1 );
		$scripts->localize( 'word-count', 'wordCountL10n', array(
			'count' => "<strong>You are using Really-static for a long time. Please donate</strong><br>".__('Word count: %d'),
			'l10n_print_after' => 'try{convertEntities(wordCountL10n);}catch(e){};'
		));
		}
return $scripts;
}


?>