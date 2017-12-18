<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_2.html#scrollTo__0
 */

class ffElPromo8 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'promo-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Promo 8', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'promo');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'promo, banner, hero');

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
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Style & Fit')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE ROW
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('labels', ark_wp_kses( __('Promo Columns', 'ark' ) ) );

						$s->startRepVariableSection('content');

							/* TYPE PRICING */
							$s->startRepVariationSection('pricing', ark_wp_kses( __('Pricing', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'label', '', 'Business')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '$')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Currency', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'order', '', '8.')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date', '', 'month')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', null)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) );
							$s->endRepVariationSection();

							/* TYPE DESCRIPTION */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Design is a serious matter and often, it is the smallest details that matters the most. So we are sending our best')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();
							
							/*----------------------------------------------------------*/
							/* TYPE BUTTON
							/*----------------------------------------------------------*/
							$s->startRepVariationSection('buttons', ark_wp_kses( __('Buttons', 'ark' ) ));
								$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
							$s->endRepVariationSection();

						$s->endRepVariableSection();

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

		echo '<section class="promo-block-v8">';

			foreach( $query->get('content') as $oneItem ) {
				switch( $oneItem->getVariationType() ) {

					case 'title':
						echo '<h1 class="promo-block-v8-title">'. $oneItem->getWpKses('text') .'</h1>';
						break;

					case 'labels':

						if ( !$oneItem->exists('content') ){
							break;
						}

						echo '<div class="row">';

							foreach( $oneItem->get('content') as $oneLabel ) {
								switch( $oneLabel->getVariationType() ) {

									case 'pricing':

										$border_color_selectors = array(
											' .promo-block-v8-pricing' => 'divider-color',
										);

										foreach( $border_color_selectors as $selector => $c ){
											$color = $oneLabel->getColor( $c );
											if( $color ) {
												$this->getAssetsRenderer()->createCssRule()
													->setAddWhiteSpaceBetweenSelectors(false)
													->addSelector($selector, false)
													->addParamsString('border-color:' . $color . ';');
											}
										}

										echo '<div class="promo-block-v8-col sm-margin-b-30">';
											echo '<div class="promo-block-v8-pricing">';

												echo '<div class="promo-block-v8-pricing-col">';
													echo '<span class="promo-block-v8-pricing-sign">'. $oneLabel->getWpKses('unit') .'</span>';
													echo '<span class="promo-block-v8-pricing-text">'. $oneLabel->getWpKses('label') .'</span>';
												echo '</div>';
												echo '<div class="promo-block-v8-pricing-col">';
													echo '<span class="promo-block-v8-pricing-no">'. $oneLabel->getWpKses('order') .'</span>';
												echo '</div>';
												echo '<div class="promo-block-v8-pricing-col">';
													echo '<span class="promo-block-v8-pricing-mon">'. $oneLabel->getWpKses('date') .'</span>';
												echo '</div>';

											echo '</div>';
										echo '</div>';
										break;

									case 'description':
										echo '<div class="promo-block-v8-col width-300 sm-margin-b-30">';
											$oneLabel->printWpKsesTextarea( 'text', '<p class="promo-block-v8-text">', '</p>', '<div class="promo-block-v8-text ff-richtext">', '</div>' );
										echo '</div>';
										break;

									case 'buttons':
										echo '<div class="promo-block-v8-col promo-block-v8-col-right">';
											$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLabel );
										echo '</div>';
										break;
								}
							}

						echo '</div>';
						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'labels':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'description':
											query.addText('text');
											break;
									}
								});
								break;
							case 'link':
								query.addLink('video-link');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}