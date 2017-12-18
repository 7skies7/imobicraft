<?php
/*
Plugin Name: Fresh File Editor
Plugin URI: http://freshface.net
Description: Easily Add, Rename, Delete and Edit your server files via WordPress admin without any FTP and Text Editor apps
Version: 1.0.1
Author: FRESHFACE
Author URI: http://freshface.net
Dependency: fresh-framework
*/

if( !function_exists('ff_plugin_fresh_framework_notification') ) {
	function ff_plugin_fresh_framework_notification() {
		?>
	    <div class="error">
	    <p><strong><em>Fresh</strong></em> plugins require the <strong><em>'Fresh Framework'</em></strong> plugin to be activated first.</p>
	    </div>
	    <?php
	}
	add_action( 'admin_notices', 'ff_plugin_fresh_framework_notification' );
}