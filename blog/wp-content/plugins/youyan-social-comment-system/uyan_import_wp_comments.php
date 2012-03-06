<?php
global $wpdb;

function get_children_comments($comment_id){
  global $wpdb;
  $query = "select comment_ID, comment_post_ID, comment_content, comment_author, comment_author_url, comment_author_email, comment_author_IP, comment_date from  " . $wpdb->prefix . "comments where comment_parent = $comment_id and comment_approved=1 and comment_agent!='YouYan Social Comment System'";
  $result = $wpdb->get_results($query, 'ARRAY_A');
  return $result;
}

function get_descendant_comments ($comment_id){
  $ret = array();
  $children = get_children_comments($comment_id);
  foreach ($children as $child)
  {
    $grand_children = get_descendant_comments($child['comment_ID']);
    $ret = array_merge($grand_children, $ret);
  }
  $ret = array_merge($ret, $children);
  return $ret;
}

$page;
$page_url;
$domain = $_SERVER['HTTP_HOST'];

$URL_BASE = get_settings('home');
#$URL_BASE = substr($URL_BASE, 0, strlen($URL_BASE))
$nowpage = isset($_POST['nowpage']) ? $_POST['nowpage'] : 0;
$pagesize = isset($_POST['pagesize']) ? $_POST['pagesize'] : 1;
$pagestart = $nowpage * $pagesize;
$alltotal = isset($_POST['alltotal']) ? $_POST['alltotal'] : 0;
$runtotal = isset($_POST['runtotal']) ? $_POST['runtotal'] : 0;

if($alltotal == 0) {
	$allTotalArr = $wpdb->get_results('select count(*) as count from  ' . $wpdb->prefix . 'comments where comment_parent=0 and comment_approved=1 and comment_agent!="YouYan Social Comment System"', 'ARRAY_A');
	$alltotal = isset($allTotalArr[0]['count']) ? $allTotalArr[0]['count'] : 0;
}

$firstLevelComments = $wpdb->get_results('select comment_ID, comment_content, comment_post_ID, comment_author, comment_author_url, comment_author_email, comment_author_IP, comment_date from  ' . $wpdb->prefix . 'comments where comment_parent=0 and comment_approved=1 and comment_agent!="YouYan Social Comment System" limit ' . $pagestart . ', ' . $pagesize, 'ARRAY_A');

$lowertotal = 0;

foreach($firstLevelComments as $comment){
  $descentdants = get_descendant_comments($comment['comment_ID']);

  $tmplowertotal = count($descentdants);
  $lowertotal += $tmplowertotal;

  $post_data = array(
    'parent_comment' => json_encode($comment),
    'descentdants' => json_encode($descentdants),
    'url_base' => $URL_BASE,
    'domain' => $domain,
    'nowpage' => $nowpage
  );

  //var_dump($post_data);

  $ch = curl_init();
  $url = 'http://uyan.cc/index.php/youyan_wp_content/import_wp_to_uyan_comments';
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $output = curl_exec($ch);
  //var_dump($output);
}

$runtotal = $runtotal + $pagesize + $lowertotal;
if(is_numeric($output)) {
echo '_FINISH_STATUS_' . $output . '_' . $alltotal . '_' . $lowertotal . '_' . $runtotal;
} else {
echo '_FINISH_STATUS_' . $nowpage . '_' . $alltotal . '_' . $lowertotal . '_' . $runtotal;
}
exit;

?>
