<?php
/*
Plugin Name: 百度分享按钮
Plugin URI: http://share.baidu.com
Description: <a href="http://share.baidu.com/" target="_blank">百度分享</a>是一个提供网页地址收藏、分享及发送的WEB2.0按钮工具，借助百度分享按钮，网站的浏览者可以方便的分享内容到人人网、开心网、QQ空间、新浪微博等一系列SNS站点。 网站主可以在百度分享网站中获得分享按钮JS代码，嵌入到自己的网站，让网站链接分享到互联网各个角落！通过百度分享按钮，您的网站的浏览者可以便捷得分享您网站上的内容到人人网、开心网、qq空间、新浪微博等SNS站点进行传播，为您的网站带回更多的流量。通过百度分享按钮，您网站上的网页将更容易被百度搜索引擎所发现，从而有机会从百度搜索带回更多的流量。通过百度分享按钮，后续您还可以免费获取详尽的分享统计分析，了解网民将您网站上哪些内容分享到哪些SNS网站，每日的分享次数是多少，帮您更好得的跟踪、分析、激励用户的分享行为，为网站带来更多的流量。（该功能即将开放，敬请期待）赶紧免费获取百度分享按钮，获取更多的流量，您还等什么呢？<a href="options-general.php?page=baidu_share.php">启用插件后，可以点击这里进行配置</a>。
Version: 0.1.0.0
Author: Baidu (China) Co., Ltd.
Author URI: http://share.baidu.com
*/

$b_option_tmp['code']='<!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_b" style="line-height: 12px;"><img src="http://share.baidu.com/static/images/type-button-1.jpg" /></div>
    <script type="text/javascript" id="bdshare_js" data="type=button&amp;uid=0" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
    </script>
<!-- Baidu Button END -->';
$b_option_tmp['position'] = 2;
$b_option_tmp['content'] = 1;
$b_option_str = implode('|', $b_option_tmp);
$b_option = get_option('b_option');
if($b_option == '') {
	update_option('b_option', $b_option_str);
}

add_filter('the_content', 'b_content');
function b_content($content) {
    if(is_page() || is_single()) {
		$tmp = get_option('b_option');
		$arr = explode('|', $tmp);
		$b_option = $arr[0];
		if($arr[2] == 2) {
			$b_option=str_replace('<div id="bdshare"' , '<div id="bdshare" data="{\'text\':\'' . htmlspecialchars_decode(preg_replace('/\\n|\\r|\\t/m',' ',preg_replace('/<[^>].*?>/m' , '' , $content))) . '\'}"' , $b_option);
		}
		/**/
		$b_option=htmlspecialchars_decode($b_option);
		if($arr[1] == 2) {
			$content = $content.'<br />'."<div style='float:left'>".$b_option.'</div><br /><br /><br />';
		}
		else {
			$content = '<br />'."<div style='float:left'>".$b_option.'</div><br /><br /><br />'.$content;
		}
	}
	return $content;
}

add_action('plugins_loaded', 'b_widget');
function b_widget() {
    function b_widget_add($args) {
        if(is_single() || is_page()){
			return;
		}
        extract($args);
		$arr = explode('|', get_option('b_option'));
		$b_option = htmlspecialchars_decode($arr[0]);
        echo $before_widget;
        echo $before_title . '百度分享' . $after_title;
	    echo '<div style="margin:12px">' . $b_option . '</div>';
        echo $after_widget;
    }
    register_sidebar_widget( '百度分享' , 'b_widget_add');
}

add_action('admin_menu', 'b_menu');
function b_menu() {
    add_options_page( '百度分享' , '百度分享' , 8 , basename(__FILE__) , 'b_option_add');
}

function b_option_add() {
	$b_upd = false;
    if($_POST['b_code'] != '') {
		if($_POST['b_pos'] != '') {
			if($_POST['b_con'] != '') {
				$b_option_tmp['code'] = stripslashes_deep($_POST['b_code']);
				$b_option_tmp['position'] = $_POST['b_pos'];
				$b_option_tmp['content'] = $_POST['b_con'];
				$b_option_str = implode('|', $b_option_tmp);
				update_option('b_option', $b_option_str);
				$b_upd = true;
			}
		}
    }
	$tmp = get_option('b_option');
	$arr = explode('|', $tmp);
    echo '<div class="wrap">';
    echo '<form name="b_form" method="post" action="">';
    echo '<p style="font-weight:bold;">请在此处输入您从百度分享网站上获得的分享按钮Javascript代码。<a href="http://share.baidu.com" target="_blank"><u style="color:blue">请点击此处访问百度分享网站</u></a></p>';
	echo '<p>默认嵌入的代码风格为按钮式标准风格，显示在文章下方，分享内容为文章标题+链接</p>';
    
    echo '<p><textarea style="height:300px;width:750px" name="b_code">' . $arr[0] . '</textarea></p>';
	if($b_upd) {
		echo '<div><p style="color:blue"><strong>百度分享按钮设置已经保存。</strong></p></div>';
    }
	echo '<br />';
	echo '嵌入位置 ：&nbsp;&nbsp;';
	echo '<input type="radio" name="b_pos" value="1" ' . ($arr[1] == 1 ? 'checked="checked"' : '') . ' /> 文章上方&nbsp;&nbsp;';
	echo '<input type="radio" name="b_pos" value="2" ' . ($arr[1] == 2 ? 'checked="checked"' : '') . ' /> 文章下方&nbsp;&nbsp;';
	echo '<br /><br />';
	echo '分享内容 ：&nbsp;&nbsp;';
	echo '<input type="radio" name="b_con" value="1" ' . ($arr[2] == 1 ? 'checked="checked"' : '') . ' /> 文章标题&nbsp;&nbsp;';
	echo '<input type="radio" name="b_con" value="2" ' . ($arr[2] == 2 ? 'checked="checked"' : '') . ' /> 文章内容&nbsp;&nbsp;';
	echo '<p class="submit"><input type="submit" value="保存设置"/>';
	echo '<input type="button" value="返回上级" onclick="window.location.href=\'plugins.php\';" /></p>';
	echo '</form>';
	
	echo '</div>';
}