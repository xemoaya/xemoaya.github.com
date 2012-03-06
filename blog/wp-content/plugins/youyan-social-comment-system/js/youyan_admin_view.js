String.prototype.indexOf = function(s) {
  for (var i = 0; i < this.length - s.length; i++) {
    if (this.charAt(i) === s.charAt(0) &&
        this.substring(i, s.length) === s) {
      return i;
    }
  }
  return -1;
};


function showNavi(navi){
  $(".naviBTN").each(function(){
    $(this).attr("class","naviBTN");
  });

  switch(navi){
    case 'sns':
      $("#sns").attr("class","naviBTN naviBTNCurrent");	
      $("#wpEdit").css({"display":"none"});
      $("#snsEdit").css({"display":"block"});
      $("#stepTwoWrapper").css({"display":"none"});
      break;
    case 'wp':
      $("#wp").attr("class","naviBTN naviBTNCurrent");	
      $("#wpEdit").css({"display":"block"});
      $("#snsEdit").css({"display":"none"});
      $("#stepTwoWrapper").css({"display":"none"});
      break;
    default:
      $("#install").attr("class","naviBTN naviBTNCurrent");
      $("#wpEdit").css({"display":"none"});
      $("#snsEdit").css({"display":"none"});
      $("#stepTwoWrapper").css({"display":"block"});
      break;
  }
}

function importComment(node, nowpage, alltotal, lowertotal, runtotal){
	/*$node = $(node);
	$node.removeAttr('onclick');
	$("#importNoti").remove();
	$node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/importDataPressed.png)','cursor':'default'});$node.html('正在导入');
  $.post("edit-comments.php?page=uyan_import", function(data){$node.attr("onclick",function(){return function(){importComment(this)}});$node.html('已导入');setTimeout("$node.html('导入数据');$node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/importData.png)','cursor':'pointer'});$node.after('<div class=\"importNoti\" id=\"importNoti\">已成功导入</div>');",'1000');});*/

	if(typeof(nowpage) == "undefined") nowpage = 0;
	if(typeof(alltotal) == "undefined") alltotal = 0;
	if(typeof(lowertotal) == "undefined") lowertotal = 0;
	if(typeof(runtotal) == "undefined") runtotal = 0;
	$node = $(node);
	$node.removeAttr('onclick');
	$("#importNoti").remove();
	$node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/importDataPressed.png)','cursor':'default'});
	$node.html('正在导入');

	$.ajax({
		type : 'POST',
		url : 'edit-comments.php?page=uyan_import',
		// dataType : 'json',
		data : 'nowpage='+nowpage+'&alltotal='+alltotal+'&lowertotal='+lowertotal+'&runtotal='+runtotal,
		success : function(msg) {
			var res = msg.split('_FINISH_STATUS_');
			var resArr = res[1].split('_');
			nowpage = parseInt(resArr[0]);
			alltotal = parseInt(resArr[1]);
			lowertotal = parseInt(resArr[2]);
			runtotal = parseInt(resArr[3]);
			if(nowpage < alltotal) {
				nowpage ++;
				$('#uyan_runtotal_id').html('<img src="../wp-content/plugins/youyan-social-comment-system/images/loading.gif" />&nbsp;导入成功'+runtotal+'条评论，还有'+(alltotal-nowpage)+'条记录没有分析');
				importComment(this, nowpage, alltotal, lowertotal, runtotal);
			} else {
				if(runtotal != 2) {
					$('#uyan_runtotal_id').html('完成导入'+runtotal+'条评论');
				} else {
					$('#uyan_runtotal_id').html('导入完成');
				}
				$('.importBTN').attr('style', '');
				$('.importBTN').html('完成导入');
			}
		}
	});

}

function exportComment(node){
	$node = $(node);
	$node.removeAttr('onclick');
	$("#exportNoti").remove();
	$node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/importDataPressed.png)','cursor':'default'});$node.html('正在导出');
  $.post("edit-comments.php?page=uyan_export", function(data){$node.attr("onclick",function(){return function(){exportComment(this)}}); $node.html('已导出'); setTimeout("$node.html('导出数据'); $node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/exportData.png)','cursor':'pointer'}); $node.after('<div class=\"importNoti\" id=\"exportNoti\">已成功导出</div>');",'1000');});
}


function importData(node){
  $node = $(node);
  $node.css({"background-image":"url(../images/importDataPressed.png)"});
}
function outputData(node){
  $node = $(node);	
}


function bindMasterSinaToDomain(){
  window.open('../wp-content/plugins/youyan-social-comment-system/sina_bind.php?UYUserID='+UYUserID+'&SINA_APP_KEY=' + SINA_APP_KEY + '&SINA_APP_SECRETE=' + SINA_APP_SECRETE ,'新浪微博','location=yes,left=200,top=100,width=600,height=600,resizable=yes');
}

