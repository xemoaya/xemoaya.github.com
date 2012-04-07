<?php
session_start();
require_once 'Weibo.php';
OpenSDK_Tencent_Weibo::init($_GET['TENCENT_APP_KEY'], $_GET['TENCENT_APP_SECRETE']);
define("TENCENT_CALLBACK","tencent_callback.php");

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . TENCENT_CALLBACK;
$_SESSION['TENCENT_APP_KEY'] = $_GET['TENCENT_APP_KEY'];
 $_SESSION['TENCENT_APP_SECRETE'] =  $_GET['TENCENT_APP_SECRETE'];

/* 获取request token */
$request_token = OpenSDK_Tencent_Weibo::getRequestToken($newURL);
$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
echo "<script>location.assign('$url');</script>";
