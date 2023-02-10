// Document Ready
jQuery(function() {
	tinymce.create('tinymce.plugins.Wpshortcode', {
		init : function(ed, url) {

			ed.addButton('custom-shortcode', {
				title : 'Add Custom Shortcode',
				cmd : 'custom-shortcode',
				image : url + '/../images/shortcode.png'
			});

			ed.addCommand('custom-shortcode', function() {
				jQuery(document).find('.wp-shortcode-button').trigger('click');
			});
		}
	});
	// Register plugin
	tinymce.PluginManager.add( 'custom-shortcode', tinymce.plugins.Wpshortcode );
});