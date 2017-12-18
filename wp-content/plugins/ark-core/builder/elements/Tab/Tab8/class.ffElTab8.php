<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__2020
 */

class ffElTab8 extends ffElTab1 {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Tabs 8', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'tabs, tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color': return '';
			case 'tab-bg-color': return '#f7f8fa';
			case 'tab-bg-color-hover': return '#34343c';

			case 'tab-text-color': return '#34343c';
			case 'tab-text-color-hover': return '#ffffff';

			case 'content-bg-color': return '';
			case 'content-text-color': return '#606060';
			case 'content-link-text-color': return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getElementColorOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title Colors', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-bg-color', '' , $this->_getDefaultColor('header-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Tab Wrapper', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-bg-color', '' , $this->_getDefaultColor('tab-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Inactive Tab', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-bg-color-hover', '' , $this->_getDefaultColor('tab-bg-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active Tab', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-text-color', '' , $this->_getDefaultColor('tab-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Inactive Tab', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-text-color-hover', '' , $this->_getDefaultColor('tab-text-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Active Tab', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Colors', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '' , $this->_getDefaultColor('content-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '' , $this->_getDefaultColor('content-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color', '' , $this->_getDefaultColor('content-link-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color-hover', '' , $this->_getDefaultColor('content-link-text-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$tab_count_class = 'tab-count-' . $query->get('content')->getNumberOfElements();

		$this->_renderBasicElement($query, $content, $data, $uniqueId, 'nav nav-tabs '.$tab_count_class, 'tab-pane fade', 8);

	}


}