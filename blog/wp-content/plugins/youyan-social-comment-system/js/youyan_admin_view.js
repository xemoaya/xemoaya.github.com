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
		url : 'admin.php?page=uyan_import',
		data : 'nowpage='+nowpage+'&alltotal='+alltotal+'&runtotal='+runtotal,
		success : function(msg) {
			var res = msg.split('_FINISH_STATUS_');
			var resArr = res[1].split('_');
			nowpage = parseInt(resArr[0]);
			alltotal = parseInt(resArr[1]);
			runtotal = parseInt(resArr[2]);
			pagesize = parseInt(resArr[3]);
			if(nowpage < alltotal/pagesize) {
				nowpage ++;
				$('#uyan_runtotal_id').html('<img src="../wp-content/plugins/youyan-social-comment-system/images/loading.gif" />&nbsp;导入成功'+runtotal+'条评论，还有'+(alltotal-runtotal)+'条记录没有分析');
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
	$node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/importDataPressed.png)','cursor':'default'});
	$node.html('正在导出');
	$.post("admin.php?page=uyan_export", function(data){$node.attr("onclick",function(){return function(){exportComment(this)}}); 	$node.html('已导出'); setTimeout("$node.html('导出数据'); $node.css({'background-image':'url(../wp-content/plugins/youyan-social-comment-system/images/exportData.png)','cursor':'pointer'}); $node.after('<div class=\"importNoti\" id=\"exportNoti\">已成功导出</div>');",'1000');});
}


function importData(node){
  $node = $(node);
  $node.css({"background-image":"url(../images/importDataPressed.png)"});
}
function outputData(node){
  $node = $(node);	
}

function bindMasterSinaToDomain(SINA_APP_KEY,SINA_APP_SECRETE){
	SINA_APP_KEY = $("#appkey").val();
	SINA_APP_SECRETE = $("#secret").val();

	if(SINA_APP_KEY == '' || SINA_APP_SECRETE == ''){
		alert('请将新浪APKEY及APPSECRET填写完全后，再绑定！');
		return false;
	}else{
		window.open('../wp-content/plugins/youyan-social-comment-system/tsina/sina_bind.php?SINA_APP_KEY=' + SINA_APP_KEY + '&SINA_APP_SECRETE=' + SINA_APP_SECRETE ,'新浪微博','location=yes,left=200,top=100,width=600,height=600,resizable=yes');
	}
}

function bindMasterTencentToDomain(TENCENT_APP_KEY,TENCENT_APP_SECRETE){
	TENCENT_APP_KEY = $("#tencent_appkey").val();
	TENCENT_APP_SECRETE = $("#tencent_secret").val();
	if(TENCENT_APP_KEY == '' || TENCENT_APP_SECRETE == ''){
		alert('请将腾讯APKEY及APPSECRET填写完全后，再绑定！');
		return false;
	}else{
		window.open('../wp-content/plugins/youyan-social-comment-system/tqq/tencent_bind.php?TENCENT_APP_KEY=' + TENCENT_APP_KEY + '&TENCENT_APP_SECRETE=' + TENCENT_APP_SECRETE,'腾讯微博','location=yes,left=200,top=100,width=800,height=800,resizable=yes');
	}
}	

function bindMasterT163ToDomain(T163_APP_KEY,T163_APP_SECRETE){
	T163_APP_KEY = $("#t163_appkey").val();
	T163_APP_SECRETE = $("#t163_secret").val();
	
	if(T163_APP_KEY == '' || T163_APP_SECRETE == ''){
		alert('请将网易APKEY及APPSECRET填写完全后，再绑定！');
		return false;
	}else{
		window.open('../wp-content/plugins/youyan-social-comment-system/t163/t163_bind.php?T163_APP_KEY=' + T163_APP_KEY + '&T163_APP_SECRETE=' + T163_APP_SECRETE,'网易微博','location=yes,left=200,top=100,width=800,height=800,resizable=yes');
	}
}	

function bindMasterTSOHUToDomain(TSOHU_APP_KEY,TSOHU_APP_SECRETE){
	TSOHU_APP_KEY = $("#tsohu_appkey").val();
	TSOHU_APP_SECRETE = $("#tsohu_secret").val();
	
	if(TSOHU_APP_KEY == '' || TSOHU_APP_SECRETE == ''){
		alert('请将搜狐APKEY及APPSECRET填写完全后，再绑定！');
		return false;
	}else{
		window.open('../wp-content/plugins/youyan-social-comment-system/tsohu/tsohu_bind.php?TSOHU_APP_KEY=' + TSOHU_APP_KEY + '&TSOHU_APP_SECRETE=' + TSOHU_APP_SECRETE,'搜狐微博','location=yes,left=200,top=100,width=800,height=800,resizable=yes');
	}
}	


