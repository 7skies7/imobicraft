<?php

class ffStyleMinificatorBox extends ffBasicObject {
	
	/**
	 * 
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	private $_currentBatchName = null;
	
	private $_isInBatch = null;
	
	private $_wpDependendencyList = null;
	
	private $_currentBatchInlineCss = null;
	
	private $_query = null;
	
	private $_batchCounter = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $WPLayer = null;
	
	public function __construct( ffMinificator $minificator ) {
		$this->_setMinificator( $minificator );
		$this->_wpDependendencyList = array();
		$this->_currentBatchInlineCss = array();
		$this->_query = array();	
		$this->_batchCounter = 0;
	}
	
	public function startBatch( $batchName ) {
		$this->_setCurrentBatchName($batchName);
		$this->_setIsInBatch( true );
		$this->_getMinificator()->startBatchCss( $batchName );
	}
	public function addMinifiedCss( $style ) {
		
		$this->_getMinificator()->addStyleOnlyUrl( $style->src );
		
		if( isset($style->extra['after']) ) {
			$this->_addInlineCss( $style->extra['after'] );
		}
		
	}
	public function endBatch() {
		$name = $this->_getCurrentBatchName();
		$src = $this->_getMinificator()->proceedBatchCss();
		$extra = $this->_getInlineCss();
		
		$style = new _WP_Dependency();
		$style->handle = $name;
		$style->src = $src;//.'.gz';
		$style->extra['after'] = $extra;
		$this->_addQuery( $style->handle);
		$this->_addDependency($style);
		
		$this->_currentBatchName = null;
		$this->_isInBatch = false;
		//$this->_wpDependendencyList = array();
		$this->_currentBatchInlineCss = array();
		
		$this->_batchCounter++;
	}
	public function addNonMinifiedCss( $style ) {
		$this->_addQuery( $style->handle);
		$this->_addDependency($style);
	}
	
	public function getBatchCounter() {
		return $this->_batchCounter;
	}
	public function isInBatch() {
		return $this->_isInBatch;
	}
	
	public function getDependencies() {
		return $this->_wpDependendencyList;
	}
	
	public function getQuery() {
		return $this->_query;
	}
	
	protected function _getInlineCss() {
		return $this->_currentBatchInlineCss;
	}
	
	protected function _addInlineCss( $inlineCssArray ) {
		$this->_currentBatchInlineCss = array_merge( $this->_currentBatchInlineCss, $inlineCssArray );
	}
	
	protected function _addQuery( $handle ) {
		$this->_query[] = $handle;
	}
	
	protected function _addDependency( $style ) {
		$this->_wpDependendencyList[ $style->handle ] = $style;
	}
 
	/**
	 * 
	 * @return ffMinificator
	 */
	protected function _getMinificator() {
		return $this->_minificator;
	}
	
	/**
	 * 
	 * @param ffMinificator $minificator
	 * @return ffStyleMinificatorBox
	 */
	protected function _setMinificator(ffMinificator $minificator) {
		$this->_minificator = $minificator;
		return $this;
	}

	protected function _getCurrentBatchName() {
		return $this->_currentBatchName;
	}
	
	protected function _setCurrentBatchName($currentBatchName) {
		$this->_currentBatchName = $currentBatchName;
		return $this;
	}

	protected function _getIsInBatch() {
		return $this->_isInBatch;
	}
	
	protected function _setIsInBatch($isInBatch) {
		$this->_isInBatch = $isInBatch;
		return $this;
	}
	
	
	

}