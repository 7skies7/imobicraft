<?php

class ffElSectionTheme extends ffElSection {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'section');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Section');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement(ffOneElement::TYPE_HTML, '', '<div class="hidden">');
			$s->addOption( ffOneOption::TYPE_TEXT, 'tx', '');
		$s->addElement(ffOneElement::TYPE_HTML, '', '</div>');
	}
}