<div id="stepTwoWrapper" style="margin-left:-20px; margin-top:-4px;"></div>
<script type="text/javascript">
<?php if($_GET['page'] == 'uyan_comment_manage') {?>
var UYSrc = "http://uyan.cc/manage/comments";
<?php } else { ?>
var UYSrc = "http://uyan.cc/index.php/youyan_wp_admin_frame";
<?php } ?>
  var message = "?uid=" + UYUserID + '&domain=' + domain + '&uname=' + UYUserName;
	var UYWpAdminSocket = new easyXDM.Socket({
		remote: UYSrc, // + targetURL,
		swf: "../wp-content/plugins/youyan-social-comment-system/easyxdm.swf",
		container: "stepTwoWrapper",
		props: {id: "uyan_wp_admin_ifr", 
        scrolling : "yes"},
		onReady: function() {
          UYWpAdminSocket.postMessage(message);
          $("#stepTwoWrapper").css('height', 670);
		}
    });
$("#footer").css({"display":"none"});
</script>
