<?php

/**
 * @link
 */

class ffElSimpleQuote2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-quote-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Simple Quote 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'quote');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'simple quote 2');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXTAREA,'text','','Sed tinci dunt odiosedeg semper max lectus')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Color', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#e55973')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'align','','text-right')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->setAddWhiteSpaceBetweenSelectors(false)
				->addParamsString( $cssAttribute .': '. $query .' ;');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		ffElSimpleQuote2::_renderColor( $query->getColor('color'), 'color' );
		ffElSimpleQuote2::_renderColor( $query->getColor('color'), 'border-right-color');

		echo '<blockquote class="blockquotes-v2 '. $query->getEscAttr('align') .'">';
			$query->printWpKses('text');
		echo '</blockquote>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				query.addText( 'text' );

			}
		</script data-type="ffscript">
	<?php
	}


}