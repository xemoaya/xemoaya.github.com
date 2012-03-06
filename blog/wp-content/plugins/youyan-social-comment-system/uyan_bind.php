<?php
switch ($_POST['update_option']){
case 'bind':
  update_option('uyan_has_binded_sina', 1);
// update_option('uyan_sina_access_token', $_POST['SINA_ACCESS_TOKEN']);
// update_option('uyan_sina_access_secret', $_POST['SINA_ACCESS_SECRET']);
  unset($_POST['update_option']);
  break;

case 'unbind':
  update_option('uyan_has_binded_sina', 0);
// update_option('uyan_sina_access_token', '');
// update_option('uyan_sina_access_secret', '');
  unset($_POST['update_option']);
  break;

case 'key':
    update_option('SINA_APP_KEY', $_POST['SINA_APP_KEY']);
    update_option('SINA_APP_SECRET', $_POST['SINA_APP_SECRETE']);
  break;

case 'bind_tencent':
  update_option('uyan_has_binded_tencent', 1);
//  update_option('uyan_tencent_access_token', $_POST['TENCENT_ACCESS_TOKEN']);
//  update_option('uyan_tencent_access_secret', $_POST['TENCENT_ACCESS_SECRET']);
  unset($_POST['update_option']);
  break;

case 'unbind_tencent':
  update_option('uyan_has_binded_tencent', 0);
// update_option('uyan_tencent_access_token', '');
// update_option('uyan_tencent_access_secret', '');
  unset($_POST['update_option']);
  break;

case 'key_tencent':
    update_option('TENCENT_APP_KEY', $_POST['TENCENT_APP_KEY']);
    update_option('TENCENT_APP_SECRET', $_POST['TENCENT_APP_SECRETE']);
  unset($_POST['update_option']);
  break;

case 'use_orig':
  update_option('uyan_use_orig', $_POST['uyan_use_orig']);
  unset($_POST['update_option']);
  break;
}
?>


