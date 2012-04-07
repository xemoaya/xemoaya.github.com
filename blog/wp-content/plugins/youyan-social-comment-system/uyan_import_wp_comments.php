<?php
global $wpdb;

$page = '';
$page_url = '';
$domain = $_SERVER['HTTP_HOST'];

$URL_BASE = get_settings('home');
$nowpage = isset($_POST['nowpage']) ? $_POST['nowpage'] : 0;
$pagesize = isset($_POST['pagesize']) ? $_POST['pagesize'] : 10;
$pagestart = $nowpage * $pagesize;
$alltotal = isset($_POST['alltotal']) ? $_POST['alltotal'] : 0;
$runtotal = isset($_POST['runtotal']) ? $_POST['runtotal'] : 0;

if($alltotal == 0) {
	$allTotalArr = $wpdb->get_results('select count(*) as count from  ' . $wpdb->prefix . 'comments where comment_approved=1 and comment_agent!="YouYan Social Comment System"', 'ARRAY_A');
	$alltotal = isset($allTotalArr[0]['count']) ? $allTotalArr[0]['count'] : 0;
}

$comments = $wpdb->get_results('select comment_ID, comment_content, comment_post_ID, comment_author, comment_author_url, comment_author_email, comment_author_IP, comment_date, comment_parent from  ' . $wpdb->prefix . 'comments where comment_approved=1 and comment_agent!="YouYan Social Comment System" order by comment_date ASC limit ' . $pagestart . ', ' . $pagesize, 'ARRAY_A');

$post_data = array(
'comments' => json_encode($comments),
'url_base' => $URL_BASE,
'domain' => $domain,
'nowpage' => $nowpage
);

$ch = curl_init();
$url = 'http://uyan.cc/index.php/youyan_wp_content/import_wp_to_uyan_comments_v2';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);

$lowertotal = 0;
$runtotal = $pagestart<$alltotal ? $pagestart : $alltotal;
if(is_numeric($output)) {
echo '_FINISH_STATUS_' . $output . '_' . $alltotal . '_' . $runtotal . '_' . $pagesize;
} else {
echo '_FINISH_STATUS_' . $nowpage . '_' . $alltotal . '_' . $runtotal . '_' . $pagesize;
}
exit;

?>