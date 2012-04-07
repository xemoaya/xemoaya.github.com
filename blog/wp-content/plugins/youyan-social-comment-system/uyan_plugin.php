<?PHP 
/*
Plugin Name: 友言
Plugin URI: http://uyan.cc
Description: 友言 - 国内最专业的社会化评论系统，它将替换您网站中默认的wordpress评论系统，一键同步评论留言信息到新浪微博，人人网，腾讯微薄，QQ空间，搜狐微博，网易微博，开心网，实时采集社交网络相关评论留言内容，从而帮助您的网站实现社交网络优化(SMO)，提高流量。
Version: 3.0.2
Author: Yang Ye (yeyangever@gmail.com)
Author URI: http://uyan.cc
 */

date_default_timezone_set('PRC');
session_start();

if(isset($_POST['sourceCode'])){
  update_option('uyan_src', $_POST['sourceCode']);
  update_option('uyan_uid', $_POST['UYUserID']);
  update_option('uyan_uname', $_POST['UYUserName']);

}

$domain = $_SERVER['HTTP_HOST'];
require_once('tsina/weibooauth.php');
require_once('tsina/OAuthSINA.php');
require_once 'tqq/Weibo.php';
require_once 't163/t163oauth.php';
require_once 'tsohu/tsohuoauth.php';

function uyan_wp_head(){
  if (is_page() or is_single()){
    echo "<link rel='shortlink' href='" . get_bloginfo('url') . '/?p='. get_the_ID() . "'/>";
  }
}

add_action('wp_head', 'uyan_wp_head');

add_action('admin_head', 'uyan_menu_admin_head');

function uyan_num_comments(){
  global $domain;
  $url = get_bloginfo('url');
  $url = substr($url, 7);
  $page_url = $url . '/?p=';
  //$page_url .= the_ID();
  $page = $domain . '_' . $page_url;
  
  $post_data = array(
    'page' => $page,
    'id' => get_the_ID()
  );

  $url = "http://uyan.cc/index.php/youyan_wp_content/get_num_comments";
  @$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $ret = curl_exec($ch);
  return $ret;
}

//add_filter('get_comments_number', 'uyan_num_comments');

// 留言导入
function uyan_import() {
  include('uyan_import_wp_comments.php');
}
// 留言导出
function uyan_export() {
  include('uyan_export_wp_comments.php');
}
// 绑定新浪微博，腾讯微博，入库操作。
function uyan_bind(){
  include('uyan_bind.php');
}
// 管理页面 （初始登录页面）
function uyan_admin() {
  include('uyan_plugin_admin.php');
}
// 评论框设置
function uyan_db_sync(){
  include('uyan_db_sync.php');
}
// 绑定(两大微博) 输入信息页面
function uyan_bind_sns(){
  include('uyan_bind_sns.php');
}
// 留言管理页面
function uyan_comment_manage(){
  include('uyan_plugin_admin.php');
}

function uyan_setting(){
  include('uyan_setting.php');
}

// 添加一级菜单及子菜单
function uyan_add_pages() {
add_object_page(
				'友言评论',
				'友言评论',
				'moderate_comments',
				'uyan',
				'uyan_admin',
				plugin_dir_url(__FILE__) . 'images/uyan_plug_log_color.png' 
			);
			/*add_submenu_page(
		         'uyan',      // 一级菜单名称
		         '评论管理', //页面标题
		         '评论管理',  // 选项名
		         'manage_options',
		         'uyan_comment_manage', // 访问的页面
		         'uyan_comment_manage' // 绑定的函数
		    );*/
			add_submenu_page(
		         'uyan',    // 父级菜单名称
		         '绑定SNS', //页面标题
		         '绑定SNS', // 选项名
		         'manage_options', // 权限
		         'uyan_bind_sns',// 访问的页面
		         'uyan_bind_sns' // 绑定的函数
		    );
			add_submenu_page(
		         'uyan',     // 父级菜单名称
		         '数据同步', //页面标题
		         '数据同步', // 选项名
		         'manage_options', // 权限
		         'uyan_db_sync',// 访问的页面
		         'uyan_db_sync' // 绑定的函数
		    );
			// 下面三个子菜单，不会显示，在这里定义，是为了绑定，留言导入，导出  能访问到定义的PHP页面。
		    add_submenu_page(
			    'uyan',    // 父级菜单名称
			    'uyan_import', //页面标题
			    'uyan_import',// 选项名
			    'manage_options', // 权限
			    'uyan_import',// 访问的页面
			    'uyan_import'// 绑定的函数
		 	 );
		  	add_submenu_page(
			    'uyan',    // 父级菜单名称
			    'uyan_export',//页面标题
			    'uyan_export',// 选项名
			    'manage_options',// 权限
			    'uyan_export',// 访问的页面
			    'uyan_export'// 绑定的函数
		 	 );
		  	add_submenu_page(
			    'uyan',    // 父级菜单名称
			    'uyan_bind',//页面标题
			    'uyan_bind',// 选项名
			    'manage_options',// 权限
			    'uyan_bind',// 访问的页面
			    'uyan_bind'// 绑定的函数
			  );
		  	add_submenu_page(
			    'uyan',    // 父级菜单名称
			    'uyan_setting',//页面标题
			    'uyan_setting',// 选项名
			    'manage_options',// 权限
			    'uyan_setting',// 访问的页面
			    'uyan_setting'// 绑定的函数
			  );
}

