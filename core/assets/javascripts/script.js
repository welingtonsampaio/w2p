/**
 * 
 */

var W2P_Message;

W2P_Message = (function() {

  W2P_Message.index = 0;

  W2P_Message.idAlert = "#alerts";

  W2P_Message.intervalTime = 3500;

  function W2P_Message(html, type) {
    var Alerts;
    if (type == null) {
      type = "";
    }
    Alerts = jQuery("#alerts");
    console.log("<div class=\"alert " + type + " alert-" + (this.getIndex()) + "\"><button type=\"button\" class=\"close close-" + (this.getIndex()) + "\" data-dismiss=\"alert-" + (this.getIndex()) + "\">×</button><strong>Well done!</strong>" + html + "</div>");
    console.log(Alerts);
    jQuery("#alerts").append("<div class=\"alert " + type + " alert-" + (this.getIndex()) + "\"><button type=\"button\" class=\"close close-" + (this.getIndex()) + "\" data-dismiss=\"alert-" + (this.getIndex()) + "\">×</button><strong>Well done!</strong>" + html + "</div>");
    jQuery(".close-" + (this.getIndex())).click(function() {
      return jQuery("." + this.dataset.dismiss).alert('close');
    });
  }

  W2P_Message.prototype.getIndex = function() {
    if (window.W2P_Message_index != null) {
      return window.W2P_Message_index;
    } else {
      window.W2P_Message_index = 1;
      return window.W2P_Message_index;
    }
  };

  W2P_Message.prototype.updateIndex = function() {
    return window.W2P_Message_index++;
  };

  return W2P_Message;

})();


jQuery(document).ready(function(){
	
	jQuery('.w2p-admin .menu button').click(function(){
		var id = this.dataset.target;
		jQuery('.w2p-admin .content .form').css('display', 'none');
		jQuery('.w2p-admin .content #'+id).css('display','block');
	});
	
	jQuery("div.buttomRadio").css('background-position', function(){
		if (jQuery('input#'+this.dataset.target).val() == 1){
			return 'right';
		}
	}).click(function(){
		if (jQuery('input#'+this.dataset.target).val() == 1){
			jQuery('input#'+this.dataset.target).val('0');
			jQuery(this).css('background-position', 'left');
		}else{
			jQuery('input#'+this.dataset.target).val('1');
			jQuery(this).css('background-position', 'right');
		}
	});
	
	jQuery('.w2p-admin input').addClass('span6');
	
	jQuery(".w2p-admin .content button.button").click(function(){
		var $this = jQuery(this).parent().parent();
		var formInput = $this.serialize();
		jQuery('#loading_admin').css('display','block').css('opacity',1);
		jQuery.ajax({
			type: 'POST',
			url: $this.attr('action'),
			data: formInput,
			context: document.body,
			dataType: 'json',
			success: function(data){
				jQuery('#loading_admin').css('display','none');
				if ( data.status == 'ok' ) {
					m = new W2P_Message( '' + data.message , 'alert-success');
					console.log(m);
				}
				if ( data.status == 'info' )
					show_info( '' + data.message );
				if ( data.status != 'info' && data.status != 'ok' )
					show_warning( '' + data.message );
			},
			error: function (error){
				jQuery('#loading_admin').css('display','none');
				show_error('Ocorreu um erro ao gravar os dados!<br />' +
						'&nbsp;&nbsp;&nbsp;&nbsp;Error : ' + error.status + 
						'<br />&nbsp;&nbsp;&nbsp;&nbsp;Error name : ' + error.statusText + 
						'<br />&nbsp;&nbsp;&nbsp;&nbsp;Content text : ' + error.responseText);
				console.log(error);
			}
		});
	});
});

/**
 * Upload images
 */
