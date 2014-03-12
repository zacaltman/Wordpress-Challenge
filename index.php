<?php

    /**
     * Plugin Name: Parse Plugin
     * Description: Parse Plugin
     * Version: 1.0
     * Author: Ion Bernaz
	 * Author URI: http://freistudium.com
    */


    if ( $_REQUEST['page'] == 'parse')
    {

        wp_enqueue_script( 'jqm-script',      'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js' );
        wp_enqueue_script( 'pjqm-script',     'http://www.parsecdn.com/js/parse-1.2.17.min.js'  );

    }

    add_action( 'admin_menu', 'ParseAPI' );

    function ParseAPI() 
    {
		add_menu_page(  'parse',   'Parse',  'manage_options',  'parse',       'parse' ,'', 22);
    }

    function parse()
    {
        if ( !current_user_can( 'manage_options' ) )  
        {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        require plugin_dir_path( __FILE__ ) . 'parse.php'  ;
        echo '</div>';
    }

?>
