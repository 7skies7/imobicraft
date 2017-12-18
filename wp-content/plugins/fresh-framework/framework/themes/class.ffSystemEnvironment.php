<?php

class ffSystemEnvironment extends ffBasicObject {
	/**********************************************************************************************************************/
	/* OBJECTS
	/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**********************************************************************************************************************/
	/* PRIVATE VARIABLES
	/**********************************************************************************************************************/
	private $_themeBuilderEnabled = false;

	private $_sitePreferencesEnabled = false;

	/**********************************************************************************************************************/
	/* CONSTRUCT
	/**********************************************************************************************************************/
	public function __construct() {

		$this->_setWPLayer( ffContainer()->getWPLayer() );

		if( $this->_getWPLayer()->is_admin() && $this->_getWPLayer()->isArkTheme() ) {
			$this->_getWPLayer()->add_action('admin_menu', array( $this, 'actAdminMenu'), 999  );

//			$notValid = $this->getNonValidServerReportLines();

//			if( !empty( $notValid ) ) {

//				$this->_getWPLayer()->add_action('admin_notices', array( $this, 'actAdminNotices' ) );
//			}
//			var_Dump( $notValid );
//			die();
			//echo '<div class="error"><p>';
//			echo ark_wp_kses( __( 'It is strongly recommended to install and activate <strong>Fresh Framework</strong> plugin and <strong>Ark Theme Core Plugin</strong> to use 100% theme options and settings.' , 'ark' ) ) ;
//			echo '</p></div>';
			// admin_notices
//			$this->_getWPLayer()->add_action('admin')
		}
	}

	public function getVersionHash() {
		$corePluginVersion = FF_ARK_CORE_PLUGIN_VERSION;
		$themeVersion = FF_ARK_THEME_VERSION;
		$frameworkVersion = ffFrameworkVersionManager::getInstance()->getLatestRegisteredVersion();

		$hash = md5( $corePluginVersion. $themeVersion. $frameworkVersion );

		return $hash;
//		FF_ARK
	}

	public function actAdminNotices() {
//		die();
		if( !empty( $this->_notValidServerReport ) ) {
			echo '<div class="notice-warning settings-error notice is-dismissible"><p>';
				$statusUrl = $this->_getWPLayer()->get_admin_url(null, 'admin.php?page=Dashboard&adminScreenView=Status');
				echo 'Your server environment is not 100% compatible with <strong>Ark Theme</strong>, please check <a href="'.$statusUrl.'">System Status</a>';
			echo '</p></div>';
		}
	}

	public function getNonValidServerReportLines() {
		$this->generateServerReport(true);

		return $this->_notValidServerReport;
	}

	public function generateServerReport( $fast = false ) {
		if( !$fast && !empty($this->_serverReport) ) {
			return $this->_serverReport;
		}

		// memory
		$request = ffContainer()->getRequest();
		$WPLayer = $this->_getWPLayer();

		ffContainer()->getEnvironment()->getThemeVersion();
		$this->_addServerReportLine('ark_version', 'Ark Version', ffContainer()->getEnvironment()->getThemeVersion() );
		$this->_addServerReportLine('php_version', 'PHP Version', phpversion(), '5.4');
		$this->_addServerReportLine('max_execution_time', 'PHP time execution Limit', ini_get('max_execution_time'), '30');
		$this->_addServerReportLine('memory_limit', 'PHP memory Limit', ini_get('memory_limit'), '128M');
		$this->_addServerReportLine('port', 'Port', $request->server('SERVER_PORT'));

		$this->_addServerReportLine('post_max_size', 'PHP Post Max Size', ini_get('post_max_size'));
		$this->_addServerReportLine('max_input_vars', 'PHP Max Input Vars', ini_get('max_input_vars'));
		$this->_addServerReportLine('max_upload_size', 'PHP Max Input Vars', ini_get('max_input_vars'));


		$this->_addServerReportLine('home_url', 'Home Url', $WPLayer->get_home_url());
		$this->_addServerReportLine('site_url', 'Site Url', $WPLayer->site_url());
		$this->_addServerReportLine('is_multisite', 'Is Multisite', $WPLayer->is_multisite());

		// gd library
		$gdVersion = 0;
		if( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) {
			$gd_info = gd_info();
			if ( isset( $gd_info['GD Version'] ) ) {
				$gdVersion = filter_var($gd_info['GD Version'], FILTER_SANITIZE_NUMBER_INT);

			}
		}

		// gd library
		$this->_addServerReportLine('gd_library', 'GD Library', $gdVersion, '0.0.0' );

		// zip archive
		$this->_addServerReportLine('zip_archive', 'Zip Archive', class_exists( 'ZipArchive' ) );

		// mysql version
		$this->_addServerReportLine('mysql_version', 'MYSQL Version', $WPLayer->getWPDB()->db_version() );
		if( $fast ) {
			$serverReport = $this->_serverReport;
			$this->_serverReport = array();
			return $serverReport;
		}
		// active plugins
		$pluginIdentificator = ffContainer()->getPluginIdentificator();

		$plugins = array();
		foreach( $pluginIdentificator->getAllActivePluginsInfo() as $onePlugin  ) {
			$plugin = ffDataHolder($onePlugin);
			$onePlugin = $plugin->Name . ' -- ' . $plugin->Version . ' -- '. $plugin->PluginURI  ;
			$plugins[] = $onePlugin;
		}

		$plugins = implode("\n", $plugins );

		$this->_addServerReportLine('active_plugins', 'Active Plugins', $plugins);

		return $this->_serverReport;
	}

