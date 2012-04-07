<?php
/*
Plugin Name: 新浪连接
Author:  Denis
Author URI: http://fairyfish.net/
Plugin URI: http://fairyfish.net/2010/06/08/sina-connect/
Description: 使用新浪微博瓣账号登陆你的 WordPress 博客，并且留言使用新浪微博的头像，博主可以同步日志到新浪微博，用户可以同步留言到新浪微博。
Version: 2.3.2
*/
$sina_consumer_key = '3279848611';
$sina_consumer_secret = '3fc9982faa7e824555b11c1b06751f5d';
$sc_loaded = false;

add_action('init', 'sc_init');
function sc_init(){
	if (session_id() == "") {
		session_start();
	}
	if(!is_user_logged_in()) {		
        if(isset($_GET['oauth_token'])){
			sc_confirm();
        } 
    } 
}

add_action("wp_head", "sc_wp_head");
add_action("admin_head", "sc_wp_head");
add_action("login_head", "sc_wp_head");
add_action("admin_head", "sc_wp_head");
function sc_wp_head(){
    if(is_user_logged_in()) {
        if(isset($_GET['oauth_token'])){
			echo '<script type="text/javascript">window.opener.sc_reload("");window.close();</script>';
        }
	}
}

add_action('comment_form', 'sina_connect');
add_action("login_form", "sina_connect");
add_action("register_form", "sina_connect",12);
function sina_connect($id='',$callback_url=''){
	global $sc_loaded;
	if($sc_loaded) {
		return;
	}
	if(is_user_logged_in() && !is_admin()){
		return;
	}
	$sc_url = WP_PLUGIN_URL.'/'.dirname(plugin_basename (__FILE__));
	
?>
	<script type="text/javascript">
    function sc_reload(){
       var url=location.href;
       var temp = url.split("#");
       url = temp[0];
       url += "#sc_button";
       location.href = url;
       location.reload();
    }
    </script>	
	<style type="text/css"> 
	.sc_button img{ border:none;}
    </style>
	<p id="sc_connect" class="sc_button">
	<img onclick='window.open("<?php echo $sc_url; ?>/sina-start.php?callback_url=<?php echo urlencode($callback_url); ?>", "dcWindow","width=800,height=600,left=150,top=100,scrollbar=no,resize=no");return false;' src="<?php echo $sc_url; ?>/sina_button.png" alt="使用新浪微博登陆" style="cursor: pointer; margin-right: 20px;" />
	</p>
<?php
    $sc_loaded = true;
}

add_filter("get_avatar", "sc_get_avatar",10,4);
function sc_get_avatar($avatar, $id_or_email='',$size='32') {
	global $comment;
	if(is_object($comment)) {
		$id_or_email = $comment->user_id;
	}
	if (is_object($id_or_email)){
		$id_or_email = $id_or_email->user_id;
	}
	if($scid = get_usermeta($id_or_email, 'scid')){
		$out = 'http://tp3.sinaimg.cn/'.$scid.'/50/1.jpg';
		$avatar = "<img alt='' src='{$out}' class='avatar avatar-{$size}' height='{$size}' width='{$size}' />";
		return $avatar;
	}else {
		return $avatar;
	}
}

function sc_confirm(){
    global $sina_consumer_key, $sina_consumer_secret;
	
	if(!class_exists('SinaOAuth')){
		include dirname(__FILE__).'/sinaOAuth.php';
	}
	
	$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret, $_GET['oauth_token'],$_SESSION['sina_oauth_token_secret']);
	
	$tok = $to->getAccessToken($_REQUEST['oauth_verifier']);

	$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret, $tok['oauth_token'], $tok['oauth_token_secret']);

	$sinaInfo = $to->OAuthRequest('http://api.t.sina.com.cn/account/verify_credentials.xml', 'GET',array());

	if($sinaInfo == "no auth"){
		echo '<script type="text/javascript">window.close();</script>';
		return;
	}
	
	$sinaInfo = simplexml_load_string($sinaInfo);

	if((string)$sinaInfo->domain){
		$sc_user_name = $sinaInfo->domain;
	} else {
		$sc_user_name = $sinaInfo->id;
	}
		
	sc_login($sinaInfo->id.'|'.$sc_user_name.'|'.$sinaInfo->screen_name.'|'.$sinaInfo->url.'|'.$tok['oauth_token'] .'|'.$tok['oauth_token_secret']); 
}

