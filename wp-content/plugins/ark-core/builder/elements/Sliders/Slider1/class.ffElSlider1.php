<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_slider_block.html#
 */

class ffElSlider1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'slider-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Slider 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE SLIDE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('slide', ark_wp_kses( __('Slide', 'ark' ) ));

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->setParam('width', 200)
							->setParam('height', 113)
							->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('labels');

							/* TYPE TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Our clients are our first priority.')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();

							/* TYPE DESCRIPTION */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis, sapien vitae sollicitudin viverra, odio purus aliquam ipsum, vel ultrices mi ante ac nibh. Fusce dignissim finibus venenatis. Aenean quis felis neque. Mauris cursus ex nunc, vel pellentesque sem ornare et.')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();

							/* TYPE LINK */
							$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'View More')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Navigation Dots', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'dot-size', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Dot Size (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dot-bg', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dot-bg-active', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Background Active', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dot-border', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Border', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dot-border-active', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Dot Border Active', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Button Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Button Color Hover', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="slider-block-v2">';
			echo '<div id="'.$uniqueId.'" class="carousel slide carousel-fade" data-ride="carousel">';

				echo '<div class="carousel-inner" role="listbox">';

					foreach( $query->get('content') as $key => $oneSlide ) {

						$active = '';
						if( 0 == $key ){
							$active = 'active';
						}

						echo '<div class="item '. $active .'">';
							echo '<div class="slider-block-v2-content">';

								echo '<div class="slider-block-v2-widget">';
									$this->_getBlock( ffThemeBlConst::IMAGE )
										->setParam('width', 200)
										->setParam('height', 113)
										->setParam('css-class', 'slider-block-v2-content-img')
										->render( $oneSlide );
								echo '</div>';

								echo '<div class="slider-block-v2-media">';

									foreach( $oneSlide->get('labels') as $oneLabel ) {
										switch( $oneLabel->getVariationType() ) {

											case 'title':
												echo '<h2 class="slider-block-v2-media-title">'. $oneLabel->getWpKses('text') .'</h2>';
												break;

											case 'description':
												$oneLabel->printWpKsesTextarea( 'text', '<p class="slider-block-v2-text">', '</p>', '<div class="slider-block-v2-text ff-richtext">', '</div>' );
												break;

											case 'link':
												echo '<a ';
													// escaped link
													echo ( $this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'slider-block-v2-link-btn')->render( $oneLabel ) );
												echo '>';
												$oneLabel->printWpKses('text');
												echo '</a>';
												break;

										}
									}

								echo '</div>';

							echo '</div>';
						echo '</div>';

					}

				echo '</div>';

				echo '<ol class="carousel-indicators theme-carousel-indicators-v2">';

					foreach( $query->getWithoutCallbacks('content') as $key => $oneSlider ) {

						$active = '';
						if( 0 == $key ){
							$active = 'class="active"';
						}

						echo '<li data-target="#'.$uniqueId.'" data-slide-to="'. $key .'" '. $active .'></li>&nbsp;';

					}

				echo '</ol>';

			echo '</div>';
		echo '</section>';

		$size = absint( $query->get('dot-size') );

		if( $size ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .carousel .theme-carousel-indicators-v2 li', false)
				->addParamsString('width: '.$size.'px;');
		}

		if( $size ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .carousel .theme-carousel-indicators-v2 li', false)
				->addParamsString('height: '.$size.'px;');
		}

		if( $size ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .carousel .theme-carousel-indicators-v2 li.active', false)
				->addParamsString('width: '.$size.'px;');
		}

		if( $size ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .carousel .theme-carousel-indicators-v2 li.active', false)
				->addParamsString('height: '.$size.'px;');
		}


		if( $query->getColor('dot-bg') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v2 .carousel .theme-carousel-indicators-v2 li', false)
				->addParamsString('background-color: '.$query->getColor('dot-bg').';');
		}

		if( $query->getColor('dot-bg-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v2 .carousel .theme-carousel-indicators-v2 li.active', false)
				->addParamsString('background-color: '.$query->getColor('dot-bg-active').';');
		}

		if( $query->getColor('dot-border') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v2 .carousel .theme-carousel-indicators-v2 li', false)
				->addParamsString('border-color: '.$query->getColor('dot-border').';');
		}

		if( $query->getColor('dot-border-active') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.slider-block-v2 .carousel .theme-carousel-indicators-v2 li.active', false)
				->addParamsString('border-color: '.$query->getColor('dot-border-active').';');
		}


		if( $query->getColor('link-btn-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .slider-block-v2-link-btn', false)
				->addParamsString('color: '.$query->getColor('link-btn-color').';');
		}

		if( $query->getColor('link-btn-color-hover') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .slider-block-v2-link-btn:hover', false)
				->addParamsString('color: '.$query->getColor('link-btn-color-hover').';');
		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'slide':
								blocks.render('image', query);

								query.get('labels').each(function (query, variationType) {
									switch (variationType) {
										case 'title':
											query.addHeadingLg('text');
											break;
										// case 'description':
										// 	query.addText('text');
										// 	break;
										// case 'link':
										// 	query.addLink('text');
										// 	break;
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