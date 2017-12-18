<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services.html#scrollTo__4600
 */

class ffElPricingLists4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'pricinglists-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Pricing Table 4', 'ark' ) ) );
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

					/* TYPE TITLE */
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Basic')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE SUBTITLE */
					$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle', '', 'Individual')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TABLE */
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

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'duration', '', '/ Month')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Duration', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/* BUTTON */
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
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'line-separator', '', '#e4e8f3')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Line Separator', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Box Shadow', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'background', '', '#ffffff')
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

		$color = $query->getColorWithoutComparationDefault( 'el-shadow', '' );
		if( $color ) {
			$this->_renderCSSRule('box-shadow', '15px 15px 15px 0 ' . $color );
		}

		$color = $query->getColorWithoutComparationDefault( 'line-separator', '' );
		if( $color ) {
			$this->_renderCSSRule('border-bottom', '1px solid ' . $color, ' .pricing-list-v4-header' );
		}

		$this->_renderCSSRule('background-color', $query->getColorWithoutComparationDefault( 'background', '' ) );

		echo '<section class="pricing-list-v4 radius-10 '.$query->get('align').'">';

			$isInHeadClass = false;
			$isInContentClass = false;

			foreach( $query->get('content') as $oneLine ) {
				switch($oneLine->getVariationType()){

					case 'one-title':
						if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
						if( !$isInHeadClass ){ echo '<div class="pricing-list-v4-header">'; $isInHeadClass = true; }

						$toPrint = '<h4 class="pricing-list-v4-title">';
							$toPrint .= $oneLine->getWpKses('title');
						$toPrint .= '</h4>';

						// Escaped title
						echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );

						break;

					case 'one-subtitle':
						if( $isInContentClass ){ echo '</div>'; $isInContentClass = false; }
						if( !$isInHeadClass ){ echo '<div class="pricing-list-v4-header">'; $isInHeadClass = true; }

						$toPrint = '<span class="pricing-list-v4-subtitle">';
							$toPrint .= $oneLine->getWpKses('subtitle');
						$toPrint .= '</span>';

						// Escaped subtitle
						echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );

						break;


					case 'one-info':
						if( $isInHeadClass ){ echo '</div>'; $isInHeadClass = false; }
						if( !$isInContentClass ){ echo '<div class="pricing-list-v4-content">'; $isInContentClass = true; }

						$this->_applySystemTabsOnRepeatableStart($oneLine);
							echo '<div class="ff-custom-pricing">';
								echo '<span class="pricing-list-v4-price-sign"><i class="'.$oneLine->getWpKses('sign').'"></i></span>';
								echo '<span class="pricing-list-v4-price">';
									$oneLine->printWpKses('price');
								echo '</span>';
								echo '<span class="pricing-list-v4-subprice">';
									$oneLine->printWpKses('subprice');
								echo '</span>';
								echo '<span class="pricing-list-v4-price-info">';
									$oneLine->printWpKses('duration');
								echo '</span>';
							echo '</div>';
						$this->_applySystemTabsOnRepeatableEnd($oneLine);

						break;

					case 'one-button':
						if( $isInHeadClass ){ echo '</div>'; $isInHeadClass = false; }
						if( !$isInContentClass ){ echo '<div class="pricing-list-v4-content">'; $isInContentClass = true; }

						$toPrint = '<div class="pricing-list-v4-button-wrapper">';
						$toPrint .= $this->_getBlock( ffThemeBlConst::BUTTON )->get( $oneLine );
						$toPrint .= '</div>';

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
								query.addHeadingLg('title');
								break;
							case 'one-subtitle':
								query.addHeadingSm('subtitle');
								break;
							case 'one-info':
								// query.addText('price');
								// query.addText('subprice');
								// query.addText('duration');
								var price = query.get('price');
								var subprice = query.get('subprice');
								price += subprice;
								price += ' ';
								var duration = query.get('duration');
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