/**
 * 
 */

jQuery(window).ready(function(){
	jQuery('.show').click(function(){
		var ref = jQuery(this).attr('refid');
		jQuery('.containers').not('#'+ref).hide();
		jQuery('#'+ref).show();
	});
});