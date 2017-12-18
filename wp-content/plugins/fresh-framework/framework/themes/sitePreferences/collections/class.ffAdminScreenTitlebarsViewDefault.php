<?php
class ffAdminScreenTitlebarsViewDefault extends ffAdminScreenCollectionView {

	protected function _init() {
		$this->_itemName = 'titlebar';

		$this->_transTitle = 'Titlebars';
		$this->_transOptionsName = 'Titlebar Settings';
		$this->_transBuilderName = 'Titlebar Builder';

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
				<li>- for your comfort, we delivered 2 predefined titlebars.</li>
				<li style="color:red;">- if you are editing titlebar and dont see any changes after save, <strong>you are editing the wrong (not assigned) titlebar</strong></li>
				<li>- titlebars are assigned globally in "Sitemap" or locally in post / page writepanels</li>
				<li>- for edit, click on the wished titlebar in left menu</li>
			</ul>
			<br><br>
			<h1>Quick tutorial</h1>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/72Ec8TxIBPw" frameborder="0" allowfullscreen></iframe>
		</div>
		<?php
	}


	/**
	 * @return ffOptionsCollection
	 */
	protected function _getItemCollection() {
		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('titlebar');
		$optionsCollection->addDefaultItemCallback('titlebar_default', function(){

			$defaultItem = array();
			$defaultItem['name'] = 'Default Titlebar';
			$defaultItem['options'] = null;
			$defaultItem['builder'] = '[ffb_section_0][/ffb_section_0]';

			return $defaultItem;
		});



		return $optionsCollection;
	}

}