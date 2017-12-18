<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__5263
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_pricing_list.html#scrollTo__397
 */

class ffElPricingLists1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 1', 'ark' ) ));
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
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Basic')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* SUBTITLE */
					$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'The very basic options')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* PRICING INFO */
					$s->startRepVariationSection('one-info', ark_wp_kses( __('Pricing Info', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'sign', ark_wp_kses( __('Price sign', 'ark' ) ), 'ff-font-awesome4 icon-dollar')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '30')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'duration', '', ' Mon')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Duration', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* PRICING INFO */
					$s->startRepVariationSection('items', ark_wp_kses( __('Pricing Items', 'ark' ) ));

						$s->startRepVariableSection('content');

							$s->startRepVariationSection('item', ark_wp_kses( __('Item', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Notifications')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Table Settings', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Most popular plan', 'ark' ) ), 0);
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Makes this Pricing List more visually prominent.', 'ark' ) ));

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT,'align','','text-center')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pricing List Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'active-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Most Popular Plan Accent', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) )
				;
				
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#f7f8fa')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Table Border', 'ark' ) ) )
				;
				
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f7f8fa')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Table Background', 'ark' ) ) )
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

		$border_color_selectors = array(
			'.pricing-list-v1' => 'border-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border: 2px solid ' . $color . ';');
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('padding: 10px;');
			}
		}

		$border_color_selectors = array(
			'.pricing-list-v1 .pricing-list-v1-body .pricing-list-v1-header' => 'divider-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-bottom: 2px solid ' . $color . ';');
			}
		}

		$activeClass = '';
		if( $query->get('is-active') ) {
			$activeClass = 'pricing-list-v1-active';

			if($query->getColor('active-color')){
				$color_selectors = array('.pricing-list-v1-header-price-sign','.pricing-list-v1-header-price','.pricing-list-v1-header-price-info');

				foreach( $color_selectors as $selector){
					$this->getAssetsRenderer()->createCssRule()
						->addSelector('.ff-custom-pricing ' . $selector)
						->addParamsString('color:' . $query->getColor('active-color') . '');
				}

			}

		}

		$this->getAssetsRenderer()->createCssRule()
			->addSelector('.pricing-list-v1-body')
			->addParamsString('background-color:' . $query->getColor('bg-color') . '');

		echo '<section class="pricing-list-v1 '. $activeClass .' '.$query->getWpKses('align').'">';

			echo '<div class="pricing-list-v1-body">';

				$isInHeadClass = false;
				$isInContentClass = false;

				foreach( $query->get('content') as $oneLine ) {
					switch($oneLine->getVariationType()){

						case 'one-title':

							if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
							if( !$isInHeadClass ){ echo '<div class="pricing-list-v1-header">'; $isInHeadClass = true; }

							$this->_applySystemTabsOnRepeatableStart($oneLine);
							echo '<h4 class="pricing-list-v1-header-title">';
								$oneLine->printWpKses('text');
							echo '</h4>';
							$this->_applySystemTabsOnRepeatableEnd($oneLine);
							break;

							case 'one-subtitle':

							if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
							if( !$isInHeadClass ){ echo '<div class="pricing-list-v1-header">'; $isInHeadClass = true; }

							$this->_applySystemTabsOnRepeatableStart($oneLine);
								echo '<p class="pricing-list-v1-header-subtitle">';
									$oneLine->printWpKses('text');
								echo '</p>';
							$this->_applySystemTabsOnRepeatableEnd($oneLine);
							break;

						case 'one-info':

							if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
							if( !$isInHeadClass ){ echo '<div class="pricing-list-v1-header">'; $isInHeadClass = true; }

							$this->_applySystemTabsOnRepeatableStart($oneLine);
								echo '<div class="ff-custom-pricing">';
									echo '<span class="pricing-list-v1-header-price-sign"><i class="'.	$oneLine->getWpKses('sign')	.'"></i></span>';
									echo '<span class="pricing-list-v1-header-price">';
										$oneLine->printWpKses('price');
									echo '</span>';
									echo '<span class="pricing-list-v1-header-price-info">';
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
							if( !$isInContentClass ){ echo ' <div class="pricing-list-v1-content">'; $isInContentClass = true; }

							$this->_applySystemTabsOnRepeatableStart($oneLine);
								echo '<ul class="list-unstyled pricing-list-v1-content-list">';
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
							if( !$isInContentClass ){ echo '<div class="pricing-list-v1-content">'; $isInContentClass = true; }

							$this->_applySystemTabsOnRepeatableStart($oneLine);
								echo '<span>';
									// escaped button block
									echo ( $this->_getBlock( ffThemeBlConst::BUTTON )->get( $oneLine ) );
								echo '</span>';
							$this->_applySystemTabsOnRepeatableEnd($oneLine);
							break;

					}
				}

				if( $isInHeadClass ){ echo '</div>'; }
				if( $isInContentClass ){ echo '</div>'; }

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