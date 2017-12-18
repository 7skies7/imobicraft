<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index.html
 */

class ffElPricingLists7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 7', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'pricing-table');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'pricing table, pricing list');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE HEADING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('heading', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Standard Plan')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SUBTITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Get started on a project or pilot')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TABLE INFO
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-info', ark_wp_kses( __('Pricing Info', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'currency', '', '$')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Currency', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '7')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subprice', '', '.00 ')
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT,'align','','text-center')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ),'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ),'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ),'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pricing List Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'radio-bg', '', '#009688')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'radio-shadow', '', 'rgba(0, 150, 136, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Border Hover', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#454558')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-pricing-list-7' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}



		if($query->getColor('bg-color')) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.l-pricing-list-v2')
				->addParamsString('background-color:' . $query->getColor('bg-color') . ';');
		}


		echo '<div class="l-pricing-list-v2 pricing-list-7 '.$query->get('align').'">';

			if($query->getColor('radio-bg')) {
				$this->getAssetsRenderer()->createCssRule()
					->addSelector('.l-pricing-list-v2-checkbox label:before',false)
					->addParamsString('background:' . $query->getColor('radio-bg') . ';');
			}

			if($query->getColor('radio-shadow')) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector('.l-pricing-list-v2:hover .l-pricing-list-v2-checkbox label:after',false)
					->addParamsString('box-shadow: 0 0 0 8px ' . $query->getColor('radio-shadow') . ';');
			}

			echo '<span class="l-pricing-list-v2-checkbox">';
			echo '<input id="radio" type="radio" name="radio">';
			echo '<label></label>';
			echo '</span>';

			if( $query->exists('content') ) {
				foreach( $query->get('content') as $oneLine ) {
					switch($oneLine->getVariationType()){

						case 'heading':
							echo '<h3 class="l-pricing-list-v2-title">';
								$oneLine->printWpKses('text');
							echo '</h3>';
							break;

						case 'subtitle':
							echo '<p class="l-pricing-list-v2-text">';
							$oneLine->printWpKses('text');
							echo '</p>';
							break;

						case 'one-info':
							echo '<div class="display-b">';

								echo '<span class="l-pricing-list-v2-price-sign">'.$oneLine->getWpKses('currency').'</span>';

								echo '<span class="l-pricing-list-v2-price">';
									$oneLine->printWpKses('price');
								echo '</span>';

								echo '<span class="l-pricing-list-v2-subprice">';
									$oneLine->printWpKses('subprice');
								echo '</span>';

								echo '<span class="l-pricing-list-v2-price-info">';
									$oneLine->printWpKses('duration');
								echo '</span>';

							echo '</div>';
							break;

						case 'one-button':
							echo '<div class="l-pricing-list-v2-btn">';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
							echo '</div>';
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

				if(query.queryExists('content')) {

					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'heading':
								query.addHeadingLg('text');
								break;

							case 'subtitle':
								query.addHeadingSm('text');
								break;

							case 'one-info':
								var all = query.get('currency');
								var price = query.get('price');
								var subprice = query.get('subprice');
								price += subprice;
								price += ' ';
								var duration = '/ ';
								duration += query.get('duration');
								all += price;
								query.addHeadingLg(null, all, duration);
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