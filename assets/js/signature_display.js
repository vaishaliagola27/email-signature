jQuery(document).ready(function () {
	var load = false;
	jQuery('#followupcontent').focus(function () {
		var divID = email_signature.id;
		//check if already signature is added
		if (load === false) {
			var data=jQuery('#'+divID).val();
			jQuery("textarea#" + divID + "").html(data+email_signature.content);
			jQuery("#rthd-new-followup-preview").trigger("click");
			load = true;
		}
	});
});