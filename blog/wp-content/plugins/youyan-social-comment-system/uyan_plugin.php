<?PHP 
/*
Plugin Name: 友言
Plugin URI: http://uyan.cc
Description: 友言是基于社交媒体的评论框解决方案，它将替换您网站中默认的wordpress评论系统，通过友言发出的评论将可自动同步到新浪微博等社交媒体去，从而帮助您的网站实现社交网络优化(SMO)，提高流量。
Version: 2.3.5
Author: Yang Ye (yeyangever@gmail.com)
Author URI: uyan.cc
 */



date_default_timezone_set('PRC');

if(isset($_POST['sourceCode'])){
  update_option('uyan_src', $_POST['sourceCode']);
  update_option('uyan_uid', $_POST['UYUserID']);
}

$domain = $_SERVER['HTTP_HOST'];

require_once('weibooauth.php');
require_once('OAuthSINA.php');
require_once('sina_config.php');
require_once('tencent_config.php');
require_once('api_client.php');
require_once('opent.php');

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
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $ret = curl_exec($ch);
  return $ret;
}

//add_filter('get_comments_number', 'uyan_num_comments');


function uyan_import() {
  include('uyan_import_wp_comments.php');
}

function uyan_export() {
  include('uyan_export_wp_comments.php');
}

function uyan_bind(){
  include('uyan_bind.php');
}

/*function uyan_setting() {
  include('uyan_basic_setting.php');
}*/

function uyan_admin() {
  include('uyan_plugin_admin.php');
}


function uyan_add_pages() {
  add_submenu_page(
    'edit-comments.php',
    '友言评论系统',
    '友言评论系统',
    'moderate_comments',
    'uyan_admin',
    'uyan_admin'
  );
  add_submenu_page(
    'edit-comments.php',
    'uyan_import',
    'uyan_import',
    'moderate_comments',
    'uyan_import',
    'uyan_import'
  );
  add_submenu_page(
    'edit-comments.php',
    'uyan_export',
    'uyan_export',
    'moderate_comments',
    'uyan_export',
    'uyan_export'
  );
  add_submenu_page(
    'edit-comments.php',
    'uyan_bind',
    'uyan_bind',
    'moderate_comments',
    'uyan_bind',
    'uyan_bind'
  );
  /*add_submenu_page(
    'edit-comments.php',
    'uyan_setting',
    'uyan_setting',
    'moderate_comments',
    'uyan_setting',
    'uyan_setting'
  );*/
}

add_action('admin_menu', 'uyan_add_pages', 10);

function uyan_menu_admin_head() {
?>
  <script type="text/javascript">
  jQuery(function($) {
    // fix menu
    var mc = $('#menu-comments');
    mc.find('a.wp-has-submenu').attr('href', 'edit-comments.php?page=uyan_bind').end().find('.wp-submenu  li:has(a[href="edit-comments.php?page=uyan_bind"])').css("display", "none").prependTo(mc.find('.wp-submenu ul')).hide();

    mc.find('a.wp-has-submenu').attr('href', 'edit-comments.php?page=uyan_import').end().find('.wp-submenu  li:has(a[href="edit-comments.php?page=uyan_import"])').prependTo(mc.find('.wp-submenu ul')).hide();

    mc.find('a.wp-has-submenu').attr('href', 'edit-comments.php?page=uyan_export').end().find('.wp-submenu  li:has(a[href="edit-comments.php?page=uyan_export"])').prependTo(mc.find('.wp-submenu ul')).hide();

    mc.find('a.wp-has-submenu').attr('href', 'edit-comments.php?page=uyan_admin').end().find('.wp-submenu  li:has(a[href="edit-comments.php?page=uyan_admin"])').prependTo(mc.find('.wp-submenu ul'));
  });
  </script>
<?php
}


//end
/*function uyan_comments_open(){
  //return get_option('uyan_use_orig') == '1';
  return 1;
}*/

//add_filter('comments_open', 'uyan_comments_open');

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