add_action('admin_menu', 'uyan_add_pages', 10);

// 隐藏上面说的三个选项
function uyan_menu_admin_head() {
?>
  <script type="text/javascript">
  jQuery(function($) {
    // fix menu
    var mc = $('#toplevel_page_uyan');
		mc.find("li:gt(2)").hide();
	});
  </script>
<?php
}

// 原有评论是否保留
function uyan_comment($post_ID){
  if(get_option('uyan_use_orig') == 1)
    echo get_option('uyan_src');
  else
    return dirname(__FILE__) . '/comment.php';
}

add_filter('comments_template', 'uyan_comment');


//provided to post article
if (1==1) { // 是否开启微博同步功能
  add_action('admin_menu', 'uyan_wp_connect_add_sidebox');
  add_action('publish_post', 'uyan_wp_connect_publish', 1);
  add_action('publish_page', 'uyan_wp_connect_publish', 1);
}


//prepared for publish
function uyan_wp_replace($str) {
  $a = array('&#160;', '&#038;', '&#8211;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&amp;', '&lt;', '&gt', '&ldquo;', '&rdquo;', '&nbsp;', 'Posted by Wordmobi');
  $b = array(' ', '&', '-', '\'', '\'', '"', '"', '&', '<', '>', '"', '"', ' ', '');
  $str = str_replace($a, $b, strip_tags($str));
  return trim($str);
}

//get photo
function uyan_wp_multi_media_url($content) {
  preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"].*>/isU', $content, $image);
  $p_sum = count($image[1]);
  if ($p_sum > 0) {
    $url = array("image", $image[1][0]);
  } 
  return $url;
}

// 发布
function uyan_wp_connect_publish($post_ID){
	
	$title = uyan_wp_replace(get_the_title($post_ID));
	$postlink = get_permalink($post_ID);
	$shortlink = get_bloginfo('url') . "/?p=" . $post_ID;
	$thePost = get_post($post_ID);	
	$content = $thePost -> post_content;
	$excerpt = $thePost -> post_excerpt;
	$post_author_ID = $thePost -> post_author;
	$post_date = strtotime($thePost -> post_date);
	$post_modified = strtotime($thePost -> post_modified);
	$post_content = uyan_wp_replace($content);
	// 匹配视频、图片
	if(!$wptm_options['disable_pic'])
		$pic = uyan_wp_multi_media_url($content);
	// 是否有摘要
	if ($excerpt) {
		$post_content = uyan_wp_replace($excerpt);
	}
	
	if($_POST['publish_no_sync_sina'] and $_POST['publish_no_sync_tencent'] and $_POST['publish_no_sync_t163']){
		return;
	}
	
	//print_r("start sync\n");
	$title = trim('#' . $title . '#'. ' - '. $post_content);
	//$title = trim($title); 
	$title = preg_replace("'([\r\n])[\s]+'", " ", $title);
	$page_part = explode('http://',$shortlink);
	
	$page = $_SERVER['HTTP_HOST'].'_'.$page_part[1];
	// 同步到新浪
	if(!$_POST['publish_no_sync_sina']){
		$at_str = trim($_POST['publish_and_at_sina']);
		if($at_str == '')
			$ats = array();
		else
			$ats = preg_split("/[\s,]+/", trim($at_str));
		
		$trace_link = "http://uyan.cc/index.php/trace_back?url=" . urlencode($postlink . "&page=" . $page . "&from_type=SINA&user_id=-1&comment_id=0");
		if(!$_POST['publish_update_no_sync_sina']){
			sychronize_post_to_sina($title, $page, $trace_link, $pic, $ats);
			unset($_POST['publish_no_sync_sina']);
		}
	}
	// 同步到腾讯
	if(!$_POST['publish_no_sync_tencent']){
		$at_str = trim($_POST['publish_and_at_tencent']);
		if($at_str == '')
			$ats = array();
		else
			$ats = preg_split("/[\s,]+/", trim($at_str));
		
		$trace_link = "http://uyan.cc/index.php/trace_back?url=" . urlencode($postlink . "&page=" . $page . "&from_type=TENCENT&user_id=-1&comment_id=0");
		if(!$_POST['publish_update_no_sync_tencent']){
		  synchronize_post_to_tencent($title, $page, $trace_link, $pic, $ats);
		  unset($_POST['publish_no_sync_tencent']);
		}
	}
	// 同步到网易
	if(!$_POST['publish_no_sync_t163']){
		$at_str = trim($_POST['publish_and_at_t163']);
		if($at_str == '')
		  $ats = array();
		else
		  $ats = preg_split("/[\s,]+/", trim($at_str));
	
		$trace_link = "http://uyan.cc/index.php/trace_back?url=" . urlencode($postlink . "&page=" . $page . "&from_type=t163&user_id=-1&comment_id=0");
		if(!$_POST['publish_update_no_sync_t163']){
		  synchronize_post_to_t163($title, $page, $trace_link, $pic, $ats);
		  unset($_POST['publish_no_sync_t163']);
		}
	}
		// 同步到搜狐
	if(!$_POST['publish_no_sync_tsohu']){
		$at_str = trim($_POST['publish_and_at_tsohu']);
		if($at_str == '')
		  $ats = array();
		else
		  $ats = preg_split("/[\s,]+/", trim($at_str));
	
		$trace_link = "http://uyan.cc/index.php/trace_back?url=" . urlencode($postlink . "&page=" . $page . "&from_type=t163&user_id=-1&comment_id=0");
		if(!$_POST['publish_update_no_sync_tsohu']){
		  synchronize_post_to_tsohu($title, $page, $trace_link, $pic, $ats);
		  unset($_POST['publish_no_sync_tsohu']);
		}
	}

}

