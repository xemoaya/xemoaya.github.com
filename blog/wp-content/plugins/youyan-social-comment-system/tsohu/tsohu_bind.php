<?php
session_start();
require_once('tsohuoauth.php');
define ('OAUTH_CALLBACK','tsohu_callback.php');
/* 创建SohuOAuth对象 */
$oauth = new SohuOAuth($_GET['TSOHU_APP_KEY'], $_GET['TSOHU_APP_SECRETE']);
 
/* 获取request token */
$request_token = $oauth->getRequestToken(OAUTH_CALLBACK);

/* 保存request token，成功获取access token之后用access token代替 */
$_SESSION['tsohu_oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['tsohu_oauth_token_secret'] = $request_token['oauth_token_secret'];
 
$_SESSION['TSOHU_APP_KEY'] = $_GET['TSOHU_APP_KEY'];
$_SESSION['TSOHU_APP_SECRETE'] = $_GET['TSOHU_APP_SECRETE'];

$URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strrpos($URL, '/');
$newURL = substr($URL, 0, $pos+1) . OAUTH_CALLBACK;

switch ($oauth->http_code) {
  case 200:
    /* 获取用户认证地址，并且重定向到SOHU */
    $url = $oauth->getAuthorizeUrl1($token, $newURL);
   header('Location: ' . $url); 
    break;
  default:
    /* Show notification if something went wrong. */
    echo '出错了。。。请重试。';
}
?>
