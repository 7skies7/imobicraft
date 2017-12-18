<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__2544
 */

class ffElSimpleDividerWithIcon extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-divider-with-icon');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider With Icon 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, simple divider with icon, separator');
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

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-skyatlas')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#c4c4c4')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$border_color_selectors = array(
			' .divider-with-icon-1-element-type:before' => 'divider-color',
			' .divider-with-icon-1-element-type:after' => 'divider-color',
		);

		$color_selectors = array(
			' .divider-with-icon-1-element-type i' => 'icon-color',
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

		echo '<section class="divider-v'. $query->getEscAttr('type-line') .' divider-with-icon-1-type">';
			echo '<div class="divider-v'. $query->getEscAttr('type-line') .'-element divider-with-icon-1-element-type">';
				echo '<i class="divider-v'. $query->getEscAttr('type-line') .'-icon '. $query->getEscAttr('icon') .'"></i>';

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				query.addIcon( 'icon' );
				query.addDivider();

			}
		</script data-type="ffscript">
	<?php
	}


}