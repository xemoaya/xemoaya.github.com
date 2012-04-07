<?php
session_start();
require_once('weibooauth.php');

$o = new WeiboOAuth( $_SESSION['SINA_APP_KEY'] , $_SESSION['SINA_APP_SECRETE'] , $_SESSION['sina_request_token']['oauth_token'] , $_SESSION['sina_request_token']['oauth_token_secret']);
$access_token = $o->getAccessToken($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']);

echo '<script>opener.UYHasBindedSina=1; opener.SINA_ACCESS_TOKEN="' . $access_token['oauth_token'] . '"; opener.SINA_ACCESS_SECRETE="' . $access_token['oauth_token_secret'] . '"; window.opener.document.getElementById("changeToConnected").style.display="none";window.opener.document.getElementById("connectWrapper").style.display="none";window.opener.document.getElementById("connectWrapperConnected").style.display="block";  opener.bindMasterSinaCallBack("'.$access_token['oauth_token'].'","'.$access_token['oauth_token_secret'].'"); window.close();</script>';
?>
