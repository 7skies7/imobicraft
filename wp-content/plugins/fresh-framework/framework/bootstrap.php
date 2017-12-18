<?php
if( ! function_exists('ark_wp_kses') ) {
	/**
	 * Theme global escaping function
	 *
	 * @param $html string
	 * @return string
	 */
	function ark_wp_kses( $html ){
		// Static variable, but we want to call this function just once
		static $allowed_html = null;
		if( empty($allowed_html) ){
			$allowed_html = wp_kses_allowed_html('post');
		}
		return wp_kses( $html, $allowed_html );
	}
}

function ff_lowPhpVersionNotification() {
	if( !defined('FF_ARK_ENVIRONMENT_READY') || (defined('FF_ARK_ENVIRONMENT_READY') && FF_ARK_ENVIRONMENT_READY == false) ) {
		echo '<div class="error"><p>';
		echo ark_wp_kses(
			__( '<strong>You need PHP 5.4+ version</strong> to run Fresh Framework and products from FRESHFACE.' , 'ark' )
		) ;
		echo '</p></div>';
	}
}

function ff_initFramework() {

	// PHP version check
	$requiredPhpVersion = '5.4';
	$currentPhpVersion = phpversion();

	if( version_compare( $requiredPhpVersion, $currentPhpVersion, '<=') == false ) {
		if ( is_admin() ) {
			add_action( 'admin_notices', 'ff_lowPhpVersionNotification' );
		}

	}


	define('FF_FRAMEWORK_PLUGIN_ACTIVE', true);
	if ( !defined('FF_DEVELOPER_MODE') ) { define('FF_DEVELOPER_MODE', false); }

	remove_action('admin_notices', 'ff_plugin_fresh_framework_notification');

	$configuration = array(
		'less_and_scss_compilation' => true,
		'style_minification' => false,
		'script_minification' => false,
		'minificator' => array(
								'cache_files_max_old' => 60*60*24*7*2, // 14 days
								'cache_check_interval' => 60*60*24*3, // 3 days
							),

		'freshface-server-upgrading-url' => 'http://files.freshcdn.net/get-info.php',
		'freshface-server-theme-upgrading-url' => 'http://files.freshcdn.net/get-info-theme.php',

		// 'freshface-server-upgrading-url' => 'http://127.0.0.1:8888/wp/sandbox/wp-content/plugins/d-fresh-updater/get-info.php',
		// 'freshface-server-theme-upgrading-url' => 'http://127.0.0.1:8888/wp/sandbox/wp-content/plugins/d-fresh-updater/get-info-theme.php',
	);
	require_once FF_FRAMEWORK_DIR . '/framework/developingTools.php';
	require_once FF_FRAMEWORK_DIR . '/framework/fileSystem/class.ffClassLoader.php';


	$classLoader = new ffClassLoader();

	$classLoader->loadClass('ffBasicObject');

	$classLoader->loadConstants();
	
	$classLoader->loadClass('ffContainer');
	$classLoader->loadClass('ffFactoryAbstract');
	$classLoader->loadClass('ffFactoryCenterAbstract');
	$classLoader->loadClass('ffPluginAbstract');
	$classLoader->loadClass('ffPluginContainerAbstract');
	$classLoader->loadClass('ffException');
	$classLoader->loadClass('ffStdClass');
	$classLoader->loadClass('ffDataHolder');

	$container = ffContainer::getInstance();

	$container->setConfiguration($configuration);
	$container->setClassLoader($classLoader);

	do_action('ff_framework_initalized');

	// preventing to running framework when only making updates
//	if( FF_FRAMEWORK_IS_INSTALLED ) {
		$container->getFramework()->run();
//	}

	if( ('plugins.php' == basename($_SERVER['SCRIPT_NAME']) ) or ( 'update.php' == basename($_SERVER['SCRIPT_NAME']) ) ){
		ffContainer::getInstance()->getScriptEnqueuer()->addScriptFramework('ff-update-hide', '/framework/adminScreens/assets/js/update.js');
	}

}

ff_initFramework();

function ffContainer() {
	return ffContainer::getInstance();
}





function ffThemeContainer() {
    if( class_exists('ffThemeContainer') ) {
        return ffThemeContainer::getInstance();
    } else {
        return null;
    }
}

function ff_var_dump() {
	$args = func_get_args();

	echo '<span>';
		foreach( $args as $oneArg ) {
			var_dump( $oneArg );
		}
	echo '</span>';
}
