<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/global.js"></script>
<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/jquery.boxy.js"></script>
<script language="javascript" src="../wp-content/plugins/youyan-social-comment-system/js/jquery.flot.js"></script>
<link href="../wp-content/plugins/youyan-social-comment-system/css/admin.css" rel="stylesheet" type="text/css" />
<link href="../wp-content/plugins/youyan-social-comment-system/css/homepage.css" rel="stylesheet" type="text/css" />
<link href="../wp-content/plugins/youyan-social-comment-system/css/admin_edit.css" rel="stylesheet" type="text/css" />

<div class="editNavigationContainer">
    <div class="editNavInnerWrapper">
        <a class="naviBTN" onClick="showNavi('wp')" id="wp">wordpress设置</a>
        <a class="naviBTN" onClick="showNavi('sns')" id="sns">绑定SNS</a>
        <a class="naviBTN naviBTNCurrent" onClick="showNavi('install')" id="install">评论框设置</a>
        <div class="clear"></div>
    </div>
</div>


<div id="wpEdit">
    <div class="editFrameTitle">禁用或保留原有WordPress评论</div>
    <div class="editFramContainer">
      <input type="radio" name="UYUseOriginalChoose" id="widthRadio" value="0" checked/>
      <div class="introTextRadio">禁用</div>
      <input type="radio" name="UYUseOriginalChoose" id="widthRadio" value="1" />
      <div class="introTextRadio">保留</div>
    </div>
    <div class="clear"></div>
    <input class="showCodeBTNApply" type="submit" name="Submit" style="position: inherit; left:0px; top: 0;" value="保存设置" onclick="saveSettings()">
    <div class="clear"></div>

    <div class="imoportIntro">从Wordpress评论导入数据到友言</div>
    <div>
    	<div class="importBTNWrapper" style="width:200px;float:left;">
        	<a class='importBTN' onclick="importComment(this)">导入数据</a>
    	</div>
    	<span id="uyan_runtotal_id" style="width:550px;float:left;display:block;height: 30px;line-height: 36px;"></span>
    </div>
    <div class="clear"></div>
    <div class="imoportIntro">从友言导出数据到Wordpress</div>
        <div class="importBTNWrapper">
        <a class='exportBTN' onclick="exportComment(this)">导出数据</a>
        <div class="clear"></div>
    </div>
</div>


<!-- sns part-->
<div id="snsEdit">
    <div class="snsLeftContainer" >
        <div class="sinaBindContainer">
            <div class="bindTitleIntro">绑定APP（默认友言）及新浪微博账号, 发文章微博</div>
            <div class="inputAPPWrapper">
                <div class="inputAPPTitle">APP Key</div>
                <input type="text" name="appkey" id="appkey" class="APPInput" />
                <div class="inputAPPIntroup">(可选)</div>
                <div class="clear"></div>
            </div>
            
            <div class="inputAPPWrapper">
                <div class="inputAPPTitle">Secret</div>
                <input type="text" name="secret" id="secret" class="APPInput" />
                <div class="inputAPPIntroup">(可选)</div>
                <div class="clear"></div>
            </div>

            <div class="submitAPPWrapper">
                <input type="submit" name="submitAPP" id="submitAPP" value="保存APPKEY" onclick="saveSinaAPPKEY();"/>
                <div class="clear"></div>
            </div>

          <div id="connectWrapperConnected">
              <a class="connectBTN unconnectSINA" onclick="unBindMasterSinaToDomain()" title="取消绑定"></a>
              <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
          </div>

          <div class="connectWrapper" id="connectWrapper">
              <a class="connectBTN connectSINA" onclick="bindMasterSinaToDomain()" title="绑定新浪微博"></a>
              <div class="bindIntro" id='sinaBindIntro'>(点击按钮绑定)</div>
              <div class="clear"></div>
          </div>
      </div>


