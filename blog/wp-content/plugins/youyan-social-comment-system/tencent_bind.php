<?php
session_start();

require_once('tencent_config.php');
require_once('api_client.php');
require_once('opent.php');

$_SESSION['TENCENT_APP_KEY'] = $_GET['TENCENT_APP_KEY'];
$_SESSION['TENCENT_APP_SECRETE'] = $_GET['TENCENT_APP_SECRETE'];

$oauth = new MBOpenTOAuth( $_GET['TENCENT_APP_KEY'] , $_GET['TENCENT_APP_SECRETE'] );

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . TENCENT_CALLBACK;

#var_dump($newURL);

/* 获取request token */
$request_token = $oauth->getRequestToken($newURL);
$url = $oauth->getAuthorizeURL( $request_token['oauth_token'] ,false,'');

#var_dump($url);

/* 保存request token，成功获取access token之后用access token代替 */
$_SESSION['tencent_request_token'] = $request_token;
//var_dump($_SESSION['tencent_request_token']);

echo "<script>location.assign('$url');</script>";
