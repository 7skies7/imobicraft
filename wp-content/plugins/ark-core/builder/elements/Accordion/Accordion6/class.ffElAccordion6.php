<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_accordion.html#scrollTo__1300
 */

class ffElAccordion6 extends ffElAccordion2 {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'accordion-6');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Accordion 6', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'accordion');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'accordion, accordeon');

		$this->_setColor('dark');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color':               return '#ffffff';
			case 'header-bg-color-hover':         return '#ffffff';
			case 'header-text-color':             return '#34343c';
			case 'header-text-color-hover':       return '[1]';
			case 'header-handle-color':           return '#34343c';
			case 'header-handle-color-hover':     return '[1]';
			case 'content-bg-color':              return '#f7f8fa';
			case 'content-text-color':            return '#5d5d5d';
			case 'content-link-text-color':       return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_renderBasicElement($query, $content, $data, $uniqueId, 6);

	}
}