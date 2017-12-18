<?php

class ffElTestimonials11 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials11');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 11', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'testimonials');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'testimonial, review');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					$s->startRepVariationSection('character', ark_wp_kses( __('Character', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'character', '', '&ldquo;')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Character', 'ark' ) ) );
					$s->endRepVariationSection();

					$s->startRepVariationSection('text', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', ark_wp_kses( __('Ark is the most amazing premium template with powerful customization settings and ultra fully responsive template with modern and smart design.', 'ark' ) ) )
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Author', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'full-name', '', '&mdash; Kenny Johnson')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Full name', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<section class="testimonials-v11">';
			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'character':
						echo '<span class="quote-mark">';
						echo ark_wp_kses( $oneLine->get('character') );
						echo '</span>';
						break;

					case 'text':
						echo '<span class="quote">';
						echo ark_wp_kses( $oneLine->get('text') );
						echo '</span>';
						break;

					case 'author':
						echo '<div class="author">';
						echo ark_wp_kses( $oneLine->get('full-name') );
						echo '</div>';
						break;
				}
			}
		echo '</section>';
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'character':
								query.addHeadingLg('character');
								break;
							case 'text':
								query.addText('text');
								break;
							case 'author':
								query.addHeadingSm('full-name');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
		<?php
	}
}