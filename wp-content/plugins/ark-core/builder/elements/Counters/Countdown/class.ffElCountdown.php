<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_3.html#scrollTo__1200
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_counters.html#scrollTo__330
 */

class ffElCountdown extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'countdown');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Countdown', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'counter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'counter, counters, count, count down, countdown');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE LABEL
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('item', ark_wp_kses( __('Counting Item', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-overlay', '', 'rgba(255, 255, 255, 0.2)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
						;
						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('content');

							$s->startRepVariationSection('time', 'Number');

								$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', 'day')
									->addSelectValue('Year', 'year')
									->addSelectValue('Month', 'month')
									->addSelectValue('Week', 'week')
									->addSelectValue('Day', 'day')
									->addSelectValue('Hour', 'hour')
									->addSelectValue('Minute', 'minute')
									->addSelectValue('Second', 'second')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Type', 'ark' ) ) );


								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-number', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number Color', 'ark' ) ) )
								;

							$s->endRepVariationSection();


							$s->startRepVariationSection('text', 'Text');
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'description', '', 'Day')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Description', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-description', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Description Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();
						$s->endRepVariableSection();
					$s->endRepVariationSection();
				$s->endRepVariableSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('General', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'countdown-type', '', 'since')
					->addSelectValue(esc_attr( __('Until', 'ark' ) ), 'until')
					->addSelectValue(esc_attr( __('Since', 'ark' ) ), 'since')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Countdown Type', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'leading-zeros', ark_wp_kses( __('Add leading zeros', 'ark' ) ),  0 );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'countdown-date', '', '1 january 2016')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Countdown Date', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: The date will be parsed trough PHP <a href="//php.net/manual/en/function.strtotime.php" target="_blank">strtotime</a> function.');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getTypeToValueMap() {
		$map = array();
		$map['year'] = '{yn}';
		$map['month'] = '{on}';
		$map['week'] = '{wn}';
		$map['day'] = '{dn}';
		$map['hour'] = '{hn}';
		$map['minute'] = '{mn}';
		$map['second'] = '{sn}';

		return $map;
	}

	protected function _getTypeToValueMapWithZeros() {
		$map = array();
		$map['year'] = '{yn}';
		$map['month'] = '{onn}';
		$map['week'] = '{wnn}';
		$map['day'] = '{dnn}';
		$map['hour'] = '{hnn}';
		$map['minute'] = '{mnn}';
		$map['second'] = '{snn}';

		return $map;
	}

	protected function _getTypeToFormatMap() {
		$map = array();
		$map['year'] = 'Y';
		$map['month'] = 'O';
		$map['week'] = 'W';
		$map['day'] = 'D';
		$map['hour'] = 'H';
		$map['minute'] = 'M';
		$map['second'] = 'S';

		return $map;
	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-countdown' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}


		if( $query->getWithoutComparationDefault('leading-zeros', 0) ){
			$map = $this->_getTypeToValueMap();
		}else{
			$map = $this->_getTypeToValueMapWithZeros();
		}
		$formatMap = $this->_getTypeToFormatMap();
		$layout = '';


		$layout .= '<span class="countdown_row countdown_show4">';
		$format = '';

		ob_start();
		foreach( $query->get('content') as $oneItem ) {

			echo '<span class="countdown_section countdown_type_'.''.'">';

			foreach( $oneItem->get('content') as $oneContentItem ) {

				if( $oneContentItem->getVariationType() == 'time' ) {
					$type = $oneContentItem->get('type');

					$format .= $formatMap[ $type ];
					$typeForPlugin = $map[ $type ];
					echo '<div class="countdown_amount">' . $typeForPlugin . '</div>';

					if( $oneContentItem->get('color-number') ) {
						$this->_getAssetsRenderer()
							->createCssRule()
							->addParamsString('color:' . $oneContentItem->get('color-number') . ' !important;');
					}

				} else {
					echo '<div class="countdown_description">' . $oneContentItem->get('description') . '</div>';

					if( $oneContentItem->get('color-description') ) {
						$this->_getAssetsRenderer()
							->createCssRule()
							->addParamsString('color:' . $oneContentItem->get('color-description') . ' !important;');
					}
				}

			}
			echo '</span>';
			$this->_getAssetsRenderer()
				->createCssRule()
				->addParamsString('background-color:' . $oneItem->get('color-overlay'));

		}

		$layout .= ob_get_contents();
		ob_end_clean();

		$layout .= '</span>';

		$data = array();
		$data['date'] = strtotime( $query->get('countdown-date') );
		$data['type'] = $query->get('countdown-type');
		$data['format'] = $format;

		$dataJSON = json_encode( $data );
		$dataEscaped = esc_attr( $dataJSON );

		echo '<div class="ffb-countdown-wrapper '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-left' ) )
			. '" data-settings="'.$dataEscaped.'">';
			echo '<div class="ffb-countdown countdown-v1"></div>';
			echo '<div class="ffb-countdown-layout hidden">' . $layout . '</div>';
		echo '</div>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

//				if(query.queryExists('content')) {
//
//					query.addPlainText('<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ff-font-awesome4 icon-clock-o"></i></div>');
//
//					var capitalizeFirstLetter = function (string) {
//						return string[0].toUpperCase() + string.slice(1);
//					};
//
//					var type = capitalizeFirstLetter( query.get('countdown-type') );
//
//					query.addHeadingSm(null, type + ': ' + query.get('countdown-date') );
//
//					var usedTypes = [];
//
//					query.get('content').each(function(query, variationType ){
//
//						query.get('content').each(function( query, variationType){
//							if( variationType == 'time'  ) {
//								usedTypes.push( capitalizeFirstLetter( query.get('type') ) );
//							}
//						});
//					});
//
//					query.addText( null, usedTypes.join(', '));
//				}

			}
		</script data-type="ffscript">
	<?php
	}


}