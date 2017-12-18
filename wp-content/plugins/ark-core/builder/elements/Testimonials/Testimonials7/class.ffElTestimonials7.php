<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__4329
 * */

class ffElTestimonials7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 7', 'ark' ) ) );
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

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )
							->setParam('default', array('md'=>4))
							->setParam('toggle', 'Column Width')
							->setParam('use-toggle', true)
							->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'sign', '', '&ldquo;')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sign', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', ark_wp_kses( __('Our Clients are our first Priority', 'ark' ) ) )
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Quote and Author', 'ark' ) ) );
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )
							->setParam('default', array('md'=>8))
							->setParam('toggle', 'Column Width')
							->setParam('use-toggle', true)
							->injectOptions( $s )
						;

						$s->startAdvancedToggleBox('quote', esc_attr( __('Quote', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'quote-text', '', 'Built on the principles of excellence. For all the things you want to do. For the things you love. Ark makes your design last forever. It\'s a Smart Template for Creatives.')
								->addParam('print-in-content', true)
							;
						$s->endAdvancedToggleBox();

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'full-name', '', 'Alex Nelson')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Author Name', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'author-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Author Name Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $space = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->setAddWhiteSpaceBetweenSelectors($space)
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

		echo '<section class="testimonials-v7">';
			echo '<div class="row">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'title':
							echo '<div class="'. $this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .'">';

								$toPrint = '<h2 class="testimonials-v7-title">';
									$toPrint .= '<span class="sign">';
										$toPrint .= $oneLine->getWpKses('sign');
									$toPrint .= '</span>';
									$toPrint .= '<span class="testimonials-v7-title-span">';
										$toPrint .= $oneLine->getWpKses('text');
									$toPrint .= '</span>';
								$toPrint .= '</h2>';

								$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
								// Escaped title
								echo ( $toPrint );

							echo '</div>';
							break;

						case 'author':
							echo '<div class="'. $this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .' testimonials-v7-quote-block">';

								$this->_advancedToggleBoxStart( $oneLine->get('quote') );
									$oneLine->printWpKsesTextarea( 'quote quote-text', '<p class="testimonials-v7-text">', '</p>', '<div class="testimonials-v7-text ff-richtext">', '</div>' );
								$this->_advancedToggleBoxEnd( $oneLine->get('quote') );

								ffElTestimonials7::_renderColor( $oneLine->getColor('author-color'), 'color' );
								ffElTestimonials7::_renderColor( $oneLine->getColor('author-color'), 'background', '.testimonials-v7-author:before', false );

								$toPrint = '<h4 class="testimonials-v7-author">';
									$toPrint .= $oneLine->getWpKses('full-name');
								$toPrint .= '</h4>';

								$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
								// Escaped author
								echo ( $toPrint );

							echo '</div>';
							break;

					}
				}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('sign');
								query.addHeadingSm('text');
								break;
							case 'author':
								query.addText('quote quote-text');
								query.addHeadingLg('full-name');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}