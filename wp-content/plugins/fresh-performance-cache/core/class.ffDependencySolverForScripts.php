<?php

class ffDependencySolverForScripts extends ffDependencySolver {
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
		if( isset($itemInfo->extra['group']) ) {
			$this->_newQueue['footer']['complex'][ $itemName ]['info'] = $itemInfo;
			$this->_newQueue['footer']['names'][] = $itemName;
		} else {
			$this->_newQueue['header']['complex'][ $itemName ]['info'] = $itemInfo;
			$this->_newQueue['header']['names'][] = $itemName;
		}
	}
}