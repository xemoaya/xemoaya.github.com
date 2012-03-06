<?php

global $wpdb;
$SNSTypeToPrefix = array(
  'SINA' => 'http://weibo.com/',
  'RENREN' => 'http://www.renren.com/profile.do?id=',
  'TENCENT' => 'http://t.qq.com/', 
  'QQ' => 'http://qzone.qq.com/',
  'SOHU' => 'http://t.sohu.com/people?uid=',
  'NETEASY' => 'http://t.163.com/',
  'KAIXIN' => 'http://www.kaixin001.com/home/?uid=',
  'DOUBAN' => 'http://www.douban.com/people/'
);
  //echo 'herehre' . $SNSTypeToPrefix['TENCENT'];


function insert_one_comment($SNSTypeToPrefix, $comment, $in_reply_to = 0){
  //global $SNSTypeToPrefix;
  global $wpdb;
  $insert_data = array();

  $page_url = $comment['page_url'];
  $pos = strrpos($page_url, 'p=');
  $post_id = substr($page_url, $pos+2);
  $insert_data['comment_post_ID'] = $post_id;

  $insert_data['comment_date'] = $insert_data['comment_date_gmt'] = $comment['time'];
  $insert_data['comment_content'] = $comment['content'];
  $insert_data['comment_agent'] = 'YouYan Social Comment System';

  $from_type = trim($comment['from_type']);
  /*echo "FROM:  " . $from_type;
  echo $SNSTypeToPrefix['TENCENT'];
  echo $SNSTypeToPrefix[$from_type];*/
  if($from_type == 'wordpress')
    continue;

  if($from_type == 'EMAIL'){
    $insert_data['comment_author'] = $comment['comment_author'];
    $insert_data['comment_author_email'] = $comment['comment_author_email'];
    $insert_data['comment_author_url'] = $comment['comment_author_url'];
    $insert_data['comment_author_IP'] = $comment['IP'];
  }

  else {            // From_TYPE is SNS
    if($from_type == 'QQ'){
      $comment_author_url = $SNSTypeToPrefix['QQ'];
    }
    else{
      $from_type_id = strtolower($from_type) . '_id';
      $comment_author_url = $SNSTypeToPrefix[$from_type] . $comment[$from_type_id];
    }
    $insert_data['comment_author'] = $comment['show_name'];
    $insert_data['comment_author_url'] = $comment_author_url;
  }

  $insert_data['comment_parent'] = $in_reply_to;

  $result = $wpdb->insert($wpdb->prefix . "comments", $insert_data);
  return $wpdb->insert_id;
}

$domain = $_SERVER['HTTP_HOST'];
$URL_BASE = get_settings('home');

$post_data = array(
  'url_base' => $URL_BASE,
  'domain' => $domain
);

$ch = curl_init();
$url = 'http://uyan.cc/index.php/youyan_wp_content/export_wp_comments';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);


$data_arr = json_decode($output, true);
//var_dump($output);
//var_dump($data_arr);

foreach($data_arr as $comment_group){
  $parent_comment_id =  insert_one_comment($SNSTypeToPrefix, $comment_group[0]);
  //echo 'id = ' . $parent_comment_id;
  for($i = 1; $i < count($comment_group); $i++){
    insert_one_comment($SNSTypeToPrefix, $comment_group[$i], $parent_comment_id);
  }
}

//var_dump($output);



/*function get_children_comments($comment_id){
  global $wpdb;
  $query = "select comment_ID, comment_post_ID, comment_content, comment_author, comment_author_url, comment_author_email, comment_date from wp_comments where comment_parent = $comment_id";
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


$firstLevelComments = $wpdb->get_results('select comment_ID, comment_content, comment_post_ID, comment_author, comment_author_url, comment_author_email, comment_date from wp_comments where comment_parent=0', 'ARRAY_A');

foreach($firstLevelComments as $comment){
  $descentdants = get_descendant_comments($comment['comment_ID']);


}*/

?>

