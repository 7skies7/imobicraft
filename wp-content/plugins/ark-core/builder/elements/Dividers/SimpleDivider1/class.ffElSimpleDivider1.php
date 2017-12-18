<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__1450
 */

class ffElSimpleDivider1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-divider-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, simple divider 1, separator');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'divider-size', '', 'medium')
					->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'small')
					->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'medium')
					->addSelectValue( esc_attr( __('Full Width', 'ark' ) ), 'fullwidth')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type-line', '', 'solid')
					->addSelectValue( esc_attr( __('Solid', 'ark' ) ), 'solid')
					->addSelectValue( esc_attr( __('Dashed', 'ark' ) ), 'dashed')
					->addSelectValue( esc_attr( __('Dotted ', 'ark' ) ), 'dotted')
					->addSelectValue( esc_attr( __('Double', 'ark' ) ), 'double')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'divider-alignment', '', 'center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alignment', 'ark' ) ) )
				;
				
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-bold', ark_wp_kses( __('Make the divider thicker', 'ark' ) ), 0);

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#c4c4c4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$border_color_selectors = array(
			' .divider-v7-title span.after' => 'divider-color',
			' .divider-v7-title span.after:after' => 'divider-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ' !important;');
			}
		}

		$bold = '';
		if( $query->get('use-bold') ) {
			$bold = 'divider-weight-bold';
		}

		echo '<section class="divider-v7 divider-alignment-'. $query->getEscAttr('divider-alignment') .' divider-size-'. $query->getEscAttr('divider-size') .' '. $bold .' ">';

			$width = '';
			if( 'fullwidth' == $query->get('divider-size') ) {
				$width = 'full-width';
			}

			echo '<div class="divider-v7-title divider-v7-title-'. $query->getEscAttr('type-line') .' '. $width .'"><span class="after"></span></div>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				query.addDivider();

			}
		</script data-type="ffscript">
	<?php
	}


}