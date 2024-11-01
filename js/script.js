if(typeof(jQuery) == 'undefined') {
	getScript('/wp-content/plugins/wparchivestree/js/jquery-3.7.1.min.js', function() {
		benyamin_wparchivestree_initialisation();
	});
} else {
	jQuery(document).ready(function() {
		benyamin_wparchivestree_initialisation();
	});
}

function benyamin_wparchivestree_initialisation() {
	jQuery('.bk_WPArchivesTree .subitemlist-'+jQuery('.bk_WPArchivesTree .first').attr('id')).show(function() {
		jQuery('.bk_WPArchivesTree .loading').hide();
		jQuery('.bk_WPArchivesTree .elements').show();
	});
	jQuery('.bk_WPArchivesTree .first').find('.arrowdown').show('fast');
	jQuery('.bk_WPArchivesTree .first').find('.arrowright').hide('fast');

	jQuery('.bk_WPArchivesTree .title').on('click', function() {
		var id = jQuery(this).attr('id');
		if (jQuery('.bk_WPArchivesTree .subitemlist-'+id).is(':visible')) {
			jQuery('.bk_WPArchivesTree .subitemlist-'+id).slideUp('fast');
			jQuery(this).find('.arrowdown').hide();
			jQuery(this).find('.arrowright').show();
		} else {
			jQuery('.bk_WPArchivesTree .subitemlist-'+id).slideDown('fast');
			jQuery(this).find('.arrowdown').show();
			jQuery(this).find('.arrowright').hide();
		}
	});
}

function getScript(source, callback) {
    var script = document.createElement('script');
    var prior = document.getElementsByTagName('script')[0];
    script.async = 1;

    script.onload = script.onreadystatechange = function( _, isAbort ) {
        if(isAbort || !script.readyState || /loaded|complete/.test(script.readyState) ) {
            script.onload = script.onreadystatechange = null;
            script = undefined;

            if(!isAbort && callback) setTimeout(callback, 0);
        }
    };

    script.src = source;
    prior.parentNode.insertBefore(script, prior);
}