	private $_serverReport = array();

	private $_notValidServerReport = array();

	private function _addServerReportLine( $id, $name, $value, $recommended = '', $valid = '>=', $description = null ) {
		if( is_string($valid ) ) {
			$valid = version_compare( $value, $recommended, $valid);
		}

		$serverReportLine = array('id'=>$id, 'name'=> $name, 'value'=> $value, 'recommended' => $recommended, 'valid'=>$valid, 'description'=>$description);
		$this->_serverReport[ $id ] = $serverReportLine;


		if( $valid == false ) {
			$this->_notValidServerReport[ $id ] = $serverReportLine;
		}
	}

	public function actAdminMenu() {
		global $menu, $submenu;

		$doWeHaveUpdates = ffContainer()
				->getThemeFrameworkFactory()
				->getPrivateUpdateManager()
				->areThereAnyUpdates();

		if( $doWeHaveUpdates ) {
			foreach( $menu as $key => $oneMenuItem ) {
				if( $oneMenuItem[0] == 'Ark' ) {
					$menu[ $key ][0] =  $menu[ $key ][0] . ' <span class="awaiting-mod count-1"><span class="pending-count">1</span></span>';
//					var_Dump( $oneMenuItem );
//					$oneMenuItem[3] = 'ark kokot';
//					die();
				}
			}
		}

//		die();

		$menuOrder = array();
		$menuOrder[] = 'Boxed Wrappers';
		$menuOrder[] = 'Content Blocks Adm';
		$menuOrder[] = 'Dashboard';
		$menuOrder[] = 'Demo Install';
		$menuOrder[] = 'Footers';
		$menuOrder[] = 'Global Styles';
		$menuOrder[] = 'Headers';
		$menuOrder[] = 'Hire Us!';
		$menuOrder[] = 'Improvements';
		$menuOrder[] = 'Layouts';
		$menuOrder[] = 'Migration';
		$menuOrder[] = 'Sidebars';
		$menuOrder[] = 'Sitemap';
		$menuOrder[] = 'Support & Docs';
		$menuOrder[] = 'Templates';
		$menuOrder[] = 'Theme Options';
		$menuOrder[] = 'Titlebars';
		$menuOrder[] = 'Updates';




		if( !isset( $submenu['ThemeDashboard'] ) ){
			return;
		}

		$oldSubmenu = $submenu['ThemeDashboard'];
		$middleSubmenu = array();
		foreach( $oldSubmenu as $oneItem ) {
			$itemName = $oneItem[0];

			$position = array_search( $itemName, $menuOrder );
//			var_dump( $position );

			if( $oneItem[0] == 'Updates' && $doWeHaveUpdates ) {
				$oneItem[0] = $oneItem[0] . ' <span class="awaiting-mod count-1"><span class="pending-count">1</span></span>';
			}

			else if ( $oneItem[0]  == 'Support & Docs') {
				$oneItem[0] = '<span style="color:orange;">Support & Docs</span>';
			}

			else if ( $oneItem[0]  == 'Hire Us!') {
				$oneItem[0] = '<span style="color:#32d316;">Hire Us!</span>';
			}

//			else if ( $oneItem[0]  == 'Improvements') {
//				$oneItem[0] = '<span style="color:#16a7d3;">Improvements</span>';
//			}

//
			$middleSubmenu[ $position ] = $oneItem;



			ksort( $middleSubmenu);

		}

		$newSubmenu = array();

		foreach( $middleSubmenu  as $oneItem ) {
			$newSubmenu[] = $oneItem;
		}

		$submenu['ThemeDashboard'] = $newSubmenu;

//		var_dump( $menu, $submenu );
//		die();

	}

