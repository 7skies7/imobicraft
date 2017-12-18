<?php
class ffOptionsHolder_SitePreferencesMetaBox extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()
			->createOneStructure( 'sitepref' );

		$sh = $s->getOptionsStructureHelper();

		$s->startSection('settings');

			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Layout');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'layout', '', 'inherit')
						->addParam('namespace', 'templates')
						->addParam('namespace-name', 'Layouts')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Sitemap', 'inherit', 'System')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can select a Layout for this page or inherit it from <a href="./admin.php?page=SitePreferences" target="_blank">Sitemap</a>.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Header');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'header', '', 'inherit')
						->addParam('namespace', 'header')
						->addParam('namespace-name', 'Headers')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Layout', 'inherit', 'System')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can select a <a href="./admin.php?page=Headers" target="_blank">Header</a> for this page or inherit it from selected Layout.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Titlebar');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'titlebar', '', 'inherit')
						->addParam('namespace', 'titlebar')
						->addParam('namespace-name', 'Titlebars')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Layout', 'inherit', 'System')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can select a <a href="./admin.php?page=TitleBars" target="_blank">Titlebar</a> for this page or inherit it from selected Layout.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Footer');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'footer', '', 'inherit')
						->addParam('namespace', 'footer')
						->addParam('namespace-name', 'Footers')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Layout', 'inherit', 'System')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can select a <a href="./admin.php?page=Footers" target="_blank">Footer</a> for this page or inherit it from selected Layout.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Boxed Wrappers');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'boxed_wrapper', '', 'inherit')
						->addParam('namespace', 'boxed_wrapper')
						->addParam('namespace-name', 'Boxed Wrappers')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Layout', 'inherit', 'System')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can select a <a href="./admin.php?page=Footers" target="_blank">Footer</a> for this page or inherit it from selected Layout.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Post Content Mode');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'builder-printing-mode', '', 'in-content')
						->addSelectValue('Normal Post Content', 'in-content')
						->addSelectValue('Full Body Post Content', 'override-layout')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<strong>Normal Post Content</strong> mode will print the content of this post/page in a normal way, inside the Layout wrappers.');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<strong>Full Body Post Content</strong> mode will remove the body wrappers of a Layout and make your post/page full body. Header, Titlebar and Footer will still be preserved from the selected Layout.');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_END );

		$s->endSection();

		return $s;
	}
}