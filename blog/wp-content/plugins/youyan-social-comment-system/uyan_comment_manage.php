<?php
@include '../wp-content/plugins/youyan-social-comment-system/link.php';
if($_COOKIE['UYEmail'] == '' && $_COOKIE['UYPassword'] == ''){
	@include '../wp-content/plugins/youyan-social-comment-system/uyan_plugin_admin.php';
}else{
?>
<div id="stepTwoWrapper" style="margin-left:-20px; margin-top:-5px;"></div>
<script type="text/javascript">
var UYSrc = "http://uyan.cc/index.php/youyan_admin/index";
var uyemail = '<?=$_COOKIE['UYEmail']?>';
var uypassword = '<?=$_COOKIE['UYPassword']?>';
var domain = document.domain;
var rem = 1;
if(uyemail != '' && uypassword != ''){
	$.getJSON("http://uyan.cc/index.php/youyan_login/userAutoLoginCrossDomain?callback=?",
		{
		  email: uyemail,
		  loginPassword:uypassword,
		  rem:rem,
		  domain: domain
		},
		function(data){
			if(data !='noData'){
				UYUserID = data.uid;
				UYUserName = data.uname;
				message = "?uid=" + UYUserID + '&domain=' + domain + '&uname=' + UYUserName;
				var UYWpAdminSocket = new easyXDM.Socket({
					remote: UYSrc, // + targetURL,
					swf: "../wp-content/plugins/youyan-social-comment-system/easyxdm.swf",
					container: "stepTwoWrapper",
					props: {id: "uyan_wp_admin_ifr", 
					scrolling : "yes"},
					onMessage: function(message, origin){
					},
					onReady: function() {
					  UYWpAdminSocket.postMessage(message);
					  $("#stepTwoWrapper").css('height', 670);
				}
			});
		}
	});
}
</script>
<?php }?>

