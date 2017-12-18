<?php

class ffStyleMinificator extends ffBasicObject {
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_wpLayer = null;
	
	/**
	 * 
	 * @var ffDependencySolver
	 */
	private $_dependencySolver = null;
	
	/**
	 * 
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	/**
	 * 
	 * @var ffStyleMinificatorBox
	 */
	private $_styleMinificatorBox = null;
	
	private $_bannedStyleHandles = array();
	
	private $_bannedStyleUrls = array();
	
	public function __construct( ffWPLayer $WPLayer, ffDependencySolver $dependencySolver, ffStyleMinificatorBox $styleMinificatorBox) {
		$this->_setWpLayer($WPLayer);
		$this->_setDependencySolver($dependencySolver);
		$this->_setStyleMinificatorBox($styleMinificatorBox);
		
	}
	
	private function _minifyFiles( $newQueue ) {
		if( empty( $newQueue ) ) {
			return;
		}
		
		$box = $this->_getStyleMinificatorBox();
		
		foreach( $newQueue['complex'] as $itemName => $itemData ) {
			$wpDep = $itemData['info'];
			
			if( $this->_isStyleBannedByURL( $wpDep->src ) || $this->_isStyleBannedByHandle( $wpDep->handle) || $this->_isStyleRemote( $wpDep->src ) || $this->_isStyleWrong( $wpDep )) { 
				if( $box->isInBatch() ) {
					
					$box->endBatch();
					
				}	
				
				$box->addNonMinifiedCss( $wpDep );
			} else {
				if( !$box->isInBatch() ) {
					$box->startBatch( 'ff-minified-style-'.$box->getBatchCounter() );
				}
				
				$box->addMinifiedCss( $wpDep );
	
			}
		}
		
		if( $box->isInBatch() ) {
			$box->endBatch();
		}
		return;
	}
	
	private function _isStyleWrong( $wpDep ) {
		return isset($wpDep->extra['conditional']);
		/*var_dump( $wpDep );
		var_dump( isset($wpDep->extra['conditional']) );
		if( isset($wpDep->extra['conditional']) ) {
			return true;
		}
		
		return false;*/
	}
	
	public function addBannedStyleHandle( $handle ) {
		if( is_array( $handle ) ) {
			$this->_bannedStyleHandles = array_merge( $this->_bannedStyleHandles, array_fill_keys($handle, true) );
		} else {
			$this->_bannedStyleHandles[ $handle ] = true;
		}
	}
	
	public function addBannedStyleByUrl( $url ) {
		if( is_array( $url ) ) {
			$this->_bannedStyleUrls = array_merge( $this->_bannedStyleUrls, array_fill_keys($url, true) );
		} else {
			$this->_bannedStyleUrls[ $url ] = true;
		}
	}
	
	private function _isStyleBannedByHandle( $handleName ) {
		return isset( $this->_bannedStyleHandles[ $handleName ] );
	} 
	
	private function _isStyleBannedByURL( $url ) {
		return isset( $this->_bannedStyleUrls[ $url ] );
	}
	
	private function _isStyleRemote( $source ) {
		$siteUrl = $this->_getWPLayer()->get_site_url();

		$siteUrl = str_replace('http://','', $siteUrl);
		$siteUrl = str_replace('https://','', $siteUrl);

		if( strpos( $source, '/wp-includes/' ) === 0 ) {
			return false;
		}
	
		if( strpos( $source, $siteUrl ) === false ) {
			return true;
		}
	
		return false;
	}
	
	
	protected function _registerMinifiedFiles() {
		$box = $this->_getStyleMinificatorBox();
		
		$styles = $this->_getWpLayer()->get_wp_styles();
		$styles->registered = array_merge( $styles->registered, $box->getDependencies() );
		$styles->queue = $box->getQuery();
		
		foreach( $box->getDependencies() as $handle => $style ) {
			$styles->registered[ $handle ]->deps = array();
		}
		
		$this->_getWpLayer()->set_wp_styles($styles);
	}
	
	public function minify() {
		// disabled minification for admin
		if( $this->_getWpLayer()->is_admin() ) {
			return;
		}
		
		$styles = $this->_getWpLayer()->get_wp_styles();
		// new queue is with all dependencies and other stuff
		$newQueue = $this->_getDependencySolver()->getNewQueue( $styles->queue, $styles->registered );
		// minify the new queue
		$this->_minifyFiles( $newQueue );
		// register minified files to wp style object
		$this->_registerMinifiedFiles();
		return;
	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWpLayer() {
		return $this->_wpLayer;
	}
	
	/**
	 * @param ffWPLayer $wpLayer
	 */
	protected function _setWpLayer(ffWPLayer $wpLayer) {
		$this->_wpLayer = $wpLayer;
		return $this;
	}

	/**
	 * @return ffDependencySolver
	 */
	protected function _getDependencySolver() {
		return $this->_dependencySolver;
	}
	
	/**
	 * @param ffDependencySolver $dependencySolver
	 */
	protected function _setDependencySolver(ffDependencySolver $dependencySolver) {
		$this->_dependencySolver = $dependencySolver;
		return $this;
	}

	/**
	 * @return ffStyleMinificatorBox
	 */
	protected function _getStyleMinificatorBox() {
		return $this->_styleMinificatorBox;
	}
	
	/**
	 * @param ffStyleMinificatorBox $styleMinificatorBox
	 */
	protected function _setStyleMinificatorBox(ffStyleMinificatorBox $styleMinificatorBox) {
		$this->_styleMinificatorBox = $styleMinificatorBox;
		return $this;
	}	
}