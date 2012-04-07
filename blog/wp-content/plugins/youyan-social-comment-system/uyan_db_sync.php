<?php
@include '../wp-content/plugins/youyan-social-comment-system/link.php';
if($_COOKIE['UYEmail'] == '' && $_COOKIE['UYPassword'] == ''){
	@include '../wp-content/plugins/youyan-social-comment-system/uyan_plugin_admin.php';
}else{
?>
<div id="stepTwoWrapper" style=" margin-left:-20px; padding-left:30px; padding-top:50px; ">
<div id="wpEdit" style="display:block;">
    <div class="editFrameTitle">禁用或保留原有WordPress评论</div>
    <div class="editFramContainer" style="margin-top:15px;">
    <label for="UYUseOriginalChoose"  onclick="sel_it('comment_no')">
      <input type="radio" name="UYUseOriginalChoose"  id="comment_no" value="0" checked/>
                  禁用 
      </label> &nbsp;&nbsp;&nbsp;
     <label for="UYUseOriginalChoose" onclick="sel_it('comment_yes')">          
      <input type="radio" name="UYUseOriginalChoose" id="comment_yes" value="1" />
               保留
      </label>            
    </div>
    <script>
    	function sel_it(obj){
			$("#"+obj).attr({"checked":true});
    	}
    	<?php if (get_option('uyan_use_orig') == 0 || get_option('uyan_use_orig') == '') { ?>
  		  $("input[name='UYUseOriginalChoose'][value='0']").attr("checked",true);
    	<?php } else { ?>
  		  $("input[name='UYUseOriginalChoose'][value='1']").attr("checked",true);
    	<?php } ?>
    </script>
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
</div>
<?php }?>