<!-- tencent-->
      <div class="tencentBindContainer">
          <div class="bindTitleIntro">绑定APP（默认友言）及腾讯微博账号, 发文章微博</div>
              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">APP Key</div>
                  <input type="text" name="appkey" id="tencent_appkey" class="APPInput" />
                  <div class="inputAPPIntroup">(可选)</div>
                  <div class="clear"></div>
              </div>

              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">Secret</div>
                  <input type="text" name="secret" id="tencent_secret" class="APPInput" />
                  <div class="inputAPPIntroup">(可选)</div>
                  <div class="clear"></div>
              </div>

              <div class="submitAPPWrapper">
                  <input type="submit" name="submitAPP" id="submitAPPTencent" value="保存APPKEY" onclick="saveTencentAPPKEY();"/>
                  <div class="clear"></div>
              </div>

              <div id="connectWrapperConnectedTencent">
                  <a class="connectBTN unconnectTencent" onclick="unBindMasterTencentToDomain()" title="取消绑定"></a>
                  <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
              </div>

              <div class="connectWrapper" id="connectWrapperTencent">
                  <a class="connectBTN connectTencent" onclick="bindMasterTencentToDomain()" title="绑定腾讯微博"></a>
                  <div class="bindIntro" id='tencentBindIntro'>(点击按钮绑定)</div>
                  <div class="clear"></div>
              </div>
          </div>
          <div class="alertGrayWrapper" id="changeToConnected">绑定后文章中的评论将自动转发您的文章微博。</div>
      </div>

    <div class="snsRightContainer">
        <div class="basicBindIntro">
            <div class="introTitleBind">绑定有哪些好处？</div>
            <div class="introBind">绑定后您将在文章发布页看到如下文章同步选项，在默认情况下您发布的文章将直接转发至微博中。</div>
            <div class="sinaArtSnap"></div>
            <div class="introBind">所有在此文章上评论的用户将用转发并评论的方式分享您的文章。例如：</div>
            <div class="sinaIntroImage"></div>
        </div>
        <div class="basicBindIntro" style="display:none;">
            <div class="introTitleBind">如何获取APP KEY与SECRET?</div>
            <div class="introBind">
                    请登录微博帐号后访问
                    http://open.weibo.com/development
                    点击”创建应用”按钮，选择“其它”填写网站基本信息后
                    即可获得APP KEY与SECRET。
                    *请在审核通过后使用APP KEY与SECRET。
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div id="stepTwoWrapper"></div>
<script type="text/javascript">
var UYSrc = "http://uyan.cc/index.php/youyan_wp_admin_frame";

//var UYSrc = "http://uyan.cc/index.php/youyan_hot_article?rankType="+encodeURIComponent('time')+"&title=" + encodeURIComponent('11') + "&url=" + encodeURIComponent('url') + "&master_id=" + 'id' + "&domain=" + encodeURIComponent('domain') + "&pageId=" + encodeURIComponent('id') + "&pageImg=" + encodeURIComponent('img') + "&pageContent=" + 'none';

//var targetURL = encodeURIComponent("http://uyan.cc/index.php/youyan_admin/?
  var message = "?uid=" + UYUserID + '&domain=' + domain + '&uname=' + UYUserName;
 
	var UYWpAdminSocket = new easyXDM.Socket({
		remote: UYSrc, // + targetURL,
		swf: "../wp-content/plugins/youyan-social-comment-system/easyxdm.swf",
		container: "stepTwoWrapper",
		props: {id: "uyan_wp_admin_ifr", 
        scrolling : "yes"},
		onMessage: function(message, origin){
			/*var currentHeight = parseInt(message);
            currentHeight += 10;
            console.log("client receive message " + message);
            document.getElementById("stepTwoWrapper").style.height = "600px";//currentHeight*2;

            //document.getElementById("stepTwoWrapper").height = currentHeight*2 + "px";

            //$("#stepTwoWrapper").css('height', currentHeight*2);
            //$("#uyan_wp_admin_ifr").css('height', currentHeight*2);
            
            document.getElementById("uyan_wp_admin_ifr").height = currentHeight*2;
            document.getElementById("stepTwoWrapper").height = currentHeight*2;*/
		},
		onReady: function() {
          UYWpAdminSocket.postMessage(message);
          $("#stepTwoWrapper").css('height', 670);
		}
    });
  </script>

<style type="text/css"> 
            html, body {
                overflow: hidden;
                margin: 0px;
                padding: 0px;
                width: 100%;
                height: 100%;
            }
            iframe {
                width: 100%;
                height: 100%;
                border: 0px;
            }
</style> 

<script language="javascript">
$("#footer").css({"display":"none"});

if(OP_USE_ORIG == 0 || OP_USE_ORIG == '')
  $("input[name='UYUseOriginalChoose'][value='0']").attr("checked",true);
else
  $("input[name='UYUseOriginalChoose'][value='1']").attr("checked",true);

if(OP_HAS_BINDED_SINA == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapper").style.display="none";
  document.getElementById("connectWrapperConnected").style.display="block";
}

if(OP_HAS_BINDED_TENCENT == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapperTencent").style.display="none";
  document.getElementById("connectWrapperConnectedTencent").style.display="block";
}


$("#appkey").val(SINA_APP_KEY);
$("#secret").val(SINA_APP_SECRETE);
$("#tencent_appkey").val(TENCENT_APP_KEY);
$("#tencent_secret").val(TENCENT_APP_SECRETE);

</script>
