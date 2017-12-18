<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_contacts.html#scrollTo__736
 */

class ffElSpecification extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'specification');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Specification', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'opening hours, specification, portfolio, list, information list');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* ONE ITEM
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('item', ark_wp_kses( __('One Item', 'ark' ) ));

						/*----------------------------------------------------------*/
						/* LEFT SIDE
						/*----------------------------------------------------------*/
						$s->startAdvancedToggleBox('left', 'Left');



							$s->startRepVariableSection('left-paragraph');

								/*----------------------------------------------------------*/
								/* TEXT
								/*----------------------------------------------------------*/
								$s->startRepVariationSection('text', ark_wp_kses( __('Text', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Name')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
									;

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-right', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Right (px)', 'ark' ) ) )
									;


									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) )
									;

								$s->endRepVariationSection();

								/*----------------------------------------------------------*/
								/* ICON
								/*----------------------------------------------------------*/
								$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', 'Icon', 'ff-font-awesome4 icon-check');
									;

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-right', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Right (px)', 'ark' ) ) )
									;

									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) )
									;

								$s->endRepVariationSection();

							$s->endRepVariableSection();

							$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'force-one-line', 'Force text on one line', 1);

						$s->endAdvancedToggleBox();

						/*----------------------------------------------------------*/
						/* RIGHT SIDE
						/*----------------------------------------------------------*/
						$s->startAdvancedToggleBox('right', 'Right');



							$s->startRepVariableSection('right-paragraph');

								/*----------------------------------------------------------*/
								/* TEXT
								/*----------------------------------------------------------*/
								$s->startRepVariationSection('text', ark_wp_kses( __('Text', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
									;

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-left', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Left (px)', 'ark' ) ) )
									;

									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) )
									;

								$s->endRepVariationSection();

								/*----------------------------------------------------------*/
								/* ICON
								/*----------------------------------------------------------*/
								$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
									$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', 'Icon', 'ff-font-awesome4 icon-check');
									;

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-left', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Left (px)', 'ark' ) ) )
									;

									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) )
									;

								$s->endRepVariationSection();

							$s->endRepVariableSection();
							$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'force-one-line', 'Force text on one line', 0);

						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();



				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vertical-gap', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Vertical gap between items (px)', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'horizontal-gap', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Horizontal Inner Offset(px)', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'divider-size', '', '1')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider size (px)', 'ark' ) ) )
				;

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'divider-show-first', 'Show first divider', 0);
			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'divider-show-last', 'Show last divider', 0);



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'even-line-background-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Even Line Background', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'odd-line-background-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Odd Line Background', 'ark' ) ) )
				;



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

