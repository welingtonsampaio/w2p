/**
 * 
 */

jQuery(window).ready(function(){
	arrumaLightbox();
});

function arrumaLightbox()
{
	jQuery("img.size-thumbnail").parent('a').fancybox();
	jQuery("img.alignleft").parent('a').fancybox();
	jQuery("img.alignright").parent('a').fancybox();
}
