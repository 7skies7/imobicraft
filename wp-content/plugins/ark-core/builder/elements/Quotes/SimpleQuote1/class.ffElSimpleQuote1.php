<?php

/**
 * @link
 */

class ffElSimpleQuote1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-quote-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Simple Quote 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'quote');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'simple quote 1');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Quote Char', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXT,'quote','','&rdquo;')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXTAREA,'text','','Fusce et lobortis dolor. Aliquam velit odio, viverra in nunc in, laoreet eleifend dolor.')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Color', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '[1]')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'align','','text-left')
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

		ffElSimpleQuote1::_renderColor( $query->getColor('color'), 'color' );
		ffElSimpleQuote1::_renderColor( $query->getColor('color'), 'background-color', 'blockquotes-v1:after');

		echo '<blockquote class="blockquotes-v1 '. $query->getEscAttr('align') .'">';
			echo '<span class="blockquotes-v1-o">'. $query->getWpKses('quote') .'</span>';
			$query->printWpKses('text');
		echo '</blockquote>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				query.addHeadingSm( 'quote' );
				query.addText( 'text' );

			}
		</script data-type="ffscript">
	<?php
	}


}