function bindMasterSinaCallBack(SINA_ACCESS_TOKEN,SINA_ACCESS_SECRETE){
  $.post('admin.php?page=uyan_bind', {update_option: 'bind', SINA_ACCESS_TOKEN: SINA_ACCESS_TOKEN, SINA_ACCESS_SECRET: SINA_ACCESS_SECRETE});
}

function bindMasterTencentCallBack(TENCENT_ACCESS_TOKEN,TENCENT_OAUTH_TOKEN_SECRET){
  $.post('admin.php?page=uyan_bind', {update_option: 'bind_tencent', TENCENT_ACCESS_TOKEN: TENCENT_ACCESS_TOKEN,TENCENT_OAUTH_TOKEN_SECRET:TENCENT_OAUTH_TOKEN_SECRET});
}

function bindMasterT163CallBack(T163_ACCESS_TOKEN,T163_OAUTH_TOKEN_SECRET){
  $.post('admin.php?page=uyan_bind', {update_option: 'bind_t163', T163_ACCESS_TOKEN: T163_ACCESS_TOKEN,T163_OAUTH_TOKEN_SECRET:T163_OAUTH_TOKEN_SECRET});
}

function bindMasterTSOHUCallBack(TSOHU_ACCESS_TOKEN,TSOHU_OAUTH_TOKEN_SECRET){
  $.post('admin.php?page=uyan_bind', {update_option: 'bind_tsohu', TSOHU_ACCESS_TOKEN: TSOHU_ACCESS_TOKEN,TSOHU_OAUTH_TOKEN_SECRET:TSOHU_OAUTH_TOKEN_SECRET});
}

function unBindMasterTencentToDomain(){
	$("#connectWrapperConnectedTencent").css({"display":"none"});
	$("#connectWrapperTencent").css({"display":"block"});
	$("#changeToConnected").css({"display":"block"});
	$.post('admin.php?page=uyan_bind', {update_option: 'unbind_tencent'});
}

function unBindMasterT163ToDomain(){
	$("#connectWrapperConnectedT163").css({"display":"none"});
	$("#connectWrapperT163").css({"display":"block"});
	$("#changeToConnected").css({"display":"block"});
	$.post('admin.php?page=uyan_bind', {update_option: 'unbind_t163'});
}


function unBindMasterSinaToDomain(){
	$("#connectWrapperConnected").css({"display":"none"});
	$("#connectWrapper").css({"display":"block"});
	$("#changeToConnected").css({"display":"block"});
	$.post('admin.php?page=uyan_bind', {update_option: 'unbind'});
}
function unBindMasterTSOHUToDomain(){
	$("#connectWrapperConnectedTSOHU").css({"display":"none"});
	$("#connectWrapperTSOHU").css({"display":"block"});
	$("#changeToConnected").css({"display":"block"});
	$.post('admin.php?page=uyan_bind', {update_option: 'unbind_tsohu'});
}

function saveSinaAPPKEY(APP_KEY,APP_SECRETE){

	if(APP_KEY == '' && APP_SECRETE == ''){
		if($("#appkey").val() != '' && $("#secret").val() != ''){
			$.post("admin.php?page=uyan_bind", {
				update_option: 'key', SINA_APP_KEY: $("#appkey").val(), SINA_APP_SECRETE: $("#secret").val()
			});
			$("#submitAPP").val("已保存");
			setTimeout('$("#submitAPP").val("保存APPKEY")',2000);
		}else{
			alert('请将新浪APKEY及APPSECRET填写完全后，再保存！');
			return false;
		}
	}else{
		if(APP_KEY != $("#appkey").val() || APP_SECRETE != $("#secret").val()){
			$("#sinaBindIntro").html('(APPKEY已修改，请重新绑定)');
			$("#connectWrapper").css({"display":"block"});
			$("#connectWrapperConnected").css({"display":"none"});
			$.post("admin.php?page=uyan_bind", {
				update_option: 'key', SINA_APP_KEY: $("#appkey").val(), SINA_APP_SECRETE: $("#secret").val()
			});
			$("#submitAPP").val("已保存");
			setTimeout('$("#submitAPP").val("保存APPKEY")',2000);
		}else{
			$("#submitAPP").val("已保存");
			setTimeout('$("#submitAPP").val("保存APPKEY")',2000);
		}
	}
}

