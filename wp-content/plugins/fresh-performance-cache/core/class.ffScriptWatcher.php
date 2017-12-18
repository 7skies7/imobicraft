<?php
/**
 * Watching the required scripts. This info is a carefully noted and then
 * available on the admin screen. Based on this info you can decide which
 * scripts could be minified and which not :)
 * 
 * @author twotick
 *
 */


class ffScriptWatcher extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	protected $_WPLayer = null;
	
	/**
	 * 
	 * @var ffDependencySolver
	 */
	protected $_dependencySolver = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffDependencySolverForScripts $dependencySolverForScripts ) {
		$this->_setDependencySolver( $dependencySolverForScripts);
		$this->_setWPLayer($WPLayer);
	}
	
	public function watchScripts() {
		$scripts = $this->_getWPLayer()->get_wp_scripts();
		
		$enqueuedScripts = $this->_getDependencySolver()->getNewQueue( $scripts->queue, $scripts->registered);

		$headerScripts = array();
		$footerScripts = array();

		if( isset($enqueuedScripts['header']) ) {
			$headerScripts = $this->_convertToHandleSrcFormat($enqueuedScripts['header']['complex']);
		}

		if( isset($enqueuedScripts['header']) ) {
			$footerScripts = $this->_convertToHandleSrcFormat($enqueuedScripts['footer']['complex']);
		}
		
		$toReturn = array();
		$toReturn['header_scripts'] = $headerScripts;
		$toReturn['footer_scripts'] = $footerScripts;
		
		return $toReturn;
		
		//die();
	}	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _convertToHandleSrcFormat( $enqueuedScripts ) {
		$scriptList = array();
		if( !empty($enqueuedScripts ) ) {
			foreach( $enqueuedScripts as $handle => $scriptInfo) {
				$newPair = array();
				if( strpos( $handle, 'ff-minified-') === false )
					$scriptList[ $handle ] = $scriptInfo['info']->src;
			}
		}
		
		return $scriptList;
	}
	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
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
}