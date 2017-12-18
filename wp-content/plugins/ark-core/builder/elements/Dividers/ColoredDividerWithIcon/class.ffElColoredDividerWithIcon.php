<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__1050
 */

class ffElColoredDividerWithIcon extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'colored-divider-with-icon');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider With Icon 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, colored divider with icon, separator');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type-line', '', '')
					->addSelectValue( esc_attr( __('Dashed', 'ark' ) ), '-dashed')
					->addSelectValue( esc_attr( __('Dotted', 'ark' ) ), '-dotted')
					->addSelectValue( esc_attr( __('Double', 'ark' ) ), '-double')
					->addSelectValue( esc_attr( __('Solid', 'ark' ) ), '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'alignment', '', 'center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alignment', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-star')
					->addParam('print-in-content', true)
				;

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-full', ark_wp_kses( __('Make the divider full width', 'ark' ) ), 0);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#e55973')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#e55973')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$border_color_selectors = array(
			' span.before' => 'divider-color',
			' span.after' => 'divider-color',
		);

		$color_selectors = array(
			' .divider-v5-element-icon' => 'icon-color',
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

		echo '<section class="divider-v5 text-'. $query->getEscAttr('alignment') .'">';

			$fullWidth = '';
			if( $query->get('is-full') ){
				$fullWidth = $query->getEscAttr('alignment').'-wrap';
			}

			echo '<p class="divider-v5-element divider-v5-element-'. $query->getEscAttr('alignment') . $query->getEscAttr('type-line') .' '.$fullWidth .'">';
				echo '<span class="before"></span>';
					echo '<i class="divider-v5-element-icon '. $query->getEscAttr('icon') .'"></i>';
				echo '<span class="after"></span>';
			echo '</p>';

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