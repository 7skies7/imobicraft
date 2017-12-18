<?php
class ffAdminScreenHeadersViewDefault extends ffAdminScreenCollectionView {

	protected function _init() {
		$this->_itemName = 'header';

		$this->_transTitle = 'Headers';
		$this->_transOptionsName = 'Header Settings';
		$this->_transBuilderName = 'Topbar Builder';
	}

	protected function _getOptionsStructure() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('header')->getElementOptionsStructure(true);
	}

	protected function _nothingSelected() {
		?>
		<div style="padding-top:100px;">
			<h1>Read this before editing</h1>
			<ul>
				<li>- for your comfort, we delivered 15+ predefined headers.</li>
				<li>- most used headers across sites are "Default Classic - Transparent Top" and "Default Header"</li>
				<li style="color:red;">- if you are editing header and dont see any changes after save, <strong>you are editing the wrong (not assigned) header</strong></li>
				<li>- headers are assigned globally in "Sitemap" or locally in post / page writepanels</li>
				<li>- for edit, click on the wished header in left menu</li>
			</ul>
			<br><br>
			<h1>Quick tutorial</h1>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/XxWnihgnMU4" frameborder="0" allowfullscreen></iframe>


		</div>
		<?php
	}

	/**
	 * @return ffOptionsCollection
	 */
	protected function _getItemCollection() {
		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('header');
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

		return $optionsCollection;
		 
	}

}