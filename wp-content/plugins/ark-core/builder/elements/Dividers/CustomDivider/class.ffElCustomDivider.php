<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__1450
 */

class ffElCustomDivider extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'custom-divider');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider Custom', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, simple divider, separator, custom divider, divider custom');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider', 'ark' ) ) );

				$s->startAdvancedToggleBox('divider', 'Divider');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Use the "pencil" icon above to size and style your Divider.', 'ark' ) ) );
				$s->endAdvancedToggleBox('divider');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'divider-alignment', '', 'center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alignment', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$color_selectors = array(
			' .divider-custom-line' => 'divider-color',
		);

		foreach( $color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . '');
			}
		}

		echo '<section class="divider-custom divider-alignment-'. $query->getEscAttr('divider-alignment') .' ">';

			$this->_advancedToggleBoxStart( $query, 'divider' );
			echo '<div class="divider-custom-line"></div>';
			$this->_advancedToggleBoxEnd( $query, 'divider' );

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