	/**********************************************************************************************************************/
	/* PUBLIC FUNCTIONS
	/**********************************************************************************************************************/
	public function enableThemeBuilder( $supportedPostTypesArray, $elementsCollection ) {
		$themeBuilderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
		foreach( $supportedPostTypesArray as $onePost ) {
			$themeBuilderManager->addSupportedPostType( $onePost );
		}



		foreach( $elementsCollection as $key=>$el ){
			$themeBuilderManager->addElement( $key );
		}

		$themeBuilderManager->enableBuilderSupport();

//		$themeBuilderManager->

		if( !is_admin() ) {
			ffContainer()->getFrameworkScriptLoader()->requireFreshGrid();
		}

		$this->_setThemeBuilderEnabled( true );

		$this->enableAdminConsole();

//		$this->enablePrintingBuilderInDoShortcodeFunction( $elementsCollection );
	}


	public function enableSitePreferencies() {
		$sitePreferencesManager = ffContainer()->getThemeFrameworkFactory()
			->getSitePreferencesFactory()
			->getSitePreferencesManager();

		$sitePreferencesManager->enableSitePreferences();

		$this->_setSitePreferencesEnabled( true );
	}

	public function enableDashboard() {
//		if( FF_DEVELOPER_MODE == false ) {
//			return;
//		}
		ffContainer()->getAdminScreenManager()
			->addAdminScreenClassName('ffAdminScreenDashboard')
			->addAdminScreenClassName('ffAdminScreenUpdates')
			->addAdminScreenClassName('ffAdminScreenMigration')
			->addAdminScreenClassName('ffAdminScreenGlobalStyles')
			->addAdminScreenClassName('ffAdminScreenHireUs')
			->addAdminScreenClassName('ffAdminScreenDocumentation')
			->addAdminScreenClassName('ffAdminScreenImprovements')
		;
	}

	public function enableDummy() {
//		if( FF_DEVELOPER_MODE == false ) {
//			return;
//		}
		ffContainer()->getAdminScreenManager()
			->addAdminScreenClassName('ffAdminScreenDummy');
	}
	
	public function enableAdminConsole() {
		ffContainer()
			->getThemeFrameworkFactory()
			->getAdminConsole()
			->enableAdminConsole();
	}


	/**********************************************************************************************************************/
	/* PUBLIC PROPERTIES
	/**********************************************************************************************************************/


	/**********************************************************************************************************************/
	/* PRIVATE FUNCTIONS
	/**********************************************************************************************************************/
	private function _hookActions() {

	}

	private function _lcnsCheck() {
		$licensing = ffContainer()->getLicensing();

		$status = $licensing->getStatus();

		if( $status == ffLicensing::STATUS_NOT_REGISTERED ) {
			$notification = ffContainer()->getAdminNotices();
			$notification->addNotice( ffAdminNotices::TYPE_WARNING, 'Ark theme requires activation in order to work properly. Please activate it <a href="'. admin_url('admin.php?page=Dashboard').'">here</a> ' , ffAdminNotices::SHOW_PERMANENT);
		} else if ( $status == ffLicensing::STATUS_DEACTIVATED ) {
			$notification = ffContainer()->getAdminNotices();
			$notification->addNotice( ffAdminNotices::TYPE_WARNING, 'Ark theme license was activated on another domain. Please activate it <a href="'. admin_url('admin.php?page=Dashboard').'">here</a> if you wish to use autoupdate functionality' , ffAdminNotices::SHOW_PERMANENT);
		}
//		var_Dump( $status );
//		die();

	}

	/**********************************************************************************************************************/
	/* ABSTRACT FUNCTIONS
	/**********************************************************************************************************************/


	/**********************************************************************************************************************/
	/* PRIVATE GETTERS & SETTERS
	/**********************************************************************************************************************/

	/**
	 * @return boolean
	 */
	private function _getThemeBuilderEnabled() {
		return $this->_themeBuilderEnabled;
	}

	/**
	 * @param boolean $themeBuilderEnabled
	 */
	private function _setThemeBuilderEnabled($themeBuilderEnabled) {
		$this->_themeBuilderEnabled = $themeBuilderEnabled;
	}

	/**
	 * @return boolean
	 */
	private function _getSitePreferencesEnabled() {
		return $this->_sitePreferencesEnabled;
	}

	/**
	 * @param boolean $sitePreferencesEnabled
	 */
	private function _setSitePreferencesEnabled($sitePreferencesEnabled) {
		$this->_sitePreferencesEnabled = $sitePreferencesEnabled;
	}

	/**
	 * @return ffWPLayer
	 */
	private function _getWPLayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $WPLayer
	 */
	private function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
	}


}