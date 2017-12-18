<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_pricing_list.html#scrollTo__1735
 */

class ffElPricingLists3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'pricing-table');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'pricing table, pricing list');
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
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'USA - Europe')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SUBTITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle', '', 'Limited')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE ITEM
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-table', ark_wp_kses( __('Pricing Plan', 'ark' ) ) );
						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle', '', 'Basic')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							$s->startRepVariationSection('one-item', ark_wp_kses( __('Item', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'item', '', '01 January - 31 January')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Item', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							$s->startRepVariationSection('one-price', ark_wp_kses( __('Price', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_ICON, 'sign', ark_wp_kses( __('Price sign', 'ark' ) ), 'ff-font-awesome4 icon-dollar')
									->addParam('print-in-content', true)
								;
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '220')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							$s->startRepVariationSection('one-button', ark_wp_kses( __('Button', 'ark' ) ));
								$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
							$s->endRepVariationSection();

						$s->endRepVariableSection();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-border', ark_wp_kses( __('Show Right Border', 'ark' ) ), 1);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'sm'=>'6'))->injectOptions( $s );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT,'align','','text-center')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pricing List Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pricing List Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'plan-border-color', '', 'rgba(255,255,255,0.7)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pricing Plan Right Border Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		if($query->getColor('bg-color')) {
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('background-color:' . $query->getColor('bg-color') . ';');
		}

		$border_color_selectors = array(
			'.pricing-list-v3 .pricing-list-v3-border' => 'plan-border-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-right: 1px solid ' . $color . ';');
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color: ' . $color . ';');
			}
		}

		echo '<div class="pricing-list-v3 '.$query->get('align').'">';

			$isInRow = false;

			foreach( $query->get('content') as $oneLine ) {
				switch($oneLine->getVariationType()){

					case 'one-title':
						if( $isInRow ){ echo '</div>'; $isInRow = false; }

						$toPrint = '<h4 class="pricing-list-v3-title">';
							$toPrint .= $oneLine->getWpKses('title');
						$toPrint .= '</h4>';

						// Escaped title
						echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );

						break;

					case 'one-subtitle':
						if( $isInRow ){ echo '</div>'; $isInRow = false; }

						$toPrint = '<span class="pricing-list-v3-text">';
							$toPrint .= $oneLine->getWpKses('subtitle');
						$toPrint .= '</span>';

						// Escaped subtitle
						echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );

						break;

					case 'one-table':
						if ( !$oneLine->exists('repeated-lines') ){
							break;
						}

						if( !$isInRow ){ echo '<div class="row">'; $isInRow = true; }

						$this->_applySystemTabsOnRepeatableStart($oneLine);

							echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .' ';
								if($oneLine->get('show-border')){ echo 'pricing-list-v3-border'; };
							echo '">';


								foreach( $oneLine->get('repeated-lines') as $oneItem ) {
									switch ($oneItem->getVariationType()) {

										case 'one-subtitle':
											echo '<span class="pricing-list-v3-subtitle">';
												$oneItem->printWpKses('subtitle');
											echo '</span>';
											break;

										case 'one-item':
											echo '<p class="pricing-list-v3-paragraph">';
												$oneItem->printWpKses('item');
											echo '</p>';
											break;

										case 'one-price':
												echo '<div class="ff-custom-pricing">';
												echo '<span class="pricing-list-v3-price-sign"><i class="'.$oneItem->getWpKses('sign').'"></i></span>';
												echo '<span class="pricing-list-v3-price">';
													$oneItem->printWpKses('price');
												echo '</span>';
												echo '</div>';
											break;

										case 'one-button':
											echo '<span>';
											$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneItem );
											echo '</span>';

											break;

									}
								}

							echo '</div>';
						$this->_applySystemTabsOnRepeatableEnd($oneLine);

						break;
				}
			}

			if( $isInRow ){ echo '</div>'; }

		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('title');
								break;

							case 'one-subtitle':
								query.addHeadingSm('subtitle');
								break;

							case 'one-table':
								query.addPlainText('<br>');
								query.get('repeated-lines').each(function (query, variationType) {
									switch (variationType) {
										case 'one-subtitle':
											query.addHeadingLg('subtitle');
											break;
										case 'one-item':
											query.addText('item');
											break;
										case 'one-price':
											query.addHeadingSm('price');
											break;
										case 'one-button':
											blocks.render('button', query);
											break;

									}
								});
									query.addPlainText('<br>');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}