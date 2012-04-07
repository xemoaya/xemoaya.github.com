<?php
session_start();
include_once('t163oauth.php');
define( "T163_CALLBACK" , 't163_callback.php');
$oauth = new OAuth($_GET['T163_APP_KEY'], $_GET['T163_APP_SECRETE']);
$request_token = $oauth->getRequestToken();

$_SESSION['T163_APP_KEY'] = trim($_GET['T163_APP_KEY']);
$_SESSION['T163_APP_SECRETE'] = trim($_GET['T163_APP_SECRETE']);
$_SESSION['t163_keys'] = $request_token;

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . T163_CALLBACK;
$t163_aurl = $oauth->getAuthorizeURL( $request_token['oauth_token'], $newURL);

header("location: ". $t163_aurl);

?>
