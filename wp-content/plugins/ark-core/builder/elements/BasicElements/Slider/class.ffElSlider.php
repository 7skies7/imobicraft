<?php

/**
 * @link
 */

class ffElSlider extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'slider');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Slider (Custom)', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'slider, slide');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addDropzoneWhitelistedElement('slide');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'sliding-effect', '', 'slide')
					->addSelectValue( 'Slide', 'carousel-slide')
					->addSelectValue( 'Fade', 'carousel-fade')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sliding effect', 'ark' ) ) )
				;

				$s->addOption(ffOneOption::TYPE_CHECKBOX,'use-auto',ark_wp_kses( __('Auto-play with an interval of &nbsp;', 'ark' ) ),0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'speed','',5000)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ms', 'ark' ) ) )
				;
				$s->startHidingBox('use-auto', 'checked');
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-hover',ark_wp_kses( __('Pause autoplay on hover', 'ark' ) ),0);
				$s->endHidingBox();

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-loop',ark_wp_kses( __('Loop Slider', 'ark' ) ),0);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Navigation', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-navigation', ark_wp_kses( __('Show navigation', 'ark' ) ), 1);

				$s->startHidingBox('use-navigation', 'checked');

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

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

				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderColors( $query ) {
		if( ! $query->exists('arrows-color') ){
			return;
		}
		$this->_renderCSSRule('color', $query->getColor('arrows-color'), 'span.carousel-control-arrows-v1' );
		$this->_renderCSSRule('background', $query->getColor('arrows-background'), 'span.carousel-control-arrows-v1' );
		$this->_renderCSSRule('color', $query->getColor('arrows-color-hover'), 'span.carousel-control-arrows-v1:hover' );
		$this->_renderCSSRule('background', $query->getColor('arrows-background-hover'), 'span.carousel-control-arrows-v1:hover' );

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( empty($content) ){
			return;
		}

		$this->_renderColors( $query );

		if($query->get('use-auto')){
			$dataSlider['auto'] = true;
		}else{
			$dataSlider['auto'] = false;
		}

		if($query->get('use-hover')){
			$dataSlider['hover'] = true;
		}else{
			$dataSlider['hover'] = false;
		}

		if($query->get('use-loop')){
			$dataSlider['loop'] = true;
		}else{
			$dataSlider['loop'] = false;
		}
		$dataSlider['speed'] = $query->getWpKses('speed');
		$datasliderJson = json_encode( $dataSlider);

		$slidingEffect = $query->get('sliding-effect');

		echo '<div id="'.$uniqueId.'" class="ff-slider slide '.$slidingEffect.' " data-ride="carousel" data-slider="'.esc_attr($datasliderJson).'">';

			echo '<div class="carousel-inner" role="listbox">';

				echo ( $this->_doShortcode( $content ) );

			echo '</div>';

			if( $query->get('use-navigation') ){
				echo '<a class="left carousel-control theme-carousel-control-v1 radius-3" href="#'.$uniqueId.'" role="button" data-slide="prev">';
				echo '<span class="carousel-control-arrows-v1 radius-3 '. $query->getEscAttr('l-arrow') .'" aria-hidden="true"></span>';
				echo '</a>';
				echo '<a class="right carousel-control theme-carousel-control-v1 radius-3" href="#'.$uniqueId.'" role="button" data-slide="next">';
				echo '<span class="carousel-control-arrows-v1 radius-3 '. $query->getEscAttr('r-arrow') .'" aria-hidden="true"></span>';
				echo '</a>';
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