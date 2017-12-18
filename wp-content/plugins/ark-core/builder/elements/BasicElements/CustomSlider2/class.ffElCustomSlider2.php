<?php

/**
 * @link
 */

class ffElCustomSlider2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'custom-slider2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Carousel (Custom)', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slider, carousel, slide');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addDropzoneWhitelistedElement('slide');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Carousel Settings', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-loop', ark_wp_kses( __('Loop Carousel', 'ark' ) ), 1);

				$s->addOption(ffOneOption::TYPE_CHECKBOX,'has-autoplay',ark_wp_kses( __('Auto-play with an interval of &nbsp;', 'ark' ) ),0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'speed','',1000)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ms', 'ark' ) ) )
				;

				$s->addOptionNL(ffOneOption::TYPE_TEXT,'scrolling-speed','', 450 )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sliding speed (in ms)', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'stage-padding', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Inner Slider Offset (in px)', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-autoheight', ark_wp_kses( __('Automatically resize the Carousel height based on the active Slide', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: Auto-resizing works only if you have only one visible Slide at a time.', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Carousel Navigation', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', '', 'arrows')
					->addSelectValue( 'Arrows under the Carousel', 'arrows')
					->addSelectValue( 'Arrows on sides', 'arrows2')
					->addSelectValue( 'Dots under the Carousel', 'dots')
					->addSelectValue( 'None', 'none')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Navigation Type', 'ark' ) ) )
				;
				
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				/*----------------------------------------------------------*/
				/* ARROWS SETTINGS
				/*----------------------------------------------------------*/
				
				$s->startHidingBox('type', 'arrows' );
					$s->startAdvancedToggleBox('arrows', 'Arrows Settings');

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'l-arrow', ark_wp_kses( __('Left Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-left');

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'r-arrow', ark_wp_kses( __('Right Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-right');

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color-hover', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Hover Color', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background', '' )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background-hover', '' )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Hover Color', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-top', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Top (in px)', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-bottom','', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Bottom (in px)', 'ark' ) ) );

					$s->endAdvancedToggleBox();
				$s->endHidingBox();

				/*----------------------------------------------------------*/
				/* ARROWS 2 SETTINGS
				/*----------------------------------------------------------*/
				$s->startHidingBox('type', 'arrows2' );
					$s->startAdvancedToggleBox('arrows2', 'Arrows 2 Settings');

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'l-arrow', ark_wp_kses( __('Left Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-left');

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'r-arrow', ark_wp_kses( __('Right Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-right');

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOption(ffOneOption::TYPE_TEXT, 'arrows-distance', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Distance (in px)', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color-hover', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Hover Color', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background', '' )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background-hover', '' )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Hover Color', 'ark' ) ) );

					$s->endAdvancedToggleBox();
				$s->endHidingBox();

				/*----------------------------------------------------------*/
				/* DOTS SETTINGS
				/*----------------------------------------------------------*/
				$s->startHidingBox('type', 'dots' );
					$s->startSection('dots');
						$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Dots Settings', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots-color', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Dots Color', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'dots-active-color', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Dots Active Color', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-top', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Top (in px)', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'margin-bottom','', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Margin Bottom (in px)', 'ark' ) ) );

						$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_END);
					$s->endSection();
				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'xs', '', '1')
					->addSelectValue( '1 Slide', '1')
					->addSelectValue( '2 Slides', '2')
					->addSelectValue( '3 Slides', '3')
					->addSelectValue( '4 Slides', '4')
					->addSelectValue( '5 Slides', '5')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Phone (XS)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'sm', '', '1')
					->addSelectValue( '1 Slide', '1')
					->addSelectValue( '2 Slides', '2')
					->addSelectValue( '3 Slides', '3')
					->addSelectValue( '4 Slides', '4')
					->addSelectValue( '5 Slides', '5')
					->addSelectValue( '6 Slides', '6')
					->addSelectValue( '7 Slides', '7')
					->addSelectValue( '8 Slides', '8')
					->addSelectValue( '9 Slides', '9')
					->addSelectValue( '10 Slides', '10')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Tablet (SM)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'md', '', '1')
					->addSelectValue( '1 Slide', '1')
					->addSelectValue( '2 Slides', '2')
					->addSelectValue( '3 Slides', '3')
					->addSelectValue( '4 Slides', '4')
					->addSelectValue( '5 Slides', '5')
					->addSelectValue( '6 Slides', '6')
					->addSelectValue( '7 Slides', '7')
					->addSelectValue( '8 Slides', '8')
					->addSelectValue( '9 Slides', '9')
					->addSelectValue( '10 Slides', '10')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Laptop (MD)', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'lg', '', '1')
					->addSelectValue( '1 Slide', '1')
					->addSelectValue( '2 Slides', '2')
					->addSelectValue( '3 Slides', '3')
					->addSelectValue( '4 Slides', '4')
					->addSelectValue( '5 Slides', '5')
					->addSelectValue( '6 Slides', '6')
					->addSelectValue( '7 Slides', '7')
					->addSelectValue( '8 Slides', '8')
					->addSelectValue( '9 Slides', '9')
					->addSelectValue( '10 Slides', '10')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Desktop (LG)', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _printDotStyles( $query ) {

		if( $query->get('type') != 'dots' ) {
			return;
		}


		$query = $query->get('dots');

		$dotsColor = $query->getColor('dots-color');
		$dotsActiveColor = $query->getColor('dots-active-color');

		$marginTop = $query->get('margin-top');
		$marginBottom = $query->get('margin-bottom');

		if( !empty($dotsColor) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.owl-controls .owl-dot span', false)
				->addParamsString('border-color: ' . $dotsColor .' !important;');
		}

		if( !empty($dotsActiveColor) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.owl-controls .owl-dot.active span', false)
				->addParamsString('border-color: ' . $dotsActiveColor .' !important; background-color: ' . $dotsActiveColor . ' !important;');
		}

		$marginString = '';
		if( !empty( $marginTop ) or ("0" === $marginTop) ) {
			$marginString .= 'margin-top: ' . $marginTop . 'px;' . PHP_EOL;
		}

		if( !empty( $marginBottom ) or ("0" === $marginBottom) ) {
			$marginString .= 'margin-bottom: ' . $marginBottom . 'px;' . PHP_EOL;
		}

		if( !empty( $marginString ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.owl-dots')
				->addParamsString( $marginString );
		}


	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderArrowColors( $query ) {
		if( ! $query->exists('arrows-color') ){
			return;
		}


		$arrowsColor = $query->getColor('arrows-color');
		$arrowsBackground = $query->getColor('arrows-background');

		$arrowsColorHover = $query->getColor('arrows-color-hover');
		$arrowsBackgroundHover = $query->getColor('arrows-background-hover');

		$marginTop = $query->get('margin-top');
		$marginBottom = $query->get('margin-bottom');

		if( !empty( $arrowsColor ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow', false)
				->addParamsString('color: ' . $arrowsColor .';');
		}

		if( !empty( $arrowsBackground ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow', false)
				->addParamsString('background: ' . $arrowsBackground .';');
		}

		if( !empty( $arrowsColorHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow:hover', false)
				->addParamsString('color: ' . $arrowsColorHover .';');
		}

		if( !empty( $arrowsBackgroundHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow:hover', false)
				->addParamsString('background: ' . $arrowsBackgroundHover .';');
		}

		$marginString = '';
		if( !empty( $marginTop ) ) {
			$marginString .= 'margin-top: ' . $marginTop . 'px;' . PHP_EOL;
		}

		if( !empty( $marginBottom ) ) {
			$marginString .= 'margin-bottom: ' . $marginBottom . 'px;' . PHP_EOL;
		}

		if( !empty( $marginString ) ) {
			$this->_getAssetsRenderer()
				->createCssRule()
				->addParamsString( $marginString );
		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderArrow2Colors( $query ) {
		if( ! $query->exists('arrows-color') ){
			return;
		}
		$arrowsColor = $query->getColor('arrows-color');
		$arrowsBackground = $query->getColor('arrows-background');

		$arrowsColorHover = $query->getColor('arrows-color-hover');
		$arrowsBackgroundHover = $query->getColor('arrows-background-hover');


		$margin = $query->getWithoutComparationDefault('arrows-distance');

		if( $margin != null ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.ff-owl-controls-item-prev .owl-arrow', false)
				->addParamsString('margin-left: -' . $margin .'px;');

			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.ff-owl-controls-item-next .owl-arrow', false)
				->addParamsString('margin-right: -' . $margin .'px;');
		}

		if( !empty( $arrowsColor ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow', false)
				->addParamsString('color: ' . $arrowsColor .';');
		}

		if( !empty( $arrowsBackground ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow', false)
				->addParamsString('background: ' . $arrowsBackground .';');
		}

		if( !empty( $arrowsColorHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow:hover', false)
				->addParamsString('color: ' . $arrowsColorHover .';');
		}

		if( !empty( $arrowsBackgroundHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('.owl-arrow:hover', false)
				->addParamsString('background: ' . $arrowsBackgroundHover .';');
		}
		
	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-custom-owl-carousel' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		wp_enqueue_script( 'ark-custom-owl-carousel' );
		$this->_printDotStyles( $query );

		echo '<div class="ff-owl-carousel ff-custom-slider-2">';

		if( $query->get('has-loop') ){
			$dataSlider['loop'] = true;
		}else{
			$dataSlider['loop'] = false;
		}

		if( $query->get('has-autoplay') ){
			$dataSlider['autoplay'] = true;
		}else{
			$dataSlider['autoplay'] = false;
		}


		if( $query->get('type') == 'dots' ){
			$dataSlider['dots'] = true;
		}else{
			$dataSlider['dots'] = false;
		}

		if( '' === $query->getWithoutComparationDefault('stage-padding', '') ){
			$dataSlider['stagePadding'] = "0";
		} else {
			$dataSlider['stagePadding'] = $query->getWithoutComparationDefault('stage-padding', '');
		}

		$dataSlider['speed'] = $query->get('speed');

		$dataSlider['smartSpeed'] = $query->get('scrolling-speed');

		$dataSlider['xs'] = $query->get('xs');
		$dataSlider['sm'] = $query->get('sm');
		$dataSlider['md'] = $query->get('md');
		$dataSlider['lg'] = $query->get('lg');

		if( $query->getWithoutComparationDefault('has-autoheight', 1) ){
			$dataSlider['autoHeight'] = true;
		}else{
			$dataSlider['autoHeight'] = false;
		}

		if (
			1 < $dataSlider['xs'] ||
			1 < $dataSlider['sm'] ||
			1 < $dataSlider['md'] ||
			1 < $dataSlider['lg']
			) {
			$dataSlider['autoHeight'] = false;	
		}

		$dataSliderJson = json_encode( $dataSlider);

		echo '<div class="ff-one-owl-carousel" data-slider="'.esc_attr($dataSliderJson).'">';

			echo ( $this->_doShortcode( $content ) );

		echo '</div>';

		if( $query->get('type') == 'arrows' ){

			$arrows = $query->get('arrows');

			$this->_advancedToggleBoxStart( $arrows );

				echo '<div class="owl-control-arrows-v1 ff-owl-controls text-center">';
					echo '<span class="ff-owl-controls-item-prev">';
						echo '<span class="owl-arrow radius-3 '.$arrows->getWpKses('l-arrow').'"></span>';
					echo '</span>';
					echo '<span class="ff-owl-controls-item-next">';
						echo '<span class="owl-arrow radius-3 '.$arrows->getWpKses('r-arrow').'"></span>';
					echo '</span>';
				echo '</div>';

				$this->_renderArrowColors( $arrows );

			$this->_advancedToggleBoxEnd( $arrows );
		}

		if( $query->get('type') == 'arrows2' ){

			$arrows = $query->get('arrows2');

			$this->_advancedToggleBoxStart( $arrows );

				echo '<div class="owl-control-arrows-v2 ff-owl-controls text-center">';
					echo '<span class="ff-owl-controls-item-prev">';
						echo '<span class="owl-arrow '.$arrows->getWpKses('l-arrow').'"></span>';
					echo '</span>';
					echo '<span class="ff-owl-controls-item-next">';
						echo '<span class="owl-arrow '.$arrows->getWpKses('r-arrow').'"></span>';
					echo '</span>';
				echo '</div>';

				$this->_renderArrow2Colors( $arrows );

			$this->_advancedToggleBoxEnd( $arrows );
		}

		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {


			}
		</script data-type="ffscript">
	<?php
	}


}