function saveTencentAPPKEY(APP_KEY,APP_SECRETE){
	
	if(APP_KEY == '' && APP_SECRETE == ''){
		if($("#tencent_appkey").val() != '' && $("#tencent_secret").val() != ''){
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_tencent', TENCENT_APP_KEY: $("#tencent_appkey").val(), TENCENT_APP_SECRETE: $("#tencent_secret").val()
			});
			$("#submitAPPTencent").val("已保存");
			setTimeout('$("#submitAPPTencent").val("保存APPKEY")',2000);
		}else{
			alert('请将腾讯APKEY及APPSECRET填写完全后，再保存！');
			return false;
		}
	}else{
		if(APP_KEY != $("#tencent_appkey").val() || APP_SECRETE != $("#tencent_secret").val()){
			$("#tencentBindIntro").html('(APPKEY已修改，请重新绑定)');
			$("#connectWrapperTencent").css({"display":"block"});
			$("#connectWrapperConnectedTencent").css({"display":"none"});
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_tencent', TENCENT_APP_KEY: $("#tencent_appkey").val(), TENCENT_APP_SECRETE: $("#tencent_secret").val()
			});
			$("#submitAPPTencent").val("已保存");
			setTimeout('$("#submitAPPTencent").val("保存APPKEY")',2000);
		}else{
			$("#submitAPPTencent").val("已保存");
			setTimeout('$("#submitAPPTencent").val("保存APPKEY")',2000);
		}
	}

}

function saveT163APPKEY(APP_KEY,APP_SECRETE){
	
	if(APP_KEY == '' && APP_SECRETE == ''){
		if($("#t163_appkey").val() != '' && $("#t163_secret").val() != ''){
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_t163', T163_APP_KEY: $("#t163_appkey").val(), T163_APP_SECRETE: $("#t163_secret").val()
			});
			$("#submitAPPT163").val("已保存");
			setTimeout('$("#submitAPPT163").val("保存APPKEY")',2000);
		}else{
			alert('请将网易APKEY及APPSECRET填写完全后，再保存！');
			return false;
		}
	}else{
		if(APP_KEY != $("#t163_appkey").val() || APP_SECRETE != $("#t163_secret").val()){
			$("#t163BindIntro").html('(APPKEY已修改，请重新绑定)');
			$("#connectWrapperT163").css({"display":"block"});
			$("#connectWrapperConnectedT163").css({"display":"none"});
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_t163', T163_APP_KEY: $("#t163_appkey").val(), T163_APP_SECRETE: $("#t163_secret").val()
			});
			$("#submitAPPT163").val("已保存");
			setTimeout('$("#submitAPPT163").val("保存APPKEY")',2000);
		}else{
			$("#submitAPPT163").val("已保存");
			setTimeout('$("#submitAPPT163").val("保存APPKEY")',2000);
		}
	}

}

function saveTSOHUAPPKEY(APP_KEY,APP_SECRETE){
	
	if(APP_KEY == '' && APP_SECRETE == ''){
		if($("#tsohu_appkey").val() != '' && $("#tsohu_secret").val() != ''){
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_tsohu', TSOHU_APP_KEY: $("#tsohu_appkey").val(), TSOHU_APP_SECRETE: $("#tsohu_secret").val()
			});
			$("#submitAPPTSOHU").val("已保存");
			setTimeout('$("#submitAPPTSOHU").val("保存APPKEY")',2000);
		}else{
			alert('请将搜狐APKEY及APPSECRET填写完全后，再保存！');
			return false;
		}
	}else{
		if(APP_KEY != $("#tsohu_appkey").val() || APP_SECRETE != $("#tsohu_secret").val()){
			$("#tsohuBindIntro").html('(APPKEY已修改，请重新绑定)');
			$("#connectWrapperTSOHU").css({"display":"block"});
			$("#connectWrapperConnectedTSOHU").css({"display":"none"});
			$.post("admin.php?page=uyan_bind", {
					update_option: 'key_tsohu', TSOHU_APP_KEY: $("#tsohu_appkey").val(), TSOHU_APP_SECRETE: $("#tsohu_secret").val()
			});
			$("#submitAPPTSOHU").val("已保存");
			setTimeout('$("#submitAPPTSOHU").val("保存APPKEY")',2000);
		}else{
			$("#submitAPPTSOHU").val("已保存");
			setTimeout('$("#submitAPPTSOHU").val("保存APPKEY")',2000);
		}
	}

}

function saveSettings(){
	$(".showCodeBTNApply").val('已保存');
	setTimeout( '$(".showCodeBTNApply").val("保存设置")',2000);	
	var use_orig = $("input[name='UYUseOriginalChoose']:checked").val();
	$.post("admin.php?page=uyan_bind",{
		update_option: 'use_orig',
		uyan_use_orig: use_orig
	});
}
