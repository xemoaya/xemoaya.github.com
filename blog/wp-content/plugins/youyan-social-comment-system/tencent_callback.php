<?php
session_start();
require_once('tencent_config.php');
require_once('api_client.php');
require_once('opent.php');



$tencent_o = new MBOpenTOAuth($_SESSION['TENCENT_APP_KEY'] , $_SESSION['TENCENT_APP_SECRETE'], $_SESSION['tencent_request_token']['oauth_token'], $_SESSION['tencent_request_token']['oauth_token_secret']);

var_dump($_SESSION['tencent_request_token']);

$access_token = $tencent_o->getAccessToken($_REQUEST['oauth_verifier']);


$url = "http://uyan.cc/index.php/youyan_admin_edit/bindMasterToTencent";

$domain = $_SERVER['HTTP_HOST'];

$post_data = array (
  "domain" => $domain,
  "access_token" => $access_token['oauth_token'],
  "access_secret" => $access_token['oauth_token_secret']
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//指定post数据
curl_setopt($ch, CURLOPT_POST, 1);
//添加变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);

#echo $output;
var_dump($output);

curl_close($ch);
#window.close();
echo '<script>opener.UYHasBindedTencent=1; opener.TENCENT_ACCESS_TOKEN="' . $access_token['oauth_token'] . '"; opener.TENCENT_ACCESS_SECRETE="' . $access_token['oauth_token_secret'] . '"; window.opener.document.getElementById("changeToConnected").style.display="none";window.opener.document.getElementById("connectWrapperTencent").style.display="none";window.opener.document.getElementById("connectWrapperConnectedTencent").style.display="block";  opener.bindMasterTencentCallBack(); window.close();   </script>';
