<?php

class ffThemeBuilderCache extends ffBasicObject {
	const CACHE_NAMESPACE = 'elementsCache';
	const FRESHBUILDER_NAMESPACE = 'freshbuilder';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffDataStorage_Cache
	 */
	private $_cache = null;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffThemeBuilderCache constructor.
	 * @param ffWPLayer $WPLayer
	 * @param ffDataStorage_Cache $cache
	 */
	public function __construct( $WPLayer, $cache ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setCache( $cache );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function deleteOldFiles() {
		$this->_cache->deleteOldFilesInNamespace( ffThemeBuilderCache::CACHE_NAMESPACE, 60*60* 8, 60*60*24 * 5);
//		$this->_cache->deleteOldFilesInNamespace( ffThemeBuilderCache::FRESHBUILDER_NAMESPACE, 60*60* 24 * 5, 60*60*24*21);
	}

	public function numberOfFilesInBackendCache() {
		return count($this->_cache->getAllOptionNames(ffThemeBuilderCache::FRESHBUILDER_NAMESPACE));
	}

	public function numberOfFilesInFrontedCache() {
		return count($this->_cache->getAllOptionNames(ffThemeBuilderCache::CACHE_NAMESPACE));
	}

	public function deleteBackendCache() {
		$this->_cache->deleteNamespace( ffThemeBuilderCache::FRESHBUILDER_NAMESPACE );
	}

	public function deleteFrontendCache() {
		$this->_cache->deleteNamespace( ffThemeBuilderCache::CACHE_NAMESPACE );
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	public function setOptionToFreshbuilder( $name, $value ) {
		if( is_array( $value ) ) {
//			$value = 'ff_flag_json'
		}
	}

	public function setElementOptionsToCache( $elementId, $options ) {
		$this->_getCache()->setOption( ffThemeBuilderCache::FRESHBUILDER_NAMESPACE, $elementId, $options );
	}

	public function getElementOptionsFromCache( $elementId ){
		if( defined('FF_BUILDER_CACHE') && FF_BUILDER_CACHE == false ) {
			return null;
		}

		return $this->_getCache()->getOption( ffThemeBuilderCache::FRESHBUILDER_NAMESPACE, $elementId );
	}
	
	
	public function setElementToCache( $id, $content, $css, $js, $hash ) {
		$elementArray = array();
		$elementArray['content'] = $content;
		$elementArray['css'] = $css;
		$elementArray['js'] = $js;

		$elementJSON = json_encode( $elementArray );
		$this->_getCache()->setOptionWithHash(ffThemeBuilderCache::CACHE_NAMESPACE, $id, $elementJSON, $hash );
	}

	public function getElementFromCache( $id, $hash, $returnAsArrayInsteadOfStdClass = true ) {
		$elementJSON = $this->_getCache()->getOptionWithHash(ffThemeBuilderCache::CACHE_NAMESPACE, $id, $hash);

		if( $elementJSON == null ) {
			return null;
		} else {
			$element = json_decode( $elementJSON, $returnAsArrayInsteadOfStdClass );

			return $element;
		}
	}
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffDataStorage_Cache
	 */
	private function _getCache() {
		return $this->_cache;
	}

	/**
	 * @param ffDataStorage_Cache $cache
	 */
	private function _setCache($cache) {
		$this->_cache = $cache;
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