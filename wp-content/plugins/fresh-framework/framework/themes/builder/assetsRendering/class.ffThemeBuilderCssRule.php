<?php

class ffThemeBuilderCssRule extends ffBasicObject {

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * scope of parent selectors
	 * @var array
	 */
	private $_scope = array();

	private $_useScope = true;

	/**
	 * Saved selectors, for multiple scoping
	 * @var array
	 */
	private $_savedSelectors = array();

	/**
	 * additional selectors
	 * @var array
	 */
	private $_selectors = array();

	private $_addWhiteSpaceBetweenSelectors = true;

	/**
	 * Media query Wrapper
	 * @var array
	 */
	private $_breakpoints = array();

	/**
	 * is retina - for media query
	 * @var bool
	 */
	private $_isRetina = false;

	private $_state = null;

	private $_pseudoElement = null;

	/**
	 * css parameters
	 * @var array
	 */
	private $_params = array();

	private $_paramsString = '';

	private $_content = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	/*----------------------------------------------------------*/
	/* BREAKPOINTS
	/*----------------------------------------------------------*/
	//(min-width: 768px and max-width:1024
	//@screen-xs-max: 767px;
	//@screen-sm-min: 768px;
	//@screen-sm-max: 991px;
	//@screen-md-min: 992px;
	//@screen-md-max: 1199px;
	//@screen-lg-min: 1200px;

	public function setContent( $string ) {
		$this->_content = $string;
	}

	public function setAddWhiteSpaceBetweenSelectors( $value ) {
		$this->_addWhiteSpaceBetweenSelectors = $value;

		return $this;
	}

	public function addBreakpointMin( $type ) {

		$typeLow = strtolower( $type );
		$typeUcFirst = ucfirst( $typeLow );

		$funcName = 'addBreakpoint' . $typeUcFirst . 'Min';

		call_user_func( array( $this, $funcName ) );

		return $this;
	}


	public function addBreakpoint( $value ) {
		$this->_breakpoints[] = $value;
	}

	public function addBreakpointXsMin() {
//		$this->addBreakpoint( 'min-width:320px' );
		return $this;
	}

	public function addBreakpointXsMax() {
		$this->addBreakpoint( 'max-width:767px' );
		return $this;
	}

	public function addBreakpointSmMin() {
		$this->addBreakpoint( 'min-width:768px');
		return $this;
	}

	public function addBreakpointSmMax() {
		$this->addBreakpoint( 'max-width:991px');
		return $this;
	}

	public function addBreakpointMdMin() {
		$this->addBreakpoint( 'min-width:992px');
		return $this;
	}

	public function addBreakpointMdMax() {
		$this->addBreakpoint( 'max-width:1199px');
		return $this;
	}

	public function addBreakpointLGMin() {
		$this->addBreakpoint( 'min-width:1200px');
		return $this;
	}

	/*----------------------------------------------------------*/
	/* ADD TEXT CONTENT
	/*----------------------------------------------------------*/
	public function setParam( $name, $value ) {
		$this->_params[ $name ] = $value;
		return $this;
	}

	public function addParamsString( $params) {
		$this->_paramsString .= $params;

//		$rules = explode(';', trim($params));
//
//		foreach( $rules as $oneRule ) {
//			if( empty( $oneRule ) ) {
//				continue;
//			}
//
//			var_dump( $oneRule );
//		}

	}

	/*----------------------------------------------------------*/
	/* STATE AND PSEUDO ELEMENTS
	/*----------------------------------------------------------*/
	public function setState( $state ) {
		$this->_state = $state;
		return $this;
	}

	public function setPseudoElement( $type, $state = null ) {
		$this->_pseudoElement = $type;
		if( $state != null ) {
			$this->_pseudoElement .= ':' . $state;
		}
		return $this;
	}

	public function setIsRetina( $isRetina ) {
		$this->_isRetina = $isRetina;
	}


	public function useScope( $useScope ) {
		$this->_useScope = $useScope;
		return $this;
	}

	public function setScope( $selectorArray ) {
		$this->_scope = $selectorArray;
		return $this;
	}

	public function removeSelectorFromScope() {
		array_pop( $this->_scope );
		return $this;
	}