jQuery(document).ready(function() {
	 
	/*jQuery('input.upload-img-w2p').click(function() {

		window.uniq_id = jQuery(this).attr('name');
		window.refid = jQuery(this).attr('refid');
		
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery('#' + window.refid ).val(imgurl);
			tb_remove();
		};
		
	 
		tb_show('', 'media-upload.php?post_id='+window.uniq_id+'&amp;type=image&amp;TB_iframe=true');
	 	return false;
	});*/
	jQuery.noConflict();

	var formfield,
		formID,
		btnContent = true,
		tbframe_interval;
		// On Click
	jQuery('.w2p-upload').bind("click", function () {
		formfield = this.dataset.target;
		formID = this.dataset.postid;

		//Change "insert into post" to "Use this Button"
		tbframe_interval = setInterval(function() {
            var contents;
            contents = jQuery('#TB_iframeContent').contents();
            contents.find('.savesend .button').val('Use This File');
            contents.find('.button.urlfile').trigger('click');
            contents.find('input[type=radio][value=full]').trigger('click');
        }, 700);
        
		// Display a custom title for each Thickbox popup.
        var woo_title = 'W2P File Upload';
        
		if ( jQuery('label.'+this.dataset.target).html() ) { woo_title = jQuery('label.'+this.dataset.target).html(); } 
        
		tb_show( woo_title, 'media-upload.php?post_id='+formID+'&TB_iframe=1' );
		return false;
	});
            
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
        
    if (formfield) {
      //clear interval for "Use this Button" so button text resets
      clearInterval(tbframe_interval);

      // itemurl = $(html).attr('href'); // Use the URL to the main image.

      if ( jQuery(html).html(html).find('img').length > 0 ) {
        itemurl = jQuery(html).html(html).find('img').attr('src'); // Use the URL to the size selected.
      } else {
        // It's not an image. Get the URL to the file instead.
        var htmlBits = html.split("'"); // jQuery seems to strip out XHTML when assigning the string to an object. Use alternate method.
        itemurl = htmlBits[1]; // Use the URL to the file.
      } // End IF Statement


      var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;

      var bg = jQuery('div.' + formfield).data('urlOuthers');
      var ar = itemurl.split('.');
      var ext = ar[ar.length-1];

      if(image.test(itemurl))  bg  = itemurl;
      if( existsExtIcon(ext) ){ bg  = jQuery('div.' + formfield).data('iconPath')+ext+".png"; }

      jQuery('#' + formfield).val(itemurl);
      jQuery('div.' + formfield + ' .file').css({
        backgroundImage: 'url('+bg+')'
      });
      jQuery('div.w2p-' + formfield + '').html(generateInfoFor(itemurl));
      tb_remove();
    } else {
      window.original_send_to_editor(html);
    }

    // Clear the formfield value so the other media library popups can work as they are meant to. - 2010-11-11.
    formfield = '';
  };
});

function existsExtIcon($ext) {
    $extensions = ['3g2', '3gp', 'ai', 'air', 'asf', 'avi', 'bib', 'cls', 'csv', 'deb', 'djvu', 'dmg', 'doc', 'docx',
                   'dwf', 'dwg', 'eps', 'epub', 'exe', 'f', 'f77', 'f90', 'flac', 'flv', 'gz', 'indd',
                   'iso', 'log', 'm4a', 'm4v', 'midi', 'mkv', 'mov', 'mp3', 'mp4', 'mpeg', 'mpg', 'msi',
                   'odp', 'ods', 'odt', 'oga', 'ogg', 'ogv', 'pdf', 'pps', 'ppsx', 'ppt', 'pptx', 'psd', 'pub',
                   'py', 'qt', 'ra', 'ram', 'rar', 'rm', 'rpm', 'rtf', 'rv', 'skp', 'sql', 'sty', 'tar', 'tex', 'tgz',
                   'tiff', 'ttf', 'txt', 'vob', 'wav', 'wmv', 'xls', 'xlsx', 'xml', 'xpi', 'zip'];
    return jQuery.inArray( $ext, $extensions ) != -1
}

function generateInfoFor(url) {
  var filename, ext, ar, html;

  if (url == '') return '';

  ar = url.split('/');
  filename = ar[ar.length-1];

  ar = url.split('.');
  ext = ar[ar.length-1];

  html = "<blockquote>" +
           "<p>Filename:</p>" +
           "<small>"+filename+"</small>";

  if ( jQuery.getMimeType(ext) )
  {
    html += "<p>Mimetype:</p>" +
            "<small>"+jQuery.getMimeType(ext)[1]+"</small>";
  }
  html += "</blockquote>";

  return html;

}