function correctNumWords($str){
  return (mb_strlen($str, 'utf8') + strlen($str))/2;
}

function getSinaShortURL($longURL){
  $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=507593302&url_long=' . $longURL;
  @$ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $output_json = json_decode($output);
  $short_url =  $output_json[0]->url_short;
  return $short_url;
}

function synchronize_post_to_tencent($title, $page, $trace_link, $pic, &$ats) {
  if($ret == 'yes')
    return;

  $short_url = getSinaShortURL($trace_link);

  $at_str = '';
  if(count($ats) != 0){
    $at_str = ' by ';
    foreach($ats as $at){
      $at_str .= '@' . $at;
    }
  }

  $content = $title . ' ' . $short_url . $at_str;
  if(correctNumWords($content) > 280){
    $content = mb_substr($title, 0, 138- strlen($short_url)/2 - mb_strlen($at_str, 'utf8'), 'utf8') . '... '  . $short_url . $at_str;
  }

  if($pic != null){
  	$api_name = 't/add_pic';
  	$pic_arr = array('pic'=>array('type' => 'image/jpg','name' => 'pic.jpg','data' => file_get_contents($pic[1])));
  }else{
  	$api_name = 't/add';
    $pic_arr = null;
  }
  if(get_option('uyan_has_binded_tencent') == 1){
		OpenSDK_Tencent_Weibo::init(get_option('UYAN_TENCENT_APP_KEY'), get_option('UYAN_TENCENT_APP_SECRET'));
		$_SESSION = get_tencent_app_info();
		$add_result = OpenSDK_Tencent_Weibo::call($api_name,array('content' => $content),'post',$pic_arr);
  }
}


function sychronize_post_to_sina($title, $page, $trace_link, $pic, &$ats) {
  $at_str = '';
  if(count($ats) != 0){
    $at_str = ' by ';
    foreach($ats as $at){
      $at_str .= '@' . $at;
    }
  }

  $short_url = getSinaShortURL($trace_link);
  $content = $title . ' ' . $short_url . $at_str;
  if(correctNumWords($content) > 280){
    $content = mb_substr($title, 0, 138- strlen($short_url)/2 - mb_strlen($at_str, 'utf8'), 'utf8') . '... '  . $short_url . $at_str;
  }
  if(get_option('uyan_has_binded_tencent') == 1){
    $arr = get_sina_app_info();
    $c = new WeiboClient($arr['UYAN_SINA_APP_KEY'], $arr['UYAN_SINA_APP_SECRET'], $arr['UYAN_SINA_ACCESS_TOKEN'], $arr['UYAN_SINA_ACCESS_SECRET']);
	$result = $c->update($content);
	if($pic == null)
	    $ret = $c->update($content);
	  else{
	    $ret =$c->upload($content, $pic[1]);
	 }
  }
  if(isset($result['error'])){
   // echo '新浪微博同步失败，请稍后再试，并与我们联系: admin@uyan.cc, 错误信息: ';
    //echo $result['error'];    
  }
	
  $post_data = array(
    'page' => $page,
    'sinaurl' => $short_url,
    'mid' => $ret['mid']
  );
}

