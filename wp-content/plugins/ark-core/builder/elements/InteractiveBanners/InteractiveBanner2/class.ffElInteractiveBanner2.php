<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__3700
 */

class ffElInteractiveBanner2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'interactive-banner-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Interactive Slider', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'interactive-banner');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'interactive banner, promo, hero, banner');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Interactive Slider', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE BANNER
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('banner', ark_wp_kses( __('Slide', 'ark' ) ) );

						$s->startAdvancedToggleBox('slide-content', esc_attr( __('Content', 'ark' ) ) );

							$this->_getBlock( ffThemeBlConst::IMAGE )->imgIsResponsive()->injectOptions( $s );

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'img-color', '', 'rgba(52, 52, 60, 0.3)')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image overlay color (filter)', 'ark' ) ) )
							;

							$s->startRepVariableSection('main-labels');

								/* TYPE TITLE */
								$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Idea &amp; Plans')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

								$s->endRepVariationSection();

								/* TYPE DESCRIPTION */
								$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Give into creativity. Smart design and flexible solutions')
										->addParam('print-in-content', true);

								$s->endRepVariationSection();

							$s->endRepVariableSection();
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('navigation', esc_attr( __('Navigation', 'ark' ) ));

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'order', '', '01.')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) );

							$s->startRepVariableSection('bottom-labels');

								/* TYPE TITLE */
								$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Idea &amp; Plans')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

								$s->endRepVariationSection();

								/* TYPE SUB-TITLE */
								$s->startRepVariationSection('sub-title', ark_wp_kses( __('Sub-Title', 'ark' ) ));

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Watch Now')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

								$s->endRepVariationSection();

							$s->endRepVariableSection();
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();


				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

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

		echo '<section class="interactive-banner-2 carousel slide carousel-fade" data-ride="carousel">';

			echo '<div class="carousel-inner" role="listbox">';

				foreach( $query->get('content') as $key => $oneBanner ) {

					$active = '';
					if( 0 == $key ){
						$active = 'active';
					}

					echo '<div class="item '. $active .'">';

						ffElInteractiveBanner2::_renderColor( $oneBanner->getColor('slide-content img-color'), 'background-color', ' .ff-img-wrapper:after' );

						$this->_advancedToggleBoxStart( $oneBanner->get('slide-content') );
						echo '<div class="i-banner-v2">';

							echo '<div class="ff-img-wrapper">';
							$this->_getBlock( ffThemeBlConst::IMAGE )->imgIsResponsive()->render( $oneBanner->get('slide-content') );
							echo '</div>';

							if( $oneBanner->exists('slide-content main-labels') ) {

								echo '<div class="i-banner-v2-center-align">';

									foreach( $oneBanner->get('slide-content main-labels') as $oneLabel ) {
										switch( $oneLabel->getVariationType() ) {

											case 'title':
												echo '<h2 class="i-banner-v2-title">'. $oneLabel->getWpKses('text') .'</h2>';
												break;

											case 'description':
												echo '<p class="i-banner-v2-text">'. $oneLabel->getWpKses('text') .'</p>';
												break;

										}
									}

								echo '</div>';

							}

						echo '</div>';
						$this->_advancedToggleBoxEnd( $oneBanner->get('slide-content') );
					echo '</div>';
				}

			echo '</div>';

			echo '<ol class="carousel-indicators theme-ci-v1">';

				foreach( $query->getWithoutCallbacks('content') as $key => $oneBanner ) {

					$active = '';
					if( 0 == $key ){
						$active = 'active';
					}

					$this->_advancedToggleBoxStart( $oneBanner->get('navigation') );

					echo '<li data-target=".ffb-id-'.$uniqueId.'" data-slide-to="'. $key .'" class="theme-ci-v1-item '. $active .'">';
						echo '<span class="theme-ci-v1-no">'. $oneBanner->getWpKses('navigation order') .'</span>';

						if( $oneBanner->exists('navigation bottom-labels') ) {
							echo '<div class="theme-ci-v1-media">';

								foreach( $oneBanner->getWithCallbacks('navigation bottom-labels') as $oneLabel ) {
									switch( $oneLabel->getVariationType() ) {

										case 'title':
											echo '<span class="theme-ci-v1-title">'. $oneLabel->getWpKses('text') .'</span>';
											break;

										case 'sub-title':
											echo '<span class="theme-ci-v1-subtitle">'. $oneLabel->getWpKses('text') .'</span>';
											break;

									}
								}

							echo '</div>';
						}

					echo '</li>';

					$this->_advancedToggleBoxEnd( $oneBanner->get('navigation') );

				}

			echo '</ol>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'banner':

								blocks.render('image', query.get('slide-content'));

                                if( query.get('slide-content').get('main-labels') != null ) {
                                    query.get('slide-content').get('main-labels').each(function (query, variationType) {
                                        switch (variationType) {
                                            case 'title':
                                                query.addHeadingLg('text');
                                                break;

                                            case 'description':
                                                query.addText('text');
                                                break;

                                        }
                                    });
                                }


								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}