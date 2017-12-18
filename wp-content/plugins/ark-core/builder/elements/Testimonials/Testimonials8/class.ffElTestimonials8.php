<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_2.html#scrollTo__788
 * */

class ffElTestimonials8 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'testimonials-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Testimonials 8', 'ark' ) ) );
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
					/* TYPE SUBTITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'User')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Review')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE QUOTE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('quote', ark_wp_kses( __('Quote', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Ark is the most amazing premium template with powerful customization settings and ultra fully responsive template.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE AUTHOR & OCCUPATION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('author-box', ark_wp_kses( __('Author Box', 'ark' ) ) );

						$s->addOption(ffOneOption::TYPE_SELECT, 'author-align', '', 'right')
							->addSelectValue('Left','left')
							->addSelectValue('Right','right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Author Box Alignment', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('image', esc_attr( __('Image', 'ark' ) ) );
							$this->_getBlock( ffThemeBlConst::IMAGE )
								->imgIsResponsive()				
								->setParam('width', 33)
								->setParam('height', 33)
								->injectOptions( $s )
							;

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'image-border-size', '', '3')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Size (in px)', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('author-name', ark_wp_kses( __('Author Name', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'author', '', 'Alex Nelson')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Full name', 'ark' ) ) )
								;

							$s->endRepVariationSection();

							$s->startRepVariationSection('position', ark_wp_kses( __('Occupation', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Google Inc.')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;

							$s->endRepVariationSection();

						$s->endRepVariationSection();


					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="services-v2">';
		
			echo '<div class="services-v2-testimonials">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'subtitle':

							$this->_applySystemTabsOnRepeatableStart( $oneLine );
								echo '<span class="services-v2-header-subtitle">';
									$oneLine->printWpKses('text');
								echo '</span>';
							$this->_applySystemTabsOnRepeatableEnd( $oneLine );

							break;

						case 'title':

							$this->_applySystemTabsOnRepeatableStart( $oneLine );
								echo '<h3 class="services-v2-header-title">';
									$oneLine->printWpKses('text');
								echo '</h3>';
							$this->_applySystemTabsOnRepeatableEnd( $oneLine );

							break;


						case 'quote':

							$this->_applySystemTabsOnRepeatableStart( $oneLine );
								$oneLine->printWpKsesTextarea( 'text', '<p class="services-v2-testimonials-quote">', '</p>', '<div class="services-v2-testimonials-quote ff-richtext">', '</div>' );
							$this->_applySystemTabsOnRepeatableEnd( $oneLine );


							break;

						case 'author-box':
							
							if($oneLine->getColor('image image-border-color') && $oneLine->get('image image-border-size')){
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector(' .services-v2-testimonials-user-picture',false)
									->addParamsString('border: '.$oneLine->get('image image-border-size').'px solid '.$oneLine->getColor('image image-border-color') . ';');
							}

							if($oneLine->get('author-align')){
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector(' .services-v2-testimonials-user-picture',false)
									->addParamsString('float: '.$oneLine->get('author-align').';');
							}

							echo '<div class="text-'.$oneLine->get('author-align').'">';

							$this->_advancedToggleBoxStart( $oneLine->get('image') );

								$this->_getBlock( ffThemeBlConst::IMAGE )
									->imgIsResponsive()				
									->setParam('width', 33)
									->setParam('height', 33)
									->setParam('css-class', 'services-v2-testimonials-user-picture')
									->render( $oneLine->get('image') );

							$this->_advancedToggleBoxEnd( $oneLine->get('image') );

							if( ! $oneLine->exists('repeated-lines') ){
								continue;
							}

							echo '<div class="services-v2-testimonials-author-body">';

								foreach( $oneLine->get('repeated-lines') as $oneAuthor ) {
									switch( $oneAuthor->getVariationType() ){

										case 'author-name':
											echo '<h4 class="services-v2-testimonials-author">';
												$oneAuthor->printWpKses('author');
											echo '</h4>';
											break;

										case 'position':
											echo '<span class="services-v2-testimonials-author-comp">';
												$oneAuthor->printWpKses('text');
											echo '</span>';
											break;
									}
								}

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
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'subtitle':
								query.addHeadingSm('text');
								break;
							case 'quote':
								query.addText('text');
								break;
							case 'author-box':
								blocks.render('image', query.get('image'));
								if(query.queryExists('repeated-lines')) {
									query.get('repeated-lines').each(function (query, variationType) {
										switch (variationType) {
											case 'author-name':
												query.addHeadingLg('author');
												break;
											case 'position':
												query.addHeadingSm('text');
												break;
										}
									});
								}
								break
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}