function uyan_wp_connect_add_sidebox() {
  if(get_option('uyan_has_binded_sina') == 1 or get_option('uyan_has_binded_tencent') == 1){
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
    if(get_option('uyan_has_binded_tencent') == 1){
      echo '<p><label><input type="checkbox" name="publish_no_sync_tencent" value="1" />不同步到腾讯微博[已与站长账号绑定]</label></p>';
      echo '<p><label>腾讯微博发布时@<input type="text" name="publish_and_at_tencent" style="width:100px;padding-left:5px;margin-left:5px;"/></label></p>';
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
  }
  echo '<p><label style="font-size:12px;color:#aaa;">(@多位作者时用空格分开)</label></p>';
}

//prepared for publish
function uyan_wp_replace($str) {
  $a = array('&#160;', '&#038;', '&#8211;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&amp;', '&lt;', '&gt', '&ldquo;', '&rdquo;', '&nbsp;', 'Posted by Wordmobi');
  $b = array(' ', '&', '-', '‘', '’', '“', '”', '&', '<', '>', '“', '”', ' ', '');
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

  if($_POST['publish_no_sync_sina'] and $_POST['publish_no_sync_tencent']){
    return;
  }

  //print_r("start sync\n");
  $title = trim('#' . $title . '#'. ' - '. $post_content);
  //$title = trim($title); 
  $title = preg_replace("'([\r\n])[\s]+'", " ", $title);
  $page_part = explode('http://',$shortlink);

  $page = $_SERVER['HTTP_HOST'].'_'.$page_part[1];

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
    }else{
    }
  }

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
    else{
    }
  }
}

function correctNumWords($str){
  return (mb_strlen($str, 'utf8') + strlen($str))/2;
}

function getSinaShortURL($longURL){
  $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=507593302&url_long=' . $longURL;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $output_json = json_decode($output);
  $short_url =  $output_json[0]->url_short;
  return $short_url;
}

function synchronize_post_to_tencent($title, $page, $trace_link, $pic, &$ats) {
  $url = "http://uyan.cc/index.php/youyan_wp_content/checkAlreadyPublishedTencent";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $ret = curl_exec($ch);
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

  $tencent_app_info = json_decode(get_tencent_app_info(), true); 

  if($tencent_app_info['TENCENT_APP_KEY'] != '' and $tencent_app_info['TENCENT_ACCESS_TOKEN'] != ''){
    $tencent_c = new MBApiClient( $tencent_app_info['TENCENT_APP_KEY'] , $tencent_app_info['TENCENT_APP_SECRETE'], $tencent_app_info['TENCENT_ACCESS_TOKEN'], $tencent_app_info['TENCENT_ACCESS_SECRETE']);
  }
  else{
    //$tencent_c = new MBApiClient(TENCENT_AKEY, TENCENT_SKEY, get_option('uyan_tencent_access_token'), get_option('uyan_tencent_access_secret'));
    return;
  }

  if($pic != null){
    $pic_arr = array("image/gif",$pic,file_get_contents($pic[1]));
  }else{
    $pic_arr = null;
  }
  $p = array('c' => $content, 'ip'=>'', 'j'=>'', 'w'=>'', 'type'=>1, 'p'=>$pic_arr);
  $ret = $tencent_c->postOne($p);

  $post_data = array(
    'page' => $page,
    'mid' => $ret['data']['id']
  );
  $url = "http://uyan.cc/index.php/youyan_wp_content/post_wordpress_tencent";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_exec($ch);
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

  $sina_app_info = json_decode(get_sina_app_info(), true); 

  if($sina_app_info['SINA_APP_KEY'] != '' and $sina_app_info['SINA_ACCESS_TOKEN'] != ''){
    $c = new WeiboClient( $sina_app_info['SINA_APP_KEY'] , $sina_app_info['SINA_APP_SECRETE'], $sina_app_info['SINA_ACCESS_TOKEN'], $sina_app_info['SINA_ACCESS_SECRETE']);
  }
  else{
    //$c = new WeiboClient( SINA_AKEY , SINA_SKEY , get_option('uyan_sina_access_token'), get_option('uyan_sina_access_secret'));
    return;
  }

  if($pic == null)
    $ret = $c->update($content);
  else{
    $ret =$c->upload($content, $pic[1]);
  }

  if(isset($ret['error'])){
    /*echo '新浪微博同步失败，请稍后再试，并与我们联系: admin@uyan.cc, 错误信息: ';
    var_dump($ret);*/
    die();
  }

  $post_data = array(
    'page' => $page,
    'sinaurl' => $short_url,
    'mid' => $ret['mid']
  );
  $url = "http://uyan.cc/index.php/youyan_wp_content/post_wordpress_sina";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_exec($ch);
}


function get_tencent_app_info(){
  global $domain;
  $post_data = array(
    'domain' => $domain
  );
  $url = "http://uyan.cc/index.php/youyan_wp_content/get_tencent_app_info";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $ret = curl_exec($ch);
  return $ret;
}


function get_sina_app_info(){
  global $domain;
  $post_data = array(
    'domain' => $domain
  );
  $url = "http://uyan.cc/index.php/youyan_wp_content/get_sina_app_info";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  //添加变量
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $ret = curl_exec($ch);
  return $ret;
}

?>
