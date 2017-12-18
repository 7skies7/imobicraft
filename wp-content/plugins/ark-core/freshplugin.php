<?php
/*
Plugin Name: Ark Theme Core Plugin
Plugin URI: http://freshface.net
Description: Shortcodes & Custom Post Types for Ark Theme
Version: 1.26.0
Author: FRESHFACE
Author URI: http://arktheme.com/
Text Domain: ark-core
Dependency: fresh-framework
*/
define('FF_ARK_CORE_PLUGIN_VERSION', '1.26.0');
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
