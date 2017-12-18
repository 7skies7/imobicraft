<?php

class ffPluginFreshMinificator extends ffPluginAbstract {
	
	const OPT_NAMESPACE = 'ff_minificator';
	/**
	 *
	 * @var ffPluginFreshMinificatorContainer
	 */
	protected $_container = null;
	
	/**
	 * 
	 * @var ffOptionsQuery
	 */
	protected $_query = null;
	
	
	protected function _registerAssets() {
		$this->_getContainer()->getFrameworkContainer()->getAdminScreenManager()->addAdminScreenClassName('ffAdminScreenMinificator');
	}
	
	protected function _run() {
		$fwc = $this->_getContainer()->getFrameworkContainer();
		$WPLayer = $fwc->getWPLayer();

	
		$hookManager =  $fwc->getWPLayer()->getHookManager();
		

		
		$dataStorage = $fwc->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		$options = $dataStorage->getOption('options');
		$optionsHolder = $fwc->getOptionsFactory()->createOptionsHolder('ffMinificatorOptionsHolder');
		$query = $fwc->getOptionsFactory()->createQuery($options, $optionsHolder);
		$this->_setQuery( $query );
		
		
		if( $query->getWithoutComparationDefault('minificator enable_cache', 0) == 0 ) {
			if( $fwc->getWPLayer()->is_admin() ) {
				$fwc->getWPLayer()->add_action('admin_notices', array( $this, 'adminNotice') );
			} else {
//				echo 'not enabled ty kurvo';
			}

			return;
		}

		if( $WPLayer->is_admin() || $WPLayer->is_login_page() ) {
			return;
		}
		
		if( $query->get('minificator allow_css') == 1) 
			$hookManager->addActionWPPrintStyles( array( $this, 'actPrintStyles'), 19 );
		
		if( $query->get('minificator allow_js') == 1 ) {
			$hookManager->addActionWPPrintScripts( array( $this, 'actPrintScripts'), 19 );
			$fwc->getWPLayer()->add_action('wp_footer', array( $this, 'actPrintScriptsFooter'), 19 ); 
		}
		
	}

	public function adminNotice() {
		$WPLayer = $this->_getContainer()->getFrameworkContainer()->getWPLayer();

		$performanceCacheAdminUrl = $WPLayer->admin_url('options-general.php?page=Minificator');
		echo '<div class="notice notice-warning is-dismissible">';
		echo '<p>Fresh Performance Cache (plugin) is installed, but not active. You can activate it in WP Admin -> Settings -> <a href="'.$performanceCacheAdminUrl.'" target="_blank">Performance Cache</a>.</p>';
		echo '</div>';
	}

	public function actPrintScriptsFooter() {
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		//if( $this->_getQuery()->get('minificator allow_monitoring_js') ) {
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED  
		if( true ) {
			$scriptWatcher = $this->_getContainer()->getScriptWatcher();
			$scriptList = $scriptWatcher->watchScripts();

			$dataStorage->addToOption('watched_scripts_header', $scriptList['header_scripts']);
			$dataStorage->addToOption('watched_scripts_footer', $scriptList['footer_scripts']);			
		}
		
		$bannedFiles = $dataStorage->getOption('banned_handles_scripts');
		
		$scriptMinificator = $this->_getContainer()->getScriptMinificator();
		$scriptMinificator->addBannedScriptHandle( $bannedFiles );
		$scriptMinificator->minify('footer');
		
	}
	
	
	public function actPrintStyles() {
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED		
		//if( $this->_getQuery()->get('minificator allow_monitoring_css') ) {
		if( true ) {
			$styleWatcher = $this->_getContainer()->getStyleWatcher();
			$styleList = $styleWatcher->watchStyles();
			
			$dataStorage->addToOption( 'watched_styles_header', $styleList);
		}
		

		
		$bannedFiles = $dataStorage->getOption('banned_handles_styles');
		$bannedFiles = $this->_getContainer()->getFrameworkContainer()->getWPLayer()->apply_filters('ff_performance_cache_banned_css', $bannedFiles);
	
		$styleMinificator = $this->_getContainer()->getStyleMinificator();
		$styleMinificator->addBannedStyleHandle($bannedFiles);

		$styleMinificator->minify();
	}
	
	

	public function actPrintScripts(){
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		//if( $this->_getQuery()->get('minificator allow_monitoring_js') ) {
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED  
		if( true ) {
			$scriptWatcher = $this->_getContainer()->getScriptWatcher();
			$scriptList = $scriptWatcher->watchScripts();

			$dataStorage->addToOption('watched_scripts_header', $scriptList['header_scripts']);
			$dataStorage->addToOption('watched_scripts_footer', $scriptList['footer_scripts']);			
		}
		
		$bannedFiles = $dataStorage->getOption('banned_handles_scripts');
		$bannedFiles = $this->_getContainer()->getFrameworkContainer()->getWPLayer()->apply_filters('ff_performance_cache_banned_js', $bannedFiles);
		$scriptMinificator = $this->_getContainer()->getScriptMinificator();
		$scriptMinificator->addBannedScriptHandle( $bannedFiles );
		$scriptMinificator->minify();
		
		
	}
	
	
	
	protected function _setDependencies() {
			
	}

	
	/**
	 * @return ffPluginFreshMinificatorContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}

	protected function _getQuery() {
		return $this->_query;
	}
	
	protected function _setQuery(ffOptionsQuery $query) {
		$this->_query = $query;
		return $this;
	}
	
}