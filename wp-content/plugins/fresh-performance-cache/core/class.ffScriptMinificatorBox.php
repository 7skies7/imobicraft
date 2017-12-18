<?php

class ffScriptMinificatorBox extends ffBasicObject {
	
	/**
	 *
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	private $_currentBatchName = null;
	
	private $_isInBatch = null;
	
	private $_wpDependendencyList = null;
	
	private $_currentBatchInlineJs = null;
	
	private $_currentBatchIntoFooter = null;
	
	private $_query = null;
	
	private $_batchCounter = null;
	
	private $_minifiedHandlesAll = null;
	
	/**
	 *
	 * @var ffWPLayer
	 */
	private $WPLayer = null;
	
	public function __construct( ffMinificator $minificator ) {
		$this->_setMinificator( $minificator );
		$this->_wpDependendencyList = array();
		$this->_currentBatchInlineJs= '';
		$this->_query = array();
		$this->_batchCounter = 0;
		$this->_minifiedHandlesAll = array();
	}
	
	public function reset() {
		$this->_isInBatch = false;
		$this->_currentBatchName = null;
		$this->_currentBatchIntoFooter = false;
		$this->_currentBatchInlineJs= '';
		$this->_minifiedHandlesAll = array();
	}
	
	public function startBatch( $batchName ) {
		$this->_setCurrentBatchName($batchName);
		$this->_setIsInBatch( true );
		$this->_getMinificator()->startBatchJs( $batchName );
	}
	
	
	public function addMinifiedJs( $script ) {
		if( in_array( $script->handle, $this->_minifiedHandlesAll) ) {
			return;
		}
		
		if( isset( $script->extra['group']) && $script->extra['group'] == 1 ) {
			$this->_currentBatchIntoFooter = true;
		}
		$this->_getMinificator()->addScriptOnlyUrl( $script->src );

		if( isset($script->extra['data']) ) {
			$this->_addInlineJs( $script->extra['data'] );
		}
		
		$this->_minifiedHandlesAll[] = $script->handle;
	
	}
	public function endBatch() {
		$name = $this->_getCurrentBatchName();
		$src = $this->_getMinificator()->proceedBatchJs();
		//$extra = $this->_getInlineCss();
	
		$script = new _WP_Dependency();
		$script->handle = $name;
		$script->src = $src;//.'.gz';
		
		if( $this->_currentBatchIntoFooter ) {
		
			$script->extra['group'] = 1;
		}
		
		if( !empty($this->_currentBatchInlineJs) ) {
			$script->extra['data'] = $this->_currentBatchInlineJs;
		}
		
		$this->_addQuery( $script->handle);
		$this->_addDependency($script);
	
		$this->_currentBatchName = null;
		$this->_isInBatch = false;
		//$this->_wpDependendencyList = array();
		$this->_currentBatchInlineJs = '';
		$this->_currentBatchIntoFooter = false;
		$this->_batchCounter++;
	}
	public function addNonMinifiedJs( $script ) {
		if( in_array( $script->handle, $this->_minifiedHandlesAll) ) {
			return;
		}
		$script->deps = array();
		$this->_addQuery( $script->handle);
		$this->_addDependency($script);
		$this->_minifiedHandlesAll[] = $script->handle;
	}
	
	public function getAllMinifiedHandles() {
		return $this->_minifiedHandlesAll;
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
	
	protected function _addInlineJs( $inlineJs ) {
		
		$this->_currentBatchInlineJs = $this->_currentBatchInlineJs . $inlineJs; //array_merge( $this->_currentBatchInlineCss, $inlineCssArray );
		//var_dump( $this->_currentBatchInlineJs );
	}
	
	protected function _addQuery( $handle ) {
		$this->_query[] = $handle;
	}
	
	protected function _addDependency( $script ) {
		$this->_wpDependendencyList[ $script->handle ] = $script;
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
	 * @return ffScriptMinificatorBox
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