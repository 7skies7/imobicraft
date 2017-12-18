<?php
class ffAdminScreenFootersViewDefault extends ffAdminScreenCollectionView {

	protected function _init() {
		$this->_itemName = 'footer';

		$this->_transTitle = 'Footers';
		$this->_transOptionsName = 'Footer Settings';
		$this->_transBuilderName = 'Footer Builder';

		$this->_hasOptions = false;
	}

	protected function _getOptionsStructure() {
		return null;
	}

	protected function _nothingSelected() {
		?>
		<div style="padding-top:100px;">
			<h1>Read this before editing</h1>
			<ul>
				<li>- for your comfort, we delivered 8+ predefined footers.</li>
				<li style="color:red;">- if you are editing footer and dont see any changes after save, <strong>you are editing the wrong (not assigned) footer</strong></li>
				<li>- footers are assigned globally in "Sitemap" or locally in post / page writepanels</li>
				<li>- for edit, click on the wished footer in left menu</li>
			</ul>
			<br><br>
			<h1>Quick tutorial</h1>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/27Ua1fpAkPY" frameborder="0" allowfullscreen></iframe>
		</div>
		<?php
	}


	/**
	 * @return ffOptionsCollection
	 */
	protected function _getItemCollection() {
		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('footer');
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