<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_slider_block.html#scrollTo__550
 */

class ffElSlider2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'slider-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Slider 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE SLIDE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('slide', ark_wp_kses( __('Slide', 'ark' ) ));

						/* TYPE ORDER */
						$s->startAdvancedToggleBox('title', esc_attr( __('Nav Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'order', '', '01')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ));
							$s->startRepVariableSection('labels');

								/* TYPE SUB-TITLE */
								$s->startRepVariationSection('sub-title', ark_wp_kses( __('Subtitle', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Our clients are')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
									;
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '[1]')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
									;
								$s->endRepVariationSection();

								/* TYPE TITLE */
								$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Our First Priority')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
									;
								$s->endRepVariationSection();

								/* TYPE DESCRIPTION */
								$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ipsum mi, rhoncus a suscipit in, finibus vel leo. Suspendisse potenti. Morbi vestibulum, lectus ut viverra congue, massa velit elementum arcu, vel vestibulum neque magna vel erat.')
										->addParam('print-in-content', true)
									;
								$s->endRepVariationSection();

								/* TYPE LINK */
								$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Read More')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

									$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
								$s->endRepVariationSection();

							$s->endRepVariableSection();

						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark') ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Button Color', 'ark') ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Button Color Hover', 'ark') ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-item', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Nav Item', 'ark') ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-item-active', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Nav Item Active', 'ark') ) );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<section class="slider-block-v1">';
			echo '<div id="'.$uniqueId.'" class="carousel slide carousel-fade" data-ride="carousel">';

				echo '<div class="carousel-inner" role="listbox">';

					foreach( $query->get('content') as $key => $oneSlide ) {

						$active = '';
						if( 0 == $key ){
							$active = 'active';
						}

						echo '<div class="item '. $active .'">';
							$this->_advancedToggleBoxStart( $oneSlide->get('content') );
								echo '<div>';

									foreach( $oneSlide->get('content labels') as $oneLabel ) {
										switch( $oneLabel->getVariationType() ) {

											case 'sub-title':

												$this->_renderCSSRuleImportant('color', $oneLabel->getColor('text-color'), null, true );

												echo '<span class="slider-block-v1-subtitle">'. $oneLabel->getWpKses('text') .'</span>';
												break;

											case 'title':
												echo '<h2 class="slider-block-v2-media-title">'. $oneLabel->getWpKses('text') .'</h2>';
												break;

											case 'description':
												$oneLabel->printWpKsesTextarea( 'text', '<p class="slider-block-v1-paragraph">', '</p>', '<div class="slider-block-v1-paragraph ff-richtext">', '</div>' );
												break;

											case 'link':
												echo '<a ';
												$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'slider-block-v1-link-btn')->render( $oneLabel );
												echo '>' . $oneLabel->getWpKses('text') . '</a>';
												break;

										}
									}

								echo '</div>';
							$this->_advancedToggleBoxEnd( $oneSlide->get('content') );
						echo '</div>';
					}

				echo '</div>';

			echo '<ol class="carousel-indicators theme-carousel-indicators-v3">';

				foreach( $query->get('content') as $key => $oneSlide ) {

					$active = '';
					if( 0 == $key ){
						$active = 'class="active"';
					}

					$this->_advancedToggleBoxStart( $oneSlide->get('title') );
					echo '<li data-target="#'.$uniqueId.'" data-slide-to="'. $key .'" '. $active .'>'. $oneSlide->getWpKses('title order') .'</li>';
					$this->_advancedToggleBoxEnd( $oneSlide->get('title') );

				}

			echo '</ol>';

			echo '</div>';
		echo '</section>';


		if( $query->getColor('nav-item') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li:not(.active)', false)
				->addParamsString('color: '.$query->getColor('nav-item').';');
		}

		if( $query->getColor('nav-item') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li:not(.active)', false)
				->addParamsString('border-bottom-color: '.$query->getColor('nav-item').';');
		}

		if( $query->getColor('nav-item-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li.active', false)
				->addParamsString('color: '.$query->getColor('nav-item-active').';');
		}

		if( $query->getColor('nav-item-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li:hover', false)
				->addParamsString('color: '.$query->getColor('nav-item-active').';');
		}

		if( $query->getColor('nav-item-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li.active', false)
				->addParamsString('border-bottom-color: '.$query->getColor('nav-item-active').';');
		}

		if( $query->getColor('nav-item-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v1 .carousel .carousel-indicators li:hover', false)
				->addParamsString('border-bottom-color: '.$query->getColor('nav-item-active').';');
		}


		if( $query->getColor('link-btn-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .slider-block-v1-link-btn', false)
				->addParamsString('color: '.$query->getColor('link-btn-color').';');
		}

		if( $query->getColor('link-btn-color-hover') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .slider-block-v1-link-btn:hover', false)
				->addParamsString('color: '.$query->getColor('link-btn-color-hover').';');
		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {

							case 'slide':

								// query.get('title').addText('order');

								query.get('content').get('labels').each(function (query, variationType) {
									switch (variationType) {
										 case 'sub-title':
										 	query.addHeadingSm('text');
										 	break;

										case 'title':
											query.addHeadingLg('text');
											break;

										 case 'description':
										 	query.addText('text');
										 	break;

										 case 'link':
										 	query.addLink('text');
										 	break;
									}
								});
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}