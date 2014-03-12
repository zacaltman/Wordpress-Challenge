jQuery(document).ready(function(){
    jQuery('form#ppc_add_page').on('submit', function(e){
        return jQuery('#ppc-object-id').val().length>0 ? true : ppc_add_page();
    });
});

function ppc_add_page(){
    var chkfrm = '';
    if(jQuery('#ppc-object-id').val()=='') chkfrm += 'Please enter object ID\n';
    
    if(chkfrm!=''){
        alert(chkfrm);
		return false;
    }
}
