<?php

class ffSitePreferencesFactory extends ffFactoryAbstract {

	public function getSitePreferencesManager() {
		return new ffSitePreferencesManager();
	}

	public function getSiteMapper() {
		return new ffSiteMapper();
	}

	private $_viewDataManager = null;
	public function getViewDataManager() {
		if( $this->_viewDataManager == null ) {
			$this->_viewDataManager =new ffViewDataManager();
		}
		return $this->_viewDataManager;
	}

//	public function getItemPartHeaderCollection() {
//		return new ffItemPartCollection_Header();
//	}

//	public function getItemPartCollection( $type = 'header' ) {
//		$collection = null;
//		switch( $type ) {
//			case 'header':
//				$collection = $collection = $this->getItemPartHeaderCollection();
//				break;
//		}
//
//		return $collection;
//	}

}