//alert('Hallo');

function pagpreview(PostId) {
	var trid;
	trid = '#pagpost-' + PostId;
	var data = {
		action: 'pag_post_preview', id : PostId
	};
	jQuery.post(ajaxurl, data, function(response) {
		//alert('Got this from the server: ' + response);
		trid = '#pagpost-' + PostId;
		//alert(trid);
		jQuery(".pag_preview").remove();
		jQuery(trid).after(response);
	});
}

function pagremove(PostId) {
	var trid; trid = '#pagpost-' + PostId;
	var prefid;	prefid = '#preview-' +PostId;
	var rcount; rcount = jQuery('#rcount').html();
	var data = {
		action:'pag_post_remove', id:PostId
	};
	jQuery.post(ajaxurl, data, function(data) {
		//alert(data);
		if (data.success) {
			rcount = rcount -1;
			trid = '#pagpost-' + PostId;
			prefid = '#preview-' +PostId;
			jQuery(trid).slideUp();
			jQuery(prefid).slideUp();
			jQuery('#rcount').html(rcount);
		}
	});
}

function pagapprove(PostId) {
	var trid; trid = '#pagpost-' + PostId;
	var prefid;	prefid = '#preview-' +PostId;
	var rcount; rcount = jQuery('#rcount').html();
	var data = {
		action:'pag_post_approve', id:PostId
	};
	jQuery.post(ajaxurl, data, function(data) {
		//alert(data);
		if (data.success) {
			rcount = rcount -1;
			trid = '#pagpost-' + PostId;
			prefid = '#preview-' +PostId;
			jQuery(trid).slideUp();
			jQuery(prefid).slideUp();
			jQuery('#rcount').html(rcount);
		}
	});
}
