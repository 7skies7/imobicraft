<?php
class ffThemeBuilderAssetsRenderer extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffThemeBuilderCssRuleFactory
	 */
	private $_cssRuleFactory = null;

	/**
	 * @var ffCollection[ffThemeBuilderCssRule]
	 */
	private $_cssRulesCollection = null;

	/**
	 * @var ffThemeBuilderJavascriptCodeFactory
	 */
	private $_javascriptCodeFactory = null;

	/**
	 * @var ffCollection[ffThemeBuilderJavascriptCode]
	 */
	private $_javascriptCodesCollection = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_selectors = array();

	private $_elementHelpers = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffThemeBuilderCssRuleFactory $cssRuleFactory, ffCollection $cssRulesCollection, ffThemeBuilderJavascriptCodeFactory $jsCodeFactory,  ffCollection $javascriptCodeCollection ) {

		$this->_setCssRuleFactory( $cssRuleFactory );
	    $this->_setJavascriptCodeFactory( $jsCodeFactory );

	    $this->_setCssRulesCollection( $cssRulesCollection );
	    $this->_setJavascriptCodesCollection( $javascriptCodeCollection );
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function reset() {
		$this->_getJavascriptCodesCollection()->clean();
		$this->_getCssRulesCollection()->clean();
		$this->getCssCollection()->clean();
		$this->getJSCollection()->clean();
	}
	/**
	 * @param bool $automaticallyAddSelectors
	 * @return ffThemeBuilderCssRule
	 */
	public function createCssRule( $keepItScoped = true) {
		$newCssRule = $this->_getCssRuleFactory()->createCssRule();
		$this->_getCssRulesCollection()->addItem( $newCssRule );
		$newCssRule->setScope( $this->_getSelectors() );
		$newCssRule->useScope( $keepItScoped );

		return $newCssRule;
	}

	public function createJavascriptCode() {
		$jsCode = $this->_getJavascriptCodeFactory()->createJavascriptCode();

		$this->_getJavascriptCodesCollection()->addItem( $jsCode );
		$jsCode->setScope( $this->_getSelectors() );

		return $jsCode;
	}


	public function getCssCollection() {
		return $this->_getCssRulesCollection();
	}

	public function getJSCollection() {
		return $this->_getJavascriptCodesCollection();
	}

	public function getCssAsString() {
		$toReturn = '';

		/**
		 * @var $oneRule ffThemeBuilderCssRule
		 */
		foreach( $this->_getCssRulesCollection() as $oneRule ) {
			$toReturn .= $oneRule->getCssAsString();
		}

		return $toReturn;
	}

	public function getJavascriptAsString() {
		$toReturn = '';

		/**
		 * @var $oneJs ffThemeBuilderJavascriptCode
		 */
		foreach( $this->_getJavascriptCodesCollection() as $oneJs ) {
			$toReturn .= $oneJs->getJsAsString() . PHP_EOL;
		}

		return $toReturn;
	}

	public function addSelectorToCascade( $selector ) {
		$this->_selectors[] = $selector;

		$this->addElementHelperToCascade();
	}

	public function removeSelectorFromCascade() {
		$this->removeElementHelperToCascade();
		return array_pop( $this->_selectors );
	}

	public function getSelectors() {
		return $this->_selectors;
	}

	public function addElementHelperToCascade() {
		$elementHelper = $this->_getNewElementHelper();
		$this->_elementHelpers[] = $elementHelper;
	}

	/**
	 * @return ffElementHelper
	 */
	public function getElementHelper() {
		return end( $this->_elementHelpers);
	}

	public function removeElementHelperToCascade() {
		return array_pop( $this->_elementHelpers );
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	private function _getNewElementHelper() {
		return ffContainer()->getElementHelper();
	}

	/**
	 * @return ffThemeBuilderCssRuleFactory
	 */
	private function _getCssRuleFactory() {
		return $this->_cssRuleFactory;
	}

	/**
	 * @param ffThemeBuilderCssRuleFactory $cssRuleFactory
	 */
	private function _setCssRuleFactory($cssRuleFactory) {
		$this->_cssRuleFactory = $cssRuleFactory;
	}

	/**
	 * @return ffCollection[ffThemeBuilderCssRule]
	 */
	private function _getCssRulesCollection() {
		return $this->_cssRulesCollection;
	}

	/**
	 * @param ffCollection[ffThemeBuilderCssRule] $cssRulesCollection
	 */
	private function _setCssRulesCollection($cssRulesCollection) {
		$this->_cssRulesCollection = $cssRulesCollection;
	}

	/**
	 * @return array
	 */
	private function _getSelectors() {
		return $this->_selectors;
	}

	/**
	 * @return ffCollection
	 */
	private function _getJavascriptCodesCollection() {
		return $this->_javascriptCodesCollection;
	}

	/**
	 * @param ffCollection $javascriptCodesCollection
	 */
	private function _setJavascriptCodesCollection($javascriptCodesCollection) {
		$this->_javascriptCodesCollection = $javascriptCodesCollection;
	}

	/**
	 * @return ffThemeBuilderJavascriptCodeFactory
	 */
	private function _getJavascriptCodeFactory() {
		return $this->_javascriptCodeFactory;
	}

	/**
	 * @param ffThemeBuilderJavascriptCodeFactory $javascriptCodeFactory
	 */
	private function _setJavascriptCodeFactory($javascriptCodeFactory) {
		$this->_javascriptCodeFactory = $javascriptCodeFactory;
	}




}