<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_business_3.html
 */

class ffElPricingLists6 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-6');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 6', 'ark' ) ));
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

					/* TITLE */
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Enterprise')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark') ) )
						;
					$s->endRepVariationSection();

					/* PRICING INFO */
					$s->startRepVariationSection('one-info', ark_wp_kses( __('Pricing Info', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'currency', '', '$')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Currency', 'ark') ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'price', '', '37')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Price', 'ark') ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subprice', '', '.00')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subprice', 'ark') ) )
						;
					$s->endRepVariationSection();

					/* TYPE BUTTON */
					$s->startRepVariationSection('one-button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Subtitle', 'ark' ) ) );

				$s->startAdvancedToggleBox('subtitle', esc_attr( __('Subtitle', 'ark' ) ));

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Yearly')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark') ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle-width', '', '90')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width (in px)', 'ark') ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle-offset', '', '40')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Offset (in px)', 'ark') ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-subtitle', '', '#34343c')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-subtitle', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle Background', 'ark' ) ) )
					;

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Table Settings', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'is-active',ark_wp_kses( __('Most popular plan', 'ark' ) ),0);
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Makes this Pricing List more visually prominent.', 'ark' ) ));
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pricing List Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#a5dff9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
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
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-pricing-v1')
				->addParamsString('background-color:' . $query->getColor('bg-color') . ';');
		}

		$isActive = '';
		if($query->get('is-active')){
			$isActive = 'op-b-pricing-v1-active';
		}

		echo '<section class="op-b-pricing-v1 pricing-list-6 '.$isActive.'">';

			foreach( $query->get('content') as $oneLine ) {
				switch($oneLine->getVariationType()){

					case 'one-title':

						echo '<h3 class="op-b-pricing-v1-title">';
						$oneLine->printText('text');
						echo '</h3>';

						break;

					case 'one-info':

						echo '<div class="display-b">';

						$this->_applySystemTabsOnRepeatableStart($oneLine);
							echo '<div class="ff-custom-pricing">';

								echo '<span class="op-b-pricing-v1-price-sign">'.	$oneLine->getWpKses('currency')	.'</span>';

								echo '<span class="op-b-pricing-v1-price">';
									$oneLine->printWpKses('price');
								echo '</span>';

								echo '<span class="op-b-pricing-v1-subprice">';
									$oneLine->printWpKses('subprice');
								echo '</span>';

							echo '</div>';
						$this->_applySystemTabsOnRepeatableEnd($oneLine);
						echo '</div>';
						break;

					case 'one-button':

						$toPrint = '<span>';
						$toPrint .= $this->_getBlock( ffThemeBlConst::BUTTON )->get( $oneLine );
						$toPrint .= '</span>';
						// Escaped button block
						echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );

						break;

				}
			}

			$this->_advancedToggleBoxStart( $query->get('subtitle') );

				if($query->getColor('subtitle bg-subtitle')) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector('.op-b-pricing-v1-subtitle')
						->addParamsString('background:' . $query->getColor('subtitle bg-subtitle') . ';');
				}

				if($query->getColor('subtitle color-subtitle')) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector('.op-b-pricing-v1-subtitle')
						->addParamsString('color:' . $query->getColor('subtitle color-subtitle') . ';');
				}

				if($query->get('subtitle subtitle-width')) {

					$sWidth = intval($query->get('subtitle subtitle-width'));
					$sOffset = intval($query->get('subtitle subtitle-offset'));

					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector('.op-b-pricing-v1-subtitle')
						->addParamsString('width:' . $sWidth . 'px;');
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector('.op-b-pricing-v1-subtitle')
						->addParamsString('left:' . (-($sWidth/2)+($sOffset)) . 'px;');
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector('.op-b-pricing-v1-subtitle')
						->addParamsString('margin-top:' . $sWidth/2 . 'px;');
				}

				echo '<span class="op-b-pricing-v1-subtitle">';
				$query->printWpKses('subtitle text');
				echo '</span>';

			$this->_advancedToggleBoxEnd( $query->get('subtitle') );

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {

					query.addText('subtitle text');

					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('text');
								break;
							case 'one-subtitle':
								query.addHeadingSm('text');
								break;
							case 'one-info':
								var priceVal = query.get('price');
								var price = query.get('currency');
								price += priceVal;
								var subprice = query.get('subprice');
								query.addHeadingLg(null, price, subprice);
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