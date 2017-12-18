<?php

/**
 * @link
 */

class ffElImageSlider extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'imageSlider');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Image Slider', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'image, slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					$s->startRepVariationSection('one-slide', ark_wp_kses( __('Image', 'ark' ) ));


						$this->_getBlock( ffThemeBlConst::IMAGE )->injectOptions( $s );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'l-arrow', ark_wp_kses( __('Left Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-left');

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'r-arrow', ark_wp_kses( __('Right Arrow', 'ark' ) ), 'ff-font-awesome4 icon-angle-right');

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOption(ffOneOption::TYPE_CHECKBOX,'use-auto',ark_wp_kses( __('Use auto-play with speed &nbsp;', 'ark' ) ),0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'speed','',5000)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ms', 'ark' ) ) );
				;
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-hover',ark_wp_kses( __('Pause auto-play when hovering over the slider', 'ark' ) ),0);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-loop',ark_wp_kses( __('Loop slides', 'ark' ) ),0);

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-navigation', ark_wp_kses( __('Show navigation', 'ark' ) ), 1);

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Icon Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-color-hover', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Icon Color Hover', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Color', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background-hover', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Background Color Hover', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}



	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ){
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


		echo '<div id="'.$uniqueId.'" class="ff-slider slide carousel-fade" data-ride="carousel" data-slider="'.esc_attr($datasliderJson).'">';

		echo '<div class="carousel-inner" role="listbox">';

		foreach( $query->get('content') as $oneSlide ) {

			echo '<div class="item ">';

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneSlide ) ) {
				echo '<a ';
				$this->_getBlock(ffThemeBuilderBlock::LINK)->render($oneSlide);
				echo ' >';
			}
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('img',false)
				->addParamsString('margin: auto');
			$this->_getBlock( ffThemeBlConst::IMAGE )->render( $oneSlide );
			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneSlide ) ) {
				echo '</a>';
			}
			echo '</div>';

		}

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

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	private function _renderColors( $query ) {
		$arrowsColor = $query->getColor('arrows-color');
		$arrowsBackground = $query->getColor('arrows-background');

		$arrowsColorHover = $query->getColor('arrows-color-hover');
		$arrowsBackgroundHover = $query->getColor('arrows-background-hover');

		if( !empty( $arrowsColor ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('span.carousel-control-arrows-v1', false)
				->addParamsString('color: ' . $arrowsColor .';');
		}

		if( !empty( $arrowsBackground ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('span.carousel-control-arrows-v1', false)
				->addParamsString('background: ' . $arrowsBackground .';');
		}

		if( !empty( $arrowsColorHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('span.carousel-control-arrows-v1:hover', false)
				->addParamsString('color: ' . $arrowsColorHover .';');
		}

		if( !empty( $arrowsBackgroundHover ) ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addSelector('span.carousel-control-arrows-v1:hover', false)
				->addParamsString('background: ' . $arrowsBackgroundHover .';');
		}
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {
				if( query.exists( 'content') ) {
					query.get('content').each(function (query, variationType) {
						blocks.render('image', query);
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}