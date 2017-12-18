<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__2020
 */

class ffElTab7 extends ffElTab1 {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Tabs 7', 'ark' ) ) );
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
			case 'tab-bg-color': return '#34343c';
			case 'tab-bg-color-hover': return '#ffffff';

			case 'tab-text-color': return '#ffffff';
			case 'tab-text-color-hover': return '#34343c';

			case 'tab-border-color': return '#f7f8fa';
			case 'tab-border-color-top': return '#34343c';

			case 'content-bg-color': return '#ffffff';
			case 'content-text-color': return '#606060';
			case 'content-link-text-color': return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getTextColorSelectors(){
		return array(
			'.nav.nav-tabs > li > a' => 'tab-text-color',

			'.nav.nav-tabs > li.active > a' => 'tab-text-color-hover',

			'.tab-content .tab-pane' => 'content-text-color',
			'.tab-content .tab-pane p' => 'content-text-color',
			'.tab-content .tab-pane a' => 'content-link-text-color',
			'.tab-content .tab-pane a:hover' => 'content-link-text-color-hover',
		);
	}

	protected function _getBGColorSelectors(){
		return array(
			'.nav-wrapper' => 'header-bg-color',

			'.nav.nav-tabs > li > a' => 'tab-bg-color',
			'.nav.nav-tabs > li.active a' => 'tab-bg-color-hover',

			'.tab-content .tab-pane' => 'content-bg-color',
		);
	}

	protected function _getElementColorOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Tabs Colors', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-border-color', '' , $this->_getDefaultColor('tab-border-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Tabs and Content Border', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

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

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-border-color-top', '' , $this->_getDefaultColor('tab-border-color-top'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Top - Active Tab', 'ark' ) ) );

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

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Tabs', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TAB
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('accordion', ark_wp_kses( __('Tab', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Is opened by default', 'ark' ) ), 0);
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('You can only activate this option on one of the tabs.', 'ark' ) ) ) ;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Section 1')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'content', '', ark_wp_kses( __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus maximus gravida efficitur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris lacinia tristique sapien, sed ornare arcu rhoncus in.', 'ark' ) ) )
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'text-alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_getElementColorOptions($s);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}


	protected function _createCssColorsBorderRules(ffOptionsQueryDynamic $query) {

		$sel = array(
			'.tab-v7 .nav-tabs > li > a' => array( 'tab-border-color', 'border-color'  ),
			'.tab-v7 > .tab-content > .tab-pane' => array( 'tab-border-color', 'border-color',),
			'.tab-v7 .nav-tabs > li.active > a' => array( 'tab-border-color-top', 'border-top-color'),
		);

		foreach( $sel as $selector => $c ){
			$color = $query->getColor( $c[0] );
			$attr = $c[1];
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->addSelector($selector)
					->addParamsString( $attr . ':' . $color . ';');
			}
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_createCssColorsBorderRules($query);

		$this->_renderBasicElement($query, $content, $data, $uniqueId, 'nav nav-tabs', 'tab-pane fade', 7);

	}


}