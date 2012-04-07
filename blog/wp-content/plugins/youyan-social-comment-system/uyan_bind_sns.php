<?php
@include '../wp-content/plugins/youyan-social-comment-system/link.php';
if($_COOKIE['UYEmail'] == '' && $_COOKIE['UYPassword'] == ''){
	@include '../wp-content/plugins/youyan-social-comment-system/uyan_plugin_admin.php';
}else{
?>
<div id="stepTwoWrapper">
<!-- sns part-->
<div id="snsEdit">
<style>
.media_name{
	width:90%;
	height:30px;
	line-height:30px;
	border:1px solid #f4f4f4;
	margin:0;
	padding:0;
	list-style:none;
	padding-left:25px;
	background:#f4f4f4;
	border-bottom:none;
}
.media_name li.curr{
	float:left;	
	width:90px;
	height:29px;
	background:#fff;
	text-align:center;
	margin-top:2px;
	font-weight:bold;
	cursor:pointer;
}
.media_name li.normal{
	float:left;	
	width:90px;
	margin-top:2px;
	height:30px;
	text-align:center;
	cursor:pointer;
}
</style>
    <ul class="media_name">
        <li class="curr"  id="nav_sina" onclick="show_media('sina')">新浪微博</li>
        <li class="normal"  id="nav_tencent" onclick="show_media('tencent')">腾讯微博</li>
        <li class="normal"  id="nav_t163" onclick="show_media('t163')">网易微博</li>
        <!--<li class="normal"  id="nav_tsohu" onclick="show_media('tsohu')">搜狐微博</li>-->
    </ul>

<script>
	var media_arr = ['sina','tencent','t163','tsohu']
	function show_media(media_name){
		for(k in media_arr){
			if(media_arr[k] == media_name){
				$("#media_"+media_name).css({"display":"block"});
				$("#nav_"+media_name).addClass("curr");
			}else{
				$("#media_"+media_arr[k]).css({"display":"none"});
				$("#nav_"+media_arr[k]).removeClass().addClass("normal");
			}
		}
		$(this).addClass('curr');
	}
</script>
    <div style="clear:both;"></div>
        <div class="sinaBindContainer" id="media_sina">
         	<div style="margin-top:35px;">第一步：填写你的新浪微博应用密钥<br />如何获取APP KEY与SECRET？点击<a href="http://open.weibo.com/development" target="_blank">这里</a>，然后"创建应用"按钮，选择"其它"填写网站基本信息后即可获得APP KEY与SECRET，请在审核通过后使用APP KEY与SECRET。</div><br />
            <div class="inputAPPWrapper">
                <div class="inputAPPTitle">APP Key</div>
                <input type="text" name="appkey" value="<?php echo get_option('UYAN_SINA_APP_KEY')?>" id="appkey" class="APPInput" />
                
                <div class="clear"></div>
            </div>
            
            <div class="inputAPPWrapper">
                <div class="inputAPPTitle">Secret</div>
                <input type="text" name="secret" value="<?php echo get_option('UYAN_SINA_APP_SECRET')?>"id="secret" class="APPInput" />
                
                <div class="clear"></div>
            </div>

            <div class="submitAPPWrapper">
                <input type="submit" name="submitAPP" id="submitAPP" value="保存APPKEY" onclick="saveSinaAPPKEY('<?php echo get_option('UYAN_SINA_APP_KEY')?>','<?php echo get_option('UYAN_SINA_APP_SECRET')?>');"/>
                <div class="clear"></div>
            </div>

            <div style="margin-top:35px;">第二步：绑定或解绑你需要同步到的个人新浪微博账户</div><br />
          <div id="connectWrapperConnected">
              <a class="connectBTN unconnectSINA" onclick="unBindMasterSinaToDomain()" title="取消绑定"></a>
              <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
          </div>

          <div class="connectWrapper" id="connectWrapper">
              <a class="connectBTN connectSINA" onclick="bindMasterSinaToDomain('<?php echo get_option('UYAN_SINA_APP_KEY')?>','<?php echo get_option('UYAN_SINA_APP_SECRET')?>')" title="绑定新浪微博"></a>
              <div class="bindIntro" id='sinaBindIntro'>(点击按钮绑定)</div>
              <div class="clear"></div>
          </div>
          <div style="margin-top:35px;">第三步：绑定新浪微博后，将在文章发布页看到如下同步选项，在默认情况下发布的文章将直接转发至你设置的个人微博中</div><br />
          <img src="<?php echo plugin_dir_url(__FILE__);?>images/introArticle_sina_Image.png" />
      </div>


		<!-- tencent-->
         <div class="tencentBindContainer" id="media_tencent"  style="display:none;">
         	<div style="margin-top:35px;">第一步：填写你的腾讯微博应用密钥<br />如何获取APP KEY与SECRET？点击<a href="http://dev.open.t.qq.com/developer/" target="_blank">这里</a>，然后创建应用</div><br />
              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">APP Key</div>
                  <input type="text" name="appkey" id="tencent_appkey" value="<?php echo get_option('UYAN_TENCENT_APP_KEY')?>" class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">Secret</div>
                  <input type="text" name="secret" value="<?php echo get_option('UYAN_TENCENT_APP_SECRET')?>" id="tencent_secret" class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="submitAPPWrapper">
                  <input type="submit" name="submitAPP" id="submitAPPTencent" value="保存APPKEY" onclick="saveTencentAPPKEY('<?php echo get_option('UYAN_TENCENT_APP_KEY')?>','<?php echo get_option('UYAN_TENCENT_APP_SECRET')?>');"/>
                  <div class="clear"></div>
              </div>

              <div style="margin-top:35px;">第二步：绑定或解绑你需要同步到的个人腾讯微博账户</div><br />
              <div id="connectWrapperConnectedTencent">
                  <a class="connectBTN unconnectTencent" onclick="unBindMasterTencentToDomain()" title="取消绑定"></a>
                  <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
              </div>

              <div class="connectWrapper" id="connectWrapperTencent">
                  <a class="connectBTN connectTencent" onclick="bindMasterTencentToDomain('<?php echo get_option('UYAN_TENCENT_APP_KEY')?>','<?php echo get_option('UYAN_TENCENT_APP_SECRET')?>')" title="绑定腾讯微博"></a>
                  <div class="bindIntro" id='tencentBindIntro'>(点击按钮绑定)</div>
                  <div class="clear"></div>
              </div>
          <div style="margin-top:35px;">第三步：绑定腾讯微博后，将在文章发布页看到如下同步选项，在默认情况下发布的文章将直接转发至你设置的个人微博中</div><br />
          <img src="<?php echo plugin_dir_url(__FILE__);?>images/introArticle_tencent_Image.png" />
       </div>
          
          <!-- t163 -->
       <div class="t163BindContainer" id="media_t163" style="display:none;">
        	<div style="margin-top:35px;">第一步：填写你的网易微博应用密钥<br />如何获取APP KEY与SECRET？点击<a href="http://open.t.163.com/" target="_blank">这里</a>，然后创建应用</div><br />
              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">APP Key</div>
                  <input type="text" name="appkey" id="t163_appkey" value="<?php echo get_option('UYAN_T163_APP_KEY')?>" class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">Secret</div>
                  <input type="text" name="secret" value="<?php echo get_option('UYAN_T163_APP_SECRET')?>" id="t163_secret" class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="submitAPPWrapper">
                  <input type="submit" name="submitAPP" id="submitAPPT163" value="保存APPKEY" onclick="saveT163APPKEY('<?php echo get_option('UYAN_T163_APP_KEY')?>','<?php echo get_option('UYAN_T163_APP_SECRET')?>');"/>
                  <div class="clear"></div>
              </div>

              <div style="margin-top:35px;">第二步：绑定或解绑你需要同步到的个人网易微博账户</div><br />
              <div id="connectWrapperConnectedT163">
                  <a class="connectBTN unconnectT163" onclick="unBindMasterT163ToDomain()" title="取消绑定"></a>
                  <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
              </div>

              <div class="connectWrapper" id="connectWrapperT163">
                  <a class="connectBTN connectT163" onclick="bindMasterT163ToDomain('<?php echo get_option('UYAN_T163_APP_KEY')?>','<?php echo get_option('UYAN_T163_APP_SECRET')?>')" title="绑定网易微博"></a>
                  <div class="bindIntro" id='T163BindIntro'>(点击按钮绑定)</div>
                  <div class="clear"></div>
              </div>
          <div style="margin-top:35px;">第三步：绑定网易微博后，将在文章发布页看到如下同步选项，在默认情况下发布的文章将直接转发至你设置的个人微博中</div><br />
          <img src="<?php echo plugin_dir_url(__FILE__);?>images/introArticle_t163_Image.png" />
          </div>
       
       <!--tsohu-->
    <div class="t163BindContainer" id="media_tsohu" style="display:none;">
        <div style="margin-top:35px;">第一步：填写你的搜狐微博应用密钥<br />如何获取APP KEY与SECRET？点击<a href="http://open.t.sohu.com/" target="_blank">这里</a>，然后创建应用</div><br />
              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">APP Key</div>
                  <input type="text" name="appkey" id="tsohu_appkey" value="<?php echo get_option('UYAN_TSOHU_APP_KEY')?>" class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="inputAPPWrapper">
                  <div class="inputAPPTitle">Secret</div>
                  <input type="text" name="secret" id="tsohu_secret" value="<?php echo get_option('UYAN_TSOHU_APP_SECRET')?>"  class="APPInput" />
                  
                  <div class="clear"></div>
              </div>

              <div class="submitAPPWrapper">
                  <input type="submit" name="submitAPP" id="submitAPPTSOHU" value="保存APPKEY" onclick="saveTSOHUAPPKEY('<?php echo get_option('UYAN_TSOHU_APP_KEY')?>','<?php echo get_option('UYAN_TSOHU_APP_SECRET')?>');"/>
                  <div class="clear"></div>
              </div>

              <div style="margin-top:35px;">第二步：绑定或解绑你需要同步到的个人搜狐微博账户</div><br />
              <div id="connectWrapperConnectedTSOHU">
                  <a class="connectBTN connectTSOHU" onclick="unBindMasterTSOHUToDomain()" title="取消绑定"></a>
                  <span class="binedIntro">（已绑定，点击按钮解除）</span><div class="clear"></div>
              </div>

              <div class="connectWrapper" id="connectWrapperTSOHU">
                  <a class="connectBTN unconnectTSOHU" onclick="bindMasterTSOHUToDomain('<?php echo get_option('UYAN_TSOHU_APP_KEY')?>','<?php echo get_option('UYAN_TSOHU_APP_SECRET')?>')" title="绑定搜狐微博"></a>
                  <div class="bindIntro" id='TSOHUBindIntro'>(点击按钮绑定)</div>
                  <div class="clear"></div>
              </div>
          <div style="margin-top:35px;">第三步：绑定搜狐微博后，将在文章发布页看到如下同步选项，在默认情况下发布的文章将直接转发至你设置的个人微博中</div><br />
          <img src="<?php echo plugin_dir_url(__FILE__);?>images/introArticle_tsohu_Image.png" />
          </div>
          
          <div class="alertGrayWrapper" id="changeToConnected">绑定后文章中的评论将自动转发您的文章微博。</div>
     <input type="hidden" value="" name="UYUserID" id="UYUserID" />
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
if('<?php echo get_option('uyan_has_binded_sina')?>' == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapper").style.display="none";
  document.getElementById("connectWrapperConnected").style.display="block";
}

if('<?php echo get_option('uyan_has_binded_tencent')?>' == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapperTencent").style.display="none";
  document.getElementById("connectWrapperConnectedTencent").style.display="block";
}

if('<?php echo get_option('uyan_has_binded_t163')?>' == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapperT163").style.display="none";
  document.getElementById("connectWrapperConnectedT163").style.display="block";
}

if('<?php echo get_option('uyan_has_binded_tsohu')?>' == 1){
  document.getElementById("changeToConnected").style.display="none";
  document.getElementById("connectWrapperTSOHU").style.display="none";
  document.getElementById("connectWrapperConnectedTSOHU").style.display="block";
}

</script>
<?php }?>
