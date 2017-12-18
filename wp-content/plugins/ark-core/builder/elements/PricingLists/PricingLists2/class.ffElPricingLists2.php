<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_pricing_list.html#scrollTo__1129
 * @link http://demo.freshface.net/html/h-ark/HTML/index_boxed_simple.html#scrollTo__2400
 */

class ffElPricingLists2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 2', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'pricing-table');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'pricing table, pricing list');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TITLE */
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Light')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark') ) )
						;
						$s->addOption(ffOneOption::TYPE_SELECT,'one-title-align','','text-right')
							->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
							->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
							->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Align', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* PRICING INFO */
					$s->startRepVariationSection('one-info', ark_wp_kses( __('Pricing Info', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'sign', ark_wp_kses( __('Price sign', 'ark' ) ), 'ff-font-awesome4 icon-dollar')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '37')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark') ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'duration', '', ' Mon')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Duration', 'ark') ) )
						;
					$s->endRepVariationSection();

					/* PRICING INFO */
					$s->startRepVariationSection('items', ark_wp_kses( __('Pricing Items', 'ark' ) ));

						$s->startRepVariableSection('content');

							$s->startRepVariationSection('item', ark_wp_kses( __('Item', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Shuffle play')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark') ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/* TYPE BUTTON */
					$s->startRepVariationSection('one-button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
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
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Table Header Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'table-content-border', '', '#f7f8fa')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Table Content Border', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pricing List Box Shadow', 'ark' ) ) )
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

		$box_shadow_selectors = array(
			'.pricing-list-v2' => 'el-shadow',
		);

		foreach( $box_shadow_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('box-shadow: 0 2px 5px 3px ' . $color . ';');
			}
		}

		$border_color_selectors = array(
			'.pricing-list-v2 .pricing-list-v2-content' => 'table-content-border',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border: 1px solid ' . $color . ';');
			}
		}

		echo '<section class="pricing-list-v2 '.$query->get('align').'">';

			$isInHeadClass = false;
			$isInContentClass = false;

			if($query->getColor('bg-color')) {
				$this->getAssetsRenderer()->createCssRule()
					->addSelector('.pricing-list-v2-header')
					->addParamsString('background-color:' . $query->getColor('bg-color') . ';');
			}

			foreach( $query->get('content') as $oneLine ) {
				switch($oneLine->getVariationType()){

					case 'one-title':
						if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
						if( !$isInHeadClass ){ echo '<div class="pricing-list-v2-header">'; $isInHeadClass = true; }

						$toPrint = '<h4 class="pricing-list-v2-header-title '.$oneLine->get('one-title-align').'">';
							$toPrint .= $oneLine->getWpKses('text');
						$toPrint .= '</h4>';

						// Escaped title
						echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );

						break;

					case 'one-info':

						if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
						if( !$isInHeadClass ){ echo '<div class="pricing-list-v2-header">'; $isInHeadClass = true; }

						$this->_applySystemTabsOnRepeatableStart($oneLine);
							echo '<div class="ff-custom-pricing">';

								echo '<span class="pricing-list-v2-header-price-sign"><i class="'.	$oneLine->getWpKses('sign')	.'"></i></span>';

								echo '<span class="pricing-list-v2-header-price">';
									$oneLine->printWpKses('price');
								echo '</span>';

								echo '<span class="pricing-list-v2-header-price-info">';
									$oneLine->printWpKses('duration');
								echo '</span>';

							echo '</div>';
						$this->_applySystemTabsOnRepeatableEnd($oneLine);
						break;


					case 'items':
						if ( !$oneLine->exists('content') ){
							break;
						}

						if( $isInHeadClass ){ echo '</div>'; $isInHeadClass = false; }
						if( !$isInContentClass ){ echo '<div class="pricing-list-v2-content">'; $isInContentClass = true; }

						$this->_applySystemTabsOnRepeatableStart($oneLine);
							echo '<ul class="list-unstyled pricing-list-v2-content-list">';
								foreach( $oneLine->get('content') as $oneItem ) {
									echo '<li>';
										$oneItem->printWpKses('text');
									echo '</li>';
								}
							echo '</ul>';
						$this->_applySystemTabsOnRepeatableEnd($oneLine);

						break;

					case 'one-button':
						if( $isInHeadClass ){ echo '</div>'; $isInHeadClass = false; }
						if( !$isInContentClass ){ echo '<div class="pricing-list-v2-content">'; $isInContentClass = true; }

						$toPrint = '<span>';
						$toPrint .= $this->_getBlock( ffThemeBlConst::BUTTON )->get( $oneLine );
						$toPrint .= '</span>';
						// Escaped button block
						echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );

						break;

				}
			}

			if( $isInHeadClass ){ echo '</div>'; }
			if( $isInContentClass ){ echo '</div>'; }

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('text');
								break;
							case 'one-info':
								var price = query.get('price');
								price += ' ';
								var duration = '/ ';
								duration += query.get('duration');
								query.addHeadingSm(null, price, duration);
								break;
							case 'items':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'item':
											query.addText('text');
											break;
									}
								});
								break;
							case 'one-button':
								blocks.render('button', query);
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}