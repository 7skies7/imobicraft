<?php
class ffAdminScreenBoxedWrappersViewDefault extends ffAdminScreenCollectionView {

	protected function _init() {
		$this->_itemName = 'boxed_wrapper';

		$this->_transTitle = 'Boxed Wrappers';
		$this->_transOptionsName = 'Boxed Wrapper Settings';
		$this->_transBuilderName = 'Boxed Wrapper Builder';

		$this->_hasOptions = true;
		$this->_hasBuilder = false;
	}

	protected function _getOptionsStructure() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('boxed-wrapper')->getElementOptionsStructure(true);
	}

	protected function _nothingSelected() {
		?>
		<div style="padding-top:180px;">
			<h1>Read this before editing</h1>
			<ul>
				<li>- for your comfort, we delivered 8+ predefined footers.</li>
				<li style="color:red;">- if you are editing footer and dont see any changes after save, <strong>you are editing the wrong (not assigned) footer</strong></li>
				<li>- footers are assigned globally in "Sitemap" or locally in post / page writepanels</li>
				<li>- for edit, click on the wished footer in left menu</li>
			</ul>
		</div>
		<?php
	}


	/**
	 * @return ffOptionsCollection
	 */
	protected function _getItemCollection() {
		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('boxed_wrapper');
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