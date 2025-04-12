//alert('Hallo');

function saveChecker(){
	if ( jQuery("#pagtitle").val().length < 4 ) {
		alert(PagAjax.enter_title);
		return false;
	}
	if ( jQuery("#pagcontent").val().length < 5 ) {
		alert(PagAjax.enter_content);
		return false;
	}
	return true;
}

jQuery(document).ready(function(){
    jQuery("#pagsubmit").click(function(e){
        e.preventDefault();
        if ( saveChecker() ) {
        	pagpost();
        }
    });
});

function pagpost() {
	jQuery.post(PagAjax.ajaxurl, jQuery("#pag").serialize(), function(data) {
        //alert("back");
		if (data.success) {
			jQuery("#pag_form").slideUp(50);
			jQuery("#pag_form").html(data.msg);
			jQuery("#pag_form").slideDown(500);
		}
	});
}
