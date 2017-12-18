<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__1729
 */

class ffElTab6 extends ffElTab5 {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-6');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Vertical Tabs 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'tabs, tab, vertical tab, vertical tabs');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_renderBasicElement($query, $content, $data, $uniqueId, 'nav nav-tabs nav-tabs-right', 'tab-pane fade', 6);

	}


}