//	protected function _renderColor( $query, $cssAttribute, $selector = null ) {
//
//		if( $query && $selector ){
//			$this->getAssetsRenderer()->createCssRule()
//				->addSelector($selector)
//				->addParamsString( $cssAttribute .': '. $query .';');;
//		} else if( $query ){
//			$this->getAssetsRenderer()->createCssRule()
//				->addParamsString( $cssAttribute .': '. $query .';');
//		}
//
//	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$counter = 1;

		echo '<div class="ffb-specification">';

			foreach( $query->get('content') as $oneItem ) {

				$counter++;
				$class = 'ffb-specification-item-odd';
				if( $counter%2 == 0 ) {
					$class = 'ffb-specification-item-even';
				}

				echo '<div class="ffb-specification-item '.$class.'">';
					echo '<div class="ffb-specification-item_holder">';
						echo '<div class="ffb-specification-item_inner">';

							$leftQuery = $oneItem->get('left');

							if( $leftQuery->exists('left-paragraph') ){
								echo '<div class="ffb-specification__left-side">';
									$this->_advancedToggleBoxStart( $leftQuery );
										echo '<p>';
											foreach( $leftQuery->get('left-paragraph') as $oneParagraphItem ) {

												switch( $oneParagraphItem->getVariationType() ) {
													case 'text':
														echo '<span>' . $oneParagraphItem->get('text') . '</span>';
														break;

													case 'icon':
														echo '<i class="ffb-specification-icon '.$oneParagraphItem->get('icon').'"></i>';
														break;
												}

												$css = '';

												$marginRight = $oneParagraphItem->get('margin-right');
												if( !empty( $marginRight) ) {
													$css .= 'margin-right:'.$marginRight.'px;';
												}

												$color = $oneParagraphItem->getColor('color');
												if( !empty( $color ) ) {
													$css .= 'color:' . $color .';';
												}

												if( !empty( $css ) ) {
													$this->_getAssetsRenderer()
														->createCssRule()
														->addParamsString( $css);
												}


											}
										echo '</p>';
									$this->_advancedToggleBoxEnd( $leftQuery);

								echo '</div>';
							}

							$rightQuery = $oneItem->get('right');

							if( $rightQuery->exists('right-paragraph') ){
								echo '<div class="ffb-specification__right-side">';
									$this->_advancedToggleBoxStart( $rightQuery );
										echo '<p>';
											foreach( $rightQuery->get('right-paragraph') as $oneParagraphItem ) {
												switch( $oneParagraphItem->getVariationType() ) {
													case 'text':
														echo '<span>' . $oneParagraphItem->get('text') . '</span>';
														break;

													case 'icon':
														echo '<i class="ffb-specification-icon '.$oneParagraphItem->get('icon').'"></i>';
														break;
												}

												$css = '';

												$marginLeft = $oneParagraphItem->get('margin-left');
												if( !empty( $marginLeft) ) {
													$css .= 'margin-left:'.$marginLeft.'px;';
												}

												$color = $oneParagraphItem->getColor('color');
												if( !empty( $color ) ) {
													$css .= 'color:' . $color .';';
												}

												if( !empty( $css ) ) {
													$this->_getAssetsRenderer()
														->createCssRule()
														->addParamsString( $css);
												}
											}
										echo '</p>';
									$this->_advancedToggleBoxEnd( $rightQuery);
								echo '</div>';
							}


						echo '</div>';
					echo '</div>';
				echo '</div>';

			}

		echo '</div>';


		$dividerSize = $query->get('divider-size');
		$dividerColor = $query->getColor('divider-color');
		if( !empty( $dividerColor ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item')
				->addParamsString('border-bottom:'.$dividerSize.'px solid '. $dividerColor .';');
		}

		$dividerFirst = $query->get('divider-show-first');
		$dividerLast = $query->get('divider-show-last');

		if( $dividerFirst && !empty( $dividerColor )) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item:first-child')
				->addParamsString('border-top:'.$dividerSize.'px solid '. $dividerColor .';');
		}

		if( !$dividerLast && !empty( $dividerColor ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item:last-child')
				->addParamsString('border-bottom:none;');
		}

		$verticalGap = $query->get('vertical-gap');

		if( !empty($verticalGap) ) {
			$half = ceil( $verticalGap / 2);

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item')
				->setParam('padding-top', $half.'px')
				->setParam('padding-bottom', $half.'px')
				;
		}

		$horizontalGap = $query->get('horizontal-gap');
		if( !empty( $horizontalGap ) ) {
//			$half = ceil( $verticalGap / 2);

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification__left-side')
				->setParam('padding-left', $horizontalGap.'px')
			;

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification__right-side')
				->setParam('padding-right', $horizontalGap.'px')
			;
		}


		$evenLineBackground = $query->getColor('even-line-background-color');
		if( !empty( $evenLineBackground ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item-even')
				->setParam('background-color', $evenLineBackground )
			;
		}

		$oddLineBackground = $query->getColor('odd-line-background-color');
		if( !empty( $oddLineBackground ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.ffb-specification-item-odd')
				->setParam('background-color', $oddLineBackground )
			;
		}


	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {

						var heading = '';

						if( query.queryExists('left left-paragraph') ) {
							query.get('left left-paragraph').each(function(query, variationType){
								switch( variationType ) {
									case 'text':
										heading += query.get('text');
								}
							});
						}

						if( query.queryExists('right right-paragraph') ) {
							heading += ' - ';
							query.get('right right-paragraph').each(function(query, variationType){
								switch( variationType ) {
									case 'text':
										heading += query.get('text');
								}
							});
						}

						query.addText(null, heading );

					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}