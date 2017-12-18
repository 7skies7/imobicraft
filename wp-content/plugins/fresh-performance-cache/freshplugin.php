<?php
/*
Plugin Name: Fresh Performance Cache
Plugin URI: http://freshface.net
Description: Boost your WordPress site performance by minifying, combining, compressing and caching your files.
Version: 1.2.0
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

