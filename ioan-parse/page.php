<?php
require_once('../../../wp-load.php');

$pageData = stripslashes($_REQUEST['pageData']);
$pageData = json_decode( $pageData, true );

global $wpdb;


$args = array(
  'post_title'     => $pageData['title'],
  'post_content'   => $pageData['content'],
  'post_status'    => 'publish',
  'post_type'      => 'page',
  'post_author'    => get_current_user_id(),
  'guid'           => site_url().'/'.$pageData['url']
);  

$page_id = wp_insert_post( $args, $wp_error ); 
echo $page_id;
?>