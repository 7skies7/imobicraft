<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_testimonials.html#scrollTo__2539
 * */

class ffElTestimonials5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 5', 'ark' ) ) );
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
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()				
							->setParam('width', 100)
							->setParam('height', 100)
							->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'image-border-size', '', '5')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Size (in px)', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Fred Penner')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'author-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SEPARATOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('separator', ark_wp_kses( __('Separator', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('review', ark_wp_kses( __('Review', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ante pulvinar, malesuada mauris vel, vehicula sapien metus at venenatis.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
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

		echo '<section class="testimonials-v5 '. $query->getEscAttr('align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'image':

						if($oneLine->getColor('image-border-color') && $oneLine->get('image-border-size')){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.testimonials-v5-img',false)
								->addParamsString('border: '.$oneLine->get('image-border-size').'px solid '.$oneLine->getColor('image-border-color') . ';');
						}

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()				
							->setParam('width', 100)
							->setParam('height', 100)
							->setParam('css-class', 'testimonials-v5-img')
							->render( $oneLine );
						break;

					case 'author':
						ffElTestimonials5::_renderColor( $oneLine->getColor('author-color'), 'color' );

						echo '<h4 class="testimonials-v5-author">';
							$oneLine->printWpKses('text');
						echo '</h4>';
						break;

					case 'separator':
						ffElTestimonials5::_renderColor( $oneLine->getColor('separator-color'), 'background-color' );

						echo '<div class="testimonials-v5-separator"></div>';
						break;

					case 'review':
						$oneLine->printWpKsesTextarea( 'text', '<p class="testimonials-v5-quote-text">', '</p>', '<div class="testimonials-v5-quote-text ff-richtext">', '</div>' );
						break;

				}
			}

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'review':
								query.addText('text');
								break;
							case 'separator':
								query.addDivider();
								break;
							case 'author':
								query.addHeadingLg('text');
								break;
							case 'image':
								blocks.render('image', query);
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}