function sc_login($Userinfo) {
	$userinfo = explode('|',$Userinfo);
	if(count($userinfo) < 6) {
		wp_die("An error occurred while trying to contact Sina Connect.");
	}

	$userdata = array(
		'user_pass' => wp_generate_password(),
		'user_login' => 'weibo_'. $userinfo[1],
		'display_name' => $userinfo[2],
		'user_url' => $userinfo[3],
		'user_email' => $userinfo[1].'@weibo.com'
	);

	if(!function_exists('wp_insert_user')){
		include_once( ABSPATH . WPINC . '/registration.php' );
	} 
  
	//$wpuid = get_user_by_login($userinfo[1]);
	$wpuid =get_user_by_meta('scid', ($userinfo[0]));

	if(!$wpuid){
		if($userinfo[0]){
			$wpuid = wp_insert_user($userdata);
		
			if($wpuid){
				update_user_meta($wpuid, 'scid', $userinfo[0]);
				$sc_array = array (
					"oauth_access_token" => $userinfo[4],
					"oauth_access_token_secret" => $userinfo[5],
				);
				update_user_meta($wpuid, 'scdata', $sc_array);
			}
		}
	} else {
		update_user_meta($wpuid, 'scid', $userinfo[0]);
		$sc_array = array (
			"oauth_access_token" => $userinfo[4],
			"oauth_access_token_secret" => $userinfo[5],
		);
		update_user_meta($wpuid, 'scdata', $sc_array);
	}
  
	if($wpuid) {
		wp_set_auth_cookie($wpuid, true, false);
		wp_set_current_user($wpuid);
	}
}

function sc_sinauser_to_wpuser($scid) {
  return get_user_by_meta('scid', $scid);
}

if(!function_exists('get_user_by_meta')){

	function get_user_by_meta($meta_key, $meta_value) {
	  global $wpdb;
	  $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
	  return $wpdb->get_var($wpdb->prepare($sql, $meta_key, $meta_value));
	}
	
	function get_user_by_login($user_login) {
	  global $wpdb;
	  $sql = "SELECT ID FROM $wpdb->users WHERE user_login = '%s'";
	  return $wpdb->get_var($wpdb->prepare($sql, $user_login));
	}
}

if(!function_exists('connect_login_form_login')){
	add_action("login_form_login", "connect_login_form_login");
	add_action("login_form_register", "connect_login_form_login");
	function connect_login_form_login(){
		if(is_user_logged_in()){
			$redirect_to = admin_url('profile.php');
			wp_safe_redirect($redirect_to);
		}
	}
}

add_action('comment_post', 'sc_comment_post',1000);
function sc_comment_post($id){
	$comment_post_id = $_POST['comment_post_ID'];
	
	if(!$comment_post_id){
		return;
	}
	$current_comment = get_comment($id);
	$current_post = get_post($comment_post_id);
	$scdata = get_user_meta($current_comment->user_id, 'scdata',true);
	if($scdata){
		if($_POST['post_2_sina_t']){
			if(!class_exists('SinaOAuth')){
				include dirname(__FILE__).'/sinaOAuth.php';
			}
			global $sina_consumer_key, $sina_consumer_secret;
			$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret,$scdata['oauth_access_token'], $scdata['oauth_access_token_secret']);
			$status = urlencode($current_comment->comment_content. ' '.get_permalink($comment_post_id)."#comment-".$id);			
			$resp = $to->OAuthRequest('http://api.t.sina.com.cn/statuses/update.xml','POST',array('status'=>$status));		
		}
	}
}