function synchronize_post_to_t163($title, $page, $trace_link, $pic, &$ats) {
  if($ret == 'yes')
    return;

  $short_url = $trace_link;

  $at_str = '';
  if(count($ats) != 0){
    $at_str = ' by ';
    foreach($ats as $at){
      $at_str .= '@' . $at;
    }
  }

  $content = $title . ' ' . $short_url . $at_str;
  if(correctNumWords($content) > 280){
    $content = mb_substr($title, 0, 138- strlen($short_url)/2 - mb_strlen($at_str, 'utf8'), 'utf8') . '... '  . $short_url . $at_str;
  }

	if(get_option('uyan_has_binded_t163') == 1){
		$arr = get_t163_app_info();
		$tblog = new TBlog($arr['UYAN_T163_APP_KEY'],$arr['UYAN_T163_APP_SECRET'],$arr['UYAN_T163_ACCESS_TOKEN'],$arr['UYAN_T163_OAUTH_TOKEN_SECRET']);
		if($pic != null){
			$add_result = $tblog->upload($content, $pic[1]); 
		}else{
			$add_result = $tblog->update($content);
		}
	}
}

function synchronize_post_to_tsohu($title, $page, $trace_link, $pic, &$ats) {
  if($ret == 'yes')
    return;

  $short_url = $trace_link;

  $at_str = '';
  if(count($ats) != 0){
    $at_str = ' by ';
    foreach($ats as $at){
      $at_str .= '@' . $at;
    }
  }

  $content = $title . ' ' . $short_url . $at_str;
  if(correctNumWords($content) > 280){
    $content = mb_substr($title, 0, 138- strlen($short_url)/2 - mb_strlen($at_str, 'utf8'), 'utf8') . '... '  . $short_url . $at_str;
  }

	if(get_option('uyan_has_binded_tsohu') == 1){
		$arr = get_tsohu_app_info();
		@$sohu = weibo_api_sohu::instance();
		@$sohu->init($arr['UYAN_TSOHU_APP_KEY'],$arr['UYAN_TSOHU_APP_SECRET'],$arr['UYAN_TSOHU_ACCESS_TOKEN'],$arr['UYAN_TSOHU_OAUTH_TOKEN_SECRET']);
		if($pic != null){
			$add_result  = $sohu->addPic(array('content' => $content, 'pic' => $pic[1]));
		}else{
			$add_result = $sohu->add(array('content' => $content));
		}
	}
}

function uyan_wp_connect_add_sidebox() {
  if(get_option('uyan_has_binded_sina') == 1 or get_option('uyan_has_binded_tencent') == 1 or get_option('uyan_has_binded_t163') == 1 or get_option('uyan_has_binded_tsohu') == 1 ){
    if (function_exists('add_meta_box')) {
      add_meta_box('uyan_wp-connect-sidebox', '"友言"文章微博同步设置 [只对本页面有效]', 'uyan_wp_connect_sidebox', 'post', 'side', 'high');
      add_meta_box('uyan_wp-connect-sidebox', '"友言"文章微博同步设置 [只对本页面有效]', 'uyan_wp_connect_sidebox', 'page', 'side', 'high');
    } 
  }
}

