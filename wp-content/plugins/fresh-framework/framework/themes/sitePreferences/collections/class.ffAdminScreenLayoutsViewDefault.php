<?php
class ffAdminScreenLayoutsViewDefault extends ffAdminScreenCollectionView {

	protected function _init() {
		$this->_itemName = 'templates';

		$this->_transTitle = 'Layouts';
		$this->_transOptionsName = 'Layouts Settinsg';
		$this->_transBuilderName = 'Layouts Builder';


//		$this->_hasOptions = false;
	}

	protected function _getOptionsStructure() {
		$fwc = ffContainer();
		return $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_SitePreferences')->getOptions();;
	}


	protected function _nothingSelected() {

		return;

	}


	/**
	 * @return ffOptionsCollection
	 */
	protected function _getItemCollection() {
		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('templates');
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

//		$optionsCollection->addDefaultItemCallback('header_default_2', function(){
//
//			$defaultItem = array();
//			$defaultItem['name'] = 'Default Header 2';
//			$defaultItem['options'] = null;
//			$defaultItem['builder'] = '[ffb_section_0][/ffb_section_0]';
//
//			return $defaultItem;
//		});

		return $optionsCollection;
	}



}