add_action('admin_menu', 'sc_options_add_page');

function sc_options_add_page() {
	add_options_page('同步到新浪微博', '同步到新浪微博', 'manage_options', 'sc_options', 'sc_options_do_page');
}

function sc_options_do_page() {
	if($_GET['delete']) {
		delete_option('sina_access_token');
	}elseif(isset($_GET['oauth_token'])){
		global $sina_consumer_key, $sina_consumer_secret;
	
		if(!class_exists('SinaOAuth')){
			include dirname(__FILE__).'/sinaOAuth.php';
		}
		
		$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret, $_GET['oauth_token'],$_SESSION['sina_oauth_token_secret']);
		
		$tok = $to->getAccessToken($_REQUEST['oauth_verifier']);
		update_option('sina_access_token',$tok);
	}
	?>
	<div class="wrap">
		<h2>同步到新浪微博</h2>
		<form method="post" action="options.php">
            <?php
			if($_GET['delete']){
				 echo '<p>你已经删除了原来绑定的新浪微博帐号了。<a href="'.menu_page_url('sc_options',false).'">重新绑定或者绑定其他帐号？</a></p>';
			} else {
				if($tok = get_option('sina_access_token')){
					
					if(!class_exists('SinaOAuth')){
						include dirname(__FILE__).'/sinaOAuth.php';
					}
					
					global $sina_consumer_key, $sina_consumer_secret;
					
					$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret, $tok['oauth_token'], $tok['oauth_token_secret']);
					
					$sinaInfo = $to->OAuthRequest('http://api.t.sina.com.cn/account/verify_credentials.xml', 'GET',array());
					$sinaInfo = simplexml_load_string($sinaInfo);

					if((string)$sinaInfo->domain){
						$sc_user_name = $sinaInfo->domain;
					} else {
						$sc_user_name = $sinaInfo->id;
					}
					echo '<p>你已经绑定了新浪微博帐号 <a href="http://weibo.com/'.$sc_user_name.'">'.$sinaInfo->screen_name.'</a> 了。<a href="'.menu_page_url('sc_options',false).'&delete=1">删除绑定或者绑定其他帐号？</a></p>';
				}else{
					echo '<p>点击下面的图标，将你的新浪微博客帐号和你的博客绑定，当你的博客更新的时候，会同时更新到新浪微博。</p>';
					sina_connect('',menu_page_url('sc_options',false));
				}
			}
			?>
	</div>
	<?php
}

function update_sina_t($status=null){
	$tok = get_option('sina_access_token');
	if(!class_exists('SinaOAuth')){
		include dirname(__FILE__).'/sinaOAuth.php';
	}
	global $sina_consumer_key, $sina_consumer_secret;
	$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret,$tok['oauth_token'], $tok['oauth_token_secret']);
	$status = urlencode($status);
	$resp = $to->OAuthRequest('http://api.t.sina.com.cn/statuses/update.xml','POST',array('status'=>$status));
}

function upload_sina_t($status,$pic){
	if(!$pic) return;
	$tok = get_option('sina_access_token');
	if(!class_exists('SinaOAuth')){
		include dirname(__FILE__).'/sinaOAuth.php';
	}
	global $sina_consumer_key, $sina_consumer_secret;
	$to = new SinaOAuth($sina_consumer_key, $sina_consumer_secret,$tok['oauth_token'], $tok['oauth_token_secret']);

	$status = urlencode($status);
	
	$resp = $to->post('http://api.t.sina.com.cn/statuses/upload.json',array('status'=>$status,'pic'=>'@'.$pic),true);
}


