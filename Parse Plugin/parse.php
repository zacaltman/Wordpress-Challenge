<?php
/*
Plugin Name: Parse Page
Description: Parse 
Plugin URI: http://mindblaze.net
Version: 1.0
*/

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;

require 'parse-php-sdk-master/autoload.php';


add_action('admin_menu', 'parse_admin_menu' );		// For admin Menu option


function parse_admin_menu() {
	add_menu_page( 'Parse plugin', 'Parse Plugin',"administrator", 'parse','parse_plugin_dashboard' );
}

function parse_plugin_dashboard(){

	ParseClient::initialize( '5gXqQ4SHUCe3QiTxJ6uONB0eqTEFlfmHKa9JGP4P', 'zKyftOEmHALMF2xWnOPJbTtgeawtrZIQexv19kVg', 'qBmQMCs3L6OEHxKtP7DVfpHtJOBLQAJtAFyfMA2d' );
	$query = new ParseQuery('Page');
	
	try {
	  	
	  	$page_obj = $query->get("WKumU2rHp4");
	  
	  } catch (ParseException $ex) {
		
		echo $ex;
	}


	$page_obj->getObjectId();
	$content 	= $page_obj->get("content");
	$url   		= str_replace("/", "", $page_obj->get("url"));
	$title 		= $page_obj->get("title");
	
	$args = array('post_type' => 'page' ,'post_content' => $content ,'post_title' => $title,'post_name' => $url ,'post_status' => 'publish' );
	if(!empty($content) && !empty($url) && !empty($title)){
		$inserted_page_id = wp_insert_post($args,false);
	}
	
	if($inserted_page_id){

		$page_obj->set("WordpressId",(string)$inserted_page_id );

		$page_obj->save();

		echo "\n Page ID created with ID ".$inserted_page_id." \n";
	
	}

}




