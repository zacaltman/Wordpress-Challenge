<?php
/*
Plugin Name: Parse.com Page Creator
Description: Allows you to create page usind data from parse.com.
Version: 1.0.0
Author: Andrey Tepaykin
Author URI: https://www.odesk.com/users/~01c390999dce44f71e
*/
if (is_admin()){
		
		//Actions and Filters	
		//Add Actions
		add_action('admin_menu', 'ppc_page');
		if(isset($_GET['page'])&&$_GET['page']=='ppc_page'){
			add_action('admin_print_scripts', 'ppc_scripts');
			add_action('admin_print_styles', 'ppc_styles');
		}
		
		function ppc_page(){
			//add the options page for this plugin
			add_options_page('Parse Page Creator','Parse Page Creator','manage_options','ppc_page','ppc_start');
		}
		
		function ppc_scripts(){
			wp_register_script('ppc-js', WP_PLUGIN_URL.'/parse-page-creator/my-script.js', array('jquery'));
			wp_enqueue_script('ppc-js');
		}
		
		function ppc_styles(){
			wp_register_style('ppc-css',WP_PLUGIN_URL.'/parse-page-creator/my-style.css');
			wp_enqueue_style('ppc-css');
		}
		
		function ppc_page_create(){
			require_once( 'parse/parse.php' );
			
			// Get from custom class
			$parseObject = new parseObject('Page');
			$res = $parseObject->get($_POST['ppc-object-id']);
			//print_r( $result );
			
			//form submitted
			if(isset($_POST['ppc-object-id']) && $_POST['ppc-object-id'] != ''){
				$_p = array(
					'post_title' => $res->title,
					'post_content' => $res->content,
					'post_name' => $res->url,
					'post_status' => 'publish',
					'post_type' => 'page',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'post_category' => array(1) // the default 'Uncatrgorised'
				);
				
				if($res->WordpressId && get_page($res->WordpressId)){ // page already exists
					$_p['ID'] = (int)$res->WordpressId;
					wp_update_post($_p);
				}else{ // create new page
					global $wpdb;
					$_p['menu_order'] = $wpdb->get_var("SELECT MAX(menu_order)+1 AS menu_order FROM {$wpdb->posts} WHERE post_type='page'");
					$wpdb->flush();
					
					$parseObject->WordpressId = (string)wp_insert_post($_p);
					$parseObject->update($_POST['ppc-object-id']);
				}
				
				echo '<script type="text/javascript">window.location=\'options-general.php?page=ppc_page&saved=1\';</script>';
			}
		}
		
		function ppc_page_del(){
			//form submitted
			$pageID = (int)$_GET['ppc-page-del'];
			if(isset($pageID) && $pageID != 0){
				wp_delete_post($pageID, true);
				echo '<script type="text/javascript">window.location=\'options-general.php?page=ppc_page&saved=1\';</script>';
			}
		}
		
		function ppc_start(){
			if($_POST['ppc-action'] == 'add-page') ppc_page_create();
			elseif($_GET['ppc-action'] == 'del-page') ppc_page_del();
			
		?>
		<div class="wrap" id="ppc-div">
			<?php if(isset($_GET['saved']) && $_GET['saved']=='1'){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
			<?php } ?>
			<h2>Parse Page Creator</h2>
			<p>Use the form below to add Parse.com object ID.</p>
			<h3>Site Pages</h3>
			<ul class="ppc-pages">
			<?php
				//print_r(wp_list_pages(array('show_date' => 'modified', 'date_format' => 'j M Y', 'title_li' => '', 'echo' => 0)));
				$ppc_pages = get_pages(array('show_date' => 'modified', 'date_format' => 'j M Y', 'title_li' => '', 'echo' => 0));
				foreach($ppc_pages as $value){
					echo '<li class="page_item page-item-'.$value->ID.'"><a href="'.$value->guid.'">'.$value->post_title.'</a> <a class="delpage" href="?page='.$_GET['page'].'&ppc-action=del-page&ppc-page-del='.$value->ID.'">Delete</a></li>';
				}
			?>
			</ul>
			<h3>Add parse.com object ID</h3>
			<form id="ppc_add_page" name="ppc_add_page" method="post" action="?page=<?php echo $_GET['page']; ?>">
			<input type="hidden" name="ppc-action" value="add-page" />
			<table>
				<tr>
					<td>ID</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><input size="50" type="text" id="ppc-object-id" name="ppc-object-id" /></td>
					<td><input type="submit" class="button-primary" value="Add Page" /></td>
				</tr>
			</table>
			</form>
		</div>
<?php
		}
}
?>
