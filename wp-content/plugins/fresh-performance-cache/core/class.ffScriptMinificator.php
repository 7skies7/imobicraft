<?php

class ffScriptMinificator extends ffBasicObject {
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffDependencySolver
	 */
	private $_dependencySolver = null;

	/**
	 * 
	 * @var ffScriptMinificatorBox
	 */
	private $_scriptMinificatorBox = null;
	
	private $_bannedScriptHandles = array();
	
	private $_bannedScriptUrls = array();
	
	public function __construct( ffWPLayer $WPLayer, ffScriptMinificatorBox $scriptMinificatorBox, ffDependencySolverForScripts $dependencySolver ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setScriptMinificatorBox( $scriptMinificatorBox );
		$this->_setDependencySolver( $dependencySolver );
	}
	
	private function _minifyFiles( $newQueue ) {
		if( empty( $newQueue ) ) {
			return;
		}
		
		$box = $this->_getScriptMinificatorBox();
		$box->reset();
		foreach( $newQueue['complex'] as $itemName => $itemData ) {
			
			$wpDep = $itemData['info'];
			
			if( $this->_isScriptBannedByURL( $wpDep->src ) || $this->_isScriptBannedByHandle( $wpDep->handle) || $this->_isScriptRemote(  $wpDep->src ) ) {
				if( $box->isInBatch() ) {
					$box->endBatch();
					
				}

				$box->addNonMinifiedJs( $wpDep );
			} else {
				if( !$box->isInBatch() ) {
					$box->startBatch( 'ff-minified-script-'.$box->getBatchCounter() );
				}
		
				$box->addMinifiedJs( $wpDep );
		
			}
		}
		
		if( $box->isInBatch() ) {
			$box->endBatch();
		}
		
		return;
	}
	
	private function _isScriptRemote( $source ) {
		if( $source == false ) {
			return false;
		}
		$siteUrl = $this->_getWPLayer()->get_site_url();

		$siteUrl = str_replace('http://','', $siteUrl);
		$siteUrl = str_replace('https://','', $siteUrl);

		//TODO maybe change this for constant
		if( strpos( $source, '/wp-includes/' ) === 0 ) {
			return false;
		}


		if( strpos( $source, '/wp-includes/' ) === 0 ) {
			return false;
		}
		
		if( strpos( $source, $siteUrl ) === false ) {
			return true;
		}
		
		return false;
	}
	
	
	private function _isScriptBannedByHandle( $handleName ) {
		return isset( $this->_bannedScriptHandles[ $handleName ] );
	}
	
	private function _isScriptBannedByURL( $url ) {
		return isset( $this->_bannedScriptUrls[ $url ] );
	}

	public function addBannedScriptHandle( $handle ) {
		if( is_array( $handle ) ) {
			$this->_bannedScriptHandles = array_merge( $this->_bannedScriptHandles, array_fill_keys($handle, true) );
		} else {
			$this->_bannedScriptHandles[ $handle ] = true;
		}
	}
	
	public function addBannedScriptByUrl( $url ) {
		if( is_array( $url ) ) {
			$this->_bannedScriptUrls = array_merge( $this->_bannedScriptUrls, array_fill_keys($url, true) );
		} else {
			$this->_bannedScriptUrls[ $url ] = true;
		}
	}
	
	private function _registerMinifiedFiles() {
		$registeredList = $this->_getScriptMinificatorBox()->getDependencies();
		$queueNew = $this->_getScriptMinificatorBox()->getQuery();
		$queueReplaced = $this->_getScriptMinificatorBox()->getAllMinifiedHandles();
//
//		//var_dump( $queueReplaced );
//
		$wp_scripts = $this->_getWPLayer()->get_wp_scripts();
//
//
//
		$wp_scripts->registered = array_merge( $wp_scripts->registered, $registeredList );
		$wp_scripts->queue = array_merge(array_diff($wp_scripts->queue, $queueReplaced), $queueNew );


		//var_Dump( $queueReplaced );
		//var_dump( array_merge(array_diff($wp_scripts->queue, $queueReplaced), $queueNew ) );
		foreach( $queueReplaced as $oneHandle ) {
			$wp_scripts->registered[ $oneHandle ]->deps = array();
		}

		$this->_getWPLayer()->set_wp_scripts( $wp_scripts );
	}
	
	public function minify( $position = 'header') {

		if( $this->_getWpLayer()->is_admin() ) {
			return;
		}

		$scripts = $this->_getWPLayer()->get_wp_scripts();		
		$dependencySolver = $this->_getDependencySolver(); //ffPluginFreshMinificatorContainer::getInstance()->getDependencySolverForScripts();
		
		$newQueue = $dependencySolver->getNewQueue( $scripts->queue, $scripts->registered );

		if( !isset( $newQueue[ $position ] ) ) {
			return;
		}

		$this->_minifyFiles( $newQueue[$position] );
//
		$this->_registerMinifiedFiles();
	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	protected function _getScriptMinificatorBox() {
		return $this->_scriptMinificatorBox;
	}
	
	protected function _setScriptMinificatorBox(ffScriptMinificatorBox $scriptMinificatorBox) {
		$this->_scriptMinificatorBox = $scriptMinificatorBox;
		return $this;
	}

	protected function _getDependencySolver() {
		return $this->_dependencySolver;
	}
	
	protected function _setDependencySolver(ffDependencySolver $dependencySolver) {
		$this->_dependencySolver = $dependencySolver;
		return $this;
	}
	
	
	
}