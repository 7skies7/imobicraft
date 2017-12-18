<?php

class ffElBeforeAfterSlider extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'before-after-slider');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Before After Slider', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'image, img, compare, slider');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Before Image', 'ark' ) ) );
				$s->startSection('before');

					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsForcedResponsive()
						->imgIsForcedFullWidth()
						->injectOptions( $s );

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Before')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'width', '', '130')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Width (in px)', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-labels-background-color', '' , 'rgba(255, 255, 255, 0.2)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Background Color', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-labels-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Color', 'ark' ) ) );

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('After Image', 'ark' ) ) );
				$s->startSection('after');

					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsForcedResponsive()
						->imgIsForcedFullWidth()
						->injectOptions( $s );

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'After')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'width', '', '130')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Width (in px)', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-labels-background-color', '' , 'rgba(255, 255, 255, 0.2)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Background Color', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-labels-color', '' , '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Color', 'ark' ) ) );

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Slider', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'orientation', '', 'horizontal')
					->addSelectValue('Vertical', 'vertical')
					->addSelectValue('Horizontal', 'horizontal')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Type', 'ark' ) ) );
				;
				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'aspect-ratio', '', '1')
					->addSelectValue('Same as Before Image', '1')
					->addSelectValue('Same as After Image', '2')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width and Height', 'ark' ) ) );
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Handle', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'position', '', '50')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Position in percent', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Hover Overlay Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-background-color', '' , 'rgba(0, 0, 0, 0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Please note, that if Before Image and After Image Label Text are empty, then overlay is disabled.', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Handle Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'circle-arrows-color', '' , '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'circle-background-color', '' , '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'circle-border-color', '' , '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'circle-shadow-color', '' , 'rgba(51, 51, 51, 0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Shadow', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Divider Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lines-color', '' , '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Line', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lines-shadow-color', '' , 'rgba(51, 51, 51, 0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Shadow', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script('ark-twentytwenty');
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		echo '<div>';

		$orientation = $query->get('orientation');

		echo '<div class="ark-twentytwenty ark-twentytwenty-'.$orientation.'"';
		echo ' data-orientation="'.$query->get('orientation').'"';
		echo ' data-offset-pct="'.( absint( $query->get('position') ) / 100 ).'"';
		echo '>';

		if( 1 == $query->getColorWithoutComparationDefault('aspect-ratio', 1) ){
			$beforeData = $this->_getBlock(ffThemeBlConst::IMAGE)
				->imgIsResponsive()
				->imgIsFullWidth()
				->returnJsonInsteadOfImage()
				->get( $query->get('before') );
			$beforeData = json_decode( $beforeData, true );
			$width = $beforeData['width'];
			$height = $beforeData['height'];

			echo $beforeData['img_html'];

			$this->_getBlock(ffThemeBlConst::IMAGE)
				->imgIsResponsive()
				->imgIsFullWidth()
				->imgHasForcedWidthAndHeight()
				->setParam('width', $width)
				->setParam('height', $height)
				->render( $query->get('after') );
		}else{
			$afterData = $this->_getBlock(ffThemeBlConst::IMAGE)
				->imgIsResponsive()
				->imgIsFullWidth()
				->returnJsonInsteadOfImage()
				->get( $query->get('after') );
			$afterData = json_decode( $afterData, true );
			$width = $afterData['width'];
			$height = $afterData['height'];

			$this->_getBlock(ffThemeBlConst::IMAGE)
				->imgIsResponsive()
				->imgIsFullWidth()
				->imgHasForcedWidthAndHeight()
				->setParam('width', $width)
				->setParam('height', $height)
				->render( $query->get('before') );

			echo $afterData['img_html'];
		}


		echo '</div>';
		echo '</div>';


		// Fixes twenty20 css plugin

		if( 'vertical' == $orientation ){
			$this->_renderCSSRule('padding', '0px', '.ark-twentytwenty-vertical .twentytwenty-before-label:before');
			$this->_renderCSSRule('padding', '0px', '.ark-twentytwenty-vertical .twentytwenty-after-label:before');
		}

		if( 'horizontal' == $orientation ) {
			$this->_renderCSSRule('text-align', 'center', '.twentytwenty-before-label:before');
			$this->_renderCSSRule('text-align', 'center', '.twentytwenty-after-label:before');
		}



			// Label BEFORE on hover
		$text_before = $query->getColorWithoutComparationDefault('before title', 'Before');
		$text_before = str_replace('"', "", $text_before);
		$text_before = str_replace("'", "", $text_before);
		$this->_renderCSSRule('content', '"'.$text_before.'"', '.twentytwenty-before-label:before');

		// Label BEFORE width
		$width = absint( $query->getColorWithoutComparationDefault('before width', 130) );
		if( $width < 38 ){
			$width = 38;
		}
		if( 'vertical' == $orientation ) {
			$this->_renderCSSRule('margin-left', '-' . absint($width / 2) . 'px', '.twentytwenty-before-label:before');
		}
		$this->_renderCSSRule('min-width', $width.'px' , '.twentytwenty-before-label:before');

		// Overlay Labels BEFORE Background
		$overlay_labels_background_color = $query->getColorWithoutComparationDefault('before overlay-labels-background-color', 'rgba(255, 255, 255, 0.2)');
		if( empty( $overlay_labels_background_color ) ){
			$overlay_labels_background_color = 'rgba(0,0,0,0)';
		}
		if( 'rgba(255, 255, 255, 0.2)' != $overlay_labels_background_color ){
			$this->_renderCSSRule('background-color', $overlay_labels_background_color, '.twentytwenty-before-label:before');
		}

		// Overlay Labels BEFORE Color
		$overlay_labels_color = $query->getColorWithoutComparationDefault('before overlay-labels-color', '#ffffff');
		if( '#ffffff' != $overlay_labels_color ){
			$this->_renderCSSRule('color', $overlay_labels_color, '.twentytwenty-before-label:before');
		}


		// Label AFTER on hover
		$text_after = $query->getColorWithoutComparationDefault('after title', 'After');
		$text_after = str_replace('"', "", $text_after);
		$text_after = str_replace("'", "", $text_after);
		$this->_renderCSSRule('content', '"'.$text_after.'"', '.twentytwenty-after-label:before');

		// Label AFTER width
		$width = absint( $query->getColorWithoutComparationDefault('after width', 130) );
		if( $width < 38 ){
			$width = 38;
		}
		if( 'vertical' == $orientation ) {
			$this->_renderCSSRule('margin-left', '-' . absint($width / 2) . 'px', '.twentytwenty-after-label:before');
		}
		$this->_renderCSSRule('width', $width.'px' , '.twentytwenty-after-label:before');

		// Overlay Labels AFTER Background
		$overlay_labels_background_color = $query->getColorWithoutComparationDefault('after overlay-labels-background-color', 'rgba(255, 255, 255, 0.2)');
		if( empty( $overlay_labels_background_color ) ){
			$overlay_labels_background_color = 'rgba(0,0,0,0)';
		}
		if( 'rgba(255, 255, 255, 0.2)' != $overlay_labels_background_color ){
			$this->_renderCSSRule('background-color', $overlay_labels_background_color, '.twentytwenty-after-label:before');
		}

		// Overlay Labels AFTER Color
		$overlay_labels_color = $query->getColorWithoutComparationDefault('after overlay-labels-color', '#ffffff');
		if( '#ffffff' != $overlay_labels_color ){
			$this->_renderCSSRule('color', $overlay_labels_color, '.twentytwenty-after-label:before');
		}

		if( empty( $text_before ) and empty( $text_after ) ){
			$this->_renderCSSRule('display', 'none' , '.twentytwenty-overlay');
		}

		// Overlay Background
		$overlay_background_color = $query->getColorWithoutComparationDefault('overlay-background-color', 'rgba(0, 0, 0, 0.5)');
		if( empty( $overlay_background_color ) ){
			$overlay_background_color = 'rgba(0,0,0,0)';
		}
		if( 'rgba(0, 0, 0, 0.5)' != $overlay_background_color ){
			$this->_renderCSSRule('background-color', $overlay_background_color, '.twentytwenty-overlay:hover');
		}

		// Arrows colors
		$circle_arrows_color = $query->getColorWithoutComparationDefault('circle-arrows-color','#ffffff');
		if( empty( $circle_arrows_color ) ){
			$circle_arrows_color = 'rgba(0,0,0,0)';
		}
		$this->_renderCSSRule('border-right-color'  , $circle_arrows_color, '.twentytwenty-left-arrow');
		$this->_renderCSSRule('border-left-color'   , $circle_arrows_color, '.twentytwenty-right-arrow');
		$this->_renderCSSRule('border-bottom-color' , $circle_arrows_color, '.twentytwenty-up-arrow');
		$this->_renderCSSRule('border-top-color'    , $circle_arrows_color, '.twentytwenty-down-arrow');

		// Handle Circle Background Color
		$circle_background_color = $query->getColorWithoutComparationDefault( 'circle-background-color', '' );
		$this->_renderCSSRule('background-color', $circle_background_color, '.twentytwenty-handle');

		// Handle Circle Border Color
		$circle_border_color = $query->getColorWithoutComparationDefault( 'circle-border-color', '#ffffff');
		if(empty($circle_border_color)){
			$circle_border_color = 'rgba(0,0,0,0)';
		}
		$this->_renderCSSRule('border-color', $circle_border_color, '.twentytwenty-handle');

		// Handle Circle Shadow
		$circle_shadow_color = $query->getColorWithoutComparationDefault( 'circle-shadow-color', 'rgba(51, 51, 51, 0.5)' );
		if( empty( $circle_shadow_color ) ){
			$circle_shadow_color = 'rgba(0,0,0,0)';
		}
		if( 'rgba(51, 51, 51, 0.5)' != $circle_shadow_color ){
			// rgba(51, 51, 51, 0.5) is already in CSS
			$shadow = '0 0 12px '.$circle_shadow_color;
			$this->_renderCSSRule('-webkit-box-shadow', $shadow, '.twentytwenty-handle');
			$this->_renderCSSRule('-moz-box-shadow', $shadow, '.twentytwenty-handle');
			$this->_renderCSSRule('box-shadow', $shadow, '.twentytwenty-handle');
		}

		// Handle Colors
		$lines_color = $query->getColorWithoutComparationDefault( 'lines-color', '#ffffff' );
		$lines_shadow_color = $query->getColorWithoutComparationDefault( 'lines-shadow-color', 'rgba(51, 51, 51, 0.5)' );

		if( ( '#ffffff' != $lines_color ) or ( 'rgba(51, 51, 51, 0.5)' != $lines_shadow_color ) ){
			if( empty( $lines_color ) ){
				$lines_color = 'rgba(0,0,0,0)';
			}

			if( empty( $lines_shadow_color ) ){
				$lines_shadow_color = 'rgba(0,0,0,0)';
			}

			$this->_renderCSSRule('background-color', $lines_color, '.twentytwenty-handle:before');
			$this->_renderCSSRule('background-color', $lines_color, '.twentytwenty-handle:after');

			if( 'horizontal' == $orientation ) {

				$shadow = '0 3px 0 ' . $lines_color . ', 0 0 12px ' . $lines_shadow_color;
				$this->_renderCSSRule('-webkit-box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:before');
				$this->_renderCSSRule('-moz-box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:before');
				$this->_renderCSSRule('box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:before');


				$shadow = '0 -3px 0 ' . $lines_color . ', 0 0 12px ' . $lines_shadow_color;
				$this->_renderCSSRule('-webkit-box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:after');
				$this->_renderCSSRule('-moz-box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:after');
				$this->_renderCSSRule('box-shadow', $shadow, '.ark-twentytwenty-horizontal .twentytwenty-handle:after');

			}

			if( 'vertical' == $orientation ) {

				$shadow = '3px 0 0 ' . $lines_color . ', 0 0 12px ' . $lines_shadow_color;
				$this->_renderCSSRule('-webkit-box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:before');
				$this->_renderCSSRule('-moz-box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:before');
				$this->_renderCSSRule('box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:before');


				$shadow = '-3px 0 0 ' . $lines_color . ', 0 0 12px ' . $lines_shadow_color;
				$this->_renderCSSRule('-webkit-box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:after');
				$this->_renderCSSRule('-moz-box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:after');
				$this->_renderCSSRule('box-shadow', $shadow, '.ark-twentytwenty-vertical .twentytwenty-handle:after');

			}

		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				blocks.render('image', query.get('before'));
				blocks.render('image', query.get('after'));

			}
		</script data-type="ffscript">
	<?php
	}


}