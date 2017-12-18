<?php

class ffThemeBuilderJavascriptCode extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var null javascript selectors
	 */
	private $_scope = null;

	/**
	 * @var bool wrap by (function($){})(jQuery)
	 */
	private $_wrapByAnonymousFunction = true;

	/**
	 * @var bool wrap by $(document).ready(function($){});
	 */
	private $_wrapByDocumentReady = true;

	/**
	 * @var string the code itself bro
	 */
	private $_code = '';

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getJsAsString() {
		return $this->_render();
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _wrapByDocumentReady( $code ) {
		if( !$this->_getWrapByDocumentReady() ) {
			return $code;
		}

		$toReturn = '';

		$toReturn .= 'jQuery(document).ready(function($) { ' . PHP_EOL;
		$toReturn .= $code . PHP_EOL;
		$toReturn .= '});' . PHP_EOL;

		return $toReturn;
	}

	private function _wrapByAnonymousFunction( $code ) {

		if( !$this->_getWrapByAnonymousFunction() ) {
			return $code;
		}

		$toReturn = '';

		$toReturn .= '(function($){' . PHP_EOL;
		$toReturn .= $code . PHP_EOL;
		$toReturn .= '})(jQuery);' . PHP_EOL;

		return $toReturn;

	}

	private function _getCodeWithReplacedSelector() {
		$code = $this->_code;

		$selectorsToReplace = $this->_createSelectorStringFromArray( $this->_getScope() );

		$codeWithReplacedSelectors = str_replace('!selector!', $selectorsToReplace, $code );

		return $codeWithReplacedSelectors;
	}

	private function _render() {
		$code = $this->_getCodeWithReplacedSelector();

		$codeWithDocumentReady = $this->_wrapByDocumentReady( $code );
		$codeWithAnonymousFunction = $this->_wrapByAnonymousFunction( $codeWithDocumentReady );

		return $codeWithAnonymousFunction;
	}

	private function _createSelectorStringFromArray( $selectorArray ) {
		$string = '';
		foreach( $selectorArray as $oneClass ) {

			if( strpos($oneClass, '.') === false && strpos($oneClass, '#') === false ) {
				$oneClass = '.'. $oneClass;
			}

			$string .= $oneClass .' ';
		}
		$string = trim( $string );

		return $string;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return null
	 */
	private function _getScope() {
		return $this->_scope;
	}

	/**
	 * @param null $scope
	 */
	public function setScope($scope) {
		$this->_scope = $scope;
	}

	/**
	 * @return boolean
	 */
	private function _getWrapByAnonymousFunction() {
		return $this->_wrapByAnonymousFunction;
	}

	/**
	 * @param boolean $wrapByAnonymousFunction
	 */
	public function setWrapByAnonymousFunction($wrapByAnonymousFunction) {
		$this->_wrapByAnonymousFunction = $wrapByAnonymousFunction;
	}

	/**
	 * @return boolean
	 */
	private function _getWrapByDocumentReady() {
		return $this->_wrapByDocumentReady;
	}

	/**
	 * @param boolean $wrapByDocumentReady
	 */
	public function setWrapByDocumentReady($wrapByDocumentReady) {
		$this->_wrapByDocumentReady = $wrapByDocumentReady;
	}

	/**
	 * @return string
	 */
	private function _getCode() {
		return $this->_code;
	}

	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->_code = $code;
	}




}