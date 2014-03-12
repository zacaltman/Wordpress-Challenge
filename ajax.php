<?php
require_once('../../../wp-load.php');

$pageData = stripslashes($_REQUEST['pageData']);
$pageData = json_decode( $pageData, true );

global $wpdb;


$pageArr = array(
  'post_content'   => $pageData['content'],
  'post_name'      => $pageData['url'],
  'post_title'     => $pageData['title'],
  'post_status'    => 'publish',
  'post_type'      => 'page',
  'post_author'    => get_current_user_id(),
  'ping_status'    => 'open',
  'post_date'      => date('Y-m-d H:i:s'),
  'post_date_gmt'  => date('Y-m-d H:i:s')
);  

$page_id = wp_insert_post( $pageArr, $wp_error ); 
echo $page_id;
?>