	public function removeSelectorFromScopeAndReturnIt() {
		return array_pop( $this->_scope );
	}

	public function addSelectorArray( $selectorArray ) {
		foreach( $selectorArray as $oneSelector ) {
			$this->addSelector( $oneSelector );
		}
		return $this;
	}

	public function cleanSelectors() {
		$this->_selectors = array();
		return $this;
	}

	public function addSelector( $selector, $useDot = true ) {

		if( strpos($selector, '.') === false && strpos($selector, '#') === false && $useDot == true ) {
			$selector = '.'. $selector;
		}

		$this->_selectors[] = $selector;
		return $this;
	}

	public function createNewSelectorBranch( $selector = null, $useDot = true ) {
		$this->_savedSelectors[] = $this->_selectors;

		$this->_selectors = array();

		if( $selector !== null ) {
			$this->addSelector( $selector, $useDot );
		}

		return $this;
	}




	public function getCssAsString() {
		return $this->_render();
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _renderCssParams() {
		$toReturn = '';
		foreach( $this->_params as $name => $value ) {
			$toReturn .= "\t" . $name . ':' . $value . ';' . PHP_EOL;
		}

		$toReturn .= $this->_paramsString;

		return $toReturn;
	}

	private function _createSelectorStringFromArray( $selectorArray , $useDot = true) {
		$string = '';

		foreach( $selectorArray as $oneClass ) {

			if( strpos($oneClass, '.') === false && strpos($oneClass, '#') === false && $useDot == true) {
				$oneClass = '.'. $oneClass;
			}

			$string .= $oneClass .' ';
		}

		if( $string !== ' ') {
			$string = rtrim( $string );
		}



		return $string;
	}

	private function _renderSelectors( $cssParams ) {
		$toReturn = '';

		$scope = '';

		if( $this->_useScope ) {
			$scope = $this->_createSelectorStringFromArray( $this->_scope );
		}

		// state
		if( !empty($this->_state ) ) {
			$scope .= ':'. $this->_state;
		}

		if( !empty( $this->_pseudoElement ) ) {
			$scope .= ':' . $this->_pseudoElement;
		}

		$selectorsArray = array();

		if( !empty( $this->_savedSelectors ) ) {
			foreach( $this->_savedSelectors as $oneSelector ) {
				$selectorsString = $this->_createSelectorStringFromArray( $oneSelector, false );
				if( !empty( $selectorsString ) ) {
					if( $this->_addWhiteSpaceBetweenSelectors ) {
						$selectorsArray[] =  $scope .' ' . $selectorsString;
					} else {
						$selectorsArray[] = $scope . $selectorsString;
					}
				}
			}
		}

		$selectorsString = $this->_createSelectorStringFromArray( $this->_selectors, false );
		if( !empty( $selectorsString ) ) {
			if( $this->_addWhiteSpaceBetweenSelectors ) {
				$selectorsArray[] =  $scope .' ' . $selectorsString;
			} else {
				$selectorsArray[] = $scope . $selectorsString;
			}
		}


		$selectorsString = implode( ',' . PHP_EOL, $selectorsArray );
		if( empty($selectorsString ) ) {
			$toReturn = $scope;
		} else {
			$toReturn = $selectorsString;
		}


		$toReturn .= '{ ' . PHP_EOL;
		$toReturn .= $cssParams . PHP_EOL;
		$toReturn .= '}' . PHP_EOL;


		return $toReturn;
	}

	private function _renderMediaQuery( $selectors )  {
		if( empty($this->_breakpoints) ) {
			return $selectors;
		}

		$toReturn = '';

		$mediaQueryString  = implode( ' and ', $this->_breakpoints );

		$toReturn .= '@media (' .$mediaQueryString .') { ' . PHP_EOL;
		$toReturn .= $selectors;
		$toReturn .= '}';

		return $toReturn;
	}

	private function _renderRetina( $mediaQuery ) {
		return $mediaQuery;
	}

	private function _render() {
		if( $this->_content != null ) {
			return $this->_content;
		}

		$cssParams = $this->_renderCssParams();
		$selectors = $this->_renderSelectors( $cssParams );
		$mediaQuery = $this->_renderMediaQuery( $selectors );
		$retina = $this->_renderRetina( $mediaQuery );

		return $retina;
	}


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}