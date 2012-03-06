<?php
session_start();
require_once('sina_config.php');
require_once('weibooauth.php');

$o = new WeiboOAuth( $_SESSION['SINA_APP_KEY'] , $_SESSION['SINA_APP_SECRETE'] , $_SESSION['sina_request_token']['oauth_token'] , $_SESSION['sina_request_token']['oauth_token_secret']);
$access_token = $o->getAccessToken($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']);

#var_dump($access_token);
#echo $_SESSION['UYUserID'];

$url = "http://uyan.cc/index.php/youyan_admin_edit/bindMasterToSina";

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
#var_dump($output);

curl_close($ch);
#window.close();
echo '<script>opener.UYHasBindedSina=1; opener.SINA_ACCESS_TOKEN="' . $access_token['oauth_token'] . '"; opener.SINA_ACCESS_SECRETE="' . $access_token['oauth_token_secret'] . '"; window.opener.document.getElementById("changeToConnected").style.display="none";window.opener.document.getElementById("connectWrapper").style.display="none";window.opener.document.getElementById("connectWrapperConnected").style.display="block";  opener.bindMasterSinaCallBack(); window.close();   </script>';
?>