function uyan_wp_connect_sidebox() {
  global $post;
  if ($post -> post_status != 'publish') {
    if(get_option('uyan_has_binded_sina') == 1){
      echo '<p><label><input type="checkbox" name="publish_no_sync_sina" value="1" />不同步到新浪微博[已与站长账号绑定]</label></p>';
      echo '<p><label>新浪微博发布时@<input type="text" name="publish_and_at_sina" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }
	if(get_option('uyan_has_binded_t163') == 1){
      echo '<p><label><input type="checkbox" name="publish_no_sync_t163" value="1" />不同步到网易微博[已与站长账号绑定]</label></p>';
      echo '<p><label>网易微博发布时@<input type="text" name="publish_and_at_t163" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }
    if(get_option('uyan_has_binded_tencent') == 1){
      echo '<p><label><input type="checkbox" name="publish_no_sync_tencent" value="1" />不同步到腾讯微博[已与站长账号绑定]</label></p>';
      echo '<p><label>腾讯微博发布时@<input type="text" name="publish_and_at_tencent" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }
	if(get_option('uyan_has_binded_tsohu') == 1){
      echo '<p><label><input type="checkbox" name="publish_no_sync_tsohu" value="1" />不同步到搜狐微博[已与站长账号绑定]</label></p>';
      echo '<p><label>搜狐微博发布时@<input type="text" name="publish_and_at_tsohu" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }

  }
  else {
    if(get_option('uyan_has_binded_sina') == 1){
      echo '<p><label><input type="checkbox" name="publish_update_no_sync_sina" value="1" />文章更新不同步到新浪微博[已绑定站长账号]</label></p>';
      echo '<p><label>新浪微博发布时@<input type="text" name="publish_and_at_sina" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';	  
    }
    if(get_option('uyan_has_binded_tencent') == 1){
      echo '<p><label><input type="checkbox" name="publish_update_no_sync_tencent" value="1" />文章更新不同步到腾讯微博[已绑定站长账号]</label></p>';
      echo '<p><label>腾讯微博发布时@<input type="text" name="publish_and_at_tencent" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }
	if(get_option('uyan_has_binded_t163') == 1){
      echo '<p><label><input type="checkbox" name="publish_update_no_sync_t163" value="1" />文章更新不同步到网易微博[已绑定站长账号]</label></p>';
      echo '<p><label>网易微博发布时@<input type="text" name="publish_and_at_t163" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }
	if(get_option('uyan_has_binded_tsohu') == 1){
      echo '<p><label><input type="checkbox" name="publish_update_no_sync_tsohu" value="1" />文章更新不同步到搜狐微博[已绑定站长账号]</label></p>';
      echo '<p><label>搜狐微博发布时@<input type="text" name="publish_and_at_tsohu" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
    }

  }
  echo '<p><label style="font-size:12px;color:#aaa;">(@多位作者时用空格分开)</label></p>';
}


function get_tencent_app_info(){
	$arr['TENCENT_APP_KEY'] = trim(get_option('UYAN_TENCENT_APP_KEY'));
	$arr['TENCENT_APP_SECRET'] = trim(get_option('UYAN_TENCENT_APP_SECRET'));
	$arr['TENCENT_ACCESS_TOKEN'] = trim(get_option('UYAN_TENCENT_ACCESS_TOKEN'));
	$arr['TENCENT_OAUTH_TOKEN_SECRET'] = trim(get_option('UYAN_TENCENT_OAUTH_TOKEN_SECRET'));
	return $arr;
}


function get_sina_app_info(){
  $arr['UYAN_SINA_APP_KEY'] = trim(get_option('UYAN_SINA_APP_KEY'));
  $arr['UYAN_SINA_APP_SECRET'] = trim(get_option('UYAN_SINA_APP_SECRET'));
  $arr['UYAN_SINA_ACCESS_TOKEN'] = trim(get_option('UYAN_SINA_ACCESS_TOKEN'));
  $arr['UYAN_SINA_ACCESS_SECRET'] = trim(get_option('UYAN_SINA_ACCESS_SECRET'));
  return $arr;
}

function get_t163_app_info(){
  $arr['UYAN_T163_APP_KEY'] = trim(get_option('UYAN_T163_APP_KEY'));
  $arr['UYAN_T163_APP_SECRET'] = trim(get_option('UYAN_T163_APP_SECRET'));
  $arr['UYAN_T163_ACCESS_TOKEN'] = trim(get_option('UYAN_T163_ACCESS_TOKEN'));
  $arr['UYAN_T163_OAUTH_TOKEN_SECRET'] = trim(get_option('UYAN_T163_OAUTH_TOKEN_SECRET'));
  return $arr;
}
function get_tsohu_app_info(){
  $arr['UYAN_TSOHU_APP_KEY'] = trim(get_option('UYAN_TSOHU_APP_KEY'));
  $arr['UYAN_TSOHU_APP_SECRET'] = trim(get_option('UYAN_TSOHU_APP_SECRET'));
  $arr['UYAN_TSOHU_ACCESS_TOKEN'] = trim(get_option('UYAN_TSOHU_ACCESS_TOKEN'));
  $arr['UYAN_TSOHU_OAUTH_TOKEN_SECRET'] = trim(get_option('UYAN_TSOHU_OAUTH_TOKEN_SECRET'));
  return $arr;
}

?>
