<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_contacts.html#scrollTo__1355
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__7763
 */

class ffElMap extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'map');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Map', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'map');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'map, google map, gmap');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ));
				$s->addElement(ffOneElement::TYPE_HTML, 'TYPE_HTML', '<p class="warning">'.
					ark_wp_kses( __('Please note that you must have a valid Google API key in order to make the Google Map work. You can insert your Google API key in <a href="./admin.php?page=ThemeOptions#GoogleApi" target="_blank"> WP Admin > Theme Options > Google API</a>.', 'ark') )
					.'</p>');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					$s->startRepVariationSection('label', ark_wp_kses( __('Map Marker', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'lat', '', '40.714236')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Latitude', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'long', '', '-73.9634776')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Longitude', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', ark_wp_kses( __('Description Text or HTML', 'ark' ) ), '<strong>Our Office</strong> <br> 277 Bedford Avenue, <br> Brooklyn, NY 11211, <br> New York, USA')
							->addParam('print-in-content', true);
						$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'map-marker-image', ark_wp_kses(__('Map Marker Image', 'ark')), '');

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('You can place multiple markers on the Map. If you do, the Map will be centered in an auto-calculated center point between all your Markers. It might also be necessary to lower the Map Zoom Level in order to display all these Markers at once.', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Map Zoom Level', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'zoom', '', '3')
					->addSelectValue(esc_attr( __('1 (The Earth)', 'ark' ) ), 1)
					->addSelectValue(2, 2)
					->addSelectValue(esc_attr( __('3 (Continents)', 'ark' ) ), 3)
					->addSelectValue(4, 4)
					->addSelectValue(esc_attr( __('5 (States)', 'ark' ) ), 5)
					->addSelectValue(6, 6)
					->addSelectValue(7, 7)
					->addSelectValue(esc_attr( __('8 (Countries)', 'ark' ) ), 8)
					->addSelectValue(9, 9)
					->addSelectValue(10, 10)
					->addSelectValue(esc_attr( __('11 (Cities)', 'ark' ) ), 11)
					->addSelectValue(12, 12)
					->addSelectValue(esc_attr( __('13 (Roads)', 'ark' ) ), 13)
					->addSelectValue(esc_attr( __('14 (Main Streets)', 'ark' ) ), 14)
					->addSelectValue(15, 15)
					->addSelectValue(esc_attr( __('16 (Streets)', 'ark' ) ), 16)
					->addSelectValue(esc_attr( __('17 (Little Streets)', 'ark' ) ), 17)
					->addSelectValue(esc_attr( __('18 (House Numbers)', 'ark' ) ), 18)
					->addSelectValue(19, 19)
					->addSelectValue(20, 20)
					->addParam('print-in-content', true);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Map Style', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'style', '', 'stylemuted')
					->addSelectValue(esc_attr( __('Default', 'ark' ) ), 'styledefault')
					->addSelectValue(esc_attr( __('Muted', 'ark' ) ), 'stylemuted')
					->addSelectValue(esc_attr( __('Custom', 'ark' ) ), 'stylecustom')
					->addParam('print-in-content', true);
				$s->startHidingBox('style', 'stylecustom');
					$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'custom-style-json', '', '');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('You can style your map by custom JSON strings. For more info look for example <a target="_blank" href="https://snazzymaps.com">Snazzy Maps</a>. Simply copy&paste the generated JSON here.', 'ark' ) ) );
				$s->endHidingBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Map Height', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'height', '', '300')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('px', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Map Control', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'zoom-mouse-wheel', 'Zoom Mouse Wheel', 1);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'zoom-double-click', 'Zoom Double Click', 1);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'draggable', 'Draggable', 1);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'disable-default-ui', 'Disable Default UI', 0);
//		disableDefaultUI
		//draggable

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', null)
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
		}//scrollwheel

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );
		$this->getAssetsRenderer()->createCssRule()
			->addParamsString('height:'. $query->getEscAttr('height') . 'px;');

		$counter = 0;
		$labels = '';
		foreach( $query->getWithoutCallbacks('content') as $oneItem ) {
			$counter++;
			$labels .= ' data-label-coordinates-'.$counter.'="';
			$labels .= $oneItem->getEscAttr('lat') . ';';
			$labels .= $oneItem->getEscAttr('long') . '"';
			$labels .= ' data-label-text-'.$counter.'="';
			$labels .= $oneItem->getEscAttr('text') . '"';

			$img = $oneItem->getWithoutComparationDefault('map-marker-image');

			$labels .= ' data-label-map-marker-'.$counter.'="';
			$labels .= esc_attr( $img ) . '" ';
		}


		$data = array();
		$data['zoom_mouse_wheel'] = $query->getWithoutComparationDefault('zoom-mouse-wheel', 1);
		$data['zoom_double_click'] = $query->getWithoutComparationDefault('zoom-double-click', 1);
		$data['draggable'] = $query->getWithoutComparationDefault('draggable', 1);
		$data['disable_default_ui'] = $query->getWithoutComparationDefault('disable-default-ui', 0);
		if( $query->get('style') == 'stylecustom' ) {
			$data['custom_style_json'] = $query->get('custom-style-json');
		}


		$dataJSON = json_encode( $data );

		echo '<section class="ff-map map" '.$labels.' data-ff-settings="'.esc_attr( $dataJSON ).'" data-label-count="'.$counter.'" data-zoom="'.$query->getEscAttr('zoom').'" data-style="'.$query->getEscAttr('style').'">';
		$g_api_key = ffThemeOptions::getQuery('gapi key');
		if( empty($g_api_key)){
			echo '<br />';
			echo '<br />';
			echo '<p class="text-center">';
			echo ark_wp_kses( __('Google API key not found.','ark') );
			echo '<br />';
			echo '<br />';
			echo ark_wp_kses( __('In order to make the Map element work, you need to input your Google API key in Theme Options.','ark') );
			echo '</p>';
			echo '<br />';
			echo '<br />';
		}else{
			wp_enqueue_script( 'ark-google-map-multiple-info-marker' );
		}
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				if(query.queryExists('content')) {
					query.addPlainText('<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ff-font-et-line icon-map"></i></div>');
				}

				 if(query.queryExists('content')) {
				 	query.get('content').each(function (query, variationType) {
				 		if (variationType == 'label') {
				 			query.addText('text');
				 		}
				 	});
				 }

			}
		</script data-type="ffscript">
	<?php
	}


}