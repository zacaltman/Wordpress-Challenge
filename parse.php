<script type="text/javascript">
	Parse.initialize("5gXqQ4SHUCe3QiTxJ6uONB0eqTEFlfmHKa9JGP4P", "LLL7J8Zesibtex2QzImMm3i0iTDwJ2hRW98xNqzC");
	
	var pageObj = Parse.Object.extend("Page");
	var query = new Parse.Query(pageObj);
	query.get("R0LatokDR8", {
	  success: function(pageData) {

		$.post('<?php echo site_url();?>/wp-content/plugins/Parse-Plugin/ajax.php', {act:'getPageDetail','pageData':JSON.stringify(pageData)},function(pageid){
			
			var PageNew = Parse.Object.extend("Page");
			var pageNewObj = new PageNew();
			pageNewObj.id = "R0LatokDR8";
			
			//pageNewObj.set("WordpressId", pageid);
			
			pageNewObj.save(null, {
			  success: function(response) {
				alert("A page has been created and the page id has been added to page object");
			  },
			  error: function(pageNewObj, error) {
				alert('error while updating object');
			  }
			});
		}); 
		
	  },
	  error: function(object, error) {
	  	alert("error occured");
	  }
	});
  </script>
  <?php 
  echo plugins_url();
  ?>

