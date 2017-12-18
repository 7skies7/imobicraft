<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_testimonials.html#scrollTo__2874
 * */

class ffElTestimonials6 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials6');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 6', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'testimonials');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'testimonial, review');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Quote', 'ark' ) ) );
				$s->startAdvancedToggleBox('quote', _('Quote Settings') );
					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Aenean adipiscing purus in odio aliquet gravida. Pellentesque convallis metus at venenatis commodo. Aliquam in molestie felis. Etiam in enim lorem.')
						->addParam('print-in-content', true)
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quote-bg-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quote-shadow-color', '', 'rgba(182,193,222,0.3)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Shadow Color', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image', 'ark' ) ) );
				$s->startAdvancedToggleBox('image', _('Image Settings') );
					$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()				
							->setParam('width', 51)
							->setParam('height', 51)
						->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'image-border-size', '', '2')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Size (in px)', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
						;

				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TYPE NAME */
					$s->startRepVariationSection('name', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Jacob Nelson')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'author-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE OCCUPATION */
					$s->startRepVariationSection('occupation', ark_wp_kses( __('Occupation', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Designer')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue('Left','text-left')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}


	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if($query->getColor('image image-border-color') && $query->get('image image-border-size')){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .testimonials-v6-user-picture',false)
				->addParamsString('border: '.$query->get('image image-border-size').'px solid '.$query->getColor('image image-border-color') . ';');
		}

		if($query->getColor('quote quote-shadow-color')){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v6 .testimonials-v6-quote',false)
				->addParamsString('box-shadow: 3px 3px 3px 0 '.$query->get('quote quote-shadow-color').';');
		}

		if($query->getColor('quote quote-shadow-color')){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v6 .testimonials-v6-quote:after',false)
				->addParamsString('filter: drop-shadow(2px 2px 1px '.$query->get('quote quote-shadow-color').');');
		}

		if($query->getColor('quote quote-shadow-color')){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v6 .testimonials-v6-quote:after',false)
				->addParamsString('-moz-filter: drop-shadow(2px 2px 1px '.$query->get('quote quote-shadow-color').');');
		}

		if($query->getColor('quote quote-shadow-color')){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.testimonials-v6 .testimonials-v6-quote:after',false)
				->addParamsString('-webkit-filter: drop-shadow(2px 2px 1px '.$query->get('quote quote-shadow-color').');');
		}

		echo '<section class="testimonials-v6 '. $query->getEscAttr('align') .'">';

			$this->_renderCSSRule('border-top-color', $query->getColor('quote quote-bg-color'), '.testimonials-v6-quote:after');
			$this->_renderCSSRule('background-color', $query->getColor('quote quote-bg-color'), '.testimonials-v6-quote');

			echo '<div class="testimonials-v6-quote">';
				$this->_advancedToggleBoxStart( $query->get('quote') );
					$query->printWpKsesTextarea( 'quote text', '<p class="testimonials-v6-quote-text">', '</p>', '<div class="testimonials-v6-quote-text ff-richtext">', '</div>' );
				$this->_advancedToggleBoxEnd( $query->get('quote') );
			echo '</div>';

			echo '<div class="testimonials-v6-author">';

				if( $query->exists('image') ) {
					$this->_advancedToggleBoxStart( $query->get('image') );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->setParam('width', 51)
							->setParam('height', 51)
							->setParam('css-class', 'testimonials-v6-user-picture')
							->render( $query->get('image') );
					$this->_advancedToggleBoxEnd( $query->get('image') );
				}

				if( $query->exists('content') ){
					echo '<div class="testimonials-v6-element">';
						foreach( $query->get('content') as $oneHeading ) {
							switch ($oneHeading->getVariationType()) {
								case 'name':

									if( $oneHeading->getColor('author-color') ){
										$this->getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector('.testimonials-v6-author',false)
											->addParamsString('color: '.$oneHeading->getColor('author-color').';');
									}
									echo '<h4 class="testimonials-v6-author">';
										$oneHeading->printWpKses('text');
									echo '</h4>';
									break;
								case 'occupation':
									echo '<span class="testimonials-v6-position">';
										$oneHeading->printWpKses('text');
									echo '</span>';
									break;
							}
						}
					echo '</div>';
				}

			echo '</div>';

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.addText('quote text');

				blocks.render('image', query.get('image'));

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'name':
								query.addHeadingLg('text');
								break;
							case 'occupation':
								query.addHeadingSm('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}