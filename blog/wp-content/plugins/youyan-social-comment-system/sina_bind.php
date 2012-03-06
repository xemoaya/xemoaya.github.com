<?php
session_start();
#echo 1;
require_once('sina_config.php');
require_once('weibooauth.php');

$_SESSION['SINA_APP_KEY'] = $_GET['SINA_APP_KEY'];
$_SESSION['SINA_APP_SECRETE'] = $_GET['SINA_APP_SECRETE'];

$sina_o = new WeiboOAuth( $_GET['SINA_APP_KEY'] , $_GET['SINA_APP_SECRETE'] );
$keys = $sina_o->getRequestToken();
$_SESSION['sina_request_token'] = $keys;

$_SESSION['UYUserID'] = $_REQUEST['UYUserID'];

#var_dump($keys);
#var_dump($_REQUEST);

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . SINA_CALLBACK;
#echo $newURL;

$sina_aurl = $sina_o->getAuthorizeURL($keys['oauth_token'] ,false , $newURL);



#echo $sina_aurl;
header("location: ". $sina_aurl);

