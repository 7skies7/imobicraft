<?php

class ffDependencySolver extends ffBasicObject {
	protected $_alreadyAdded = null;
	protected $_dependencyList = null;
	protected $_newQueue = null;
	
	public function getNewQueue( $oldQueue, $dependencyList ) {
		$this->_alreadyAdded = array();
		$this->_dependencyList = $dependencyList;
		$this->_newQueue = array();
		
		foreach( $oldQueue as $oneItem ) {
			$this->_processQueuedItem( $oneItem );
		}
		
		return $this->_newQueue;
	}
	
	protected function _hasBeenItemQueried( $itemName ) {
		if( isset( $this->_alreadyAdded[ $itemName ] ) ) {
			return true;
		} else {
			$this->_alreadyAdded[ $itemName ] = true;
			return false;
		}
	}
	
	protected function _processQueuedItem( $itemName ) {
		if( $this->_hasBeenItemQueried($itemName) ) {
			return;
		}
		
		$itemInfo = $this->_getItemInfo($itemName);
		if( !empty( $itemInfo->deps ) ) {
			foreach( $itemInfo->deps as $oneDependencyName ) {
				$this->_processQueuedItem( $oneDependencyName );
			}
		}
		
		$this->_newQueue['complex'][ $itemName ]['info'] = $itemInfo;
		$this->_newQueue['names'][] = $itemName;
			
	}
	
	protected function _getItemInfo( $itemName ) {
		if( isset( $this->_dependencyList[ $itemName ] ) ) {
			return $this->_dependencyList[ $itemName ];
		} else {
			return false;
		}
	}
}