<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__2650
 */

class ffElSimpleDividerWithTitle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-divider-with-title');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider With Title 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, simple divider with title, separator');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type-line', '', '1')
					->addSelectValue( esc_attr( __('Dashed', 'ark' ) ), '2')
					->addSelectValue( esc_attr( __('Dotted', 'ark' ) ), '3-5')
					->addSelectValue( esc_attr( __('Double', 'ark' ) ), '3')
					->addSelectValue( esc_attr( __('Solid', 'ark' ) ), '1')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'design', '', 'text')
					->addSelectValue( esc_attr( __('Text', 'ark' ) ), 'text')
					->addSelectValue( esc_attr( __('Text with Background Color', 'ark' ) ), 'text-with-bg')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Type', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Fancy Title')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#c4c4c4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#333333')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-background-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Background', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$border_color_selectors = array(
			'.divider-with-title-1-type > div:before' => 'divider-color',
			'.divider-with-title-1-type > div:after' => 'divider-color',
		);

		$color_selectors = array(
			'.divider-with-title-1-type > div' => 'text-color',
		);

		$bg_color_selectors = array(
			'.divider-with-title-1-type > .has-text-bg' => 'text-background-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		foreach( $color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		echo '<section class="divider-v'. $query->getEscAttr('type-line') .' divider-with-title-1-type">';

			$text = $query->get('text');
			if( empty($text) ){
				$text = '&nbsp;';
			}

			switch( $query->get('design') ) {

				case 'text':
					echo '<div class="divider-v'. $query->getEscAttr('type-line') .'-element">';
						echo ark_wp_kses( $text );
					echo '</div>';
					break;

				case 'text-with-bg':
					echo '<div class="divider-v'. $query->getEscAttr('type-line') .'-element divider-v'. $query->getEscAttr('type-line') .'-element-bg radius-50 has-text-bg">';
						echo ark_wp_kses( $text );
					echo '</div>';
					break;
			}



		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				query.addHeadingLg( 'text' );
				query.addDivider();

			}
		</script data-type="ffscript">
	<?php
	}


}