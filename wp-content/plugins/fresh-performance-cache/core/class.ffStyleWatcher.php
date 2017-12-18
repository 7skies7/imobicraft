<?php
/**
 * Watching all enqueued scripts, and they are noted into the wp options
 * thanks to this we can disable minification of few of them
 * 
 * @author twotick
 *
 */
class ffStyleWatcher extends ffBasicObject {

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
	public function __construct( ffWPLayer $WPLayer, ffDependencySolver $dependencySolver ) {
		$this->_setDependencySolver($dependencySolver);
		$this->_setWPLayer($WPLayer);
	}	
	
	public function watchStyles() {
		$styles = $this->_getWPLayer()->get_wp_styles();
		$enqueuedStyles = $this->_getDependencySolver()->getNewQueue( $styles->queue, $styles->registered );
		$styleList = $this->_convertToHandleSrcFormat( $enqueuedStyles['complex'] );

		return $styleList;
	}
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/

	private function _convertToHandleSrcFormat( $enqueuedStyles ) {
		$styleList = array();
		if( !empty($enqueuedStyles ) ) {
			foreach( $enqueuedStyles as $handle => $styleInfo) {
				if( strpos( $handle, 'ff-minified-') === false )
					$styleList[ $handle ] = $styleInfo['info']->src;
			}
		}

		return $styleList;
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