add_action('publish_post', 'publish_post_2_sina_t', 0);
function publish_post_2_sina_t($post_ID){
	$tok = get_option('sina_access_token');
	if(!$tok) return;
	$sina_t = get_post_meta($post_ID, 'sina_t', true);
	if($sina_t) return;
	$c_post = get_post($post_ID);
	//$status = $c_post->post_title.' '.get_permalink($post_ID);
	
	$post_title = $c_post->post_title;
	$post_content = get_post_excerpt($c_post);

	$title_len = mb_strlen($post_title,'UTF-8');
	$content_len = mb_strlen($post_content,'UTF-8');
	$rest_len = 120;

	if($title_len + $content_len> $rest_len) {
		$post_content = mb_substr($post_content,0,$rest_len-$title_len).'... ';
	}
	$status = '【'.$post_title.'】 '.$post_content.get_sina_short_url(get_permalink($post_ID));

	$pic = get_post_first_image($c_post->post_content);
	
	if($pic){
		upload_sina_t($status,$pic);
	}else{
		update_sina_t($status);
	}

	update_sina_t($status);
	add_post_meta($post_ID, 'sina_t', 'true', true);
}

if(!function_exists('get_post_first_image')){

	function get_post_first_image($post_content){
		preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post_content, $matches);
		if($matches){		
			return $matches[1][0];
		}else{
			return false;
		}
	}
}
if(!function_exists('get_sina_short_url')){

	function get_sina_short_url($long_url){
		$api_url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=744243473&url_long='.$long_url;
		$request = new WP_Http;
		$result = $request->request( $api_url);
		$result = $result['body'];
		$result = json_decode($result);
		return $result[0]->url_short;
	}
}

if(!function_exists('get_post_excerpt')){
	function get_post_excerpt($post){
		$post_excerpt = strip_tags($post->post_excerpt); 
		if(!$post_excerpt){
			###第一种情况，以<p>开始,</p>结束来取第一段 Windows live writer
			if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){ 
				$post_content = $result['1'];
			} else {
			###第二种情况，以换行符(\n)来取第一段   
				$post_content_r = explode("\n",trim(strip_tags($post->post_content))); 
				$post_content = $post_content_r['0'];
			}
			$post_excerpt = explode("\n",trim(strip_tags($post->post_content))); 
   			$post_excerpt = $post_excerpt['0'];	
		}
		$post_excerpt = trim(strip_tags($post_excerpt));
		$post_excerpt = str_replace('"', '', $post_excerpt);	
		// replace newlines on mac / windows?
		$post_excerpt = str_replace("\r\n", ' ', $post_excerpt);
		// maybe linux uses this alone
		$post_excerpt = str_replace("\n", ' ', $post_excerpt);
		$post_excerpt = mb_substr($post_excerpt,0,120);

		return $post_excerpt;
	}
}

if(!function_exists('wpjam_modify_dashboard_widgets')){
	
	add_action('wp_dashboard_setup', 'wpjam_modify_dashboard_widgets' );
	function wpjam_modify_dashboard_widgets() {
		global $wp_meta_boxes;
		
		wp_add_dashboard_widget('wpjam_dashboard_widget', '我爱水煮鱼', 'wpjam_dashboard_widget_function');
	}
	
	function wpjam_dashboard_widget_function() {?>
		<p><a href="http://wpjam.com/&amp;utm_medium=wp-plugin&amp;utm_campaign=wp-plugin&amp;utm_source=<?php bloginfo('home');?>" title="WordPress JAM" target="_blank"><img src="http://wpjam.com/wp-content/themes/WPJ-Parent/images/logo_index_1.png" alt="WordPress JAM"></a><br />
        <a href="http://wpjam.com/&amp;utm_medium=wp-plugin&amp;utm_campaign=wp-plugin&amp;utm_source=<?php bloginfo('home');?>" title="WordPress JAM" target="_blank"> WordPress JAM</a> 是中国最好的 WordPress 二次开发团队，我们精通 WordPress，可以制作 WordPress 主题，开发 WordPress 插件，WordPress 整站优化。</p>
        <hr />
	<?php 
		echo '<div class="rss-widget">';
		wp_widget_rss_output('http://fairyfish.net/feed/', array( 'show_author' => 0, 'show_date' => 1, 'show_summary' => 0 ));
		echo "</div>";
	}
}
