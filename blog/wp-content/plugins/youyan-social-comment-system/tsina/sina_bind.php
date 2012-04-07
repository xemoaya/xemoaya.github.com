<?php
session_start();
require_once('weibooauth.php');
define( "SINA_CALLBACK" , 'sina_callback.php');

$_SESSION['SINA_APP_KEY'] = trim($_GET['SINA_APP_KEY']);
$_SESSION['SINA_APP_SECRETE'] = trim($_GET['SINA_APP_SECRETE']);
$sina_o = new WeiboOAuth( $_GET['SINA_APP_KEY'] , $_GET['SINA_APP_SECRETE'] );
$keys = $sina_o->getRequestToken();

$_SESSION['sina_request_token'] = $keys;

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . SINA_CALLBACK;

$sina_aurl = $sina_o->getAuthorizeURL($keys['oauth_token'] ,false , $newURL);
header("location: ". $sina_aurl);

