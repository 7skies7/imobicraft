<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/about_us.html#scrollTo__3008
 */

class ffElPricingLists5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 5', 'ark' ) ) );
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

					/*----------------------------------------------------------*/
					/* TYPE HEADING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('heading', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Personal')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TABLE INFO
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-info', ark_wp_kses( __('Pricing Info', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'sign', ark_wp_kses( __('Price sign', 'ark' ) ), 'ff-font-awesome4 icon-dollar');
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '7.')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subprice', '', '00')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subprice', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'duration', '', 'Month')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Duration', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-button', ark_wp_kses( __('Button', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-profile-male');

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'icon-position','','icon-right')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'icon-left')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'icon-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Position', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-text-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT,'align','','text-left')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pricing List Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', '#eff1f8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow Color', 'ark' ) ) )
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
			'.l-pricing-list-v1' => 'el-shadow',
		);

		foreach( $box_shadow_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('box-shadow: 7px 7px 5px 0 ' . $color . ';');
			}
		}

		echo '<div class="l-pricing-list-v1 radius-5 '.$query->get('align').' '.$query->get('icon-position').'">';

			echo '<div class="l-pricing-list-v1-effect-wrap">';
				echo '<span class="l-pricing-list-v1-effect l-pricing-list-v1-effect-one">';

					if($query->getColor('icon-text-color')) {
						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(true)
							->addSelector('.l-pricing-list-v1-icon')
							->addParamsString('color:' . $query->getColor('icon-text-color') . ' ;');
					}

					if($query->getColor('icon-color')) {
						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(true)
							->addSelector('span.before')
							->addParamsString('border-color:' . $query->getColor('icon-color') . ' ;');

						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(true)
							->addSelector('.l-pricing-list-v1-icon')
							->addParamsString('background: '. $query->getColor('icon-color') . ' ;');

						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(true)
							->addSelector('span.after')
							->addParamsString('border-color:'. $query->getColor('icon-color') . ' ;');
					}

					echo '<span class="before"></span>';

					echo '<i class="l-pricing-list-v1-icon '.$query->getWpKses('icon').'"></i>';

					echo '<span class="after"></span>';
				echo '</span>';
			echo '</div>';

			if( $query->exists('content') ) {
				foreach( $query->get('content') as $oneLine ) {
					switch($oneLine->getVariationType()){

						case 'heading':
							echo '<h4 class="l-pricing-list-v1-title">';
								$oneLine->printWpKses('title');
							echo '</h4>';
							break;

						case 'one-info':
							echo '<div class="display-b">';

								echo '<span class="l-pricing-list-v1-price-sign"><i class="'.$oneLine->getWpKses('sign').'"></i></span>';

								echo '<span class="l-pricing-list-v1-price">';
									$oneLine->printWpKses('price');
								echo '</span>';

								echo '<span class="l-pricing-list-v1-subprice">';
									$oneLine->printWpKses('subprice');
								echo '</span>';

								echo '<span class="l-pricing-list-v1-price-info">';
									$oneLine->printWpKses('duration');
								echo '</span>';

							echo '</div>';
							break;

						case 'one-button':
							echo '<span class="l-pricing-list-v1-button-wrapper">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
							echo '</span>';
							break;
					}
				}
			}

		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.addIcon('icon');

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'heading':
								query.addHeadingLg('title');
								break;

							case 'one-info':
								var price = query.get('price');
								var subprice = query.get('subprice');
								price += subprice;
								price += ' ';
								var duration = '/ ';
								duration += query.get('duration');
								query.addHeadingLg(null, price, duration);
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