function bindMasterTencentToDomain(){
  window.open('../wp-content/plugins/youyan-social-comment-system/tencent_bind.php?UYUserID='+UYUserID+'&TENCENT_APP_KEY=' + TENCENT_APP_KEY + '&TENCENT_APP_SECRETE=' + TENCENT_APP_SECRETE,'腾讯微博','location=yes,left=200,top=100,width=800,height=800,resizable=yes');
}

function bindMasterSinaCallBack(){
  $.post('edit-comments.php?page=uyan_bind', {update_option: 'bind', SINA_ACCESS_TOKEN: SINA_ACCESS_TOKEN, SINA_ACCESS_SECRET: SINA_ACCESS_SECRETE});
}

function bindMasterTencentCallBack(){
  $.post('edit-comments.php?page=uyan_bind', {update_option: 'bind_tencent', TENCENT_ACCESS_TOKEN: TENCENT_ACCESS_TOKEN, TENCENT_ACCESS_SECRET: TENCENT_ACCESS_SECRETE});
}

function unBindMasterTencentToDomain(){
  $.getJSON("http://uyan.cc/index.php/youyan_admin_edit/unBindMasterToTencentCrossDomain?callback=?", 
      {domain: domain}, function(data){
                                        $("#connectWrapperConnectedTencent").css({"display":"none"});
                                        $("#connectWrapperTencent").css({"display":"block"});
                                        $("#changeToConnected").css({"display":"block"});
                                        $.post('edit-comments.php?page=uyan_bind', {update_option: 'unbind_tencent'});
                                      });	
}


function unBindMasterSinaToDomain(){
  $.getJSON("http://uyan.cc/index.php/youyan_admin_edit/unBindMasterToSinaCrossDomain?callback=?", 
      {domain: domain}, function(data){
                                        $("#connectWrapperConnected").css({"display":"none"});
                                        $("#connectWrapper").css({"display":"block"});
                                        $("#changeToConnected").css({"display":"block"});
                                        $.post('edit-comments.php?page=uyan_bind', {update_option: 'unbind'});
                                      });	
}

function saveSinaAPPKEY(){
  var APP_KEY = $("#appkey").val();
  var APP_SECRETE = $("#secret").val();
  $.getJSON("http://uyan.cc/index.php/youyan_admin_edit/saveAPPCrossDomain?callback=?",
      {
        domain: domain,
    SINA_APP_KEY: APP_KEY,
    SINA_APP_SECRETE: APP_SECRETE
      },
      function(data){
        if(data == 1){
          $.post("edit-comments.php?page=uyan_bind", 
            {
              update_option: 'key', SINA_APP_KEY: APP_KEY, SINA_APP_SECRETE: APP_SECRETE
            });
          unBindMasterSinaToDomain();          
          SINA_APP_KEY = APP_KEY;
          SINA_APP_SECRETE = APP_SECRETE;
          $("#sinaBindIntro").html('(APPKEY已修改，请重新绑定)');
        }
      });
  $("#submitAPP").val("已保存");
  setTimeout('$("#submitAPP").val("保存APPKEY")',2000);
}

function saveTencentAPPKEY(){
  var APP_KEY = $("#tencent_appkey").val();
  var APP_SECRETE = $("#tencent_secret").val();
  $.getJSON("http://uyan.cc/index.php/youyan_admin_edit/saveTencentAPPCrossDomain?callback=?",
      {
        domain: domain,
    TENCENT_APP_KEY: APP_KEY,
    TENCENT_APP_SECRETE: APP_SECRETE
      },
      function(data)
      {
        if(data == 1){
          $.post("edit-comments.php?page=uyan_bind", 
            {
              update_option: 'key_tencent', TENCENT_APP_KEY: APP_KEY, TENCENT_APP_SECRETE: APP_SECRETE
            });
          TENCENT_APP_KEY = APP_KEY;
          TENCENT_APP_SECRETE = APP_SECRETE;
          unBindMasterTencentToDomain();
          $("#tencentBindIntro").html('(APPKEY已修改，请重新绑定)');
        }
      });
  $("#submitAPPTencent").val("已保存");
  setTimeout('$("#submitAPPTencent").val("保存APPKEY")',2000);
}

function saveSettings(){
  $(".showCodeBTNApply").val('已保存');
  setTimeout( '$(".showCodeBTNApply").val("保存设置")',2000);	
  var use_orig = $("input[name='UYUseOriginalChoose']:checked").val();

  $.getJSON("http://uyan.cc/index.php/youyan_admin_edit/saveSettingCrossDomain?callback=?", 
      {
        domain: domain,
    wp_use_orig: use_orig
      }, function(){
        $.post("edit-comments.php?page=uyan_bind",
          {
            update_option: 'use_orig',
        uyan_use_orig: use_orig
          });
      });
}
