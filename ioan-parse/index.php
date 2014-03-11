<?php

    /**
     * Plugin Name: Parse
     * Description: Parse plugin
     * Version: 1.0
     * Author: Ioan Pokorny
     * Author URI: https://www.odesk.com/users/~01e4100b804e968512
    */

    
    function parse()
    {
        wp_enqueue_script( 'jqm-script',      'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js' );
        wp_enqueue_script( 'pjqm-script',     'http://www.parsecdn.com/js/parse-1.2.17.min.js'  );
        
        ?>


<script src="http://www.parsecdn.com/js/parse-1.2.17.min.js"></script>
<script type="text/javascript">
    
  Parse.initialize("5gXqQ4SHUCe3QiTxJ6uONB0eqTEFlfmHKa9JGP4P", "LLL7J8Zesibtex2QzImMm3i0iTDwJ2hRW98xNqzC");
  
  var user='ioanp';
  var user_pass='pulamea';
  var obj='b7px3b6xR2';
  
  Parse.User.logIn(user, user_pass);
  
  
  
  var pageObj = Parse.Object.extend("Page");
  var query = new Parse.Query(pageObj);
  query.get(obj, {
    success: function(pageData) {

    $.post('<?php echo site_url();?>/wp-content/plugins/ioan-parse/page.php', {act:'getPageDetail','pageData':JSON.stringify(pageData)},function(pageid){
      
      var PageNew = Parse.Object.extend("Page");
      var pageNewObj = new PageNew();
      pageNewObj.id = obj;
      
      pageNewObj.set("WordpressId", pageid);
      
      
      pageNewObj.save(null);
    }); 
    
    },
   
    }
  );
  </script>

        <?php 
    }
add_action('admin_head', 'parse');
?>
