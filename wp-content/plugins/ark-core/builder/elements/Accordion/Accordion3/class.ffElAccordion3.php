<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_accordion.html#scrollTo__900
 */

class ffElAccordion3 extends ffElAccordion2 {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'accordion-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Accordion 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'accordion');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'accordion, accordeon');

		$this->_setColor('light');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color':               return '';
			case 'header-bg-color-hover':         return '';
			case 'header-text-color':             return '#ffffff';
			case 'header-text-color-hover':       return '[1]';
			case 'header-handle-color':           return '#ffffff';
			case 'header-handle-color-hover':     return '[1]';
			case 'content-bg-color':              return '';
			case 'content-text-color':            return '#ffffff';
			case 'content-link-text-color':       return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getTextColorSelectors(){
		return array(
			'.panel-title > a' => 'header-text-color',
			'.panel-title > a:before' => 'header-handle-color',

			'.panel-title > a:hover' => 'header-text-color-hover',
			'.panel-title > a[aria-expanded="true"]' => 'header-text-color-hover',

			'.panel-title > a:hover:before' => 'header-handle-color-hover',
			'.panel-title > a[aria-expanded="true"]:before' => 'header-handle-color-hover',

			'.panel-body' => 'content-text-color',
			'.panel-body a' => 'content-link-text-color',
			'.panel-body a:hover' => 'content-link-text-color-hover',
		);
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_renderBasicElement($query, $content, $data, $uniqueId, 3);

	}

}