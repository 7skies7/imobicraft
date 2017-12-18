<?php

/**
 * @link
 */

class ffElSimpleQuote4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'simple-quote-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Simple Quote 4', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'quote');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'simple quote 4');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXTAREA,'text','','Quisque lobortis luctus sodales. Donec placerat turpis quis ultricies tincidunt. Morbi eget pulvinar nibh. Donec lorem ipsum, laoreet sed pellentesque sed, lobortis eget ligula. Maecenas vel magna varius, venenatis lorem et, vehicula lacus.')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Author', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXT,'author','','Adelya Nh.')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'before-color', '', '#cbcbcb')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Before text divider', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'after-color', '', '#cbcbcb')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('After text divider', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'align','','text-center')
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
				->addParamsString( $cssAttribute .': '. $query .' ;');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		ffElSimpleQuote4::_renderColor( $query->getColor('before-color'), 'background-color', 'blockquotes-v4-text:before' );
		ffElSimpleQuote4::_renderColor( $query->getColor('after-color'), 'background-color', 'blockquotes-v4-text:after' );

		echo '<blockquote class="blockquotes-v4 '. $query->getEscAttr('align') .'">';
			$query->printWpKsesTextarea( 'text', '<p class="blockquotes-v4-text">', '</p>', '<div class="blockquotes-v4-text ff-richtext">', '</div>' );
			echo '<span class="blockquotes-v4-by">'. $query->getWpKses('author') .'</span>';
		echo '</blockquote>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				query.addText( 'text' );
				query.addHeadingSm( 'author' );

			}
		</script data-type="ffscript">
	<?php
	}


}