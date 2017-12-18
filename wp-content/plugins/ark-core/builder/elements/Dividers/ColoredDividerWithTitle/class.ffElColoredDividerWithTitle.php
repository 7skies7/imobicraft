<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__1900
 */

class ffElColoredDividerWithTitle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'colored-divider-with-title');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Divider With Title 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'divider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'divider, colored divider with title, separator');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Settings', 'ark' ) ));
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-alignment', '', 'center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alignment', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'This is Awesome')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'design', '', 'text-with-r-border')
					->addSelectValue( esc_attr( __('None', 'ark' ) ), 'text')
					->addSelectValue( esc_attr( __('Square Border', 'ark' ) ), 'text-with-border')
					->addSelectValue( esc_attr( __('Rounded Border', 'ark' ) ), 'text-with-r-border')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Border Type', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type-line', '', '')
					->addSelectValue( esc_attr( __('Dashed', 'ark' ) ), 'dashed')
					->addSelectValue( esc_attr( __('Dotted', 'ark' ) ), 'dotted')
					->addSelectValue( esc_attr( __('Double line', 'ark' ) ), 'double')
					->addSelectValue( esc_attr( __('Solid', 'ark' ) ), '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Border Style', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#e55973')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#e55973')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-border-color', '', '#e55973')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Border', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$background_color_selectors = array(
			'.divider-v6 .divider-v6-element .before, .divider-v6 .divider-v6-element .after' => 'divider-color',
		);

		$border_color_selectors = array(
			'.divider-v6 .divider-v6-element-title.divider-v6-element-title-brd' => 'text-border-color',
		);

		$color_selectors = array(
			'.divider-v6 .divider-v6-element-title' => 'text-color',
		);

		foreach( $background_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

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

		echo '<section class="divider-v6 text-'. $query->getEscAttr('text-alignment') .'">';
			$class = '';
			switch( $query->get('design') ) {

				case 'text-with-border':
					$class = 'divider-v6-element-title-brd '. $query->getEscAttr('type-line');
					break;

				case 'text-with-r-border':
					$class = 'divider-v6-element-title-brd '. $query->getEscAttr('type-line') .' radius-50';
					break;
			}

			echo '<div class="divider-v6-element divider-v6-element-'. $query->getEscAttr('text-alignment') .'">';
				echo '<span class="before"></span>';
					echo '<h2 class="divider-v6-element-title '. $class .'">';
						$text = $query->get('text');
						if( empty($text) ){
							$text = '&nbsp;';
						}
						echo ark_wp_kses( $text );
					echo '</h2>';
				echo '<span class="after"></span>';
			echo '</div>';

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